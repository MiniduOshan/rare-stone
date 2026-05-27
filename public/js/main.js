document.addEventListener('DOMContentLoaded', () => {
    // Initialize Lucide Icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Navbar Scroll Effect
    const navbar = document.getElementById('navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
    }

    // Newsletter Submission
    const newsletterForm = document.getElementById('newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(newsletterForm);
            const msgDiv = document.getElementById('newsletter-message');

            try {
                const response = await fetch(`${BASE_URL}/index.php?route=newsletter`, {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                msgDiv.textContent = result.message;
                msgDiv.classList.remove('hidden', 'text-red-400', 'text-emerald-400');
                msgDiv.classList.add(result.status === 'success' ? 'text-emerald-400' : 'text-red-400');
                
                if (result.status === 'success') {
                    newsletterForm.reset();
                }
            } catch (err) {
                console.error(err);
            }
        });
    }

    // Inquiry Form Submission
    const inquiryForm = document.getElementById('inquiryForm');
    if (inquiryForm) {
        inquiryForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(inquiryForm);
            const respDiv = document.getElementById('inquiryResponse');

            try {
                const response = await fetch(`${BASE_URL}/index.php?route=inquire`, {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                respDiv.textContent = result.message;
                respDiv.classList.remove('hidden');
                inquiryForm.reset();
            } catch (err) {
                console.error(err);
            }
        });
    }
});

// Modal Controls
window.openModal = function(modalId, subtitleText = null) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        if (subtitleText && modalId === 'inquiryModal') {
            const sub = document.getElementById('inquiryModalSubtitle');
            if (sub) sub.textContent = subtitleText;
        }
    }
}

window.closeModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        
        const respDiv = document.getElementById('inquiryResponse');
        if (respDiv) respDiv.classList.add('hidden');
    }
}

window.toggleAllGems = function(e) {
    e.preventDefault();
    const grid = document.getElementById('expanded-grid');
    const btn = document.getElementById('viewAllBtn');
    
    if (grid && grid.classList.contains('hidden')) {
        grid.classList.remove('hidden');
        if (btn) btn.innerHTML = `<span>Show Less</span> <i data-lucide="arrow-up" class="w-3.5 h-3.5 inline-block"></i>`;
        if (window.lucide) lucide.createIcons();
    } else {
        if (grid) grid.classList.add('hidden');
        if (btn) btn.innerHTML = `<span>View All</span> <i data-lucide="arrow-right" class="w-3.5 h-3.5 inline-block"></i>`;
        if (window.lucide) lucide.createIcons();
        const acq = document.getElementById('acquisitions');
        if (acq) acq.scrollIntoView({ behavior: 'smooth' });
    }
}

// Mobile Menu Controls
window.toggleMobileMenu = function() {
    const menu = document.getElementById('mobile-menu');
    const openIcon = document.getElementById('menu-icon-open');
    const closeIcon = document.getElementById('menu-icon-close');
    
    if (menu) {
        const isOpen = !menu.classList.contains('translate-x-full');
        if (isOpen) {
            window.closeMobileMenu();
        } else {
            menu.classList.remove('translate-x-full');
            if (openIcon) openIcon.classList.add('hidden');
            if (closeIcon) closeIcon.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }
}

window.closeMobileMenu = function() {
    const menu = document.getElementById('mobile-menu');
    const openIcon = document.getElementById('menu-icon-open');
    const closeIcon = document.getElementById('menu-icon-close');
    
    if (menu) {
        menu.classList.add('translate-x-full');
        if (openIcon) openIcon.classList.remove('hidden');
        if (closeIcon) closeIcon.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

// Password Visibility Toggle
window.togglePasswordVisibility = function(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input && icon) {
        if (input.type === 'password') {
            input.type = 'text';
            icon.setAttribute('data-lucide', 'eye-off');
        } else {
            input.type = 'password';
            icon.setAttribute('data-lucide', 'eye');
        }
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }
}
