<!-- EDITORIAL HEADER SECTION -->
<section class="pt-40 pb-16 px-8 md:px-16 max-w-7xl mx-auto relative z-20 border-b border-borderGray mb-16">
    <div class="max-w-3xl space-y-4">
        <h1 class="font-serif text-5xl md:text-7xl text-white font-light tracking-tight leading-tight">
            Editorial & <span class="italic text-gradient">Insight</span>
        </h1>
        <p class="text-sm md:text-base text-gray-400 font-light leading-relaxed max-w-xl tracking-wide">
            Market analysis, authentic origin reporting, and private collecting strategies for high-net-worth individuals.
        </p>
    </div>
</section>

<!-- MAIN EDITORIAL GRID -->
<section class="pb-32 px-8 md:px-16 max-w-7xl mx-auto relative z-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-16">
        
        <!-- Left Column: Featured Main Article -->
        <div class="lg:col-span-7 space-y-6 lg:border-r lg:border-borderGray lg:pr-16">
            <div class="relative aspect-[16/10] bg-surface rounded-2xl overflow-hidden border border-borderGray shadow-2xl group cursor-pointer" onclick="openArticleModal('padparadscha')">
                <div class="absolute inset-0 bg-gradient-to-t from-dark/80 via-transparent to-transparent z-10 opacity-60 group-hover:opacity-40 transition-opacity"></div>
                <img src="<?= BASE_URL; ?>/public/images/heritage-hero.jpg" alt="Balcony view" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 z-0">
            </div>

            <div class="flex items-center space-x-3 text-[10px] tracking-[0.2em] uppercase font-medium">
                <span class="text-gold">Market Insight</span>
                <span class="text-gray-600">•</span>
                <span class="text-gray-500 flex items-center space-x-1">
                    <i data-lucide="clock" class="w-3 h-3"></i>
                    <span>May 2, 2026</span>
                </span>
            </div>

            <h2 class="font-serif text-3xl md:text-4xl text-white font-light leading-tight hover:text-gray-200 transition-colors cursor-pointer" onclick="openArticleModal('padparadscha')">
                Sri Lanka Padparadscha Market Hits New High
            </h2>

            <p class="text-sm text-gray-400 font-light leading-relaxed tracking-wide">
                Demand for rare Sri Lankan padparadscha sapphires is surging among collectors seeking luminous pink-orange stones with certified provenance.
            </p>

            <div class="pt-2">
                <button onclick="openArticleModal('padparadscha')" class="inline-flex items-center space-x-2 text-xs uppercase tracking-[0.2em] font-medium text-white border-b-2 border-white pb-1 group hover:text-gray-300 hover:border-gray-300 transition-all">
                    <span>Read Analysis</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>
        </div>

        <!-- Right Column: Secondary Articles List -->
        <div class="lg:col-span-5 space-y-12">
            
            <!-- Article 1 -->
            <div class="flex flex-col sm:flex-row items-start space-y-4 sm:space-y-0 sm:space-x-6 group cursor-pointer border-b border-borderGray/50 pb-8 last:border-0" onclick="openArticleModal('mining')">
                <div class="relative w-full sm:w-36 h-36 aspect-square bg-surface rounded-xl overflow-hidden flex-shrink-0 border border-borderGray shadow-xl">
                    <img src="<?= BASE_URL; ?>/public/images/news-bracelet.jpg" alt="Antique Rose Gold Bracelet" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                </div>

                <div class="space-y-3">
                    <div class="flex items-center space-x-2 text-[9px] tracking-[0.2em] uppercase font-medium">
                        <span class="text-gold">Origin Report</span>
                        <span class="text-gray-600">•</span>
                        <span class="text-gray-500">April 28, 2026</span>
                    </div>

                    <h3 class="font-serif text-xl text-white font-light leading-snug group-hover:text-gold transition-colors">
                        Ratnapura Mining Season: 2026 Quality Outlook
                    </h3>

                    <div class="inline-flex items-center space-x-1 text-[11px] uppercase tracking-[0.2em] font-medium text-gray-400 group-hover:text-white transition-colors">
                        <span>Read</span>
                        <i data-lucide="arrow-right" class="w-3 h-3 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </div>

            <!-- Article 2 -->
            <div class="flex flex-col sm:flex-row items-start space-y-4 sm:space-y-0 sm:space-x-6 group cursor-pointer border-b border-borderGray/50 pb-8 last:border-0" onclick="openArticleModal('trends')">
                <div class="relative w-full sm:w-36 h-36 aspect-square bg-surface rounded-xl overflow-hidden flex-shrink-0 border border-borderGray shadow-xl">
                    <img src="<?= BASE_URL; ?>/public/images/heritage-earrings.jpg" alt="Sapphire Diamond Earrings on Monstera" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                </div>

                <div class="space-y-3">
                    <div class="flex items-center space-x-2 text-[9px] tracking-[0.2em] uppercase font-medium">
                        <span class="text-gold">Authentication</span>
                        <span class="text-gray-600">•</span>
                        <span class="text-gray-500">April 15, 2026</span>
                    </div>

                    <h3 class="font-serif text-xl text-white font-light leading-snug group-hover:text-gold transition-colors">
                        Heritage Sri Lankan Jewelry Trends for Private Collectors
                    </h3>

                    <div class="inline-flex items-center space-x-1 text-[11px] uppercase tracking-[0.2em] font-medium text-gray-400 group-hover:text-white transition-colors">
                        <span>Read</span>
                        <i data-lucide="arrow-right" class="w-3 h-3 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- Article Reader Modal -->
