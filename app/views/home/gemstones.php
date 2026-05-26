<!-- GEM STONES COMPACT HEADER -->
<section class="pt-28 pb-6 px-8 md:px-16 max-w-7xl mx-auto relative z-20 border-b border-borderGray mb-8">
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pb-2">
        <div class="space-y-2">
            <div class="text-[10px] tracking-[0.3em] uppercase font-medium text-gold">
                Vault Catalog
            </div>
            <h1 class="font-serif text-4xl md:text-5xl text-white font-light tracking-tight leading-tight">
                Rare & Master-Cut <span class="italic text-gradient">Gem Stones</span>
            </h1>
            <p class="text-xs md:text-sm text-gray-400 font-light max-w-lg tracking-wide">
                Investment-grade natural sapphires, rubies, emeralds, and diamonds with certified provenance.
            </p>
        </div>

        <!-- Category Filter Bar -->
        <div class="flex flex-wrap gap-2 lg:gap-3 text-[11px] uppercase tracking-[0.2em] font-medium">
            <button onclick="filterGems('all', this)"
                class="gem-filter-btn px-5 py-2 rounded-full border border-white text-white bg-white/10 transition-all">All
                Vault</button>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <button onclick="filterGems('<?= htmlspecialchars($cat['slug']); ?>', this)"
                        class="gem-filter-btn px-5 py-2 rounded-full border border-gray-800 text-gray-400 hover:border-gray-500 hover:text-white transition-all"><?= htmlspecialchars($cat['name']); ?></button>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- GEM STONES CATALOG GRID -->
<section class="pb-32 px-8 md:px-16 max-w-7xl mx-auto relative z-20">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10" id="gemstones-grid">
        <?php foreach ($allGemstones as $gem): ?>
            <?php
            // Use category from database, fallback to detection if not set
            $cat = $gem['category'] ?? 'sapphire';

            // Fallback detection if category not stored
            if (empty($cat) || $cat === '') {
                $cat = 'sapphire';
                if (stripos($gem['title'], 'ruby') !== false)
                    $cat = 'ruby';
                elseif (stripos($gem['title'], 'emerald') !== false)
                    $cat = 'emerald';
                elseif (stripos($gem['title'], 'diamond') !== false)
                    $cat = 'diamond';
                elseif (stripos($gem['title'], 'jewelry') !== false || stripos($gem['title'], 'ring') !== false || stripos($gem['title'], 'necklace') !== false || stripos($gem['title'], 'pendant') !== false || stripos($gem['title'], 'earring') !== false || stripos($gem['title'], 'bracelet') !== false)
                    $cat = 'jewelry';
            }
            ?>
            <a href="<?= BASE_URL; ?>/gem/<?= urlencode(Gemstone::buildSlug($gem)); ?>/"
                class="gem-card-item block group cursor-pointer" data-category="<?= htmlspecialchars($cat); ?>">
                <div
                    class="relative aspect-[4/5] bg-surface rounded-xl overflow-hidden mb-4 border border-borderGray group-hover:border-gray-500 transition-all duration-500 shadow-2xl flex items-center justify-center p-6">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-dark/90 via-transparent to-transparent z-10 opacity-60 group-hover:opacity-40 transition-opacity">
                    </div>
                    <?php
                    $imgSrc = $gem['image'] ?? '';
                    $decoded = json_decode($imgSrc, true);
                    if (is_array($decoded) && count($decoded) > 0)
                        $useImg = $decoded[0];
                    else
                        $useImg = $imgSrc;
                    $imgUrl = (strpos((string) $useImg, 'http') === 0 || strpos((string) $useImg, 'data:') === 0) ? $useImg : BASE_URL . '/public/images/' . $useImg;
                    ?>
                    <img src="<?= htmlspecialchars($imgUrl); ?>" alt="<?= htmlspecialchars($gem['title']); ?>"
                        class="max-h-full max-w-full object-contain transform group-hover:scale-110 transition-transform duration-700 drop-shadow-[0_20px_30px_rgba(0,0,0,0.8)] z-0">
                </div>

                <div class="flex items-baseline justify-between text-white font-serif tracking-wide mb-1">
                    <h3 class="text-xl font-light text-gray-100 group-hover:text-white transition-colors">
                        <?= htmlspecialchars($gem['title']); ?></h3>
                    <span
                        class="text-[10px] tracking-[0.2em] uppercase font-sans font-medium text-gray-400 px-2 py-0.5 border border-gray-800 rounded bg-dark">
                        <?= htmlspecialchars($gem['status']); ?>
                    </span>
                </div>

                <div class="flex justify-between text-xs font-light text-gray-500 font-sans tracking-wider pt-1">
                    <span><?= htmlspecialchars($gem['origin']); ?> -
                        <?= htmlspecialchars(Gemstone::getDisplayLocation($gem)); ?></span>
                    <span class="text-gold font-normal"><?= htmlspecialchars($gem['price_tier']); ?></span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<script>
    function filterGems(category, btnElem) {
        // Update button styles
        const buttons = document.querySelectorAll('.gem-filter-btn');
        buttons.forEach(btn => {
            btn.className = "gem-filter-btn px-5 py-2 rounded-full border border-gray-800 text-gray-400 hover:border-gray-500 hover:text-white transition-all";
        });
        btnElem.className = "gem-filter-btn px-5 py-2 rounded-full border border-white text-white bg-white/10 transition-all";

        // Filter items
        const items = document.querySelectorAll('.gem-card-item');
        items.forEach(item => {
            if (category === 'all' || item.getAttribute('data-category') === category) {
                item.style.display = 'block';
                item.classList.add('animate-fade-in');
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>