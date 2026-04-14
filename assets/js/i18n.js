const i18n = {
  currentLang: localStorage.getItem('lang') || navigator.language.slice(0, 2) || 'es',
  translations: {},

  async load(lang = this.currentLang) {
    try {
      if (!window.translations) {
        console.warn('translations.js not loaded yet. Retrying...');
        setTimeout(() => this.load(lang), 100);
        return;
      }
      
      const dictionary = window.translations[lang] || window.translations['es'];
      if (!dictionary) {
        throw new Error('Translations not found');
      }

      this.translations = dictionary;
      this.currentLang = lang;
      localStorage.setItem('lang', lang);
      this.updateDOM();
      
      // Attempt to refresh dynamic content if exposed
      if (typeof window.renderProducts === 'function' && window.currentCategory) {
          window.filterProducts(window.currentCategory);
      }
    } catch (error) {
      console.error('Error loading translations:', error);
    }
  },

  updateDOM() {
    // Translating normal text and innerHTML
    document.querySelectorAll('[data-i18n]').forEach(element => {
      const key = element.getAttribute('data-i18n');
      if (this.translations[key]) {
        // Use innerHTML to allow tags within translations like <br> or <span>
        element.innerHTML = this.translations[key];
      }
    });

    // Translating placeholders
    document.querySelectorAll('[data-i18n-placeholder]').forEach(element => {
      const key = element.getAttribute('data-i18n-placeholder');
      if (this.translations[key]) {
        element.placeholder = this.translations[key];
      }
    });

    // Translating alt text
    document.querySelectorAll('[data-i18n-alt]').forEach(element => {
      const key = element.getAttribute('data-i18n-alt');
      if (this.translations[key]) {
        element.alt = this.translations[key];
      }
    });

    // Translating titles
    document.querySelectorAll('[data-i18n-title]').forEach(element => {
      const key = element.getAttribute('data-i18n-title');
      if (this.translations[key]) {
        element.title = this.translations[key];
      }
    });
  },

  t(key) {
    return this.translations[key] || key;
  }
};

// Auto-init on DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
  i18n.load();
});

// Update global space
window.i18n = i18n;
