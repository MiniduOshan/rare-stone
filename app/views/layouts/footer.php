    <!-- Premium Footer -->
    <footer class="bg-[#050507] border-t border-borderGray pt-24 pb-12 px-8 md:px-16 text-xs text-gray-500 font-light tracking-wide">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-12 pb-16 border-b border-borderGray">
            
            <!-- Brand Column -->
            <div class="md:col-span-6 space-y-6">
                <div class="flex items-center space-x-3 group">
                    <div class="w-7 h-7 rounded-full border border-gray-600 flex items-center justify-center text-white">
                        <i data-lucide="gem" class="w-3.5 h-3.5"></i>
                    </div>
                    <span class="tracking-[0.3em] font-light text-white text-base uppercase">Rare Stones</span>
                </div>
                <p class="max-w-md leading-relaxed text-gray-400 font-light text-sm">
                    Sri Lanka's premier private gemstone brand. Discover world-class unheated sapphires, historic rubies, and bespoke high jewelry directly from our private island vaults.
                </p>
            </div>

            <!-- Explore Salons Links -->
            <div class="md:col-span-3 space-y-4">
                <h4 class="text-white uppercase tracking-[0.2em] text-[10px] font-medium">Explore Vaults</h4>
                <ul class="space-y-3 font-light text-gray-400">
                    <li><a href="<?= BASE_URL; ?>/" class="hover:text-white transition-colors">The Vault Catalog</a></li>
                    <li><a href="<?= BASE_URL; ?>/index.php?route=gemstones" class="hover:text-white transition-colors">All Gem Stones</a></li>
                    <li><a href="<?= BASE_URL; ?>/index.php?route=discover" class="hover:text-white transition-colors">Branches</a></li>
                    <li><button onclick="openModal('inquiryModal', 'Private Viewing Appointment')" class="hover:text-white transition-colors text-left">Book Viewing Appointment</button></li>
                </ul>
            </div>

            <!-- About Links -->
            <div class="md:col-span-3 space-y-4">
                <h4 class="text-white uppercase tracking-[0.2em] text-[10px] font-medium">The Brand</h4>
                <ul class="space-y-3 font-light text-gray-400">
                    <li><a href="<?= BASE_URL; ?>/index.php?route=heritage" class="hover:text-white transition-colors">Our Heritage</a></li>
                    <li><a href="<?= BASE_URL; ?>/index.php?route=news" class="hover:text-white transition-colors">Editorial & Insight</a></li>
                    <li><button onclick="openModal('inquiryModal', 'Private Consultation Request')" class="hover:text-white transition-colors text-left">Private Consultation</button></li>
                </ul>
            </div>

        </div>

        <!-- Footer Bottom -->
        <div class="max-w-7xl mx-auto pt-8 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 text-[11px] text-gray-600">
            <div>
                © 2026 Rare Stones. All rights reserved.
            </div>
            <div class="flex space-x-8 tracking-wider">
                <a href="#" class="hover:text-gray-400 transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-gray-400 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-gray-400 transition-colors">Trust & Laboratory Guarantee</a>
            </div>
        </div>
    </footer>

    <!-- Inquiry / Direct Contact Modal with Blur Backdrop -->
    <div id="inquiryModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-md modal-backdrop" onclick="closeModal('inquiryModal')"></div>
        <div class="relative bg-surface border border-borderGray p-8 md:p-12 rounded-2xl max-w-lg w-full mx-4 shadow-2xl z-10 transition-all text-left">
            <button onclick="closeModal('inquiryModal')" class="absolute top-6 right-6 text-gray-400 hover:text-white">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
            <h3 class="font-serif text-3xl text-white mb-2 italic">Private Client Concierge</h3>
            <p id="inquiryModalSubtitle" class="text-xs text-gray-400 mb-8 font-light leading-relaxed">Connect directly with our senior gemologists and private client advisors through your preferred secure communication channel.</p>
            
            <!-- Direct Contact Directory in Classic Dark Theme -->
            <div class="space-y-4">
                
                <!-- WhatsApp VIP Line -->
                <a href="https://wa.me/94771234567" target="_blank" class="flex items-center justify-between p-4 bg-dark border border-gray-800 rounded-xl hover:border-[#25D366] transition-all group block">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-[#25D366]/10 border border-[#25D366]/30 flex items-center justify-center text-[#25D366] group-hover:scale-110 transition-transform">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-widest text-gray-400 font-medium group-hover:text-white transition-colors">WhatsApp Concierge</div>
                            <div class="text-sm font-light text-gray-200">+94 77 123 4567</div>
                        </div>
                    </div>
                    <span class="text-[10px] bg-[#25D366]/20 text-[#25D366] border border-[#25D366]/40 px-2.5 py-1 rounded-full uppercase tracking-wider font-medium">VIP 24/7</span>
                </a>

                <!-- Direct Phone Line -->
                <a href="tel:+94112345678" class="flex items-center justify-between p-4 bg-dark border border-gray-800 rounded-xl hover:border-gold transition-all group block">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-gold/10 border border-gold/30 flex items-center justify-center text-gold group-hover:scale-110 transition-transform">
                            <i data-lucide="phone-call" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-widest text-gray-400 font-medium group-hover:text-white transition-colors">Colombo Flagship Vault</div>
                            <div class="text-sm font-light text-gray-200">+94 11 234 5678</div>
                        </div>
                    </div>
                    <span class="text-[10px] text-gray-500 uppercase tracking-widest">Direct Line</span>
                </a>

                <!-- Secure Email -->
                <a href="mailto:concierge@rarestones.lk" class="flex items-center justify-between p-4 bg-dark border border-gray-800 rounded-xl hover:border-white transition-all group block">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-widest text-gray-400 font-medium group-hover:text-white transition-colors">Secure Email Advisory</div>
                            <div class="text-sm font-light text-gray-200">concierge@rarestones.lk</div>
                        </div>
                    </div>
                    <span class="text-[10px] text-gray-500 uppercase tracking-widest">Encrypted</span>
                </a>

                <!-- Instagram -->
                <a href="https://instagram.com" target="_blank" class="flex items-center justify-between p-4 bg-dark border border-gray-800 rounded-xl hover:border-[#E1306C] transition-all group block">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-[#E1306C]/10 border border-[#E1306C]/30 flex items-center justify-center text-[#E1306C] group-hover:scale-110 transition-transform">
                            <i data-lucide="instagram" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-widest text-gray-400 font-medium group-hover:text-white transition-colors">Instagram Previews</div>
                            <div class="text-sm font-light text-gray-200">@rarestones.ceylon</div>
                        </div>
                    </div>
                    <span class="text-[10px] text-gray-500 uppercase tracking-widest">Daily Catalog</span>
                </a>

                <!-- Facebook -->
                <a href="https://facebook.com" target="_blank" class="flex items-center justify-between p-4 bg-dark border border-gray-800 rounded-xl hover:border-[#1877F2] transition-all group block">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-[#1877F2]/10 border border-[#1877F2]/30 flex items-center justify-center text-[#1877F2] group-hover:scale-110 transition-transform">
                            <i data-lucide="facebook" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-widest text-gray-400 font-medium group-hover:text-white transition-colors">Facebook Official Page</div>
                            <div class="text-sm font-light text-gray-200">Rare Stones Ceylon</div>
                        </div>
                    </div>
                    <span class="text-[10px] text-gray-500 uppercase tracking-widest">Community</span>
                </a>

            </div>

            <div class="mt-8 text-center">
                <button onclick="closeModal('inquiryModal')" class="text-xs uppercase tracking-[0.2em] text-gray-500 hover:text-white font-medium transition-colors">
                    Close Directory
                </button>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-md modal-backdrop" onclick="closeModal('loginModal')"></div>
        <div class="relative bg-surface border border-borderGray p-8 md:p-12 rounded-2xl max-w-md w-full mx-4 shadow-2xl z-10 transition-all text-center">
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
                    <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2 font-light text-left">Client ID / Email</label>
                    <input type="text" required class="w-full bg-dark border border-gray-800 rounded-lg px-4 py-3 text-white text-sm focus:outline-none focus:border-gray-500 font-light">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2 font-light text-left">Private Access Key</label>
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
        // Define BASE_URL for JS scripts
        const BASE_URL = "<?= BASE_URL; ?>";
    </script>
</body>
</html>
