<?php
// Admin Sidebar Component
$activeTab = $activeTab ?? 'feedbacks';
?>
<!-- Sidebar Navigation -->
<aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-surface border-r border-borderGray flex flex-col justify-between h-screen transform -translate-x-full transition-transform duration-300 ease-in-out md:sticky md:top-0 md:translate-x-0 md:flex md:flex-shrink-0 font-sans">
    
    <!-- Top Brand Area -->
    <div class="p-6 border-b border-borderGray">
        <div class="flex items-center justify-between">
            <a href="<?= BASE_URL; ?>/" class="flex items-center space-x-3 group">
                <img src="<?= BASE_URL; ?>/public/images/logo-mark.png" alt="Rare Stones" class="h-10 w-10 object-contain shrink-0">
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

        <div class="text-[9px] uppercase tracking-widest text-gray-500 font-semibold px-3 mt-6 mb-3">System Tools</div>

        <!-- Backup -->
        <a href="javascript:void(0)" id="nav-backup" onclick="initiateBackup()"
           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all text-xs tracking-wider uppercase text-gray-400 hover:bg-white/5 hover:text-white border border-transparent group">
            <i data-lucide="hard-drive-download" class="w-4 h-4"></i>
            <span id="backup-label">Backup</span>
            <div id="backup-spinner" class="hidden ml-auto">
                <svg class="animate-spin h-4 w-4 text-gold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </div>
        </a>
    </nav>

    <!-- Bottom Actions Area -->
    <div class="p-4 border-t border-borderGray bg-dark/40 space-y-2">
        <a href="<?= BASE_URL; ?>/" target="_blank" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-xs text-gray-400 hover:text-white hover:bg-white/5 transition-all uppercase tracking-wider">
            <i data-lucide="external-link" class="w-4 h-4"></i>
            <span>View Home</span>
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

        <a href="<?= BASE_URL; ?>/logout/" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-xs text-red-400 hover:bg-red-950/20 transition-all uppercase tracking-wider">
            <i data-lucide="log-out" class="w-4 h-4"></i>
            <span>Logout Portal</span>
        </a>
    </div>

