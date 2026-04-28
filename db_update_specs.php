<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/db/database.php';

try {
    $db = getDB();
    echo "Conexión establecida.<br>";

    $cols = ['specs_en', 'specs_pt'];

    foreach ($cols as $col) {
        try {
            $db->exec("ALTER TABLE productos ADD COLUMN $col TEXT DEFAULT '[]'");
            echo "Columna $col agregada.<br>";
        } catch (Exception $e) {
            echo "Columna $col ya existe o error sutil.<br>";
        }
    }
    echo "Proceso finalizado.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
