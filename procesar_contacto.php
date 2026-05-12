<?php
require_once __DIR__ . '/db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre      = trim($_POST['nombre'] ?? '');
    $institucion = trim($_POST['institucion'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $telefono    = trim($_POST['telefono'] ?? '');
    $producto    = trim($_POST['producto'] ?? '');
    $mensaje     = trim($_POST['mensaje'] ?? '');
    
    $redirect = $_POST['redirect'] ?? 'contacto.html';

    if ($nombre && $email) {
        $db = getDB();
        $stmt = $db->prepare('INSERT INTO mensajes (nombre, institucion, email, telefono, producto, mensaje) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$nombre, $institucion, $email, $telefono, $producto, $mensaje]);
        
        $redirUrl = $redirect . (strpos($redirect, '?') !== false ? '&' : '?') . 'msg=ok';
        header("Location: $redirUrl#form");
        exit;
    } else {
        $redirUrl = $redirect . (strpos($redirect, '?') !== false ? '&' : '?') . 'msg=error';
        header("Location: $redirUrl#form");
        exit;
    }
}
header('Location: index.php');
exit;
