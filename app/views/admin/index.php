<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Admin Dashboard | Rare Stones'; ?></title>
    
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
<body class="bg-dark text-gray-300 font-sans antialiased flex flex-col md:flex-row min-h-screen">

    <!-- Mobile Admin Header -->
    <header class="md:hidden w-full bg-surface border-b border-borderGray flex items-center justify-between p-4 sticky top-0 z-40">
        <a href="<?= BASE_URL; ?>/" class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full border border-gold flex items-center justify-center text-gold bg-gold/10">
                <i data-lucide="gem" class="w-4 h-4"></i>
            </div>
            <span class="tracking-[0.2em] font-light text-white text-sm uppercase">Rare Stones</span>
        </a>
        <button class="p-2 text-gray-400 hover:text-white transition-colors" onclick="toggleAdminSidebar()" aria-label="Toggle Navigation">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
    </header>

    <!-- Admin Sidebar Backdrop (Mobile only) -->
    <div id="admin-sidebar-backdrop" class="fixed inset-0 bg-black/60 z-40 hidden transition-opacity duration-300" onclick="toggleAdminSidebar()"></div>

    <!-- Sidebar Inclusion -->
    <?php require_once APP_ROOT . '/views/admin/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-6 md:p-12 overflow-y-auto overflow-x-hidden max-w-7xl w-full">
        
        <!-- Global Message Alerts -->
        <?php if (!empty($success)): ?>
            <div class="p-4 mb-6 bg-emerald-950/30 border border-emerald-800/50 rounded-xl text-xs text-emerald-400 flex items-center space-x-2 relative z-50">
                <i data-lucide="check-circle" class="w-4 h-4 flex-shrink-0 text-emerald-500"></i>
                <span><?= htmlspecialchars($success); ?></span>
            </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="p-4 mb-6 bg-red-950/30 border border-red-800/50 rounded-xl text-xs text-red-400 flex items-center space-x-2 relative z-50">
                <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0 text-red-500"></i>
                <span><?= htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <!-- 1. FEEDBACKS MODERATION TAB -->
        <div id="tab-feedbacks" class="tab-content space-y-8">
            <!-- Header -->
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-borderGray pb-6 mb-8 gap-4">
                <div>
                    <h1 class="font-serif text-3xl md:text-4xl text-white font-light">Client Reflection <span class="italic text-gold">Moderation</span></h1>
                    <p class="text-xs text-gray-400 mt-1 font-light">Approve or reject customer reviews to publish them on the public vault landing page.</p>
                </div>
                
                <div class="flex items-center space-x-3 text-xs bg-surface border border-borderGray px-4 py-2.5 rounded-xl font-light">
                    <i data-lucide="user-check" class="w-4 h-4 text-gold"></i>
                    <span class="text-white">Admin Session Logged</span>
                </div>
            </header>

            <!-- Stats Grid -->
            <section class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="bg-surface border border-borderGray p-6 rounded-2xl space-y-2 shadow-xl">
                    <div class="flex justify-between items-center text-gray-400">
                        <span class="text-[10px] tracking-wider uppercase font-medium">Pending Moderation</span>
                        <i data-lucide="clock" class="w-4 h-4 text-gold"></i>
                    </div>
                    <div class="text-3xl font-light text-white"><?= $stats['pendingReviews']; ?></div>
                </div>
                <div class="bg-surface border border-borderGray p-6 rounded-2xl space-y-2 shadow-xl">
                    <div class="flex justify-between items-center text-gray-400">
                        <span class="text-[10px] tracking-wider uppercase font-medium">Approved Reviews</span>
                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-500"></i>
                    </div>
                    <div class="text-3xl font-light text-white"><?= $stats['approvedReviews']; ?></div>
                </div>
                <div class="bg-surface border border-borderGray p-6 rounded-2xl space-y-2 shadow-xl">
                    <div class="flex justify-between items-center text-gray-400">
                        <span class="text-[10px] tracking-wider uppercase font-medium">Gems in Vault</span>
                        <i data-lucide="gem" class="w-4 h-4 text-gold"></i>
                    </div>
                    <div class="text-3xl font-light text-white"><?= $stats['totalGems']; ?></div>
                </div>
                <div class="bg-surface border border-borderGray p-6 rounded-2xl space-y-2 shadow-xl">
                    <div class="flex justify-between items-center text-gray-400">
                        <span class="text-[10px] tracking-wider uppercase font-medium">Insights Published</span>
                        <i data-lucide="book-open" class="w-4 h-4 text-blue-400"></i>
                    </div>
                    <div class="text-3xl font-light text-white"><?= $stats['totalNews']; ?></div>
                </div>
            </section>

            <!-- Feedback Table -->
            <section class="bg-surface border border-borderGray rounded-3xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-borderGray flex justify-between items-center">
                    <h2 class="text-sm font-medium uppercase tracking-wider text-white">Verification Queue</h2>
                    <span class="px-2.5 py-1 text-[10px] bg-dark border border-gray-800 rounded text-gray-400">Moderated Real-time</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm font-light">
                        <thead class="bg-dark/60 text-[10px] uppercase tracking-widest text-gray-400 border-b border-borderGray">
                            <tr>
                                <th class="px-6 py-4">Client Detail</th>
                                <th class="px-6 py-4">Rating</th>
                                <th class="px-6 py-4">Reflection Message</th>
                                <th class="px-6 py-4">Submitted At</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Moderation Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-borderGray/50">
                            <?php if (!empty($feedbacks)): ?>
                                <?php foreach ($feedbacks as $fb): ?>
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-white"><?= htmlspecialchars($fb['user_name']); ?></div>
                                            <div class="text-xs text-gray-500 font-light"><?= htmlspecialchars($fb['user_email']); ?></div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center text-gold space-x-0.5">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i data-lucide="star" class="w-3.5 h-3.5 <?= $i <= $fb['rating'] ? 'fill-gold' : 'text-gray-700'; ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 max-w-sm">
                                            <p class="text-xs text-gray-300 leading-relaxed font-light truncate hover:text-clip hover:whitespace-normal" title="<?= htmlspecialchars($fb['message']); ?>">
                                                <?= htmlspecialchars($fb['message']); ?>
                                            </p>
                                        </td>
                                        <td class="px-6 py-4 text-xs text-gray-500 font-light">
                                            <?= date('M d, Y H:i', strtotime($fb['created_at'])); ?>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <?php if ($fb['status'] === 'approved'): ?>
                                                <span class="inline-block px-2.5 py-0.5 text-[9px] uppercase tracking-wider bg-emerald-950/40 border border-emerald-800/40 text-emerald-400 rounded-full font-medium">Approved</span>
                                            <?php elseif ($fb['status'] === 'rejected'): ?>
                                                <span class="inline-block px-2.5 py-0.5 text-[9px] uppercase tracking-wider bg-red-950/40 border border-red-800/40 text-red-400 rounded-full font-medium">Rejected</span>
                                            <?php else: ?>
                                                <span class="inline-block px-2.5 py-0.5 text-[9px] uppercase tracking-wider bg-yellow-950/40 border border-yellow-800/40 text-yellow-400 rounded-full font-medium animate-pulse">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end space-x-2">
                                                <?php if ($fb['status'] !== 'approved'): ?>
                                                    <a href="<?= BASE_URL; ?>/admin/feedback-status/?id=<?= $fb['id']; ?>&status=approved" 
                                                       class="px-3 py-1.5 bg-emerald-600 text-white hover:bg-emerald-500 rounded-lg text-xs font-semibold transition-all shadow-md flex items-center space-x-1">
                                                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                                        <span>Approve</span>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($fb['status'] !== 'rejected'): ?>
                                                    <a href="<?= BASE_URL; ?>/admin/feedback-status/?id=<?= $fb['id']; ?>&status=rejected" 
                                                       class="px-3 py-1.5 bg-red-950/40 border border-red-800/50 text-red-400 hover:bg-red-800 hover:text-white rounded-lg text-xs font-semibold transition-all flex items-center space-x-1">
                                                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                                        <span>Reject</span>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic font-light">
                                        No customer feedback records found in database.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <!-- 2. GEMSTONES MANAGEMENT TAB -->
        <div id="tab-gems" class="tab-content hidden space-y-8">
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

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Add/Edit Form -->
                <section id="gem-form-section" class="lg:col-span-7 bg-surface border border-borderGray p-8 rounded-3xl shadow-2xl relative overflow-hidden">
                    <h2 class="font-serif text-2xl text-white font-light mb-6 flex items-center space-x-2">
                        <i id="gem-form-icon" data-lucide="plus-circle" class="w-5 h-5 text-gold"></i>
                        <span id="gem-form-title">Register New Gemstone</span>
                    </h2>

                    <form id="gemstone-form" action="<?= BASE_URL; ?>/?route=admin_gems" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <input type="hidden" name="id" id="gem-id" value="0">

                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Gem Title</label>
                            <input type="text" name="title" id="gem-title" required placeholder="e.g. Ceylon Blue Sapphire" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Origin Source</label>
                                <input type="text" name="origin" id="gem-origin" required placeholder="e.g. Sri Lanka" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Selling Area / Branch</label>
                                <input type="text" name="location" id="gem-location" required placeholder="e.g. Ratnapura Branch" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Carat Weight</label>
                                <input type="text" name="carats" id="gem-carats" required placeholder="e.g. 8.12 ct" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Optical Cut</label>
                                <input type="text" name="cut" id="gem-cut" required placeholder="e.g. Cushion Cut" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Status Tag</label>
                                <select name="status" id="gem-status" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                                    <option value="INQUIRE">INQUIRE</option>
                                    <option value="UPON REQUEST">UPON REQUEST</option>
                                    <option value="PRIVATE SALE">PRIVATE SALE</option>
                                    <option value="RESERVED">RESERVED</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Image Selection (Paste URL or Upload File)</label>
                                <div class="space-y-2">
                                    <input type="text" name="image" id="gem-image" placeholder="Paste URL/Filename (e.g. ceylon-blue-sapphire.jpg)" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                                    <input type="file" name="image_file" accept="image/*" class="w-full bg-dark border border-gray-800 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:bg-white/10 file:text-white file:hover:bg-white/20 text-[10px] text-gray-400 rounded-xl py-1 px-2 focus:outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Valuation Tier</label>
                                <input type="text" name="price_tier" id="gem-price_tier" required placeholder="e.g. Investment Grade" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Detailed Monograph Description</label>
                            <textarea name="description" id="gem-description" required rows="3" placeholder="Enter micro-level gemological details..." class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors resize-none"></textarea>
                        </div>

                        <div class="flex items-center space-x-3 pt-2">
                            <button type="button" id="btn-cancel-gem-edit" onclick="cancelGemEdit()" class="hidden px-5 py-3.5 bg-dark border border-gray-800 text-gray-400 hover:text-white hover:border-gray-600 rounded-full text-xs font-semibold tracking-wider uppercase transition-all flex items-center space-x-1.5">
                                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                <span>Cancel</span>
                            </button>
                            <button type="submit" id="btn-submit-gem" class="flex-1 bg-white text-black font-semibold tracking-[0.2em] text-xs uppercase py-3.5 rounded-full hover:bg-gray-200 transition-all shadow-lg flex items-center justify-center space-x-2">
                                <i id="gem-submit-icon" data-lucide="save" class="w-3.5 h-3.5"></i>
                                <span id="gem-form-submit-text">Register Listing</span>
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Gem Inventory List -->
                <section class="lg:col-span-5 bg-surface border border-borderGray rounded-3xl shadow-2xl overflow-hidden">
                    <div class="p-6 border-b border-borderGray">
                        <h2 class="text-sm font-medium uppercase tracking-wider text-white">Active Vault Inventory</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs font-light">
                            <thead class="bg-dark/60 text-[10px] uppercase tracking-widest text-gray-400 border-b border-borderGray">
                                <tr>
                                    <th class="px-4 py-4">Gem</th>
                                    <th class="px-4 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-borderGray/50">
                                <?php if (!empty($gems)): ?>
                                    <?php foreach ($gems as $gem): ?>
                                        <tr class="hover:bg-white/5 transition-colors">
                                            <td class="px-4 py-4 flex items-center space-x-3">
                                                <div class="w-10 h-10 rounded border border-gray-800 bg-dark overflow-hidden flex-shrink-0 flex items-center justify-center p-1">
                                                    <?php 
                                                    $imgSrc = $gem['image'];
                                                    $imgUrl = (strpos($imgSrc, 'http') === 0 || strpos($imgSrc, 'data:') === 0) ? $imgSrc : BASE_URL . '/public/images/' . $imgSrc;
                                                    ?>
                                                    <img src="<?= htmlspecialchars($imgUrl); ?>" alt="" class="max-h-full max-w-full object-contain">
                                                </div>
                                                <div class="max-w-[160px] md:max-w-[200px]">
                                                    <div class="font-medium text-white text-sm truncate"><?= htmlspecialchars($gem['title']); ?></div>
                                                    <div class="text-[10px] text-gray-500 truncate"><?= htmlspecialchars($gem['cut']); ?></div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-right">
                                                <div class="flex items-center justify-end space-x-1.5">
                                                    <!-- Edit -->
                                                    <button data-gem="<?= htmlspecialchars(json_encode($gem), ENT_QUOTES, 'UTF-8'); ?>" onclick="editGem(this)" title="Edit Gemstone" class="w-8 h-8 inline-flex items-center justify-center bg-white/5 border border-borderGray hover:bg-white/10 text-gray-300 hover:text-white rounded-lg transition-all duration-200">
                                                        <i data-lucide="edit-3" class="w-3.5 h-3.5 text-gold"></i>
                                                    </button>

                                                    <!-- Delete -->
                                                    <button onclick="deleteGem(<?= $gem['id']; ?>)" title="Delete Gemstone" class="w-8 h-8 inline-flex items-center justify-center bg-red-950/40 border border-red-800/50 hover:bg-red-850 hover:text-white text-red-400 rounded-lg transition-all duration-200">
                                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" class="px-4 py-12 text-center text-gray-500 italic font-light">
                                            No gemstones registered in the database inventory.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

        <!-- 3. NEWS & EDITORIAL TAB -->
        <div id="tab-news" class="tab-content hidden space-y-8">
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-borderGray pb-6 mb-8 gap-4">
                <div>
                    <h1 class="font-serif text-3xl md:text-4xl text-white font-light">Editorial & <span class="italic text-gold">Insights</span></h1>
                    <p class="text-xs text-gray-400 mt-1 font-light">Publish new insight articles, market reports, and global collecting guides.</p>
                </div>
                
                <a href="<?= BASE_URL; ?>/news/" target="_blank" class="px-4 py-2 bg-white/5 border border-borderGray rounded-xl text-xs text-gray-300 hover:text-white hover:bg-white/10 transition-all flex items-center space-x-1.5 font-light">
                    <i data-lucide="eye" class="w-4 h-4 text-gold"></i>
                    <span>View Public Editorial</span>
                </a>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <section class="lg:col-span-7 bg-surface border border-borderGray p-8 rounded-3xl shadow-2xl relative overflow-hidden">
                    <h2 class="font-serif text-2xl text-white font-light mb-6 flex items-center space-x-2">
                        <i id="news-form-icon" data-lucide="plus-circle" class="w-5 h-5 text-gold"></i>
                        <span id="news-form-title">Publish Insight</span>
                    </h2>

                    <form action="<?= BASE_URL; ?>/?route=admin_news" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <input type="hidden" name="id" id="news-id" value="0">

                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Article Title</label>
                            <input type="text" name="title" id="news-title" required placeholder="e.g. Ratnapura Mining Season: 2026 Quality Outlook" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Subtitle / Excerpt</label>
                            <input type="text" name="subtitle" id="news-subtitle" required placeholder="e.g. Demand for rare gems is surging..." class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Meta Details</label>
                                <input type="text" name="meta" id="news-meta" required placeholder="Origin Report • April 28, 2026 • 4 min read" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Custom URL Slug</label>
                                <input type="text" name="slug" id="news-slug" placeholder="e.g. ratnapura-mining-outlook" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Author Name</label>
                                <input type="text" name="author" id="news-author" required placeholder="e.g. Elena Vance" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Author Role</label>
                                <input type="text" name="author_role" id="news-author-role" required placeholder="e.g. Field Inspection Lead" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Image Selection (Paste URL or Upload File)</label>
                            <div class="space-y-2">
                                <input type="text" name="image" id="news-image" placeholder="Paste URL/Filename (e.g. news-bracelet.jpg)" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                                <input type="file" name="image_file" accept="image/*" class="w-full bg-dark border border-gray-800 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:bg-white/10 file:text-white file:hover:bg-white/20 text-[10px] text-gray-400 rounded-xl py-1 px-2 focus:outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Article Content (HTML Supported)</label>
                            <textarea name="content" id="news-content" required rows="6" placeholder="<p>Enter the full body of the article using paragraph tags...</p>" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors resize-none h-40"></textarea>
                        </div>

                        <div class="flex items-center space-x-3 pt-2">
                            <button type="button" id="btn-cancel-news-edit" onclick="cancelNewsEdit()" class="hidden px-5 py-3.5 bg-dark border border-gray-800 text-gray-400 hover:text-white hover:border-gray-600 rounded-full text-xs font-semibold tracking-wider uppercase transition-all flex items-center space-x-1.5">
                                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                <span>Cancel</span>
                            </button>
                            <button type="submit" id="btn-submit-news" class="flex-1 bg-white text-black font-semibold tracking-[0.2em] text-xs uppercase py-3.5 rounded-full hover:bg-gray-200 transition-all shadow-lg flex items-center justify-center space-x-2">
                                <i id="news-submit-icon" data-lucide="send" class="w-3.5 h-3.5"></i>
                                <span id="news-form-submit-text">Publish Article</span>
                            </button>
                        </div>
                    </form>
                </section>

                <section class="lg:col-span-5 bg-surface border border-borderGray rounded-3xl shadow-2xl overflow-hidden">
                    <div class="p-6 border-b border-borderGray">
                        <h2 class="text-sm font-medium uppercase tracking-wider text-white">Active Editorial Inventory</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs font-light">
                            <thead class="bg-dark/60 text-[10px] uppercase tracking-widest text-gray-400 border-b border-borderGray">
                                <tr>
                                    <th class="px-4 py-4">Article</th>
                                    <th class="px-4 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-borderGray/50">
                                <?php if (!empty($newsArticles)): ?>
                                    <?php foreach ($newsArticles as $art): ?>
                                        <tr class="hover:bg-white/5 transition-colors">
                                            <td class="px-4 py-4 flex items-center space-x-3">
                                                <div class="w-10 h-10 rounded border border-gray-800 bg-dark overflow-hidden flex-shrink-0 flex items-center justify-center p-1">
                                                    <?php 
                                                    $imgSrc = $art['image'];
                                                    $imgUrl = (strpos($imgSrc, 'http') === 0 || strpos($imgSrc, 'data:') === 0) ? $imgSrc : BASE_URL . '/public/images/' . $imgSrc;
                                                    ?>
                                                    <img src="<?= htmlspecialchars($imgUrl); ?>" alt="" class="max-h-full max-w-full object-cover">
                                                </div>
                                                <div class="max-w-[160px] md:max-w-[200px]">
                                                    <div class="font-medium text-white text-sm truncate"><?= htmlspecialchars($art['title']); ?></div>
                                                    <div class="text-[10px] text-gray-500 truncate"><?= htmlspecialchars($art['subtitle']); ?></div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-right">
                                                <div class="flex items-center justify-end space-x-1.5">
                                                    <!-- Headline -->
                                                    <?php if (isset($art['is_headline']) && $art['is_headline']): ?>
                                                        <span title="Current Headline" class="w-8 h-8 inline-flex items-center justify-center bg-gold/10 border border-gold/45 text-gold rounded-lg shadow-sm">
                                                            <i data-lucide="star" class="w-3.5 h-3.5 fill-gold text-gold"></i>
                                                        </span>
                                                    <?php else: ?>
                                                        <form action="<?= BASE_URL; ?>/?route=admin_headline" method="POST" class="inline">
                                                            <input type="hidden" name="id" value="<?= $art['id']; ?>">
                                                            <button type="submit" title="Make Headline" class="w-8 h-8 inline-flex items-center justify-center bg-dark border border-gray-800 hover:border-gray-650 text-gray-400 hover:text-white rounded-lg transition-all duration-200">
                                                                <i data-lucide="star" class="w-3.5 h-3.5"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>

                                                    <!-- Read -->
                                                    <a href="<?= BASE_URL; ?>/article/<?= urlencode($art['slug']); ?>/" target="_blank" title="Read Article" class="w-8 h-8 inline-flex items-center justify-center bg-gold text-black hover:bg-gold/80 rounded-lg transition-all duration-200 shadow-md">
                                                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                                    </a>

                                                    <!-- Edit -->
                                                    <button data-article="<?= htmlspecialchars(json_encode($art), ENT_QUOTES, 'UTF-8'); ?>" onclick="editNews(this)" title="Edit Article" class="w-8 h-8 inline-flex items-center justify-center bg-white/5 border border-borderGray hover:bg-white/10 text-gray-300 hover:text-white rounded-lg transition-all duration-200">
                                                        <i data-lucide="edit-3" class="w-3.5 h-3.5 text-gold"></i>
                                                    </button>

                                                    <!-- Delete -->
                                                    <button onclick="deleteNews(<?= $art['id']; ?>)" title="Delete Article" class="w-8 h-8 inline-flex items-center justify-center bg-red-950/40 border border-red-800/50 hover:bg-red-850 hover:text-white text-red-400 rounded-lg transition-all duration-200">
                                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" class="px-4 py-12 text-center text-gray-500 italic font-light">
                                            No editorial insights found in database.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

        <!-- 4. BRAND HERITAGE TAB -->
        <div id="tab-heritage" class="tab-content hidden space-y-8">
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-borderGray pb-6 mb-8 gap-4">
                <div>
                    <h1 class="font-serif text-3xl md:text-4xl text-white font-light">Brand <span class="italic text-gold">Heritage</span></h1>
                    <p class="text-xs text-gray-400 mt-1 font-light">Customize the brand philosophy, primary network definitions, and historical quotes shown on the heritage page.</p>
                </div>
                
                <a href="<?= BASE_URL; ?>/heritage/" target="_blank" class="px-4 py-2 bg-white/5 border border-borderGray rounded-xl text-xs text-gray-300 hover:text-white hover:bg-white/10 transition-all flex items-center space-x-1.5 font-light">
                    <i data-lucide="eye" class="w-4 h-4 text-gold"></i>
                    <span>View Public Heritage Page</span>
                </a>
            </header>

            <section class="bg-surface border border-borderGray p-8 md:p-12 rounded-3xl shadow-2xl relative overflow-hidden max-w-4xl mx-auto">
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-gold/5 blur-[80px] rounded-full pointer-events-none z-0"></div>

                <h2 class="font-serif text-3xl text-white font-light mb-8 flex items-center space-x-3 border-b border-gray-800 pb-4 relative z-10">
                    <i data-lucide="edit-3" class="w-6 h-6 text-gold"></i>
                    <span>Modify Brand Dossier</span>
                </h2>

                <form action="<?= BASE_URL; ?>/?route=admin_heritage" method="POST" enctype="multipart/form-data" class="space-y-6 relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Network Headline Title</label>
                            <input type="text" name="title" required value="<?= htmlspecialchars($heritageArticle['title']); ?>" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Hero Subtitle</label>
                            <input type="text" name="subtitle" required value="<?= htmlspecialchars($heritageArticle['subtitle']); ?>" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Hero Image Selection (Paste URL or Upload File)</label>
                            <div class="space-y-2">
                                <input type="text" name="image" id="heritage-image" value="<?= htmlspecialchars($heritageArticle['image']); ?>" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                                <input type="file" name="image_file" accept="image/*" class="w-full bg-dark border border-gray-800 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:bg-white/10 file:text-white file:hover:bg-white/20 text-[10px] text-gray-400 rounded-xl py-1.5 px-2 focus:outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Philosophy Statement / Quote</label>
                            <input type="text" name="quote" required value="<?= htmlspecialchars($heritageArticle['author']); ?>" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Heritage Detailed Narrative Content (HTML Supported)</label>
                        <textarea name="content" required rows="10" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors resize-none h-64"><?= htmlspecialchars($heritageArticle['content']); ?></textarea>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="w-full md:w-auto px-8 py-4 bg-white text-black font-semibold tracking-[0.2em] text-xs uppercase rounded-full hover:bg-gray-200 transition-all shadow-lg flex items-center justify-center space-x-2">
                            <i data-lucide="save" class="w-3.5 h-3.5"></i>
                            <span>Save Brand Narrative</span>
                        </button>
                    </div>
                </form>
            </section>
        </div>

        <!-- 5. DISCOVER PAGE TAB -->
        <div id="tab-discover" class="tab-content hidden space-y-8">
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-borderGray pb-6 mb-8 gap-4">
                <div>
                    <h1 class="font-serif text-3xl md:text-4xl text-white font-light">Discover <span class="italic text-gold">Page</span></h1>
                    <p class="text-xs text-gray-400 mt-1 font-light">Manage your global vault branches and the Discover page content.</p>
                </div>
                
                <a href="<?= BASE_URL; ?>/discover/" target="_blank" class="px-4 py-2 bg-white/5 border border-borderGray rounded-xl text-xs text-gray-300 hover:text-white hover:bg-white/10 transition-all flex items-center space-x-1.5 font-light">
                    <i data-lucide="eye" class="w-4 h-4 text-gold"></i>
                    <span>View Public Discover Page</span>
                </a>
            </header>

            <section class="bg-surface border border-borderGray p-8 md:p-12 rounded-3xl shadow-2xl relative overflow-hidden max-w-4xl mx-auto">
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-gold/5 blur-[80px] rounded-full pointer-events-none z-0"></div>

                <h2 class="font-serif text-3xl text-white font-light mb-8 flex items-center space-x-3 border-b border-gray-800 pb-4 relative z-10">
                    <i data-lucide="map" class="w-6 h-6 text-gold"></i>
                    <span>Modify Discover Details</span>
                </h2>

                <form action="<?= BASE_URL; ?>/?route=admin_discover" method="POST" class="space-y-6 relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Page Title</label>
                            <input type="text" name="title" required value="<?= htmlspecialchars($discoverArticle['title']); ?>" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Page Subtitle</label>
                            <input type="text" name="subtitle" required value="<?= htmlspecialchars($discoverArticle['subtitle']); ?>" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Branches List (JSON Format)</label>
                        <div class="bg-dark border border-gray-800 rounded-xl p-4 mb-2 text-xs text-gray-400 font-mono overflow-auto">
                            [<br>
                            &nbsp;&nbsp;{ "lat": 6.9271, "lng": 79.8612, "name": "Rare Stones - Colombo Gallery", "city": "Colombo, Sri Lanka", "listings": "42 active lots" }<br>
                            ]
                        </div>
                        <?php 
                        $jsonContent = $discoverArticle['content'];
                        $decoded = json_decode($jsonContent, true);
                        $prettyJson = $decoded ? json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : $jsonContent;
                        ?>
                        <textarea name="content" required rows="12" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs font-mono focus:outline-none focus:border-gray-500 font-light transition-colors resize-none h-64"><?= htmlspecialchars($prettyJson); ?></textarea>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="w-full md:w-auto px-8 py-4 bg-white text-black font-semibold tracking-[0.2em] text-xs uppercase rounded-full hover:bg-gray-200 transition-all shadow-lg flex items-center justify-center space-x-2">
                            <i data-lucide="save" class="w-3.5 h-3.5"></i>
                            <span>Save Discover Config</span>
                        </button>
                    </div>
                </form>
            </section>
        </div>

        <!-- 6. CONTACT DETAILS TAB -->
        <div id="tab-contact" class="tab-content hidden space-y-8">
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-borderGray pb-6 mb-8 gap-4">
                <div>
                    <h1 class="font-serif text-3xl md:text-4xl text-white font-light">Contact <span class="italic text-gold">Details</span></h1>
                    <p class="text-xs text-gray-400 mt-1 font-light">Manage the phone numbers and links displayed in the Concierge directory.</p>
                </div>
            </header>

            <section class="bg-surface border border-borderGray p-8 md:p-12 rounded-3xl shadow-2xl relative overflow-hidden max-w-4xl mx-auto">
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-gold/5 blur-[80px] rounded-full pointer-events-none z-0"></div>

                <h2 class="font-serif text-3xl text-white font-light mb-8 flex items-center space-x-3 border-b border-gray-800 pb-4 relative z-10">
                    <i data-lucide="phone-call" class="w-6 h-6 text-gold"></i>
                    <span>Concierge Contact Info</span>
                </h2>

                <?php 
                    $contacts = json_decode($contactArticle['content'], true) ?? [];
                    $whatsapp = $contacts['whatsapp'] ?? '';
                    $phone = $contacts['phone'] ?? '';
                    $email = $contacts['email'] ?? '';
                    $instagram = $contacts['instagram'] ?? '';
                    $facebook = $contacts['facebook'] ?? '';
                ?>

                <form action="<?= BASE_URL; ?>/?route=admin_contact" method="POST" class="space-y-6 relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium flex items-center space-x-2"><i data-lucide="message-circle" class="w-3 h-3 text-[#25D366]"></i> <span>WhatsApp Number</span></label>
                            <input type="text" name="whatsapp" required value="<?= htmlspecialchars($whatsapp); ?>" placeholder="+94 77 123 4567" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium flex items-center space-x-2"><i data-lucide="phone" class="w-3 h-3 text-gold"></i> <span>Direct Phone Line</span></label>
                            <input type="text" name="phone" required value="<?= htmlspecialchars($phone); ?>" placeholder="+94 11 234 5678" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium flex items-center space-x-2"><i data-lucide="mail" class="w-3 h-3 text-white"></i> <span>Secure Email</span></label>
                            <input type="email" name="email" required value="<?= htmlspecialchars($email); ?>" placeholder="concierge@rarestones.lk" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium flex items-center space-x-2"><i data-lucide="instagram" class="w-3 h-3 text-[#E1306C]"></i> <span>Instagram Handle</span></label>
                            <input type="text" name="instagram" required value="<?= htmlspecialchars($instagram); ?>" placeholder="rarestones.ceylon" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium flex items-center space-x-2"><i data-lucide="facebook" class="w-3 h-3 text-[#1877F2]"></i> <span>Facebook Page Name</span></label>
                        <input type="text" name="facebook" required value="<?= htmlspecialchars($facebook); ?>" placeholder="Rare Stones Ceylon" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="w-full md:w-auto px-8 py-4 bg-white text-black font-semibold tracking-[0.2em] text-xs uppercase rounded-full hover:bg-gray-200 transition-all shadow-lg flex items-center justify-center space-x-2">
                            <i data-lucide="save" class="w-3.5 h-3.5"></i>
                            <span>Save Contact Info</span>
                        </button>
                    </div>
                </form>
            </section>
        </div>

    </main>

    <script>
        // Responsive Admin Sidebar controls
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('admin-sidebar-backdrop');
            if (sidebar && backdrop) {
                const isOpen = !sidebar.classList.contains('-translate-x-full');
                if (isOpen) {
                    closeAdminSidebar();
                } else {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('hidden');
                }
            }
        }

        function closeAdminSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('admin-sidebar-backdrop');
            if (sidebar && backdrop) {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        // Tab switching logic
        function switchTab(tabId) {
            // Update sidebar links active styles
            document.querySelectorAll('.sidebar-nav-link').forEach(link => {
                if (link.getAttribute('href') === '#' + tabId) {
                    link.className = "sidebar-nav-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all text-xs tracking-wider uppercase bg-gold/15 text-gold border border-gold/30 font-medium";
                } else {
                    link.className = "sidebar-nav-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all text-xs tracking-wider uppercase text-gray-400 hover:bg-white/5 hover:text-white border border-transparent";
                }
            });

            // Hide all tab content sections, show the active one
            document.querySelectorAll('.tab-content').forEach(section => {
                if (section.id === 'tab-' + tabId) {
                    section.classList.remove('hidden');
                } else {
                    section.classList.add('hidden');
                }
            });
            
            // Re-render Lucide icons inside shown panel
            if (window.lucide) {
                lucide.createIcons();
            }

            // Auto-close sidebar on mobile after tab selection
            closeAdminSidebar();
        }

        // Watch hash change
        window.addEventListener('hashchange', function() {
            const tab = window.location.hash.substring(1) || 'feedbacks';
            switchTab(tab);
        });

        // Initial setup
        const initialTab = window.location.hash.substring(1) || 'feedbacks';
        switchTab(initialTab);
        
        // Auto-dismiss alert banners after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.querySelectorAll('.bg-emerald-950\\/30, .bg-red-950\\/30').forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });

        // Edit Gemstone Function
        function editGem(btn) {
            const gem = JSON.parse(btn.getAttribute('data-gem'));
            
            // Populate form fields
            document.getElementById('gem-id').value = gem.id;
            document.getElementById('gem-title').value = gem.title || '';
            document.getElementById('gem-origin').value = gem.origin || '';
            document.getElementById('gem-location').value = gem.location || '';
            document.getElementById('gem-carats').value = gem.carats || '';
            document.getElementById('gem-cut').value = gem.cut || '';
            document.getElementById('gem-status').value = gem.status || 'INQUIRE';
            document.getElementById('gem-image').value = gem.image || '';
            document.getElementById('gem-price_tier').value = gem.price_tier || '';
            document.getElementById('gem-description').value = gem.description || '';
            
            // UI Updates
            document.getElementById('gem-form-title').innerText = 'Edit Gemstone';
            document.getElementById('gem-form-submit-text').innerText = 'Update Gemstone';
            
            // Change submit icon
            const submitIcon = document.getElementById('gem-submit-icon');
            if (submitIcon) {
                submitIcon.setAttribute('data-lucide', 'check-circle');
            }
            // Change form icon
            const formIcon = document.getElementById('gem-form-icon');
            if (formIcon) {
                formIcon.setAttribute('data-lucide', 'edit-3');
            }
            
            // Show cancel button
            document.getElementById('btn-cancel-gem-edit').classList.remove('hidden');
            
            // Re-render Lucide icons for the form
            if (window.lucide) {
                lucide.createIcons();
            }
            
            // Scroll to form section
            document.getElementById('gem-form-section').scrollIntoView({ behavior: 'smooth' });
        }

        // Cancel Gemstone Edit Function
        function cancelGemEdit() {
            // Reset form
            document.getElementById('gemstone-form').reset();
            document.getElementById('gem-id').value = '0';
            
            // UI Updates
            document.getElementById('gem-form-title').innerText = 'Register New Gemstone';
            document.getElementById('gem-form-submit-text').innerText = 'Register Listing';
            
            // Change submit icon
            const submitIcon = document.getElementById('gem-submit-icon');
            if (submitIcon) {
                submitIcon.setAttribute('data-lucide', 'save');
            }
            // Change form icon
            const formIcon = document.getElementById('gem-form-icon');
            if (formIcon) {
                formIcon.setAttribute('data-lucide', 'plus-circle');
            }
            
            // Hide cancel button
            document.getElementById('btn-cancel-gem-edit').classList.add('hidden');
            
            // Re-render Lucide icons
            if (window.lucide) {
                lucide.createIcons();
            }
        }

        // Delete Gemstone Function
        function deleteGem(id) {
            if (confirm('Are you sure you want to permanently remove this gemstone listing from the vault?')) {
                window.location.href = '<?= BASE_URL; ?>/?route=admin_delete_gem&id=' + id;
            }
        }

        // Edit News Article Function
        function editNews(btn) {
            const art = JSON.parse(btn.getAttribute('data-article'));
            
            // Populate form fields
            document.getElementById('news-id').value = art.id;
            document.getElementById('news-title').value = art.title || '';
            document.getElementById('news-subtitle').value = art.subtitle || '';
            document.getElementById('news-meta').value = art.meta || '';
            document.getElementById('news-slug').value = art.slug || '';
            document.getElementById('news-author').value = art.author || '';
            document.getElementById('news-author-role').value = art.author_role || '';
            document.getElementById('news-image').value = art.image || '';
            document.getElementById('news-content').value = art.content || '';
            
            // UI Updates
            document.getElementById('news-form-title').innerText = 'Edit Insight';
            document.getElementById('news-form-submit-text').innerText = 'Update Article';
            
            // Change submit icon
            const submitIcon = document.getElementById('news-submit-icon');
            if (submitIcon) {
                submitIcon.setAttribute('data-lucide', 'check-circle');
            }
            // Change form icon
            const formIcon = document.getElementById('news-form-icon');
            if (formIcon) {
                formIcon.setAttribute('data-lucide', 'edit-3');
            }
            
            // Show cancel button
            document.getElementById('btn-cancel-news-edit').classList.remove('hidden');
            
            // Re-render Lucide icons
            if (window.lucide) {
                lucide.createIcons();
            }
            
            // Scroll to form parent
            document.getElementById('news-id').closest('section').scrollIntoView({ behavior: 'smooth' });
        }

        // Cancel News Edit Function
        function cancelNewsEdit() {
            // Reset form
            document.getElementById('news-id').closest('form').reset();
            document.getElementById('news-id').value = '0';
            
            // UI Updates
            document.getElementById('news-form-title').innerText = 'Publish Insight';
            document.getElementById('news-form-submit-text').innerText = 'Publish Article';
            
            // Change submit icon
            const submitIcon = document.getElementById('news-submit-icon');
            if (submitIcon) {
                submitIcon.setAttribute('data-lucide', 'send');
            }
            // Change form icon
            const formIcon = document.getElementById('news-form-icon');
            if (formIcon) {
                formIcon.setAttribute('data-lucide', 'plus-circle');
            }
            
            // Hide cancel button
            document.getElementById('btn-cancel-news-edit').classList.add('hidden');
            
            // Re-render Lucide icons
            if (window.lucide) {
                lucide.createIcons();
            }
        }

        // Delete News Function
        function deleteNews(id) {
            if (confirm('Are you sure you want to permanently delete this editorial insight article?')) {
                window.location.href = '<?= BASE_URL; ?>/?route=admin_delete_news&id=' + id;
            }
        }
    </script>
</body>
</html>
