<!-- ARTICLE READER HERO HEADER -->
<section class="pt-32 pb-12 px-8 md:px-16 max-w-4xl mx-auto relative z-20 space-y-6 text-left">
    
    <!-- Back link & Meta -->
    <div class="flex items-center justify-between pb-4 border-b border-borderGray">
        <a href="<?= BASE_URL; ?>/index.php?route=news" class="inline-flex items-center space-x-2 text-xs uppercase tracking-[0.2em] font-medium text-gray-400 hover:text-white transition-colors">
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
    <div class="aspect-[16/9] w-full rounded-3xl overflow-hidden border border-borderGray bg-surface shadow-2xl relative">
        <?php 
        $imgSrc = $article['image'];
        if (strpos($imgSrc, 'http') === 0 || strpos($imgSrc, 'data:') === 0) {
            $imgUrl = $imgSrc;
        } else {
            $imgUrl = BASE_URL . '/public/images/' . $imgSrc;
        }
        ?>
        <img src="<?= htmlspecialchars($imgUrl); ?>" alt="<?= htmlspecialchars($article['title']); ?>" class="w-full h-full object-cover">
    </div>
</section>

<!-- ARTICLE BODY CONTENT -->
<section class="px-8 md:px-16 max-w-4xl mx-auto relative z-20 pb-32">
    
    <div class="font-sans text-sm md:text-base text-gray-300 font-light leading-relaxed tracking-wide space-y-6 editorial-content max-w-3xl">
        <?= $article['content']; ?>
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
