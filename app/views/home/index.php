<!-- HERO SECTION -->
<section class="relative min-h-screen flex items-center justify-center pt-32 pb-24 px-8 overflow-hidden">
    <!-- Hero Background Image & Gradient Overlays -->
    <div class="absolute inset-0 z-0 flex items-center justify-center">
        <div class="absolute inset-0 bg-radial-gradient z-10 opacity-70"></div>
        <img src="<?= BASE_URL; ?>/public/images/hero-gem.jpg" alt="Flawless Diamond Background" class="w-full h-full object-cover object-center scale-105 animate-pulse-slow filter brightness-75 contrast-125">
        <div class="absolute inset-0 bg-gradient-to-t from-dark via-dark/40 to-dark/80 z-10"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-20 max-w-4xl mx-auto text-center space-y-8 mt-12">
        <!-- Pill Badge -->
        <div class="inline-flex items-center space-x-2 px-5 py-1.5 rounded-full border border-gray-600 bg-surface/80 backdrop-blur-md text-[10px] tracking-[0.3em] uppercase text-gray-300 shadow-2xl">
            <span>The Private Collection</span>
        </div>

        <!-- Headline -->
        <h1 class="font-serif text-6xl md:text-8xl lg:text-9xl text-white font-light tracking-tight leading-[1.05]">
            Rare & <br><span class="italic font-light text-gradient">Exceptional</span>
        </h1>

        <!-- Description -->
        <p class="max-w-xl mx-auto text-sm md:text-base text-gray-400 font-light leading-relaxed tracking-wide">
            Discover Sri Lanka's most exclusive marketplace for investment-grade gemstones, master-cut sapphires, and historic bespoke jewelry.
        </p>

        <!-- CTAs -->
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6 text-xs uppercase tracking-[0.2em] font-medium">
            <a href="#acquisitions" class="w-full sm:w-auto px-10 py-4 bg-white text-black rounded-full hover:bg-gray-200 hover:shadow-[0_0_30px_rgba(255,255,255,0.3)] transition-all duration-300">
                Enter Marketplace
            </a>
            <a href="#discovery-map" class="w-full sm:w-auto px-8 py-4 border border-gray-700 text-white rounded-full hover:border-white transition-all duration-300 flex items-center justify-center space-x-3 group">
                <span>Find Traders</span>
                <i data-lucide="arrow-right" class="w-4 h-4 text-gray-400 group-hover:text-white group-hover:translate-x-1 transition-all"></i>
            </a>
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
                Exceptional rare pieces, recently verified and added to our private network.
            </p>
        </div>
        <a href="#all-gems" onclick="toggleAllGems(event)" id="viewAllBtn" class="inline-flex items-center space-x-2 text-xs uppercase tracking-[0.2em] font-medium text-white group hover:text-gray-300 transition-colors">
            <span>View All</span>
            <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>

    <!-- Featured Grid (Top 3) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
        <?php foreach ($featuredGemstones as $gem): ?>
            <div class="gem-card group cursor-pointer" onclick="openGemModal(<?= htmlspecialchars(json_encode($gem)); ?>)">
                <!-- Aspect Ratio Image Box -->
                <div class="relative aspect-[4/5] bg-surface rounded-xl overflow-hidden mb-5 border border-borderGray group-hover:border-gray-500 transition-all duration-500 shadow-2xl flex items-center justify-center p-8">
                    <!-- Subtle Glow Effect on Hover -->
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
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Expanded Grid (Hidden by default, shown when 'View All' is clicked) -->
    <div id="expanded-grid" class="hidden grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 mt-12 pt-12 border-t border-borderGray/50 animate-fade-in">
        <?php foreach (array_slice($allGemstones, 3) as $gem): ?>
            <div class="gem-card group cursor-pointer" onclick="openGemModal(<?= htmlspecialchars(json_encode($gem)); ?>)">
                <div class="relative aspect-[4/5] bg-surface rounded-xl overflow-hidden mb-5 border border-borderGray group-hover:border-gray-500 transition-all duration-500 shadow-2xl flex items-center justify-center p-8">
                    <div class="absolute inset-0 bg-gradient-to-t from-dark/90 via-transparent to-transparent z-10 opacity-60 group-hover:opacity-40 transition-opacity"></div>
                    <img src="<?= BASE_URL; ?>/public/images/<?= htmlspecialchars($gem['image']); ?>" alt="<?= htmlspecialchars($gem['title']); ?>" class="max-h-full max-w-full object-contain transform group-hover:scale-110 transition-transform duration-700 drop-shadow-[0_20px_30px_rgba(0,0,0,0.8)] z-0">
                </div>
                <div class="flex items-baseline justify-between text-white font-serif tracking-wide mb-1">
                    <h3 class="text-xl font-light text-gray-100 group-hover:text-white transition-colors"><?= htmlspecialchars($gem['title']); ?></h3>
                    <span class="text-[10px] tracking-[0.2em] uppercase font-sans font-medium text-gray-400 px-2 py-0.5 border border-gray-800 rounded bg-dark">
                        <?= htmlspecialchars($gem['status']); ?>
                    </span>
                </div>
                <div class="text-xs font-light text-gray-500 font-sans tracking-wider">
                    <?= htmlspecialchars($gem['origin']); ?> - <?= htmlspecialchars($gem['carats']); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- HIGHLIGHTS / FEATURES SECTION -->
