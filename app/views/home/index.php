<!-- HERO SECTION -->
<section class="relative min-h-screen flex items-center justify-center pt-32 pb-24 px-8 overflow-hidden">
    <!-- Hero Background Image & Gradient Overlays -->
    <div class="absolute inset-0 z-0 flex items-center justify-center bg-dark overflow-hidden">
        <div class="absolute inset-0 bg-radial-gradient z-10 opacity-70"></div>
        
        <!-- Spread Blue Shadow / Glow Left & Right -->
        <div class="absolute top-1/2 left-0 -translate-y-1/2 -translate-x-1/3 w-[800px] h-[600px] bg-blue-600/30 blur-[120px] rounded-full z-10 pointer-events-none"></div>
        <div class="absolute top-1/2 right-0 -translate-y-1/2 translate-x-1/3 w-[800px] h-[600px] bg-blue-600/30 blur-[120px] rounded-full z-10 pointer-events-none"></div>
        
        <img src="<?= BASE_URL; ?>/public/images/Hero.png" alt="Flawless Blue Diamond" class="w-full h-full object-cover object-center transform translate-y-16 scale-110 animate-pulse-slow filter brightness-90 contrast-125 z-0 opacity-80">
        <div class="absolute inset-0 bg-gradient-to-t from-dark via-dark/50 to-dark/80 z-10"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-20 max-w-5xl mx-auto text-center space-y-10">
        <!-- Pill Badge -->
        <div class="inline-flex items-center space-x-2 px-6 py-2 rounded-full border border-gray-600 bg-surface/80 backdrop-blur-md text-[10px] tracking-[0.3em] uppercase text-gray-300 shadow-2xl">
            <span>The Private Vault</span>
        </div>

        <!-- Headline -->
        <h1 class="font-serif text-5xl sm:text-6xl md:text-8xl lg:text-9xl text-white font-light tracking-tight leading-[1.05]">
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
        <a href="<?= BASE_URL; ?>/gemstones/" class="inline-flex items-center space-x-2 text-xs uppercase tracking-[0.2em] font-medium text-white group hover:text-gray-300 transition-colors">
            <span>Explore Entire Vault</span>
            <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>

    <!-- Featured Grid (Top 3) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
        <?php foreach ($featuredGemstones as $gem): ?>
            <a href="<?= BASE_URL; ?>/gem/<?= urlencode(Gemstone::buildSlug($gem)); ?>/" class="gem-card block group cursor-pointer">
                <!-- Aspect Ratio Image Box -->
                <div class="relative aspect-[4/5] bg-surface rounded-xl overflow-hidden mb-5 border border-borderGray group-hover:border-gray-500 transition-all duration-500 shadow-2xl flex items-center justify-center p-8">
                    <div class="absolute inset-0 bg-gradient-to-t from-dark/90 via-transparent to-transparent z-10 opacity-60 group-hover:opacity-40 transition-opacity"></div>
                    <?php 
                    $imgSrc = $gem['image'] ?? '';
                    $decoded = json_decode($imgSrc, true);
                    if (is_array($decoded) && count($decoded) > 0) $useImg = $decoded[0]; else $useImg = $imgSrc;
                    $imgUrl = (strpos((string)$useImg, 'http') === 0 || strpos((string)$useImg, 'data:') === 0) ? $useImg : BASE_URL . '/public/images/' . $useImg;
                    ?>
                    <img src="<?= htmlspecialchars($imgUrl); ?>" alt="<?= htmlspecialchars($gem['title']); ?>" class="max-h-full max-w-full object-contain transform group-hover:scale-110 transition-transform duration-700 drop-shadow-[0_20px_30px_rgba(0,0,0,0.8)] z-0">
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
                    <?= htmlspecialchars($gem['origin']); ?> - <?= htmlspecialchars(Gemstone::getDisplayLocation($gem)); ?>
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

