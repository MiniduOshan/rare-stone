<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : SITE_NAME; ?></title>
    <meta name="description" content="Discover Sri Lanka's most exclusive marketplace for investment-grade gemstones, master-cut sapphires, and historic bespoke jewelry.">
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💎</text></svg>">

    <!-- Google Fonts: Cormorant Garamond & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Suppress Tailwind CDN warnings in console -->
    <script>
        (function() {
            const originalWarn = console.warn;
            console.warn = function(...args) {
                if (args[0] && typeof args[0] === 'string' && args[0].includes('cdn.tailwindcss.com')) return;
                originalWarn.apply(console, args);
            };
        })();
    </script>
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: '#08080a',
                        surface: '#111115',
                        borderGray: 'rgba(255, 255, 255, 0.12)',
                        gold: '#d4af37',
                    },
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>/public/css/style.css">

    <!-- Leaflet CSS for Map Discovery -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-dark text-gray-300 font-sans antialiased selection:bg-white selection:text-black">

    <!-- Premium Navigation Bar -->
    <header id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 py-4 px-6 md:py-6 md:px-16 border-b border-transparent bg-dark/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            
            <!-- Logo -->
            <a href="<?= BASE_URL; ?>" class="flex items-center space-x-3 group">
                <img src="<?= BASE_URL; ?>/public/images/logo-mark.png" alt="Rare Stones" class="h-10 w-10 object-contain shrink-0 group-hover:opacity-90 transition-opacity duration-300">
                <span class="tracking-[0.22em] font-light text-white text-sm md:text-base uppercase whitespace-nowrap">Rare Stones</span>
            </a>

            <!-- Center Navigation Links -->
            <nav class="hidden md:flex items-center space-x-8 lg:space-x-12 text-xs tracking-[0.2em] uppercase font-light text-gray-400">
                <a href="<?= BASE_URL; ?>/" class="hover:text-white transition-colors duration-300 <?= (isset($activeNav) && $activeNav === 'home') ? 'text-white border-b-2 border-white pb-1 font-normal' : ''; ?>">Home</a>
                
                <a href="<?= BASE_URL; ?>/gemstones/" class="hover:text-white transition-colors duration-300 <?= (isset($activeNav) && $activeNav === 'gemstones') ? 'text-white border-b-2 border-white pb-1 font-normal' : ''; ?>">Gem Stones</a>
                
                <a href="<?= BASE_URL; ?>/heritage/" class="hover:text-white transition-colors duration-300 <?= (isset($activeNav) && $activeNav === 'heritage') ? 'text-white border-b-2 border-white pb-1 font-normal' : ''; ?>">Heritage</a>
                
                <a href="<?= BASE_URL; ?>/news/" class="hover:text-white transition-colors duration-300 <?= (isset($activeNav) && $activeNav === 'news') ? 'text-white border-b-2 border-white pb-1 font-normal' : ''; ?>">News</a>
            </nav>

            <!-- Right Actions -->
            <div class="hidden md:flex items-center space-x-4 lg:space-x-6 text-[10px] lg:text-xs tracking-[0.15em] uppercase font-light">
                <a href="<?= BASE_URL; ?>/discover/" class="hidden lg:flex items-center space-x-2 transition-colors duration-300 <?= (isset($activeNav) && $activeNav === 'discover') ? 'text-gold font-normal' : 'text-gray-400 hover:text-white'; ?>">
                    <i data-lucide="globe" class="w-3.5 h-3.5"></i>
                    <span>Discover</span>
                </a>
                
                <span class="hidden lg:inline text-gray-700">|</span>

                <button onclick="openModal('inquiryModal')" class="px-5 py-2 border border-gray-600 rounded-full text-white hover:border-white transition-all duration-300">
                    Inquire
                </button>



                <?php if (User::isLoggedIn()): ?>
                    <?php if (User::isAdmin()): ?>
                        <a href="<?= BASE_URL; ?>/admin/" class="px-4 py-2 border border-gold rounded-full text-gold hover:bg-gold hover:text-black transition-all duration-300 flex items-center space-x-1.5 font-medium">
                            <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i>
                            <span>Dashboard</span>
                        </a>
                    <?php else: ?>
                        <span class="text-gray-400 hidden xl:inline normal-case font-normal">Circle: <strong><?= htmlspecialchars(User::getCurrentUser()['name']); ?></strong></span>
                    <?php endif; ?>
                    <a href="<?= BASE_URL; ?>/logout/" class="px-5 py-2 border border-gray-600 rounded-full text-white hover:border-white hover:bg-white hover:text-black transition-all duration-300">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL; ?>/login/" class="px-5 py-2 border border-gray-600 rounded-full text-white hover:border-white hover:bg-white hover:text-black transition-all duration-300">
                        Client Entrance
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-toggle" class="md:hidden flex items-center justify-center p-2 text-gray-400 hover:text-white transition-colors duration-300 focus:outline-none" aria-label="Toggle Menu" onclick="toggleMobileMenu()">
                <i data-lucide="menu" id="menu-icon-open" class="w-6 h-6"></i>
                <i data-lucide="x" id="menu-icon-close" class="w-6 h-6 hidden"></i>
            </button>

        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu" class="fixed inset-0 z-40 bg-dark/98 backdrop-blur-lg flex flex-col justify-between pt-28 pb-12 px-8 transform translate-x-full transition-transform duration-500 ease-in-out md:hidden overflow-y-auto">
        <!-- Navigation Links -->
        <nav class="flex flex-col space-y-6 text-sm tracking-[0.2em] uppercase font-light text-gray-400">
            <a href="<?= BASE_URL; ?>/" onclick="closeMobileMenu()" class="hover:text-white transition-colors duration-300 py-2 border-b border-gray-900 <?= (isset($activeNav) && $activeNav === 'home') ? 'text-white font-normal' : ''; ?>">Home</a>
            <a href="<?= BASE_URL; ?>/gemstones/" onclick="closeMobileMenu()" class="hover:text-white transition-colors duration-300 py-2 border-b border-gray-900 <?= (isset($activeNav) && $activeNav === 'gemstones') ? 'text-white font-normal' : ''; ?>">Gem Stones</a>
            <a href="<?= BASE_URL; ?>/heritage/" onclick="closeMobileMenu()" class="hover:text-white transition-colors duration-300 py-2 border-b border-gray-900 <?= (isset($activeNav) && $activeNav === 'heritage') ? 'text-white font-normal' : ''; ?>">Heritage</a>
            <a href="<?= BASE_URL; ?>/news/" onclick="closeMobileMenu()" class="hover:text-white transition-colors duration-300 py-2 border-b border-gray-900 <?= (isset($activeNav) && $activeNav === 'news') ? 'text-white font-normal' : ''; ?>">News</a>
            <a href="<?= BASE_URL; ?>/discover/" onclick="closeMobileMenu()" class="hover:text-white transition-colors duration-300 py-2 border-b border-gray-900 <?= (isset($activeNav) && $activeNav === 'discover') ? 'text-gold font-normal' : 'text-gray-400 hover:text-white'; ?>">Discover</a>
        </nav>

        <!-- Actions -->
        <div class="flex flex-col space-y-4 pt-8 border-t border-gray-900">
            <button onclick="closeMobileMenu(); openModal('inquiryModal')" class="w-full py-3.5 border border-gray-600 rounded-full text-center text-white hover:border-white transition-all duration-300 tracking-[0.15em] uppercase text-xs">
                Inquire
            </button>

            <?php if (User::isLoggedIn()): ?>
                <?php if (User::isAdmin()): ?>
                    <a href="<?= BASE_URL; ?>/admin/" class="w-full py-3.5 border border-gold rounded-full text-center text-gold hover:bg-gold hover:text-black transition-all duration-300 tracking-[0.15em] uppercase text-xs flex items-center justify-center space-x-1.5 font-medium">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        <span>Dashboard</span>
                    </a>
                <?php else: ?>
                    <div class="text-gray-400 text-center py-2 text-xs">Circle: <strong><?= htmlspecialchars(User::getCurrentUser()['name']); ?></strong></div>
                <?php endif; ?>
                <a href="<?= BASE_URL; ?>/logout/" class="w-full py-3.5 border border-gray-600 rounded-full text-center text-white hover:border-white hover:bg-white hover:text-black transition-all duration-300 tracking-[0.15em] uppercase text-xs">
                    Logout
                </a>
            <?php else: ?>
                <a href="<?= BASE_URL; ?>/login/" class="w-full py-3.5 border border-gray-600 rounded-full text-center text-white hover:border-white hover:bg-white hover:text-black transition-all duration-300 tracking-[0.15em] uppercase text-xs">
                    Client Entrance
                </a>
            <?php endif; ?>
        </div>
    </div>
