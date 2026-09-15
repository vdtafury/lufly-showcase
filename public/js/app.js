/**
 * Lufly Factory Showcase & Digital Catalog Application Logic
 * European Luxury Sanitary Ceramics & Architectural Ware
 * Zero-dependency, high-performance vanilla JavaScript
 */

let allProducts = [];
let filteredProducts = [];
let currentCategory = 'all';
let searchQuery = '';
let currentPage = 1;
const itemsPerPage = 12;

// Official Lufly Contact Configuration
const LUFLY_CONFIG = {
  phone: '+90 850 3040 817',
  whatsappNumber: '908503040817',
  email: 'info@lufly.tr',
  companyName: 'LUFLY İNŞAAT SANAYİ VE TİCARET LİMİTED ŞİRKETİ',
  city: 'Gaziantep, Türkiye'
};

/**
 * Multi-lingual Translation Dictionary
 * Maps legacy catalog labels and Czech/foreign descriptions into pristine European architectural English
 */
const translationDictionary = [
  { match: /WC mísa zav\s*ěšená na stěně bez sed\s*átka/i, title: 'Wall-Hung Rimless Toilet Bowl (Excl. Seat)' },
  { match: /toaletní mísa závěsná bez sedátka/i, title: 'Wall-Hung Rimless Toilet Bowl (Excl. Seat)' },
  { match: /Závěsná toaletní mísa bez sedátka/i, title: 'Wall-Hung Rimless Toilet Bowl (Excl. Seat)' },
  { match: /Závěsná toaleta/i, title: 'Wall-Hung Vitreous Toilet' },
  { match: /Závěsné WC/i, title: 'Wall-Hung Vitreous Toilet' },
  { match: /nást\s*ěnné bidet bez víka/i, title: 'Wall-Hung Luxury Ceramic Bidet' },
  { match: /umývadlo na desce/i, title: 'Luxury Countertop Ceramic Washbasin' },
  { match: /Umyvadlo na desku/i, title: 'Luxury Countertop Ceramic Washbasin' },
  { match: /UMYVADLA NA DESKÁCH POUŽITELNÁ PRO STOJACÍ A ZÁVĚSNÉ SKŘÍ\s*NĚ DUERO/i, title: 'Duero Countertop Vanity Washbasin' },
  { match: /VYTVOŘENO PRO KOUPELNÉ MÍSTNOSTI/i, title: (p) => (p && p.category === 'Vanity & Cabinets') ? 'Duero Architectural Vanity Cabinet Unit' : 'Duero Architectural Designer Washbasin' },
  { match: /poloviční piedestal pro umyvadlo/i, title: 'Vitreous Semi-Pedestal for Washbasin' },
  { match: /Polovina podstavce pro umyvadlo/i, title: 'Vitreous Semi-Pedestal for Washbasin' },
  { match: /Poloviční podstavec pro umyvadlo/i, title: 'Vitreous Semi-Pedestal for Washbasin' },
  { match: /měkké zavírání sedadla,\s*duroplast/i, title: 'Soft-Close Duroplast Toilet Seat & Cover' },
  { match: /tichý uzavírací sedák/i, title: 'Soft-Close Duroplast Toilet Seat & Cover' },
  { match: /Nástěnné umyvadlo pro děti - Dekorativní typ/i, title: "Wall-Hung Children's Washbasin (Decorative)" },
  { match: /nástěnný toaletní pant pro děti/i, title: "Children's Wall-Hung Toilet Hinge Mechanism" },
  { match: /Okružní tlačítko na splachování, dvě funkce, chrom/i, title: 'Dual-Flush Round Actuator Plate (Polished Chrome)' }
];

/**
 * formatEnglishTitle(product)
 * Transforms product metadata into clean, descriptive English titles
 */
function formatEnglishTitle(product) {
  if (!product) return '';
  const raw = product.name || '';

  for (const item of translationDictionary) {
    if (item.match.test(raw)) {
      const base = typeof item.title === 'function' ? item.title(product) : item.title;
      return product.sku ? `${base} - SKU: ${product.sku}` : base;
    }
  }

  // Format pipe separators and clean up raw code prefixes
  let cleaned = raw
    .replace(/\s*\|\s*Kod:\s*/gi, ' | SKU: ')
    .replace(/\s*\|\s*(\d{4}-\d{3})/g, ' | SKU: $1')
    .trim();

  // Normalize all-caps legacy headings to sentence case
  if (cleaned.length > 25 && cleaned === cleaned.toUpperCase()) {
    cleaned = cleaned.charAt(0) + cleaned.slice(1).toLowerCase();
  }

  return cleaned;
}