<!-- QUALITY ASSURANCE & CERTIFIED PARTNERS MARQUEE -->
<section id="quality-partners" class="py-16 px-8 md:px-16 max-w-7xl mx-auto relative z-20 border-t border-borderGray">
    <div class="text-center mb-10">
        <span class="text-[10px] tracking-[0.3em] uppercase font-semibold text-gold">Accredited Alliances</span>
        <h2 class="font-serif text-3xl md:text-4xl text-white font-light tracking-wide mt-2">
            Quality Certifications & Partners
        </h2>
        <p class="text-xs text-gray-400 font-light mt-2 max-w-md mx-auto">
            Our vault acquisitions undergo strict gemological validation by renowned international standard bodies.
        </p>
    </div>

    <div class="py-4">
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 xl:grid-cols-6">
            <div class="partner-card h-24 rounded-2xl flex flex-col justify-center items-center p-4">
                <svg class="h-8 text-gold" viewBox="0 0 200 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <text x="50%" y="30" font-family="'Cormorant Garamond', serif" font-weight="bold" font-size="28" fill="#d4af37" text-anchor="middle" letter-spacing="4">G I A</text>
                    <text x="50%" y="45" font-family="'Inter', sans-serif" font-size="8" fill="#a5a5b0" text-anchor="middle" letter-spacing="2">GEMOLOGY TRUST</text>
                </svg>
            </div>
            <div class="partner-card h-24 rounded-2xl flex flex-col justify-center items-center p-4">
                <svg class="h-10 text-gold" viewBox="0 0 200 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="45" cy="25" r="18" stroke="#d4af37" stroke-width="1.5"/>
                    <circle cx="45" cy="25" r="14" stroke="#d4af37" stroke-width="0.5" stroke-dasharray="2 2"/>
                    <text x="45" y="29" font-family="'Inter', sans-serif" font-weight="bold" font-size="10" fill="#d4af37" text-anchor="middle">ISO</text>
                    <text x="130" y="24" font-family="'Inter', sans-serif" font-weight="bold" font-size="14" fill="#ffffff" text-anchor="middle" letter-spacing="1">9001</text>
                    <text x="130" y="36" font-family="'Inter', sans-serif" font-size="8" fill="#a5a5b0" text-anchor="middle" letter-spacing="1.5">QUALITY CERTIFIED</text>
                </svg>
            </div>
            <div class="partner-card h-24 rounded-2xl flex flex-col justify-center items-center p-4">
                <svg class="h-8 text-gold" viewBox="0 0 200 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <text x="50%" y="28" font-family="'Cormorant Garamond', serif" font-style="italic" font-size="22" fill="#ffffff" text-anchor="middle" letter-spacing="2">Gübelin</text>
                    <text x="50%" y="42" font-family="'Inter', sans-serif" font-size="8" fill="#d4af37" text-anchor="middle" letter-spacing="3">SWISS GEM LAB</text>
                </svg>
            </div>
            <div class="partner-card h-24 rounded-2xl flex flex-col justify-center items-center p-4">
                <svg class="h-10 text-gold" viewBox="0 0 200 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M30 13 L45 8 L60 13 L60 28 C60 37 45 44 45 44 C45 44 30 37 30 28 Z" stroke="#d4af37" stroke-width="1.5" fill="none"/>
                    <text x="45" y="27" font-family="'Inter', sans-serif" font-weight="bold" font-size="8" fill="#d4af37" text-anchor="middle">HACCP</text>
                    <text x="130" y="24" font-family="'Inter', sans-serif" font-weight="bold" font-size="13" fill="#ffffff" text-anchor="middle" letter-spacing="1">HACCP</text>
                    <text x="130" y="36" font-family="'Inter', sans-serif" font-size="7" fill="#a5a5b0" text-anchor="middle" letter-spacing="1.5">SAFETY COMPLIANT</text>
                </svg>
            </div>
            <div class="partner-card h-24 rounded-2xl flex flex-col justify-center items-center p-4">
                <svg class="h-8 text-gold" viewBox="0 0 200 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <text x="50%" y="28" font-family="'Inter', sans-serif" font-weight="bold" font-size="20" fill="#ffffff" text-anchor="middle" letter-spacing="4">S S E F</text>
                    <text x="50%" y="42" font-family="'Inter', sans-serif" font-size="8" fill="#a5a5b0" text-anchor="middle" letter-spacing="2.5">SWISS GEMMOLOGICAL INST.</text>
                </svg>
            </div>
            <div class="partner-card h-24 rounded-2xl flex flex-col justify-center items-center p-4">
                <svg class="h-8 text-gold" viewBox="0 0 200 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <text x="50%" y="26" font-family="'Cormorant Garamond', serif" font-weight="bold" font-size="20" fill="#d4af37" text-anchor="middle" letter-spacing="1">CEYLON GEM LAB</text>
                    <text x="50%" y="40" font-family="'Inter', sans-serif" font-size="8" fill="#ffffff" text-anchor="middle" letter-spacing="2">AUTHENTICITY SECURED</text>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- CLIENT ENDORSEMENTS & FEEDBACK SECTION -->
