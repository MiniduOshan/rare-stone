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
function openModal(modalId, subtitleText = null) {
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

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        
        const respDiv = document.getElementById('inquiryResponse');
        if (respDiv) respDiv.classList.add('hidden');
    }
}

let currentSelectedGem = null;

function openGemModal(gem) {
    currentSelectedGem = gem;
    document.getElementById('modalGemImg').src = `${BASE_URL}/public/images/${gem.image}`;
    document.getElementById('modalGemStatus').textContent = gem.status;
    document.getElementById('modalGemTitle').textContent = gem.title;
    document.getElementById('modalGemSubtitle').textContent = `${gem.origin} - ${gem.carats} | ${gem.cut}`;
    document.getElementById('modalGemDesc').textContent = gem.description;
    
    openModal('gemModal');
}

function initiateGemInquiry() {
    closeModal('gemModal');
    if (currentSelectedGem) {
        document.getElementById('stone_id').value = currentSelectedGem.id;
        openModal('inquiryModal', `Inquiring about: ${currentSelectedGem.title} (${currentSelectedGem.carats}, ${currentSelectedGem.origin})`);
    } else {
        openModal('inquiryModal');
    }
}

function toggleAllGems(e) {
    e.preventDefault();
    const grid = document.getElementById('expanded-grid');
    const btn = document.getElementById('viewAllBtn');
    
    if (grid.classList.contains('hidden')) {
        grid.classList.remove('hidden');
        btn.innerHTML = `<span>Show Less</span> <i data-lucide="arrow-up" class="w-3.5 h-3.5 inline-block"></i>`;
        lucide.createIcons();
    } else {
        grid.classList.add('hidden');
        btn.innerHTML = `<span>View All</span> <i data-lucide="arrow-right" class="w-3.5 h-3.5 inline-block"></i>`;
        lucide.createIcons();
        document.getElementById('acquisitions').scrollIntoView({ behavior: 'smooth' });
    }
}
