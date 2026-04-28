<?php
require_once __DIR__ . '/db/database.php';
$db = getDB();

// Obtener todas las noticias activas
$stmt = $db->query('SELECT * FROM noticias WHERE activo = 1 ORDER BY fecha DESC');
$noticias = $stmt->fetchAll();

// Si viene un ID por GET, buscamos esa noticia específica para destacarla
$featured_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$featured_news = null;

if ($featured_id) {
    foreach ($noticias as $n) {
        if ($n['id'] === $featured_id) {
            $featured_news = $n;
            break;
        }
    }
}

// Si no hay ID o no se encontró, la primera es la destacada
if (!$featured_news && !empty($noticias)) {
    $featured_news = $noticias[0];
}
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>DPC – Novedades y Actualidad Médica</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              primary: "#1A4F9C",
              accent: "#D42B2B",
              "dark-navy": "#0B1A2E",
              "navy-dark": "#0B1A2E",
              "background-light": "#FFFFFF",
            },
            fontFamily: { display: ["Public Sans"] },
          },
        },
      };
    </script>
    <style type="text/tailwindcss">
      @layer components {
        .nav-scrolled {
          background-color: rgba(255, 255, 255, 0.97) !important;
          border-bottom: 1px solid rgba(26, 79, 156, 0.08);
          @apply shadow-sm;
        }
        .nav-scrolled a, .nav-scrolled span, .nav-scrolled button { color: #0b1a2e !important; }
        .nav-scrolled .nav-cta { color: #ffffff !important; }
        .glass-v2 {
          background: rgba(255, 255, 255, 0.4);
          backdrop-filter: blur(20px);
          @apply border border-white/40 shadow-[0_8px_32px_0_rgba(31,38,135,0.07)];
        }
        .bg-watermark {
          position: absolute;
          font-size: 25vw;
          font-weight: 900;
          color: rgba(26, 79, 156, 0.02);
          pointer-events: none;
          user-select: none;
          z-index: 0;
          white-space: nowrap;
        }
        /* Connection Line */
        .connection-line {
          position: fixed;
          left: 40px;
          top: 0;
          bottom: 0;
          width: 1px;
          background: linear-gradient(to bottom, transparent, rgba(26, 79, 156, 0.1) 10%, rgba(26, 79, 156, 0.1) 90%, transparent);
          z-index: 5;
          pointer-events: none;
        }
      }
    </style>
  </head>
  <body class="bg-background-light text-slate-900 overflow-x-hidden">
    <div class="connection-line"></div>
    <nav class="fixed top-0 w-full z-50 transition-all duration-500 px-6 py-3 flex items-center justify-between bg-dark-navy" id="main-nav">
      <div class="flex items-center gap-3">
        <a href="index.php"><img src="assets/img/logo.png" alt="DPC Logo" class="h-14 w-auto" /></a>
      </div>
      <div class="hidden md:flex items-center gap-8 text-white">
        <a class="text-sm font-semibold tracking-wide hover:text-white/70 transition-colors" href="index.php" data-i18n="nav_home">INICIO</a>
        <a class="text-sm font-semibold tracking-wide hover:text-white/70 transition-colors" href="nosotros.html" data-i18n="nav_about">NOSOTROS</a>
        <a class="text-sm font-semibold tracking-wide hover:text-white/70 transition-colors" href="productos.php" data-i18n="nav_products">PRODUCTOS</a>
        <a class="text-sm font-semibold tracking-wide hover:text-white/70 transition-colors border-b-2 border-accent" href="noticias.php" data-i18n="nav_news">NOTICIAS</a>
        <a class="text-sm font-semibold tracking-wide hover:text-white/70 transition-colors" href="contacto.html" data-i18n="nav_contact">CONTACTO</a>
        
          <div class="flex items-center gap-2.5 px-4 border-l border-white/10 ml-2">
            <button onclick="openGlobalSearch()" class="flex items-center text-white hover:text-white/70 transition-colors mr-2" title="Buscar">
              <span class="material-symbols-outlined text-xl">search</span>
            </button>
            <a href="#" onclick="event.preventDefault(); i18n.load('es');" title="Español" class="flex" data-i18n-title="nav_lang_es"><img src="https://flagcdn.com/w40/es.png" class="w-5 h-5 rounded-full object-cover border border-white/20 hover:scale-110 transition-transform shadow-sm" alt="ES"></a>
            <a href="#" onclick="event.preventDefault(); i18n.load('en');" title="English" class="flex" data-i18n-title="nav_lang_en"><img src="https://flagcdn.com/w40/us.png" class="w-5 h-5 rounded-full object-cover border border-white/20 hover:scale-110 transition-transform shadow-sm" alt="EN"></a>
            <a href="#" onclick="event.preventDefault(); i18n.load('pt');" title="Português" class="flex" data-i18n-title="nav_lang_pt"><img src="https://flagcdn.com/w40/br.png" class="w-5 h-5 rounded-full object-cover border border-white/20 hover:scale-110 transition-transform shadow-sm" alt="PT"></a>
          </div>
          
          <a href="assets/pdf/catalogo.pdf" target="_blank" class="nav-cta bg-primary hover:bg-[#153f7a] text-white px-6 py-2.5 rounded-full font-semibold text-sm transition-all shadow-md shadow-primary/20" data-i18n="nav_catalog">CATÁLOGO</a>

          <a href="admin/login.php" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition-all border border-white/10">
            <span class="material-symbols-outlined text-sm">login</span>
            INGRESAR
          </a>
      </div>
    </nav>

    <main class="pt-[80px]">
      <!-- Hero Section -->
      <section class="relative h-[300px] w-full overflow-hidden bg-navy-dark mb-12">
        <div class="absolute inset-0 opacity-40 bg-cover bg-center" style="background-image: url('assets/img/Hospitalaria.webp');"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-navy-dark via-navy-dark/80 to-transparent"></div>
        <div class="relative mx-auto flex h-full max-w-7xl flex-col justify-center px-6 md:px-20">
          <h1 class="text-4xl md:text-6xl font-black text-white mb-6 leading-tight max-w-2xl" data-i18n="news_hero_title">Actualidad Médica</h1>
          <p class="text-lg md:text-xl text-slate-300 max-w-2xl font-light" data-i18n="news_hero_desc">Explorando las últimas innovaciones y el futuro del sector salud.</p>
        </div>
      </section>

      <div class="max-w-7xl mx-auto px-6 lg:px-20">
        <?php if ($featured_news): ?>
        <!-- Featured Post -->
        <section class="mb-16 relative">
          <div class="bg-watermark top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 -rotate-12">FEATURED</div>
          <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-2 relative z-10">
            <span class="material-symbols-outlined text-primary">star</span>
            <span data-i18n="news_ui_featured">Noticia Destacada</span>
          </h2>
          <div class="group relative grid grid-cols-1 lg:grid-cols-2 gap-0 overflow-hidden rounded-[2.5rem] glass-v2 shadow-2xl z-10">
            <div class="relative h-64 lg:h-[450px] overflow-hidden">
              <img src="<?= htmlspecialchars($featured_news['imagen']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="News Image" />
            </div>
            <div class="p-8 md:p-12 flex flex-col justify-center">
              <div class="flex items-center gap-3 text-sm text-primary font-bold mb-4 uppercase tracking-widest">
                <span>DPC NEWS</span>
                <span class="w-1 h-1 rounded-full bg-slate-400"></span>
                <span class="text-slate-500 font-normal"><?= date('d M, Y', strtotime($featured_news['fecha'])) ?></span>
              </div>
              <h3 class="text-3xl md:text-4xl font-black text-dark-navy mb-6 leading-tight"><?= htmlspecialchars($featured_news['titulo']) ?></h3>
              <p class="text-slate-600 text-lg leading-relaxed mb-8"><?= htmlspecialchars($featured_news['copete'] ?: $featured_news['cuerpo']) ?></p>
            </div>
          </div>
        </section>
        <?php endif; ?>

        <!-- News Feed Grid -->
        <section class="mb-24">
          <h2 class="text-2xl font-bold text-slate-900 mb-8 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">grid_view</span>
            <span data-i18n="news_ui_title">Todas las Novedades</span>
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php foreach ($noticias as $n): ?>
            <article onclick="window.location.href='noticias.php?id=<?= $n['id'] ?>'" class="flex flex-col rounded-3xl overflow-hidden glass-v2 hover:shadow-2xl transition-all hover:-translate-y-2 group cursor-pointer h-full">
              <div class="h-56 overflow-hidden relative">
                <img src="<?= htmlspecialchars($n['imagen']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="News Image" />
                <div class="absolute bottom-4 left-4"><span class="bg-primary/90 backdrop-blur-md text-white px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-widest">NOVEDAD</span></div>
              </div>
              <div class="p-8 flex flex-col flex-1">
                <p class="text-xs text-slate-400 font-bold mb-3 uppercase"><?= date('M d, Y', strtotime($n['fecha'])) ?></p>
                <h4 class="text-xl font-bold text-dark-navy mb-4 group-hover:text-primary transition-colors leading-tight"><?= htmlspecialchars($n['titulo']) ?></h4>
                <p class="text-sm text-slate-500 line-clamp-3 mb-6 font-light leading-relaxed"><?= htmlspecialchars($n['copete']) ?></p>
                <span class="mt-auto text-primary text-xs font-black uppercase tracking-widest flex items-center gap-1 group-hover:gap-2 transition-all">
                  Leer Más <span class="material-symbols-outlined text-sm">chevron_right</span>
                </span>
              </div>
            </article>
            <?php endforeach; ?>
          </div>
        </section>
      </div>
    </main>

    <footer class="bg-dark-navy text-white pt-16 pb-12">
      <div class="container mx-auto px-6 text-center">
        <img src="assets/img/logo.png" alt="DPC Logo" class="h-12 mx-auto mb-8" />
        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">© 2026 DPC - Fábrica de Ropa Hospitalaria Descartable</p>
      </div>
    </footer>

    <script src="assets/js/translations.js"></script>
    <script src="assets/js/i18n.js"></script>
    <script>
      window.addEventListener("scroll", function () {
        const nav = document.getElementById("main-nav");
        nav.classList.toggle("nav-scrolled", window.scrollY > 50);
      });
    </script>
    <!-- Global Search Overlay -->
    <div id="search-overlay" class="fixed inset-0 z-[100] hidden items-start justify-center bg-navy-dark/95 backdrop-blur-md p-4 pt-20 transition-all duration-300">
      <div class="relative w-full max-w-3xl animate-fade-in">
        <button onclick="closeGlobalSearch()" class="absolute -top-12 right-0 text-white/60 hover:text-white flex items-center gap-2 text-sm uppercase font-bold tracking-widest">
          Cerrar <span class="material-symbols-outlined">close</span>
        </button>
        <div class="relative">
          <span class="absolute left-6 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-3xl">search</span>
          <input type="text" id="global-search-input" placeholder="¿Qué estás buscando? (ej: barbijos, misión, contacto...)" 
            class="w-full bg-white/10 border-2 border-white/10 rounded-3xl py-6 pl-16 pr-8 text-white text-xl focus:border-primary focus:ring-0 transition-all outline-none"
            oninput="handleGlobalSearch(this.value)">
        </div>
        <div id="search-results" class="mt-8 grid grid-cols-1 gap-4 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar"></div>
      </div>
    </div>

    <script>
      const siteMap = [
        { title: "Nuestros Productos", category: "Catálogo", keywords: ["barbijo", "camisolin", "cofia", "guante", "kit", "insumos", "quirurgico", "productos"], url: "productos.php" },
        { title: "Nuestra Historia", category: "Nosotros", keywords: ["mision", "vision", "historia", "nosotros", "quienes somos", "tucuman", "fabrica"], url: "nosotros.html" },
        { title: "Habilitaciones ANMAT", category: "Calidad", keywords: ["anmat", "certificacion", "habilitacion", "seguridad", "calidad"], url: "nosotros.html#certificacion" },
        { title: "Últimas Noticias", category: "Actualidad", keywords: ["novedades", "noticias", "blog", "actualidad", "eventos"], url: "noticias.php" },
        { title: "Contacto y Ubicación", category: "Ayuda", keywords: ["contacto", "telefono", "email", "donde estamos", "mapa", "direccion", "whatsapp"], url: "contacto.html" }
      ];

      function openGlobalSearch() {
        const overlay = document.getElementById('search-overlay');
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        setTimeout(() => document.getElementById('global-search-input').focus(), 100);
        document.body.style.overflow = 'hidden';
      }

      function closeGlobalSearch() {
        const overlay = document.getElementById('search-overlay');
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
        document.body.style.overflow = '';
      }

      function handleGlobalSearch(query) {
        const resultsContainer = document.getElementById('search-results');
        if (query.length < 2) {
          resultsContainer.innerHTML = '';
          return;
        }

        const filtered = siteMap.filter(item => 
          item.title.toLowerCase().includes(query.toLowerCase()) || 
          item.keywords.some(k => k.includes(query.toLowerCase()))
        );

        resultsContainer.innerHTML = filtered.map(item => `
          <a href="${item.url}" class="group flex items-center justify-between p-6 bg-white/5 hover:bg-primary/20 border border-white/10 rounded-2xl transition-all">
            <div class="flex flex-col">
              <span class="text-[10px] font-black uppercase tracking-widest text-primary mb-1">${item.category}</span>
              <span class="text-white text-lg font-bold group-hover:text-primary transition-colors">${item.title}</span>
            </div>
            <span class="material-symbols-outlined text-white/20 group-hover:text-primary transition-all">arrow_forward</span>
          </a>
        `).join('');

        if (filtered.length === 0) {
          resultsContainer.innerHTML = '<p class="text-center text-slate-500 py-10">No encontramos resultados para tu búsqueda.</p>';
        }
      }

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeGlobalSearch();
      });
    </script>
  </body>
</html>
