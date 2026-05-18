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

$imagenesRaw = json_decode($producto['imagenes'] ?? '[]', true);
$todasLasImagenes = [];
if ($prodBase64) $todasLasImagenes[] = $prodBase64;
if (is_array($imagenesRaw)) {
    foreach ($imagenesRaw as $img) {
        $b64 = imgToBase64(__DIR__ . '/' . $img);
        if ($b64) $todasLasImagenes[] = $b64;
    }
}

// Traducciones
$nombre = $producto['nombre'];
$specs = json_decode($producto['specs'] ?? '[]', true);
$desc = $producto['descripcion'];
$categoria = strtoupper($producto['categoria'] ?? '');

if ($lang == 'en') {
    $nombre = $producto['nombre_en'] ?: $nombre;
    $specs = json_decode($producto['specs_en'] ?? '[]', true) ?: $specs;
    $desc = $producto['descripcion_en'] ?: $desc;
} elseif ($lang == 'pt') {
    $nombre = $producto['nombre_pt'] ?: $nombre;
    $specs = json_decode($producto['specs_pt'] ?? '[]', true) ?: $specs;
    $desc = $producto['descripcion_pt'] ?: $desc;
}

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Helvetica');
$dompdf = new Dompdf($options);

// Generar grilla de imágenes
$imgHtml = '';
foreach ($todasLasImagenes as $imgB64) {
    $imgHtml .= '<img src="' . $imgB64 . '" class="prod-img">';
}

// Función para obtener un SVG convertido a base64 (para compatibilidad en Dompdf)
function getSpecIconB64($key) {
    $k = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $key));
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#64748b">';
    
    if (strpos($k, 'tela') !== false || strpos($k, 'composicion') !== false) 
        $svg .= '<path d="M19.51 3.08L3.08 19.51c.09.34.27.65.51.9l15.92-15.92c-.26-.16-.42-.52-.52-1.32zm.89 11.52l-5.8-5.8c-.39-.39-1.02-.39-1.41 0l-2.83 2.83 5.8 5.8c.39.39 1.02.39 1.41 0l2.83-2.83c.39-.39.39-1.02 0-1.41zM12 3L3 12v9l9-9V3z"/>';
    elseif (strpos($k, 'presentacion') !== false) 
        $svg .= '<path d="M20 2H4c-1.1 0-2 .9-2 2v3.01c0 .72.38 1.34.94 1.7L3 14v6c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-6l.06-5.29c.56-.36.94-.98.94-1.7V4c0-1.1-.9-2-2-2zm0 5l-2 1v12H6V8l-2-1V4h16v3zm-9 6h2v-2h-2v2z"/>';
    elseif (strpos($k, 'tama') !== false || strpos($k, 'medida') !== false) 
        $svg .= '<path d="M21 6H3c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 10H3V8h2v4h2V8h2v4h2V8h2v4h2V8h2v4h2V8h2v8z"/>';
    elseif (strpos($k, 'color') !== false) 
        $svg .= '<path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9c.83 0 1.5-.67 1.5-1.5 0-.39-.15-.74-.39-1.01-.23-.26-.38-.61-.38-.99 0-.83.67-1.5 1.5-1.5H16c2.76 0 5-2.24 5-5 0-4.42-4.03-8-9-8zm-5.5 9c-.83 0-1.5-.67-1.5-1.5S5.67 9 6.5 9 8 9.67 8 10.5 7.33 12 6.5 12zm3-4C8.67 8 8 7.33 8 6.5S8.67 5 9.5 5s1.5.67 1.5 1.5S10.33 8 9.5 8zm5 0c-.83 0-1.5-.67-1.5-1.5S13.67 5 14.5 5s1.5.67 1.5 1.5S15.33 8 14.5 8zm3 4c-.83 0-1.5-.67-1.5-1.5S16.67 9 17.5 9s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>';
    elseif (strpos($k, 'gramaje') !== false) 
        $svg .= '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 14.93V19h-2v-2.07c-3.23-.49-5.84-3.1-6.33-6.33H6.74c.46 2.45 2.37 4.36 4.82 4.82V11h-2v-2h2V7.41c-2.45.46-4.36 2.37-4.82 4.82H4.67c.49-3.23 3.1-5.84 6.33-6.33V4h2v1.9c3.23.49 5.84 3.1 6.33 6.33h-2.07c-.46-2.45-2.37-4.36-4.82-4.82V13h2v2h-2v1.93c2.45-.46 4.36-2.37 4.82-4.82h2.07c-.49 3.23-3.1 5.84-6.33 6.33z"/>';
    elseif (strpos($k, 'puño') !== false || strpos($k, 'ajuste') !== false) 
        $svg .= '<path d="M19.5 10c.83 0 1.5-.67 1.5-1.5S20.33 7 19.5 7h-1.36c-.44-2.58-2.68-4.5-5.39-4.5-2.31 0-4.3 1.45-5.09 3.5H4.5c-.83 0-1.5.67-1.5 1.5S3.67 9 4.5 9h1.06l-1.34 7.37c-.36 1.96.96 3.63 2.95 3.63h9.65c1.99 0 3.31-1.67 2.95-3.63L18.44 9h1.06zM12.75 4c1.65 0 3.01 1.25 3.19 2.87l.06.13h-6.5l.06-.13c.18-1.62 1.54-2.87 3.19-2.87z"/>';
    elseif (strpos($k, 'autorizado') !== false) 
        $svg .= '<path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>';
    elseif (strpos($k, 'contenido') !== false || strpos($k, 'conexion') !== false || strpos($k, 'desconexion') !== false) 
        $svg .= '<path d="M4 10.5c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5 1.5-.67 1.5-1.5-.67-1.5-1.5-1.5zm0-6c-.83 0-1.5.67-1.5 1.5S3.17 7.5 4 7.5 5.5 6.83 5.5 6 4.83 4.5 4 4.5zm0 12c-.83 0-1.5.68-1.5 1.5s.68 1.5 1.5 1.5 1.5-.68 1.5-1.5-.67-1.5-1.5-1.5zM7 19h14v-2H7v2zm0-6h14v-2H7v2zm0-8v2h14V5H7z"/>';
    else 
        $svg .= '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>';
    
    $svg .= '</svg>';
    return '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '" style="width:14px; height:14px; vertical-align:middle; margin-right:8px; margin-top:-2px;">';
}