/**
 * HTML Entity Escape Utility (Security / XSS Protection)
 */
function escapeHTML(str) {
  if (str == null) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#39;');
}

/**
 * Debounce utility (180ms delay for high responsiveness without jank)
 */
function debounce(fn, delay = 180) {
  let timer;
  return function (...args) {
    clearTimeout(timer);
    timer = setTimeout(() => fn.apply(this, args), delay);
  };
}

document.addEventListener('DOMContentLoaded', async () => {
  await loadProducts();
  setupEventListeners();
});

async function loadProducts() {
  try {
    const res = await fetch('/data/products.json');
    if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
    allProducts = await res.json();
    filteredProducts = [...allProducts];
    updateCategoryCounts();
    renderProducts();
  } catch (err) {
    console.error("Failed to load Lufly product catalog:", err);
    const grid = document.getElementById('products-grid');
    if (grid) {
      grid.innerHTML = `
        <div class="col-span-full py-16 text-center text-gray-500">
          <p class="font-medium">Connecting to production database...</p>
          <button onclick="loadProducts()" class="mt-4 px-4 py-2 text-xs rounded-lg bg-[#163e30] text-white">Retry</button>
        </div>`;
    }
  }
}

function updateCategoryCounts() {
  const counts = { all: allProducts.length };
  allProducts.forEach(p => {
    if (p.category) {
      counts[p.category] = (counts[p.category] || 0) + 1;
    }
  });

  const countElements = document.querySelectorAll('[data-cat-count]');
  countElements.forEach(el => {
    const cat = el.getAttribute('data-cat-count');
    if (counts[cat] !== undefined) {
      el.textContent = counts[cat];
    }
  });
}

function filterProducts() {
  const searchLower = searchQuery.toLowerCase().trim();
  filteredProducts = allProducts.filter(p => {
    const matchesCat = (currentCategory === 'all' || p.category === currentCategory);
    if (!matchesCat) return false;
    if (!searchLower) return true;

    const engTitle = formatEnglishTitle(p).toLowerCase();
    const origName = (p.name || '').toLowerCase();
    const sku = (p.sku || '').toLowerCase();
    const desc = (p.description || '').toLowerCase();

    return engTitle.includes(searchLower) ||
           origName.includes(searchLower) ||
           sku.includes(searchLower) ||
           desc.includes(searchLower);
  });

  currentPage = 1;
  renderProducts();
}