<section id="heritage" class="py-24 px-8 md:px-16 max-w-7xl mx-auto border-t border-b border-borderGray my-12 bg-surface/30">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-16 md:gap-12 text-center md:text-left">
        <!-- Feature 1 -->
        <div class="space-y-5">
            <div class="w-12 h-12 rounded-full border border-gray-700 flex items-center justify-center text-white mx-auto md:mx-0 bg-dark shadow-xl">
                <i data-lucide="shield-check" class="w-5 h-5 stroke-[1.5]"></i>
            </div>
            <h3 class="font-serif text-2xl text-white font-light tracking-wide">Verified Authenticity</h3>
            <p class="text-sm font-light text-gray-400 leading-relaxed">
                Every stone is cross-tested by top laboratory certification (GIA, Gübelin, SSEF).
            </p>
        </div>

        <!-- Feature 2 -->
        <div class="space-y-5">
            <div class="w-12 h-12 rounded-full border border-gray-700 flex items-center justify-center text-white mx-auto md:mx-0 bg-dark shadow-xl">
                <i data-lucide="gem" class="w-5 h-5 stroke-[1.5]"></i>
            </div>
            <h3 class="font-serif text-2xl text-white font-light tracking-wide">Direct Trader Access</h3>
            <p class="text-sm font-light text-gray-400 leading-relaxed">
                Connect directly with elite international dealers, miners, and private collectors.
            </p>
        </div>

        <!-- Feature 3 -->
        <div class="space-y-5">
            <div class="w-12 h-12 rounded-full border border-gray-700 flex items-center justify-center text-white mx-auto md:mx-0 bg-dark shadow-xl">
                <i data-lucide="star" class="w-5 h-5 stroke-[1.5]"></i>
            </div>
            <h3 class="font-serif text-2xl text-white font-light tracking-wide">Discrete Transactions</h3>
            <p class="text-sm font-light text-gray-400 leading-relaxed">
                Secure inquiry and negotiation platform maintaining total privacy for high-net-worth clients.
            </p>
        </div>
    </div>
</section>

<!-- CALL TO ACTION / MAP DISCOVERY SECTION -->
<section id="discovery-map" class="relative py-40 px-8 my-20 overflow-hidden text-center flex items-center justify-center max-w-7xl mx-auto rounded-3xl border border-borderGray shadow-2xl">
    <!-- CTA Background Image & Overlay -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <img src="<?= BASE_URL; ?>/public/images/cta-bg.jpg" alt="Diamond Texture Background" class="w-full h-full object-cover object-center scale-110 filter brightness-50 contrast-125 opacity-40">
        <div class="absolute inset-0 bg-gradient-to-b from-dark via-dark/60 to-dark"></div>
    </div>

    <div class="relative z-10 max-w-2xl mx-auto space-y-8">
        <h2 class="font-serif text-5xl md:text-7xl text-white font-light leading-tight tracking-tight">
            Locate exceptional pieces <br><span class="italic text-gradient font-light">near you.</span>
        </h2>
        <p class="text-sm md:text-base text-gray-400 font-light leading-relaxed max-w-xl mx-auto">
            Use our interactive discovery map to connect with verified sellers and view rare collections in your immediate vicinity or next travel destination.
        </p>
        <div class="pt-4">
            <button onclick="openModal('inquiryModal', 'Map Discovery & Location Inquiry')" class="px-10 py-4 bg-white text-black font-medium text-xs tracking-[0.2em] uppercase rounded-full hover:bg-gray-200 hover:shadow-[0_0_30px_rgba(255,255,255,0.3)] transition-all duration-300">
                Open Map Discovery
            </button>
        </div>
    </div>
</section>

<!-- Detail Modal for Gemstones -->
<div id="gemModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-md modal-backdrop" onclick="closeModal('gemModal')"></div>
    <div class="relative bg-surface border border-borderGray p-8 md:p-12 rounded-2xl max-w-2xl w-full mx-4 shadow-2xl z-10 text-left flex flex-col md:flex-row gap-8 items-center">
        <button onclick="closeModal('gemModal')" class="absolute top-6 right-6 text-gray-400 hover:text-white z-20">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>
        
        <div class="w-full md:w-1/2 bg-dark p-6 rounded-xl border border-gray-800 flex items-center justify-center aspect-[4/5]">
            <img id="modalGemImg" src="" alt="" class="max-h-full max-w-full object-contain filter drop-shadow-[0_15px_25px_rgba(0,0,0,0.8)]">
        </div>

        <div class="w-full md:w-1/2 space-y-4">
            <span id="modalGemStatus" class="inline-block text-[10px] tracking-[0.2em] uppercase font-sans font-medium text-gray-400 px-2 py-1 border border-gray-800 rounded bg-dark"></span>
            <h3 id="modalGemTitle" class="font-serif text-3xl text-white font-light"></h3>
            <p id="modalGemSubtitle" class="text-xs text-gray-400 uppercase tracking-widest font-light"></p>
            <p id="modalGemDesc" class="text-sm text-gray-300 font-light leading-relaxed border-t border-b border-gray-800 py-4"></p>
            <div class="pt-2">
                <button id="modalInquireBtn" onclick="initiateGemInquiry()" class="w-full bg-white text-black font-medium tracking-[0.2em] text-xs uppercase py-3 rounded-full hover:bg-gray-200 transition-all text-center">
                    Inquire About This Piece
                </button>
            </div>
        </div>
    </div>
</div>
