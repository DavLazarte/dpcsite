<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/db/database.php';

try {
    $db = getDB();
    echo "Conexión establecida.<br>";

    // Forzar creación de tabla si por alguna razón initDB no lo hizo
    $db->exec("
        CREATE TABLE IF NOT EXISTS noticias (
            id          INTEGER PRIMARY KEY AUTOINCREMENT,
            titulo      TEXT    NOT NULL,
            titulo_en   TEXT    DEFAULT '',
            titulo_pt   TEXT    DEFAULT '',
            copete      TEXT    DEFAULT '',
            copete_en   TEXT    DEFAULT '',
            copete_pt   TEXT    DEFAULT '',
            cuerpo      TEXT    DEFAULT '',
            cuerpo_en   TEXT    DEFAULT '',
            cuerpo_pt   TEXT    DEFAULT '',
            imagen      TEXT    DEFAULT '',
            fecha       DATE    DEFAULT CURRENT_DATE,
            activo      INTEGER DEFAULT 1,
            created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at  DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "Tabla 'noticias' verificada/creada.<br>";

    $noticias = [
        [
            'titulo' => 'Implementación de termofusión ultrasónica',
            'copete' => 'Optimizamos la estanqueidad de nuestras costuras para cirugías de alta complejidad.',
            'imagen' => 'assets/img/termofusion.jpg',
            'fecha'  => '2026-03-01'
        ],
        [
            'titulo' => 'Nueva Planta de Producción',
            'copete' => 'Avanzan las obras en nuestra nueva sede en El Manantial, Tucumán, diseñada bajo normas internacionales de bioseguridad.',
            'imagen' => 'assets/img/nuevaplanta.jpeg',
            'fecha'  => '2026-04-01'
        ],
        [
            'titulo' => 'Auditoría de Calidad Exitosa',
            'copete' => 'Hemos superado con éxito la última inspección de procesos, reafirmando nuestro compromiso con la seguridad hospitalaria.',
            'imagen' => 'assets/img/sala.jpeg',
            'fecha'  => '2026-05-01'
        ]
    ];

    $check = $db->query("SELECT COUNT(*) FROM noticias")->fetchColumn();
    if ($check > 0) {
        die("La tabla ya tiene datos. No se insertaron duplicados.");
    }

    foreach ($noticias as $n) {
        $stmt = $db->prepare('INSERT INTO noticias (titulo, copete, imagen, fecha) VALUES (?, ?, ?, ?)');
        $stmt->execute([$n['titulo'], $n['copete'], $n['imagen'], $n['fecha']]);
    }

    echo "Noticias cargadas correctamente.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
