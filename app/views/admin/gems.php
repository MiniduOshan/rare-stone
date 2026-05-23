<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Manage Gems | Rare Stones Admin'; ?></title>
    
    <!-- Prevent theme flash -->
    <script>
        (function() {
            if (localStorage.getItem('rareStonesAdminTheme') === 'light') {
                document.documentElement.classList.add('white-theme');
            } else {
                document.documentElement.classList.remove('white-theme');
            }
        })();
    </script>
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💎</text></svg>">
    
    <!-- Google Fonts -->
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
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-dark text-gray-300 font-sans antialiased flex min-h-screen">

    <!-- Sidebar Inclusion -->
    <?php require_once APP_ROOT . '/views/admin/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-8 md:p-12 overflow-y-auto max-w-7xl">
        
        <!-- Header -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-borderGray pb-6 mb-8 gap-4">
            <div>
                <h1 class="font-serif text-3xl md:text-4xl text-white font-light">Gemstone <span class="italic text-gold">Listings</span></h1>
                <p class="text-xs text-gray-400 mt-1 font-light">Add new curated gemstone acquisitions and manage vault entries.</p>
            </div>
            
            <a href="<?= BASE_URL; ?>/gemstones/" target="_blank" class="px-4 py-2 bg-white/5 border border-borderGray rounded-xl text-xs text-gray-300 hover:text-white hover:bg-white/10 transition-all flex items-center space-x-1.5 font-light">
                <i data-lucide="eye" class="w-4 h-4 text-gold"></i>
                <span>View Public Catalog</span>
            </a>
        </header>

        <!-- Message Alerts -->
        <?php if (!empty($success)): ?>
            <div class="p-4 mb-6 bg-emerald-950/30 border border-emerald-800/50 rounded-xl text-xs text-emerald-400 flex items-center space-x-2">
                <i data-lucide="check-circle" class="w-4 h-4 flex-shrink-0 text-emerald-500"></i>
                <span><?= htmlspecialchars($success); ?></span>
            </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="p-4 mb-6 bg-red-950/30 border border-red-800/50 rounded-xl text-xs text-red-400 flex items-center space-x-2">
                <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0 text-red-500"></i>
                <span><?= htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left: Add Gemstone Form -->
            <section class="lg:col-span-5 bg-surface border border-borderGray p-8 rounded-3xl shadow-2xl relative overflow-hidden">
                <h2 class="font-serif text-2xl text-white font-light mb-6 flex items-center space-x-2">
                    <i data-lucide="plus-circle" class="w-5 h-5 text-gold"></i>
                    <span>Register New Gemstone</span>
                </h2>

                <form action="<?= BASE_URL; ?>/admin/gems/" method="POST" class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Gem Title</label>
                        <input type="text" name="title" placeholder="e.g. Ceylon Blue Sapphire" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Origin Source</label>
                            <input type="text" name="origin" placeholder="e.g. Sri Lanka" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Selling Area / Branch</label>
                            <input type="text" name="location" placeholder="e.g. Ratnapura Branch" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Carat Weight</label>
                            <input type="text" name="carats" placeholder="e.g. 8.12 ct" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Optical Cut</label>
                            <input type="text" name="cut" placeholder="e.g. Cushion Cut" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Status Tag</label>
                        <select name="status" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                            <option value="INQUIRE">INQUIRE</option>
                            <option value="UPON REQUEST">UPON REQUEST</option>
                            <option value="PRIVATE SALE">PRIVATE SALE</option>
                            <option value="RESERVED">RESERVED</option>
                        </select>
                    </div>

                    <!-- Image path & Price Tier Row -->
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Image URL or Local Filename</label>
                            <input type="text" name="image" placeholder="e.g. https://example.com/gem.jpg or ceylon-blue-sapphire.jpg" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                            <span class="text-[9px] text-gray-500 font-light mt-1 block">Paste an image URL or input a local filename located inside /public/images/</span>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Valuation Tier</label>
                            <input type="text" name="price_tier" placeholder="e.g. Investment Grade" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Detailed Monograph Description</label>
                        <textarea name="description" rows="3" placeholder="Enter micro-level gemological details..." class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-white text-black font-semibold tracking-[0.2em] text-xs uppercase py-3.5 rounded-full hover:bg-gray-200 transition-all shadow-lg hover:shadow-white/10 flex items-center justify-center space-x-2">
                        <i data-lucide="save" class="w-3.5 h-3.5"></i>
                        <span>Register Listing</span>
                    </button>
                </form>
            </section>

            <!-- Right: Gemstone List Table -->
            <section class="lg:col-span-7 bg-surface border border-borderGray rounded-3xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-borderGray">
                    <h2 class="text-sm font-medium uppercase tracking-wider text-white">Active Vault Inventory</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs font-light">
                        <thead class="bg-dark/60 text-[10px] uppercase tracking-widest text-gray-400 border-b border-borderGray">
                            <tr>
                                <th class="px-6 py-4">Acquisition Name</th>
                                <th class="px-6 py-4">Specification</th>
                                <th class="px-6 py-4">Valuation</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-borderGray/50">
                            <?php if (!empty($gems)): ?>
                                <?php foreach ($gems as $gem): ?>
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <!-- Image + Title -->
                                        <td class="px-6 py-4 flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded border border-gray-800 bg-dark overflow-hidden flex-shrink-0 flex items-center justify-center p-1">
                                                <?php 
                                                $imgSrc = $gem['image'] ?? '';
                                                $decoded = json_decode($imgSrc, true);
                                                if (is_array($decoded) && count($decoded) > 0) $useImg = $decoded[0]; else $useImg = $imgSrc;
                                                $imgUrl = (strpos((string)$useImg, 'http') === 0 || strpos((string)$useImg, 'data:') === 0) ? $useImg : BASE_URL . '/public/images/' . $useImg;
                                                ?>
                                                <img src="<?= htmlspecialchars($imgUrl); ?>" alt="" class="max-h-full max-w-full object-contain">
                                            </div>
                                            <div>
                                                <div class="font-medium text-white text-sm"><?= htmlspecialchars($gem['title']); ?></div>
                                                <div class="text-[10px] text-gray-500"><?= htmlspecialchars($gem['cut']); ?></div>
                                            </div>
                                        </td>
                                        
                                        <!-- Spec -->
                                        <td class="px-6 py-4">
                                            <div class="text-gray-300"><?= htmlspecialchars($gem['carats']); ?></div>
                                            <div class="text-gray-500 font-light"><?= htmlspecialchars($gem['origin']); ?></div>
                                                <div class="text-gray-500 font-light"><?= htmlspecialchars($gem['location'] ?? $gem['origin']); ?></div>
                                        </td>

                                        <!-- Price -->
                                        <td class="px-6 py-4 text-gold font-medium">
                                            <?= htmlspecialchars($gem['price_tier']); ?>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4">
                                            <span class="inline-block px-2 py-0.5 text-[9px] uppercase tracking-wider bg-dark border border-gray-800 rounded text-gray-300 font-medium">
                                                <?= htmlspecialchars($gem['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic font-light">
                                        No gemstones registered in the database inventory.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>

    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
