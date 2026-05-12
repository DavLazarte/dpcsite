<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../db/database.php';

$db = getDB();
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? 0;

if ($action === 'delete' && $id) {
    $stmt = $db->prepare('DELETE FROM mensajes WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: mensajes.php');
    exit;
}

if ($action === 'toggle' && $id) {
    $stmt = $db->prepare('UPDATE mensajes SET leido = NOT leido WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: mensajes.php');
    exit;
}

$mensajes = $db->query('SELECT * FROM mensajes ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes - DPC Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: "#1A4F9C", accent: "#D42B2B", "dark-navy": "#0B1A2E" },
                    fontFamily: { display: ["Public Sans", "sans-serif"] },
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-display text-slate-800 h-screen flex overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-72 bg-dark-navy flex flex-col h-full shrink-0 shadow-2xl relative z-20">
        <div class="h-20 flex items-center px-8 border-b border-white/5">
            <img src="../assets/img/logo.png" alt="DPC Logo" class="h-8">
        </div>
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="productos.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                <span class="material-symbols-outlined">inventory_2</span> Productos
            </a>
            <a href="noticias.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                <span class="material-symbols-outlined">article</span> Noticias
            </a>
            <a href="mensajes.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold bg-primary/20 text-primary">
                <span class="material-symbols-outlined">mail</span> Mensajes
            </a>
        </nav>
        <div class="p-4">
            <a href="logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-accent hover:bg-accent/10 transition-colors">
                <span class="material-symbols-outlined">logout</span> Cerrar Sesión
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden bg-slate-50 relative">
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-10 shrink-0">
            <div>
                <h1 class="text-2xl font-black text-dark-navy">Bandeja de Entrada</h1>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mt-1">Consultas y Formularios de Contacto</p>
            </div>
        </header>

        <div class="flex-1 overflow-auto p-10">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-xs uppercase tracking-widest text-slate-400 font-bold">
                            <th class="px-6 py-4 font-bold">Estado</th>
                            <th class="px-6 py-4 font-bold">Fecha</th>
                            <th class="px-6 py-4 font-bold">Contacto</th>
                            <th class="px-6 py-4 font-bold">Producto</th>
                            <th class="px-6 py-4 font-bold">Mensaje</th>
                            <th class="px-6 py-4 font-bold text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if(empty($mensajes)): ?>
                        <tr><td colspan="6" class="px-6 py-8 text-center text-slate-500">No hay mensajes.</td></tr>
                        <?php endif; ?>
                        <?php foreach($mensajes as $m): ?>
                        <tr class="hover:bg-slate-50 transition-colors <?= $m['leido'] ? 'opacity-60' : '' ?>">
                            <td class="px-6 py-4">
                                <?php if($m['leido']): ?>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full"><span class="material-symbols-outlined text-[14px]">drafts</span> Leído</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-primary bg-primary/10 px-2.5 py-1 rounded-full"><span class="material-symbols-outlined text-[14px]">mail</span> Nuevo</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-500 whitespace-nowrap">
                                <?= date('d/m/Y H:i', strtotime($m['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-dark-navy text-sm"><?= htmlspecialchars($m['nombre']) ?></div>
                                <div class="text-xs text-slate-500 mt-0.5"><?= htmlspecialchars($m['email']) ?></div>
                                <?php if($m['telefono']): ?><div class="text-xs text-slate-500 mt-0.5"><span class="material-symbols-outlined text-[12px] align-middle">call</span> <?= htmlspecialchars($m['telefono']) ?></div><?php endif; ?>
                                <?php if($m['institucion']): ?><div class="text-xs text-slate-500 mt-0.5"><span class="material-symbols-outlined text-[12px] align-middle">business</span> <?= htmlspecialchars($m['institucion']) ?></div><?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                <?= htmlspecialchars($m['producto'] ?: 'N/A') ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate" title="<?= htmlspecialchars($m['mensaje']) ?>">
                                <?= htmlspecialchars($m['mensaje']) ?>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="?action=toggle&id=<?= $m['id'] ?>" class="p-2 bg-slate-100 hover:bg-slate-200 rounded-lg text-slate-600 transition-colors inline-block" title="Marcar como <?= $m['leido'] ? 'No Leído' : 'Leído' ?>">
                                    <span class="material-symbols-outlined text-sm"><?= $m['leido'] ? 'mark_email_unread' : 'mark_email_read' ?></span>
                                </a>
                                <a href="?action=delete&id=<?= $m['id'] ?>" onclick="return confirm('¿Eliminar mensaje?')" class="p-2 bg-red-50 hover:bg-red-100 rounded-lg text-red-600 transition-colors inline-block ml-1">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
