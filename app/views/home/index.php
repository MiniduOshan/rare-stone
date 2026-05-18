<!-- HERO SECTION -->
<section class="relative min-h-screen flex items-center justify-center pt-32 pb-24 px-8 overflow-hidden">
    <!-- Hero Background Image & Gradient Overlays -->
    <div class="absolute inset-0 z-0 flex items-center justify-center bg-dark overflow-hidden">
        <div class="absolute inset-0 bg-radial-gradient z-10 opacity-70"></div>
        
        <!-- Spread Blue Shadow / Glow Left & Right -->
        <div class="absolute top-1/2 left-0 -translate-y-1/2 -translate-x-1/3 w-[800px] h-[600px] bg-blue-600/30 blur-[120px] rounded-full z-10 pointer-events-none"></div>
        <div class="absolute top-1/2 right-0 -translate-y-1/2 translate-x-1/3 w-[800px] h-[600px] bg-blue-600/30 blur-[120px] rounded-full z-10 pointer-events-none"></div>
        
        <img src="<?= BASE_URL; ?>/public/images/blue-diamond-hero.jpg" alt="Flawless Blue Diamond" class="w-full h-full object-cover object-center transform translate-y-16 scale-110 animate-pulse-slow filter brightness-90 contrast-125 z-0 opacity-80">
        <div class="absolute inset-0 bg-gradient-to-t from-dark via-dark/50 to-dark/80 z-10"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-20 max-w-5xl mx-auto text-center space-y-10">
        <!-- Pill Badge -->
        <div class="inline-flex items-center space-x-2 px-6 py-2 rounded-full border border-gray-600 bg-surface/80 backdrop-blur-md text-[10px] tracking-[0.3em] uppercase text-gray-300 shadow-2xl">
            <span>The Private Vault</span>
        </div>

        <!-- Headline -->
        <h1 class="font-serif text-6xl md:text-8xl lg:text-9xl text-white font-light tracking-tight leading-[1.05]">
            Rare & <br><span class="italic font-light text-gradient">Exceptional</span>
        </h1>

        <!-- Description -->
        <p class="max-w-2xl mx-auto text-base md:text-lg text-gray-300 font-light leading-relaxed tracking-wide">
            Sri Lanka's premier private gemstone vault. Discover investment-grade unheated sapphires, master-cut rubies, and historic bespoke jewelry.
        </p>

        <!-- Elegant Ornamental Divider -->
        <div class="pt-8 flex justify-center items-center space-x-6 opacity-70">
            <div class="w-24 md:w-32 h-px bg-gradient-to-r from-transparent to-gold"></div>
            <i data-lucide="gem" class="w-4 h-4 text-gold drop-shadow-[0_0_10px_rgba(255,215,0,0.5)]"></i>
            <div class="w-24 md:w-32 h-px bg-gradient-to-l from-transparent to-gold"></div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center space-y-2 text-gray-500 opacity-60 hover:opacity-100 transition-opacity">
        <div class="w-px h-12 bg-gradient-to-b from-gray-500 to-transparent animate-bounce"></div>
    </div>
</section>

<!-- CURATED ACQUISITIONS SECTION -->
<section id="acquisitions" class="py-32 px-8 md:px-16 max-w-7xl mx-auto relative z-20">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 space-y-6 md:space-y-0 border-b border-borderGray pb-8">
        <div>
            <h2 class="font-serif text-4xl md:text-5xl text-white font-light tracking-wide mb-3">
                Curated Acquisitions
            </h2>
            <p class="text-sm text-gray-400 font-light max-w-md">
                Exceptional rare pieces, recently verified and added to our private vault network.
            </p>
        </div>
        <a href="<?= BASE_URL; ?>/index.php?route=gemstones" class="inline-flex items-center space-x-2 text-xs uppercase tracking-[0.2em] font-medium text-white group hover:text-gray-300 transition-colors">
            <span>Explore Entire Vault</span>
            <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>

    <!-- Featured Grid (Top 3) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
        <?php foreach ($featuredGemstones as $gem): ?>
            <a href="<?= BASE_URL; ?>/index.php?route=gem&id=<?= $gem['id']; ?>" class="gem-card block group cursor-pointer">
                <!-- Aspect Ratio Image Box -->
                <div class="relative aspect-[4/5] bg-surface rounded-xl overflow-hidden mb-5 border border-borderGray group-hover:border-gray-500 transition-all duration-500 shadow-2xl flex items-center justify-center p-8">
                    <div class="absolute inset-0 bg-gradient-to-t from-dark/90 via-transparent to-transparent z-10 opacity-60 group-hover:opacity-40 transition-opacity"></div>
                    <img src="<?= BASE_URL; ?>/public/images/<?= htmlspecialchars($gem['image']); ?>" alt="<?= htmlspecialchars($gem['title']); ?>" class="max-h-full max-w-full object-contain transform group-hover:scale-110 transition-transform duration-700 drop-shadow-[0_20px_30px_rgba(0,0,0,0.8)] z-0">
                </div>

                <!-- Info Row -->
                <div class="flex items-baseline justify-between text-white font-serif tracking-wide mb-1">
                    <h3 class="text-xl font-light text-gray-100 group-hover:text-white transition-colors"><?= htmlspecialchars($gem['title']); ?></h3>
                    <span class="text-[10px] tracking-[0.2em] uppercase font-sans font-medium text-gray-400 px-2 py-0.5 border border-gray-800 rounded bg-dark">
                        <?= htmlspecialchars($gem['status']); ?>
                    </span>
                </div>

                <!-- Subtitle / Origin -->
                <div class="text-xs font-light text-gray-500 font-sans tracking-wider">
                    <?= htmlspecialchars($gem['origin']); ?> - <?= htmlspecialchars($gem['carats']); ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- HIGHLIGHTS / BRAND HERITAGE SECTION -->
