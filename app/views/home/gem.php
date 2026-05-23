<!-- DEDICATED GEMSTONE SPECIFICATION VIEW -->
<section class="pt-32 pb-24 px-8 md:px-16 max-w-7xl mx-auto relative z-20 min-h-screen flex items-start">
    <div class="w-full grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">
        
        <!-- Left Column: Cinematic High-Fidelity Image Presentation -->
        <div class="lg:col-span-5">
            <div class="relative bg-surface border border-borderGray p-4 md:p-6 rounded-3xl overflow-hidden shadow-2xl flex items-center justify-center aspect-square group cursor-pointer" onclick="openLightbox()">
                <div class="absolute inset-0 bg-radial-gradient opacity-80 z-0"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-dark/80 via-transparent to-transparent z-10 opacity-50"></div>
                
                        <?php
                        // Support multiple gem images saved as JSON array, JSON object, comma-separated string, or a single image string
                        $images = [];
                        $rawImageValue = $gem['image'] ?? '';
                        if (!empty($rawImageValue)) {
                            $try = json_decode($rawImageValue, true);
                            if (is_array($try)) {
                                $images = array_values(array_filter($try, function ($value) {
                                    return is_string($value) && trim($value) !== '';
                                }));
                            } else {
                                $parts = array_map('trim', explode(',', $rawImageValue));
                                $images = array_values(array_filter($parts, function ($value) {
                                    return $value !== '';
                                }));
                            }
                        }
                        $featured = $images[0] ?? '';
                        if (strpos((string)$featured, 'http') === 0 || strpos((string)$featured, 'data:') === 0) {
                            $featuredUrl = $featured;
                        } else {
                            $featuredUrl = !empty($featured) ? BASE_URL . '/public/images/' . $featured : '';
                        }
                        ?>
                        <img id="gemMainImage" src="<?= htmlspecialchars($featuredUrl); ?>" alt="<?= htmlspecialchars($gem['title']); ?>" class="block mx-auto max-h-full max-w-full object-contain transform group-hover:scale-110 transition-transform duration-700 drop-shadow-[0_25px_35px_rgba(0,0,0,0.9)] relative z-20">

                        <?php if (count($images) > 1): ?>
                            <button type="button" onclick="event.stopPropagation(); prevGemImage();" aria-label="Previous image" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 rounded-full border border-gray-700 bg-black/50 text-white hover:bg-white hover:text-black transition-all shadow-2xl flex items-center justify-center">
                                <i data-lucide="chevron-left" class="w-5 h-5"></i>
                            </button>
                            <button type="button" onclick="event.stopPropagation(); nextGemImage();" aria-label="Next image" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 rounded-full border border-gray-700 bg-black/50 text-white hover:bg-white hover:text-black transition-all shadow-2xl flex items-center justify-center">
                                <i data-lucide="chevron-right" class="w-5 h-5"></i>
                            </button>
                        <?php endif; ?>

                        <!-- Ambient Backlight -->
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-3/4 h-3/4 bg-gold/5 blur-[100px] rounded-full pointer-events-none z-0"></div>
                
                <!-- Hover Expand Icon -->
                <div class="absolute bottom-6 right-6 z-30 text-white/40 group-hover:text-white transition-colors bg-black/40 p-2.5 rounded-full backdrop-blur-md opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 duration-300">
                    <i data-lucide="zoom-in" class="w-5 h-5"></i>
                </div>
            </div>
        </div>

        <!-- Right Column: Dossier & Specifications -->
        <div class="lg:col-span-7 space-y-8">
            
            <!-- Breadcrumbs & Status Tag -->
            <div class="flex items-center justify-between border-b border-borderGray pb-6">
                <a href="<?= BASE_URL; ?>/gemstones/" class="inline-flex items-center space-x-2 text-xs uppercase tracking-[0.2em] font-light text-gray-400 hover:text-white transition-colors">
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
                    <?= htmlspecialchars(Gemstone::getDisplayLocation($gem)); ?>
                </p>
            </div>

            <!-- Detailed Description (preserve line breaks) -->
            <p class="text-sm md:text-base text-gray-300 font-light leading-relaxed">
                <?= nl2br(htmlspecialchars($gem['description'])); ?>
            </p>

            <!-- Technical Specifications Dossier Table -->
            <div class="bg-surface/50 border border-borderGray rounded-2xl p-6 md:p-8 space-y-4 shadow-xl">
                <h3 class="text-xs uppercase tracking-[0.25em] text-white font-medium mb-6 flex items-center space-x-2">
                    <i data-lucide="shield-check" class="w-4 h-4 text-gold"></i>
                    <span>Certified Monograph Overview</span>
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 text-xs">
                    <div class="flex justify-between border-b border-gray-800/80 pb-3">
                        <span class="text-gray-500 uppercase tracking-wider font-light">Carat Weight</span>
                        <span class="text-white font-medium tracking-wide"><?= htmlspecialchars($gem['carats']); ?></span>
                    </div>
                    <div class="flex justify-between border-b border-gray-800/80 pb-3">
                        <span class="text-gray-500 uppercase tracking-wider font-light">Origin Source</span>
                        <span class="text-white font-medium tracking-wide"><?= htmlspecialchars($gem['origin']); ?></span>
                    </div>
                    <div class="flex justify-between border-b border-gray-800/80 pb-3">
                        <span class="text-gray-500 uppercase tracking-wider font-light">Selling Area / Branch</span>
                        <span class="text-white font-medium tracking-wide"><?= htmlspecialchars(Gemstone::getDisplayLocation($gem)); ?></span>
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

