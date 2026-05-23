<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Edit Contact Details | Rare Stones Admin'; ?></title>
    
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
                <h1 class="font-serif text-3xl md:text-4xl text-white font-light">Contact <span class="italic text-gold">Details</span></h1>
                <p class="text-xs text-gray-400 mt-1 font-light">Manage the phone numbers and links displayed in the Concierge directory.</p>
            </div>
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

        <!-- Configuration Form -->
        <section class="bg-surface border border-borderGray p-8 md:p-12 rounded-3xl shadow-2xl relative overflow-hidden max-w-4xl mx-auto">
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-gold/5 blur-[80px] rounded-full pointer-events-none z-0"></div>

            <h2 class="font-serif text-3xl text-white font-light mb-8 flex items-center space-x-3 border-b border-gray-800 pb-4 relative z-10">
                <i data-lucide="phone-call" class="w-6 h-6 text-gold"></i>
                <span>Concierge Contact Info</span>
            </h2>

            <?php 
                $contacts = json_decode($article['content'], true) ?? [];
                $whatsapp = $contacts['whatsapp'] ?? '';
                $phone = $contacts['phone'] ?? '';
                $email = $contacts['email'] ?? '';
                $instagram = $contacts['instagram'] ?? '';
                $facebook = $contacts['facebook'] ?? '';
            ?>

            <form action="<?= BASE_URL; ?>/admin/contact/" method="POST" class="space-y-6 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium flex items-center space-x-2"><i data-lucide="message-circle" class="w-3 h-3 text-[#25D366]"></i> <span>WhatsApp Number</span></label>
                        <input type="text" name="whatsapp" value="<?= htmlspecialchars($whatsapp); ?>" placeholder="+94 77 123 4567" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium flex items-center space-x-2"><i data-lucide="phone" class="w-3 h-3 text-gold"></i> <span>Direct Phone Line</span></label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($phone); ?>" placeholder="+94 11 234 5678" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium flex items-center space-x-2"><i data-lucide="mail" class="w-3 h-3 text-white"></i> <span>Secure Email</span></label>
                        <input type="email" name="email" value="<?= htmlspecialchars($email); ?>" placeholder="concierge@rarestones.lk" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium flex items-center space-x-2"><i data-lucide="instagram" class="w-3 h-3 text-[#E1306C]"></i> <span>Instagram Handle</span></label>
                        <input type="text" name="instagram" value="<?= htmlspecialchars($instagram); ?>" placeholder="rarestones.ceylon" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-medium flex items-center space-x-2"><i data-lucide="facebook" class="w-3 h-3 text-[#1877F2]"></i> <span>Facebook Page Name</span></label>
                    <input type="text" name="facebook" value="<?= htmlspecialchars($facebook); ?>" placeholder="Rare Stones Ceylon" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-gray-500 font-light transition-colors">
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="w-full md:w-auto px-8 py-4 bg-white text-black font-semibold tracking-[0.2em] text-xs uppercase rounded-full hover:bg-gray-200 transition-all shadow-lg hover:shadow-white/10 flex items-center justify-center space-x-2">
                        <i data-lucide="save" class="w-3.5 h-3.5"></i>
                        <span>Save Contact Config</span>
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