<section id="heritage-highlights" class="py-24 px-8 md:px-16 max-w-7xl mx-auto border-t border-b border-borderGray my-16 bg-surface/30 rounded-3xl">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-16 md:gap-12 text-center md:text-left">
        <!-- Feature 1 -->
        <div class="space-y-5">
            <div class="w-12 h-12 rounded-full border border-gray-700 flex items-center justify-center text-white mx-auto md:mx-0 bg-dark shadow-xl">
                <i data-lucide="shield-check" class="w-5 h-5 stroke-[1.5] text-gold"></i>
            </div>
            <h3 class="font-serif text-2xl text-white font-light tracking-wide">Certified Provenance</h3>
            <p class="text-sm font-light text-gray-400 leading-relaxed">
                Every investment-grade gemstone is accompanied by definitive gemological origin dossiers and authentication from world-renowned laboratories (GIA, Gübelin, SSEF).
            </p>
        </div>

        <!-- Feature 2 -->
        <div class="space-y-5">
            <div class="w-12 h-12 rounded-full border border-gray-700 flex items-center justify-center text-white mx-auto md:mx-0 bg-dark shadow-xl">
                <i data-lucide="crown" class="w-5 h-5 stroke-[1.5] text-gold"></i>
            </div>
            <h3 class="font-serif text-2xl text-white font-light tracking-wide">Centuries of Island Heritage</h3>
            <p class="text-sm font-light text-gray-400 leading-relaxed">
                Rooted in generations of Ceylonese mining tradition, sourcing unheated royal blue and rare padparadscha sapphires directly from legendary gem gravels across Ratnapura and Elahera.
            </p>
        </div>

        <!-- Feature 3 -->
        <div class="space-y-5">
            <div class="w-12 h-12 rounded-full border border-gray-700 flex items-center justify-center text-white mx-auto md:mx-0 bg-dark shadow-xl">
                <i data-lucide="sparkles" class="w-5 h-5 stroke-[1.5] text-gold"></i>
            </div>
            <h3 class="font-serif text-2xl text-white font-light tracking-wide">Bespoke Master Lapidary</h3>
            <p class="text-sm font-light text-gray-400 leading-relaxed">
                Our master cutters and goldsmiths collaborate privately with collectors to maximize optical brilliance and craft heirloom settings worthy of museum exhibition.
            </p>
        </div>
    </div>
</section>

<!-- CALL TO ACTION / MAP DISCOVERY SECTION -->
<section id="discovery-map" class="relative py-40 px-8 my-20 overflow-hidden text-center flex items-center justify-center max-w-7xl mx-auto rounded-3xl border border-borderGray shadow-2xl">
    <div class="absolute inset-0 z-0 overflow-hidden">
        <img src="<?= BASE_URL; ?>/public/images/cta-bg.jpg" alt="Diamond Texture Background" class="w-full h-full object-cover object-center scale-110 filter brightness-50 contrast-125 opacity-40">
        <div class="absolute inset-0 bg-gradient-to-b from-dark via-dark/60 to-dark"></div>
    </div>

    <div class="relative z-10 max-w-2xl mx-auto space-y-8">
        <h2 class="font-serif text-5xl md:text-7xl text-white font-light leading-tight tracking-tight">
            Locate exceptional pieces <br><span class="italic text-gradient font-light">near you.</span>
        </h2>
        <p class="text-sm md:text-base text-gray-400 font-light leading-relaxed max-w-xl mx-auto">
            Use our interactive discovery map to explore our private viewing salons and view rare collections in your immediate vicinity or next travel destination.
        </p>
        <div class="pt-4">
            <a href="<?= BASE_URL; ?>/index.php?route=discover" class="inline-block px-10 py-4 bg-white text-black font-medium text-xs tracking-[0.2em] uppercase rounded-full hover:bg-gray-200 hover:shadow-[0_0_30px_rgba(255,255,255,0.3)] transition-all duration-300">
                Open Map Discovery
            </a>
        </div>
    </div>
</section>
