    <!-- Premium Footer -->
    <footer class="bg-[#050507] border-t border-borderGray pt-24 pb-12 px-8 md:px-16 text-xs text-gray-500 font-light tracking-wide">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-12 pb-16 border-b border-borderGray">
            
            <!-- Brand Column -->
            <div class="md:col-span-4 space-y-6">
                <div class="flex items-center space-x-3 group">
                    <div class="w-7 h-7 rounded-full border border-gray-600 flex items-center justify-center text-white">
                        <i data-lucide="gem" class="w-3.5 h-3.5"></i>
                    </div>
                    <span class="tracking-[0.3em] font-light text-white text-base uppercase">Aetheria</span>
                </div>
                <p class="pr-8 leading-relaxed text-gray-400 font-light text-sm">
                    The world's most exclusive marketplace for rare gemstones and high jewelry. Discover the extraordinary.
                </p>
            </div>

            <!-- Explore Links -->
            <div class="md:col-span-2 space-y-4">
                <h4 class="text-white uppercase tracking-[0.2em] text-[10px] font-medium">Explore</h4>
                <ul class="space-y-3 font-light text-gray-400">
                    <li><a href="#marketplace" class="hover:text-white transition-colors">The Marketplace</a></li>
                    <li><a href="#acquisitions" class="hover:text-white transition-colors">High Jewelry</a></li>
                    <li><a href="#discovery-map" class="hover:text-white transition-colors">Curated Sellers</a></li>
                    <li><a href="#discovery-map" class="hover:text-white transition-colors">Location Discovery</a></li>
                </ul>
            </div>

            <!-- About Links -->
            <div class="md:col-span-2 space-y-4">
                <h4 class="text-white uppercase tracking-[0.2em] text-[10px] font-medium">About</h4>
                <ul class="space-y-3 font-light text-gray-400">
                    <li><a href="#heritage" class="hover:text-white transition-colors">Our Heritage</a></li>
                    <li><a href="#news" class="hover:text-white transition-colors">Editorial News</a></li>
                    <li><button onclick="openModal('inquiryModal', 'Private Consultation Request')" class="hover:text-white transition-colors text-left">Private Consultation</button></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="md:col-span-4 space-y-4">
                <h4 class="text-white uppercase tracking-[0.2em] text-[10px] font-medium">Newsletter</h4>
                <p class="text-gray-400 font-light text-sm">
                    Sign up to receive news about our latest acquisitions.
                </p>
                <form id="newsletter-form" class="mt-4 flex items-center border-b border-gray-600 focus-within:border-white transition-colors pb-2">
                    <input type="email" name="email" required placeholder="Email Address" class="bg-transparent w-full text-white placeholder-gray-600 focus:outline-none text-sm pr-4 font-light">
                    <button type="submit" class="text-[10px] uppercase tracking-[0.2em] text-white hover:text-gray-300 font-medium px-2 py-1">
                        Join
                    </button>
                </form>
                <div id="newsletter-message" class="text-xs pt-1 hidden"></div>
            </div>

        </div>

        <!-- Footer Bottom -->
        <div class="max-w-7xl mx-auto pt-8 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 text-[11px] text-gray-600">
            <div>
                © 2026 Aetheria Gems. All rights reserved.
            </div>
            <div class="flex space-x-8 tracking-wider">
                <a href="#" class="hover:text-gray-400 transition-colors">Terms</a>
                <a href="#" class="hover:text-gray-400 transition-colors">Privacy</a>
                <a href="#" class="hover:text-gray-400 transition-colors">Trust & Authenticity</a>
            </div>
        </div>
    </footer>

    <!-- Inquiry Modal -->
    <div id="inquiryModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-md modal-backdrop" onclick="closeModal('inquiryModal')"></div>
        <div class="relative bg-surface border border-borderGray p-8 md:p-12 rounded-2xl max-w-lg w-full mx-4 shadow-2xl z-10 transition-all">
            <button onclick="closeModal('inquiryModal')" class="absolute top-6 right-6 text-gray-400 hover:text-white">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
            <h3 class="font-serif text-3xl text-white mb-2 italic">Private Inquiry</h3>
            <p id="inquiryModalSubtitle" class="text-sm text-gray-400 mb-8 font-light">Request an exclusive portfolio or private viewing appointment.</p>
            
            <form id="inquiryForm" class="space-y-6">
                <input type="hidden" id="stone_id" name="stone_id" value="0">
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2 font-light">Your Full Name</label>
                    <input type="text" name="client_name" required class="w-full bg-dark border border-gray-800 rounded-lg px-4 py-3 text-white text-sm focus:outline-none focus:border-gray-500 font-light">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2 font-light">Secure Email</label>
                    <input type="email" name="client_email" required class="w-full bg-dark border border-gray-800 rounded-lg px-4 py-3 text-white text-sm focus:outline-none focus:border-gray-500 font-light">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2 font-light">Specific Request / Gemstone Interest</label>
                    <textarea name="client_notes" rows="3" placeholder="Please indicate requested origin, carat range, or specific lot number..." class="w-full bg-dark border border-gray-800 rounded-lg px-4 py-3 text-white text-sm focus:outline-none focus:border-gray-500 font-light"></textarea>
                </div>
                <button type="submit" class="w-full bg-white text-black font-medium tracking-[0.2em] text-xs uppercase py-4 rounded-full hover:bg-gray-200 transition-all shadow-lg hover:shadow-white/10">
                    Submit Secure Request
                </button>
            </form>
            <div id="inquiryResponse" class="mt-6 text-sm hidden py-3 px-4 rounded-lg bg-emerald-950/50 border border-emerald-500/30 text-emerald-300"></div>
        </div>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-md modal-backdrop" onclick="closeModal('loginModal')"></div>
        <div class="relative bg-surface border border-borderGray p-8 md:p-12 rounded-2xl max-w-md w-full mx-4 shadow-2xl z-10 transition-all">
            <button onclick="closeModal('loginModal')" class="absolute top-6 right-6 text-gray-400 hover:text-white">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
            <div class="text-center mb-8">
                <div class="w-12 h-12 rounded-full border border-gray-600 flex items-center justify-center text-white mx-auto mb-4">
                    <i data-lucide="lock" class="w-5 h-5"></i>
                </div>
                <h3 class="font-serif text-3xl text-white mb-2 italic">Client Portal</h3>
                <p class="text-sm text-gray-400 font-light">Enter your secure client credentials.</p>
            </div>
            
            <form id="loginForm" onsubmit="event.preventDefault(); alert('Demo mode: Client authentication successfully simulated.'); closeModal('loginModal');" class="space-y-6">
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2 font-light">Client ID / Email</label>
                    <input type="text" required class="w-full bg-dark border border-gray-800 rounded-lg px-4 py-3 text-white text-sm focus:outline-none focus:border-gray-500 font-light">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2 font-light">Private Access Key</label>
                    <input type="password" required class="w-full bg-dark border border-gray-800 rounded-lg px-4 py-3 text-white text-sm focus:outline-none focus:border-gray-500 font-light">
                </div>
                <button type="submit" class="w-full bg-white text-black font-medium tracking-[0.2em] text-xs uppercase py-4 rounded-full hover:bg-gray-200 transition-all shadow-lg hover:shadow-white/10">
                    Secure Entry
                </button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?= BASE_URL; ?>/public/js/main.js"></script>
    <script>
        // Define BASE_URL for JS scripts if needed
        const BASE_URL = "<?= BASE_URL; ?>";
    </script>
</body>
</html>
