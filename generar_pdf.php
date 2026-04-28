<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/db/database.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// 1. Obtener ID y datos del producto
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'es';

if ($id <= 0) die("ID de producto no válido.");

$db = getDB();
$stmt = $db->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch();

if (!$producto) die("Producto no encontrado.");

// Función para convertir imagen a Base64 (evita errores de ruta en PDF)
function imgToBase64($path) {
    if (!file_exists($path)) return '';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}

// Preparar imágenes
$logoBase64 = imgToBase64(__DIR__ . '/assets/img/logo.png');
$prodBase64 = imgToBase64(__DIR__ . '/' . $producto['imagen']);

// Traducciones
$nombre = $producto['nombre'];
$specs = json_decode($producto['specs'], true);
$desc = $producto['descripcion'];

if ($lang == 'en') {
    $nombre = $producto['nombre_en'] ?: $nombre;
    $specs = json_decode($producto['specs_en'], true) ?: $specs;
    $desc = $producto['descripcion_en'] ?: $desc;
} elseif ($lang == 'pt') {
    $nombre = $producto['nombre_pt'] ?: $nombre;
    $specs = json_decode($producto['specs_pt'], true) ?: $specs;
    $desc = $producto['descripcion_pt'] ?: $desc;
}

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Helvetica');
$dompdf = new Dompdf($options);

$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0; }
        body {
            font-family: "Helvetica", Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }
        .header {
            background-color: #0b1a2e;
            height: 110px;
            width: 100%;
            position: relative;
            color: white;
        }
        .header-content {
            padding: 30px 50px;
        }
        .logo {
            height: 50px;
            float: left;
        }
        .header-info {
            float: right;
            text-align: right;
        }
        .header-info h1 {
            margin: 0;
            font-size: 14px;
            letter-spacing: 2px;
            font-weight: 300;
            text-transform: uppercase;
            color: #94a3b8;
        }
        .header-info p {
            margin: 5px 0 0;
            font-size: 20px;
            font-weight: bold;
            color: #ffffff;
        }
        .main-container {
            padding: 50px;
            min-height: 700px;
        }
        .product-title {
            color: #1a4f9c;
            font-size: 38px;
            font-weight: 900;
            margin: 0 0 10px 0;
            text-transform: uppercase;
            border-bottom: 4px solid #1a4f9c;
            display: inline-block;
            padding-bottom: 5px;
        }
        .product-desc {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 40px;
            max-width: 80%;
        }
        .grid {
            width: 100%;
        }
        .col-img {
            width: 45%;
            vertical-align: top;
            padding-right: 30px;
        }
        .col-info {
            width: 55%;
            vertical-align: top;
        }
        .img-container {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 24px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        .img-container img {
            max-width: 100%;
            height: auto;
        }
        .specs-title {
            font-size: 16px;
            font-weight: 900;
            text-transform: uppercase;
            color: #0b1a2e;
            margin-bottom: 20px;
            letter-spacing: 1px;
            background: #f1f5f9;
            padding: 8px 15px;
            border-left: 5px solid #1a4f9c;
        }
        .spec-item {
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
        }
        .spec-label {
            font-weight: bold;
            color: #0b1a2e;
            width: 140px;
            display: inline-block;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: #ffffff;
            padding: 30px 50px 40px;
            border-top: 2px solid #0b1a2e;
        }
        .warning-banner {
            border: 1px dashed #ef4444;
            color: #ef4444;
            text-align: center;
            padding: 12px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 25px;
            border-radius: 8px;
        }
        .footer-grid {
            width: 100%;
            font-size: 10px;
        }
        .footer-grid td {
            vertical-align: top;
        }
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border: 1.5px solid #1a4f9c;
            color: #1a4f9c;
            font-weight: bold;
            border-radius: 6px;
            margin-right: 8px;
            font-size: 11px;
        }
        .contact-col {
            color: #64748b;
            line-height: 1.6;
        }
        .contact-col strong {
            color: #0b1a2e;
        }
        .lote-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
        }
        .lote-table td {
            padding: 8px 15px;
            border: 1px solid #e2e8f0;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <img src="' . $logoBase64 . '" class="logo">
            <div class="header-info">
                <h1>Ficha Técnica de Producto</h1>
                <p>DPC Hospitalaria</p>
            </div>
        </div>
    </div>

    <div class="main-container">
        <h2 class="product-title">' . $nombre . '</h2>
        <p class="product-desc">' . $desc . '</p>

        <table class="grid">
            <tr>
                <td class="col-img">
                    <div class="img-container">
                        <img src="' . $prodBase64 . '" alt="">
                    </div>
                </td>
                <td class="col-info">
                    <div class="specs-title">Especificaciones</div>
                    <div class="specs-box">';
                    foreach ($specs as $spec) {
                        $parts = explode(':', $spec, 2);
                        if (count($parts) == 2) {
                            $html .= '<div class="spec-item"><span class="spec-label">' . trim($parts[0]) . ':</span> ' . trim($parts[1]) . '</div>';
                        } else {
                            $html .= '<div class="spec-item">' . $spec . '</div>';
                        }
                    }
$html .= '          </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <div class="warning-banner">
            NO UTILIZAR SI EL ENVASE ESTÁ DAÑADO - MATERIAL PARA USAR POR ÚNICA VEZ
        </div>
        
        <table class="footer-grid">
            <tr>
                <td width="35%">
                    <div style="margin-bottom: 12px;">
                        <span class="badge">ESTÉRIL</span>
                        <span class="badge">ETO</span>
                    </div>
                    <p style="margin: 0; color: #475569;">
                        Producto Biomédico autorizado por <strong>ANMAT</strong><br>
                        N° PM 2521-1 / 2521-2<br>
                        <strong>Industria Argentina</strong>
                    </p>
                </td>
                <td width="35%" class="contact-col">
                    <strong>DPC - Planta Industrial</strong><br>
                    Colombia 2589, S.M. de Tucumán<br>
                    Tucumán, Argentina<br>
                    Tel: (0381) 4346555 / 6669<br>
                    ventas@dpc.com.ar | www.dpc.com.ar
                </td>
                <td width="30%">
                    <table class="lote-table">
                        <tr><td>LOTE: ________________</td></tr>
                        <tr><td>VENCE: _______________</td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$filename = "Ficha-DPC-" . str_replace(' ', '-', $nombre) . ".pdf";
$dompdf->stream($filename, ["Attachment" => true]);
