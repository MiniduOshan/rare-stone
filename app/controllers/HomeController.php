<?php

require_once APP_ROOT . '/controllers/Controller.php';
require_once APP_ROOT . '/models/Gemstone.php';

class HomeController extends Controller {
    /**
     * Display the main landing page
     */
    public function index() {
        $allGemstones = Gemstone::getCuratedAcquisitions();
        $featuredGemstones = array_slice($allGemstones, 0, 3);

        $data = [
            'pageTitle' => 'Rare Stones | Rare & Exceptional Gemstones',
            'featuredGemstones' => $featuredGemstones,
            'allGemstones' => $allGemstones,
            'activeNav' => 'home'
        ];

        $this->render('home/index', $data);
    }

    /**
     * Display dedicated gemstone view page
     */
    public function gem() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 1;
        $gem = Gemstone::getById($id);

        $data = [
            'pageTitle' => htmlspecialchars($gem['title']) . ' | Rare Stones',
            'gem' => $gem,
            'activeNav' => 'gemstones'
        ];

        $this->render('home/gem', $data);
    }

    /**
     * Display the Gem Stones page
     */
    public function gemstones() {
        $allGemstones = Gemstone::getCuratedAcquisitions();

        $data = [
            'pageTitle' => 'Vault Gem Stones | Rare Stones',
            'allGemstones' => $allGemstones,
            'activeNav' => 'gemstones'
        ];

        $this->render('home/gemstones', $data);
    }

    /**
     * Display the Heritage page
     */
    public function heritage() {
        $data = [
            'pageTitle' => 'Our Heritage & Philosophy | Rare Stones',
            'activeNav' => 'heritage'
        ];

        $this->render('home/heritage', $data);
    }

    /**
     * Display the News & Editorial page
     */
    public function news() {
        $data = [
            'pageTitle' => 'Editorial & Insight | Rare Stones',
            'activeNav' => 'news'
        ];

        $this->render('home/news', $data);
    }

    /**
     * Display the Dedicated Article Reader page
     */
    public function article() {
        $articleId = isset($_GET['id']) ? trim($_GET['id']) : 'padparadscha';

        $articles = [
            'padparadscha' => [
                'meta' => 'Market Insight • May 2, 2026 • 5 min read',
                'title' => 'Sri Lanka Padparadscha Market Hits New High',
                'subtitle' => 'Demand for rare Sri Lankan padparadscha sapphires is surging among collectors seeking luminous pink-orange stones with certified provenance.',
                'image' => 'heritage-hero.jpg',
                'author' => 'Dr. Aris Thorne',
                'author_role' => 'Senior Gemologist & Valuations Director',
                'content' => '
                    <p class="lead text-xl text-gray-200 font-light leading-relaxed mb-6">Recent private auctions in Geneva and Hong Kong have demonstrated record per-carat valuations for unheated specimens exceeding 5 carats, cementing the Padparadscha sapphire as one of the most highly sought-after tangible assets of the decade.</p>
                    <p class="mb-6">The term \'padparadscha\' derives from the Sinhalese word for lotus blossom, representing an elusive equilibrium of sunset orange and delicate pink. Unlike standard blue sapphires, true unheated padparadschas exhibit a mesmerizing internal glow that shifts dynamically between incandescent and natural daylight.</p>
                    <blockquote class="border-l-2 border-gold pl-6 py-2 my-8 italic text-2xl font-serif text-white">"In an era of economic volatility, ultra-high-net-worth individuals are shifting capital into portable, historically verified colored stones. Sri Lanka remains the undisputed benchmark for true Padparadscha color."</blockquote>
                    <p class="mb-6">With primary deposits in Ratnapura yielding fewer investment-grade rough stones each year, institutional collectors are securing heritage pieces. Extensive laboratory certification from Gübelin or SSEF confirming untreated status and Sri Lankan origin is essential to commanding top-tier auction premiums.</p>
                    <p class="mb-6">For private clients seeking acquisition strategies, our advisory team recommends focusing on stones displaying pristine clarity and symmetrical master-cutting, even over pure carat weight.</p>
                '
            ],
            'mining' => [
                'meta' => 'Origin Report • April 28, 2026 • 4 min read',
                'title' => 'Ratnapura Mining Season: 2026 Quality Outlook',
                'subtitle' => 'Artisanal cooperatives utilizing traditional extraction techniques report a remarkable emergence of pristine unheated sapphire crystals.',
                'image' => 'news-bracelet.jpg',
                'author' => 'Elena Vance',
                'author_role' => 'Field Inspection Lead, Ratnapura District',
                'content' => '
                    <p class="lead text-xl text-gray-200 font-light leading-relaxed mb-6">The 2026 mining outlook across Ratnapura\'s gem-bearing gravels indicates a steady emergence of exceptional royal blue and vivid yellow sapphires. Traditional zero-carbon manual extraction methods continue to protect the integrity of delicate rough formations.</p>
                    <p class="mb-6">Our field inspection team on site has pre-vetted over forty premier specimens for inclusion in the upcoming private portfolio release. Among the highlights are two museum-grade unheated blue sapphires exceeding 15 carats, exhibiting flawless silk patterns under microscopic examination.</p>
                    <blockquote class="border-l-2 border-gold pl-6 py-2 my-8 italic text-2xl font-serif text-white">"The gravel beds of Ratnapura have been mined for over two millennia, yet they continue to surprise gemologists with crystals of unparalleled chromatic purity."</blockquote>
                    <p class="mb-6">Environmental stewardship and ethical cooperative revenue sharing remain at the forefront of our mining partnerships. By purchasing directly through vetted network ateliers, collectors ensure that local mining families receive equitable value for their historic discoveries.</p>
                '
            ],
            'trends' => [
                'meta' => 'Authentication • April 15, 2026 • 6 min read',
                'title' => 'Heritage Sri Lankan Jewelry Trends for Private Collectors',
                'subtitle' => 'The synthesis of antique provenance with contemporary GIA/Gübelin optical standards creates unparalleled heirloom value.',
                'image' => 'heritage-earrings.jpg',
                'author' => 'Lord Julian Alistair',
                'author_role' => 'Bespoke High Jewelry Curator',
                'content' => '
                    <p class="lead text-xl text-gray-200 font-light leading-relaxed mb-6">High jewelry collectors are increasingly prioritizing historical Sri Lankan craftsmanship, combining traditional filigree settings with modern precision recutting. This fusion celebrates historical provenance while maximizing internal brilliance.</p>
                    <p class="mb-6">Our advisory panel notes a 35% increase in private commissions for bespoke settings that highlight natural inclusions and untreated fluorescence. Rather than masking a stone\'s natural birthmarks, contemporary high jewelry embraces them as irrefutable proof of natural origin.</p>
                    <blockquote class="border-l-2 border-gold pl-6 py-2 my-8 italic text-2xl font-serif text-white">"A flawless stone is a marvel of physics, but a stone with a delicate natural three-phase inclusion is a historic masterpiece of time and geology."</blockquote>
                    <p class="mb-6">When evaluating antique Sri Lankan jewelry, preservation of original metalwork combined with non-invasive gemological verification ensures that pieces retain both their numismatic and intrinsic gemstone value for generations to come.</p>
                '
            ]
        ];

        $currentArticle = isset($articles[$articleId]) ? $articles[$articleId] : $articles['padparadscha'];

        $data = [
            'pageTitle' => htmlspecialchars($currentArticle['title']) . ' | Rare Stones',
            'article' => $currentArticle,
            'activeNav' => 'news'
        ];

        $this->render('home/article', $data);
    }

    /**
     * Display the Map Discovery page
     */
    public function discover() {
        $data = [
            'pageTitle' => 'Sri Lanka Seller Network | Rare Stones',
            'activeNav' => 'discover'
        ];

        $this->render('home/discover', $data);
    }

    /**
     * Handle inquiry modal submission or data request
     */
    public function inquire() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stoneId = isset($_POST['stone_id']) ? intval($_POST['stone_id']) : 0;
            $name = isset($_POST['client_name']) ? trim($_POST['client_name']) : '';
            $email = isset($_POST['client_email']) ? trim($_POST['client_email']) : '';
            $notes = isset($_POST['client_notes']) ? trim($_POST['client_notes']) : '';

            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Thank you, ' . htmlspecialchars($name) . '. Our private gemologist will contact you securely at ' . htmlspecialchars($email) . ' within 4 hours.'
            ]);
            exit;
        }
    }

    /**
     * Handle newsletter subscription
     */
    public function newsletter() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';

            header('Content-Type: application/json');
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Your subscription has been recorded. You will receive private previews before public listings.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Please enter a valid secure email address.'
                ]);
            }
            exit;
        }
    }
}
