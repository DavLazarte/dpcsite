<?php

/**
 * DPC - Conexión a base de datos SQLite
 */
function getDB(): PDO
{
    static $db = null;
    if ($db === null) {
        $dbPath = __DIR__ . '/dpc.db';
        $db = new PDO('sqlite:' . $dbPath);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->exec('PRAGMA journal_mode=WAL;');
        initDB($db);
    }
    return $db;
}

function initDB(PDO $db): void
{
    // Tabla de Productos
    $db->exec("
        CREATE TABLE IF NOT EXISTS productos (
            id          INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre      TEXT    NOT NULL,
            nombre_en   TEXT    DEFAULT '',
            nombre_pt   TEXT    DEFAULT '',
            categoria   TEXT    NOT NULL,
            desc_corta  TEXT    DEFAULT '',
            desc_corta_en TEXT  DEFAULT '',
            desc_corta_pt TEXT  DEFAULT '',
            descripcion TEXT    DEFAULT '',
            descripcion_en TEXT DEFAULT '',
            descripcion_pt TEXT DEFAULT '',
            imagen      TEXT    DEFAULT '',
            specs       TEXT    DEFAULT '[]',
            specs_en    TEXT    DEFAULT '[]',
            specs_pt    TEXT    DEFAULT '[]',
            activo      INTEGER DEFAULT 1,
            orden       INTEGER DEFAULT 0,
            created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at  DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Tabla de Noticias
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
}