// Generar tabla de specs
$specsHtml = '';
if (is_array($specs)) {
    foreach ($specs as $spec) {
        $parts = explode(':', $spec, 2);
        if (count($parts) == 2) {
            $key   = trim($parts[0]);
            $value = trim($parts[1]);

            // Normalización de llave robusta y a prueba de fallos en iconv()
            $normalizedKey = @iconv('UTF-8', 'ASCII//TRANSLIT', $key);
            if ($normalizedKey === false) {
                // Fallback seguro sin iconv
                $normalizedKey = strtolower(str_replace(
                    ['á','é','í','ó','ú','ñ','Á','É','Í','Ó','Ú','Ñ'],
                    ['a','e','i','o','u','n','a','e','i','o','u','n'],
                    $key
                ));
            } else {
                $normalizedKey = strtolower($normalizedKey);
            }

            $listKeys = ['contenido', 'conexion', 'desconexion', 'conexi', 'desconexion'];
            $isListKey = false;
            foreach ($listKeys as $lk) {
                if (strpos($normalizedKey, $lk) !== false) { $isListKey = true; break; }
            }

            if ($isListKey) {
                // Normalizar separador: convertir \/ a / y luego explode simple
                $cleanValue = str_replace('\\/', '/', $value);
                
                // Dividir por saltos de línea HTML (<br>, <br/>) o por barras inclinadas (/)
                if (preg_match('/<br\s*\/?>/i', $cleanValue)) {
                    $items = preg_split('/<br\s*\/?>/i', $cleanValue);
                } else {
                    $items = explode('/', $cleanValue);
                }

                $valHtml = '';
                $letterIndex = 0;
                foreach ($items as $item) {
                    $itemStr = trim($item);
                    if ($itemStr !== '') {
                        $letter   = chr(65 + $letterIndex);
                        // Estructura de tabla interna robusta en lugar de floats.
                        // Esto garantiza que Dompdf calcule la altura de fila correctamente y previene solapamiento.
                        $valHtml .= '<table style="width: 100%; border-collapse: collapse; border: 0; margin-bottom: 4px;">' .
                                    '<tr>' .
                                    '<td style="width: 85%; padding: 2px 0; border: 0; color: #444; font-size: 14px; vertical-align: top;">' . $itemStr . '</td>' .
                                    '<td style="width: 15%; padding: 2px 0; border: 0; text-align: right; vertical-align: top;">' .
                                    '<span class="circle-letter">' . $letter . '</span>' .
                                    '</td>' .
                                    '</tr>' .
                                    '</table>';
                        $letterIndex++;
                    }
                }
            } else {
                $valHtml = $value;
            }

            $specsHtml .= '<tr><td class="spec-key">' . getSpecIconB64($key) . ' ' . htmlspecialchars($key) . '</td><td class="spec-val">' . $valHtml . '</td></tr>';
        } else {
            $specsHtml .= '<tr><td colspan="2" style="font-weight: 900; font-size: 14px; border-bottom: 2px solid #000; padding-top: 15px; padding-bottom: 5px;">' . strtoupper(htmlspecialchars($spec)) . '</td></tr>';
        }
    }
}


