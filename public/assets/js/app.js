/**
 * Lufly Architectural Ceramics - Modern Progressive Client Script
 * Zero heavy dependencies. Purposeful UX interactions only.
 */

document.addEventListener('DOMContentLoaded', () => {
    const loc = window.LUFLY_LOCALE || 'tr';
    const locPrefix = loc === 'tr' ? '' : `/${loc}`;

    // 1. Mobile Navigation Toggle
    const mobileBtn = document.querySelector('.mobile-nav-toggle');
    const mobileDrawer = document.getElementById('mobile-drawer');
    const mobileClose = document.getElementById('mobile-drawer-close');

    if (mobileBtn && mobileDrawer) {
        mobileBtn.addEventListener('click', () => {
            mobileDrawer.classList.add('open');
            document.body.style.overflow = 'hidden';
        });
    }

    if (mobileClose && mobileDrawer) {
        mobileClose.addEventListener('click', () => {
            mobileDrawer.classList.remove('open');
            document.body.style.overflow = '';
        });
    }

    // 2. Search Modal & Debounced Autocomplete
    const searchTrigger = document.querySelector('.search-trigger-btn');
    const searchModal = document.getElementById('search-modal');
    const searchClose = document.getElementById('search-modal-close');
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results-box');

    function openSearch() {
        if (!searchModal) return;
        searchModal.classList.add('open');
        document.body.style.overflow = 'hidden';
        if (searchInput) {
            setTimeout(() => searchInput.focus(), 50);
        }
    }

    function closeSearch() {
        if (!searchModal) return;
        searchModal.classList.remove('open');
        document.body.style.overflow = '';
        if (searchInput) searchInput.value = '';
        if (searchResults) searchResults.innerHTML = '';
    }

    if (searchTrigger) {
        searchTrigger.addEventListener('click', openSearch);
    }

    if (searchClose) {
        searchClose.addEventListener('click', closeSearch);
    }

    // Keyboard shortcuts (Cmd+K or /) & Escape
    document.addEventListener('keydown', (e) => {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            openSearch();
        } else if (e.key === 'Escape') {
            closeSearch();
            if (mobileDrawer) {
                mobileDrawer.classList.remove('open');
                document.body.style.overflow = '';
            }
        }
    });

    if (searchModal) {
        searchModal.addEventListener('click', (e) => {
            if (e.target === searchModal) {
                closeSearch();
            }
        });
    }

    // Debounced Live Search
    let debounceTimer;
    if (searchInput && searchResults) {
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            const query = searchInput.value.trim();

            if (query.length < 2) {
                searchResults.innerHTML = '';
                return;
            }

            debounceTimer = setTimeout(() => {
                fetch(`/api/search?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(items => {
                        if (!items || items.length === 0) {
                            const emptyMsg = loc === 'tr' 
                                ? `"${escapeHtml(query)}" ile eşleşen model bulunamadı.<br><a href="${locPrefix}/products" style="text-decoration: underline; color: var(--c-forest); margin-top: 0.5rem; display: inline-block;">Tüm Ürünleri İncele</a>`
                                : (loc === 'cs'
                                    ? `Pro "${escapeHtml(query)}" nebyly nalezeny žádné modely.<br><a href="${locPrefix}/products" style="text-decoration: underline; color: var(--c-forest); margin-top: 0.5rem; display: inline-block;">Procházet všechny produkty</a>`
                                    : `No models found for "${escapeHtml(query)}".<br><a href="${locPrefix}/products" style="text-decoration: underline; color: var(--c-forest); margin-top: 0.5rem; display: inline-block;">Browse All Collections</a>`);
                            searchResults.innerHTML = `<div style="padding: 1.5rem; text-align: center; color: var(--c-muted); font-size: 0.875rem;">${emptyMsg}</div>`;
                            return;
                        }

                        const viewText = loc === 'tr' ? 'İncele &rarr;' : (loc === 'cs' ? 'Zobrazit &rarr;' : 'View &rarr;');
                        const viewAllText = loc === 'tr' ? 'Tüm Eşleşen Modelleri Gör &rarr;' : (loc === 'cs' ? 'Zobrazit všechny výsledky &rarr;' : 'View All Matching Products &rarr;');

                        let html = '<div style="display: flex; flex-direction: column; gap: 0.25rem;">';
                        items.forEach(p => {
                            const targetUrl = locPrefix + p.url;
                            html += `
                                <a href="${escapeHtml(targetUrl)}" class="search-result-item">
                                    <img src="${escapeHtml(p.image)}" alt="${escapeHtml(p.name)}" class="search-item-thumb" width="50" height="50" loading="lazy">
                                    <div style="flex-grow: 1;">
                                        <div style="font-size: 0.875rem; font-weight: 600; color: var(--c-obsidian);">${escapeHtml(p.name)}</div>
                                        <div style="font-size: 0.75rem; font-family: var(--font-mono); color: var(--c-eucalyptus);">${escapeHtml(p.sku)} &bull; ${escapeHtml(p.category_name)}</div>
                                    </div>
                                    <span style="font-size: 0.75rem; color: var(--c-forest); font-weight: 500;">${viewText}</span>
                                </a>
                            `;
                        });
                        html += `</div>
                        <div style="padding: 0.75rem; text-align: center; border-top: 1px solid var(--c-divider-subtle); margin-top: 0.5rem;">
                            <a href="${locPrefix}/search?q=${encodeURIComponent(query)}" style="font-size: 0.8125rem; font-weight: 600; color: var(--c-forest);">${viewAllText}</a>
                        </div>`;
                        searchResults.innerHTML = html;
                    })
                    .catch(() => {
                        searchResults.innerHTML = '<div style="padding: 1rem; color: #b03a2e; font-size: 0.875rem;">Error searching database.</div>';
                    });
            }, 180);
        });
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
});