<!-- Full Screen Image Lightbox Modal with Animation -->
<div id="lightboxModal" class="fixed inset-0 z-[200] flex items-center justify-center hidden opacity-0 transition-opacity duration-500 ease-in-out">
    <div class="absolute inset-0 bg-black/95 backdrop-blur-2xl" onclick="closeLightbox()"></div>
    <button onclick="closeLightbox()" class="absolute top-6 right-6 text-gray-400 hover:text-white z-20 bg-dark border border-gray-800 rounded-full p-3 hover:bg-gray-800 transition-colors shadow-2xl">
        <i data-lucide="x" class="w-6 h-6"></i>
    </button>
    
    <div class="relative z-10 w-full max-w-7xl h-[85vh] p-4 flex items-center justify-center">
        <img id="lightboxImg" src="<?= htmlspecialchars($featuredUrl ?? ''); ?>" alt="<?= htmlspecialchars($gem['title']); ?>" class="max-h-full max-w-full object-contain transform scale-95 opacity-0 transition-all duration-700 cubic-bezier(0.16, 1, 0.3, 1) filter drop-shadow-[0_0_80px_rgba(255,255,255,0.15)]">
    </div>
    <?php if (count($images) > 1): ?>
        <button type="button" onclick="stepLightbox(-1)" class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full border border-gray-700 bg-black/50 text-white hover:bg-white hover:text-black transition-all shadow-2xl flex items-center justify-center">
            <i data-lucide="chevron-left" class="w-6 h-6"></i>
        </button>
        <button type="button" onclick="stepLightbox(1)" class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full border border-gray-700 bg-black/50 text-white hover:bg-white hover:text-black transition-all shadow-2xl flex items-center justify-center">
            <i data-lucide="chevron-right" class="w-6 h-6"></i>
        </button>
    <?php endif; ?>
    <?php if (count($images) > 1): ?>
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-30 w-full max-w-4xl flex items-center justify-center gap-2">
            <?php foreach ($images as $idx => $img):
                $url = (strpos((string)$img, 'http') === 0 || strpos((string)$img, 'data:') === 0) ? $img : BASE_URL . '/public/images/' . $img;
            ?>
                <button type="button" class="rounded overflow-hidden border border-borderGray bg-dark p-0" onclick="setLightboxImage(<?= $idx; ?>)"><img src="<?= htmlspecialchars($url); ?>" alt="" class="h-12 object-cover"></button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    const gemImages = <?= json_encode(array_values($images)); ?>;
    let currentLightboxIndex = 0;
    let currentGemIndex = 0;

    function openLightbox() {
        openLightboxAtIndex(currentGemIndex || 0);
    }

    function openLightboxAtIndex(idx) {
        const modal = document.getElementById('lightboxModal');
        const img = document.getElementById('lightboxImg');
        const raw = gemImages[idx] || gemImages[0] || '';
        const url = (raw && (raw.indexOf('http') === 0 || raw.indexOf('data:') === 0)) ? raw : (raw ? '<?= BASE_URL; ?>' + '/public/images/' + raw : '');

        currentLightboxIndex = gemImages.length ? ((idx % gemImages.length) + gemImages.length) % gemImages.length : 0;
        currentGemIndex = currentLightboxIndex;

        img.src = url;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            img.classList.remove('scale-95', 'opacity-0');
            img.classList.add('scale-100', 'opacity-100');
        }, 20);
    }

    function setLightboxImage(idx) {
        openLightboxAtIndex(idx);
    }

    function stepLightbox(direction) {
        if (!gemImages.length) return;
        openLightboxAtIndex(currentLightboxIndex + direction);
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
        }, 500);
    }

    function setGemImage(idx) {
        if (!gemImages.length) return;
        const raw = gemImages[idx] || gemImages[0] || '';
        const url = (raw && (raw.indexOf('http') === 0 || raw.indexOf('data:') === 0)) ? raw : (raw ? '<?= BASE_URL; ?>' + '/public/images/' + raw : '');
        const el = document.getElementById('gemMainImage');
        if (el) el.src = url;
        currentGemIndex = gemImages.length ? ((idx % gemImages.length) + gemImages.length) % gemImages.length : 0;
    }

    function prevGemImage() {
        if (!gemImages.length) return;
        setGemImage((currentGemIndex - 1 + gemImages.length) % gemImages.length);
    }

    function nextGemImage() {
        if (!gemImages.length) return;
        setGemImage((currentGemIndex + 1) % gemImages.length);
    }

    document.addEventListener('keydown', function (event) {
        const modal = document.getElementById('lightboxModal');
        const modalOpen = modal && !modal.classList.contains('hidden');
        if (event.key === 'ArrowLeft') {
            event.preventDefault();
            if (modalOpen) stepLightbox(-1); else prevGemImage();
        }
        if (event.key === 'ArrowRight') {
            event.preventDefault();
            if (modalOpen) stepLightbox(1); else nextGemImage();
        }
        if (event.key === 'Escape' && modalOpen) {
            closeLightbox();
        }
    });

    // Initialize main image on load (ensure correct index if images present)
    document.addEventListener('DOMContentLoaded', function () {
        setGemImage(0);
    });
</script>
