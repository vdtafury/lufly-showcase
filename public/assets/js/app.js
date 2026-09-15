/**
 * Lufly Architectural Ceramics - Modern Progressive Client Script
 * Zero heavy external dependencies. High-performance UX interactions.
 */

document.addEventListener("DOMContentLoaded", () => {
    const loc = window.LUFLY_LOCALE || "tr";
    const locPrefix = loc === "tr" ? "" : `/${loc}`;

    // 1. Mobile Navigation Toggle & Backdrop Dismiss
    const mobileBtn = document.querySelector(".mobile-nav-toggle");
    const mobileDrawer = document.getElementById("mobile-drawer");
    const mobileClose = document.getElementById("mobile-drawer-close");

    function openMobileDrawer() {
        if (!mobileDrawer) return;
        mobileDrawer.classList.add("open");
        document.body.style.overflow = "hidden";
    }

    function closeMobileDrawer() {
        if (!mobileDrawer) return;
        mobileDrawer.classList.remove("open");
        document.body.style.overflow = "";
    }

    if (mobileBtn) {
        mobileBtn.addEventListener("click", openMobileDrawer);
    }

    if (mobileClose) {
        mobileClose.addEventListener("click", closeMobileDrawer);
    }

    if (mobileDrawer) {
        // Close when clicking the semi-transparent backdrop
        mobileDrawer.addEventListener("click", (e) => {
            if (e.target === mobileDrawer) {
                closeMobileDrawer();
            }
        });
    }

    // 2. Tri-Lingual In-Memory Search Index & Autocomplete
    let searchIndex = null;
    let searchIndexPromise = null;

    function getSearchIndex() {
        if (searchIndex) return Promise.resolve(searchIndex);
        if (searchIndexPromise) return searchIndexPromise;

        searchIndexPromise = fetch("/data/search-index.json")
            .then(res => {
                if (!res.ok) throw new Error("Search index not found");
                return res.json();
            })
            .then(data => {
                searchIndex = data;
                return data;
            })
            .catch(err => {
                console.warn("Search index fetch error:", err);
                return [];
            });

        return searchIndexPromise;
    }

    // Prefetch search index in browser idle time
    if ("requestIdleCallback" in window) {
        window.requestIdleCallback(() => getSearchIndex());
    } else {
        setTimeout(getSearchIndex, 800);
    }

    function queryIndex(query, limit = 8) {
        return getSearchIndex().then(items => {
            if (!query) return [];
            const q = query.toLowerCase().trim();
            const results = [];

            for (let i = 0; i < items.length; i++) {
                const item = items[i];
                const sku = (item.sku || "").toLowerCase();
                const nameTr = (item.name_tr || "").toLowerCase();
                const nameEn = (item.name_en || "").toLowerCase();
                const nameCs = (item.name_cs || "").toLowerCase();
                const catTr = (item.category_tr || item.category_name || "").toLowerCase();
                const catEn = (item.category_en || item.category_name || "").toLowerCase();
                const catCs = (item.category_cs || item.category_name || "").toLowerCase();

                let score = 0;
                if (sku === q) score += 100;
                else if (sku.startsWith(q)) score += 60;
                else if (sku.includes(q)) score += 35;

                const nameCurrent = loc === "tr" ? nameTr : (loc === "cs" ? nameCs : nameEn);
                if (nameCurrent.startsWith(q)) score += 40;
                else if (nameCurrent.includes(q)) score += 25;
                else if (nameEn.includes(q) || nameTr.includes(q) || nameCs.includes(q)) score += 15;

                if (catTr.includes(q) || catEn.includes(q) || catCs.includes(q)) score += 10;

                if (score > 0) {
                    results.push({ item: item, score: score });
                }
            }

            results.sort((a, b) => b.score - a.score);
            const matches = results.map(r => r.item);
            return limit > 0 ? matches.slice(0, limit) : matches;
        });
    }

    // Search Modal Dialog Controls
    const searchTrigger = document.querySelector(".search-trigger-btn");
    const searchModal = document.getElementById("search-modal");
    const searchClose = document.getElementById("search-modal-close");
    const searchInput = document.getElementById("search-input");
    const searchResults = document.getElementById("search-results-box");

    function openSearch() {
        if (!searchModal) return;
        searchModal.classList.add("open");
        document.body.style.overflow = "hidden";
        getSearchIndex(); // Ensure index is loading
        if (searchInput) {
            setTimeout(() => searchInput.focus(), 50);
        }
    }

    function closeSearch() {
        if (!searchModal) return;
        searchModal.classList.remove("open");
        document.body.style.overflow = "";
        if (searchInput) searchInput.value = "";
        if (searchResults) searchResults.innerHTML = "";
    }

    if (searchTrigger) {
        searchTrigger.addEventListener("click", openSearch);
    }

    if (searchClose) {
        searchClose.addEventListener("click", closeSearch);
    }

    // Keyboard Shortcuts (Cmd+K, Ctrl+K, Escape)
    document.addEventListener("keydown", (e) => {
        if ((e.metaKey || e.ctrlKey) && e.key === "k") {
            e.preventDefault();
            openSearch();
        } else if (e.key === "Escape") {
            closeSearch();
            closeMobileDrawer();
        }
    });

    if (searchModal) {
        searchModal.addEventListener("click", (e) => {
            if (e.target === searchModal) {
                closeSearch();
            }
        });
    }

    // Live Instant Autocomplete (0ms latency from local index)
    let debounceTimer;
    if (searchInput && searchResults) {
        searchInput.addEventListener("input", () => {
            clearTimeout(debounceTimer);
            const query = searchInput.value.trim();

            if (query.length < 2) {
                searchResults.innerHTML = "";
                return;
            }

            debounceTimer = setTimeout(() => {
                queryIndex(query, 8).then(items => {
                    if (!items || items.length === 0) {
                        const emptyMsg = loc === "tr" 
                            ? `"${escapeHtml(query)}" ile eşleşen model bulunamadı.<br><a href="${locPrefix}/products" style="text-decoration: underline; color: var(--c-forest); margin-top: 0.5rem; display: inline-block;">Tüm Ürünleri İncele</a>`
                            : (loc === "cs"
                                ? `Pro "${escapeHtml(query)}" nebyly nalezeny žádné modely.<br><a href="${locPrefix}/products" style="text-decoration: underline; color: var(--c-forest); margin-top: 0.5rem; display: inline-block;">Procházet všechny produkty</a>`
                                : `No models found for "${escapeHtml(query)}".<br><a href="${locPrefix}/products" style="text-decoration: underline; color: var(--c-forest); margin-top: 0.5rem; display: inline-block;">Browse All Collections</a>`);
                        searchResults.innerHTML = `<div style="padding: 1.5rem; text-align: center; color: var(--c-muted); font-size: 0.875rem;">${emptyMsg}</div>`;
                        return;
                    }

                    const viewText = loc === "tr" ? "İncele &rarr;" : (loc === "cs" ? "Zobrazit &rarr;" : "View &rarr;");
                    const viewAllText = loc === "tr" ? "Tüm Eşleşen Modelleri Gör &rarr;" : (loc === "cs" ? "Zobrazit všechny výsledky &rarr;" : "View All Matching Products &rarr;");

                    let html = "<div style="display: flex; flex-direction: column; gap: 0.25rem;">";
                    items.forEach(p => {
                        const targetUrl = `${locPrefix}/products/${p.slug}`;
                        const displayName = p["name_" + loc] || p.name_en || p.name_tr || p.sku;
                        const displayCat = p["category_" + loc] || p.category_name_en || p.category_name || "";
                        const img = p.image || "/assets/images/brand/placeholder.png";

                        html += `
                            <a href="${escapeHtml(targetUrl)}" class="search-result-item">
                                <img src="${escapeHtml(img)}" alt="${escapeHtml(displayName)}" class="search-item-thumb" width="50" height="50" loading="lazy">
                                <div style="flex-grow: 1;">
                                    <div style="font-size: 0.875rem; font-weight: 600; color: var(--c-obsidian);">${escapeHtml(displayName)}</div>
                                    <div style="font-size: 0.75rem; font-family: var(--font-mono); color: var(--c-eucalyptus);">${escapeHtml(p.sku)} &bull; ${escapeHtml(displayCat)}</div>
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
                }).catch(() => {
                    searchResults.innerHTML = "<div style="padding: 1rem; color: #b03a2e; font-size: 0.875rem;">Search unavailable.</div>";
                });
            }, 100);
        });
    }

    // 3. Search Page Dynamic Client-Side Hydration
    const searchPageGrid = document.getElementById("search-results-grid");
    const searchPageTitle = document.getElementById("search-page-title");
    const searchPageDesc = document.getElementById("search-page-desc");
    const searchPageInput = document.getElementById("search-page-input");

    if (searchPageGrid && searchPageInput) {
        const urlParams = new URLSearchParams(window.location.search);
        const queryParam = urlParams.get("q");
        if (queryParam && queryParam.trim() !== "") {
            const cleanQuery = queryParam.trim();
            searchPageInput.value = cleanQuery;

            queryIndex(cleanQuery, 0).then(matches => {
                const count = matches.length;
                if (searchPageTitle) {
                    const titleText = loc === "tr"
                        ? `Arama Sonuçları: "${cleanQuery}"`
                        : (loc === "cs" ? `Výsledky vyhledávání: "${cleanQuery}"` : `Search Results for "${cleanQuery}"`);
                    searchPageTitle.textContent = titleText;
                }
                if (searchPageDesc) {
                    const descText = loc === "tr"
                        ? `Arama kriterlerinize uyan ${count} onaylı model bulundu.`
                        : (loc === "cs" ? `Nalezeno ${count} certifikovaných modelů odpovídajících vašemu dotazu.` : `Found ${count} certified models matching your criteria.`);
                    searchPageDesc.textContent = descText;
                }

                if (count === 0) {
                    const noResultsMsg = loc === "tr"
                        ? `<div style="grid-column: 1 / -1; background-color: var(--c-white); border: 1px solid var(--c-divider); border-radius: var(--radius-md); padding: 4rem 2rem; text-align: center;">
                            <h3 style="font-size: 1.25rem; color: var(--c-obsidian);">Aradığınız kriterlere uygun model bulunamadı</h3>
                            <p style="color: var(--c-muted); margin-top: 0.75rem; max-width: 500px; margin-left: auto; margin-right: auto;">Lütfen girdiğiniz ürün kodunu (örn. 1620-111 veya 1610-242) kontrol ediniz veya doğrudan mimari koleksiyonlarımızı inceleyiniz.</p>
                            <div style="margin-top: 2rem; display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                                <a href="${locPrefix}/products" class="btn btn-primary">Tüm Ürünler</a>
                                <a href="${locPrefix}/collections" class="btn btn-secondary">Koleksiyonlar</a>
                            </div>
                           </div>`
                        : (loc === "cs"
                            ? `<div style="grid-column: 1 / -1; background-color: var(--c-white); border: 1px solid var(--c-divider); border-radius: var(--radius-md); padding: 4rem 2rem; text-align: center;">
                                <h3 style="font-size: 1.25rem; color: var(--c-obsidian);">Nebyly nalezeny žádné odpovídající modely</h3>
                                <p style="color: var(--c-muted); margin-top: 0.75rem; max-width: 500px; margin-left: auto; margin-right: auto;">Zkontrolujte prosím formát kódu SKU (např. 1620-111 nebo 1610-242) nebo si prohlédněte naše kolekce přímo.</p>
                                <div style="margin-top: 2rem; display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                                    <a href="${locPrefix}/products" class="btn btn-primary">Všechny produkty</a>
                                    <a href="${locPrefix}/collections" class="btn btn-secondary">Kolekce</a>
                                </div>
                               </div>`
                            : `<div style="grid-column: 1 / -1; background-color: var(--c-white); border: 1px solid var(--c-divider); border-radius: var(--radius-md); padding: 4rem 2rem; text-align: center;">
                                <h3 style="font-size: 1.25rem; color: var(--c-obsidian);">No matching models found</h3>
                                <p style="color: var(--c-muted); margin-top: 0.75rem; max-width: 500px; margin-left: auto; margin-right: auto;">Please verify your SKU code formatting or browse our architectural collections directly.</p>
                                <div style="margin-top: 2rem; display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                                    <a href="${locPrefix}/products" class="btn btn-primary">All Products</a>
                                    <a href="${locPrefix}/collections" class="btn btn-secondary">Collections</a>
                                </div>
                               </div>`);
                    searchPageGrid.innerHTML = noResultsMsg;
                } else {
                    const viewSpecsText = loc === "tr" ? "Teknik Detaylar" : (loc === "cs" ? "Technické specifikace" : "View Specifications");
                    const featText = loc === "tr" ? "Öne Çıkan" : (loc === "cs" ? "Doporučeno" : "Featured");

                    let cardsHtml = "";
                    matches.forEach(p => {
                        const targetUrl = `${locPrefix}/products/${p.slug}`;
                        const displayName = p["name_" + loc] || p.name_en || p.name_tr || p.sku;
                        const displayCat = p["category_" + loc] || p.category_name_en || p.category_name || "";
                        const featBadge = p.is_featured ? `<span class="product-badge-featured">${featText}</span>` : "";
                        const dims = p.dimensions || "600 x 420 x 145 mm";

                        cardsHtml += `
                            <article class="product-card" itemscope itemtype="https://schema.org/Product">
                                <div class="product-img-box">
                                    <span class="product-sku-tag" itemprop="sku">${escapeHtml(p.sku)}</span>
                                    ${featBadge}
                                    <a href="${escapeHtml(targetUrl)}" tabindex="-1" aria-hidden="true" style="display: block; width: 100%; height: 100%;">
                                        <img src="${escapeHtml(p.image || "/assets/images/brand/placeholder.png")}" 
                                             alt="${escapeHtml(displayName)}" 
                                             width="400" 
                                             height="400" 
                                             loading="lazy" 
                                             decoding="async" 
                                             itemprop="image">
                                    </a>
                                </div>
                                <div class="product-info">
                                    <span class="product-category-label">${escapeHtml(displayCat)}</span>
                                    <h3 class="product-card-title" itemprop="name">
                                        <a href="${escapeHtml(targetUrl)}">${escapeHtml(displayName)}</a>
                                    </h3>
                                    <div class="product-card-specs">
                                        <span class="product-dim-text">${escapeHtml(dims)}</span>
                                        <a href="${escapeHtml(targetUrl)}" class="product-view-link">
                                            <span>${viewSpecsText}</span>
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        `;
                    });
                    searchPageGrid.innerHTML = cardsHtml;
                }
            });
        }
    }

    // 4. Contact Form B2B Handler (Edge Resilience)
    const contactForm = document.querySelector("form[action="/contact/submit"]");
    if (contactForm) {
        contactForm.addEventListener("submit", (e) => {
            const companyInput = contactForm.querySelector("[name="company_name"]");
            const nameInput = contactForm.querySelector("[name="contact_name"]");
            const emailInput = contactForm.querySelector("[name="email"]");
            const phoneInput = contactForm.querySelector("[name="phone"]");
            const skuInput = contactForm.querySelector("[name="product_sku"]");
            const typeInput = contactForm.querySelector("[name="inquiry_type"]");
            const msgInput = contactForm.querySelector("[name="message"]");

            if (!nameInput || !emailInput || !msgInput) return;
            if (!nameInput.value.trim() || !emailInput.value.trim() || !msgInput.value.trim()) {
                return; // Standard validation
            }

            // Handle smoothly client-side
            const isStaticHost = window.location.hostname.includes("vercel.app") || window.location.protocol === "file:" || window.location.port !== "";
            if (isStaticHost) {
                e.preventDefault();

                const company = companyInput ? companyInput.value.trim() : "";
                const name = nameInput.value.trim();
                const email = emailInput.value.trim();
                const phone = phoneInput ? phoneInput.value.trim() : "";
                const sku = skuInput ? skuInput.value.trim() : "";
                const inquiryType = typeInput ? typeInput.value : "quote";
                const message = msgInput.value.trim();

                const submitBtn = contactForm.querySelector("button[type="submit"]");
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = "<span>Talebiniz Alındı...</span>";
                }

                const formattedInquiry = `*LUFLY B2B INQUIRY*
` +
                    `Company: ${company || "N/A"}
` +
                    `Contact: ${name}
` +
                    `Email: ${email}
` +
                    `Phone: ${phone || "N/A"}
` +
                    `Target SKU: ${sku || "General Catalog"}
` +
                    `Type: ${inquiryType}
` +
                    `Message: ${message}`;

                const successDiv = document.createElement("div");
                successDiv.style.cssText = "background: #edf7ed; border: 1px solid #c8e6c9; border-radius: 4px; padding: 1.5rem; margin-top: 1.5rem; color: #1e4620;";

                const successTitle = loc === "tr" ? "Talebiniz Başarıyla Hazırlandı!" : (loc === "cs" ? "Vaše poptávka je připravena!" : "Inquiry Formatted Successfully!");
                const successText = loc === "tr" 
                    ? "Talebiniz kaydedildi. İhracat departmanımıza iletmek için doğrudan WhatsApp veya e-posta seçeneklerini kullanabilirsiniz:"
                    : (loc === "cs" 
                        ? "Vaše poptávka byla zaznamenána. Pro odeslání do výrobního závodu použijte WhatsApp nebo e-mail:"
                        : "Your inquiry has been formatted. For direct factory routing, select WhatsApp or Email dispatch below:");

                const waUrl = `https://wa.me/908503040817?text=${encodeURIComponent(formattedInquiry)}`;
                const mailtoUrl = `mailto:export@lufly.tr?subject=${encodeURIComponent("B2B Quote Request: " + (sku || company || name))}&body=${encodeURIComponent(formattedInquiry)}`;

                successDiv.innerHTML = `
                    <div style="font-weight: 700; font-size: 1.05rem; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        ${successTitle}
                    </div>
                    <p style="font-size: 0.875rem; line-height: 1.5; margin-bottom: 1.25rem;">${successText}</p>
                    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                        <a href="${waUrl}" target="_blank" rel="noopener" class="btn" style="background-color: #25D366; color: #fff; padding: 0.65rem 1.25rem; font-size: 0.875rem; text-decoration: none; border-radius: 4px; font-weight: 600;">
                            <span>WhatsApp ile İlet &rarr;</span>
                        </a>
                        <a href="${mailtoUrl}" class="btn btn-secondary" style="padding: 0.65rem 1.25rem; font-size: 0.875rem; text-decoration: none;">
                            <span>E-posta ile Gönder (export@lufly.tr)</span>
                        </a>
                    </div>
                `;

                contactForm.appendChild(successDiv);
                contactForm.reset();
                if (submitBtn) {
                    submitBtn.style.display = "none";
                }
            }
        });
    }

    function escapeHtml(str) {
        if (!str) return "";
        return String(str)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
});