<section id="feedback-section" class="py-24 px-8 md:px-16 max-w-7xl mx-auto relative z-20 border-t border-borderGray">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
        
        <!-- Left: Verified Endorsements List -->
        <div class="lg:col-span-7 space-y-8">
            <div>
                <span class="text-[10px] tracking-[0.3em] uppercase font-semibold text-gold">Client Reflections</span>
                <h2 class="font-serif text-4xl md:text-5xl text-white font-light tracking-wide mt-2">
                    Circle Endorsements
                </h2>
                <p class="text-xs text-gray-400 font-light mt-1 max-w-md">
                    Verified evaluations and acquisition reflections shared by our vetted global client network.
                </p>
            </div>

            <!-- Review Feed Grid -->
            <div class="space-y-6 max-h-[500px] overflow-y-auto pr-4 scrollbar-thin scrollbar-thumb-gray-800">
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $rev): ?>
                        <div class="bg-surface/60 border border-borderGray/50 p-6 rounded-2xl space-y-4 shadow-xl">
                            <!-- Star Rating -->
                            <div class="flex items-center space-x-1 text-gold">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i data-lucide="star" class="w-3.5 h-3.5 <?= $i <= $rev['rating'] ? 'fill-gold' : 'text-gray-700'; ?>"></i>
                                <?php endfor; ?>
                            </div>
                            
                            <!-- Comment -->
                            <p class="text-sm font-light text-gray-300 leading-relaxed italic">
                                "<?= htmlspecialchars($rev['message']); ?>"
                            </p>

                            <!-- Client Meta -->
                            <div class="flex justify-between items-center text-[10px] tracking-wider uppercase text-gray-500 font-medium">
                                <span class="text-white font-normal"><?= htmlspecialchars($rev['user_name']); ?></span>
                                <span><?= date('M d, Y', strtotime($rev['created_at'])); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-surface/30 border border-dashed border-gray-800/80 p-12 rounded-2xl text-center text-gray-500 italic font-light">
                        No endorsements have been published yet. All incoming reviews undergo strict authenticity checks.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right: Submit Feedback Form / Login Wall -->
        <div class="lg:col-span-5">
            <div class="bg-surface border border-borderGray p-8 rounded-3xl shadow-2xl relative overflow-hidden h-full flex flex-col justify-center">
                <!-- Background Ambient -->
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-gold/5 blur-[50px] rounded-full pointer-events-none"></div>
                
                <?php 
                $currUser = User::getCurrentUser();
                $isRealClient = ($currUser && !$currUser['is_guest']);
                ?>

                <?php if ($isRealClient): ?>
                    <!-- Logged in Customer Form -->
                    <div class="space-y-6">
                        <div>
                            <span class="text-[10px] tracking-[0.2em] uppercase font-semibold text-gold">Circle Member Portal</span>
                            <h3 class="font-serif text-3xl text-white font-light italic mt-1">Submit Reflection</h3>
                            <p class="text-xs text-gray-400 font-light mt-1">
                                Share your personal curation experience or gemstone acquisition report securely.
                            </p>
                        </div>

                        <!-- Submission Alert Box -->
                        <div id="feedbackAlert" class="hidden p-4 rounded-xl text-xs flex items-center space-x-2"></div>

                        <form id="feedbackForm" onsubmit="submitFeedback(event)" class="space-y-4">
                            <!-- Interactive Star Selection -->
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2 font-medium">Rating Score</label>
                                <div class="flex items-center space-x-2 text-gray-600">
                                    <input type="hidden" name="rating" id="ratingInput" value="5">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <button type="button" onclick="setRating(<?= $i; ?>)" class="rating-star-btn hover:scale-110 transition-transform" data-value="<?= $i; ?>">
                                            <i data-lucide="star" class="w-6 h-6 fill-gold text-gold cursor-pointer star-icon"></i>
                                        </button>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <!-- Feedback message -->
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2 font-medium">Your Reflection</label>
                                <textarea name="message" required rows="4" placeholder="Describe the optical properties, certification accuracy, and private advisor communication..." class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-gray-500 font-light transition-colors resize-none"></textarea>
                            </div>

                            <button type="submit" class="w-full bg-white text-black font-semibold tracking-[0.2em] text-xs uppercase py-4 rounded-full hover:bg-gray-200 transition-all shadow-lg hover:shadow-white/10 flex items-center justify-center space-x-2">
                                <i data-lucide="send" class="w-3.5 h-3.5"></i>
                                <span>Publish Endorsement</span>
                            </button>
                        </form>
                    </div>

                    <script>
                    function setRating(val) {
                        document.getElementById('ratingInput').value = val;
                        const stars = document.querySelectorAll('.rating-star-btn');
                        stars.forEach((star, idx) => {
                            const icon = star.querySelector('.star-icon');
                            if (idx < val) {
                                icon.classList.add('fill-gold', 'text-gold');
                                icon.classList.remove('text-gray-700');
                            } else {
                                icon.classList.remove('fill-gold', 'text-gold');
                                icon.classList.add('text-gray-700');
                            }
                        });
                    }

                    function submitFeedback(e) {
                        e.preventDefault();
                        const form = document.getElementById('feedbackForm');
                        const alertBox = document.getElementById('feedbackAlert');
                        const formData = new FormData(form);

                        fetch('<?= BASE_URL; ?>/feedback/', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            alertBox.classList.remove('hidden', 'bg-red-950/30', 'border-red-800/50', 'text-red-400', 'bg-emerald-950/30', 'border-emerald-800/50', 'text-emerald-400');
                            
                            if (data.status === 'success') {
                                alertBox.classList.add('bg-emerald-950/30', 'border', 'border-emerald-800/50', 'text-emerald-400');
                                alertBox.innerHTML = `<i data-lucide="check-circle" class="w-4 h-4 text-emerald-500 flex-shrink-0"></i><span>${data.message}</span>`;
                                form.reset();
                                setRating(5);
                            } else {
                                alertBox.classList.add('bg-red-950/30', 'border', 'border-red-800/50', 'text-red-400');
                                alertBox.innerHTML = `<i data-lucide="alert-circle" class="w-4 h-4 text-red-500 flex-shrink-0"></i><span>${data.message}</span>`;
                            }
                            lucide.createIcons();
                        })
                        .catch(err => {
                            alertBox.classList.remove('hidden');
                            alertBox.classList.add('bg-red-950/30', 'border', 'border-red-800/50', 'text-red-400');
                            alertBox.innerHTML = `<span>A network error occurred. Please try again.</span>`;
                        });
                    }
                    </script>

                <?php else: ?>
                    <!-- Guest / Unauthorized Lock Screen -->
                    <div class="text-center space-y-6 py-6">
                        <div class="w-14 h-14 rounded-full border border-gray-700 bg-dark flex items-center justify-center text-white mx-auto shadow-2xl">
                            <i data-lucide="shield-alert" class="w-6 h-6 text-gold"></i>
                        </div>
                        
                        <div class="space-y-2">
                            <h3 class="font-serif text-2xl text-white font-light italic">Advisory Log Required</h3>
                            <p class="text-xs text-gray-400 leading-relaxed font-light max-w-sm mx-auto">
                                To preserve absolute authenticity, endorsement submissions are restricted to registered Client Circle members. Guests may browse catalog archives freely, but must authenticate to submit evaluations.
                            </p>
                        </div>

                        <div class="pt-2">
                            <a href="<?= BASE_URL; ?>/login/" class="inline-flex items-center space-x-2 px-8 py-4 bg-white text-black font-semibold text-xs tracking-[0.2em] uppercase rounded-full hover:bg-gray-200 hover:shadow-[0_0_20px_rgba(255,255,255,0.15)] transition-all">
                                <i data-lucide="key-round" class="w-3.5 h-3.5"></i>
                                <span>Circle Member Entry</span>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
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
            <a href="<?= BASE_URL; ?>/discover/" class="inline-block px-10 py-4 bg-white text-black font-medium text-xs tracking-[0.2em] uppercase rounded-full hover:bg-gray-200 hover:shadow-[0_0_30px_rgba(255,255,255,0.3)] transition-all duration-300">
                Open Map Discovery
            </a>
        </div>
    </div>
</section>
