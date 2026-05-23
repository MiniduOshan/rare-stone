<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Edit Brand Heritage | Rare Stones Admin'; ?></title>
    
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
                <h1 class="font-serif text-3xl md:text-4xl text-white font-light">Brand <span class="italic text-gold">Heritage</span></h1>
                <p class="text-xs text-gray-400 mt-1 font-light">Customize the brand philosophy, primary network definitions, and historical quotes shown on the heritage page.</p>
            </div>
            
            <a href="<?= BASE_URL; ?>/index.php?route=heritage" target="_blank" class="px-4 py-2 bg-white/5 border border-borderGray rounded-xl text-xs text-gray-300 hover:text-white hover:bg-white/10 transition-all flex items-center space-x-1.5 font-light">
                <i data-lucide="eye" class="w-4 h-4 text-gold"></i>
                <span>View Public Heritage Page</span>
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

        <!-- Heritage Configuration Form -->
        <section class="bg-surface border border-borderGray p-8 md:p-12 rounded-3xl shadow-2xl relative overflow-hidden max-w-4xl mx-auto">
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-gold/5 blur-[80px] rounded-full pointer-events-none z-0"></div>

            <h2 class="font-serif text-3xl text-white font-light mb-8 flex items-center space-x-3 border-b border-gray-800 pb-4 relative z-10">
                <i data-lucide="edit-3" class="w-6 h-6 text-gold"></i>
                <span>Modify Brand Dossier</span>
            </h2>

            <form action="<?= BASE_URL; ?>/index.php?route=admin_heritage" method="POST" class="space-y-6 relative z-10">
                <!-- Title & Subtitle Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Network Headline Title</label>
                        <input type="text" name="title" value="<?= htmlspecialchars($article['title']); ?>" placeholder="e.g. The Private Network" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Hero Subtitle</label>
                        <input type="text" name="subtitle" value="<?= htmlspecialchars($article['subtitle']); ?>" placeholder="e.g. Founded on the principles of trust, discretion..." class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                    </div>
                </div>

                <!-- Image and Philosophy Quote Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Hero Image URL or Local Filename</label>
                        <input type="text" name="image" value="<?= htmlspecialchars($article['image']); ?>" placeholder="e.g. heritage-earrings.jpg" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Philosophy Statement / Quote</label>
                        <input type="text" name="quote" value="<?= htmlspecialchars($article['author']); ?>" placeholder="e.g. True luxury is found in absolute rarity..." class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                    </div>
                </div>

                <!-- Editorial Content Body -->
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium">Heritage Detailed Narrative Content (HTML Supported)</label>
                    <textarea name="content" rows="10" placeholder="Narrate the historic philosophies of the vault..." class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors resize-none h-64"><?= htmlspecialchars($article['content']); ?></textarea>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="w-full md:w-auto px-8 py-4 bg-white text-black font-semibold tracking-[0.2em] text-xs uppercase rounded-full hover:bg-gray-200 transition-all shadow-lg hover:shadow-white/10 flex items-center justify-center space-x-2">
                        <i data-lucide="save" class="w-3.5 h-3.5"></i>
                        <span>Save Brand Narrative</span>
                    </button>
                </div>
            </form>
        </section>

    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>