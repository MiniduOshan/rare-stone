<?php
// Fallbacks if not set in DB
$headline = !empty($article['title']) ? $article['title'] : 'Rare Stones Vaults';
$subtitleText = !empty($article['subtitle']) ? $article['subtitle'] : 'Explore our exclusive island-wide private viewing salons and secure gemological vaults.';

$defaultBranches = [
    [ 'lat' => 6.9271, 'lng' => 79.8612, 'name' => 'Rare Stones - Colombo Gallery', 'city' => 'Colombo, Sri Lanka', 'listings' => '42 active lots' ],
    [ 'lat' => 6.6828, 'lng' => 80.3992, 'name' => 'Rare Stones - Ratnapura Source', 'city' => 'Ratnapura, Sri Lanka', 'listings' => '34 active lots' ],
    [ 'lat' => 6.0329, 'lng' => 80.2168, 'name' => 'Rare Stones - Galle Atelier', 'city' => 'Galle, Sri Lanka', 'listings' => '18 active lots' ],
    [ 'lat' => 6.4750, 'lng' => 79.9958, 'name' => 'Rare Stones - Beruwala Syndicate', 'city' => 'Beruwala, Sri Lanka', 'listings' => '26 active lots' ]
];

$branches = null;
if (!empty($article['content'])) {
    $branches = json_decode($article['content'], true);
}

if (!is_array($branches)) {
    $branches = $defaultBranches;
}

$branchesJson = json_encode($branches);
?>
<!-- MAP DISCOVERY SPLIT VIEW -->
<section class="pt-[72px] md:pt-[88px] h-screen w-full flex flex-col md:flex-row overflow-hidden relative z-20">
    
    <!-- Left Sidebar: Network & Branches List -->
    <div class="w-full md:w-[420px] bg-dark border-r border-borderGray flex flex-col flex-shrink-0 h-[45%] md:h-full z-10">
        
        <!-- Sidebar Header & Search -->
        <div class="p-8 border-b border-borderGray space-y-4">
            <h1 class="font-serif text-3xl md:text-4xl text-white font-light tracking-wide">
                <?= htmlspecialchars($headline); ?>
            </h1>
            <p class="text-xs text-gray-400 font-light leading-relaxed">
                <?= htmlspecialchars($subtitleText); ?>
            </p>

            <!-- Search Input -->
            <div class="relative mt-4">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" id="sellerSearch" onkeyup="filterBranches()" placeholder="Search vaults by city or region..." class="w-full bg-surface border border-gray-800 rounded-xl pl-11 pr-10 py-3 text-xs text-white placeholder-gray-600 focus:outline-none focus:border-gray-500 transition-colors font-light">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gold">
                    <i data-lucide="gem" class="w-4 h-4"></i>
                </div>
            </div>
        </div>

        <!-- Scrollable Branches List -->
        <div class="flex-1 overflow-y-auto p-8 space-y-6 custom-scrollbar" id="branchesList">
            <?php foreach ($branches as $index => $branch): ?>
                <div class="branch-card p-6 bg-surface border border-borderGray rounded-2xl hover:border-gold transition-all cursor-pointer shadow-xl group" onclick="focusMap(<?= $branch['lat'] ?>, <?= $branch['lng'] ?>, '<?= htmlspecialchars(addslashes($branch['name'])) ?>')">
                    <h3 class="font-serif text-xl text-white font-light group-hover:text-gold transition-colors mb-1"><?= htmlspecialchars($branch['name']) ?></h3>
                    <p class="text-xs text-gray-500 font-light mb-6"><?= htmlspecialchars($branch['city']) ?></p>
                    <div class="flex items-center justify-between text-[10px] tracking-[0.15em] uppercase font-medium">
                        <span class="text-gray-400 font-sans">Verified Branch</span>
                        <span class="bg-dark border border-gray-800 text-gray-300 px-2.5 py-1 rounded"><?= htmlspecialchars($branch['listings']) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Right Map Container -->
    <div class="flex-1 h-[55%] md:h-full relative z-0">
        <div id="map" class="w-full h-full"></div>
    </div>

</section>

<!-- Leaflet Map JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let map;
let markers = {};