function renderProducts() {
  const grid = document.getElementById('products-grid');
  const countDisplay = document.getElementById('results-count');
  const loadMoreBtn = document.getElementById('load-more-btn');

  if (!grid) return;

  if (countDisplay) {
    countDisplay.textContent = `Showing ${filteredProducts.length} certified designs`;
  }

  if (filteredProducts.length === 0) {
    grid.innerHTML = `
      <div class="col-span-full py-16 text-center">
        <div class="inline-flex p-4 rounded-full bg-emerald-50 text-[#163e30] mb-3">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-[#0f2d22]">No matching products found</h3>
        <p class="text-gray-500 mt-1">Try searching with a different product code or clear filters.</p>
        <button onclick="clearSearch()" class="mt-4 px-5 py-2 rounded-lg bg-[#163e30] text-white text-sm font-medium hover:bg-[#0f2d22] transition">Reset Search</button>
      </div>`;
    if (loadMoreBtn) loadMoreBtn.classList.add('hidden');
    return;
  }

  const endIndex = currentPage * itemsPerPage;
  const currentBatch = filteredProducts.slice(0, endIndex);

  grid.innerHTML = currentBatch.map(p => {
    const rawTitle = formatEnglishTitle(p);
    const title = escapeHTML(rawTitle);
    const sku = escapeHTML(p.sku || '');
    const category = escapeHTML(p.category || '');
    const desc = escapeHTML(p.description || 'Premium architectural vitreous ceramic engineered to European sanitary standards.');
    const image = escapeHTML(p.image || '');
    const id = Number(p.id);
    const altText = `${title} - Lufly European Sanitary Ware (${sku})`;

    return `
      <div class="luxury-card bg-white rounded-2xl overflow-hidden flex flex-col justify-between shadow-sm group">
        <div class="relative overflow-hidden bg-gray-50 aspect-square p-6 flex items-center justify-center cursor-pointer" onclick="openQuickView(${id})">
          <img 
            src="${image}" 
            alt="${altText}" 
            width="400"
            height="400"
            loading="lazy"
            decoding="async"
            class="w-full h-full object-contain group-hover:scale-105 transition duration-500"
            onerror="this.src='/images/logo.png'; this.classList.add('opacity-40', 'p-8');"
          />
          <div class="absolute top-3 left-3">
            <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-md bg-[#e8f0ea] text-[#163e30]">
              ${category}
            </span>
          </div>
          <div class="absolute top-3 right-3">
            <span class="inline-block px-2 py-0.5 text-xs font-mono font-medium rounded bg-gray-100 text-gray-700">
              ${sku}
            </span>
          </div>
        </div>

        <div class="p-5 flex flex-col flex-grow justify-between">
          <div>
            <h3 class="font-bold text-[#0f2d22] text-base leading-snug line-clamp-2 hover:text-[#163e30] cursor-pointer" onclick="openQuickView(${id})">
              ${title}
            </h3>
            <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed">
              ${desc}
            </p>
          </div>

          <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
            <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Factory Direct
            </span>
            <div class="flex gap-2">
              <button onclick="openQuickView(${id})" class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-700 hover:border-[#163e30] hover:text-[#163e30] transition">
                Specs
              </button>
              <button onclick="inquireProduct(${id})" class="px-3.5 py-1.5 rounded-lg bg-[#163e30] hover:bg-[#0f2d22] text-xs font-medium text-white transition flex items-center gap-1" aria-label="Inquire about ${title}">
                <span>Inquire</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    `;
  }).join('');

  if (loadMoreBtn) {
    if (endIndex < filteredProducts.length) {
      loadMoreBtn.classList.remove('hidden');
    } else {
      loadMoreBtn.classList.add('hidden');
    }
  }
}

function loadMore() {
  currentPage++;
  renderProducts();
}

function clearSearch() {
  searchQuery = '';
  currentCategory = 'all';
  const input = document.getElementById('search-input');
  if (input) input.value = '';
  document.querySelectorAll('.cat-pill').forEach(btn => {
    btn.classList.toggle('active-cat', btn.getAttribute('data-cat') === 'all');
  });
  filterProducts();
}

function setupEventListeners() {
  const searchInput = document.getElementById('search-input');
  if (searchInput) {
    // 180ms debounced search for lightning fast, stutter-free performance
    const debouncedFilter = debounce((query) => {
      searchQuery = query;
      filterProducts();
    }, 180);

    searchInput.addEventListener('input', (e) => {
      debouncedFilter(e.target.value);
    });
  }

  const catButtons = document.querySelectorAll('.cat-pill');
  catButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      catButtons.forEach(b => b.classList.remove('bg-[#163e30]', 'text-white'));
      catButtons.forEach(b => b.classList.add('bg-white', 'text-gray-700'));
      btn.classList.remove('bg-white', 'text-gray-700');
      btn.classList.add('bg-[#163e30]', 'text-white');
      currentCategory = btn.getAttribute('data-cat');
      filterProducts();
    });
  });

  const loadMoreBtn = document.getElementById('load-more-btn');
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', loadMore);
  }

  // Backdrop click listener to close quick-modal
  const quickModal = document.getElementById('quick-modal');
  if (quickModal) {
    quickModal.addEventListener('click', (e) => {
      if (e.target === quickModal) {
        closeModal();
      }
    });
  }

  // Escape key listener to close quick-modal
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      const modal = document.getElementById('quick-modal');
      if (modal && !modal.classList.contains('hidden')) {
        closeModal();
      }
    }
  });

  // Mobile navigation hamburger menu toggle
  const mobileMenuBtn = document.getElementById('mobile-menu-btn');
  const mobileNavDrawer = document.getElementById('mobile-nav-drawer');
  if (mobileMenuBtn && mobileNavDrawer) {
    mobileMenuBtn.addEventListener('click', () => {
      const isExpanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
      mobileMenuBtn.setAttribute('aria-expanded', String(!isExpanded));
      mobileNavDrawer.classList.toggle('hidden');
    });

    mobileNavDrawer.querySelectorAll('.mobile-nav-link').forEach(link => {
      link.addEventListener('click', () => {
        mobileNavDrawer.classList.add('hidden');
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
      });
    });
  }
}

