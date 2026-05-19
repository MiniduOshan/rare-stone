<?php

require_once APP_ROOT . '/models/User.php';
require_once APP_ROOT . '/models/Gemstone.php';
require_once APP_ROOT . '/models/Article.php';
require_once APP_ROOT . '/models/Feedback.php';

class AdminController {
    
    /**
     * Helper to render admin dashboard views
     */
    protected function renderAdmin($view, $data = []) {
        extract($data);
        $viewPath = APP_ROOT . '/views/admin/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Admin dashboard view not found: " . $viewPath);
        }
    }

    /**
     * Dashboard Home: Feedback Moderation Queue & Master Layout
     */
    public function index() {
        $feedbacks = Feedback::getAll();
        $gems = Gemstone::getCuratedAcquisitions();
        $allArticles = Article::getAll();
        
        // Filter out internal configuration pages
        $newsArticles = array_filter($allArticles, function($art) {
            return !in_array($art['slug'], ['heritage-philosophies', 'discover-page', 'contact-details']);
        });
        $newsArticles = array_values($newsArticles);

        // Count stats
        $totalGems = count($gems);
        $totalNews = count($newsArticles);
        
        $pendingReviews = 0;
        $approvedReviews = 0;
        foreach ($feedbacks as $f) {
            if ($f['status'] === 'pending') $pendingReviews++;
            if ($f['status'] === 'approved') $approvedReviews++;
        }

        // Self-healing check for heritage
        $heritageArticle = Article::getBySlug('heritage-philosophies');
        if (!$heritageArticle) {
            Article::add(
                'heritage-philosophies',
                'Philosophy & Heritage',
                'The Private Network',
                'Founded on the principles of trust, discretion, and an unyielding commitment to exceptional quality.',
                'heritage-earrings.jpg',
                'True luxury is found in absolute rarity and flawless provenance. We do not sell gems; we curate legacies.',
                'Rare Stones Board',
                '<p>Founded on the principles of trust, discretion, and an unyielding commitment to exceptional quality, Aetheria Gems was established to connect the world\'s most distinguished buyers with rare and historically significant gemstones.</p><p>We do not hold inventory. Instead, we provide a secure, authenticated framework for transactions between vetted private collectors, artisanal sustainable miners, and master jewelers across the globe.</p><p>Every listing on our platform undergoes a rigorous pre-approval process, requiring certification from premier gemological laboratories (such as GIA, Gübelin, or SSEF) and verification of the seller\'s standing.</p>'
            );
            $heritageArticle = Article::getBySlug('heritage-philosophies');
        }

        // Self-healing check for discover
        $discoverArticle = Article::getBySlug('discover-page');
        if (!$discoverArticle) {
            $defaultBranches = [
                [ 'lat' => 6.9271, 'lng' => 79.8612, 'name' => 'Rare Stones - Colombo Gallery', 'city' => 'Colombo, Sri Lanka', 'listings' => '42 active lots' ],
                [ 'lat' => 6.6828, 'lng' => 80.3992, 'name' => 'Rare Stones - Ratnapura Source', 'city' => 'Ratnapura, Sri Lanka', 'listings' => '34 active lots' ],
                [ 'lat' => 6.0329, 'lng' => 80.2168, 'name' => 'Rare Stones - Galle Atelier', 'city' => 'Galle, Sri Lanka', 'listings' => '18 active lots' ],
                [ 'lat' => 6.4750, 'lng' => 79.9958, 'name' => 'Rare Stones - Beruwala Syndicate', 'city' => 'Beruwala, Sri Lanka', 'listings' => '26 active lots' ]
            ];
            Article::add(
                'discover-page',
                'Discover Page',
                'Rare Stones Vaults',
                'Explore our exclusive island-wide private viewing salons and secure gemological vaults.',
                '',
                '',
                '',
                json_encode($defaultBranches)
            );
            $discoverArticle = Article::getBySlug('discover-page');
        }

        // Self-healing check for contact
        $contactArticle = Article::getBySlug('contact-details');
        if (!$contactArticle) {
            $defaultContacts = [
                'whatsapp' => '+94 77 123 4567',
                'phone' => '+94 11 234 5678',
                'email' => 'concierge@rarestones.lk',
                'instagram' => 'rarestones.ceylon',
                'facebook' => 'Rare Stones Ceylon'
            ];
            
            Article::add(
                'contact-details',
                'Contact Page',
                'Private Client Concierge',
                'Connect directly with our senior gemologists and private client advisors through your preferred secure communication channel.',
                '',
                '',
                '',
                json_encode($defaultContacts)
            );
            $contactArticle = Article::getBySlug('contact-details');
        }

        // Retrieve messages from session (if any)
        $success = isset($_SESSION['admin_success']) ? $_SESSION['admin_success'] : '';
        $error = isset($_SESSION['admin_error']) ? $_SESSION['admin_error'] : '';
        unset($_SESSION['admin_success'], $_SESSION['admin_error']);

        $data = [
            'pageTitle' => 'Admin Control Panel | Rare Stones',
            'feedbacks' => $feedbacks,
            'gems' => $gems,
            'articles' => $allArticles,
            'newsArticles' => $newsArticles,
            'heritageArticle' => $heritageArticle,
            'discoverArticle' => $discoverArticle,
            'contactArticle' => $contactArticle,
            'success' => $success,
            'error' => $error,
            'stats' => [
                'totalGems' => $totalGems,
                'totalNews' => $totalNews,
                'pendingReviews' => $pendingReviews,
                'approvedReviews' => $approvedReviews
            ]
        ];

        $this->renderAdmin('index', $data);
    }

    /**
     * Add Gemstones Panel
     */
    public function gems() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = isset($_POST['title']) ? trim($_POST['title']) : '';
            $origin = isset($_POST['origin']) ? trim($_POST['origin']) : '';
            $carats = isset($_POST['carats']) ? trim($_POST['carats']) : '';
            $cut = isset($_POST['cut']) ? trim($_POST['cut']) : '';
            $status = isset($_POST['status']) ? trim($_POST['status']) : '';
            $image = isset($_POST['image']) ? trim($_POST['image']) : '';
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';
            $price_tier = isset($_POST['price_tier']) ? trim($_POST['price_tier']) : '';

            if (empty($title) || empty($origin) || empty($carats) || empty($cut) || empty($status) || empty($image) || empty($description) || empty($price_tier)) {
                $_SESSION['admin_error'] = 'All fields are required to register a new gemstone.';
            } else {
                $added = Gemstone::add($title, $origin, $carats, $cut, $status, $image, $description, $price_tier);
                if ($added) {
                    $_SESSION['admin_success'] = 'Gemstone listing successfully added to the vault.';
                } else {
                    $_SESSION['admin_error'] = 'Failed to register gemstone in database.';
                }
            }
        }
        header('Location: ' . BASE_URL . '/index.php?route=admin#gems');
        exit;
    }

    /**
     * Add News / Editorial Panel
     */
    public function news() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = isset($_POST['title']) ? trim($_POST['title']) : '';
            $subtitle = isset($_POST['subtitle']) ? trim($_POST['subtitle']) : '';
            $meta = isset($_POST['meta']) ? trim($_POST['meta']) : '';
            $image = isset($_POST['image']) ? trim($_POST['image']) : '';
            $author = isset($_POST['author']) ? trim($_POST['author']) : '';
            $author_role = isset($_POST['author_role']) ? trim($_POST['author_role']) : '';
            $content = isset($_POST['content']) ? trim($_POST['content']) : '';
            $slug = isset($_POST['slug']) ? trim($_POST['slug']) : '';

            // Auto-generate slug if not provided
            if (empty($slug)) {
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
            }

            if (empty($title) || empty($meta) || empty($author) || empty($content)) {
                $_SESSION['admin_error'] = 'Title, Meta details, Author, and Article Content are required.';
            } else {
                $added = Article::add($slug, $meta, $title, $subtitle, $image, $author, $author_role, $content);
                if ($added) {
                    $_SESSION['admin_success'] = 'Editorial insight article successfully published.';
                } else {
                    $_SESSION['admin_error'] = 'Failed to save article. Slug might already exist.';
                }
            }
        }
        header('Location: ' . BASE_URL . '/index.php?route=admin#news');
        exit;
    }

    /**
     * Change Heritage Article Panel
     */
    public function heritage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article = Article::getBySlug('heritage-philosophies');
            if ($article) {
                $title = isset($_POST['title']) ? trim($_POST['title']) : '';
                $subtitle = isset($_POST['subtitle']) ? trim($_POST['subtitle']) : '';
                $image = isset($_POST['image']) ? trim($_POST['image']) : '';
                $author = isset($_POST['quote']) ? trim($_POST['quote']) : ''; // Quote field is stored in author
                $content = isset($_POST['content']) ? trim($_POST['content']) : '';

                if (empty($title) || empty($content)) {
                    $_SESSION['admin_error'] = 'Title and Heritage content are required.';
                } else {
                    $updated = Article::update($article['id'], 'heritage-philosophies', 'Philosophy & Heritage', $title, $subtitle, $image, $author, 'Rare Stones Board', $content);
                    if ($updated) {
                        $_SESSION['admin_success'] = 'Heritage and Brand philosophy article updated successfully.';
                    } else {
                        $_SESSION['admin_error'] = 'Failed to update heritage article in database.';
                    }
                }
            }
        }
        header('Location: ' . BASE_URL . '/index.php?route=admin#heritage');
        exit;
    }

    /**
     * Moderate Customer Feedbacks Status
     */
    public function feedbackStatus() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $status = isset($_GET['status']) ? trim($_GET['status']) : '';

        if ($id > 0 && in_array($status, ['approved', 'rejected'])) {
            Feedback::updateStatus($id, $status);
        }

        header('Location: ' . BASE_URL . '/index.php?route=admin#feedbacks');
        exit;
    }

    /**
     * Change Discover Page configuration
     */
    public function discover() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article = Article::getBySlug('discover-page');
            if ($article) {
                $title = isset($_POST['title']) ? trim($_POST['title']) : '';
                $subtitle = isset($_POST['subtitle']) ? trim($_POST['subtitle']) : '';
                $content = isset($_POST['content']) ? trim($_POST['content']) : ''; // JSON string of branches

                if (empty($title) || empty($content)) {
                    $_SESSION['admin_error'] = 'Title and Branches JSON content are required.';
                } else {
                    // Validate JSON
                    json_decode($content);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $updated = Article::update($article['id'], 'discover-page', 'Discover Page', $title, $subtitle, '', '', '', $content);
                        if ($updated) {
                            $_SESSION['admin_success'] = 'Discover page configuration updated successfully.';
                        } else {
                            $_SESSION['admin_error'] = 'Failed to update discover page in database.';
                        }
                    } else {
                        $_SESSION['admin_error'] = 'Branches content must be a valid JSON format.';
                    }
                }
            }
        }
        header('Location: ' . BASE_URL . '/index.php?route=admin#discover');
        exit;
    }

    /**
     * Change Contact Details configuration
     */
    public function contact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article = Article::getBySlug('contact-details');
            if ($article) {
                $whatsapp = isset($_POST['whatsapp']) ? trim($_POST['whatsapp']) : '';
                $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
                $email = isset($_POST['email']) ? trim($_POST['email']) : '';
                $instagram = isset($_POST['instagram']) ? trim($_POST['instagram']) : '';
                $facebook = isset($_POST['facebook']) ? trim($_POST['facebook']) : '';

                $contacts = [
                    'whatsapp' => $whatsapp,
                    'phone' => $phone,
                    'email' => $email,
                    'instagram' => $instagram,
                    'facebook' => $facebook
                ];

                $updated = Article::update($article['id'], 'contact-details', 'Contact Page', 'Private Client Concierge', 'Connect directly with our senior gemologists...', '', '', '', json_encode($contacts));
                if ($updated) {
                    $_SESSION['admin_success'] = 'Contact details updated successfully.';
                } else {
                    $_SESSION['admin_error'] = 'Failed to update contact details in database.';
                }
            }
        }
        header('Location: ' . BASE_URL . '/index.php?route=admin#contact');
        exit;
    }
}
