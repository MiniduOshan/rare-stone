<!-- EDITORIAL HEADER SECTION -->
<section class="pt-28 pb-8 px-8 md:px-16 max-w-7xl mx-auto relative z-20 border-b border-borderGray mb-8">
    <div class="max-w-3xl space-y-4">
        <h1 class="font-serif text-5xl md:text-6xl text-white font-light tracking-tight leading-tight">
            Editorial & <span class="italic text-gradient">Insight</span>
        </h1>
        <p class="text-sm md:text-base text-gray-400 font-light leading-relaxed max-w-xl tracking-wide">
            Market analysis, authentic origin reporting, and private collecting strategies for high-net-worth individuals.
        </p>
    </div>
</section>

<!-- MAIN EDITORIAL GRID -->
<section class="pb-32 px-8 md:px-16 max-w-7xl mx-auto relative z-20">
    <?php
    $featured = null;
    $others = [];
    if (!empty($articles)) {
        $featured = $articles[0];
        $others = array_slice($articles, 1);
    }
    ?>

    <?php if ($featured): ?>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-16">
        
        <!-- Left Column: Featured Main Article -->
        <div class="lg:col-span-7 space-y-6 lg:border-r lg:border-borderGray lg:pr-16">
            <a href="<?= BASE_URL; ?>/index.php?route=article&id=<?= urlencode($featured['slug']); ?>" class="block relative aspect-[16/10] bg-surface rounded-2xl overflow-hidden border border-borderGray shadow-2xl group cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-t from-dark/80 via-transparent to-transparent z-10 opacity-60 group-hover:opacity-40 transition-opacity"></div>
                <?php 
                $imgSrc = $featured['image'];
                if (strpos($imgSrc, 'http') === 0 || strpos($imgSrc, 'data:') === 0) {
                    $imgUrl = $imgSrc;
                } else {
                    $imgUrl = BASE_URL . '/public/images/' . $imgSrc;
                }
                ?>
                <img src="<?= htmlspecialchars($imgUrl); ?>" alt="<?= htmlspecialchars($featured['title']); ?>" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 z-0">
            </a>

            <div class="flex items-center space-x-3 text-[10px] tracking-[0.2em] uppercase font-medium">
                <span class="text-gold"><?= htmlspecialchars(explode('•', $featured['meta'])[0] ?? 'Insight'); ?></span>
                <span class="text-gray-600">•</span>
                <span class="text-gray-500 flex items-center space-x-1">
                    <i data-lucide="clock" class="w-3 h-3"></i>
                    <span><?= htmlspecialchars(trim(explode('•', $featured['meta'])[1] ?? 'Recent')); ?></span>
                </span>
            </div>

            <h2 class="font-serif text-3xl md:text-4xl text-white font-light leading-tight hover:text-gray-200 transition-colors">
                <a href="<?= BASE_URL; ?>/index.php?route=article&id=<?= urlencode($featured['slug']); ?>"><?= htmlspecialchars($featured['title']); ?></a>
            </h2>

            <p class="text-sm text-gray-400 font-light leading-relaxed tracking-wide">
                <?= htmlspecialchars($featured['subtitle']); ?>
            </p>

            <div class="pt-2">
                <a href="<?= BASE_URL; ?>/index.php?route=article&id=<?= urlencode($featured['slug']); ?>" class="inline-flex items-center space-x-2 text-xs uppercase tracking-[0.2em] font-medium text-white border-b-2 border-white pb-1 group hover:text-gray-300 hover:border-gray-300 transition-all">
                    <span>Read Analysis</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Right Column: Secondary Articles List -->
        <div class="lg:col-span-5 space-y-12">
            
            <?php if (!empty($others)): ?>
                <?php foreach ($others as $art): ?>
                <a href="<?= BASE_URL; ?>/index.php?route=article&id=<?= urlencode($art['slug']); ?>" class="flex flex-col sm:flex-row items-start space-y-4 sm:space-y-0 sm:space-x-6 group cursor-pointer border-b border-borderGray/50 pb-8 last:border-0 block">
                    <div class="relative w-full sm:w-36 h-36 aspect-square bg-surface rounded-xl overflow-hidden flex-shrink-0 border border-borderGray shadow-xl">
                        <?php 
                        $secImgSrc = $art['image'];
                        if (strpos($secImgSrc, 'http') === 0 || strpos($secImgSrc, 'data:') === 0) {
                            $secImgUrl = $secImgSrc;
                        } else {
                            $secImgUrl = BASE_URL . '/public/images/' . $secImgSrc;
                        }
                        ?>
                        <img src="<?= htmlspecialchars($secImgUrl); ?>" alt="<?= htmlspecialchars($art['title']); ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    </div>

                    <div class="space-y-3 font-sans">
                        <div class="flex items-center space-x-2 text-[9px] tracking-[0.2em] uppercase font-medium">
                            <span class="text-gold"><?= htmlspecialchars(explode('•', $art['meta'])[0] ?? 'Insight'); ?></span>
                            <span class="text-gray-600">•</span>
                            <span class="text-gray-500"><?= htmlspecialchars(trim(explode('•', $art['meta'])[1] ?? 'Recent')); ?></span>
                        </div>

                        <h3 class="font-serif text-xl text-white font-light leading-snug group-hover:text-gold transition-colors">
                            <?= htmlspecialchars($art['title']); ?>
                        </h3>

                        <div class="inline-flex items-center space-x-1 text-[11px] uppercase tracking-[0.2em] font-medium text-gray-400 group-hover:text-white transition-colors">
                            <span>Read</span>
                            <i data-lucide="arrow-right" class="w-3 h-3 group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-gray-500 italic font-light">More insights will be published soon.</div>
            <?php endif; ?>

        </div>

    </div>
    <?php else: ?>
        <div class="text-center py-20 text-gray-500 italic font-light">
            No editorial articles have been published yet.
        </div>
    <?php endif; ?>
</section>
