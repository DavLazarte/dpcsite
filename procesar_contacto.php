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
        
        // Enviar email
        $to = 'e.galvan@pharmacenter.com.ar';
        $subject = 'Nueva consulta web - DPC Hospitalaria';
        $body = "Has recibido una nueva consulta desde el sitio web:\n\n"
              . "Nombre: $nombre\n"
              . "Institución: $institucion\n"
              . "Email: $email\n"
              . "Teléfono: $telefono\n"
              . "Producto: $producto\n\n"
              . "Mensaje:\n$mensaje\n";
        
        $headers = "From: noreply@pharmacenter.com.ar\r\n"
                 . "Reply-To: $email\r\n"
                 . "Content-Type: text/plain; charset=UTF-8";
                 
        @mail($to, $subject, $body, $headers);

        
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
