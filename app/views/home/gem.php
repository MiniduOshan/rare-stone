<!-- DEDICATED GEMSTONE SPECIFICATION VIEW -->
<section class="pt-32 pb-24 px-8 md:px-16 max-w-7xl mx-auto relative z-20 min-h-screen flex items-center">
    <div class="w-full grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
        
        <!-- Left Column: Cinematic High-Fidelity Image Presentation -->
        <div class="lg:col-span-6">
            <div class="relative bg-surface border border-borderGray p-8 md:p-12 rounded-3xl overflow-hidden shadow-2xl flex items-center justify-center aspect-[4/5] group cursor-pointer" onclick="openLightbox()">
                <div class="absolute inset-0 bg-radial-gradient opacity-80 z-0"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-dark/80 via-transparent to-transparent z-10 opacity-50"></div>
                
                <img src="<?= BASE_URL; ?>/public/images/<?= htmlspecialchars($gem['image']); ?>" alt="<?= htmlspecialchars($gem['title']); ?>" class="max-h-full max-w-full object-contain transform group-hover:scale-110 transition-transform duration-700 drop-shadow-[0_25px_35px_rgba(0,0,0,0.9)] relative z-20">
                
                <!-- Ambient Backlight -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-3/4 h-3/4 bg-gold/5 blur-[100px] rounded-full pointer-events-none z-0"></div>
                
                <!-- Hover Expand Icon -->
                <div class="absolute bottom-6 right-6 z-30 text-white/40 group-hover:text-white transition-colors bg-black/40 p-2.5 rounded-full backdrop-blur-md opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 duration-300">
                    <i data-lucide="zoom-in" class="w-5 h-5"></i>
                </div>
            </div>
        </div>

        <!-- Right Column: Dossier & Specifications -->
        <div class="lg:col-span-6 space-y-8">
            
            <!-- Breadcrumbs & Status Tag -->
            <div class="flex items-center justify-between border-b border-borderGray pb-6">
                <a href="<?= BASE_URL; ?>/index.php?route=gemstones" class="inline-flex items-center space-x-2 text-xs uppercase tracking-[0.2em] font-light text-gray-400 hover:text-white transition-colors">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Back to Vault Catalog</span>
                </a>
                <span class="text-[10px] tracking-[0.25em] uppercase font-sans font-medium text-gold px-3 py-1 border border-gold/30 rounded bg-gold/10">
                    <?= htmlspecialchars($gem['status']); ?>
                </span>
            </div>

            <!-- Title & Subtitle -->
            <div class="space-y-2">
                <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl text-white font-light tracking-tight leading-tight">
                    <?= htmlspecialchars($gem['title']); ?>
                </h1>
                <p class="text-sm uppercase tracking-[0.2em] text-gray-400 font-light">
                    <?= htmlspecialchars($gem['origin']); ?> Provenance
                </p>
            </div>

            <!-- Detailed Description -->
            <p class="text-sm md:text-base text-gray-300 font-light leading-relaxed">
                <?= htmlspecialchars($gem['description']); ?>
            </p>

            <!-- Technical Specifications Dossier Table -->
            <div class="bg-surface/50 border border-borderGray rounded-2xl p-6 md:p-8 space-y-4 shadow-xl">
                <h3 class="text-xs uppercase tracking-[0.25em] text-white font-medium mb-6 flex items-center space-x-2">
                    <i data-lucide="shield-check" class="w-4 h-4 text-gold"></i>
                    <span>Certified Monograph Overview</span>
                </h3>
                
                <div class="grid grid-cols-2 gap-y-4 gap-x-8 text-xs">
                    <div class="flex justify-between border-b border-gray-800/80 pb-3">
                        <span class="text-gray-500 uppercase tracking-wider font-light">Carat Weight</span>
                        <span class="text-white font-medium tracking-wide"><?= htmlspecialchars($gem['carats']); ?></span>
                    </div>
                    <div class="flex justify-between border-b border-gray-800/80 pb-3">
                        <span class="text-gray-500 uppercase tracking-wider font-light">Origin Source</span>
                        <span class="text-white font-medium tracking-wide"><?= htmlspecialchars($gem['origin']); ?></span>
                    </div>
                    <div class="flex justify-between border-b border-gray-800/80 pb-3">
                        <span class="text-gray-500 uppercase tracking-wider font-light">Optical Cut</span>
                        <span class="text-white font-medium tracking-wide"><?= htmlspecialchars($gem['cut']); ?></span>
                    </div>
                    <div class="flex justify-between border-b border-gray-800/80 pb-3">
                        <span class="text-gray-500 uppercase tracking-wider font-light">Valuation Tier</span>
                        <span class="text-gold font-medium tracking-wide"><?= htmlspecialchars($gem['price_tier']); ?></span>
                    </div>
                </div>

                <div class="pt-4 text-[11px] text-gray-400 font-light italic flex items-center space-x-2">
                    <i data-lucide="info" class="w-3.5 h-3.5 text-gray-500 flex-shrink-0"></i>
                    <span>Guaranteed unheated & accompanied by official GIA / Gübelin / SSEF certification dossiers upon secure delivery.</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                <button onclick="openModal('inquiryModal', 'Secure Advisory: <?= htmlspecialchars($gem['title']); ?> (<?= htmlspecialchars($gem['carats']); ?>, <?= htmlspecialchars($gem['origin']); ?>)')" class="w-full sm:w-1/2 py-4 bg-white text-black font-medium text-xs uppercase tracking-[0.2em] rounded-full hover:bg-gray-200 hover:shadow-[0_0_30px_rgba(255,255,255,0.3)] transition-all duration-300 text-center">
                    Inquiry Now
                </button>
            </div>

        </div>

    </div>
</section>

<!-- Full Screen Image Lightbox Modal with Animation -->
<div id="lightboxModal" class="fixed inset-0 z-[200] flex items-center justify-center hidden opacity-0 transition-opacity duration-500 ease-in-out">
    <div class="absolute inset-0 bg-black/95 backdrop-blur-2xl" onclick="closeLightbox()"></div>
    <button onclick="closeLightbox()" class="absolute top-6 right-6 text-gray-400 hover:text-white z-20 bg-dark border border-gray-800 rounded-full p-3 hover:bg-gray-800 transition-colors shadow-2xl">
        <i data-lucide="x" class="w-6 h-6"></i>
    </button>
    
    <div class="relative z-10 w-full max-w-7xl h-[85vh] p-4 flex items-center justify-center">
        <img id="lightboxImg" src="<?= BASE_URL; ?>/public/images/<?= htmlspecialchars($gem['image']); ?>" alt="<?= htmlspecialchars($gem['title']); ?>" class="max-h-full max-w-full object-contain transform scale-95 opacity-0 transition-all duration-700 cubic-bezier(0.16, 1, 0.3, 1) filter drop-shadow-[0_0_80px_rgba(255,255,255,0.15)]">
    </div>
</div>

<script>
    function openLightbox() {
        const modal = document.getElementById('lightboxModal');
        const img = document.getElementById('lightboxImg');
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Small delay to allow display:block to paint before animating
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            
            img.classList.remove('scale-95', 'opacity-0');
            img.classList.add('scale-100', 'opacity-100');
        }, 20);
    }

    function closeLightbox() {
        const modal = document.getElementById('lightboxModal');
        const img = document.getElementById('lightboxImg');
        
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        
        img.classList.remove('scale-100', 'opacity-100');
        img.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 500); // Wait for transition to complete
    }
</script>
