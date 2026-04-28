<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../db/database.php';
requireLogin();

$db = getDB();

$uploadDir = __DIR__ . '/../assets/img/dynamic/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$CATEGORIAS = [
    'proteccion'  => 'Protección Personal',
    'camisolines' => 'Camisolines',
    'quirurgico'  => 'Quirúrgico',
    'kits'        => 'Kits',
    'cama'        => 'Camilla y Campo',
    'otros'       => 'Otros',
];

$action  = $_GET['action'] ?? 'list';
$editId  = isset($_GET['id']) ? (int)$_GET['id'] : null;
$message = '';
$msgType = 'success';

function handleImageUpload(array $file, string $uploadDir): string|false {
    if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] === 0) return false;
    $ext   = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp','gif'];
    if (!in_array($ext, $allowed)) return false;
    $name  = uniqid('prod_', true) . '.' . $ext;
    $dest  = $uploadDir . $name;
    if (!move_uploaded_file($file['tmp_name'], $dest)) return false;
    return 'assets/img/dynamic/' . $name;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postAction = $_POST['_action'] ?? '';

    if ($postAction === 'delete') {
        $id  = (int)($_POST['id'] ?? 0);
        $row = $db->prepare('SELECT imagen FROM productos WHERE id = ?');
        $row->execute([$id]);
        $prod = $row->fetch();
        if ($prod && $prod['imagen']) {
            $imgPath = __DIR__ . '/../' . $prod['imagen'];
            if (file_exists($imgPath) && strpos($prod['imagen'], 'dynamic/') !== false) {
                unlink($imgPath);
            }
        }
        $db->prepare('DELETE FROM productos WHERE id = ?')->execute([$id]);
        $message = 'Producto eliminado correctamente.';
        $action  = 'list';
    }
    elseif ($postAction === 'toggle') {
        $id = (int)($_POST['id'] ?? 0);
        $db->prepare('UPDATE productos SET activo = CASE WHEN activo=1 THEN 0 ELSE 1 END, updated_at = CURRENT_TIMESTAMP WHERE id = ?')
           ->execute([$id]);
        $action = 'list';
    }
    elseif ($postAction === 'create' || $postAction === 'update') {
        $id        = (int)($_POST['id'] ?? 0);
        $nombre    = trim($_POST['nombre']    ?? '');
        $nombre_en = trim($_POST['nombre_en'] ?? '');
        $nombre_pt = trim($_POST['nombre_pt'] ?? '');
        
        $categoria = trim($_POST['categoria'] ?? '');
        
        $descCorta = trim($_POST['desc_corta'] ?? '');
        $descCorta_en = trim($_POST['desc_corta_en'] ?? '');
        $descCorta_pt = trim($_POST['desc_corta_pt'] ?? '');
        
        $desc      = trim($_POST['descripcion'] ?? '');
        $desc_en   = trim($_POST['descripcion_en'] ?? '');
        $desc_pt   = trim($_POST['descripcion_pt'] ?? '');
        
        $activo    = isset($_POST['activo']) ? 1 : 0;
        $orden     = (int)($_POST['orden'] ?? 0);

        // Specs ES
        $specsRaw  = explode("\n", $_POST['specs'] ?? '');
        $specsJson = json_encode(array_values(array_filter(array_map('trim', $specsRaw))), JSON_UNESCAPED_UNICODE);
        
        // Specs EN
        $specsRaw_en = explode("\n", $_POST['specs_en'] ?? '');
        $specsJson_en = json_encode(array_values(array_filter(array_map('trim', $specsRaw_en))), JSON_UNESCAPED_UNICODE);
        
        // Specs PT
        $specsRaw_pt = explode("\n", $_POST['specs_pt'] ?? '');
        $specsJson_pt = json_encode(array_values(array_filter(array_map('trim', $specsRaw_pt))), JSON_UNESCAPED_UNICODE);

        if ($postAction === 'create') {
            $imagen = '';
            if (!empty($_FILES['imagen']['name'])) {
                $uploaded = handleImageUpload($_FILES['imagen'], $uploadDir);
                if ($uploaded) $imagen = $uploaded;
            }

            if ($nombre && $categoria) {
                $stmt = $db->prepare('INSERT INTO productos (nombre, nombre_en, nombre_pt, categoria, desc_corta, desc_corta_en, desc_corta_pt, descripcion, descripcion_en, descripcion_pt, imagen, specs, specs_en, specs_pt, activo, orden) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
                $stmt->execute([$nombre, $nombre_en, $nombre_pt, $categoria, $descCorta, $descCorta_en, $descCorta_pt, $desc, $desc_en, $desc_pt, $imagen, $specsJson, $specsJson_en, $specsJson_pt, $activo, $orden]);
                $message = "Producto \"$nombre\" creado correctamente.";
            } else {
                $message = 'El nombre y la categoría son obligatorios.';
                $msgType = 'error';
            }
        } else {
            $cur = $db->prepare('SELECT imagen FROM productos WHERE id = ?');
            $cur->execute([$id]);
            $curData = $cur->fetch();
            $imagen  = $curData['imagen'] ?? '';

            if (!empty($_FILES['imagen']['name'])) {
                $uploaded = handleImageUpload($_FILES['imagen'], $uploadDir);
                if ($uploaded) {
                    if ($imagen && strpos($imagen, 'dynamic/') !== false) {
                        $oldPath = __DIR__ . '/../' . $imagen;
                        if (file_exists($oldPath)) unlink($oldPath);
                    }
                    $imagen = $uploaded;
                }
            }

            if ($nombre && $categoria) {
                $stmt = $db->prepare('UPDATE productos SET nombre=?, nombre_en=?, nombre_pt=?, categoria=?, desc_corta=?, desc_corta_en=?, desc_corta_pt=?, descripcion=?, descripcion_en=?, descripcion_pt=?, imagen=?, specs=?, specs_en=?, specs_pt=?, activo=?, orden=?, updated_at=CURRENT_TIMESTAMP WHERE id=?');
                $stmt->execute([$nombre, $nombre_en, $nombre_pt, $categoria, $descCorta, $descCorta_en, $descCorta_pt, $desc, $desc_en, $desc_pt, $imagen, $specsJson, $specsJson_en, $specsJson_pt, $activo, $orden, $id]);
                $message = "Producto \"$nombre\" actualizado correctamente.";
            } else {
                $message = 'El nombre y la categoría son obligatorios.';
                $msgType = 'error';
            }
        }
        $action = 'list';
    }
}