document.addEventListener('DOMContentLoaded', () => {
    // Initialize map centered on Sri Lanka with tap:false to eliminate Windows pointer vanishing bug
    map = L.map('map', {
        zoomControl: true,
        attributionControl: false,
        tap: false
    }).setView([7.0, 80.5], 8);

    // Add Dark Matter Tile Layer
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);

    // Add custom attribution control
    L.control.attribution({
        position: 'bottomright',
        prefix: '<span style="color:#666; font-size:10px;">Leaflet | &copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" style="color:#888;">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions" target="_blank" style="color:#888;">CARTO</a></span>'
    }).addTo(map);

    // Custom gold pin marker with white center and glowing gold shadow
    const pinSvg = `<svg viewBox="0 0 24 36" width="36" height="54" style="filter: drop-shadow(0px 0px 12px #ffd700); transform-origin: bottom center;"><path d="M12 0C5.373 0 0 5.373 0 12c0 9 12 24 12 24s12-15 12-24c0-6.627-5.373-12-12-12z" fill="#ffd700"/><circle cx="12" cy="12" r="5.5" fill="#ffffff"/></svg>`;
    
    const pinIcon = L.divIcon({
        className: 'custom-svg-pin',
        html: pinSvg,
        iconSize: [36, 54],
        iconAnchor: [18, 54],
        popupAnchor: [0, -50]
    });

    const locations = <?= $branchesJson; ?>;

    locations.forEach(loc => {
        const marker = L.marker([loc.lat, loc.lng], { icon: pinIcon }).addTo(map);
        marker.bindPopup(`
            <div class="p-4 bg-[#111115] text-white font-sans text-xs rounded-xl border border-gray-800 shadow-2xl min-w-[220px]">
                <h4 class="font-serif text-xl font-light text-gold mb-1">${loc.name}</h4>
                <p class="text-[11px] text-gray-400 mb-4">${loc.city}</p>
                <div class="flex items-center justify-between pt-3 border-t border-gray-800/80">
                    <span class="text-[10px] text-gray-500 uppercase tracking-widest">${loc.listings}</span>
                    <button onclick="openModal('inquiryModal', 'Direct Branch Inquiry: ${loc.name}')" class="px-4 py-1.5 bg-white text-black text-[10px] uppercase tracking-widest font-semibold rounded hover:bg-gray-200 transition-colors">Connect</button>
                </div>
            </div>
        `, {
            closeButton: false,
            className: 'custom-popup'
        });

        // Add click listener to sync sidebar selection
        marker.on('click', () => {
            highlightSidebarCard(loc.name);
        });

        markers[loc.name] = marker;
    });

    // Re-render Lucide icons if needed
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

function highlightSidebarCard(branchName) {
    document.querySelectorAll('#branchesList .branch-card').forEach(card => {
        const title = card.querySelector('h3').textContent;
        if (title === branchName) {
            card.classList.add('border-gold', '!bg-[#1a1a24]');
            card.classList.remove('border-borderGray', 'bg-surface');
            card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            card.classList.remove('border-gold', '!bg-[#1a1a24]');
            card.classList.add('border-borderGray', 'bg-surface');
        }
    });
}

function focusMap(lat, lng, name) {
    highlightSidebarCard(name);
    
    if (map && markers[name]) {
        map.flyTo([lat, lng], 11, {
            duration: 1.0
        });

        // Ensure popup opens smoothly after map finishes panning
        setTimeout(() => {
            markers[name].openPopup();
        }, 1050);
    }
}

function filterBranches() {
    const query = document.getElementById('sellerSearch').value.toLowerCase();
    const cards = document.querySelectorAll('#branchesList .branch-card');
    
    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        if (text.includes(query)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

<style>
/* Universal Bulletproof Cursor Rules for Windows Browsers */
#map,
#map *,
.leaflet-container,
.leaflet-container * {
    cursor: auto !important;
}

.leaflet-interactive,
.leaflet-interactive *,
.custom-svg-pin,
.custom-svg-pin * {
    cursor: pointer !important;
}

.leaflet-dragging,
.leaflet-dragging * {
    cursor: move !important;
}

/* Leaflet Custom Popup Styling */
.leaflet-popup-content-wrapper {
    background: #111115 !important;
    color: #fff !important;
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 12px !important;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8) !important;
    padding: 0 !important;
}
.leaflet-popup-content {
    margin: 0 !important;
}
.leaflet-popup-tip {
    background: #111115 !important;
    border: 1px solid rgba(255,255,255,0.12);
}

/* Ensure SVG pins scale perfectly in place without touching Leaflet's 3D positioning transform */
.custom-svg-pin {
    background: transparent;
    border: none;
}
.custom-svg-pin svg {
    transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1), filter 0.2s ease;
}
.custom-svg-pin:hover svg {
    transform: scale(1.25);
    filter: drop-shadow(0px 0px 16px #ffd700) !important;
}
.custom-svg-pin:hover {
    z-index: 1000 !important;
}
</style>