// Definir título principal basado en la categoría
$titulos = [
    'proteccion'    => 'Protección Personal',
    'camisolines'   => 'Camisolines Descartables',
    'quirurgico'    => 'Equipos de Cirugía Estéril',
    'kits'          => 'Kits y Tratamientos',
    'kit_pacientes' => 'Kits y Tratamientos',
    'kit_dialisis'  => 'Kits y Tratamientos',
    'cama'          => 'Ropa de Cama y Campos',
    'cobertores'    => 'Ropa de Cama y Campos',
    'ambos'         => 'Accesorios Médicos',
    'otros'         => 'Accesorios Médicos',
];
$catKey = strtolower($producto['categoria']);
$tituloPrincipal = isset($titulos[$catKey]) ? $titulos[$catKey] : 'Catálogo de Productos';

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
            padding: 50px 50px 50px 80px;
        }
        /* Margen de colores izquierdo */
        .color-bar {
            position: fixed;
            left: 0;
            width: 35px;
            height: 20%;
            z-index: -1;
        }
        .cb-1 { top: 0; background-color: #e30613; }
        .cb-2 { top: 20%; background-color: #f37021; }
        .cb-3 { top: 40%; background-color: #fff200; }
        .cb-4 { top: 60%; background-color: #8dc63f; }
        .cb-5 { top: 80%; background-color: #0054a6; height: 21%; } /* altura extra para asegurar que llega al fondo */

        /* Logo superior derecho */
        .logo-container {
            position: absolute;
            top: 40px;
            right: 40px;
            text-align: right;
        }
        .logo-container img {
            height: 90px;
        }

        /* Encabezado de texto */
        .header-text {
            margin-right: 160px; /* Espacio para el logo */
        }
        .cat-title {
            font-size: 28px;
            font-weight: 900;
            color: #333;
            margin: 0 0 15px 0;
        }
        .prod-subtitle {
            font-size: 15px;
            font-weight: normal;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        /* Contenedor principal de dos columnas */
        .content-table {
            width: 100%;
            margin-top: 30px;
            table-layout: fixed;
        }
        .col-left {
            width: 50%;
            vertical-align: top;
            padding-right: 30px;
        }
        .col-right {
            width: 50%;
            vertical-align: top;
        }

        /* Grilla de Imágenes */
        .images-container {
            text-align: center;
        }
        .prod-img {
            max-width: 90%;
            max-height: 400px;
            margin: 10px 0 20px 0;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        /* Ficha Técnica (Specs) */
        .specs-title {
            font-size: 18px;
            font-weight: 900;
            color: #000;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }
        .spec-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .spec-table tr {
            border-bottom: 1px solid #ccc;
        }
        .spec-table tr:first-child {
            border-top: 2px solid #000;
        }
        .spec-table tr:last-child {
            border-bottom: 2px solid #000;
        }
        .spec-table td {
            padding: 12px 10px;
            vertical-align: top;
            color: #333;
        }
        .spec-key {
            font-weight: 900;
            width: 35%;
            color: #000;
        }
        .spec-val {
            color: #444;
        }
        .circle-letter {
            display: inline-block;
            background-color: #1a1a1a;
            color: #fff;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            text-align: center;
            line-height: 18px;
            font-size: 10px;
            font-weight: bold;
            float: right;
            margin-left: 10px;
        }
        .item-row {
            margin-bottom: 4px;
            clear: both;
            overflow: hidden;
        }
        .item-text {
            float: left;
            width: 85%;
        }
    </style>
</head>
<body>
    <div class="color-bar cb-1"></div>
    <div class="color-bar cb-2"></div>
    <div class="color-bar cb-3"></div>
    <div class="color-bar cb-4"></div>
    <div class="color-bar cb-5"></div>

    <div class="logo-container">
        <img src="' . $logoBase64 . '">
    </div>

    <div class="header-text">
        <h1 class="cat-title">' . $tituloPrincipal . '</h1>
        <h2 class="prod-subtitle">' . $nombre . '</h2>
    </div>

    <table class="content-table">
        <tr>
            <td class="col-left">
                <div class="images-container">
                    ' . $imgHtml . '
                </div>
            </td>
            <td class="col-right">
                <div class="specs-title">Ficha técnica</div>
                <table class="spec-table">
                    ' . $specsHtml . '
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$filename = "Ficha-DPC-" . str_replace(' ', '-', $nombre) . ".pdf";
$dompdf->stream($filename, ["Attachment" => true]);

