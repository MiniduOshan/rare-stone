<?php
// Admin Sidebar Component
$activeTab = $activeTab ?? 'feedbacks';
?>
<!-- Sidebar Navigation -->
<aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-surface border-r border-borderGray flex flex-col justify-between h-screen transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:translate-x-0 md:flex font-sans">
    
    <!-- Top Brand Area -->
    <div class="p-6 border-b border-borderGray">
        <div class="flex items-center justify-between">
            <a href="<?= BASE_URL; ?>/" class="flex items-center space-x-3 group">
                <div class="w-8 h-8 rounded-full border border-gold flex items-center justify-center text-gold bg-gold/10">
                    <i data-lucide="gem" class="w-4 h-4"></i>
                </div>
                <div class="text-left">
                    <span class="block tracking-[0.2em] font-light text-white text-sm uppercase">Rare Stones</span>
                    <span class="block text-[9px] tracking-widest text-gold uppercase font-medium">Control Panel</span>
                </div>
            </a>
            <!-- Close Sidebar Button (Mobile Only) -->
            <button class="md:hidden text-gray-400 hover:text-white transition-colors" onclick="toggleAdminSidebar()" aria-label="Close Sidebar">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
    </div>

    <!-- Middle Menu Navigation Links -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        <div class="text-[9px] uppercase tracking-widest text-gray-500 font-semibold px-3 mb-3">Moderation & Content</div>
        
        <!-- Feedback Moderation Queue -->
        <a href="#feedbacks" id="nav-feedbacks"
           class="sidebar-nav-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all text-xs tracking-wider uppercase text-gray-400 hover:bg-white/5 hover:text-white border border-transparent">
            <i data-lucide="message-square" class="w-4 h-4"></i>
            <span>Moderation</span>
        </a>

        <!-- Gemstone Inventory -->
        <a href="#gems" id="nav-gems"
           class="sidebar-nav-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all text-xs tracking-wider uppercase text-gray-400 hover:bg-white/5 hover:text-white border border-transparent">
            <i data-lucide="gem" class="w-4 h-4"></i>
            <span>Gem Stones</span>
        </a>

        <!-- News & Insights -->
        <a href="#news" id="nav-news"
           class="sidebar-nav-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all text-xs tracking-wider uppercase text-gray-400 hover:bg-white/5 hover:text-white border border-transparent">
            <i data-lucide="book-open" class="w-4 h-4"></i>
            <span>Add News</span>
        </a>

        <!-- Brand Heritage -->
        <a href="#heritage" id="nav-heritage"
           class="sidebar-nav-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all text-xs tracking-wider uppercase text-gray-400 hover:bg-white/5 hover:text-white border border-transparent">
            <i data-lucide="crown" class="w-4 h-4"></i>
            <span>Heritage Page</span>
        </a>

        <!-- Discover Page -->
        <a href="#discover" id="nav-discover"
           class="sidebar-nav-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all text-xs tracking-wider uppercase text-gray-400 hover:bg-white/5 hover:text-white border border-transparent">
            <i data-lucide="map" class="w-4 h-4"></i>
            <span>Discover Page</span>
        </a>

        <!-- Contact Page -->
        <a href="#contact" id="nav-contact"
           class="sidebar-nav-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all text-xs tracking-wider uppercase text-gray-400 hover:bg-white/5 hover:text-white border border-transparent">
            <i data-lucide="phone-call" class="w-4 h-4"></i>
            <span>Contact Details</span>
        </a>
    </nav>

    <!-- Bottom Actions Area -->
    <div class="p-4 border-t border-borderGray bg-dark/40 space-y-2">
        <a href="<?= BASE_URL; ?>/" target="_blank" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-xs text-gray-400 hover:text-white hover:bg-white/5 transition-all uppercase tracking-wider">
            <i data-lucide="external-link" class="w-4 h-4"></i>
            <span>View Marketplace</span>
        </a>
        
        <button onclick="toggleTheme()" class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-xs text-gray-400 hover:text-white hover:bg-white/5 transition-all uppercase tracking-wider">
            <div class="flex items-center space-x-3">
                <i data-lucide="sun" class="w-4 h-4"></i>
                <span>Light Theme</span>
            </div>
            <div class="w-8 h-4 bg-dark border border-gray-600 rounded-full relative transition-colors" id="themeToggleBg">
                <div class="w-3 h-3 bg-gray-400 rounded-full absolute left-0.5 top-0.5 transition-transform" id="themeToggleDot"></div>
            </div>
        </button>

        <a href="<?= BASE_URL; ?>/index.php?route=logout" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-xs text-red-400 hover:bg-red-950/20 transition-all uppercase tracking-wider">
            <i data-lucide="log-out" class="w-4 h-4"></i>
            <span>Logout Portal</span>
        </a>
    </div>

</aside>

<style>
    /* White Theme Filter - elegant color inversion retaining brand hues */
    html.white-theme body {
        filter: invert(1) hue-rotate(180deg) brightness(1.05);
        background-color: #000 !important; /* Inverts to white */
    }
    html.white-theme img {
        filter: invert(1) hue-rotate(180deg);
    }
</style>

<script>
    function applyThemeUI() {
        const isLight = localStorage.getItem('rareStonesAdminTheme') === 'light';
        const dot = document.getElementById('themeToggleDot');
        const bg = document.getElementById('themeToggleBg');
        
        if (isLight) {
            document.documentElement.classList.add('white-theme');
            if (dot) dot.classList.add('translate-x-4', 'bg-gold');
            if (dot) dot.classList.remove('bg-gray-400');
            if (bg) bg.classList.add('border-gold');
        } else {
            document.documentElement.classList.remove('white-theme');
            if (dot) dot.classList.remove('translate-x-4', 'bg-gold');
            if (dot) dot.classList.add('bg-gray-400');
            if (bg) bg.classList.remove('border-gold');
        }
    }

    function toggleTheme() {
        const isLight = localStorage.getItem('rareStonesAdminTheme') === 'light';
        localStorage.setItem('rareStonesAdminTheme', isLight ? 'dark' : 'light');
        applyThemeUI();
    }

    // Apply UI classes on load immediately
    document.addEventListener('DOMContentLoaded', applyThemeUI);
    applyThemeUI(); // Call directly as well to update early if DOM is ready
</script>
