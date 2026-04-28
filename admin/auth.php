<?php
/**
 * DPC Admin — Autenticación
 * Cambiá ADMIN_PASS antes de subir al servidor.
 */

define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'dpc2026admin');   // ← CAMBIÁ ESTO

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin(): void {
    if (empty($_SESSION['dpc_admin'])) {
        header('Location: login.php');
        exit;
    }
}

function isLoggedIn(): bool {
    return !empty($_SESSION['dpc_admin']);
}