function openQuickView(id) {
  const numericId = Number(id);
  const p = allProducts.find(item => Number(item.id) === numericId);
  if (!p) return;

  const modal = document.getElementById('quick-modal');
  const content = document.getElementById('modal-content');
  if (!modal || !content) return;

  const rawTitle = formatEnglishTitle(p);
  const title = escapeHTML(rawTitle);
  const sku = escapeHTML(p.sku || '');
  const category = escapeHTML(p.category || '');
  const desc = escapeHTML(p.description || 'Premium architectural vitreous ceramic.');
  const image = escapeHTML(p.image || '');
  const safeId = Number(p.id);
  const altText = `${title} - Lufly European Sanitary Ware (${sku})`;

  content.innerHTML = `
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-8">
      <div class="bg-gray-50 rounded-2xl p-6 flex items-center justify-center aspect-square overflow-hidden border border-gray-100">
        <img 
          src="${image}" 
          alt="${altText}" 
          width="400"
          height="400"
          decoding="async"
          class="w-full h-full object-contain" 
        />
      </div>

      <div class="flex flex-col justify-between">
        <div>
          <div class="flex items-center gap-2 mb-2">
            <span class="px-2.5 py-0.5 rounded text-xs font-semibold bg-[#e8f0ea] text-[#163e30]">${category}</span>
            <span class="px-2 py-0.5 rounded text-xs font-mono bg-gray-100 text-gray-700">SKU: ${sku}</span>
          </div>

          <h3 id="modal-title" class="text-2xl font-bold text-[#0f2d22] leading-tight">${title}</h3>
          <p class="text-gray-600 mt-4 text-sm leading-relaxed">${desc}</p>

          <div class="mt-6 space-y-2 border-t border-b border-gray-100 py-4">
            <div class="flex justify-between text-xs py-1">
              <span class="text-gray-500 font-medium">Material Composition:</span>
              <span class="text-gray-900 font-semibold">100% Vitreous China (High-Fire 1250°C)</span>
            </div>
            <div class="flex justify-between text-xs py-1">
              <span class="text-gray-500 font-medium">Manufacturing Origin:</span>
              <span class="text-gray-900 font-semibold">Gaziantep, Türkiye (European Standards)</span>
            </div>
            <div class="flex justify-between text-xs py-1">
              <span class="text-gray-500 font-medium">Hygiene Surface:</span>
              <span class="text-gray-900 font-semibold">Antibacterial Nano-Shield Glaze</span>
            </div>
            <div class="flex justify-between text-xs py-1">
              <span class="text-gray-500 font-medium">Factory Guarantee:</span>
              <span class="text-gray-900 font-semibold">10 Years Structural Warranty</span>
            </div>
            <div class="flex justify-between text-xs py-1">
              <span class="text-gray-500 font-medium">Certification:</span>
              <span class="text-gray-900 font-semibold">CE & EN 997 Compliant</span>
            </div>
          </div>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row gap-3">
          <button onclick="inquireProduct(${safeId})" class="flex-1 py-3 px-5 rounded-xl bg-[#163e30] hover:bg-[#0f2d22] text-white font-medium text-sm transition flex items-center justify-center gap-2 shadow-lg shadow-emerald-900/10">
            <svg class="w-4 h-4 text-emerald-300" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
            <span>Request Factory Quote</span>
          </button>
          <button onclick="closeModal()" class="py-3 px-5 rounded-xl border border-gray-200 text-gray-700 font-medium text-sm hover:bg-gray-50 transition">
            Close
          </button>
        </div>
      </div>
    </div>`;

  modal.classList.remove('hidden');
}

function closeModal() {
  const modal = document.getElementById('quick-modal');
  if (modal) modal.classList.add('hidden');
}

/**
 * Direct WhatsApp inquiry with official factory phone number
 */
function inquireProduct(id) {
  const numericId = Number(id);
  const p = allProducts.find(item => Number(item.id) === numericId);
  if (!p) return;
  const title = formatEnglishTitle(p);
  const message = encodeURIComponent(`Hello Lufly Factory Team, I would like to inquire about specifications and B2B pricing for: ${title} (SKU: ${p.sku})`);
  window.open(`https://wa.me/${LUFLY_CONFIG.whatsappNumber}?text=${message}`, '_blank', 'noopener,noreferrer');
}