<div id="articleModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-md modal-backdrop" onclick="closeModal('articleModal')"></div>
    <div class="relative bg-surface border border-borderGray p-8 md:p-12 rounded-2xl max-w-3xl w-full mx-4 max-h-[90vh] overflow-y-auto shadow-2xl z-10 text-left space-y-6 custom-scrollbar">
        <button onclick="closeModal('articleModal')" class="absolute top-6 right-6 text-gray-400 hover:text-white z-20">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>

        <div id="articleMeta" class="text-xs uppercase tracking-widest text-gold font-medium"></div>
        <h2 id="articleHeadline" class="font-serif text-3xl md:text-4xl text-white font-light leading-tight"></h2>
        
        <div class="border-t border-b border-gray-800 py-6 my-6 text-sm text-gray-300 font-light leading-relaxed space-y-4" id="articleBody">
        </div>

        <div class="pt-4 flex justify-between items-center">
            <button onclick="openModal('inquiryModal', 'Article Inquiry & Advisory')" class="px-8 py-3 bg-white text-black text-xs font-medium uppercase tracking-[0.2em] rounded-full hover:bg-gray-200 transition-all">
                Request Advisory on this Topic
            </button>
            <button onclick="closeModal('articleModal')" class="text-xs text-gray-400 uppercase tracking-widest hover:text-white transition-colors">
                Close Reader
            </button>
        </div>
    </div>
</div>

<script>
const articleData = {
    padparadscha: {
        meta: "Market Insight • May 2, 2026",
        title: "Sri Lanka Padparadscha Market Hits New High",
        body: `<p>Demand for rare Sri Lankan padparadscha sapphires is surging among collectors seeking luminous pink-orange stones with certified provenance. Recent private auctions in Geneva and Hong Kong have demonstrated record per-carat valuations for unheated specimens exceeding 5 carats.</p>
        <p>The term 'padparadscha' derives from the Sinhalese word for lotus blossom, representing an elusive equilibrium of sunset orange and delicate pink. With primary deposits in Ratnapura yielding fewer investment-grade rough stones each year, institutional collectors are securing heritage pieces as highly liquid tangible assets.</p>`
    },
    mining: {
        meta: "Origin Report • April 28, 2026",
        title: "Ratnapura Mining Season: 2026 Quality Outlook",
        body: `<p>The 2026 mining outlook across Ratnapura's gem-bearing gravels indicates a steady emergence of exceptional royal blue and vivid yellow sapphires. Artisanal mining cooperatives utilizing traditional zero-carbon extraction techniques have reported a remarkable lot of pristine unheated crystals.</p>
        <p>Aetheria's gemological inspection team on site has pre-vetted over forty premier specimens for inclusion in the upcoming private portfolio release.</p>`
    },
    trends: {
        meta: "Authentication • April 15, 2026",
        title: "Heritage Sri Lankan Jewelry Trends for Private Collectors",
        body: `<p>High jewelry collectors are increasingly prioritizing historical Sri Lankan craftsmanship, combining traditional filigree settings with modern precision recutting. The synthesis of antique provenance with contemporary GIA/Gübelin optical standards creates unparalleled heirloom value.</p>
        <p>Our advisory panel notes a 35% increase in private commissions for bespoke settings that highlight natural inclusions and untreated fluorescence.</p>`
    }
};

function openArticleModal(key) {
    const data = articleData[key];
    if (data) {
        document.getElementById('articleMeta').textContent = data.meta;
        document.getElementById('articleHeadline').textContent = data.title;
        document.getElementById('articleBody').innerHTML = data.body;
        openModal('articleModal');
    }
}
</script>
