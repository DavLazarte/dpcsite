<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/db/database.php';

try {
    $db = getDB();
    echo "Conexión establecida.\n";

    try {
        $db->exec("ALTER TABLE productos ADD COLUMN imagenes TEXT DEFAULT '[]'");
        echo "Columna 'imagenes' agregada con éxito.\n";
    } catch (Exception $e) {
        echo "La columna 'imagenes' ya existe o hubo un error: " . $e->getMessage() . "\n";
    }
    
    echo "Proceso finalizado.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
