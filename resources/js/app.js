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
