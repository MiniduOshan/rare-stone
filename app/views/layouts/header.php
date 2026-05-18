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

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-dark text-gray-300 font-sans antialiased selection:bg-white selection:text-black">

    <!-- Premium Navigation Bar -->
    <header id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 py-6 px-8 md:px-16 border-b border-transparent">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            
            <!-- Logo -->
            <a href="<?= BASE_URL; ?>" class="flex items-center space-x-3 group">
                <div class="w-8 h-8 rounded-full border border-gray-600 flex items-center justify-center text-white group-hover:border-white transition-colors duration-300">
                    <i data-lucide="gem" class="w-4 h-4"></i>
                </div>
                <span class="tracking-[0.3em] font-light text-white text-base md:text-lg uppercase">Aetheria</span>
            </a>

            <!-- Center Navigation Links -->
            <nav class="hidden md:flex items-center space-x-8 lg:space-x-10 text-xs tracking-[0.2em] uppercase font-light text-gray-400">
                <a href="<?= BASE_URL; ?>/#marketplace" class="hover:text-white transition-colors duration-300">Marketplace</a>
                
                <div class="relative group py-2">
                    <a href="<?= BASE_URL; ?>/#acquisitions" class="flex items-center space-x-1 hover:text-white transition-colors duration-300">
                        <span>Jewelry</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-gray-500 group-hover:text-white transition-colors"></i>
                    </a>
                </div>

                <a href="<?= BASE_URL; ?>/#discovery-map" class="hover:text-white transition-colors duration-300">Sellers</a>
                
                <a href="<?= BASE_URL; ?>/index.php?route=heritage" class="hover:text-white transition-colors duration-300 <?= (isset($activeNav) && $activeNav === 'heritage') ? 'text-white border-b-2 border-white pb-1 font-normal' : ''; ?>">Heritage</a>
                
                <div class="relative group py-2">
                    <a href="<?= BASE_URL; ?>/#news" class="flex items-center space-x-1 hover:text-white transition-colors duration-300">
                        <span>News</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-gray-500 group-hover:text-white transition-colors"></i>
                    </a>
                </div>
            </nav>

            <!-- Right Actions -->
            <div class="flex items-center space-x-4 lg:space-x-6 text-[10px] lg:text-xs tracking-[0.15em] uppercase font-light">
                <a href="<?= BASE_URL; ?>/#discovery-map" class="hidden lg:flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-300">
                    <i data-lucide="globe" class="w-3.5 h-3.5"></i>
                    <span>Discover</span>
                </a>
                
                <span class="hidden lg:inline text-gray-700">|</span>

                <button onclick="openModal('inquiryModal')" class="px-5 py-2 border border-gray-600 rounded-full text-white hover:border-white transition-all duration-300">
                    Inquire
                </button>

                <button onclick="openModal('inquiryModal', 'Application for Vetted Gemstone Seller Network')" class="px-5 py-2 bg-gold text-black font-medium rounded-full hover:bg-[#ebd275] hover:shadow-[0_0_20px_rgba(212,175,55,0.4)] transition-all duration-300">
                    Sell Gem
                </button>

                <button onclick="openModal('loginModal')" class="px-5 py-2 border border-gray-600 rounded-full text-white hover:border-white hover:bg-white hover:text-black transition-all duration-300">
                    Login
                </button>
            </div>

        </div>
    </header>
