<?php

require_once APP_ROOT . '/models/User.php';
require_once APP_ROOT . '/models/Gemstone.php';
require_once APP_ROOT . '/models/Article.php';
require_once APP_ROOT . '/models/Feedback.php';
require_once APP_ROOT . '/helpers/Security.php';

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
            error_log("Admin dashboard view not found: " . $viewPath);
            die("A required admin page component is missing.");
        }
    }

    /**
     * Helper to upload image file and return new name, otherwise fallback
     */
    protected function handleImageUpload($key, $fallback) {
        if (isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK) {
            $tmpPath = $_FILES[$key]['tmp_name'];
            $originalName = $_FILES[$key]['name'];
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (in_array($extension, $allowedExtensions)) {
                $newFilename = uniqid('upload_', true) . '.' . $extension;
                $targetDir = APP_ROOT . '/../public/images';
                
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }
                
                $targetPath = $targetDir . '/' . $newFilename;
                if (move_uploaded_file($tmpPath, $targetPath)) {
                    return $newFilename;
                }
            }
        }
        return $fallback;
    }

    /**
     * Handle multiple uploaded image files (from inputs named name[])
     * Returns array of uploaded filenames.
     */
    protected function handleMultipleUploads($key) {
        $uploaded = [];
        if (!isset($_FILES[$key])) return $uploaded;

        $files = $_FILES[$key];
        if (!is_array($files['name'])) return $uploaded;

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $targetDir = APP_ROOT . '/../public/images';
        if (!file_exists($targetDir)) mkdir($targetDir, 0755, true);

        foreach ($files['name'] as $i => $originalName) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            if (!in_array($extension, $allowedExtensions)) continue;
            $tmpPath = $files['tmp_name'][$i];
            $newFilename = uniqid('upload_', true) . '.' . $extension;
            $targetPath = $targetDir . '/' . $newFilename;
            if (move_uploaded_file($tmpPath, $targetPath)) {
                $uploaded[] = $newFilename;
            }
        }
        return $uploaded;
    }

    /**
     * Normalise a gemstone image value into an array of image references.
     */
    protected function normalizeGemImages($imageValue) {
        if (!is_string($imageValue) || trim($imageValue) === '') {
            return [];
        }

        $decoded = json_decode($imageValue, true);
        if (is_array($decoded)) {
            return array_values(array_filter($decoded, function ($value) {
                return is_string($value) && trim($value) !== '';
            }));
        }

        return [trim($imageValue)];
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
     * Add/Edit Gemstones Panel
     */
    public function gems() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = Security::sanitizeInt($_POST['id'] ?? 0, 0);
            $title = Security::sanitizeString($_POST['title'] ?? '', 200);
            $origin = Security::sanitizeString($_POST['origin'] ?? '', 200);
            $location = Security::sanitizeString($_POST['location'] ?? '', 200);
            $carats = Security::sanitizeString($_POST['carats'] ?? '', 50);
            $cut = Security::sanitizeString($_POST['cut'] ?? '', 100);
            $status = Security::sanitizeString($_POST['status'] ?? '', 50);
            $image = Security::sanitizeString($_POST['image'] ?? '', 500);
            $description = Security::sanitizeString($_POST['description'] ?? '', 5000);
            $price_tier = Security::sanitizeString($_POST['price_tier'] ?? '', 100);

            // Validate status against whitelist
            $allowedStatuses = ['INQUIRE', 'UPON REQUEST', 'PRIVATE SALE', 'RESERVED'];
            if (!in_array($status, $allowedStatuses)) $status = 'INQUIRE';

            $existingImages = [];
            if ($id > 0) {
                $existingGem = Gemstone::getById($id);
                if ($existingGem && !empty($existingGem['image'])) {
                    $existingImages = $this->normalizeGemImages($existingGem['image']);
                }
            }

            // Support multiple image uploads from admin: prefer uploaded files, but preserve text fallback
            $postedImages = $this->normalizeGemImages($image);
            $uploadedMultiple = $this->handleMultipleUploads('image_files');
            // Also keep existing single-file handling for backwards-compat
            $singleUpload = $this->handleImageUpload('image_file', '');

            $images = $existingImages;

            if (!empty($postedImages)) {
                foreach ($postedImages as $postedImage) {
                    $images[] = $postedImage;
                }
            }
            if (!empty($singleUpload)) $images[] = $singleUpload;
            if (!empty($uploadedMultiple) && is_array($uploadedMultiple)) {
                $images = array_merge($images, $uploadedMultiple);
            }

            $images = array_values(array_filter(array_unique($images)));

            // Store images as a JSON array string (keeps backward compatibility if single)
            $image = json_encode(array_values($images));

            if (empty($title) || empty($origin) || empty($location) || empty($carats) || empty($cut) || empty($status) || empty($image) || empty($description) || empty($price_tier)) {
                $_SESSION['admin_error'] = 'All fields are required to save the gemstone.';
            } else {
                if ($id > 0) {
                    $updated = Gemstone::update($id, $title, $origin, $location, $carats, $cut, $status, $image, $description, $price_tier);
                    if ($updated) {
                        $_SESSION['admin_success'] = 'Gemstone listing successfully updated.';
                    } else {
                        $_SESSION['admin_error'] = 'Failed to update gemstone in database.';
                    }
                } else {
                    $added = Gemstone::add($title, $origin, $location, $carats, $cut, $status, $image, $description, $price_tier);
                    if ($added) {
                        $_SESSION['admin_success'] = 'Gemstone listing successfully added to the vault.';
                    } else {
                        $_SESSION['admin_error'] = 'Failed to register gemstone in database.';
                    }
                }
            }
        }
        header('Location: ' . BASE_URL . '/admin/#gems');
        exit;
    }

    /**
     * Add/Edit News / Editorial Panel
     */
    public function news() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = Security::sanitizeInt($_POST['id'] ?? 0, 0);
            $title = Security::sanitizeString($_POST['title'] ?? '', 300);
            $subtitle = Security::sanitizeString($_POST['subtitle'] ?? '', 500);
            $meta = Security::sanitizeString($_POST['meta'] ?? '', 300);
            $image = Security::sanitizeString($_POST['image'] ?? '', 500);
            $author = Security::sanitizeString($_POST['author'] ?? '', 100);
            $author_role = Security::sanitizeString($_POST['author_role'] ?? '', 100);
            $content = Security::sanitizeHtml($_POST['content'] ?? '', 50000);
            $slug = Security::sanitizeSlug($_POST['slug'] ?? '', 200);

            $image = $this->handleImageUpload('image_file', $image);

            // Auto-generate slug if not provided
            if (empty($slug)) {
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
            }

            if (empty($title) || empty($meta) || empty($author) || empty($content)) {
                $_SESSION['admin_error'] = 'Title, Meta details, Author, and Article Content are required.';
            } else {
                if ($id > 0) {
                    $updated = Article::update($id, $slug, $meta, $title, $subtitle, $image, $author, $author_role, $content);
                    if ($updated) {
                        $_SESSION['admin_success'] = 'Editorial insight article successfully updated.';
                    } else {
                        $_SESSION['admin_error'] = 'Failed to update article. Slug might already exist.';
                    }
                } else {
                    $added = Article::add($slug, $meta, $title, $subtitle, $image, $author, $author_role, $content);
                    if ($added) {
                        $_SESSION['admin_success'] = 'Editorial insight article successfully published.';
                    } else {
                        $_SESSION['admin_error'] = 'Failed to save article. Slug might already exist.';
                    }
                }
            }
        }
        header('Location: ' . BASE_URL . '/admin/#news');
        exit;
    }

    /**
     * Set a specific article as headline
     */
    public function headline() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            if ($id > 0) {
                if (Article::setHeadline($id)) {
                    $_SESSION['admin_success'] = 'Headline article updated successfully.';
                } else {
                    $_SESSION['admin_error'] = 'Failed to set headline article.';
                }
            } else {
                $_SESSION['admin_error'] = 'Invalid article ID provided.';
            }
        }
        header('Location: ' . BASE_URL . '/admin/#news');
        exit;
    }

    /**
     * Change Heritage Article Panel
     */
    public function heritage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article = Article::getBySlug('heritage-philosophies');
            if ($article) {
                $title = Security::sanitizeString($_POST['title'] ?? '', 300);
                $subtitle = Security::sanitizeString($_POST['subtitle'] ?? '', 500);
                $image = Security::sanitizeString($_POST['image'] ?? '', 500);
                $author = Security::sanitizeString($_POST['quote'] ?? '', 500); // Quote field is stored in author
                $content = Security::sanitizeHtml($_POST['content'] ?? '', 50000);

                $image = $this->handleImageUpload('image_file', $image);

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
        header('Location: ' . BASE_URL . '/admin/#heritage');
        exit;
    }

    /**
     * Moderate Customer Feedbacks Status
     */
    public function feedbackStatus() {
        $id = Security::sanitizeInt($_GET['id'] ?? 0, 0);
        $status = Security::sanitizeString($_GET['status'] ?? '', 20);

        if ($id > 0 && in_array($status, ['approved', 'rejected'])) {
            Feedback::updateStatus($id, $status);
        }

        header('Location: ' . BASE_URL . '/admin/#feedbacks');
        exit;
    }

    /**
     * Change Discover Page configuration
     */
    public function discover() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article = Article::getBySlug('discover-page');
            if ($article) {
                $title = Security::sanitizeString($_POST['title'] ?? '', 300);
                $subtitle = Security::sanitizeString($_POST['subtitle'] ?? '', 500);
                $content = isset($_POST['content']) ? trim($_POST['content']) : ''; // JSON — validated below

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
        header('Location: ' . BASE_URL . '/admin/#discover');
        exit;
    }

    /**
     * Change Contact Details configuration
     */
    public function contact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article = Article::getBySlug('contact-details');
            if ($article) {
                $whatsapp = Security::sanitizeString($_POST['whatsapp'] ?? '', 50);
                $phone = Security::sanitizeString($_POST['phone'] ?? '', 50);
                $email = Security::sanitizeEmail($_POST['email'] ?? '');
                $instagram = Security::sanitizeString($_POST['instagram'] ?? '', 200);
                $facebook = Security::sanitizeString($_POST['facebook'] ?? '', 200);

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
        header('Location: ' . BASE_URL . '/admin/#contact');
        exit;
    }

    /**
     * Generate and download a full project backup ZIP
     * Includes: MySQL DB export, uploaded images, all project files
     */
    public function backup() {
        // --- Rate Limit: max 2 backups per 24 hours ---
        $maxAttempts = 2;
        $windowSeconds = 86400; // 24 hours
        $now = time();

        if (!isset($_SESSION['backup_timestamps'])) {
            $_SESSION['backup_timestamps'] = [];
        }

        // Purge entries older than 24 hours
        $_SESSION['backup_timestamps'] = array_values(array_filter(
            $_SESSION['backup_timestamps'],
            function ($ts) use ($now, $windowSeconds) {
                return ($now - $ts) < $windowSeconds;
            }
        ));

        if (count($_SESSION['backup_timestamps']) >= $maxAttempts) {
            // Calculate when the earliest attempt expires
            $oldest = min($_SESSION['backup_timestamps']);
            $resetAt = $oldest + $windowSeconds;
            $remaining = $resetAt - $now;
            $hours = floor($remaining / 3600);
            $minutes = ceil(($remaining % 3600) / 60);

            $_SESSION['admin_error'] = "Backup limit reached (max {$maxAttempts} per 24 hours). Try again in {$hours}h {$minutes}m.";
            header('Location: ' . BASE_URL . '/admin/');
            exit;
        }

        // Record this attempt
        $_SESSION['backup_timestamps'][] = $now;

        // Increase limits for large backups
        @set_time_limit(600);
        @ini_set('memory_limit', '512M');

        $projectRoot = dirname(dirname(APP_ROOT));
        $storageDir = $projectRoot . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'backups';

        // Ensure storage/backups directory exists
        if (!is_dir($storageDir)) {
            if (!@mkdir($storageDir, 0755, true)) {
                $_SESSION['admin_error'] = 'Failed to create backup storage directory.';
                header('Location: ' . BASE_URL . '/admin/');
                exit;
            }
        }

        // Generate timestamped filename
        $timestamp = date('Y-m-d_H-i-s');
        $zipFilename = 'backup_' . $timestamp . '.zip';
        $zipPath = $storageDir . DIRECTORY_SEPARATOR . $zipFilename;
        $sqlFilename = 'database_' . $timestamp . '.sql';
        $sqlPath = $storageDir . DIRECTORY_SEPARATOR . $sqlFilename;

        try {
            // --- 1. Export MySQL Database ---
            $sqlExported = $this->exportDatabase($sqlPath);
            if (!$sqlExported) {
                throw new Exception('Database export failed. Check server logs for details.');
            }

            // --- 2. Create ZIP Archive ---
            $zip = new ZipArchive();
            $result = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            if ($result !== true) {
                throw new Exception('Could not create ZIP archive. Error code: ' . $result);
            }

            // Add SQL export
            $zip->addFile($sqlPath, $sqlFilename);

            // Directories/files to exclude from backup
            $excludeDirs = [
                'vendor',
                'node_modules',
                'storage' . DIRECTORY_SEPARATOR . 'cache',
                'storage' . DIRECTORY_SEPARATOR . 'backups',
                '.git',
            ];

            // --- 3. Add all project files recursively ---
            $this->addDirectoryToZip($zip, $projectRoot, $projectRoot, $excludeDirs);

            $zip->close();

            // --- 4. Verify ZIP was created ---
            if (!file_exists($zipPath) || filesize($zipPath) === 0) {
                throw new Exception('ZIP archive was not created or is empty.');
            }

            // --- 5. Stream download with secure headers ---
            // Clean any previous output buffers
            while (ob_get_level()) {
                ob_end_clean();
            }

            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipFilename . '"');
            header('Content-Length: ' . filesize($zipPath));
            header('Content-Transfer-Encoding: binary');
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header('Pragma: no-cache');
            header('Expires: 0');
            header('X-Content-Type-Options: nosniff');

            readfile($zipPath);

            // --- 6. Cleanup temporary files ---
            @unlink($sqlPath);
            @unlink($zipPath);

            exit;

        } catch (Exception $e) {
            error_log('Backup failed: ' . $e->getMessage());

            // Cleanup on failure
            if (file_exists($sqlPath)) @unlink($sqlPath);
            if (file_exists($zipPath)) @unlink($zipPath);

            $_SESSION['admin_error'] = 'Backup generation failed: ' . $e->getMessage();
            header('Location: ' . BASE_URL . '/admin/');
            exit;
        }
    }

    /**
     * Export MySQL database using mysqldump or PDO fallback
     * Uses config constants (DB_HOST, DB_USER, DB_PASS, DB_NAME) from environment
     *
     * @param string $sqlPath Full path for the output .sql file
     * @return bool
     */
    protected function exportDatabase($sqlPath) {
        $dbHost = DB_HOST;
        $dbUser = DB_USER;
        $dbPass = DB_PASS;
        $dbName = DB_NAME;

        // Attempt mysqldump first (faster, more reliable for large DBs)
        $mysqldumpPath = $this->findMysqldump();
        if ($mysqldumpPath) {
            $cmd = sprintf(
                '%s --host=%s --user=%s %s --single-transaction --routines --triggers %s > %s 2>&1',
                escapeshellarg($mysqldumpPath),
                escapeshellarg($dbHost),
                escapeshellarg($dbUser),
                $dbPass !== '' ? '--password=' . escapeshellarg($dbPass) : '',
                escapeshellarg($dbName),
                escapeshellarg($sqlPath)
            );

            exec($cmd, $output, $returnCode);

            if ($returnCode === 0 && file_exists($sqlPath) && filesize($sqlPath) > 0) {
                return true;
            }
            error_log('mysqldump failed (exit code ' . $returnCode . '): ' . implode("\n", $output));
        }

        // Fallback: PDO-based SQL export
        return $this->exportDatabaseViaPDO($sqlPath);
    }

    /**
     * Locate mysqldump binary on common paths (Linux/Windows)
     *
     * @return string|null
     */
    protected function findMysqldump() {
        $paths = [
            'mysqldump',                               // system PATH
            '/usr/bin/mysqldump',                      // Linux default
            '/usr/local/bin/mysqldump',                // Linux alt
            '/usr/local/mysql/bin/mysqldump',          // macOS Homebrew
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',     // Windows XAMPP
            'C:\\wamp64\\bin\\mysql\\mysql8.0.31\\bin\\mysqldump.exe', // WAMP
        ];

        foreach ($paths as $path) {
            // For the first entry, check if it's on PATH
            if ($path === 'mysqldump') {
                $which = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? 'where mysqldump 2>nul' : 'which mysqldump 2>/dev/null';
                exec($which, $out, $ret);
                if ($ret === 0 && !empty($out[0])) {
                    return trim($out[0]);
                }
                continue;
            }
            if (file_exists($path) && is_executable($path)) {
                return $path;
            }
            // Windows: also check without is_executable since it may not work correctly
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' && file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Export database via PDO (fallback when mysqldump is unavailable)
     *
     * @param string $sqlPath
     * @return bool
     */
    protected function exportDatabaseViaPDO($sqlPath) {
        try {
            require_once APP_ROOT . '/models/Database.php';
            $pdo = Database::getConnection();

            $handle = fopen($sqlPath, 'w');
            if (!$handle) {
                return false;
            }

            fwrite($handle, "-- Rare Stones Database Backup\n");
            fwrite($handle, "-- Generated: " . date('Y-m-d H:i:s') . "\n");
            fwrite($handle, "-- Database: " . DB_NAME . "\n");
            fwrite($handle, "SET NAMES utf8mb4;\n");
            fwrite($handle, "SET FOREIGN_KEY_CHECKS = 0;\n\n");

            // Get all tables
            $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

            foreach ($tables as $table) {
                // Table structure
                $createStmt = $pdo->query('SHOW CREATE TABLE `' . $table . '`')->fetch();
                $createSql = $createStmt['Create Table'] ?? $createStmt[1] ?? '';

                fwrite($handle, "\n-- Table: `{$table}`\n");
                fwrite($handle, "DROP TABLE IF EXISTS `{$table}`;\n");
                fwrite($handle, $createSql . ";\n\n");

                // Table data
                $rows = $pdo->query('SELECT * FROM `' . $table . '`')->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($rows)) {
                    $columns = array_keys($rows[0]);
                    $colList = '`' . implode('`, `', $columns) . '`';

                    foreach ($rows as $row) {
                        $values = array_map(function($val) use ($pdo) {
                            if ($val === null) return 'NULL';
                            return $pdo->quote($val);
                        }, array_values($row));

                        fwrite($handle, "INSERT INTO `{$table}` ({$colList}) VALUES (" . implode(', ', $values) . ");\n");
                    }
                    fwrite($handle, "\n");
                }
            }

            fwrite($handle, "SET FOREIGN_KEY_CHECKS = 1;\n");
            fclose($handle);

            return file_exists($sqlPath) && filesize($sqlPath) > 0;

        } catch (Exception $e) {
            error_log('PDO database export failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Recursively add a directory's contents to a ZipArchive
     *
     * @param ZipArchive $zip
     * @param string $dir           Current directory to scan
     * @param string $projectRoot   Project root for relative path calculation
     * @param array  $excludeDirs   Relative dir paths to skip
     */
    protected function addDirectoryToZip(ZipArchive $zip, $dir, $projectRoot, $excludeDirs) {
        $iterator = new DirectoryIterator($dir);

        foreach ($iterator as $item) {
            if ($item->isDot()) {
                continue;
            }

            $fullPath = $item->getPathname();
            $relativePath = str_replace(
                ['/', '\\'],
                DIRECTORY_SEPARATOR,
                substr($fullPath, strlen($projectRoot) + 1)
            );

            // Normalise to forward slashes for zip internal paths
            $zipInternalPath = str_replace('\\', '/', $relativePath);

            // Check exclusion list
            $skip = false;
            foreach ($excludeDirs as $excludeDir) {
                $normalizedExclude = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $excludeDir);
                if (strpos($relativePath, $normalizedExclude) === 0) {
                    $skip = true;
                    break;
                }
            }
            if ($skip) {
                continue;
            }

            if ($item->isDir()) {
                $zip->addEmptyDir($zipInternalPath);
                $this->addDirectoryToZip($zip, $fullPath, $projectRoot, $excludeDirs);
            } elseif ($item->isFile() && $item->isReadable()) {
                $zip->addFile($fullPath, $zipInternalPath);
            }
        }
    }
}
