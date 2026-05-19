<!-- CLIENT ENTRY PORTAL -->
<section class="relative min-h-screen flex items-center justify-center pt-28 pb-20 px-8 overflow-hidden bg-dark">
    <!-- Ambient Background Effects -->
    <div class="absolute inset-0 z-0 flex items-center justify-center pointer-events-none">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute top-1/4 left-1/4 w-[300px] h-[300px] bg-gold/5 blur-[100px] rounded-full"></div>
    </div>

    <!-- Login Container -->
    <div class="relative z-10 max-w-md w-full bg-surface border border-borderGray p-8 md:p-12 rounded-3xl shadow-2xl transition-all font-sans text-left">
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-full border border-gray-600 flex items-center justify-center text-white mx-auto mb-4 bg-dark shadow-xl">
                <i data-lucide="lock" class="w-5 h-5 text-gold"></i>
            </div>
            <h1 class="font-serif text-3xl md:text-4xl text-white mb-2 italic">Client Portal</h1>
            <p class="text-xs text-gray-400 font-light tracking-wider uppercase">Enter your secure client credentials</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="p-4 mb-6 bg-red-950/30 border border-red-800/50 rounded-xl text-xs text-red-400 flex items-center space-x-2">
                <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0 text-red-500"></i>
                <span><?= htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <!-- Standard Login Form -->
        <form action="<?= BASE_URL; ?>/login/" method="POST" class="space-y-6">
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2 font-medium">Client ID / Email</label>
                <input type="email" name="email" required placeholder="name@client.com" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-gray-500 font-light transition-colors">
            </div>
            <div>
                <div class="flex justify-between items-baseline mb-2">
                    <label class="block text-xs uppercase tracking-widest text-gray-400 font-medium">Private Access Key</label>
                </div>
                <div class="relative">
                    <input type="password" id="login-password" name="password" required placeholder="••••••••••••" class="w-full bg-dark border border-gray-800 rounded-xl pl-4 pr-12 py-3 text-white text-sm focus:outline-none focus:border-gray-500 font-light transition-colors">
                    <button type="button" onclick="togglePasswordVisibility('login-password', 'eye-icon-login')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-white transition-colors">
                        <i data-lucide="eye" id="eye-icon-login" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-white text-black font-semibold tracking-[0.2em] text-xs uppercase py-4 rounded-full hover:bg-gray-200 transition-all shadow-lg hover:shadow-white/10">
                Secure Entry
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-8 flex items-center justify-center">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-800"></div></div>
            <span class="relative bg-surface px-4 text-[10px] uppercase tracking-widest text-gray-500">Or</span>
        </div>

        <!-- Guest Session Action Form -->
        <form action="<?= BASE_URL; ?>/login/" method="POST">
            <input type="hidden" name="action" value="guest">
            <button type="submit" class="w-full py-4 border border-gray-800 rounded-full text-xs text-gray-300 font-medium tracking-[0.2em] uppercase hover:border-gray-500 hover:text-white transition-all">
                Browse as Guest
            </button>
        </form>

        <div class="mt-8 text-center text-xs text-gray-500 font-light tracking-wide">
            Not a member of our exclusive list? <br class="hidden sm:inline">
            <a href="<?= BASE_URL; ?>/register/" class="text-gold hover:text-white underline transition-colors font-medium mt-1 inline-block">Apply for Client Circle</a>
        </div>
    </div>
</section>
