<?php
require_once __DIR__ . '/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['usuario'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    if ($user === ADMIN_USER && $pass === ADMIN_PASS) {
        $_SESSION['dpc_admin'] = true;
        header('Location: productos.php');
        exit;
    }
    $error = 'Usuario o contraseña incorrectos.';
}

if (isLoggedIn()) {
    header('Location: productos.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DPC Admin — Ingresar</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600;700;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@400,0" rel="stylesheet">
<script>
  tailwind.config = {
    theme: { extend: {
      colors: { primary: '#1A4F9C', 'dark-navy': '#0B1A2E' },
      fontFamily: { sans: ['Public Sans', 'sans-serif'] }
    }}
  };
</script>
</head>
<body class="min-h-screen bg-dark-navy flex items-center justify-center font-sans p-4">
  <div class="w-full max-w-sm">

    <div class="text-center mb-8">
      <img src="../assets/img/logo.png" alt="DPC" class="h-16 mx-auto mb-4" onerror="this.style.display='none'">
      <h1 class="text-2xl font-black text-white tracking-tight">Panel Administrativo</h1>
      <p class="text-slate-400 text-sm mt-1">Ingresá para gestionar el contenido</p>
    </div>

    <div class="bg-white/5 border border-white/10 rounded-2xl p-8 backdrop-blur-sm">
      <?php if ($error): ?>
        <div class="mb-4 flex items-center gap-2 bg-red-500/10 border border-red-500/20 text-red-400 text-sm rounded-xl px-4 py-3">
          <span class="material-symbols-outlined text-base">error</span>
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" class="space-y-4">
        <div>
          <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Usuario</label>
          <input type="text" name="usuario" required autocomplete="username"
            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-primary transition-colors placeholder-slate-600"
            placeholder="admin">
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Contraseña</label>
          <input type="password" name="password" required autocomplete="current-password"
            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-primary transition-colors placeholder-slate-600"
            placeholder="••••••••">
        </div>
        <button type="submit"
          class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-3 rounded-xl text-sm tracking-widest uppercase transition-colors mt-2 flex items-center justify-center gap-2">
          <span class="material-symbols-outlined text-base">login</span>
          Ingresar
        </button>
      </form>
    </div>

    <p class="text-center text-slate-600 text-xs mt-6">
      <a href="../productos.php" class="hover:text-slate-400 transition-colors">← Volver al sitio</a>
    </p>
  </div>
</body>
</html>