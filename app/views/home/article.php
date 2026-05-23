<!-- ARTICLE READER HERO HEADER -->
<section class="pt-32 pb-12 px-8 md:px-16 max-w-4xl mx-auto relative z-20 space-y-6 text-left">
    
    <!-- Back link & Meta -->
    <div class="flex items-center justify-between pb-4 border-b border-borderGray">
        <a href="<?= BASE_URL; ?>/news/" class="inline-flex items-center space-x-2 text-xs uppercase tracking-[0.2em] font-medium text-gray-400 hover:text-white transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Back to Editorial Overview</span>
        </a>
        <span class="text-[11px] uppercase tracking-widest font-medium text-gold">
            <?= htmlspecialchars($article['meta']); ?>
        </span>
    </div>

    <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl text-white font-light tracking-tight leading-tight">
        <?= htmlspecialchars($article['title']); ?>
    </h1>

    <p class="text-sm md:text-base text-gray-400 font-light leading-relaxed tracking-wide">
        <?= htmlspecialchars($article['subtitle']); ?>
    </p>

    <!-- Author Row -->
    <div class="flex items-center space-x-4 pt-2">
        <div class="w-10 h-10 rounded-full border border-gray-700 bg-surface flex items-center justify-center text-white">
            <i data-lucide="user" class="w-4 h-4"></i>
        </div>
        <div class="text-left font-sans">
            <div class="text-xs font-medium text-white tracking-wider"><?= htmlspecialchars($article['author']); ?></div>
            <div class="text-[11px] text-gray-500 tracking-wide font-light"><?= htmlspecialchars($article['author_role']); ?></div>
        </div>
    </div>
</section>

<!-- FEATURED IMAGE ALIGNED PERFECTLY WITH CONTENT COLUMN -->
<section class="px-8 md:px-16 max-w-4xl mx-auto relative z-20 mb-12">
    <?php
    // Support multiple images stored as JSON array or a single image string
    $images = [];
    if (!empty($article['image'])) {
        $try = json_decode($article['image'], true);
        if (is_array($try)) {
            $images = $try;
        } else {
            $images = [$article['image']];
        }
    }
    $featuredImg = isset($images[0]) ? $images[0] : '';
    if (strpos((string)$featuredImg, 'http') === 0 || strpos((string)$featuredImg, 'data:') === 0) {
        $featuredUrl = $featuredImg;
    } else {
        $featuredUrl = !empty($featuredImg) ? BASE_URL . '/public/images/' . $featuredImg : '';
    }
    ?>
    <div class="aspect-[16/9] w-full rounded-3xl overflow-hidden border border-borderGray bg-surface shadow-2xl relative">
        <?php if (!empty($featuredUrl)): ?>
            <img src="<?= htmlspecialchars($featuredUrl); ?>" alt="<?= htmlspecialchars($article['title']); ?>" class="w-full h-full object-cover">
        <?php else: ?>
            <div class="w-full h-full flex items-center justify-center text-gray-500">No image available</div>
        <?php endif; ?>
    </div>

    <?php if (count($images) > 1): ?>
    <div class="mt-4 grid grid-cols-4 gap-3 max-w-4xl">
        <?php foreach ($images as $img):
            $url = (strpos((string)$img, 'http') === 0 || strpos((string)$img, 'data:') === 0) ? $img : BASE_URL . '/public/images/' . $img;
        ?>
            <div class="rounded overflow-hidden border border-borderGray bg-dark">
                <img src="<?= htmlspecialchars($url); ?>" alt="" class="w-full h-24 object-cover">
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>

<!-- ARTICLE BODY CONTENT -->
<section class="px-8 md:px-16 max-w-4xl mx-auto relative z-20 pb-32">
    
    <div class="font-sans text-sm md:text-base text-gray-300 font-light leading-relaxed tracking-wide space-y-6 editorial-content max-w-3xl">
        <?php
        $body = $article['content'] ?? '';
        // If body already contains HTML tags, output as-is (it's sanitized on save);
        // otherwise convert newlines to <br> for line-by-line input.
        if ($body !== strip_tags($body)) {
            echo $body;
        } else {
            echo nl2br(htmlspecialchars($body));
        }
        ?>
    </div>

    <!-- Article Footer / CTA -->
    <div class="mt-16 pt-12 border-t border-borderGray flex flex-col sm:flex-row items-center justify-between gap-6 max-w-3xl">
        <div>
            <h4 class="font-serif text-2xl text-white font-light mb-1">Interested in this acquisition?</h4>
            <p class="text-xs text-gray-400 font-light">Request a secure private advisory briefing from our gemology panel.</p>
        </div>
        <button onclick="openModal('inquiryModal', 'Editorial Advisory Briefing: <?= htmlspecialchars($article['title']); ?>')" class="px-8 py-4 bg-white text-black font-medium text-xs tracking-[0.2em] uppercase rounded-full hover:bg-gray-200 transition-all shadow-xl hover:shadow-white/10 flex-shrink-0">
            Request Advisory
        </button>
    </div>

</section>
