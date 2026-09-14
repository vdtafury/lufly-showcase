let allProducts = [];
let filteredProducts = [];
let currentCategory = 'all';
let searchQuery = '';
let currentPage = 1;
const itemsPerPage = 12;

document.addEventListener('DOMContentLoaded', async () => {
  await loadProducts();
  setupEventListeners();
});

async function loadProducts() {
  try {
    const res = await fetch('/data/products.json');
    allProducts = await res.json();
    filteredProducts = [...allProducts];
    updateCategoryCounts();
    renderProducts();
  } catch (err) {
    console.error("Failed to load products:", err);
    document.getElementById('products-grid').innerHTML = `
      <div class="col-span-full py-12 text-center text-gray-500">
        <p>Loading products catalog...</p>
      </div>`;
  }
}

function updateCategoryCounts() {
  const counts = { all: allProducts.length };
  allProducts.forEach(p => {
    counts[p.category] = (counts[p.category] || 0) + 1;
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
  filteredProducts = allProducts.filter(p => {
    const matchesCat = (currentCategory === 'all' || p.category === currentCategory);
    const searchLower = searchQuery.toLowerCase().trim();
    const matchesSearch = !searchQuery || 
      p.name.toLowerCase().includes(searchLower) ||
      p.sku.toLowerCase().includes(searchLower) ||
      (p.description && p.description.toLowerCase().includes(searchLower));
    return matchesCat && matchesSearch;
  });

  currentPage = 1;
  renderProducts();
}

function renderProducts() {
  const grid = document.getElementById('products-grid');
  const countDisplay = document.getElementById('results-count');
  const loadMoreBtn = document.getElementById('load-more-btn');

  if (countDisplay) {
    countDisplay.textContent = `Showing ${filteredProducts.length} designs`;
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

  grid.innerHTML = currentBatch.map(p => `
    <div class="luxury-card bg-white rounded-2xl overflow-hidden flex flex-col justify-between shadow-sm group">
      <div class="relative overflow-hidden bg-gray-50 aspect-square p-6 flex items-center justify-center cursor-pointer" onclick="openQuickView(${p.id})">
        <img 
          src="${p.image}" 
          alt="${p.name}" 
          class="w-full h-full object-contain group-hover:scale-105 transition duration-500"
          loading="lazy"
          onerror="this.src='/images/logo.png'; this.classList.add('opacity-40', 'p-8');"
        />
        <div class="absolute top-3 left-3">
          <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-md bg-[#e8f0ea] text-[#163e30]">
            ${p.category}
          </span>
        </div>
        <div class="absolute top-3 right-3">
          <span class="inline-block px-2 py-0.5 text-xs font-mono font-medium rounded bg-gray-100 text-gray-700">
            ${p.sku}
          </span>
        </div>
      </div>

      <div class="p-5 flex flex-col flex-grow justify-between">
        <div>
          <h4 class="font-bold text-[#0f2d22] text-base leading-snug line-clamp-2 hover:text-[#163e30] cursor-pointer" onclick="openQuickView(${p.id})">
            ${p.name}
          </h4>
          <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed">
            ${p.description || 'Premium architectural ceramic engineered to European sanitary standards.'}
          </p>
        </div>

        <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
          <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Factory Available
          </span>
          <div class="flex gap-2">
            <button onclick="openQuickView(${p.id})" class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-700 hover:border-[#163e30] hover:text-[#163e30] transition">
              Specs
            </button>
            <button onclick="inquireProduct(${p.id})" class="px-3.5 py-1.5 rounded-lg bg-[#163e30] hover:bg-[#0f2d22] text-xs font-medium text-white transition flex items-center gap-1">
              <span>Inquire</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  `).join('');

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
    searchInput.addEventListener('input', (e) => {
      searchQuery = e.target.value;
      filterProducts();
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
}

function openQuickView(id) {
  const p = allProducts.find(item => item.id === id);
  if (!p) return;

  const modal = document.getElementById('quick-modal');
  const content = document.getElementById('modal-content');
  if (!modal || !content) return;

  content.innerHTML = `
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-8">
      <div class="bg-gray-50 rounded-2xl p-6 flex items-center justify-center aspect-square overflow-hidden border border-gray-100">
        <img src="${p.image}" alt="${p.name}" class="w-full h-full object-contain" />
      </div>

      <div class="flex flex-col justify-between">
        <div>
          <div class="flex items-center gap-2 mb-2">
            <span class="px-2.5 py-0.5 rounded text-xs font-semibold bg-[#e8f0ea] text-[#163e30]">${p.category}</span>
            <span class="px-2 py-0.5 rounded text-xs font-mono bg-gray-100 text-gray-700">SKU: ${p.sku}</span>
          </div>

          <h3 class="text-2xl font-bold text-[#0f2d22] leading-tight">${p.name}</h3>
          <p class="text-gray-600 mt-4 text-sm leading-relaxed">${p.description}</p>

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
          </div>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row gap-3">
          <button onclick="inquireProduct(${p.id})" class="flex-1 py-3 px-5 rounded-xl bg-[#163e30] hover:bg-[#0f2d22] text-white font-medium text-sm transition flex items-center justify-center gap-2 shadow-lg shadow-emerald-900/10">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
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

function inquireProduct(id) {
  const p = allProducts.find(item => item.id === id);
  if (!p) return;
  const message = encodeURIComponent(`Hello Lufly Team, I would like to inquire about specifications and B2B pricing for: ${p.name} (SKU: ${p.sku})`);
  // Lufly WhatsApp Direct Factory link
  window.open(`https://wa.me/905320000000?text=${message}`, '_blank');
}

function downloadCatalogAlert() {
  alert("Lufly 2025 Architectural Ceramics & Sanitary Ware Catalog (PDF) download started.");
}
