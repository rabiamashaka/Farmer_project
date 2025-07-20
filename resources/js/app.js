import './bootstrap';
import './script.js';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// -------- Language Switcher (global) --------
document.addEventListener('DOMContentLoaded', () => {
    const switcher = document.getElementById('lang-switcher');
    if (!switcher) return;

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const setLocaleUrl = '/set-locale';
    
    // Endpoint that returns translated text
    const translateUrl = '/translate-text';

    const applyTranslation = async (lang) => {
        const elements = document.querySelectorAll('[data-i18n]');
        for (const el of elements) {
            if (!el.dataset.original) {
                el.dataset.original = el.textContent.trim();
            }
            if (lang === 'en') {
                el.textContent = el.dataset.original;
                continue;
            }
            try {
                const res = await fetch(translateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: JSON.stringify({ text: el.dataset.original, lang }),
                });
                const data = await res.json();
                if (data.translated) {
                    el.textContent = data.translated;
                }
            } catch (err) {
                console.error('Translation failed', err);
            }
        }
    };

    // Function to save locale to server, then reload
    const saveLocale = async (lang) => {
        await fetch(`${setLocaleUrl}/${lang}`, {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': csrf}
        });
        location.reload();
    };

    // Set initial language from storage
    const savedLang = localStorage.getItem('lang') || 'en';
    switcher.value = savedLang;
    if (savedLang !== 'en') {
        applyTranslation(savedLang);
    }

    // Listen for changes
    switcher.addEventListener('change', (e) => {
        const lang = e.target.value;
        localStorage.setItem('lang', lang);
        saveLocale(lang);
    });
});

// Language switching functionality
document.addEventListener('DOMContentLoaded', function() {
    // Handle language switcher dropdown
    const langSwitcher = document.getElementById('lang-switcher');
    if (langSwitcher) {
        langSwitcher.addEventListener('change', function() {
            const selectedLang = this.value;
            const form = document.getElementById('lang-form');
            if (form) {
                form.action = `/set-locale/${selectedLang}`;
                form.submit();
            }
        });
    }

    // Add smooth language switching for mobile
    const mobileLangSwitcher = document.querySelector('#lang-switcher[class*="w-full"]');
    if (mobileLangSwitcher) {
        mobileLangSwitcher.addEventListener('change', function() {
            const selectedLang = this.value;
            window.location.href = `/set-locale/${selectedLang}`;
        });
    }

    // Show current language in UI
    const currentLang = document.documentElement.lang || 'en';
    const langIndicators = document.querySelectorAll('.current-lang');
    langIndicators.forEach(indicator => {
        indicator.textContent = currentLang === 'en' ? 'English' : 'Kiswahili';
    });
});

// Translation helper function
window.translate = function(key, parameters = {}) {
    // This would typically call a backend endpoint
    // For now, we'll use the Laravel translation system
    return key;
};

// Auto-refresh page content when language changes
window.addEventListener('storage', function(e) {
    if (e.key === 'locale') {
        window.location.reload();
    }
});
