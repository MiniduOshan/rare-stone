<?php
$headline = !empty($article['title']) ? $article['title'] : 'Private Client Concierge';
$subtitleText = !empty($article['subtitle']) ? $article['subtitle'] : 'Connect directly with our senior gemologists and private client advisors through your preferred secure communication channel.';
$contacts = is_array($contacts ?? null) ? $contacts : [];

$whatsapp = $contacts['whatsapp'] ?? '+94 77 123 4567';
$whatsappSecondary = $contacts['whatsapp_secondary'] ?? '+94 71 411 8474';
$phone = $contacts['phone'] ?? '+94 11 234 5678';
$email = $contacts['email'] ?? 'concierge@rarestones.lk';
$instagram = $contacts['instagram'] ?? 'rarestones.ceylon';
$facebook = $contacts['facebook'] ?? 'Rare Stones Ceylon';

$waLink = preg_replace('/[^0-9]/', '', $whatsapp);
$waSecondaryLink = preg_replace('/[^0-9]/', '', $whatsappSecondary);
$phoneLink = preg_replace('/[^0-9+]/', '', $phone);
?>

<section class="pt-32 pb-16 px-8 md:px-16 max-w-7xl mx-auto relative z-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        <div class="lg:col-span-5 space-y-6">
            <span class="text-[10px] tracking-[0.3em] uppercase font-semibold text-gold">Private Client Concierge</span>
            <h1 class="font-serif text-5xl md:text-6xl text-white font-light leading-tight tracking-tight">
                <?= htmlspecialchars($headline); ?>
            </h1>
            <p class="text-sm md:text-base text-gray-400 font-light leading-relaxed max-w-xl">
                <?= htmlspecialchars($subtitleText); ?>
            </p>
            <div class="pt-4">
                <a href="<?= BASE_URL; ?>/discover/" class="inline-flex items-center space-x-2 text-xs uppercase tracking-[0.2em] font-medium text-white border-b-2 border-white pb-1 hover:text-gray-300 hover:border-gray-300 transition-all">
                    <span>View Network</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>

        <div class="lg:col-span-7">
            <div class="bg-surface border border-borderGray rounded-3xl p-6 md:p-8 shadow-2xl space-y-4">
                <a href="https://wa.me/<?= htmlspecialchars($waLink); ?>" target="_blank" class="flex items-center justify-between p-4 bg-dark border border-gray-800 rounded-2xl hover:border-[#25D366] transition-all group block">
                    <div>
                        <div class="text-xs uppercase tracking-widest text-gray-400 font-medium group-hover:text-white transition-colors">WhatsApp Concierge</div>
                        <div class="text-sm font-light text-gray-200 mt-1"><?= htmlspecialchars($whatsapp); ?></div>
                    </div>
                    <span class="text-[10px] bg-[#25D366]/20 text-[#25D366] border border-[#25D366]/40 px-2.5 py-1 rounded-full uppercase tracking-wider font-medium">VIP 24/7</span>
                </a>

                <a href="https://wa.me/<?= htmlspecialchars($waSecondaryLink); ?>" target="_blank" class="flex items-center justify-between p-4 bg-dark border border-gray-800 rounded-2xl hover:border-[#25D366] transition-all group block">
                    <div>
                        <div class="text-xs uppercase tracking-widest text-gray-400 font-medium group-hover:text-white transition-colors">WhatsApp Concierge 2</div>
                        <div class="text-sm font-light text-gray-200 mt-1"><?= htmlspecialchars($whatsappSecondary); ?></div>
                    </div>
                    <span class="text-[10px] bg-[#25D366]/20 text-[#25D366] border border-[#25D366]/40 px-2.5 py-1 rounded-full uppercase tracking-wider font-medium">VIP 24/7</span>
                </a>

                <a href="tel:<?= htmlspecialchars($phoneLink); ?>" class="flex items-center justify-between p-4 bg-dark border border-gray-800 rounded-2xl hover:border-gold transition-all group block">
                    <div>
                        <div class="text-xs uppercase tracking-widest text-gray-400 font-medium group-hover:text-white transition-colors">Direct Phone Line</div>
                        <div class="text-sm font-light text-gray-200 mt-1"><?= htmlspecialchars($phone); ?></div>
                    </div>
                    <span class="text-[10px] text-gray-500 uppercase tracking-widest">Direct Line</span>
                </a>

                <a href="mailto:<?= htmlspecialchars($email); ?>" class="flex items-center justify-between p-4 bg-dark border border-gray-800 rounded-2xl hover:border-white transition-all group block">
                    <div>
                        <div class="text-xs uppercase tracking-widest text-gray-400 font-medium group-hover:text-white transition-colors">Secure Email Advisory</div>
                        <div class="text-sm font-light text-gray-200 mt-1"><?= htmlspecialchars($email); ?></div>
                    </div>
                    <span class="text-[10px] text-gray-500 uppercase tracking-widest">Encrypted</span>
                </a>

                <a href="https://instagram.com/<?= htmlspecialchars($instagram); ?>" target="_blank" class="flex items-center justify-between p-4 bg-dark border border-gray-800 rounded-2xl hover:border-[#E1306C] transition-all group block">
                    <div>
                        <div class="text-xs uppercase tracking-widest text-gray-400 font-medium group-hover:text-white transition-colors">Instagram Previews</div>
                        <div class="text-sm font-light text-gray-200 mt-1">@<?= htmlspecialchars($instagram); ?></div>
                    </div>
                    <span class="text-[10px] text-gray-500 uppercase tracking-widest">Daily Catalog</span>
                </a>

                <a href="https://facebook.com/<?= htmlspecialchars($facebook); ?>" target="_blank" class="flex items-center justify-between p-4 bg-dark border border-gray-800 rounded-2xl hover:border-[#1877F2] transition-all group block">
                    <div>
                        <div class="text-xs uppercase tracking-widest text-gray-400 font-medium group-hover:text-white transition-colors">Facebook Official Page</div>
                        <div class="text-sm font-light text-gray-200 mt-1"><?= htmlspecialchars($facebook); ?></div>
                    </div>
                    <span class="text-[10px] text-gray-500 uppercase tracking-widest">Community</span>
                </a>
            </div>
        </div>
    </div>
</section>