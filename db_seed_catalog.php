<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/db/database.php';

try {
    $db = getDB();
    echo "Conexión establecida.<br>";

    $db->exec("DELETE FROM productos");
    $db->exec("DELETE FROM sqlite_sequence WHERE name='productos'");
    echo "Tabla de productos reseteada.<br>";

    $productos = [

        // ─────────────────────────────────────────
        // PROTECCIÓN
        // ─────────────────────────────────────────
        [
            'nombre'       => 'Barbijos',
            'nombre_en'    => 'Face Masks',
            'nombre_pt'    => 'Máscaras Faciais',
            'categoria'    => 'proteccion',
            'desc_corta'   => 'Triple capa con ajuste nasal.',
            'desc_corta_en' => 'Triple layer with nose clip.',
            'desc_corta_pt' => 'Camada tripla com ajuste nasal.',
            'descripcion'  => 'Barbijos descartables de triple capa con meltblown para alta filtración bacteriana.',
            'descripcion_en' => 'Disposable triple-layer masks with meltblown for high bacterial filtration.',
            'descripcion_pt' => 'Máscaras descartáveis de tripla camada com meltblown para alta filtração bacteriana.',
            'imagen'       => 'assets/img/catalogo/barbijo.png',
            'specs'        => json_encode(['Tela: SMS / Meltblown', 'Presentaciones: 1 / 25', 'Color: Celeste / Blanco', 'Ajustes: Elástico + ajuste nasal', 'Composición: Triple capa', 'Autorizado: PM 2521 - 2']),
            'specs_en'     => json_encode(['Fabric: SMS / Meltblown', 'Package: 1 / 25 units', 'Color: Light Blue / White', 'Adjustments: Elastic + nose clip', 'Composition: Triple layer', 'Authorized: PM 2521 - 2']),
            'specs_pt'     => json_encode(['Tecido: SMS / Meltblown', 'Apresentações: 1 / 25', 'Cor: Celeste / Branco', 'Ajustes: Elástico + ajuste nasal', 'Composição: Camada tripla', 'Autorizado: PM 2521 - 2']),
            'orden'        => 1
        ],
        [
            'nombre'       => 'Cubre Calzado',
            'nombre_en'    => 'Shoe Covers',
            'nombre_pt'    => 'Pró-pés',
            'categoria'    => 'proteccion',
            'desc_corta'   => 'Gramajes 20/30/45 gr. 50 Pares.',
            'desc_corta_en' => 'Grammage 20/30/45 gr. 50 Pairs.',
            'desc_corta_pt' => 'Gramagens 20/30/45 gr. 50 Pares.',
            'descripcion'  => 'Protectores de calzado descartables con elástico para sujeción firme.',
            'descripcion_en' => 'Disposable shoe protectors with elastic for firm hold.',
            'descripcion_pt' => 'Protetores de calçados descartáveis com elástico para fixação firme.',
            'imagen'       => 'assets/img/catalogo/cubrecalzado.png',
            'specs'        => json_encode(['Tela: SMS / Laminado', 'Presentaciones: 50 Pares', 'Color: Azul / Blanco', 'Gramajes: 20 / 30 / 45 gr', 'Medidas: 35x30 cm', 'Autorizado: PM 2521 - 1']),
            'specs_en'     => json_encode(['Fabric: SMS / Laminated', 'Package: 50 Pairs', 'Color: Blue / White', 'Grammage: 20 / 30 / 45 gr', 'Measures: 35x30 cm', 'Authorized: PM 2521 - 1']),
            'specs_pt'     => json_encode(['Tecido: SMS / Laminado', 'Apresentações: 50 Pares', 'Cor: Azul / Branco', 'Gramagens: 20 / 30 / 45 gr', 'Medidas: 35x30 cm', 'Autorizado: PM 2521 - 1']),
            'orden'        => 2
        ],
        [
            'nombre'       => 'Cofias',
            'nombre_en'    => 'Bouffant Caps',
            'nombre_pt'    => 'Toucas Descartáveis',
            'categoria'    => 'proteccion',
            'desc_corta'   => 'Ajuste elástico, triple capa.',
            'desc_corta_en' => 'Elastic fit, triple layer.',
            'desc_corta_pt' => 'Ajuste elástico, camada tripla.',
            'descripcion'  => 'Cofias descartables circulares con elástico perimetral para cobertura total del cabello.',
            'descripcion_en' => 'Disposable circular caps with perimeter elastic for total hair coverage.',
            'descripcion_pt' => 'Toucas circulares descartáveis com elástico perimetral para cobertura total dos cabelos.',
            'imagen'       => 'assets/img/catalogo/cofia.png',
            'specs'        => json_encode(['Tela: SMS', 'Presentaciones: 100 u.', 'Color: Blanco', 'Ajustes: Elástico', 'Composición: Triple capa', 'Autorizado: PM 2521 - 2']),
            'specs_en'     => json_encode(['Fabric: SMS', 'Package: 100 units', 'Color: White', 'Adjustments: Elastic', 'Composition: Triple layer', 'Authorized: PM 2521 - 2']),
            'specs_pt'     => json_encode(['Tecido: SMS', 'Apresentações: 100 un.', 'Cor: Branco', 'Ajustes: Elástico', 'Composição: Camada tripla', 'Autorizado: PM 2521 - 2']),
            'orden'        => 3
        ],

        // ─────────────────────────────────────────
        // CAMISOLINES
        // ─────────────────────────────────────────
        [
            'nombre'       => 'Camisolín Línea Económica',
            'nombre_en'    => 'Medical Gown - Economic Line',
            'nombre_pt'    => 'Avental Linha Econômica',
            'categoria'    => 'camisolines',
            'desc_corta'   => 'Tela SMS 15 gr, puño elástico.',
            'desc_corta_en' => 'SMS Fabric 15 gr, elastic cuff.',
            'desc_corta_pt' => 'Tecido SMS 15 gr, punho elástico.',
            'descripcion'  => 'Camisolín descartable para uso general en áreas de bajo riesgo.',
            'descripcion_en' => 'Disposable gown for general use in low-risk areas.',
            'descripcion_pt' => 'Avental descartável para uso geral em áreas de baixo risco.',
            'imagen'       => 'assets/img/catalogo/camisolin-lineaeconomica.png',
            'specs'        => json_encode(['Tela: SMS', 'Presentaciones: 20 u.', 'Tamaño: 1.00 / 1.20 mts', 'Color: Azul / Blanco', 'Gramaje: 15 gr', 'Puño: Elástico', 'Autorizado: PM 2521 - 1']),
            'specs_en'     => json_encode(['Fabric: SMS', 'Package: 20 units', 'Size: 1.00 / 1.20 mts', 'Color: Blue / White', 'Grammage: 15 gr', 'Cuff: Elastic', 'Authorized: PM 2521 - 1']),
            'specs_pt'     => json_encode(['Tecido: SMS', 'Apresentações: 20 un.', 'Tamanho: 1.00 / 1.20 mts', 'Cor: Azul / Branco', 'Gramagem: 15 gr', 'Punho: Elástico', 'Autorizado: PM 2521 - 1']),
            'orden'        => 4
        ],
        [
            'nombre'       => 'Camisolín Línea Médium',
            'nombre_en'    => 'Medical Gown - Medium Line',
            'nombre_pt'    => 'Avental Linha Médium',
            'categoria'    => 'camisolines',
            'desc_corta'   => 'Tela SMS 20/30 gr, puño Elástico o Morley.',
            'desc_corta_en' => 'SMS Fabric 20/30 gr, Elastic or Morley cuff.',
            'desc_corta_pt' => 'Tecido SMS 20/30 gr, punho Elástico ou Morley.',
            'descripcion'  => 'Camisolín de mayor resistencia para procedimientos intermedios.',
            'descripcion_en' => 'Resistant gown for intermediate procedures.',
            'descripcion_pt' => 'Avental de maior resistência para procedimentos intermediários.',
            'imagen'       => 'assets/img/catalogo/camisolin-lineamedium.png',
            'specs'        => json_encode(['Tela: SMS', 'Presentaciones: 10 u.', 'Tamaño: 1.00 / 1.20 / 1.40 mts', 'Color: Azul / Blanco', 'Gramaje: 20 / 30 gr', 'Puño: Elástico / Morley', 'Autorizado: PM 2521 - 1']),
            'specs_en'     => json_encode(['Fabric: SMS', 'Package: 10 units', 'Size: 1.00 / 1.20 / 1.40 mts', 'Color: Blue / White', 'Grammage: 20 / 30 gr', 'Cuff: Elastic / Morley', 'Authorized: PM 2521 - 1']),
            'specs_pt'     => json_encode(['Tecido: SMS', 'Apresentações: 10 un.', 'Tamanho: 1.00 / 1.20 / 1.40 mts', 'Cor: Azul / Branco', 'Gramagem: 20 / 30 gr', 'Punho: Elástico / Morley', 'Autorizado: PM 2521 - 1']),
            'orden'        => 5
        ],
        [
            'nombre'       => 'Camisolín Línea Premium',
            'nombre_en'    => 'Medical Gown - Premium Line',
            'nombre_pt'    => 'Avental Linha Premium',
            'categoria'    => 'camisolines',
            'desc_corta'   => 'Tela SMS 45/50 gr, alta barrera.',
            'desc_corta_en' => 'SMS Fabric 45/50 gr, high barrier.',
            'desc_corta_pt' => 'Tecido SMS 45/50 gr, alta barreira.',
            'descripcion'  => 'Máxima protección y confort para procedimientos quirúrgicos prolongados.',
            'descripcion_en' => 'Maximum protection and comfort for prolonged surgical procedures.',
            'descripcion_pt' => 'Máxima proteção e conforto para procedimentos cirúrgicos prolongados.',
            'imagen'       => 'assets/img/catalogo/camisolin-lineapremium.png',
            'specs'        => json_encode(['Tela: SMS', 'Presentaciones: 10 u.', 'Tamaño: 1.20 / 1.40 mts', 'Color: Azul', 'Gramaje: 45 / 50 gr', 'Puño: Elástico / Morley', 'Autorizado: PM 2521 - 1']),
            'specs_en'     => json_encode(['Fabric: SMS', 'Package: 10 units', 'Size: 1.20 / 1.40 mts', 'Color: Blue', 'Grammage: 45 / 50 gr', 'Cuff: Elastic / Morley', 'Authorized: PM 2521 - 1']),
            'specs_pt'     => json_encode(['Tecido: SMS', 'Apresentações: 10 un.', 'Tamanho: 1.20 / 1.40 mts', 'Cor: Azul', 'Gramagem: 45 / 50 gr', 'Punho: Elástico / Morley', 'Autorizado: PM 2521 - 1']),
            'orden'        => 6
        ],
        [
            'nombre'       => 'Camisolín Línea Especial',
            'nombre_en'    => 'Medical Gown - Special Line',
            'nombre_pt'    => 'Avental Linha Especial',
            'categoria'    => 'camisolines',
            'desc_corta'   => 'SMS/Laminado 30-60 gr, refuerzo en mangas y pecho.',
            'desc_corta_en' => 'SMS/Laminated 30-60 gr, reinforced sleeves and chest.',
            'desc_corta_pt' => 'SMS/Laminado 30-60 gr, reforço em mangas e peito.',
            'descripcion'  => 'Camisolín 100% laminado con refuerzo mixto en mangas y pecho. Alta capacidad de protección para procedimientos de alto riesgo.',
            'descripcion_en' => '100% laminated gown with mixed reinforcement on sleeves and chest. High protection capacity for high-risk procedures.',
            'descripcion_pt' => 'Avental 100% laminado com reforço misto em mangas e peito. Alta capacidade de proteção para procedimentos de alto risco.',
            'imagen'       => 'assets/img/catalogo/camisolin-lineaespecial.png',
            'specs'        => json_encode(['Tela: SMS / Laminado', 'Presentaciones: 10 u.', 'Tamaño: 1.20 / 1.40 mts', 'Color: Azul / Blanco', 'Gramaje: 30 / 45 / 50 / 60 gr', 'Puño: Elástico / Morley', '100% laminado: Alta capacidad de protección', 'Mixto con refuerzo: Mangas y pecho', 'Autorizado: PM 2521 - 1']),
            'specs_en'     => json_encode(['Fabric: SMS / Laminated', 'Package: 10 units', 'Size: 1.20 / 1.40 mts', 'Color: Blue / White', 'Grammage: 30 / 45 / 50 / 60 gr', 'Cuff: Elastic / Morley', '100% laminated: High protection capacity', 'Mixed reinforcement: Sleeves and chest', 'Authorized: PM 2521 - 1']),
            'specs_pt'     => json_encode(['Tecido: SMS / Laminado', 'Apresentações: 10 un.', 'Tamanho: 1.20 / 1.40 mts', 'Cor: Azul / Branco', 'Gramagem: 30 / 45 / 50 / 60 gr', 'Punho: Elástico / Morley', '100% laminado: Alta capacidade de proteção', 'Reforço misto: Mangas e peito', 'Autorizado: PM 2521 - 1']),
            'orden'        => 7
        ],
        [
            'nombre'       => 'Camisolín Línea Brin',
            'nombre_en'    => 'Medical Gown - Brin Line',
            'nombre_pt'    => 'Avental Linha Brin',
            'categoria'    => 'camisolines',
            'desc_corta'   => 'Tela Brin 80 gr, lavable y resistente.',
            'desc_corta_en' => 'Brin Fabric 80 gr, washable and resistant.',
            'desc_corta_pt' => 'Tecido Brin 80 gr, lavável e resistente.',
            'descripcion'  => 'Camisolín de tela Brin reutilizable con 100% laminado y alta capacidad de protección. Ideal para consultorios y uso prolongado.',
            'descripcion_en' => 'Reusable Brin fabric gown with 100% lamination and high protection. Ideal for clinics and extended use.',
            'descripcion_pt' => 'Avental de tecido Brin reutilizável com 100% laminado e alta capacidade de proteção. Ideal para consultórios e uso prolongado.',
            'imagen'       => 'assets/img/catalogo/camisolin-brin.png',
            'specs'        => json_encode(['Tela: Brin', 'Presentaciones: 1 u.', 'Tamaño: L / XL / XXL / XXXL', 'Color: Verde', 'Gramaje: 80 gr', 'Puño: Morley', '100% laminado: Alta capacidad de protección', 'Autorizado: PM 2521 - 1']),
            'specs_en'     => json_encode(['Fabric: Brin', 'Package: 1 unit', 'Size: L / XL / XXL / XXXL', 'Color: Green', 'Grammage: 80 gr', 'Cuff: Morley', '100% laminated: High protection capacity', 'Authorized: PM 2521 - 1']),
            'specs_pt'     => json_encode(['Tecido: Brin', 'Apresentações: 1 un.', 'Tamanho: L / XL / XXL / XXXL', 'Cor: Verde', 'Gramagem: 80 gr', 'Punho: Morley', '100% laminado: Alta capacidade de proteção', 'Autorizado: PM 2521 - 1']),
            'orden'        => 8
        ],

        // ─────────────────────────────────────────
        // EQUIPOS DE CIRUGÍA
        // ─────────────────────────────────────────
        [
            'nombre'       => 'Equipo de Cirugía General',
            'nombre_en'    => 'General Surgery Equipment',
            'nombre_pt'    => 'Equipamento de Cirurgia Geral',
            'categoria'    => 'quirurgico',
            'desc_corta'   => 'Kit completo esterilizado, 5 u.',
            'desc_corta_en' => 'Full sterilized kit, 5 units.',
            'desc_corta_pt' => 'Kit completo esterilizado, 5 un.',
            'descripcion'  => 'Equipo completo 100% esterilizado para cirugía general. Incluye campos, camisolines, sábanas y toallas de secado.',
            'descripcion_en' => 'Fully sterilized kit for general surgery. Includes fields, gowns, sheets and drying towels.',
            'descripcion_pt' => 'Equipamento completo 100% esterilizado para cirurgia geral. Inclui campos, aventais, lençóis e toalhas de secagem.',
            'imagen'       => 'assets/img/catalogo/equipodecirugiageneral.png',
            'specs'        => json_encode(['Tela: SMS', 'Presentaciones: 5 u.', 'Contenido: 4 Campos 100x100 cm / 4 Camisolines p/morley / 5 Sábanas 200x150 cm / 5 Toallas de Secado', 'Color: Azul', 'Gramaje: 50 gr', 'Esterilidad: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'specs_en'     => json_encode(['Fabric: SMS', 'Package: 5 units', 'Contents: 4 Fields 100x100 cm / 4 Morley Gowns / 5 Sheets 200x150 cm / 5 Drying Towels', 'Color: Blue', 'Grammage: 50 gr', 'Sterility: 100% Sterilized', 'Authorized: PM 2521 - 1/3']),
            'specs_pt'     => json_encode(['Tecido: SMS', 'Apresentações: 5 un.', 'Conteúdo: 4 Campos 100x100 cm / 4 Aventais p/morley / 5 Lençóis 200x150 cm / 5 Toalhas de Secagem', 'Cor: Azul', 'Gramagem: 50 gr', 'Esterilidade: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'orden'        => 9
        ],
        [
            'nombre'       => 'Equipo de Cirugía TyO',
            'nombre_en'    => 'Surgery Equipment TyO',
            'nombre_pt'    => 'Equipamento de Cirurgia TyO',
            'categoria'    => 'quirurgico',
            'desc_corta'   => 'Traumatología y Ortopedia, 5 u.',
            'desc_corta_en' => 'Traumatology and Orthopedics, 5 units.',
            'desc_corta_pt' => 'Traumatologia e Ortopedia, 5 un.',
            'descripcion'  => 'Configuración específica 100% esterilizada para cirugías de Traumatología y Ortopedia.',
            'descripcion_en' => 'Specific 100% sterilized setup for Traumatology and Orthopedics surgeries.',
            'descripcion_pt' => 'Configuração específica 100% esterilizada para cirurgias de Traumatologia e Ortopedia.',
            'imagen'       => 'assets/img/catalogo/equipodecirugiatyo.png',
            'specs'        => json_encode(['Tela: SMS', 'Presentaciones: 5 u.', 'Contenido: 2 Campos 70x70 cm / 4 Camisolines p/morley / 5 Sábanas 200x150 cm / 8 Toallas de Secado', 'Color: Azul', 'Gramaje: 50 gr', 'Esterilidad: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'specs_en'     => json_encode(['Fabric: SMS', 'Package: 5 units', 'Contents: 2 Fields 70x70 cm / 4 Morley Gowns / 5 Sheets 200x150 cm / 8 Drying Towels', 'Color: Blue', 'Grammage: 50 gr', 'Sterility: 100% Sterilized', 'Authorized: PM 2521 - 1/3']),
            'specs_pt'     => json_encode(['Tecido: SMS', 'Apresentações: 5 un.', 'Conteúdo: 2 Campos 70x70 cm / 4 Aventais p/morley / 5 Lençóis 200x150 cm / 8 Toalhas de Secagem', 'Cor: Azul', 'Gramagem: 50 gr', 'Esterilidade: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'orden'        => 10
        ],
        [
            'nombre'       => 'Equipo de Cirugía de Rodilla',
            'nombre_en'    => 'Knee Surgery Equipment',
            'nombre_pt'    => 'Equipamento de Cirurgia de Joelho',
            'categoria'    => 'quirurgico',
            'desc_corta'   => 'Kit especializado para artroplastia de rodilla.',
            'desc_corta_en' => 'Specialized kit for knee arthroplasty.',
            'desc_corta_pt' => 'Kit especializado para artroplastia de joelho.',
            'descripcion'  => 'Equipo 100% esterilizado para cirugía de rodilla. Incluye cubrepierna laminada, sábanas tipo U, campos con adhesivo y refuerzos laminados.',
            'descripcion_en' => '100% sterilized kit for knee surgery. Includes laminated leg cover, U-type sheets, adhesive fields and laminated reinforcements.',
            'descripcion_pt' => 'Equipamento 100% esterilizado para cirurgia de joelho. Inclui cobre-perna laminado, lençóis tipo U, campos com adesivo e reforços laminados.',
            'imagen'       => 'assets/img/catalogo/equipodecirugiarodilla.png',
            'specs'        => json_encode(['Tela: SMS', 'Presentaciones: 5 u.', 'Contenido: 3 Campos 70x70 cm / 1 Camisolín p/morley 50g / 1 Camisolín p/morley 60g / 2 Camisolines c/refuerzo laminado y p/morley 60g / 2 Sábanas c/laminado 200x150 cm / 2 Sábanas c/adhesivo 200x150 cm / 1 Sábana c/laminado tipo U 200x150 cm / 1 Sábana tipo U 250x200 cm / 1 Cubrepierna c/laminado y adhesivo / 1 Tira c/adhesivo 4x60 cm / 6 Toallas de Secado', 'Color: Azul', 'Gramaje: 50 - 60 gr', 'Esterilidad: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'specs_en'     => json_encode(['Fabric: SMS', 'Package: 5 units', 'Contents: 3 Fields 70x70 cm / 1 Morley Gown 50g / 1 Morley Gown 60g / 2 Reinforced Laminated Morley Gowns 60g / 2 Laminated Sheets 200x150 cm / 2 Adhesive Sheets 200x150 cm / 1 Laminated U-Sheet 200x150 cm / 1 U-Sheet 250x200 cm / 1 Laminated & Adhesive Leg Cover / 1 Adhesive Strip 4x60 cm / 6 Drying Towels', 'Color: Blue', 'Grammage: 50-60 gr', 'Sterility: 100% Sterilized', 'Authorized: PM 2521 - 1/3']),
            'specs_pt'     => json_encode(['Tecido: SMS', 'Apresentações: 5 un.', 'Conteúdo: 3 Campos 70x70 cm / 1 Avental p/morley 50g / 1 Avental p/morley 60g / 2 Aventais c/reforço laminado e p/morley 60g / 2 Lençóis c/laminado 200x150 cm / 2 Lençóis c/adesivo 200x150 cm / 1 Lençol c/laminado tipo U 200x150 cm / 1 Lençol tipo U 250x200 cm / 1 Cobre-perna c/laminado e adesivo / 1 Tira c/adesivo 4x60 cm / 6 Toalhas de Secagem', 'Cor: Azul', 'Gramagem: 50-60 gr', 'Esterilidade: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'orden'        => 11
        ],
        [
            'nombre'       => 'Equipo de Cirugía de Columna',
            'nombre_en'    => 'Spine Surgery Equipment',
            'nombre_pt'    => 'Equipamento de Cirurgia de Coluna',
            'categoria'    => 'quirurgico',
            'desc_corta'   => 'Sábana especial 300x200 cm tipo U.',
            'desc_corta_en' => 'Special U-type sheet 300x200 cm.',
            'desc_corta_pt' => 'Lençol especial tipo U 300x200 cm.',
            'descripcion'  => 'Equipo 100% esterilizado para cirugía de columna. Incluye campos adhesivos de gran tamaño y sábana 300x200 cm tipo U.',
            'descripcion_en' => '100% sterilized kit for spine surgery. Includes large adhesive fields and 300x200 cm U-type sheet.',
            'descripcion_pt' => 'Equipamento 100% esterilizado para cirurgia de coluna. Inclui campos adesivos de grande porte e lençol 300x200 cm tipo U.',
            'imagen'       => 'assets/img/catalogo/equipodecirugiacolumna.png',
            'specs'        => json_encode(['Tela: SMS', 'Presentaciones: 5 u.', 'Contenido: 3 Campos 70x70 cm / 4 Campos c/adhesivo 70x70 cm / 4 Camisolines p/morley 50g / 1 Sábana 300x200 cm tipo U 60g / 2 Sábanas 200x150 cm c/laminado / 2 Sábanas 200x150 c/adhesivo / 6 Toallas de Secado', 'Color: Azul', 'Gramaje: 50 - 60 gr', 'Esterilidad: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'specs_en'     => json_encode(['Fabric: SMS', 'Package: 5 units', 'Contents: 3 Fields 70x70 cm / 4 Adhesive Fields 70x70 cm / 4 Morley Gowns 50g / 1 U-Sheet 300x200 cm 60g / 2 Laminated Sheets 200x150 cm / 2 Adhesive Sheets 200x150 cm / 6 Drying Towels', 'Color: Blue', 'Grammage: 50-60 gr', 'Sterility: 100% Sterilized', 'Authorized: PM 2521 - 1/3']),
            'specs_pt'     => json_encode(['Tecido: SMS', 'Apresentações: 5 un.', 'Conteúdo: 3 Campos 70x70 cm / 4 Campos c/adesivo 70x70 cm / 4 Aventais p/morley 50g / 1 Lençol 300x200 cm tipo U 60g / 2 Lençóis 200x150 cm c/laminado / 2 Lençóis 200x150 c/adesivo / 6 Toalhas de Secagem', 'Cor: Azul', 'Gramagem: 50-60 gr', 'Esterilidade: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'orden'        => 12
        ],
        [
            'nombre'       => 'Equipo de Cirugía de Cadera',
            'nombre_en'    => 'Hip Surgery Equipment',
            'nombre_pt'    => 'Equipamento de Cirurgia de Quadril',
            'categoria'    => 'quirurgico',
            'desc_corta'   => 'Sábanas tipo U 250x200 cm, adhesivos.',
            'desc_corta_en' => 'U-type sheets 250x200 cm, adhesive.',
            'desc_corta_pt' => 'Lençóis tipo U 250x200 cm, adesivos.',
            'descripcion'  => 'Equipo 100% esterilizado para cirugía de cadera. Incluye campos 100x100, camisolines Morley y sábanas tipo U con adhesivo.',
            'descripcion_en' => '100% sterilized kit for hip surgery. Includes 100x100 fields, Morley gowns and U-type sheets with adhesive.',
            'descripcion_pt' => 'Equipamento 100% esterilizado para cirurgia de quadril. Inclui campos 100x100, aventais Morley e lençóis tipo U com adesivo.',
            'imagen'       => 'assets/img/catalogo/equipodecirugiacadera.png',
            'specs'        => json_encode(['Tela: SMS', 'Presentaciones: 5 u.', 'Contenido: 3 Campos 100x100 cm / 2 Camisolines p/morley 50g / 2 Camisolines p/morley 60g / 2 Sábanas tipo U 250x200 cm / 2 Sábanas c/laminado 200x150 cm / 2 Sábanas 200x150 cm c/adhesivo / 6 Toallas de Secado', 'Color: Azul', 'Gramaje: 50 - 60 gr', 'Esterilidad: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'specs_en'     => json_encode(['Fabric: SMS', 'Package: 5 units', 'Contents: 3 Fields 100x100 cm / 2 Morley Gowns 50g / 2 Morley Gowns 60g / 2 U-Sheets 250x200 cm / 2 Laminated Sheets 200x150 cm / 2 Adhesive Sheets 200x150 cm / 6 Drying Towels', 'Color: Blue', 'Grammage: 50-60 gr', 'Sterility: 100% Sterilized', 'Authorized: PM 2521 - 1/3']),
            'specs_pt'     => json_encode(['Tecido: SMS', 'Apresentações: 5 un.', 'Conteúdo: 3 Campos 100x100 cm / 2 Aventais p/morley 50g / 2 Aventais p/morley 60g / 2 Lençóis tipo U 250x200 cm / 2 Lençóis c/laminado 200x150 cm / 2 Lençóis 200x150 cm c/adesivo / 6 Toalhas de Secagem', 'Cor: Azul', 'Gramagem: 50-60 gr', 'Esterilidade: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'orden'        => 13
        ],
        [
            'nombre'       => 'Equipo de Cirugía de Hombro',
            'nombre_en'    => 'Shoulder Surgery Equipment',
            'nombre_pt'    => 'Equipamento de Cirurgia de Ombro',
            'categoria'    => 'quirurgico',
            'desc_corta'   => 'Camisolines con refuerzo, tira adhesiva.',
            'desc_corta_en' => 'Reinforced gowns, adhesive strip.',
            'desc_corta_pt' => 'Aventais com reforço, tira adesiva.',
            'descripcion'  => 'Equipo 100% esterilizado para cirugía de hombro. Incluye campo adhesivo, camisolines con refuerzo, sábanas tipo U y tira adhesiva 4x30 cm.',
            'descripcion_en' => '100% sterilized kit for shoulder surgery. Includes adhesive field, reinforced gowns, U-type sheets and 4x30 cm adhesive strip.',
            'descripcion_pt' => 'Equipamento 100% esterilizado para cirurgia de ombro. Inclui campo adesivo, aventais com reforço, lençóis tipo U e tira adesiva 4x30 cm.',
            'imagen'       => 'assets/img/catalogo/equipodecirugiaombro.png',
            'specs'        => json_encode(['Tela: SMS', 'Presentaciones: 5 u.', 'Contenido: 1 Campo 70x70 cm c/adhesivo / 1 Camisolín p/morley 60g / 1 Camisolín p/morley 50g / 2 Camisolines c/refuerzo y p/morley 60g / 2 Sábanas 200x150 cm c/adhesivo / 1 Sábana 200x150 cm c/laminado / 1 Sábana 250x200 cm tipo U / 1 Sábana 200x150 cm tipo U / 1 Tira c/adhesivo 4x30 cm / 6 Toallas de Secado', 'Color: Azul', 'Gramaje: 50 - 60 gr', 'Esterilidad: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'specs_en'     => json_encode(['Fabric: SMS', 'Package: 5 units', 'Contents: 1 Adhesive Field 70x70 cm / 1 Morley Gown 60g / 1 Morley Gown 50g / 2 Reinforced Morley Gowns 60g / 2 Adhesive Sheets 200x150 cm / 1 Laminated Sheet 200x150 cm / 1 U-Sheet 250x200 cm / 1 U-Sheet 200x150 cm / 1 Adhesive Strip 4x30 cm / 6 Drying Towels', 'Color: Blue', 'Grammage: 50-60 gr', 'Sterility: 100% Sterilized', 'Authorized: PM 2521 - 1/3']),
            'specs_pt'     => json_encode(['Tecido: SMS', 'Apresentações: 5 un.', 'Conteúdo: 1 Campo 70x70 cm c/adesivo / 1 Avental p/morley 60g / 1 Avental p/morley 50g / 2 Aventais c/reforço e p/morley 60g / 2 Lençóis 200x150 cm c/adesivo / 1 Lençol 200x150 cm c/laminado / 1 Lençol 250x200 cm tipo U / 1 Lençol 200x150 cm tipo U / 1 Tira c/adesivo 4x30 cm / 6 Toalhas de Secagem', 'Cor: Azul', 'Gramagem: 50-60 gr', 'Esterilidade: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'orden'        => 14
        ],
        [
            'nombre'       => 'Equipo de Cirugía Menor',
            'nombre_en'    => 'Minor Surgery Equipment',
            'nombre_pt'    => 'Equipamento de Cirurgia Menor',
            'categoria'    => 'quirurgico',
            'desc_corta'   => 'Kit compacto para procedimientos menores.',
            'desc_corta_en' => 'Compact kit for minor procedures.',
            'desc_corta_pt' => 'Kit compacto para procedimentos menores.',
            'descripcion'  => 'Equipo 100% esterilizado para cirugía menor. Incluye campos fenestrados, camisolín Morley, gasas y toalla de secado.',
            'descripcion_en' => '100% sterilized kit for minor surgery. Includes fenestrated fields, Morley gown, gauze and drying towel.',
            'descripcion_pt' => 'Equipamento 100% esterilizado para cirurgia menor. Inclui campos fenestrados, avental Morley, gazes e toalha de secagem.',
            'imagen'       => 'assets/img/catalogo/equipodecirugiamenor.png',
            'specs'        => json_encode(['Tela: SMS', 'Presentaciones: 5 u.', 'Contenido: 1 Campo 60x50 cm fenestrado / 1 Campo 75x50 cm / 1 Campo 90x60 cm / 1 Camisolín p/morley 50g / 3 Gasas 7x7 / 1 Toalla de Secado', 'Color: Azul', 'Gramaje: 50 gr', 'Esterilidad: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'specs_en'     => json_encode(['Fabric: SMS', 'Package: 5 units', 'Contents: 1 Fenestrated Field 60x50 cm / 1 Field 75x50 cm / 1 Field 90x60 cm / 1 Morley Gown 50g / 3 Gauze 7x7 / 1 Drying Towel', 'Color: Blue', 'Grammage: 50 gr', 'Sterility: 100% Sterilized', 'Authorized: PM 2521 - 1/3']),
            'specs_pt'     => json_encode(['Tecido: SMS', 'Apresentações: 5 un.', 'Conteúdo: 1 Campo 60x50 cm fenestrado / 1 Campo 75x50 cm / 1 Campo 90x60 cm / 1 Avental p/morley 50g / 3 Gazes 7x7 / 1 Toalha de Secagem', 'Cor: Azul', 'Gramagem: 50 gr', 'Esterilidade: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'orden'        => 15
        ],
        [
            'nombre'       => 'Equipo de Cirugía Hemodinamia',
            'nombre_en'    => 'Hemodynamics Surgery Equipment',
            'nombre_pt'    => 'Equipamento de Cirurgia Hemodinâmica',
            'categoria'    => 'quirurgico',
            'desc_corta'   => 'Cubreintensificador SMS y plástico.',
            'desc_corta_en' => 'SMS and plastic intensifier cover.',
            'desc_corta_pt' => 'Cobre-intensificador SMS e plástico.',
            'descripcion'  => 'Equipo 100% esterilizado para hemodinamia. Incluye cubreintensificadores, cubreprotector de irradiación, sábanas bifenestradas y absorbentes.',
            'descripcion_en' => '100% sterilized kit for hemodynamics. Includes intensifier covers, radiation protection cover, bifenestrated and absorbent sheets.',
            'descripcion_pt' => 'Equipamento 100% esterilizado para hemodinâmica. Inclui cobre-intensificadores, cobre-protetor de irradiação, lençóis bifenestrados e absorventes.',
            'imagen'       => 'assets/img/catalogo/equipodecirugiahemodinamia.png',
            'specs'        => json_encode(['Tela: SMS', 'Presentaciones: 5 u.', 'Contenido: 1 Campo 100x100 fenestrado c/adhesivo / 1 Cubreintensificador SMS / 1 Cubreprotector de irradiación 100x75 cm SMS / 1 Cubreintensificador plástico 100x50 cm / 2 Camisolines c/refuerzo en pecho / 1 Sábana 300x210 cm bifenestrada con adhesivo visor / 1 Sábana 200x200 cm laminada c/absorbente con adhesivo visor / 4 Toallas de Secado', 'Color: Azul', 'Gramaje: 50 gr', 'Esterilidad: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'specs_en'     => json_encode(['Fabric: SMS', 'Package: 5 units', 'Contents: 1 Fenestrated Field 100x100 w/adhesive / 1 SMS Intensifier Cover / 1 Radiation Protection Cover 100x75 cm SMS / 1 Plastic Intensifier Cover 100x50 cm / 2 Chest-Reinforced Gowns / 1 Bifenestrated Sheet 300x210 cm w/visor adhesive / 1 Laminated Absorbent Sheet 200x200 cm w/visor adhesive / 4 Drying Towels', 'Color: Blue', 'Grammage: 50 gr', 'Sterility: 100% Sterilized', 'Authorized: PM 2521 - 1/3']),
            'specs_pt'     => json_encode(['Tecido: SMS', 'Apresentações: 5 un.', 'Conteúdo: 1 Campo 100x100 fenestrado c/adesivo / 1 Cobre-intensificador SMS / 1 Cobre-protetor de irradiação 100x75 cm SMS / 1 Cobre-intensificador plástico 100x50 cm / 2 Aventais c/reforço no peito / 1 Lençol 300x210 cm bifenestrado c/adesivo visor / 1 Lençol 200x200 cm laminado c/absorvente c/adesivo visor / 4 Toalhas de Secagem', 'Cor: Azul', 'Gramagem: 50 gr', 'Esterilidade: 100% Esterilizado', 'Autorizado: PM 2521 - 1/3']),
            'orden'        => 16
        ],

        // ─────────────────────────────────────────
        // AMBOS
        // ─────────────────────────────────────────
        [
            'nombre'       => 'Ambos Descartables',
            'nombre_en'    => 'Disposable Scrubs',
            'nombre_pt'    => 'Conjuntos Descartáveis',
            'categoria'    => 'otros',
            'desc_corta'   => 'Chaqueta y pantalón SMS, con o sin mangas.',
            'desc_corta_en' => 'SMS jacket and pants, with or without sleeves.',
            'desc_corta_pt' => 'Jaqueta e calça SMS, com ou sem mangas.',
            'descripcion'  => 'Conjunto de dos piezas descartable para personal de salud. Disponible con mangas cortas o sin mangas.',
            'descripcion_en' => 'Disposable two-piece set for healthcare staff. Available with short sleeves or sleeveless.',
            'descripcion_pt' => 'Conjunto descartável de duas peças para profissionais de saúde. Disponível com mangas curtas ou sem mangas.',
            'imagen'       => 'assets/img/catalogo/ambos.png',
            'specs'        => json_encode(['Tela: SMS', 'Presentaciones: 5 u.', 'Tamaño: L / XL / XXL', 'Color: Azul', 'Gramaje: 15 / 20 / 30 / 45 / 50 gr', 'Formato: C/Mangas Corta - S/Mangas', 'Puño: Elástico / Morley', 'Autorizado: PM 2521 - 1']),
            'specs_en'     => json_encode(['Fabric: SMS', 'Package: 5 units', 'Size: L / XL / XXL', 'Color: Blue', 'Grammage: 15 / 20 / 30 / 45 / 50 gr', 'Format: Short Sleeves / Sleeveless', 'Cuff: Elastic / Morley', 'Authorized: PM 2521 - 1']),
            'specs_pt'     => json_encode(['Tecido: SMS', 'Apresentações: 5 un.', 'Tamanho: L / XL / XXL', 'Cor: Azul', 'Gramagem: 15 / 20 / 30 / 45 / 50 gr', 'Formato: C/Mangas Curtas - S/Mangas', 'Punho: Elástico / Morley', 'Autorizado: PM 2521 - 1']),
            'orden'        => 17
        ],

        // ─────────────────────────────────────────
        // COBERTORES
        // ─────────────────────────────────────────
        [
            'nombre'       => 'Cubre Camilla',
            'nombre_en'    => 'Stretcher Cover',
            'nombre_pt'    => 'Cobre-Maca',
            'categoria'    => 'cama',
            'desc_corta'   => 'SMS/Laminado, con elástico o tiras.',
            'desc_corta_en' => 'SMS/Laminated, elastic or tie closure.',
            'desc_corta_pt' => 'SMS/Laminado, com elástico ou tiras.',
            'descripcion'  => 'Cubre camilla descartable en múltiples medidas y gramajes para uso hospitalario. Ajuste con elástico o tiras según modelo.',
            'descripcion_en' => 'Disposable stretcher cover in multiple sizes and grammages for hospital use. Elastic or tie closure according to model.',
            'descripcion_pt' => 'Cobre-maca descartável em múltiplos tamanhos e gramagens para uso hospitalar. Ajuste com elástico ou tiras conforme modelo.',
            'imagen'       => 'assets/img/catalogo/cubrecamilla.png',
            'specs'        => json_encode(['Tela: SMS / Laminado', 'Presentaciones: 5 / 10 / 25 / 50', 'Color: Azul / Blanco', 'Gramaje: 10 / 20 / 30 / 45 / 50 gr', 'Ajustes: Elástico / Con Tiras', 'Medidas: 1.90x0.90 / 2.20x0.80 / 2.20x1 / 2.3x1 / 2.4x1.20 / 2x0.80 / 2x0.90 / 2x1 / 1.78x1 / 2.16x0.80 / 2.20x0.70 mts (consultar otras medidas)', 'Autorizado: PM 2521 - 1']),
            'specs_en'     => json_encode(['Fabric: SMS / Laminated', 'Package: 5 / 10 / 25 / 50', 'Color: Blue / White', 'Grammage: 10 / 20 / 30 / 45 / 50 gr', 'Closure: Elastic / Ties', 'Measures: 1.90x0.90 / 2.20x0.80 / 2.20x1 / 2.3x1 / 2.4x1.20 / 2x0.80 / 2x0.90 / 2x1 / 1.78x1 / 2.16x0.80 / 2.20x0.70 mts (inquire for other sizes)', 'Authorized: PM 2521 - 1']),
            'specs_pt'     => json_encode(['Tecido: SMS / Laminado', 'Apresentações: 5 / 10 / 25 / 50', 'Cor: Azul / Branco', 'Gramagem: 10 / 20 / 30 / 45 / 50 gr', 'Ajuste: Elástico / Com Tiras', 'Medidas: 1.90x0.90 / 2.20x0.80 / 2.20x1 / 2.3x1 / 2.4x1.20 / 2x0.80 / 2x0.90 / 2x1 / 1.78x1 / 2.16x0.80 / 2.20x0.70 mts (consultar outros tamanhos)', 'Autorizado: PM 2521 - 1']),
            'orden'        => 18
        ],
        [
            'nombre'       => 'Sábanas Descartables',
            'nombre_en'    => 'Disposable Sheets',
            'nombre_pt'    => 'Lençóis Descartáveis',
            'categoria'    => 'cama',
            'desc_corta'   => 'SMS/Laminado, diversas medidas y gramajes.',
            'desc_corta_en' => 'SMS/Laminated, various sizes and grammages.',
            'desc_corta_pt' => 'SMS/Laminado, vários tamanhos e gramagens.',
            'descripcion'  => 'Sábanas descartables de SMS o Laminado para camillas y camas hospitalarias. Amplia variedad de medidas disponibles.',
            'descripcion_en' => 'Disposable SMS or Laminated sheets for hospital stretchers and beds. Wide variety of sizes available.',
            'descripcion_pt' => 'Lençóis descartáveis de SMS ou Laminado para macas e camas hospitalares. Grande variedade de tamanhos disponíveis.',
            'imagen'       => 'assets/img/catalogo/sabanas.png',
            'specs'        => json_encode(['Tela: SMS / Laminado', 'Presentaciones: 5 / 10 / 25 / 50', 'Color: Azul / Blanco', 'Gramaje: 15 / 20 / 30 / 45 / 50 gr', 'Medidas: 1.8x1.2 / 1x150 / 2.20x0.70 / 2.5x1.5 / 2x0.80 / 2x1 / 2x1.5 / 2x2 / 3x1.5 / 4x2 mts (consultar otras medidas)', 'Autorizado: PM 2521 - 1']),
            'specs_en'     => json_encode(['Fabric: SMS / Laminated', 'Package: 5 / 10 / 25 / 50', 'Color: Blue / White', 'Grammage: 15 / 20 / 30 / 45 / 50 gr', 'Measures: 1.8x1.2 / 1x150 / 2.20x0.70 / 2.5x1.5 / 2x0.80 / 2x1 / 2x1.5 / 2x2 / 3x1.5 / 4x2 mts (inquire for other sizes)', 'Authorized: PM 2521 - 1']),
            'specs_pt'     => json_encode(['Tecido: SMS / Laminado', 'Apresentações: 5 / 10 / 25 / 50', 'Cor: Azul / Branco', 'Gramagem: 15 / 20 / 30 / 45 / 50 gr', 'Medidas: 1.8x1.2 / 1x150 / 2.20x0.70 / 2.5x1.5 / 2x0.80 / 2x1 / 2x1.5 / 2x2 / 3x1.5 / 4x2 mts (consultar outros tamanhos)', 'Autorizado: PM 2521 - 1']),
            'orden'        => 19
        ],
        [
            'nombre'       => 'Campos Quirúrgicos',
            'nombre_en'    => 'Surgical Drape Fields',
            'nombre_pt'    => 'Campos Cirúrgicos',
            'categoria'    => 'cama',
            'desc_corta'   => 'Completos o fenestrados, múltiples medidas.',
            'desc_corta_en' => 'Full or fenestrated, multiple sizes.',
            'desc_corta_pt' => 'Completos ou fenestrados, múltiplos tamanhos.',
            'descripcion'  => 'Campos descartables SMS o Laminado para delimitación de área quirúrgica. Disponibles en formato completo o fenestrado.',
            'descripcion_en' => 'Disposable SMS or Laminated fields for surgical area delimitation. Available in full or fenestrated format.',
            'descripcion_pt' => 'Campos descartáveis SMS ou Laminado para delimitação de área cirúrgica. Disponíveis em formato completo ou fenestrado.',
            'imagen'       => 'assets/img/catalogo/campos.png',
            'specs'        => json_encode(['Tela: SMS / Laminado', 'Presentaciones: 5 / 10 / 25 / 50 / 100', 'Formato: Completo / Fenestrado', 'Color: Azul / Blanco', 'Gramaje: 20 / 30 / 45 / 50 gr', 'Medidas: 40x40 / 40x60 / 50x20 / 50x50 / 50x60 / 60x60 / 60x80 / 70x70 / 75x75 / 80x80 / 100x80 / 100x100 / 100x150 / 120x120 / 150x150 cm (consultar otras medidas)', 'Autorizado: PM 2521 - 1']),
            'specs_en'     => json_encode(['Fabric: SMS / Laminated', 'Package: 5 / 10 / 25 / 50 / 100', 'Format: Full / Fenestrated', 'Color: Blue / White', 'Grammage: 20 / 30 / 45 / 50 gr', 'Measures: 40x40 / 40x60 / 50x20 / 50x50 / 50x60 / 60x60 / 60x80 / 70x70 / 75x75 / 80x80 / 100x80 / 100x100 / 100x150 / 120x120 / 150x150 cm (inquire for other sizes)', 'Authorized: PM 2521 - 1']),
            'specs_pt'     => json_encode(['Tecido: SMS / Laminado', 'Apresentações: 5 / 10 / 25 / 50 / 100', 'Formato: Completo / Fenestrado', 'Cor: Azul / Branco', 'Gramagem: 20 / 30 / 45 / 50 gr', 'Medidas: 40x40 / 40x60 / 50x20 / 50x50 / 50x60 / 60x60 / 60x80 / 70x70 / 75x75 / 80x80 / 100x80 / 100x100 / 100x150 / 120x120 / 150x150 cm (consultar outros tamanhos)', 'Autorizado: PM 2521 - 1']),
            'orden'        => 20
        ],

        // ─────────────────────────────────────────
        // KITS PACIENTE
        // ─────────────────────────────────────────
        [
            'nombre'       => 'Kit Paciente',
            'nombre_en'    => 'Patient Kit',
            'nombre_pt'    => 'Kit Paciente',
            'categoria'    => 'kits',
            'desc_corta'   => 'Camisolín + cofia + botas. Opcional: barbijo.',
            'desc_corta_en' => 'Gown + cap + boots. Optional: face mask.',
            'desc_corta_pt' => 'Avental + touca + botas. Opcional: máscara.',
            'descripcion'  => 'Kit individual para paciente con camisolín, par de botas y cofia. Disponible en modelos Eco, Largo 30g y Premium. Opcional con barbijo.',
            'descripcion_en' => 'Individual patient kit with gown, boots and cap. Available in Eco, Long 30g and Premium models. Optional face mask.',
            'descripcion_pt' => 'Kit individual para paciente com avental, botas e touca. Disponível em modelos Eco, Longo 30g e Premium. Opcional com máscara.',
            'imagen'       => 'assets/img/catalogo/kitpaciente.png',
            'specs'        => json_encode(['Contenido: 1 Camisolín / 1 Par de botas / 1 Cofia / (Opcional) 1 Barbijo', 'Modelos: Kit corto eco (camisolín 15gr+cofia+bota) / Kit largo eco (camisolín 15gr+cofia+bota) / Kit largo 30g (camisolín 30gr+cofia+bota) / Kit largo premium (camisolín 45gr+cofia+bota)', 'Presentaciones: 1 u.', 'Autorizado: PM 2521 - 1']),
            'specs_en'     => json_encode(['Contents: 1 Gown / 1 Pair of boots / 1 Cap / (Optional) 1 Face Mask', 'Models: Short eco kit (gown 15gr+cap+boot) / Long eco kit (gown 15gr+cap+boot) / Long 30g kit (gown 30gr+cap+boot) / Long premium kit (gown 45gr+cap+boot)', 'Package: 1 unit', 'Authorized: PM 2521 - 1']),
            'specs_pt'     => json_encode(['Conteúdo: 1 Avental / 1 Par de botas / 1 Touca / (Opcional) 1 Máscara', 'Modelos: Kit curto eco (avental 15gr+touca+bota) / Kit longo eco (avental 15gr+touca+bota) / Kit longo 30g (avental 30gr+touca+bota) / Kit longo premium (avental 45gr+touca+bota)', 'Apresentações: 1 un.', 'Autorizado: PM 2521 - 1']),
            'orden'        => 21
        ],

        // ─────────────────────────────────────────
        // KITS CATÉTER Y FÍSTULA
        // ─────────────────────────────────────────
        [
            'nombre'       => 'Kit de Catéter MOD 1',
            'nombre_en'    => 'Catheter Kit MOD 1',
            'nombre_pt'    => 'Kit de Cateter MOD 1',
            'categoria'    => 'kits',
            'desc_corta'   => 'Conexión y desconexión con bandeja 105.',
            'desc_corta_en' => 'Connection and disconnection with tray 105.',
            'desc_corta_pt' => 'Conexão e desconexão com bandeja 105.',
            'descripcion'  => 'Kit completo de conexión y desconexión de catéter. Incluye bandejas, guantes estériles, gasas, jeringas, camisolín 30gr, cofias, campos fenestrados y barbijos triple capa.',
            'descripcion_en' => 'Complete catheter connection and disconnection kit. Includes trays, sterile gloves, gauze, syringes, 30gr gown, caps, fenestrated fields and triple-layer masks.',
            'descripcion_pt' => 'Kit completo de conexão e desconexão de cateter. Inclui bandejas, luvas estéreis, gazes, seringas, avental 30gr, toucas, campos fenestrados e máscaras tripla camada.',
            'imagen'       => 'assets/img/catalogo/kitcateter1.png',
            'specs'        => json_encode(['Conexión: 1 Bandeja n°105 / 2 Par guantes estéril n°7 (PM 1440-110) / 2 Gasa estéril 7x7 x2 unid (PM 1057-5) / 1 Aguja 25/8 (PM 1440-79) / 2 Jeringa 10ml (PM 1977-26) / 1 Camisolín 30gr (PM 2521-1) / 2 Cofias (PM 2521-1) / 2 Campo fenestrado 50x50 (PM 2521-1) / 2 Barbijo triple capa (PM 2521-2)', 'Desconexión: 1 Bandeja n°105 / 1 Par guantes estéril n°7 / 2 Gasa estéril 7x7 x2 unid / 2 Jeringa 10ml / 2 Tapón heparina (PM 2106-33) / 1 Aguja 25/8 / 1 Bandeja n°101', 'Autorizado: PM 2521 - 1/2']),
            'specs_en'     => json_encode(['Connection: 1 Tray #105 / 2 Sterile gloves #7 / 2 Sterile gauze 7x7 / 1 Needle 25/8 / 2 Syringe 10ml / 1 Gown 30gr / 2 Caps / 2 Fenestrated Field 50x50 / 2 Triple-layer Mask', 'Disconnection: 1 Tray #105 / 1 Sterile gloves #7 / 2 Sterile gauze 7x7 / 2 Syringe 10ml / 2 Heparin cap / 1 Needle 25/8 / 1 Tray #101', 'Authorized: PM 2521 - 1/2']),
            'specs_pt'     => json_encode(['Conexão: 1 Bandeja n°105 / 2 Par luvas estéreis n°7 / 2 Gaze estéril 7x7 x2 unid / 1 Agulha 25/8 / 2 Seringa 10ml / 1 Avental 30gr / 2 Toucas / 2 Campo fenestrado 50x50 / 2 Máscara tripla camada', 'Desconexão: 1 Bandeja n°105 / 1 Par luvas estéreis n°7 / 2 Gaze estéril 7x7 x2 unid / 2 Seringa 10ml / 2 Tampão heparina / 1 Agulha 25/8 / 1 Bandeja n°101', 'Autorizado: PM 2521 - 1/2']),
            'orden'        => 22
        ],
        [
            'nombre'       => 'Kit de Catéter MOD 2',
            'nombre_en'    => 'Catheter Kit MOD 2',
            'nombre_pt'    => 'Kit de Cateter MOD 2',
            'categoria'    => 'kits',
            'desc_corta'   => 'Conexión y desconexión en bolsa pouch.',
            'desc_corta_en' => 'Connection and disconnection in pouch bag.',
            'desc_corta_pt' => 'Conexão e desconexão em bolsa pouch.',
            'descripcion'  => 'Kit de conexión y desconexión de catéter en formato bolsa pouch. Incluye guantes estériles, jeringas, camisolín 30gr, campo SMS, barbijos y tapones heparina.',
            'descripcion_en' => 'Catheter connection and disconnection kit in pouch bag format. Includes sterile gloves, syringes, 30gr gown, SMS field, masks and heparin caps.',
            'descripcion_pt' => 'Kit de conexão e desconexão de cateter em formato bolsa pouch. Inclui luvas estéreis, seringas, avental 30gr, campo SMS, máscaras e tampões heparina.',
            'imagen'       => 'assets/img/catalogo/kitcateter2.png',
            'specs'        => json_encode(['Conexión: 1 Bolsa pouch 200mm (PM 1197-2) / 3 Par guantes estéril n°7 (PM 1440-110) / 2 Jeringa 5ml (PM 2178-5) / 1 Camisolín 30gr (PM 2521-1) / 1 Campo 50x50 SMS (PM 2521-1) / 2 Barbijo triple capa (PM 2521-2)', 'Desconexión: 1 Bolsa pouch 200mm (PM 1197-2) / 2 Par guantes estéril n°7 / 2 Apósito 6x7 (PM 1440-147) / 2 Tapones heparina (PM 2106-33) / 1 Campo 50x50 SMS / 1 Par de manoplas desc.', 'Autorizado: PM 2521 - 1/2']),
            'specs_en'     => json_encode(['Connection: 1 Pouch bag 200mm / 3 Sterile gloves #7 / 2 Syringe 5ml / 1 Gown 30gr / 1 Field 50x50 SMS / 2 Triple-layer Mask', 'Disconnection: 1 Pouch bag 200mm / 2 Sterile gloves #7 / 2 Dressing 6x7 / 2 Heparin caps / 1 Field 50x50 SMS / 1 Disposable mittens pair', 'Authorized: PM 2521 - 1/2']),
            'specs_pt'     => json_encode(['Conexão: 1 Bolsa pouch 200mm / 3 Par luvas estéreis n°7 / 2 Seringa 5ml / 1 Avental 30gr / 1 Campo 50x50 SMS / 2 Máscara tripla camada', 'Desconexão: 1 Bolsa pouch 200mm / 2 Par luvas estéreis n°7 / 2 Curativo 6x7 / 2 Tampões heparina / 1 Campo 50x50 SMS / 1 Par de manoplas desc.', 'Autorizado: PM 2521 - 1/2']),
            'orden'        => 23
        ],
        [
            'nombre'       => 'Kit de Catéter MOD 3',
            'nombre_en'    => 'Catheter Kit MOD 3',
            'nombre_pt'    => 'Kit de Cateter MOD 3',
            'categoria'    => 'kits',
            'desc_corta'   => 'Camisolín 45gr, 2 campos fenestrados.',
            'desc_corta_en' => 'Gown 45gr, 2 fenestrated fields.',
            'desc_corta_pt' => 'Avental 45gr, 2 campos fenestrados.',
            'descripcion'  => 'Kit completo de conexión y desconexión de catéter con camisolín de mayor gramaje (45gr). Incluye gasas extras, cofias, campos fenestrados y barbijos.',
            'descripcion_en' => 'Complete catheter kit with heavier gown (45gr). Includes extra gauze, caps, fenestrated fields and masks.',
            'descripcion_pt' => 'Kit completo de conexão e desconexão de cateter com avental de maior gramagem (45gr). Inclui gazes extras, toucas, campos fenestrados e máscaras.',
            'imagen'       => 'assets/img/catalogo/kitcateter3.png',
            'specs'        => json_encode(['Conexión: 1 Bandeja n°105 / 2 Par guantes estéril n°7 (PM 1440-110) / 4 Gasa estéril 7x7 x2 unid (PM 1057-5) / 2 Jeringa 5ml (PM 2178-5) / 1 Camisolín 45gr (PM 2521-1) / 2 Cofias (PM 2521-1) / 1 Campo fenestrado 50x50 (PM 2521-1) / 1 Campo 50x50 (PM 2521-1) / 2 Barbijo triple capa (PM 2521-2)', 'Desconexión: 1 Bandeja n°105 / 1 Par guantes estéril n°7 / 2 Gasa estéril 7x7 x2 unid / 1 Jeringa 10ml (PM 1977-26) / 2 Tapones (PM 2106-33) / 1 Aguja 25/8 (PM 1440-79) / 1 Bandeja n°101', 'Autorizado: PM 2521 - 1/2']),
            'specs_en'     => json_encode(['Connection: 1 Tray #105 / 2 Sterile gloves #7 / 4 Sterile gauze 7x7 / 2 Syringe 5ml / 1 Gown 45gr / 2 Caps / 1 Fenestrated Field 50x50 / 1 Field 50x50 / 2 Triple-layer Mask', 'Disconnection: 1 Tray #105 / 1 Sterile gloves #7 / 2 Sterile gauze 7x7 / 1 Syringe 10ml / 2 Caps / 1 Needle 25/8 / 1 Tray #101', 'Authorized: PM 2521 - 1/2']),
            'specs_pt'     => json_encode(['Conexão: 1 Bandeja n°105 / 2 Par luvas estéreis n°7 / 4 Gaze estéril 7x7 x2 unid / 2 Seringa 5ml / 1 Avental 45gr / 2 Toucas / 1 Campo fenestrado 50x50 / 1 Campo 50x50 / 2 Máscara tripla camada', 'Desconexão: 1 Bandeja n°105 / 1 Par luvas estéreis n°7 / 2 Gaze estéril 7x7 x2 unid / 1 Seringa 10ml / 2 Tampões / 1 Agulha 25/8 / 1 Bandeja n°101', 'Autorizado: PM 2521 - 1/2']),
            'orden'        => 24
        ],
        [
            'nombre'       => 'Kit de Catéter MOD 4',
            'nombre_en'    => 'Catheter Kit MOD 4',
            'nombre_pt'    => 'Kit de Cateter MOD 4',
            'categoria'    => 'kits',
            'desc_corta'   => 'Sin camisolín, 2 campos fenestrados.',
            'desc_corta_en' => 'No gown, 2 fenestrated fields.',
            'desc_corta_pt' => 'Sem avental, 2 campos fenestrados.',
            'descripcion'  => 'Kit de conexión y desconexión de catéter sin camisolín. Incluye bandejas, campos fenestrados, gasas, agujas y jeringas 10ml y 5ml.',
            'descripcion_en' => 'Catheter connection and disconnection kit without gown. Includes trays, fenestrated fields, gauze, needles and 10ml and 5ml syringes.',
            'descripcion_pt' => 'Kit de conexão e desconexão de cateter sem avental. Inclui bandejas, campos fenestrados, gazes, agulhas e seringas 10ml e 5ml.',
            'imagen'       => 'assets/img/catalogo/kitcateter4.png',
            'specs'        => json_encode(['Conexión: 1 Bandeja n°105 / 2 Campo fenestrado 50x50 (PM 2521-1) / 3 Gasa estéril 7x7 x2 unid (PM 1057-5) / 1 Aguja 25/8 (PM 1440-79) / 2 Jeringa 10ml (PM 1977-26) / 1 Jeringa 5ml (PM 2178-5) / 1 Campo 50x50 (PM 2521-1)', 'Desconexión: 1 Bandeja n°105 / 3 Par guantes estéril n°7 (PM 1440-110) / 3 Gasa estéril 7x7 x2 unid / 2 Jeringa 10ml / 1 Jeringa 5ml / 2 Tapones (PM 2106-33) / 1 Aguja 25/8 / 2 Bandeja n°101', 'Autorizado: PM 2521 - 1']),
            'specs_en'     => json_encode(['Connection: 1 Tray #105 / 2 Fenestrated Field 50x50 / 3 Sterile gauze 7x7 / 1 Needle 25/8 / 2 Syringe 10ml / 1 Syringe 5ml / 1 Field 50x50', 'Disconnection: 1 Tray #105 / 3 Sterile gloves #7 / 3 Sterile gauze 7x7 / 2 Syringe 10ml / 1 Syringe 5ml / 2 Caps / 1 Needle 25/8 / 2 Tray #101', 'Authorized: PM 2521 - 1']),
            'specs_pt'     => json_encode(['Conexão: 1 Bandeja n°105 / 2 Campo fenestrado 50x50 / 3 Gaze estéril 7x7 x2 unid / 1 Agulha 25/8 / 2 Seringa 10ml / 1 Seringa 5ml / 1 Campo 50x50', 'Desconexão: 1 Bandeja n°105 / 3 Par luvas estéreis n°7 / 3 Gaze estéril 7x7 x2 unid / 2 Seringa 10ml / 1 Seringa 5ml / 2 Tampões / 1 Agulha 25/8 / 2 Bandeja n°101', 'Autorizado: PM 2521 - 1']),
            'orden'        => 25
        ],
        [
            'nombre'       => 'Kit de Catéter MOD 5',
            'nombre_en'    => 'Catheter Kit MOD 5',
            'nombre_pt'    => 'Kit de Cateter MOD 5',
            'categoria'    => 'kits',
            'desc_corta'   => 'Similar MOD 1 con aguja en conexión.',
            'desc_corta_en' => 'Similar to MOD 1 with needle on connection.',
            'desc_corta_pt' => 'Similar ao MOD 1 com agulha na conexão.',
            'descripcion'  => 'Kit de conexión y desconexión de catéter. Configuración similar al MOD 1 con aguja incluida en la etapa de conexión.',
            'descripcion_en' => 'Catheter connection and disconnection kit. Similar configuration to MOD 1 with needle included in the connection stage.',
            'descripcion_pt' => 'Kit de conexão e desconexão de cateter. Configuração similar ao MOD 1 com agulha incluída na etapa de conexão.',
            'imagen'       => 'assets/img/catalogo/kitcateter5.png',
            'specs'        => json_encode(['Conexión: 1 Bandeja n°105 / 2 Par guantes estéril n°7 (PM 1440-110) / 2 Gasa estéril 7x7 x2 unid (PM 1057-5) / 1 Aguja 25/8 (PM 1440-79) / 2 Jeringa 10ml (PM 1977-26) / 1 Camisolín 30gr (PM 2521-1) / 2 Cofias (PM 2521-1) / 2 Campo fenestrado 50x50 (PM 2521-1) / 2 Barbijo triple capa (PM 2521-2)', 'Desconexión: 1 Bandeja n°105 / 1 Par guantes estéril n°7 / 2 Gasa estéril 7x7 x2 unid / 2 Jeringa 10ml / 2 Tapones (PM 2106-33) / 1 Aguja 25/8 / 1 Bandeja n°101', 'Autorizado: PM 2521 - 1/2']),
            'specs_en'     => json_encode(['Connection: 1 Tray #105 / 2 Sterile gloves #7 / 2 Sterile gauze 7x7 / 1 Needle 25/8 / 2 Syringe 10ml / 1 Gown 30gr / 2 Caps / 2 Fenestrated Field 50x50 / 2 Triple-layer Mask', 'Disconnection: 1 Tray #105 / 1 Sterile gloves #7 / 2 Sterile gauze 7x7 / 2 Syringe 10ml / 2 Caps / 1 Needle 25/8 / 1 Tray #101', 'Authorized: PM 2521 - 1/2']),
            'specs_pt'     => json_encode(['Conexão: 1 Bandeja n°105 / 2 Par luvas estéreis n°7 / 2 Gaze estéril 7x7 x2 unid / 1 Agulha 25/8 / 2 Seringa 10ml / 1 Avental 30gr / 2 Toucas / 2 Campo fenestrado 50x50 / 2 Máscara tripla camada', 'Desconexão: 1 Bandeja n°105 / 1 Par luvas estéreis n°7 / 2 Gaze estéril 7x7 x2 unid / 2 Seringa 10ml / 2 Tampões / 1 Agulha 25/8 / 1 Bandeja n°101', 'Autorizado: PM 2521 - 1/2']),
            'orden'        => 26
        ],
        [
            'nombre'       => 'Kit de Catéter MOD 6',
            'nombre_en'    => 'Catheter Kit MOD 6',
            'nombre_pt'    => 'Kit de Cateter MOD 6',
            'categoria'    => 'kits',
            'desc_corta'   => 'Solo conexión, campo fenestrado 40x60.',
            'desc_corta_en' => 'Connection only, 40x60 fenestrated field.',
            'desc_corta_pt' => 'Somente conexão, campo fenestrado 40x60.',
            'descripcion'  => 'Kit de conexión de catéter simplificado. Incluye bandeja, guantes, gasas, aguja, apósito, jeringa y 2 campos fenestrados 40x60.',
            'descripcion_en' => 'Simplified catheter connection kit. Includes tray, gloves, gauze, needle, dressing, syringe and 2 fenestrated fields 40x60.',
            'descripcion_pt' => 'Kit de conexão de cateter simplificado. Inclui bandeja, luvas, gazes, agulha, curativo, seringa e 2 campos fenestrados 40x60.',
            'imagen'       => 'assets/img/catalogo/kitcateter6.png',
            'specs'        => json_encode(['Conexión: 1 Bandeja n°105 (PM 1440-110) / 1 Par guantes estéril n°7 (PM 1057-5) / 2 Gasa estéril 7x7 x2 unid (PM 1440-79) / 1 Aguja 25/8 (PM 1977-26) / 2 Apósito 6x7 (PM 1440-147) / 1 Jeringa 10ml (PM 2521-1) / 2 Campo fenestrado 40x60 (PM 2521-2)', 'Solo kit de conexión (sin desconexión)', 'Autorizado: PM 2521 - 1/2']),
            'specs_en'     => json_encode(['Connection: 1 Tray #105 / 1 Sterile gloves #7 / 2 Sterile gauze 7x7 / 1 Needle 25/8 / 2 Dressing 6x7 / 1 Syringe 10ml / 2 Fenestrated Field 40x60', 'Connection kit only (no disconnection)', 'Authorized: PM 2521 - 1/2']),
            'specs_pt'     => json_encode(['Conexão: 1 Bandeja n°105 / 1 Par luvas estéreis n°7 / 2 Gaze estéril 7x7 x2 unid / 1 Agulha 25/8 / 2 Curativo 6x7 / 1 Seringa 10ml / 2 Campo fenestrado 40x60', 'Kit somente de conexão (sem desconexão)', 'Autorizado: PM 2521 - 1/2']),
            'orden'        => 27
        ],
        [
            'nombre'       => 'Kit de Fístula MOD 1',
            'nombre_en'    => 'Fistula Kit MOD 1',
            'nombre_pt'    => 'Kit de Fístula MOD 1',
            'categoria'    => 'kits',
            'desc_corta'   => 'Conexión/desconexión con aguja de fístula n°16.',
            'desc_corta_en' => 'Connection/disconnection with fistula needle #16.',
            'desc_corta_pt' => 'Conexão/desconexão com agulha de fístula n°16.',
            'descripcion'  => 'Kit de conexión y desconexión de fístula. Incluye bandeja, gasas estériles, agujas, jeringa 5ml, campos SMS y aguja de fístula n°16.',
            'descripcion_en' => 'Fistula connection and disconnection kit. Includes tray, sterile gauze, needles, 5ml syringe, SMS fields and fistula needle #16.',
            'descripcion_pt' => 'Kit de conexão e desconexão de fístula. Inclui bandeja, gazes estéreis, agulhas, seringa 5ml, campos SMS e agulha de fístula n°16.',
            'imagen'       => 'assets/img/catalogo/kitfistula1.png',
            'specs'        => json_encode(['Conexión / Desconexión: 1 Bandeja n°105 (PM 1440-110) / 4 Gasa estéril 7x7 x2 unid (PM 1440-79) / 1 Aguja 25/8 (PM 1977-26) / 1 Jeringa 5ml (PM 2178-5) / 2 Campo SMS 50x50 (PM 2521-2) / 1 Aguja fístula n°16 (PM 889-03) / 1 Bandeja n°102', 'Autorizado: PM 2521 - 1/2']),
            'specs_en'     => json_encode(['Connection / Disconnection: 1 Tray #105 / 4 Sterile gauze 7x7 / 1 Needle 25/8 / 1 Syringe 5ml / 2 SMS Field 50x50 / 1 Fistula needle #16 / 1 Tray #102', 'Authorized: PM 2521 - 1/2']),
            'specs_pt'     => json_encode(['Conexão / Desconexão: 1 Bandeja n°105 / 4 Gaze estéril 7x7 x2 unid / 1 Agulha 25/8 / 1 Seringa 5ml / 2 Campo SMS 50x50 / 1 Agulha fístula n°16 / 1 Bandeja n°102', 'Autorizado: PM 2521 - 1/2']),
            'orden'        => 28
        ],
    ];

    $stmt = $db->prepare("INSERT INTO productos (
        nombre, nombre_en, nombre_pt,
        categoria,
        desc_corta, desc_corta_en, desc_corta_pt,
        descripcion, descripcion_en, descripcion_pt,
        imagen, specs, specs_en, specs_pt,
        orden
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($productos as $p) {
        $stmt->execute([
            $p['nombre'],
            $p['nombre_en'],
            $p['nombre_pt'],
            $p['categoria'],
            $p['desc_corta'],
            $p['desc_corta_en'],
            $p['desc_corta_pt'],
            $p['descripcion'],
            $p['descripcion_en'],
            $p['descripcion_pt'],
            $p['imagen'],
            $p['specs'],
            $p['specs_en'],
            $p['specs_pt'],
            $p['orden']
        ]);
    }

    echo "✅ Carga masiva finalizada: " . count($productos) . " productos insertados.";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
