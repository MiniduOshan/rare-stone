<?php

require_once APP_ROOT . '/controllers/Controller.php';
require_once APP_ROOT . '/models/Gemstone.php';
require_once APP_ROOT . '/models/Article.php';
require_once APP_ROOT . '/models/Feedback.php';
require_once APP_ROOT . '/models/User.php';
require_once APP_ROOT . '/helpers/Security.php';

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
        $gemSlug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
        $gemId = isset($_GET['id']) ? trim($_GET['id']) : '';

        if ($gemSlug !== '') {
            $gem = Gemstone::getBySlug($gemSlug);
        } elseif ($gemId !== '' && ctype_digit($gemId)) {
            $gem = Gemstone::getById((int) $gemId);
        } else {
            $gem = Gemstone::getBySlug($gemId);
        }

        if (!$gem) {
            header('Location: ' . BASE_URL . '/gemstones/');
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

        foreach ($allGemstones as &$gem) {
            $gem['slug'] = Gemstone::buildSlug($gem);
        }
        unset($gem);

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
            return !in_array($art['slug'], ['heritage-philosophies', 'discover-page', 'contact-details']);
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
        $articleSlug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
        $articleId = isset($_GET['id']) ? trim($_GET['id']) : '';

        if ($articleSlug !== '') {
            $article = Article::getBySlug($articleSlug);
        } elseif ($articleId !== '' && ctype_digit($articleId)) {
            $article = Article::getById((int) $articleId);
        } else {
            $article = Article::getBySlug($articleId);
        }

        if (!$article) {
            // Redirect back if article not found
            header('Location: ' . BASE_URL . '/news/');
            exit;
        }

        $effectiveSlug = $article['slug'] ?? $articleSlug;

        if ($effectiveSlug === 'contact-details') {
            $contacts = json_decode($article['content'], true);
            if (!is_array($contacts)) {
                $contacts = [];
            }

            $data = [
                'pageTitle' => 'Private Client Concierge | Rare Stones',
                'activeNav' => 'discover',
                'article' => $article,
                'contacts' => $contacts
            ];

            $this->render('home/contact', $data);
            return;
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
                header('Location: ' . BASE_URL . '/');
                exit;
            }

            // Brute-force protection
            if (!Security::canAttemptLogin()) {
                $remaining = Security::loginLockoutRemaining();
                $mins = (int) ceil($remaining / 60);
                $error = "Too many login attempts. Please try again in {$mins} minute(s).";
            } else {
                $email = Security::sanitizeEmail($_POST['email'] ?? '');
                $password = isset($_POST['password']) ? trim($_POST['password']) : '';

                if ($email === '' || $password === '') {
                    $error = 'Please enter a valid email and password.';
                } else {
                    Security::recordLoginAttempt();
                    $user = User::login($email, $password);
                    if ($user) {
                        Security::resetLoginAttempts();
                        if ($user['role'] === 'admin') {
                            header('Location: ' . BASE_URL . '/admin/');
                        } else {
                            header('Location: ' . BASE_URL . '/');
                        }
                        exit;
                    } else {
                        $error = 'Invalid credentials. Please verify your client ID and secure key.';
                    }
                }
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
            $name = Security::sanitizeString($_POST['name'] ?? '', 100);
            $email = Security::sanitizeEmail($_POST['email'] ?? '');
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            
            if (empty($name) || $email === '' || empty($password)) {
                $error = 'All fields are required.';
            } elseif (mb_strlen($password) < 6) {
                $error = 'Password must be at least 6 characters.';
            } else {
                $registered = User::register($name, $email, $password, 'customer');
                if ($registered) {
                    // Log in immediately
                    User::login($email, $password);
                    header('Location: ' . BASE_URL . '/');
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
        header('Location: ' . BASE_URL . '/');
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

            // --- Rate Limit: max 10 feedbacks per user per 24 hours ---
            $maxFeedbacks = 10;
            $windowSeconds = 86400; // 24 hours
            $now = time();
            $userId = $user['id'];
            $sessionKey = 'feedback_timestamps_' . $userId;

            if (!isset($_SESSION[$sessionKey])) {
                $_SESSION[$sessionKey] = [];
            }

            // Purge entries older than 24 hours
            $_SESSION[$sessionKey] = array_values(array_filter(
                $_SESSION[$sessionKey],
                function ($ts) use ($now, $windowSeconds) {
                    return ($now - $ts) < $windowSeconds;
                }
            ));

            if (count($_SESSION[$sessionKey]) >= $maxFeedbacks) {
                $oldest = min($_SESSION[$sessionKey]);
                $resetAt = $oldest + $windowSeconds;
                $remaining = $resetAt - $now;
                $hours = floor($remaining / 3600);
                $minutes = ceil(($remaining % 3600) / 60);

                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => "Daily feedback limit reached (max {$maxFeedbacks} per day). Try again in {$hours}h {$minutes}m."
                ]);
                exit;
            }

            $rating = Security::sanitizeInt($_POST['rating'] ?? 5, 1, 5);
            $message = Security::sanitizeString($_POST['message'] ?? '', 2000);

            if (empty($message)) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Feedback message cannot be empty.']);
                exit;
            }

            // Record this feedback attempt
            $_SESSION[$sessionKey][] = $now;

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
            $stoneId = Security::sanitizeInt($_POST['stone_id'] ?? 0, 0);
            $name = Security::sanitizeString($_POST['client_name'] ?? '', 100);
            $email = Security::sanitizeEmail($_POST['client_email'] ?? '');
            $notes = Security::sanitizeString($_POST['client_notes'] ?? '', 2000);

            if ($name === '' || $email === '') {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Please provide your name and a valid email address.']);
                exit;
            }

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
            $email = Security::sanitizeEmail($_POST['email'] ?? '');

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
