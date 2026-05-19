<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Manage Editorial News | Rare Stones Admin'; ?></title>
    
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
                <h1 class="font-serif text-3xl md:text-4xl text-white font-light">Editorial & <span class="italic text-gold">Insights</span></h1>
                <p class="text-xs text-gray-400 mt-1 font-light">Publish new insight articles, market reports, and global collecting guides.</p>
            </div>
            
            <a href="<?= BASE_URL; ?>/news/" target="_blank" class="px-4 py-2 bg-white/5 border border-borderGray rounded-xl text-xs text-gray-300 hover:text-white hover:bg-white/10 transition-all flex items-center space-x-1.5 font-light">
                <i data-lucide="eye" class="w-4 h-4 text-gold"></i>
                <span>View Public Editorial</span>
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
            
            <!-- Left: Add News Form -->
            <section class="lg:col-span-5 bg-surface border border-borderGray p-8 rounded-3xl shadow-2xl relative overflow-hidden">
                <h2 class="font-serif text-2xl text-white font-light mb-6 flex items-center space-x-2">
                    <i data-lucide="plus-circle" class="w-5 h-5 text-gold"></i>
                    <span>Publish Insight</span>
                </h2>

                <form action="<?= BASE_URL; ?>/admin/news/" method="POST" class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Article Title</label>
                        <input type="text" name="title" required placeholder="e.g. Ratnapura Mining Season: 2026 Quality Outlook" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                    </div>

                    <!-- Subtitle -->
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Subtitle / Excerpt</label>
                        <input type="text" name="subtitle" required placeholder="e.g. Demand for rare gems is surging..." class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                    </div>

                    <!-- Meta and Slug Row -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Meta (e.g. Topic • Date • Time)</label>
                            <input type="text" name="meta" required placeholder="Origin Report • April 28, 2026 • 4 min read" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Custom URL Slug (Optional)</label>
                            <input type="text" name="slug" placeholder="e.g. ratnapura-mining-outlook" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                    </div>

                    <!-- Author & Role Row -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Author Name</label>
                            <input type="text" name="author" required placeholder="e.g. Elena Vance" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Author Role</label>
                            <input type="text" name="author_role" required placeholder="e.g. Field Inspection Lead" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        </div>
                    </div>

                    <!-- Image path -->
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Image URL or Local Filename</label>
                        <input type="text" name="image" required placeholder="e.g. https://example.com/news.jpg or news-bracelet.jpg" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                        <span class="text-[9px] text-gray-500 font-light mt-1 block">Paste an image URL or input a local filename located inside /public/images/</span>
                    </div>

                    <!-- Content Body -->
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Article Content (HTML Supported)</label>
                        <textarea name="content" required rows="6" placeholder="<p>Enter the full body of the article using paragraph tags...</p>" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors resize-none h-40"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-white text-black font-semibold tracking-[0.2em] text-xs uppercase py-3.5 rounded-full hover:bg-gray-200 transition-all shadow-lg hover:shadow-white/10 flex items-center justify-center space-x-2">
                        <i data-lucide="send" class="w-3.5 h-3.5"></i>
                        <span>Publish Article</span>
                    </button>
                </form>
            </section>

            <!-- Right: Articles List Table -->
            <section class="lg:col-span-7 bg-surface border border-borderGray rounded-3xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-borderGray">
                    <h2 class="text-sm font-medium uppercase tracking-wider text-white">Active Editorial Inventory</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs font-light">
                        <thead class="bg-dark/60 text-[10px] uppercase tracking-widest text-gray-400 border-b border-borderGray">
                            <tr>
                                <th class="px-6 py-4">Article</th>
                                <th class="px-6 py-4">Topic / Metadata</th>
                                <th class="px-6 py-4">Author</th>
                                <th class="px-6 py-4 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-borderGray/50">
                            <?php if (!empty($articles)): ?>
                                <?php foreach ($articles as $art): ?>
                                    <!-- Skip internal configuration pages to avoid confusion -->
                                    <?php if (in_array($art['slug'], ['heritage-philosophies', 'discover-page'])) continue; ?>
                                    
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <!-- Image + Title -->
                                        <td class="px-6 py-4 flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded border border-gray-800 bg-dark overflow-hidden flex-shrink-0 flex items-center justify-center p-1">
                                                <?php 
                                                $imgSrc = $art['image'];
                                                $imgUrl = (strpos($imgSrc, 'http') === 0 || strpos($imgSrc, 'data:') === 0) ? $imgSrc : BASE_URL . '/public/images/' . $imgSrc;
                                                ?>
                                                <img src="<?= htmlspecialchars($imgUrl); ?>" alt="" class="max-h-full max-w-full object-cover">
                                            </div>
                                            <div class="max-w-[200px]">
                                                <div class="font-medium text-white text-sm truncate"><?= htmlspecialchars($art['title']); ?></div>
                                                <div class="text-[10px] text-gray-500 truncate"><?= htmlspecialchars($art['subtitle']); ?></div>
                                            </div>
                                        </td>
                                        
                                        <!-- Topic / Metadata -->
                                        <td class="px-6 py-4">
                                            <div class="text-gray-300"><?= htmlspecialchars(explode('•', $art['meta'])[0] ?? 'Insight'); ?></div>
                                            <div class="text-gray-500 font-light text-[10px]"><?= htmlspecialchars(trim(explode('•', $art['meta'])[1] ?? 'Recent')); ?></div>
                                        </td>

                                        <!-- Author -->
                                        <td class="px-6 py-4">
                                            <div class="text-white"><?= htmlspecialchars($art['author']); ?></div>
                                            <div class="text-gray-500 font-light text-[10px]"><?= htmlspecialchars($art['author_role']); ?></div>
                                        </td>

                                        <!-- View action -->
                                        <td class="px-6 py-4 text-center">
                                            <a href="<?= BASE_URL; ?>/article/<?= urlencode($art['slug']); ?>/" target="_blank" class="text-gold hover:text-white underline transition-colors">
                                                Read
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic font-light">
                                        No editorial insights found in database.
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
