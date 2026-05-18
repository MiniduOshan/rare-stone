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
            'pageTitle' => 'AETHERIA | Rare & Exceptional Gemstones',
            'featuredGemstones' => $featuredGemstones,
            'allGemstones' => $allGemstones,
            'activeNav' => 'home'
        ];

        $this->render('home/index', $data);
    }

    /**
     * Display the Heritage page
     */
    public function heritage() {
        $data = [
            'pageTitle' => 'Our Heritage & Philosophy | AETHERIA',
            'activeNav' => 'heritage'
        ];

        $this->render('home/heritage', $data);
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
