<!-- HERITAGE HERO BANNER -->
<section class="relative h-[55vh] min-h-[450px] w-full flex items-end justify-center overflow-hidden pt-32">
    <!-- Hero Background Image & Gradient Overlays -->
    <div class="absolute inset-0 z-0">
        <img src="<?= BASE_URL; ?>/public/images/heritage-hero.jpg" alt="Aetheria Heritage Balcony View" class="w-full h-full object-cover object-center filter brightness-75 contrast-125 grayscale scale-105 animate-pulse-slow">
        <div class="absolute inset-0 bg-gradient-to-t from-dark via-dark/40 to-dark/80"></div>
    </div>
</section>

<!-- THE PRIVATE NETWORK SECTION -->
<section class="py-24 px-8 md:px-16 max-w-7xl mx-auto relative z-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-20 items-center">
        
        <!-- Left Text Column -->
        <div class="lg:col-span-6 space-y-8">
            <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl text-white font-light tracking-wide leading-tight">
                The Private Network
            </h1>
            
            <div class="space-y-6 text-sm md:text-base text-gray-400 font-light leading-relaxed tracking-wide">
                <p>
                    Founded on the principles of trust, discretion, and an unyielding commitment to exceptional quality, Aetheria Gems was established to connect the world's most distinguished buyers with rare and historically significant gemstones.
                </p>
                <p>
                    We do not hold inventory. Instead, we provide a secure, authenticated framework for transactions between vetted private collectors, artisanal sustainable miners, and master jewelers across the globe.
                </p>
                <p>
                    Every listing on our platform undergoes a rigorous pre-approval process, requiring certification from premier gemological laboratories (such as GIA, Gübelin, or SSEF) and verification of the seller's institutional standing.
                </p>
            </div>
        </div>

        <!-- Right Image Column -->
        <div class="lg:col-span-6">
            <div class="relative aspect-[4/5] max-w-lg mx-auto bg-surface rounded-2xl overflow-hidden border border-borderGray shadow-2xl p-4 flex items-center justify-center group">
                <div class="absolute inset-0 bg-gradient-to-t from-dark/60 via-transparent to-transparent z-10 opacity-40 group-hover:opacity-20 transition-opacity"></div>
                <img src="<?= BASE_URL; ?>/public/images/heritage-earrings.jpg" alt="Antique Sapphire & Diamond Drop Earrings on Monstera Leaf" class="w-full h-full object-cover rounded-xl transform group-hover:scale-105 transition-transform duration-700 z-0">
            </div>
        </div>

    </div>
</section>

<!-- OUR PHILOSOPHY / QUOTE SECTION -->
<section class="py-32 px-8 md:px-16 max-w-5xl mx-auto text-center space-y-12 border-t border-borderGray my-12 relative z-20">
    <!-- Subtitle -->
    <div class="text-[10px] tracking-[0.3em] uppercase font-medium text-gray-500">
        Our Philosophy
    </div>

    <!-- Quote -->
    <blockquote class="font-serif text-3xl md:text-5xl lg:text-6xl text-white font-light italic leading-[1.3] tracking-wide max-w-4xl mx-auto">
        "True luxury is found in absolute rarity and flawless provenance. We do not sell gems; we curate legacies."
    </blockquote>

    <!-- Vertical Line Decoration -->
    <div class="w-px h-16 bg-gradient-to-b from-gray-500 via-gray-700 to-transparent mx-auto my-8"></div>

    <!-- CTA Button -->
    <div class="pt-4">
        <button onclick="openModal('inquiryModal', 'Private Consultation Request')" class="px-10 py-4 bg-white text-black font-medium text-xs tracking-[0.2em] uppercase rounded-full hover:bg-gray-200 hover:shadow-[0_0_30px_rgba(255,255,255,0.3)] transition-all duration-300">
            Book a Private Consultation
        </button>
    </div>
</section>
