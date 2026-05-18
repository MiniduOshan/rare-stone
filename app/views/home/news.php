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
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-16">
        
        <!-- Left Column: Featured Main Article -->
        <div class="lg:col-span-7 space-y-6 lg:border-r lg:border-borderGray lg:pr-16">
            <a href="<?= BASE_URL; ?>/index.php?route=article&id=padparadscha" class="block relative aspect-[16/10] bg-surface rounded-2xl overflow-hidden border border-borderGray shadow-2xl group cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-t from-dark/80 via-transparent to-transparent z-10 opacity-60 group-hover:opacity-40 transition-opacity"></div>
                <img src="<?= BASE_URL; ?>/public/images/heritage-hero.jpg" alt="Balcony view" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 z-0">
            </a>

            <div class="flex items-center space-x-3 text-[10px] tracking-[0.2em] uppercase font-medium">
                <span class="text-gold">Market Insight</span>
                <span class="text-gray-600">•</span>
                <span class="text-gray-500 flex items-center space-x-1">
                    <i data-lucide="clock" class="w-3 h-3"></i>
                    <span>May 2, 2026</span>
                </span>
            </div>

            <h2 class="font-serif text-3xl md:text-4xl text-white font-light leading-tight hover:text-gray-200 transition-colors">
                <a href="<?= BASE_URL; ?>/index.php?route=article&id=padparadscha">Sri Lanka Padparadscha Market Hits New High</a>
            </h2>

            <p class="text-sm text-gray-400 font-light leading-relaxed tracking-wide">
                Demand for rare Sri Lankan padparadscha sapphires is surging among collectors seeking luminous pink-orange stones with certified provenance.
            </p>

            <div class="pt-2">
                <a href="<?= BASE_URL; ?>/index.php?route=article&id=padparadscha" class="inline-flex items-center space-x-2 text-xs uppercase tracking-[0.2em] font-medium text-white border-b-2 border-white pb-1 group hover:text-gray-300 hover:border-gray-300 transition-all">
                    <span>Read Analysis</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Right Column: Secondary Articles List -->
        <div class="lg:col-span-5 space-y-12">
            
            <!-- Article 1 -->
            <a href="<?= BASE_URL; ?>/index.php?route=article&id=mining" class="flex flex-col sm:flex-row items-start space-y-4 sm:space-y-0 sm:space-x-6 group cursor-pointer border-b border-borderGray/50 pb-8 last:border-0 block">
                <div class="relative w-full sm:w-36 h-36 aspect-square bg-surface rounded-xl overflow-hidden flex-shrink-0 border border-borderGray shadow-xl">
                    <img src="<?= BASE_URL; ?>/public/images/news-bracelet.jpg" alt="Antique Rose Gold Bracelet" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                </div>

                <div class="space-y-3">
                    <div class="flex items-center space-x-2 text-[9px] tracking-[0.2em] uppercase font-medium">
                        <span class="text-gold">Origin Report</span>
                        <span class="text-gray-600">•</span>
                        <span class="text-gray-500">April 28, 2026</span>
                    </div>

                    <h3 class="font-serif text-xl text-white font-light leading-snug group-hover:text-gold transition-colors">
                        Ratnapura Mining Season: 2026 Quality Outlook
                    </h3>

                    <div class="inline-flex items-center space-x-1 text-[11px] uppercase tracking-[0.2em] font-medium text-gray-400 group-hover:text-white transition-colors">
                        <span>Read</span>
                        <i data-lucide="arrow-right" class="w-3 h-3 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </a>

            <!-- Article 2 -->
            <a href="<?= BASE_URL; ?>/index.php?route=article&id=trends" class="flex flex-col sm:flex-row items-start space-y-4 sm:space-y-0 sm:space-x-6 group cursor-pointer border-b border-borderGray/50 pb-8 last:border-0 block">
                <div class="relative w-full sm:w-36 h-36 aspect-square bg-surface rounded-xl overflow-hidden flex-shrink-0 border border-borderGray shadow-xl">
                    <img src="<?= BASE_URL; ?>/public/images/heritage-earrings.jpg" alt="Sapphire Diamond Earrings on Monstera" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                </div>

                <div class="space-y-3">
                    <div class="flex items-center space-x-2 text-[9px] tracking-[0.2em] uppercase font-medium">
                        <span class="text-gold">Authentication</span>
                        <span class="text-gray-600">•</span>
                        <span class="text-gray-500">April 15, 2026</span>
                    </div>

                    <h3 class="font-serif text-xl text-white font-light leading-snug group-hover:text-gold transition-colors">
                        Heritage Sri Lankan Jewelry Trends for Private Collectors
                    </h3>

                    <div class="inline-flex items-center space-x-1 text-[11px] uppercase tracking-[0.2em] font-medium text-gray-400 group-hover:text-white transition-colors">
                        <span>Read</span>
                        <i data-lucide="arrow-right" class="w-3 h-3 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </a>

        </div>

    </div>
</section>