$products = [];
$editProd = null;

if ($action === 'list') {
    $products = $db->query('SELECT * FROM productos ORDER BY categoria, orden ASC, nombre ASC')->fetchAll();
}

if ($action === 'edit' && $editId) {
    $stmt = $db->prepare('SELECT * FROM productos WHERE id = ?');
    $stmt->execute([$editId]);
    $editProd = $stmt->fetch();
    if (!$editProd) { $action = 'list'; }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DPC Admin — Productos</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@400,0" rel="stylesheet">
<script>
  tailwind.config = {
    theme: { extend: {
      colors: {
        primary: '#1A4F9C',
        accent: '#D42B2B',
        'dark-navy': '#0B1A2E',
        'deep-blue': '#112240',
      },
      fontFamily: { sans: ['Public Sans','sans-serif'] }
    }}
  };
</script>
<style>
  .ms { font-family: 'Material Symbols Outlined'; font-size: 20px; line-height: 1; }
</style>
</head>
<body class="bg-slate-100 font-sans min-h-screen">

<div class="flex min-h-screen">
  <aside class="w-64 bg-dark-navy text-white flex flex-col shrink-0">
    <div class="px-6 py-6 border-b border-white/10">
      <img src="../assets/img/logo.png" alt="DPC" class="h-10 mb-3">
      <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Panel Administrativo</p>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-1">
      <a href="productos.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold bg-primary/20 text-primary">
        <span class="ms">inventory_2</span> Productos
      </a>
      <a href="../productos.php" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
        <span class="ms">open_in_new</span> Ver sitio
      </a>
    </nav>
    <div class="px-4 pb-6">
      <a href="logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-500 hover:bg-white/5 hover:text-red-400 transition-colors">
        <span class="ms">logout</span> Cerrar sesión
      </a>
    </div>
  </aside>

  <main class="flex-1 p-8">
    <?php if ($message): ?>
      <div class="mb-6 flex items-center gap-3 px-5 py-4 rounded-xl text-sm font-medium <?= $msgType === 'error' ? 'bg-red-50 border border-red-200 text-red-700' : 'bg-green-50 border border-green-200 text-green-700' ?>">
        <span class="ms"><?= $msgType === 'error' ? 'error' : 'check_circle' ?></span>
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <?php if ($action === 'list'): ?>
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-2xl font-black text-dark-navy">Productos</h1>
        <p class="text-slate-500 text-sm"><?= count($products) ?> producto<?= count($products) !== 1 ? 's' : '' ?> en total</p>
      </div>
      <a href="?action=new" class="flex items-center gap-2 bg-primary hover:bg-blue-700 text-white px-5 py-3 rounded-xl text-sm font-bold tracking-wide transition-colors shadow-lg shadow-primary/20">
        <span class="ms" style="font-size:18px">add</span> Nuevo producto
      </a>
    </div>

    <?php if (empty($products)): ?>
      <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-16 text-center">
        <span class="ms text-slate-300" style="font-size:64px">inventory_2</span>
        <p class="text-slate-400 font-medium mt-4">Todavía no hay productos cargados.</p>
        <a href="?action=new" class="inline-flex items-center gap-2 mt-4 bg-primary text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-700 transition-colors">
          <span class="ms" style="font-size:16px">add</span> Agregar el primero
        </a>
      </div>
    <?php else: ?>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b border-slate-100">
            <th class="text-left px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Imagen</th>
            <th class="text-left px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Nombre</th>
            <th class="text-left px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Categoría</th>
            <th class="text-left px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Estado</th>
            <th class="text-right px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          <?php foreach ($products as $p): ?>
          <tr class="hover:bg-slate-50 transition-colors group">
            <td class="px-6 py-4">
              <img src="<?= $p['imagen'] ? '../'.$p['imagen'] : '../assets/img/iconos/camisolin.png' ?>" alt="" class="w-14 h-14 object-contain rounded-lg bg-slate-100 p-1">
            </td>
            <td class="px-6 py-4">
              <p class="font-bold text-dark-navy"><?= htmlspecialchars($p['nombre']) ?></p>
              <p class="text-slate-400 text-xs mt-0.5 line-clamp-1"><?= htmlspecialchars($p['desc_corta']) ?></p>
            </td>
            <td class="px-6 py-4">
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary">
                <?= $CATEGORIAS[$p['categoria']] ?? $p['categoria'] ?>
              </span>
            </td>
            <td class="px-6 py-4">
              <form method="POST">
                <input type="hidden" name="_action" value="toggle">
                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold transition-colors <?= $p['activo'] ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' ?>">
                  <span class="ms" style="font-size:14px"><?= $p['activo'] ? 'visibility' : 'visibility_off' ?></span>
                  <?= $p['activo'] ? 'Publicado' : 'Oculto' ?>
                </button>
              </form>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center justify-end gap-2">
                <a href="?action=edit&id=<?= $p['id'] ?>" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 hover:bg-primary hover:text-white transition-colors">
                  <span class="ms" style="font-size:14px">edit</span> Editar
                </a>
                <form method="POST" onsubmit="return confirm('¿Eliminar producto?')">
                  <input type="hidden" name="_action" value="delete">
                  <input type="hidden" name="id" value="<?= $p['id'] ?>">
                  <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 hover:bg-red-500 hover:text-white transition-colors">
                    <span class="ms" style="font-size:14px">delete</span> Eliminar
                  </button>
                </form>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>

    <?php elseif ($action === 'new' || $action === 'edit'): ?>
    <?php
      $isEdit  = ($action === 'edit' && $editProd);
      $p       = $editProd ?? [];
      
      $specsStr    = implode("\n", json_decode($p['specs'] ?? '[]', true));
      $specsStr_en = implode("\n", json_decode($p['specs_en'] ?? '[]', true));
      $specsStr_pt = implode("\n", json_decode($p['specs_pt'] ?? '[]', true));
    ?>

    <div class="flex items-center gap-4 mb-8">
      <a href="productos.php" class="w-10 h-10 rounded-full bg-white shadow-sm border border-slate-200 flex items-center justify-center text-slate-500 hover:text-primary hover:border-primary transition-colors">
        <span class="ms">arrow_back</span>
      </a>
      <div>
        <h1 class="text-2xl font-black text-dark-navy"><?= $isEdit ? 'Editar producto' : 'Nuevo producto' ?></h1>
        <p class="text-slate-500 text-sm"><?= $isEdit ? htmlspecialchars($p['nombre']) : 'Cargá los datos del producto en varios idiomas' ?></p>
      </div>
    </div>

    <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <input type="hidden" name="_action" value="<?= $isEdit ? 'update' : 'create' ?>">
      <?php if ($isEdit): ?><input type="hidden" name="id" value="<?= $p['id'] ?>"><?php endif; ?>

      <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
          <div class="flex border-b border-slate-100">
            <button type="button" onclick="switchLang('es')" class="lang-tab flex-1 py-4 text-xs font-bold uppercase tracking-widest border-b-2 transition-all border-primary text-primary" id="tab-es">Español (ES)</button>
            <button type="button" onclick="switchLang('en')" class="lang-tab flex-1 py-4 text-xs font-bold uppercase tracking-widest border-b-2 transition-all border-transparent text-slate-400" id="tab-en">Inglés (EN)</button>
            <button type="button" onclick="switchLang('pt')" class="lang-tab flex-1 py-4 text-xs font-bold uppercase tracking-widest border-b-2 transition-all border-transparent text-slate-400" id="tab-pt">Portugués (PT)</button>
          </div>
          
          <div class="p-6">
            <!-- Español -->
            <div id="lang-es" class="lang-content space-y-6">
              <div class="space-y-4">
                <div>
                  <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Nombre (ES) <span class="text-accent">*</span></label>
                  <input type="text" name="nombre" value="<?= htmlspecialchars($p['nombre'] ?? '') ?>" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none">
                </div>
                <div>
                  <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Desc. Corta (ES)</label>
                  <input type="text" name="desc_corta" value="<?= htmlspecialchars($p['desc_corta'] ?? '') ?>" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none">
                </div>
                <div>
                  <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Descripción Larga (ES)</label>
                  <textarea name="descripcion" rows="4" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none"><?= htmlspecialchars($p['descripcion'] ?? '') ?></textarea>
                </div>
              </div>
              <div class="pt-4 border-t border-slate-50">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Especificaciones Técnicas (ES)</label>
                <textarea name="specs" rows="6" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono focus:ring-2 focus:ring-primary/20 outline-none" placeholder="Una por línea..."><?= htmlspecialchars($specsStr) ?></textarea>
              </div>
            </div>
            
            <!-- Inglés -->
            <div id="lang-en" class="lang-content space-y-6 hidden">
              <div class="space-y-4">
                <div>
                  <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Nombre (EN)</label>
                  <input type="text" name="nombre_en" value="<?= htmlspecialchars($p['nombre_en'] ?? '') ?>" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none">
                </div>
                <div>
                  <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Desc. Corta (EN)</label>
                  <input type="text" name="desc_corta_en" value="<?= htmlspecialchars($p['desc_corta_en'] ?? '') ?>" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none">
                </div>
                <div>
                  <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Descripción Larga (EN)</label>
                  <textarea name="descripcion_en" rows="4" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none"><?= htmlspecialchars($p['descripcion_en'] ?? '') ?></textarea>
                </div>
              </div>
              <div class="pt-4 border-t border-slate-50">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Technical Specs (EN)</label>
                <textarea name="specs_en" rows="6" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono focus:ring-2 focus:ring-primary/20 outline-none" placeholder="One per line..."><?= htmlspecialchars($specsStr_en) ?></textarea>
              </div>
            </div>
            
            <!-- Portugués -->
            <div id="lang-pt" class="lang-content space-y-6 hidden">
              <div class="space-y-4">
                <div>
                  <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Nombre (PT)</label>
                  <input type="text" name="nombre_pt" value="<?= htmlspecialchars($p['nombre_pt'] ?? '') ?>" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none">
                </div>
                <div>
                  <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Desc. Corta (PT)</label>
                  <input type="text" name="desc_corta_pt" value="<?= htmlspecialchars($p['desc_corta_pt'] ?? '') ?>" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none">
                </div>
                <div>
                  <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Descripción Larga (PT)</label>
                  <textarea name="descripcion_pt" rows="4" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none"><?= htmlspecialchars($p['descripcion_pt'] ?? '') ?></textarea>
                </div>
              </div>
              <div class="pt-4 border-t border-slate-50">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Especificações Técnicas (PT)</label>
                <textarea name="specs_pt" rows="6" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono focus:ring-2 focus:ring-primary/20 outline-none" placeholder="Uma por linha..."><?= htmlspecialchars($specsStr_pt) ?></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
          <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-5">Categoría <span class="text-accent">*</span></h3>
          <select name="categoria" required class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none bg-white">
            <option value="">Seleccioná...</option>
            <?php foreach ($CATEGORIAS as $val => $label): ?>
              <option value="<?= $val ?>" <?= ($p['categoria'] ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
          <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-5">Imagen</h3>
          <?php if ($isEdit && !empty($p['imagen'])): ?>
            <img src="../<?= htmlspecialchars($p['imagen']) ?>" alt="" class="max-h-32 mx-auto mb-4 object-contain rounded-lg bg-slate-50 p-2">
          <?php endif; ?>
          <input type="file" name="imagen" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-4">
          <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="activo" value="1" <?= ($p['activo'] ?? 1) ? 'checked' : '' ?> class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary">
            <span class="text-sm font-semibold text-slate-700">Publicado</span>
          </label>
          <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Orden</label>
            <input type="number" name="orden" value="<?= (int)($p['orden'] ?? 0) ?>" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none">
          </div>
        </div>

        <div class="flex flex-col gap-3">
          <button type="submit" class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl text-sm tracking-wide transition-colors shadow-lg shadow-primary/20">
            <?= $isEdit ? 'Guardar cambios' : 'Crear producto' ?>
          </button>
          <a href="productos.php" class="w-full text-center border border-slate-200 text-slate-500 hover:text-slate-700 font-bold py-3 rounded-xl text-sm transition-colors">Cancelar</a>
        </div>
      </div>
    </form>
    <?php endif; ?>
  </main>
</div>

<script>
function switchLang(lang) {
  document.querySelectorAll('.lang-tab').forEach(t => {
    t.classList.remove('border-primary', 'text-primary');
    t.classList.add('border-transparent', 'text-slate-400');
  });
  document.getElementById('tab-' + lang).classList.remove('border-transparent', 'text-slate-400');
  document.getElementById('tab-' + lang).classList.add('border-primary', 'text-primary');
  
  document.querySelectorAll('.lang-content').forEach(c => c.classList.add('hidden'));
  document.getElementById('lang-' + lang).classList.remove('hidden');
}
</script>
</body>
</html>