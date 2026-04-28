<?php
require_once __DIR__ . '/db/database.php';
$db = getDB();

// Obtener las últimas 3 noticias
$stmt = $db->query('SELECT * FROM noticias WHERE activo = 1 ORDER BY fecha DESC LIMIT 3');
$noticias = $stmt->fetchAll();
?>
<!doctype html>
<html class="scroll-smooth" lang="es">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>DPC – Fábrica de Ropa Hospitalaria Descartable</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;900&amp;family=Bebas+Neue&amp;display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
      .swiper-pagination-bullet-active { background-color: #0c1a30 !important; }
    </style>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              primary: "#1A4F9C",
              accent: "#D42B2B",
              "dark-navy": "#0B1A2E",
              "deep-blue": "#112240",
              "light-blue-gray": "#F8FAFC",
              "background-light": "#FFFFFF",
              "background-dark": "#0B1A2E",
            },
            fontFamily: {
              display: ["Public Sans", "sans-serif"],
              title: ["Bebas Neue", "sans-serif"],
            },
            borderRadius: {
              DEFAULT: "0.25rem",
              lg: "0.5rem",
              xl: "0.75rem",
              full: "9999px",
            },
          },
        },
      };
    </script>
    <style type="text/tailwindcss">
      @layer components {
        .dot-grid {
          background-image: radial-gradient(
            rgba(26, 79, 156, 0.04) 1px,
            transparent 1px
          );
          background-size: 24px 24px;
        }
        .glass {
          background: rgba(255, 255, 255, 0.9);
          backdrop-filter: blur(12px);
          border: 1px solid rgba(26, 79, 156, 0.08);
        }
        .nav-scrolled {
          background-color: rgba(255, 255, 255, 0.97) !important;
          border-bottom: 1px solid rgba(26, 79, 156, 0.08);
          @apply shadow-sm;
        }
        .nav-scrolled a,
        .nav-scrolled span,
        .nav-scrolled button {
          color: #0b1a2e !important;
        }
        .nav-scrolled .nav-cta {
          color: #ffffff !important;
        }
        .parallax-bg {
          background-attachment: fixed;
          background-position: center;
          background-repeat: no-repeat;
          background-size: cover;
        }
        .watermark-text {
          font-size: 35vw;
          line-height: 0.8;
          font-weight: 900;
          letter-spacing: -0.05em;
          background: linear-gradient(180deg, #1a4f9c 0%, transparent 100%);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          opacity: 0.04;
          user-select: none;
          pointer-events: none;
        }
        .hero-slide {
          @apply absolute inset-0 transition-opacity duration-1000 opacity-0;
        }
        .hero-slide.active {
          @apply opacity-100;
        }
        @keyframes dpcLayerMove {
          0%, 100% { transform: translateY(0) scale(1) rotate(0deg); }
          50% { transform: translateY(-15px) scale(1.03) rotate(1deg); }
        }
        .animate-dpc-move {
          animation: dpcLayerMove 5s ease-in-out infinite;
        }
        /* Dropdown nav */
        .nav-dropdown {
          min-width: 200px;
          top: calc(100% + 12px);
        }
        .nav-megamenu {
          min-width: 520px;
          top: calc(100% + 12px);
          left: 50%;
          transform: translateX(-50%);
        }
        @keyframes customFloat {
          0%, 100% { transform: translateY(0) rotate(0); }
          50% { transform: translateY(-20px) rotate(5deg); }
        }
        .animate-float-slow {
          animation: customFloat 8s ease-in-out infinite;
        }
        .glass-v2 {
          background: rgba(255, 255, 255, 0.4);
          backdrop-filter: blur(20px);
          @apply border border-white/40 shadow-[0_8px_32px_0_rgba(31,38,135,0.07)];
        }
        /* Mesh Gradient Background */
        .mesh-bg {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          z-index: -1;
          background-color: #ffffff;
          background-image: 
            radial-gradient(at 0% 0%, rgba(26, 79, 156, 0.05) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(212, 43, 43, 0.02) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(26, 79, 156, 0.05) 0px, transparent 50%),
            radial-gradient(at 0% 100%, rgba(212, 43, 43, 0.02) 0px, transparent 50%);
        }
        /* Continuous Connection Line */
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
        .connection-line::after {
          content: '';
          position: absolute;
          top: 0;
          left: -2px;
          width: 5px;
          height: 5px;
          background: #1A4F9C;
          border-radius: 50%;
          animation: slideDown 20s linear infinite;
          opacity: 0.3;
        }
        @keyframes slideDown {
          0% { top: 0; }
          100% { top: 100%; }
        }
        /* Giant Watermark */
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
        /* Layered Wave Animation */
        .wave-layer {
          animation: waveMove 15s ease-in-out infinite;
        }
        .wave-layer-slow {
          animation: waveMove 25s ease-in-out infinite;
        }
        @keyframes waveMove {
          0%, 100% { transform: translateX(0); }
          50% { transform: translateX(-2%); }
        }
      }
    </style>
  </head>
  <body
    class="font-display bg-background-light text-slate-900 overflow-x-hidden"
  >
    <div class="mesh-bg"></div>
    <div class="connection-line"></div>
    <nav
      class="fixed top-0 w-full z-50 transition-all duration-500 px-6 py-3 flex items-center justify-between"
      id="main-nav"
    >
      <div class="flex items-center gap-3">
        <img src="assets/img/logo.png" alt="DPC Logo" class="h-14 w-auto" />
      </div>
      <div class="hidden md:flex items-center gap-8">
        <a class="text-sm font-semibold tracking-wide text-white hover:text-white/70 transition-colors" href="index.php" data-i18n="nav_home">INICIO</a>
        <div class="relative group flex items-center">
          <a href="nosotros.html" class="text-sm font-semibold tracking-wide text-white hover:text-white/70 transition-colors uppercase" data-i18n="nav_about">NOSOTROS</a>
          <button class="flex items-center text-white hover:text-white/70 transition-colors ml-1">
            <span class="material-symbols-outlined text-base" style="font-size:16px">expand_more</span>
          </button>
          <div class="nav-dropdown absolute invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 bg-white rounded-2xl shadow-2xl shadow-slate-200/80 border border-slate-100 py-2 z-50">
            <a href="nosotros.html#historia" class="flex items-center gap-3 px-5 py-3 text-sm text-slate-600 hover:text-primary hover:bg-slate-50 transition-colors" data-i18n="nav_about_history">
              <span class="material-symbols-outlined text-primary" style="font-size:18px">history_edu</span>Historia
            </a>
            <a href="nosotros.html#certificacion" class="flex items-center gap-3 px-5 py-3 text-sm text-slate-600 hover:text-primary hover:bg-slate-50 transition-colors" data-i18n="nav_about_certification">
              <span class="material-symbols-outlined text-primary" style="font-size:18px">verified_user</span>Certificación
            </a>
            <a href="nosotros.html#equipo" class="flex items-center gap-3 px-5 py-3 text-sm text-slate-600 hover:text-primary hover:bg-slate-50 transition-colors" data-i18n="nav_about_team">
              <span class="material-symbols-outlined text-primary" style="font-size:18px">group</span>Equipo de Trabajo
            </a>
            <a href="nosotros.html#cultura" class="flex items-center gap-3 px-5 py-3 text-sm text-slate-600 hover:text-primary hover:bg-slate-50 transition-colors" data-i18n="nav_about_culture">
              <span class="material-symbols-outlined text-primary" style="font-size:18px">diversity_3</span>Cultura
            </a>
          </div>
        </div>
        <div class="relative group flex items-center">
          <a href="productos.php" class="text-sm font-semibold tracking-wide text-white hover:text-white/70 transition-colors uppercase" data-i18n="nav_products">PRODUCTOS</a>
          <button class="flex items-center text-white hover:text-white/70 transition-colors ml-1">
            <span class="material-symbols-outlined text-base" style="font-size:16px">expand_more</span>
          </button>
          <div class="nav-megamenu absolute invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 bg-white rounded-2xl shadow-2xl shadow-slate-200/80 border border-slate-100 p-6 z-50">
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-4 pb-3 border-b border-slate-100" data-i18n="nav_products_catalog">Catálogo de Productos</p>
            <div class="grid grid-cols-2 gap-x-8 gap-y-1">
              <a href="productos.php?cat=proteccion" class="text-sm text-slate-600 hover:text-primary py-1.5 transition-colors">Protección Personal</a>
              <a href="productos.php?cat=camisolines" class="text-sm text-slate-600 hover:text-primary py-1.5 transition-colors">Camisolines</a>
              <a href="productos.php?cat=quirurgico" class="text-sm text-slate-600 hover:text-primary py-1.5 transition-colors">Quirúrgico</a>
              <a href="productos.php?cat=kits" class="text-sm text-slate-600 hover:text-primary py-1.5 transition-colors">Kits</a>
              <a href="productos.php?cat=cama" class="text-sm text-slate-600 hover:text-primary py-1.5 transition-colors">Camilla y Campo</a>
              <a href="productos.php?cat=otros" class="text-sm text-slate-600 hover:text-primary py-1.5 transition-colors">Otros Accesorios</a>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
              <a href="productos.php" class="inline-flex items-center gap-2 text-xs font-bold text-primary hover:underline">
                Ver catálogo completo <span class="material-symbols-outlined" style="font-size:14px">arrow_forward</span>
              </a>
            </div>
          </div>
        </div>
        <a class="text-sm font-semibold tracking-wide text-white hover:text-white/70 transition-colors" href="noticias.html">NOTICIAS</a>
        <a class="text-sm font-semibold tracking-wide text-white hover:text-white/70 transition-colors" href="contacto.html">CONTACTO</a>
        
        <div class="flex items-center gap-2.5 px-4 border-l border-white/10 ml-2">
          <button onclick="openGlobalSearch()" class="flex items-center text-white hover:text-white/70 transition-colors mr-2" title="Buscar">
            <span class="material-symbols-outlined text-xl">search</span>
          </button>
          <a href="#" onclick="event.preventDefault(); i18n.load('es');" title="Español" class="flex" data-i18n-title="nav_lang_es"><img src="https://flagcdn.com/w40/es.png" class="w-5 h-5 rounded-full object-cover border border-white/20 hover:scale-110 transition-transform shadow-sm" alt="ES"></a>
          <a href="#" onclick="event.preventDefault(); i18n.load('en');" title="English" class="flex" data-i18n-title="nav_lang_en"><img src="https://flagcdn.com/w40/us.png" class="w-5 h-5 rounded-full object-cover border border-white/20 hover:scale-110 transition-transform shadow-sm" alt="EN"></a>
          <a href="#" onclick="event.preventDefault(); i18n.load('pt');" title="Português" class="flex" data-i18n-title="nav_lang_pt"><img src="https://flagcdn.com/w40/br.png" class="w-5 h-5 rounded-full object-cover border border-white/20 hover:scale-110 transition-transform shadow-sm" alt="PT"></a>
        </div>

        <a href="assets/pdf/catalogo.pdf" target="_blank"
          class="nav-cta bg-primary hover:bg-[#153f7a] text-white px-6 py-2.5 rounded-full font-semibold text-sm transition-all shadow-md shadow-primary/20"
          data-i18n="nav_catalog">
          CATÁLOGO
        </a>
        
        <a href="admin/login.php" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition-all border border-white/10">
          <span class="material-symbols-outlined text-sm">login</span>
          INGRESAR
        </a>
      </div>
      <button class="md:hidden text-white" id="mobile-menu-btn">
        <span class="material-symbols-outlined">menu</span>
      </button>
    </nav>
    <section class="relative h-screen min-h-screen w-full overflow-hidden bg-dark-navy" id="inicio">
      <div class="hero-slide active">
        <img alt="Medical environment" class="w-full h-full object-cover opacity-60" src="assets/img/Hospitalaria.webp" />
        <div class="absolute inset-0 bg-gradient-to-r from-dark-navy/80 via-dark-navy/40 to-transparent"></div>
      </div>
      <div class="hero-slide">
        <img alt="Protective gear" class="w-full h-full object-cover opacity-60" src="assets/img/ropa-hospitalaria-lavanderia-limpieza-sanidad.jpg" />
        <div class="absolute inset-0 bg-gradient-to-r from-dark-navy/80 via-dark-navy/40 to-transparent"></div>
      </div>
      <div class="relative z-20 h-full flex flex-col justify-center container mx-auto px-6">
        <div class="max-w-3xl pt-20">
          <span class="inline-block px-4 py-1.5 rounded-full bg-white/20 border border-white/40 text-white font-semibold text-xs tracking-widest uppercase mb-6" data-i18n="home_hero_badge">Excelencia en Descartables</span>
          <h1 class="text-4xl md:text-6xl lg:text-7xl font-title tracking-wide text-white mb-6 leading-none" data-i18n="home_hero_title">Soluciones Hospitalarias con <span class="text-white block mt-2 opacity-90">Estándares de Calidad</span></h1>
          <p class="text-xl md:text-2xl text-white mb-12 max-w-xl leading-relaxed font-light opacity-90" data-i18n="home_hero_desc">En DPC trabajamos con un enfoque de mejora continua y eficiencia operativa. Preparados para atender la demanda del mercado hospitalario.</p>
          <div class="flex flex-wrap gap-5">
            <a href="#productos" class="bg-white hover:bg-slate-100 text-dark-navy px-10 py-4 rounded-full font-semibold text-base shadow-xl transition-all hover:-translate-y-1" data-i18n="btn_view_products">Ver Productos</a>
            <a href="nosotros.html" class="bg-transparent hover:bg-white/10 text-white border border-white px-10 py-4 rounded-full font-semibold text-base backdrop-blur-md transition-all" data-i18n="btn_our_company">Nuestra Empresa</a>
          </div>
        </div>
      </div>
      <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 animate-bounce cursor-pointer flex flex-col items-center opacity-80 hover:opacity-100 transition-opacity" onclick="window.scrollBy({top: window.innerHeight, behavior: 'smooth'})">
        <span class="text-white text-xs font-semibold tracking-[0.2em] uppercase mb-1" data-i18n="home_hero_explore">Explorar</span>
        <span class="material-symbols-outlined text-white text-3xl">keyboard_arrow_down</span>
      </div>
    </section>
    <section class="relative h-[40vh] md:h-[60vh] overflow-hidden flex items-center justify-center border-y border-slate-100" style="background-color: #F0F7FF;">
      <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
      <div class="absolute inset-0 z-0">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 1600 900" preserveAspectRatio="xMidYMax slice" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; box-sizing: border-box; display: block; background-color: transparent;">
          <defs>
            <linearGradient id="bg">
              <stop offset="0%" style="stop-color:rgba(148, 163, 184, 0.1)"></stop>
              <stop offset="50%" style="stop-color:rgba(100, 116, 139, 0.1)"></stop>
              <stop offset="100%" style="stop-color:rgba(71, 85, 105, 0.05)"></stop>
            </linearGradient>
            <path id="wave" fill="url(#bg)" d="M-363.852,502.589c0,0,236.988-41.997,505.475,0 s371.981,38.998,575.971,0 s293.985-39.278,505.474,5.859 s493.475,48.368,716.963-4.995v560.106H-363.852V502.589z" />
          </defs>
          <g>
            <use xlink:href='#wave' opacity=".3"><animateTransform attributeName="transform" attributeType="XML" type="translate" dur="10s" calcMode="spline" values="270 230; -334 180; 270 230" keyTimes="0; .5; 1" keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0" repeatCount="indefinite" /></use>
            <use xlink:href='#wave' opacity=".6"><animateTransform attributeName="transform" attributeType="XML" type="translate" dur="8s" calcMode="spline" values="-270 230;243 220;-270 230" keyTimes="0; .6; 1" keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0" repeatCount="indefinite" /></use>
          </g>
        </svg>
      </div>
      <div class="absolute inset-0 flex flex-col items-center justify-center select-none overflow-hidden pointer-events-none z-10 px-4">
        <div id="parallax-watermark"><div class="flex flex-row items-center justify-center animate-dpc-move"><img src="assets/img/logo.png" alt="DPC Logo" class="h-[35vw] md:h-[28vw] object-contain" style="filter: drop-shadow(0 20px 40px rgba(11, 26, 46, 0.3));" /></div></div>
      </div>
      <div class="absolute inset-0 z-20 pointer-events-none">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 1600 900" preserveAspectRatio="xMidYMax slice" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; box-sizing: border-box; display: block; background: transparent;">
          <defs>
            <linearGradient id="bg-fg">
              <stop offset="0%" style="stop-color:rgba(148, 163, 184, 0.1)"></stop>
              <stop offset="50%" style="stop-color:rgba(100, 116, 139, 0.15)"></stop>
              <stop offset="100%" style="stop-color:rgba(71, 85, 105, 0.1)"></stop>
            </linearGradient>
            <path id="wave-fg" fill="url(#bg-fg)" d="M-363.852,502.589c0,0,236.988-41.997,505.475,0 s371.981,38.998,575.971,0 s293.985-39.278,505.474,5.859 s493.475,48.368,716.963-4.995v560.106H-363.852V502.589z" />
          </defs>
          <g><use xlink:href='#wave-fg' opacity=".4"><animateTransform attributeName="transform" attributeType="XML" type="translate" dur="6s" calcMode="spline" values="0 230;-140 200;0 230" keyTimes="0; .4; 1" keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0" repeatCount="indefinite" /></use></g>
        </svg>
      </div>
    </section>
    <section class="py-32 bg-transparent relative overflow-hidden" id="nosotros">
      <div class="absolute top-0 inset-x-0 h-48 -mt-1 overflow-hidden pointer-events-none">
        <svg class="absolute top-0 left-0 w-[120%] h-full wave-layer-slow opacity-20 fill-primary" viewBox="0 0 1440 120" preserveAspectRatio="none"><path d="M0,32L48,37.3C96,43,192,53,288,58.7C384,64,480,64,576,58.7C672,53,768,43,864,42.7C960,43,1056,53,1152,53.3C1248,53,1344,43,1392,37.3L1440,32V0H1392C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0H0Z"></path></svg>
        <svg class="absolute top-0 left-0 w-[110%] h-full wave-layer opacity-40 fill-[#F0F7FF]" viewBox="0 0 1440 120" preserveAspectRatio="none" style="animation-delay: -2s"><path d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,64C960,75,1056,85,1152,85.3C1248,85,1344,75,1392,69.3L1440,64V0H1392C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0H0Z"></path></svg>
      </div>
      <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-20 left-10 w-24 h-24 bg-primary/2 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute top-60 right-20 w-32 h-32 bg-accent/3 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 2s"></div>
        <span class="material-symbols-outlined absolute top-40 left-[5%] text-primary/5 text-6xl animate-float-slow" style="animation-delay: 1s">medical_services</span>
        <span class="material-symbols-outlined absolute bottom-40 right-[10%] text-primary/5 text-8xl animate-float-slow" style="animation-duration: 10s">science</span>
      </div>
      <div class="absolute inset-0 dot-grid opacity-20"></div>
      <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-20 max-w-2xl mx-auto">
          <span class="text-primary font-bold tracking-[0.3em] uppercase text-xs mb-4 block" data-i18n="home_about_badge">Nuestra Identidad</span>
          <h2 class="text-3xl md:text-5xl font-black text-dark-navy mb-6 tracking-tight" data-i18n="home_about_title">Por qué elegir DPC</h2>
          <div class="w-20 h-1 bg-primary mx-auto rounded-full mb-6"></div>
          <p class="text-slate-500 font-light text-lg" data-i18n="home_about_desc">Estamos comprometidos en brindar soluciones hospitalarias descartables de primer nivel, apoyados en la innovación tecnológica y los más altos estándares.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div class="glass-v2 rounded-[2rem] p-8 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300 group flex flex-col h-full transform hover:-translate-y-2 relative overflow-hidden">
            <div class="w-16 h-16 rounded-2xl bg-primary/5 text-primary flex items-center justify-center mb-8 group-hover:bg-primary group-hover:text-white transition-colors"><span class="material-symbols-outlined text-3xl">precision_manufacturing</span></div>
            <h3 class="text-xl font-black text-dark-navy mb-4 leading-tight" data-i18n="home_about_card1_title">Somos Fabricante</h3>
            <p class="text-slate-500 font-light text-sm mb-8 flex-grow leading-relaxed" data-i18n="home_about_card1_desc">Estamos preparados para atender la demanda y cumplir con las exigencias de nuestros clientes, garantizando soluciones que satisfacen plenamente sus requerimientos.</p>
            <button class="inline-flex items-center gap-2 text-primary font-bold text-sm uppercase tracking-wider group-hover:gap-3 transition-all mt-auto" onclick="openModal(0)" data-i18n="btn_read_more">Leer Más <span class="material-symbols-outlined text-sm">arrow_forward</span></button>
          </div>
          <div class="glass-v2 rounded-[2rem] p-8 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300 group flex flex-col h-full transform hover:-translate-y-2 lg:mt-12 relative overflow-hidden">
            <div class="w-16 h-16 rounded-2xl bg-primary/5 text-primary flex items-center justify-center mb-8 group-hover:bg-primary group-hover:text-white transition-colors"><span class="material-symbols-outlined text-3xl">language</span></div>
            <h3 class="text-xl font-black text-dark-navy mb-4 leading-tight" data-i18n="home_about_card2_title">Tecnología</h3>
            <p class="text-slate-500 font-light text-sm mb-8 flex-grow leading-relaxed" data-i18n="home_about_card2_desc">Trabajamos permanentemente en la implementación de nuevos métodos que nos permiten incrementar la calidad de nuestros productos.</p>
            <button class="inline-flex items-center gap-2 text-primary font-bold text-sm uppercase tracking-wider group-hover:gap-3 transition-all mt-auto" onclick="openModal(1)" data-i18n="btn_read_more">Leer Más <span class="material-symbols-outlined text-sm">arrow_forward</span></button>
          </div>
          <div class="glass-v2 rounded-[2rem] p-8 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300 group flex flex-col h-full transform hover:-translate-y-2 relative overflow-hidden">
            <div class="w-16 h-16 rounded-2xl bg-primary/5 text-primary flex items-center justify-center mb-8 group-hover:bg-primary group-hover:text-white transition-colors"><span class="material-symbols-outlined text-3xl">workspace_premium</span></div>
            <h3 class="text-xl font-black text-dark-navy mb-4 leading-tight" data-i18n="home_about_card3_title">Estándares de Calidad</h3>
            <p class="text-slate-500 font-light text-sm mb-8 flex-grow leading-relaxed" data-i18n="home_about_card3_desc">Contamos con la capacidad y experiencia necesarias para atender las exigencias actuales del mercado hospitalario.</p>
            <button class="inline-flex items-center gap-2 text-primary font-bold text-sm uppercase tracking-wider group-hover:gap-3 transition-all mt-auto" onclick="openModal(2)" data-i18n="btn_read_more">Leer Más <span class="material-symbols-outlined text-sm">arrow_forward</span></button>
          </div>
          <div class="glass-v2 rounded-[2rem] p-8 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300 group flex flex-col h-full transform hover:-translate-y-2 lg:mt-12 relative overflow-hidden">
            <div class="w-16 h-16 rounded-2xl bg-primary/5 text-primary flex items-center justify-center mb-8 group-hover:bg-primary group-hover:text-white transition-colors"><span class="material-symbols-outlined text-3xl">rule</span></div>
            <h3 class="text-xl font-black text-dark-navy mb-4 leading-tight" data-i18n="home_about_card4_title">Requisitos Reglamentarios</h3>
            <p class="text-slate-500 font-light text-sm mb-8 flex-grow leading-relaxed" data-i18n="home_about_card4_desc">En DPC trabajamos con un enfoque de mejora continua y eficiencia operativa.</p>
            <button class="inline-flex items-center gap-2 text-primary font-bold text-sm uppercase tracking-wider group-hover:gap-3 transition-all mt-auto" onclick="openModal(3)" data-i18n="btn_read_more">Leer Más <span class="material-symbols-outlined text-sm">arrow_forward</span></button>
          </div>
        </div>
      </div>
      <!-- Info Modal -->
      <div id="infoModal" class="fixed inset-0 z-[100] flex items-center justify-center invisible opacity-0 transition-all duration-300">
        <div class="absolute inset-0 bg-dark-navy/90 backdrop-blur-md" onclick="closeModal()"></div>
        <div class="bg-white w-full max-w-3xl mx-4 rounded-[2rem] shadow-2xl relative z-10 transform scale-95 opacity-0 transition-all duration-300 flex flex-col overflow-hidden" id="modalContent">
          <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-primary to-accent"></div>
          <div class="px-8 md:px-12 py-8 border-b border-slate-100 flex justify-between items-start mt-2">
            <div class="flex items-start gap-5">
              <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center shrink-0" id="modalIconContainer"><span class="material-symbols-outlined text-3xl" id="modalIcon">info</span></div>
              <div><span class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1 block">Detalle de Sección</span><h3 class="text-3xl font-black text-dark-navy leading-tight" id="modalTitle">Título Modal</h3></div>
            </div>
            <button onclick="closeModal()" class="w-12 h-12 rounded-full hover:bg-slate-100 text-slate-400 hover:text-dark-navy flex items-center justify-center transition-all shrink-0"><span class="material-symbols-outlined">close</span></button>
          </div>
          <div class="px-8 md:px-12 py-10 bg-slate-50/50"><p class="text-slate-600 leading-relaxed font-light text-xl" id="modalText">Texto detallado del modal...</p></div>
          <div class="px-8 md:px-12 py-8 flex justify-end gap-3 bg-white"><button onclick="closeModal()" class="px-10 py-4 rounded-full bg-primary text-white font-bold tracking-wider hover:bg-[#153f7a] transition-colors shadow-xl shadow-primary/30">Entendido</button></div>
        </div>
      </div>
    </section>
    <section class="py-24 bg-white relative overflow-hidden" id="productos">
      <div class="container mx-auto px-6 relative z-10 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-end gap-8 text-center md:text-left">
          <div class="max-w-xl mx-auto md:mx-0">
            <span class="text-primary font-bold tracking-[0.3em] uppercase text-xs mb-4 block" data-i18n="home_catalog_badge">Nuestro Catálogo</span>
            <h2 class="text-4xl md:text-5xl font-black text-dark-navy leading-tight tracking-tight" data-i18n="home_catalog_title">Soluciones Descartables</h2>
          </div>
          <div class="mx-auto md:mx-0"><a href="productos.php" class="inline-flex items-center gap-3 bg-primary text-white px-8 py-4 rounded-full font-bold shadow-lg shadow-primary/30 hover:shadow-primary/50 transition-all hover:-translate-y-1">Catálogo Completo <span class="material-symbols-outlined">dataset_linked</span></a></div>
        </div>
      </div>
      <div class="w-full relative px-0 pb-12 pt-10">
        <div class="swiper productSwiper pb-16">
          <div class="swiper-wrapper">
            <div class="swiper-slide !w-[300px] md:!w-[450px]">
              <a href="productos.php?cat=proteccion" class="relative block h-64 md:h-80 rounded-[2rem] overflow-hidden group shadow-2xl border border-white/10">
                <img src="assets/img/catalogo/barbijo.png" alt="Protección Facial" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" data-i18n-alt="prod_cat_proteccion_title">
                <div class="absolute inset-0 bg-gradient-to-t from-dark-navy/90 via-dark-navy/20 to-transparent"></div>
                <div class="absolute inset-0 flex flex-col justify-end p-8 md:p-10"><h3 class="text-white text-2xl md:text-3xl font-black uppercase tracking-tight mb-4 drop-shadow-lg leading-none" data-i18n="home_catalog_item1">Protección Facial <br>& de Cabeza</h3><div class="inline-block self-start bg-[#F3B844] text-dark-navy px-8 py-3 rounded-md font-black text-xs uppercase tracking-widest shadow-xl transform transition-all group-hover:scale-105">Explorar Ahora</div></div>
              </a>
            </div>
            <div class="swiper-slide !w-[300px] md:!w-[450px]">
              <a href="productos.php?cat=camisolines" class="relative block h-64 md:h-80 rounded-[2rem] overflow-hidden group shadow-2xl border border-white/10">
                <img src="assets/img/catalogo/camisolin-lineapremium.png" alt="Camisolines" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" data-i18n-alt="prod_cat_camisolines_title">
                <div class="absolute inset-0 bg-gradient-to-t from-dark-navy/90 via-dark-navy/20 to-transparent"></div>
                <div class="absolute inset-0 flex flex-col justify-end p-8 md:p-10"><h3 class="text-white text-2xl md:text-3xl font-black uppercase tracking-tight mb-4 drop-shadow-lg leading-none" data-i18n="home_catalog_item2">Camisolines <br>Línea Hospitalaria</h3><div class="inline-block self-start bg-[#F3B844] text-dark-navy px-8 py-3 rounded-md font-black text-xs uppercase tracking-widest shadow-xl transform transition-all group-hover:scale-105">Explorar Ahora</div></div>
              </a>
            </div>
            <div class="swiper-slide !w-[300px] md:!w-[450px]">
              <a href="productos.php?cat=quirurgico" class="relative block h-64 md:h-80 rounded-[2rem] overflow-hidden group shadow-2xl border border-white/10">
                <img src="assets/img/catalogo/equipodecirugiageneral.png" alt="Equipos de Cirugía" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" data-i18n-alt="prod_cat_quirurgico_title">
                <div class="absolute inset-0 bg-gradient-to-t from-dark-navy/90 via-dark-navy/20 to-transparent"></div>
                <div class="absolute inset-0 flex flex-col justify-end p-8 md:p-10"><h3 class="text-white text-2xl md:text-3xl font-black uppercase tracking-tight mb-4 drop-shadow-lg leading-none" data-i18n="home_catalog_item3">Equipos de Cirugía <br>Estériles</h3><div class="inline-block self-start bg-[#F3B844] text-dark-navy px-8 py-3 rounded-md font-black text-xs uppercase tracking-widest shadow-xl transform transition-all group-hover:scale-105">Explorar Ahora</div></div>
              </a>
            </div>
            <div class="swiper-slide !w-[300px] md:!w-[450px]">
              <a href="productos.php?cat=cama" class="relative block h-64 md:h-80 rounded-[2rem] overflow-hidden group shadow-2xl border border-white/10">
                <img src="assets/img/catalogo/sabanas.png" alt="Ropa de Cama" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" data-i18n-alt="prod_cat_cama_title">
                <div class="absolute inset-0 bg-gradient-to-t from-dark-navy/90 via-dark-navy/20 to-transparent"></div>
                <div class="absolute inset-0 flex flex-col justify-end p-8 md:p-10"><h3 class="text-white text-2xl md:text-3xl font-black uppercase tracking-tight mb-4 drop-shadow-lg leading-none" data-i18n="home_catalog_item4">Ropa de Cama <br>& Campos</h3><div class="inline-block self-start bg-[#F3B844] text-dark-navy px-8 py-3 rounded-md font-black text-xs uppercase tracking-widest shadow-xl transform transition-all group-hover:scale-105">Explorar Ahora</div></div>
              </a>
            </div>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </section>

    <section class="py-32 bg-transparent relative overflow-hidden" id="noticias">
      <div class="bg-watermark top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 rotate-12">NEWS / DPC</div>
      <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16">
          <h2 class="text-5xl font-black text-dark-navy" data-i18n="home_news_title">Novedades DPC</h2>
          <p class="text-slate-500 font-light mt-4 md:mt-0" data-i18n="home_news_subtitle">Lo último en tecnología y eventos del sector.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-12">
          <?php foreach ($noticias as $n): ?>
          <article onclick="window.location.href='noticias.html?id=<?= $n['id'] ?>'" class="bg-white rounded-[2rem] overflow-hidden shadow-xl shadow-slate-200/50 group hover:-translate-y-2 transition-all duration-500 cursor-pointer">
            <div class="h-64 overflow-hidden"><img alt="<?= htmlspecialchars($n['titulo']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700" src="<?= htmlspecialchars($n['imagen']) ?>" /></div>
            <div class="p-10">
              <time class="text-[10px] font-black text-accent uppercase tracking-widest mb-4 block"><?= date('M Y', strtotime($n['fecha'])) ?></time>
              <h3 class="text-xl font-bold text-dark-navy mb-4 leading-tight"><?= htmlspecialchars($n['titulo']) ?></h3>
              <p class="text-slate-500 text-sm font-light leading-relaxed line-clamp-2"><?= htmlspecialchars($n['copete']) ?></p>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="py-32 bg-transparent relative overflow-hidden" id="contacto">
      <div class="bg-watermark top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 -rotate-6" data-i18n="home_contact_watermark">CONTACT / DPC</div>
      <div class="container mx-auto px-6">
        <div class="max-w-5xl mx-auto grid lg:grid-cols-2 gap-16 items-center">
          <div>
            <span class="text-primary font-black tracking-widest uppercase text-xs mb-4 block" data-i18n="contact_badge">Hablemos</span>
            <h2 class="text-5xl font-black text-dark-navy mb-10 leading-none" data-i18n="contact_title">Consultas <br><span class="text-primary italic">Profesionales</span></h2>
            <div class="space-y-8">
              <div class="flex gap-6 items-center">
                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center border border-slate-100 text-primary"><span class="material-symbols-outlined text-2xl">location_on</span></div>
                <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Dirección</p><p class="text-lg font-bold text-dark-navy leading-tight">Colombia 2589, San Miguel de Tucumán</p></div>
              </div>
              <div class="flex gap-6 items-center">
                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center border border-slate-100 text-primary"><span class="material-symbols-outlined text-2xl">mail</span></div>
                <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Email Corporativo</p><p class="text-lg font-bold text-dark-navy leading-tight">ventas@dpc.com.ar</p></div>
              </div>
            </div>
          </div>
          <div class="bg-white p-8 md:p-12 rounded-[2.5rem] border border-slate-200 shadow-2xl relative overflow-hidden">
            <form class="space-y-6 relative z-10">
              <div class="grid md:grid-cols-2 gap-6">
                <div><label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nombre Completo</label><input type="text" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3.5 outline-none text-sm" placeholder="Ej: Juan Pérez"></div>
                <div><label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Institución</label><input type="text" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3.5 outline-none text-sm" placeholder="Clínica / Hospital"></div>
              </div>
              <button class="w-full bg-primary text-white font-black py-4 rounded-xl shadow-lg flex items-center justify-center gap-3 text-sm tracking-widest group">ENVIAR SOLICITUD <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span></button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <footer class="bg-dark-navy text-white pt-16 pb-12 relative overflow-hidden">
      <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary via-accent to-primary opacity-50"></div>
      <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-10 mb-12">
          <div class="flex flex-col items-center md:items-start"><img src="assets/img/logo.png" alt="DPC Logo" class="h-16 w-auto mb-6" /></div>
          <nav class="flex flex-wrap justify-center gap-x-8 gap-y-4">
            <a href="index.php" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-white transition-colors">Inicio</a>
            <a href="nosotros.html" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-white transition-colors">Nosotros</a>
            <a href="productos.php" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-white transition-colors">Productos</a>
            <a href="noticias.html" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-white transition-colors">Noticias</a>
            <a href="contacto.html" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-white transition-colors">Contacto</a>
          </nav>
        </div>
        <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6 text-[9px] uppercase font-bold tracking-[0.2em] text-slate-500 text-center">
          <p>© 2026 DPC - Desarrollo Profesional Confiable. Colombia 2589, Tucumán.</p>
        </div>
      </div>
    </footer>

    <a class="fixed bottom-10 right-10 z-[60] w-20 h-20 bg-[#25D366] rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-transform group" href="https://wa.me/543814456789" target="_blank">
      <svg class="w-10 h-10 text-white fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.185-.573c.948.517 2.139.945 3.145.945 3.181 0 5.768-2.586 5.768-5.766 0-3.18-2.587-5.766-5.767-5.766zm3.371 8.203c-.144.405-.833.748-1.15.773-.243.018-.56.033-1.602-.383-1.353-.54-2.226-1.888-2.293-1.979-.066-.091-.539-.717-.539-1.379 0-.662.348-.988.472-1.12.124-.132.273-.166.364-.166.091 0 .182.001.261.005.083.004.195-.032.304.233.112.274.385.938.418 1.005.033.066.054.144.01.233-.044.089-.066.144-.132.221-.066.077-.14.173-.2.235-.069.071-.141.148-.061.286.08.138.354.584.76 0.941.522.459.963.601 1.102.668.138.066.221.055.304-.042.083-.097.354-.412.449-.553.095-.141.19-.118.32-.07.13.047.825.389.968.461.143.072.238.107.273.167.035.06.035.348-.109.753z"></path></svg>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="assets/js/translations.js"></script>
    <script src="assets/js/i18n.js"></script>
    <script>
      // Navigation Scroll
      window.addEventListener("scroll", function () {
        const nav = document.getElementById("main-nav");
        nav.classList.toggle("nav-scrolled", window.scrollY > 100);
      });

      // Parallax Watermark
      window.addEventListener("scroll", function () {
        const watermark = document.getElementById("parallax-watermark");
        if (!watermark) return;
        const scrollPos = window.scrollY;
        const offset = (scrollPos - watermark.parentElement.offsetTop) * 0.4;
        watermark.style.transform = `translateX(${offset}px)`;
      });

      // Hero Slider
      let currentSlide = 0;
      const slides = document.querySelectorAll('.hero-slide');
      setInterval(() => {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
      }, 5000);

      // Swiper
      new Swiper(".productSwiper", {
        slidesPerView: "auto",
        centeredSlides: true,
        spaceBetween: 30,
        loop: true,
        grabCursor: true,
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
        pagination: { el: ".swiper-pagination", clickable: true },
        breakpoints: { 768: { spaceBetween: 50 } }
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
        <div id="search-results" class="mt-8 grid grid-cols-1 gap-4 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
          <!-- Results will appear here -->
        </div>
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

      // Cerrar con Escape
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeGlobalSearch();
      });
    </script>
  </body>
</html>
