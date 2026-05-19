<!-- CLIENT REGISTRATION PORTAL -->
<section class="relative min-h-screen flex items-center justify-center pt-28 pb-20 px-8 overflow-hidden bg-dark">
    <!-- Ambient Background Effects -->
    <div class="absolute inset-0 z-0 flex items-center justify-center pointer-events-none">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute top-1/4 left-1/4 w-[300px] h-[300px] bg-gold/5 blur-[100px] rounded-full"></div>
    </div>

    <!-- Registration Container -->
    <div class="relative z-10 max-w-md w-full bg-surface border border-borderGray p-8 md:p-12 rounded-3xl shadow-2xl transition-all font-sans text-left">
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-full border border-gray-600 flex items-center justify-center text-white mx-auto mb-4 bg-dark shadow-xl">
                <i data-lucide="user-plus" class="w-5 h-5 text-gold"></i>
            </div>
            <h1 class="font-serif text-3xl md:text-4xl text-white mb-2 italic">Client Circle</h1>
            <p class="text-xs text-gray-400 font-light tracking-wider uppercase">Request inclusion in our private database</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="p-4 mb-6 bg-red-950/30 border border-red-800/50 rounded-xl text-xs text-red-400 flex items-center space-x-2">
                <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0 text-red-500"></i>
                <span><?= htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <!-- Registration Form -->
        <form action="<?= BASE_URL; ?>/index.php?route=register" method="POST" class="space-y-6">
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2 font-medium">Full Name</label>
                <input type="text" name="name" required placeholder="Lord Julian Alistair" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-gray-500 font-light transition-colors">
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2 font-medium">Secure Email Address</label>
                <input type="email" name="email" required placeholder="name@client.com" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-gray-500 font-light transition-colors">
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2 font-medium">Choose Access Key (Password)</label>
                <input type="password" name="password" required placeholder="Minimally 6 characters" minlength="6" class="w-full bg-dark border border-gray-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-gray-500 font-light transition-colors">
            </div>

            <button type="submit" class="w-full bg-white text-black font-semibold tracking-[0.2em] text-xs uppercase py-4 rounded-full hover:bg-gray-200 transition-all shadow-lg hover:shadow-white/10">
                Submit Request
            </button>
        </form>

        <div class="mt-8 text-center text-xs text-gray-500 font-light tracking-wide">
            Already registered with a private key? <br class="hidden sm:inline">
            <a href="<?= BASE_URL; ?>/index.php?route=login" class="text-gold hover:text-white underline transition-colors font-medium mt-1 inline-block">Secure Client Entrance</a>
        </div>
    </div>
</section>