<!-- Backup Confirmation Modal -->
<div id="backup-confirm-modal" style="display:none" class="fixed inset-0 z-[9999] bg-black/70 backdrop-blur-sm flex items-center justify-center" onclick="if(event.target===this)closeBackupModal()">
    <div class="bg-[#111115] border border-[rgba(255,255,255,0.12)] rounded-2xl shadow-2xl max-w-[420px] w-full mx-4 overflow-hidden animate-[modalSlideIn_0.25s_ease-out]">

        <!-- Header -->
        <div class="px-6 pt-6 pb-4 flex items-start justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-[#d4af37]/15 border border-[#d4af37]/30 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="hard-drive-download" class="w-5 h-5 text-[#d4af37]"></i>
                </div>
                <div>
                    <h3 class="font-serif text-lg text-white font-light leading-tight">Project Backup</h3>
                    <p class="text-[10px] text-gray-500 font-light mt-0.5">Full system archive</p>
                </div>
            </div>
            <button onclick="closeBackupModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:text-white hover:bg-white/10 transition-all -mr-1 -mt-1">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="px-6 pb-5">
            <!-- Warning banner -->
            <?php
                $backupTimestamps = isset($_SESSION['backup_timestamps']) ? $_SESSION['backup_timestamps'] : [];
                $backupTimestamps = array_filter($backupTimestamps, function($ts) { return (time() - $ts) < 86400; });
                $attemptsUsed = count($backupTimestamps);
                $attemptsLeft = max(0, 2 - $attemptsUsed);
            ?>
            <div class="bg-amber-950/25 border border-amber-800/30 rounded-lg px-3.5 py-2.5 mb-4 flex items-start space-x-2.5">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5"></i>
                <div>
                    <p class="text-[11px] text-amber-400/90 font-light leading-relaxed">This may take a moment and will use server resources.</p>
                    <p class="text-[10px] text-gray-500 font-light mt-1">Daily limit: <span class="text-white font-medium"><?= $attemptsLeft ?></span> of 2 backups remaining</p>
                </div>
            </div>

            <!-- Included items -->
            <p class="text-[10px] uppercase tracking-widest text-gray-500 font-medium mb-2.5">Backup includes</p>
            <div class="space-y-0">
                <div class="flex items-center space-x-2.5 py-2 border-b border-white/5">
                    <i data-lucide="database" class="w-3.5 h-3.5 text-[#d4af37] flex-shrink-0"></i>
                    <span class="text-xs text-gray-300 font-light">MySQL database export</span>
                    <span class="ml-auto text-[10px] text-gray-600">.sql</span>
                </div>
                <div class="flex items-center space-x-2.5 py-2 border-b border-white/5">
                    <i data-lucide="image" class="w-3.5 h-3.5 text-[#d4af37] flex-shrink-0"></i>
                    <span class="text-xs text-gray-300 font-light">Uploaded images</span>
                    <span class="ml-auto text-[10px] text-gray-600">public/images/</span>
                </div>
                <div class="flex items-center space-x-2.5 py-2">
                    <i data-lucide="folder" class="w-3.5 h-3.5 text-[#d4af37] flex-shrink-0"></i>
                    <span class="text-xs text-gray-300 font-light">All project source files</span>
                    <span class="ml-auto text-[10px] text-gray-600">configs, views, assets</span>
                </div>
            </div>
        </div>

        <!-- Footer buttons -->
        <div class="px-6 py-3.5 bg-black/30 border-t border-white/5 flex items-center justify-end space-x-2">
            <button onclick="closeBackupModal()" class="px-4 py-1.5 bg-transparent border border-gray-700 text-gray-400 hover:text-white hover:border-gray-500 rounded-md text-[11px] font-medium tracking-wide transition-all">
                Cancel
            </button>
            <button id="backup-confirm-btn" onclick="startBackupDownload()" class="px-4 py-1.5 bg-white text-black font-semibold tracking-wide text-[11px] rounded-md hover:bg-gray-200 transition-all flex items-center space-x-1.5">
                <i data-lucide="download" class="w-3 h-3"></i>
                <span>Download</span>
            </button>
        </div>
    </div>
</div>

<!-- Backup Progress Overlay -->
<div id="backup-overlay" style="display:none" class="fixed inset-0 z-[10000] bg-black/70 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-[#111115] border border-[rgba(255,255,255,0.12)] rounded-2xl p-8 text-center shadow-2xl max-w-xs mx-4">
        <div class="mb-5">
            <svg class="animate-spin h-10 w-10 text-[#d4af37] mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
        </div>
        <h3 class="font-serif text-lg text-white font-light mb-1.5">Generating Backup</h3>
        <p class="text-[11px] text-gray-500 font-light leading-relaxed">Exporting database & compressing files…<br>Please wait.</p>
    </div>
</div>

<style>
    @keyframes modalSlideIn {
        from { opacity: 0; transform: translateY(12px) scale(0.97); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
</style>

<script>
    function initiateBackup() {
        document.getElementById('backup-confirm-modal').style.display = 'flex';
        if (window.lucide) lucide.createIcons();
    }

    function closeBackupModal() {
        document.getElementById('backup-confirm-modal').style.display = 'none';
    }

    function startBackupDownload() {
        closeBackupModal();

        const overlay = document.getElementById('backup-overlay');
        const spinner = document.getElementById('backup-spinner');
        const label = document.getElementById('backup-label');

        overlay.style.display = 'flex';
        if (spinner) spinner.classList.remove('hidden');
        if (label) label.textContent = 'Generating...';

        const iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = '<?= BASE_URL; ?>/?route=admin_backup';
        document.body.appendChild(iframe);

        let checkCount = 0;
        const maxChecks = 120;
        const pollInterval = setInterval(() => {
            checkCount++;
            try {
                const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                if (iframeDoc && iframeDoc.body && iframeDoc.body.innerHTML.length > 0) {
                    clearInterval(pollInterval);
                    hideBackupLoading();
                    if (iframeDoc.body.innerHTML.includes('admin')) {
                        showBackupMessage('error', 'Backup generation failed. Check server logs.');
                    }
                    document.body.removeChild(iframe);
                    return;
                }
            } catch (e) {}

            if (checkCount >= maxChecks) {
                clearInterval(pollInterval);
                hideBackupLoading();
                document.body.removeChild(iframe);
            }
        }, 1000);

        setTimeout(() => {
            hideBackupLoading();
            showBackupMessage('success', 'Backup download initiated successfully.');
        }, 5000);
    }

    function hideBackupLoading() {
        document.getElementById('backup-overlay').style.display = 'none';
        const spinner = document.getElementById('backup-spinner');
        const label = document.getElementById('backup-label');
        if (spinner) spinner.classList.add('hidden');
        if (label) label.textContent = 'Backup';
    }

    function showBackupMessage(type, message) {
        const main = document.querySelector('main');
        if (!main) return;

        const isSuccess = type === 'success';
        const alertDiv = document.createElement('div');
        alertDiv.className = isSuccess
            ? 'p-4 mb-6 bg-emerald-950/30 border border-emerald-800/50 rounded-xl text-xs text-emerald-400 flex items-center space-x-2 relative z-50'
            : 'p-4 mb-6 bg-red-950/30 border border-red-800/50 rounded-xl text-xs text-red-400 flex items-center space-x-2 relative z-50';

        alertDiv.innerHTML = `
            <i data-lucide="${isSuccess ? 'check-circle' : 'alert-circle'}" class="w-4 h-4 flex-shrink-0 ${isSuccess ? 'text-emerald-500' : 'text-red-500'}"></i>
            <span>${message}</span>
        `;

        main.insertBefore(alertDiv, main.firstChild);
        if (window.lucide) lucide.createIcons();

        setTimeout(() => {
            alertDiv.style.transition = 'opacity 0.5s ease';
            alertDiv.style.opacity = '0';
            setTimeout(() => alertDiv.remove(), 500);
        }, 6000);
    }
</script>

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
