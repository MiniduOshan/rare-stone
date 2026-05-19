<?php

require_once APP_ROOT . '/controllers/Controller.php';
require_once APP_ROOT . '/models/Gemstone.php';
require_once APP_ROOT . '/models/Article.php';
require_once APP_ROOT . '/models/Feedback.php';
require_once APP_ROOT . '/models/User.php';

class HomeController extends Controller {
    /**
     * Display the main landing page
     */
    public function index() {
        $allGemstones = Gemstone::getCuratedAcquisitions();
        $featuredGemstones = array_slice($allGemstones, 0, 3);
        $reviews = Feedback::getApproved();

        $data = [
            'pageTitle' => 'Rare Stones | Rare & Exceptional Gemstones',
            'featuredGemstones' => $featuredGemstones,
            'allGemstones' => $allGemstones,
            'reviews' => $reviews,
            'activeNav' => 'home',
            'currentUser' => User::getCurrentUser()
        ];

        $this->render('home/index', $data);
    }

    /**
     * Display dedicated gemstone view page
     */
    public function gem() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 1;
        $gem = Gemstone::getById($id);

        if (!$gem) {
            header('Location: ' . BASE_URL . '/index.php?route=gemstones');
            exit;
        }

        $reviews = Feedback::getApproved();

        $data = [
            'pageTitle' => htmlspecialchars($gem['title']) . ' | Rare Stones',
            'gem' => $gem,
            'reviews' => $reviews,
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
        // Load the heritage article from the database using its unique slug
        $article = Article::getBySlug('heritage-philosophies');
        
        // If not found in the DB (for example, if not seeded), we can show static fallbacks or create it.
        $data = [
            'pageTitle' => 'Our Heritage & Philosophy | Rare Stones',
            'activeNav' => 'heritage',
            'article' => $article
        ];

        $this->render('home/heritage', $data);
    }

    /**
     * Display the News & Editorial page
     */
    public function news() {
        $allArticles = Article::getAll();
        
        // Filter out internal configuration pages
        $articles = array_filter($allArticles, function($art) {
            return !in_array($art['slug'], ['heritage-philosophies', 'discover-page']);
        });
        
        // Re-index array
        $articles = array_values($articles);

        $data = [
            'pageTitle' => 'Editorial & Insight | Rare Stones',
            'articles' => $articles,
            'activeNav' => 'news'
        ];

        $this->render('home/news', $data);
    }

    /**
     * Display the Dedicated Article Reader page
     */
    public function article() {
        $articleId = isset($_GET['id']) ? trim($_GET['id']) : '';
        $article = Article::getBySlug($articleId);

        if (!$article) {
            // Redirect back if article not found
            header('Location: ' . BASE_URL . '/index.php?route=news');
            exit;
        }

        $data = [
            'pageTitle' => htmlspecialchars($article['title']) . ' | Rare Stones',
            'article' => $article,
            'activeNav' => 'news'
        ];

        $this->render('home/article', $data);
    }

    /**
     * Display the Map Discovery page
     */
    public function discover() {
        $article = Article::getBySlug('discover-page');
        
        $data = [
            'pageTitle' => 'Sri Lanka Seller Network | Rare Stones',
            'activeNav' => 'discover',
            'article' => $article
        ];

        $this->render('home/discover', $data);
    }

    /**
     * Handle client login & guest session redirection
     */
    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'guest') {
                User::loginAsGuest();
                header('Location: ' . BASE_URL . '/index.php?route=home');
                exit;
            }

            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';

            $user = User::login($email, $password);
            if ($user) {
                if ($user['role'] === 'admin') {
                    header('Location: ' . BASE_URL . '/index.php?route=admin');
                } else {
                    header('Location: ' . BASE_URL . '/index.php?route=home');
                }
                exit;
            } else {
                $error = 'Invalid credentials. Please verify your client ID and secure key.';
            }
        }

        $data = [
            'pageTitle' => 'Client Entry Portal | Rare Stones',
            'error' => $error,
            'activeNav' => ''
        ];

        $this->render('home/login', $data);
    }

    /**
     * Handle client registration
     */
    public function register() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            
            if (empty($name) || empty($email) || empty($password)) {
                $error = 'All fields are required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } else {
                $registered = User::register($name, $email, $password, 'customer');
                if ($registered) {
                    // Log in immediately
                    User::login($email, $password);
                    header('Location: ' . BASE_URL . '/index.php?route=home');
                    exit;
                } else {
                    $error = 'Email is already registered. Please login or use another email.';
                }
            }
        }

        $data = [
            'pageTitle' => 'Client Circle Registration | Rare Stones',
            'error' => $error,
            'activeNav' => ''
        ];

        $this->render('home/register', $data);
    }

    /**
     * Perform logout and redirect
     */
    public function logout() {
        User::logout();
        header('Location: ' . BASE_URL . '/index.php?route=home');
        exit;
    }

    /**
     * Submit feedback (requires customer authentication)
     */
    public function feedback() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = User::getCurrentUser();
            if (!$user || $user['is_guest']) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Please register or login to submit your feedback.']);
                exit;
            }

            $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 5;
            $message = isset($_POST['message']) ? trim($_POST['message']) : '';

            if (empty($message)) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Feedback message cannot be empty.']);
                exit;
            }

            $success = Feedback::add($user['id'], $rating, $message);
            header('Content-Type: application/json');
            if ($success) {
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Thank you. Your review has been submitted for verification. It will appear once approved by our administrator.'
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Could not save feedback. Please try again.']);
            }
            exit;
        }
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
