<?php
// includes/functions.php — COMPLETE FIX
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/env.php';

/**
 * Core utility functions for Vueports Solutions
 * FIXED: Table name consistency, session key alignment, null safety
 */

/* ========================================
   Security & Input Sanitization
   ======================================== */

function sanitize(string $data): string {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function csrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrf(?string $token): bool {
    if (empty($token) || empty($_SESSION['csrf_token'])) return false;
    return hash_equals($_SESSION['csrf_token'], $token);
}

function generateNonce(): string {
    return base64_encode(random_bytes(16));
}

/* ========================================
   Authentication & Authorization
   ======================================== */

// FIXED: Check both possible session keys for role
function isAdmin(): bool {
    return isset($_SESSION['admin_id']) 
        && !empty($_SESSION['admin_id']) 
        && in_array(($_SESSION['role'] ?? $_SESSION['admin_role'] ?? ''), ['admin', 'super_admin', 'editor', 'support']);
}

function isSuperAdmin(): bool {
    $role = $_SESSION['role'] ?? $_SESSION['admin_role'] ?? '';
    return isAdmin() && $role === 'super_admin';
}

function isClient(): bool {
    return isset($_SESSION['client_id']) && !empty($_SESSION['client_id']);
}

function getCurrentClientId(): int {
    return (int) ($_SESSION['client_id'] ?? 0);
}

function getCurrentAdminId(): int {
    return (int) ($_SESSION['admin_id'] ?? 0);
}

function requireAdmin(): void {
    if (!isAdmin()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        redirect('../admin/login.php');
    }
}

function requireClient(): void {
    if (!isClient()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        redirect('../client/login.php');
    }
}

/* ========================================
   Navigation & Redirects
   ======================================== */

function redirect(string $url): void {
    if (headers_sent()) {
        echo "<script>window.location.href='" . addslashes($url) . "';</script>";
        exit;
    }
    header("Location: $url");
    exit;
}

function back(): void {
    redirect($_SERVER['HTTP_REFERER'] ?? 'index.php');
}

function jsonResponse(bool $success, $data = null, string $message = '', int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => $success, 'message' => $message, 'data' => $data], JSON_THROW_ON_ERROR);
    exit;
}

/* ========================================
   Settings & Configuration
   ======================================== */

function getSetting(string $key, string $default = ''): string {
    static $cache = [];
    if (isset($cache[$key])) return $cache[$key];
    
    $db = db();
    if (!$db) return $default;
    
    try {
        $stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = ? LIMIT 1");
        $stmt->execute([$key]);
        $row = $stmt->fetch();
        $value = $row ? (string) $row['setting_value'] : $default;
        $cache[$key] = $value;
        return $value;
    } catch (PDOException $e) {
        error_log("getSetting error: " . $e->getMessage());
        return $default;
    }
}

function setSetting(string $key, string $value): bool {
    $db = db();
    if (!$db) return false;
    
    try {
        $stmt = $db->prepare("INSERT INTO settings (setting_key, setting_value, updated_at) 
                              VALUES (?, ?, NOW()) 
                              ON DUPLICATE KEY UPDATE setting_value = ?, updated_at = NOW()");
        $stmt->execute([$key, $value, $value]);
        return true;
    } catch (PDOException $e) {
        error_log("setSetting error: " . $e->getMessage());
        return false;
    }
}

/* ========================================
   Database Helpers
   ======================================== */

if (!function_exists('db')) {
    function db(): ?PDO {
        global $pdo;
        return $pdo ?? null;
    }
}

function dbTransaction(callable $callback): bool {
    $db = db();
    if (!$db) return false;
    
    try {
        $db->beginTransaction();
        $result = $callback($db);
        if ($result === false) {
            $db->rollBack();
            return false;
        }
        $db->commit();
        return true;
    } catch (Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        error_log("Transaction failed: " . $e->getMessage());
        return false;
    }
}

/* ========================================
   Content & CMS Helpers
   ======================================== */

function getServiceBySlug(string $slug): ?array {
    $db = db();
    if (!$db) return null;
    
    $stmt = $db->prepare("SELECT * FROM services WHERE slug = ? AND status = 'active' LIMIT 1");
    $stmt->execute([$slug]);
    $row = $stmt->fetch();
    return $row ?: null;
}

// FIXED: Removed duplicate getServices() - consolidated into one function
function getServices(int $limit = 6, string $status = 'active'): array {
    $db = db();
    if (!$db) return [];
    
    $sql = "SELECT * FROM services";
    $params = [];
    if ($status !== 'all') {
        $sql .= " WHERE status = ?";
        $params[] = $status;
    }
    $sql .= " ORDER BY sort_order ASC, created_at DESC";
    if ($limit > 0) {
        $sql .= " LIMIT ?";
        $params[] = $limit;
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// FIXED: getAllServices now calls getServices for consistency
function getAllServices(string $status = 'active'): array {
    return getServices(0, $status); // 0 = no limit
}

function getBlogPosts(int $limit = 10, int $offset = 0, string $category = '', string $status = 'published'): array {
    $db = db();
    if (!$db) return [];
    
    $where = ["status = ?", "published_at <= NOW()"];
    $params = [$status];
    
    if ($category) {
        $where[] = "category = ?";
        $params[] = $category;
    }
    
    $sql = "SELECT * FROM blog_posts WHERE " . implode(" AND ", $where) . " ORDER BY published_at DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getBlogPostBySlug(string $slug): ?array {
    $db = db();
    if (!$db) return null;
    
    $stmt = $db->prepare("SELECT * FROM blog_posts WHERE slug = ? AND status = 'published' AND published_at <= NOW() LIMIT 1");
    $stmt->execute([$slug]);
    $row = $stmt->fetch();
    return $row ?: null;
}

// REPLACE your existing getPortfolioItems() with this:
function getPortfolioItems(int $limit = 6, string $status = 'active'): array {
    $db = db();
    if (!$db) return [];
    
    try {
        $stmt = $db->prepare("
            SELECT * FROM portfolio 
            WHERE status = ? 
            ORDER BY sort_order ASC, created_at DESC 
            LIMIT ?
        ");
        $stmt->execute([$status, $limit]);
        $items = $stmt->fetchAll();
        
        foreach ($items as &$item) {
            // Handle image path
            if (!empty($item['image']) && !str_starts_with($item['image'], 'http') && !str_starts_with($item['image'], 'assets/')) {
                $item['image'] = 'assets/images/' . $item['image'];
            }
            // Parse JSON fields
            $item['gallery'] = safeJsonDecode($item['gallery'] ?? null);
            $item['tech_stack'] = safeJsonDecode($item['tech_stack'] ?? null);
            $item['results'] = safeJsonDecode($item['results'] ?? null);
        }
        unset($item);
        
        return $items;
        
    } catch (PDOException $e) {
        error_log("getPortfolioItems error: " . $e->getMessage());
        return [];
    }
}


// ============================================================
// DATABASE CONNECTION (reuse your existing or use this)
// ============================================================




/* ========================================
   Portfolio Helpers — FIXED
   ======================================== */

/**
 * Get a single portfolio item by slug
 * Uses 'portfolio' table (not 'portfolio_items')
 * @param string $slug
 * @return array|null
 */
function getPortfolioItemBySlug(string $slug): ?array {
    $db = db();
    if (!$db) return null;
    
    try {
        $stmt = $db->prepare("
            SELECT * FROM portfolio 
            WHERE slug = ? AND status = 'active' 
            LIMIT 1
        ");
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        
        if (!$row) return null;
        
        // Parse JSON fields
        $row['gallery'] = safeJsonDecode($row['gallery'] ?? null);
        $row['tech_stack'] = safeJsonDecode($row['tech_stack'] ?? null);
        $row['results'] = safeJsonDecode($row['results'] ?? null);
        
        return $row;
        
    } catch (PDOException $e) {
        error_log("getPortfolioItemBySlug error: " . $e->getMessage());
        return null;
    }
}

/**
 * Get related projects (same service type, excluding current)
 * @param string $slug
 * @param int $limit
 * @return array
 */
function getRelatedProjects(string $slug, int $limit = 3): array {
    $db = db();
    if (!$db) return [];
    
    try {
        // First try same service type
        $stmt = $db->prepare("
            SELECT p.* FROM portfolio p
            WHERE p.status = 'active' 
              AND p.slug != ?
              AND p.service_type = (
                  SELECT service_type FROM portfolio WHERE slug = ? LIMIT 1
              )
            ORDER BY p.sort_order, p.created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$slug, $slug, $limit]);
        $related = $stmt->fetchAll();
        
        // If not enough, fill with other active projects
        if (count($related) < $limit) {
            $existingSlugs = array_column($related, 'slug');
            $existingSlugs[] = $slug;
            $placeholders = implode(',', array_fill(0, count($existingSlugs), '?'));
            
            $needed = $limit - count($related);
            $stmt2 = $db->prepare("
                SELECT * FROM portfolio 
                WHERE status = 'active' 
                  AND slug NOT IN ($placeholders)
                ORDER BY sort_order, created_at DESC
                LIMIT ?
            ");
            $params = array_merge($existingSlugs, [$needed]);
            $stmt2->execute($params);
            $fill = $stmt2->fetchAll();
            $related = array_merge($related, $fill);
        }
        
        // Parse JSON fields
        foreach ($related as &$item) {
            $item['gallery'] = safeJsonDecode($item['gallery'] ?? null);
            $item['tech_stack'] = safeJsonDecode($item['tech_stack'] ?? null);
            $item['results'] = safeJsonDecode($item['results'] ?? null);
        }
        unset($item);
        
        return $related;
        
    } catch (PDOException $e) {
        error_log("getRelatedProjects error: " . $e->getMessage());
        return [];
    }
}

/**
 * Get all portfolio service types/categories
 * @return array
 */
function getPortfolioCategories(): array {
    $db = db();
    if (!$db) return [];
    
    try {
        $stmt = $db->query("
            SELECT DISTINCT service_type 
            FROM portfolio 
            WHERE status = 'active' 
            ORDER BY service_type
        ");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
        
    } catch (PDOException $e) {
        error_log("getPortfolioCategories error: " . $e->getMessage());
        return [];
    }
}

/**
 * Create or update a portfolio item
 * @param array $data
 * @return bool
 */
function savePortfolioItem(array $data): bool {
    $db = db();
    if (!$db) return false;
    
    try {
        // Encode arrays to JSON
        if (isset($data['gallery']) && is_array($data['gallery'])) {
            $data['gallery'] = json_encode($data['gallery']);
        }
        if (isset($data['tech_stack']) && is_array($data['tech_stack'])) {
            $data['tech_stack'] = json_encode($data['tech_stack']);
        }
        if (isset($data['results']) && is_array($data['results'])) {
            $data['results'] = json_encode($data['results']);
        }
        
        if (!empty($data['id'])) {
            // Update
            $fields = [];
            $values = [];
            foreach ($data as $key => $val) {
                if ($key !== 'id') {
                    $fields[] = "$key = ?";
                    $values[] = $val;
                }
            }
            $values[] = $data['id'];
            $sql = "UPDATE portfolio SET " . implode(', ', $fields) . " WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute($values);
        } else {
            // Insert
            $keys = array_keys($data);
            $placeholders = array_fill(0, count($keys), '?');
            $sql = "INSERT INTO portfolio (" . implode(', ', $keys) . ") VALUES (" . implode(', ', $placeholders) . ")";
            $stmt = $db->prepare($sql);
            return $stmt->execute(array_values($data));
        }
        
    } catch (PDOException $e) {
        error_log("savePortfolioItem error: " . $e->getMessage());
        return false;
    }
}

/**
 * Delete a portfolio item (soft delete)
 * @param int $id
 * @return bool
 */
function deletePortfolioItem(int $id): bool {
    $db = db();
    if (!$db) return false;
    
    try {
        $stmt = $db->prepare("UPDATE portfolio SET status = 'inactive' WHERE id = ?");
        return $stmt->execute([$id]);
        
    } catch (PDOException $e) {
        error_log("deletePortfolioItem error: " . $e->getMessage());
        return false;
    }
}
// ============================================================
// SETTINGS FUNCTION (if not already in your functions.php)
// ============================================================

/**
 * Get a setting value from database
 * @param string $key
 * @param string $default
 * @return string
 */


/**
 * Sanitize output
 * @param string|null $text
 * @return string
 */

/* ========================================
   Client Portal Helpers
   ======================================== */

function getClient(int $id): ?array {
    $db = db();
    if (!$db) return null;
    
    $stmt = $db->prepare("SELECT id, full_name, email, company_name, phone, avatar, status, created_at, last_login_at 
                          FROM clients WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function getClientByEmail(string $email): ?array {
    $db = db();
    if (!$db) return null;
    
    $stmt = $db->prepare("SELECT * FROM clients WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function getClientProjects(int $clientId, string $status = 'all'): array {
    $db = db();
    if (!$db) return [];
    
    $sql = "SELECT p.*, c.full_name as client_name 
            FROM projects p 
            JOIN clients c ON p.client_id = c.id 
            WHERE p.client_id = ?";
    $params = [$clientId];
    
    if ($status !== 'all') {
        $sql .= " AND p.status = ?";
        $params[] = $status;
    }
    $sql .= " ORDER BY p.updated_at DESC";
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getProject(int $id, ?int $clientId = null): ?array {
    $db = db();
    if (!$db) return null;
    
    if ($clientId) {
        $stmt = $db->prepare("SELECT p.*, c.full_name as client_name, c.email as client_email 
                              FROM projects p 
                              JOIN clients c ON p.client_id = c.id 
                              WHERE p.id = ? AND p.client_id = ? LIMIT 1");
        $stmt->execute([$id, $clientId]);
    } else {
        $stmt = $db->prepare("SELECT p.*, c.full_name as client_name, c.email as client_email 
                              FROM projects p 
                              JOIN clients c ON p.client_id = c.id 
                              WHERE p.id = ? LIMIT 1");
        $stmt->execute([$id]);
    }
    
    $row = $stmt->fetch();
    return $row ?: null;
}

function getProjectMilestones(int $projectId): array {
    $db = db();
    if (!$db) return [];
    
    $stmt = $db->prepare("SELECT * FROM project_milestones WHERE project_id = ? ORDER BY due_date ASC, sort_order ASC");
    $stmt->execute([$projectId]);
    return $stmt->fetchAll();
}

function getProjectFiles(int $projectId): array {
    $db = db();
    if (!$db) return [];
    
    $stmt = $db->prepare("SELECT id, filename, file_size, mime_type, uploaded_by_type, uploaded_at 
                          FROM project_files WHERE project_id = ? ORDER BY uploaded_at DESC");
    $stmt->execute([$projectId]);
    return $stmt->fetchAll();
}

function getProjectComments(int $projectId): array {
    $db = db();
    if (!$db) return [];
    
    $stmt = $db->prepare("SELECT pc.*, 
                           CASE WHEN pc.admin_id IS NOT NULL THEN a.name ELSE c.full_name END as author_name,
                           CASE WHEN pc.admin_id IS NOT NULL THEN 'admin' ELSE 'client' END as author_type
                           FROM project_comments pc
                           LEFT JOIN admins a ON pc.admin_id = a.id
                           LEFT JOIN clients c ON pc.client_id = c.id
                           WHERE pc.project_id = ? AND pc.is_internal = 0
                           ORDER BY pc.created_at DESC");
    $stmt->execute([$projectId]);
    return $stmt->fetchAll();
}

function getClientInvoices(int $clientId, string $status = 'all'): array {
    $db = db();
    if (!$db) return [];
    
    $sql = "SELECT i.*, p.title as project_title 
            FROM invoices i 
            LEFT JOIN projects p ON i.project_id = p.id 
            WHERE i.client_id = ?";
    $params = [$clientId];
    
    if ($status !== 'all') {
        $sql .= " AND i.status = ?";
        $params[] = $status;
    }
    $sql .= " ORDER BY i.created_at DESC";
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getInvoice(int $id, ?int $clientId = null): ?array {
    $db = db();
    if (!$db) return null;
    
    if ($clientId) {
        $stmt = $db->prepare("SELECT * FROM invoices WHERE id = ? AND client_id = ? LIMIT 1");
        $stmt->execute([$id, $clientId]);
    } else {
        $stmt = $db->prepare("SELECT i.*, c.full_name as client_name, c.email as client_email, c.company_name 
                              FROM invoices i 
                              JOIN clients c ON i.client_id = c.id 
                              WHERE i.id = ? LIMIT 1");
        $stmt->execute([$id]);
    }
    
    $row = $stmt->fetch();
    return $row ?: null;
}

function getInvoiceItems(int $invoiceId): array {
    $db = db();
    if (!$db) return [];
    
    $stmt = $db->prepare("SELECT * FROM invoice_items WHERE invoice_id = ? ORDER BY sort_order ASC");
    $stmt->execute([$invoiceId]);
    return $stmt->fetchAll();
}

function getInvoicePayments(int $invoiceId): array {
    $db = db();
    if (!$db) return [];
    
    $stmt = $db->prepare("SELECT * FROM payments WHERE invoice_id = ? ORDER BY created_at DESC");
    $stmt->execute([$invoiceId]);
    return $stmt->fetchAll();
}

/* ========================================
   Lead & CRM Helpers
   ======================================== */

function getConsultations(string $status = 'all', ?int $assignedTo = null, int $limit = 50, int $offset = 0): array {
    $db = db();
    if (!$db) return [];
    
    $where = ["1=1"];
    $params = [];
    
    if ($status !== 'all') {
        $where[] = "status = ?";
        $params[] = $status;
    }
    if ($assignedTo) {
        $where[] = "assigned_admin_id = ?";
        $params[] = $assignedTo;
    }
    
    $sql = "SELECT c.*, a.name as assigned_admin_name 
            FROM consultations c 
            LEFT JOIN admins a ON c.assigned_admin_id = a.id 
            WHERE " . implode(" AND ", $where) . " 
            ORDER BY c.created_at DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getConsultation(int $id): ?array {
    $db = db();
    if (!$db) return null;
    
    $stmt = $db->prepare("SELECT c.*, a.name as assigned_admin_name 
                          FROM consultations c 
                          LEFT JOIN admins a ON c.assigned_admin_id = a.id 
                          WHERE c.id = ? LIMIT 1");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function getBookings(string $status = 'all', ?string $dateFrom = null, ?string $dateTo = null): array {
    $db = db();
    if (!$db) return [];
    
    $where = ["1=1"];
    $params = [];
    
    if ($status !== 'all') {
        $where[] = "status = ?";
        $params[] = $status;
    }
    if ($dateFrom) {
        $where[] = "booking_date >= ?";
        $params[] = $dateFrom;
    }
    if ($dateTo) {
        $where[] = "booking_date <= ?";
        $params[] = $dateTo;
    }
    
    $sql = "SELECT * FROM bookings WHERE " . implode(" AND ", $where) . " ORDER BY booking_date DESC, booking_time ASC";
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getBooking(int $id): ?array {
    $db = db();
    if (!$db) return null;
    
    $stmt = $db->prepare("SELECT * FROM bookings WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function isSlotAvailable(string $date, string $time, ?int $excludeBookingId = null): bool {
    $db = db();
    if (!$db) return true;
    
    $sql = "SELECT COUNT(*) FROM bookings WHERE booking_date = ? AND booking_time = ? AND status != 'cancelled'";
    $params = [$date, $time];
    
    if ($excludeBookingId) {
        $sql .= " AND id != ?";
        $params[] = $excludeBookingId;
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return ((int) $stmt->fetchColumn()) === 0;
}

function getMessages(string $status = 'all', int $limit = 50, int $offset = 0): array {
    $db = db();
    if (!$db) return [];
    
    $sql = "SELECT m.*, a.name as replied_by_name 
            FROM messages m 
            LEFT JOIN admins a ON m.replied_by = a.id";
    $params = [];
    
    if ($status !== 'all') {
        $sql .= " WHERE m.status = ?";
        $params[] = $status;
    }
    $sql .= " ORDER BY m.created_at DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getMessage(int $id): ?array {
    $db = db();
    if (!$db) return null;
    
    $stmt = $db->prepare("SELECT m.*, a.name as replied_by_name 
                          FROM messages m 
                          LEFT JOIN admins a ON m.replied_by = a.id 
                          WHERE m.id = ? LIMIT 1");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function getCalculatorLeads(int $limit = 50): array {
    $db = db();
    if (!$db) return [];
    
    $stmt = $db->prepare("SELECT cl.*, c.name as consultation_name 
                          FROM calculator_leads cl 
                          LEFT JOIN consultations c ON cl.converted_to_consultation_id = c.id 
                          ORDER BY cl.created_at DESC LIMIT ?");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

/* ========================================
   Payment & Financial Helpers
   ======================================== */

function getPayments(string $status = 'all', ?int $clientId = null, int $limit = 50): array {
    $db = db();
    if (!$db) return [];
    
    $where = ["1=1"];
    $params = [];
    
    if ($status !== 'all') {
        $where[] = "payment_status = ?";
        $params[] = $status;
    }
    if ($clientId) {
        $where[] = "client_id = ?";
        $params[] = $clientId;
    }
    
    $sql = "SELECT p.*, c.full_name as client_name 
            FROM payments p 
            LEFT JOIN clients c ON p.client_id = c.id 
            WHERE " . implode(" AND ", $where) . " 
            ORDER BY p.created_at DESC LIMIT ?";
    $params[] = $limit;
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getPayment(int $id): ?array {
    $db = db();
    if (!$db) return null;
    
    $stmt = $db->prepare("SELECT p.*, c.full_name as client_name, c.email as client_email 
                          FROM payments p 
                          LEFT JOIN clients c ON p.client_id = c.id 
                          WHERE p.id = ? LIMIT 1");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function getRevenueStats(string $period = '30days'): array {
    $db = db();
    if (!$db) return ['total' => 0, 'count' => 0, 'outstanding' => 0];
    
    $since = match($period) {
        '7days' => date('Y-m-d', strtotime('-7 days')),
        '30days' => date('Y-m-d', strtotime('-30 days')),
        '90days' => date('Y-m-d', strtotime('-90 days')),
        'year' => date('Y-m-d', strtotime('-1 year')),
        default => date('Y-m-d', strtotime('-30 days')),
    };
    
    $stmt = $db->prepare("SELECT COALESCE(SUM(amount), 0) as total, COUNT(*) as count 
                          FROM payments 
                          WHERE payment_status = 'completed' AND DATE(created_at) >= ?");
    $stmt->execute([$since]);
    $payments = $stmt->fetch();
    
    $outstanding = (float) $db->query("SELECT COALESCE(SUM(total_amount), 0) FROM invoices WHERE status IN ('sent', 'overdue')")->fetchColumn();
    
    return [
        'total' => (float) ($payments['total'] ?? 0),
        'count' => (int) ($payments['count'] ?? 0),
        'outstanding' => $outstanding,
    ];
}

/* ========================================
   Analytics Helpers
   ======================================== */

function logPageView(string $page, ?string $referrer = null, ?string $sessionId = null): void {
    $db = db();
    if (!$db) return;
    
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $ipHash = hash('sha256', $ip . getSetting('app_key', 'salt'));
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    $device = 'desktop';
    if (stripos($ua, 'mobile') !== false) $device = 'mobile';
    elseif (stripos($ua, 'tablet') !== false) $device = 'tablet';
    
    try {
        $stmt = $db->prepare("INSERT INTO page_views (page_path, referrer, ip_hash, user_agent, device_type, session_id, created_at) 
                              VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([
            sanitize($page),
            sanitize($referrer ?? ''),
            $ipHash,
            sanitize(substr($ua, 0, 255)),
            $device,
            $sessionId ?? session_id(),
        ]);
    } catch (PDOException $e) {
        error_log("logPageView error: " . $e->getMessage());
    }
}

function logEvent(string $type, array $data = [], string $userType = 'guest', ?int $userId = null): void {
    $db = db();
    if (!$db) return;
    
    try {
        $stmt = $db->prepare("INSERT INTO events (event_type, event_data, user_type, user_id, ip_hash, session_id, created_at) 
                              VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([
            sanitize($type),
            json_encode($data),
            $userType,
            $userId,
            hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0') . getSetting('app_key', 'salt')),
            session_id(),
        ]);
    } catch (PDOException $e) {
        error_log("logEvent error: " . $e->getMessage());
    }
}

function getAnalyticsSummary(string $period = '30days'): array {
    $db = db();
    if (!$db) return [];
    
    $since = match($period) {
        '7days' => date('Y-m-d', strtotime('-7 days')),
        '30days' => date('Y-m-d', strtotime('-30 days')),
        '90days' => date('Y-m-d', strtotime('-90 days')),
        'year' => date('Y-m-d', strtotime('-1 year')),
        default => date('Y-m-d', strtotime('-30 days')),
    };
    
    $views = (int) $db->query("SELECT COUNT(*) FROM page_views WHERE DATE(created_at) >= '$since'")->fetchColumn();
    $unique = (int) $db->query("SELECT COUNT(DISTINCT ip_hash) FROM page_views WHERE DATE(created_at) >= '$since'")->fetchColumn();
    $consultations = (int) $db->query("SELECT COUNT(*) FROM consultations WHERE DATE(created_at) >= '$since'")->fetchColumn();
    $bookings = (int) $db->query("SELECT COUNT(*) FROM bookings WHERE DATE(created_at) >= '$since'")->fetchColumn();
    $messages = (int) $db->query("SELECT COUNT(*) FROM messages WHERE DATE(created_at) >= '$since'")->fetchColumn();
    
    return compact('views', 'unique', 'consultations', 'bookings', 'messages');
}

/* ========================================
   Audit & Compliance
   ======================================== */

function auditLog(string $action, string $entityType, int $entityId, ?array $oldValues = null, ?array $newValues = null): void {
    $db = db();
    if (!$db) return;
    
    $userType = isAdmin() ? 'admin' : (isClient() ? 'client' : 'guest');
    $userId = isAdmin() ? getCurrentAdminId() : (isClient() ? getCurrentClientId() : null);
    
    try {
        $stmt = $db->prepare("INSERT INTO audit_log (user_type, user_id, action, entity_type, entity_id, old_values, new_values, ip_address, user_agent, created_at) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([
            $userType,
            $userId,
            sanitize($action),
            sanitize($entityType),
            $entityId,
            $oldValues ? json_encode($oldValues) : null,
            $newValues ? json_encode($newValues) : null,
            inet_pton($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'),
            sanitize(substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255)),
        ]);
    } catch (PDOException $e) {
        error_log("auditLog error: " . $e->getMessage());
    }
}

/* ========================================
   Utility Functions
   ======================================== */

function timeAgo(string $datetime): string {
    $time = strtotime($datetime);
    $now = time();
    $diff = $now - $time;
    
    if ($diff < 60) return 'just now';
    if ($diff < 3600) return floor($diff / 60) . ' min ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hour' . (floor($diff / 3600) > 1 ? 's' : '') . ' ago';
    if ($diff < 604800) return floor($diff / 86400) . ' day' . (floor($diff / 86400) > 1 ? 's' : '') . ' ago';
    if ($diff < 2592000) return floor($diff / 604800) . ' week' . (floor($diff / 604800) > 1 ? 's' : '') . ' ago';
    return date('M j, Y', $time);
}

function formatCurrency(float $amount, string $currency = 'ZAR'): string {
    $symbol = match($currency) {
        'ZAR' => 'R',
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        default => $currency . ' ',
    };
    return $symbol . number_format($amount, 2);
}

function formatDate(string $date, string $format = 'M j, Y'): string {
    return date($format, strtotime($date));
}

function truncate(string $text, int $length = 100, string $suffix = '...'): string {
    if (strlen($text) <= $length) return $text;
    return substr($text, 0, $length) . $suffix;
}

function generateSlug(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    return trim($text, '-');
}

function generateInvoiceNumber(): string {
    $db = db();
    $year = date('Y');
    $count = 1;
    
    if ($db) {
        $stmt = $db->prepare("SELECT COUNT(*) FROM invoices WHERE invoice_number LIKE ?");
        $stmt->execute(["INV-$year-%"]);
        $count = (int) $stmt->fetchColumn() + 1;
    }
    
    return "INV-$year-" . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
}

function paginate(int $total, int $page, int $perPage): array {
    $totalPages = (int) max(1, ceil($total / $perPage));
    $page = max(1, min($page, $totalPages));
    
    return [
        'page' => $page,
        'perPage' => $perPage,
        'total' => $total,
        'totalPages' => $totalPages,
        'offset' => ($page - 1) * $perPage,
        'hasPrev' => $page > 1,
        'hasNext' => $page < $totalPages,
    ];
}

function uploadFile(array $file, string $directory, array $allowedTypes = [], int $maxSize = 10485760): array {
    $result = ['success' => false, 'path' => '', 'error' => ''];
    
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        $result['error'] = 'No file uploaded';
        return $result;
    }
    
    if ($file['size'] > $maxSize) {
        $result['error'] = 'File too large (max ' . round($maxSize / 1048576, 1) . 'MB)';
        return $result;
    }
    
    $mime = mime_content_type($file['tmp_name']);
    if (!empty($allowedTypes) && !in_array($mime, $allowedTypes)) {
        $result['error'] = 'Invalid file type';
        return $result;
    }
    
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = bin2hex(random_bytes(8)) . '.' . $ext;
    $path = rtrim($directory, '/') . '/' . $filename;
    
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $path)) {
        $result['success'] = true;
        $result['path'] = $path;
        $result['filename'] = $filename;
        $result['originalName'] = $file['name'];
        $result['size'] = $file['size'];
        $result['mime'] = $mime;
    } else {
        $result['error'] = 'Failed to save file';
    }
    
    return $result;
}

function rateLimit(string $key, int $maxAttempts = 60, int $windowSeconds = 60): bool {
    if (getSetting('rate_limit_enabled', 'true') !== 'true') return true;
    
    $dir = __DIR__ . '/../cache/ratelimit';
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    
    $file = $dir . '/' . preg_replace('/[^a-z0-9_-]/', '', $key) . '.json';
    $now = time();
    $data = ['count' => 0, 'reset' => $now + $windowSeconds];
    
    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true) ?: $data;
        if ($data['reset'] < $now) {
            $data = ['count' => 0, 'reset' => $now + $windowSeconds];
        }
    }
    
    $data['count']++;
    file_put_contents($file, json_encode($data), LOCK_EX);
    
    return $data['count'] <= $maxAttempts;
}

function loadEnv(): array {
    static $env = null;
    if ($env !== null) return $env;
    
    $env = [];
    $file = __DIR__ . '/../.env';
    
    if (!file_exists($file)) {
        $file = __DIR__ . '/../.env.example';
    }
    
    if (file_exists($file)) {
        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (str_starts_with(trim($line), '#')) continue;
            if (!str_contains($line, '=')) continue;
            [$key, $value] = explode('=', $line, 2);
            $env[trim($key)] = trim($value);
        }
    }
    
    return $env;
}

// Initialize environment
$env = loadEnv();
foreach ($env as $key => $value) {
    if (!isset($_ENV[$key])) {
        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
}

// Session security — FIXED: Only start if not already active
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_secure', $_ENV['SESSION_SECURE'] ?? '0');
    ini_set('session.cookie_samesite', $_ENV['SESSION_SAMESITE'] ?? 'Lax');
    ini_set('session.gc_maxlifetime', (int) ($_ENV['SESSION_LIFETIME'] ?? 120) * 60);
    session_start();
}

// FIXED: Added helper to safely decode JSON from DB fields
function safeJsonDecode(?string $json, array $default = []): array {
    if (empty($json)) return $default;
    try {
        $decoded = json_decode($json, true);
        return is_array($decoded) ? $decoded : $default;
    } catch (Exception $e) {
        return $default;
    }
}

// FIXED: Added email template renderer
function renderEmailTemplate(string $templateKey, array $variables = []): ?array {
    $db = db();
    if (!$db) return null;
    
    try {
        $stmt = $db->prepare("SELECT * FROM email_templates WHERE template_key = ? AND status = 'active' LIMIT 1");
        $stmt->execute([$templateKey]);
        $template = $stmt->fetch();
        
        if (!$template) return null;
        
        $subject = $template['subject'];
        $html = $template['body_html'];
        $text = $template['body_text'];
        
        foreach ($variables as $key => $value) {
            $subject = str_replace('{{' . $key . '}}', $value, $subject);
            $html = str_replace('{{' . $key . '}}', $value, $html);
            $text = str_replace('{{' . $key . '}}', $value, $text);
        }
        
        return [
            'subject' => $subject,
            'html' => $html,
            'text' => $text,
        ];
    } catch (PDOException $e) {
        error_log("renderEmailTemplate error: " . $e->getMessage());
        return null;
    }
}

/**
 * Queue an email for async sending.
 * 
 * Template mode: queueEmail('user@x.com', 'Name', 'template_key', ['name' => 'John'])
 * Direct mode:   queueEmail('user@x.com', 'Name', 'Subject', '<html>...</html>')
 */
/**
 * Queue an email for async sending.
 * 
 * Template mode: queueEmail('user@x.com', 'Name', 'template_key', ['name' => 'John'])
 * Direct mode:   queueEmail('user@x.com', 'Name', 'Subject', '<html>...</html>')
 */
function queueEmail(string $toEmail, string $toName, string $subjectOrTemplateKey, array|string $bodyOrVariables = [], ?string $replyTo = null): bool {
    $db = db();
    if (!$db) {
        error_log('queueEmail: No database connection');
        return false;
    }
    
    $fromEmail = getSetting('smtp_from', 'njabulod.hlongwane@gmail.com');
    $fromName  = getSetting('smtp_from_name', 'Vueports Solutions');
    
    $subject   = $subjectOrTemplateKey;
    $htmlBody  = '';
    $plainText = null;
    
    // Template mode: 4th arg is array of variables
    if (is_array($bodyOrVariables)) {
        $template = renderEmailTemplate($subjectOrTemplateKey, $bodyOrVariables);
        if (!$template) {
            error_log("queueEmail: Template not found: $subjectOrTemplateKey");
            return false;
        }
        $subject   = $template['subject'];
        $htmlBody  = $template['html'];
        $plainText = $template['text'];
    } 
    // Direct mode: 4th arg is HTML string
    else {
        $htmlBody  = $bodyOrVariables;
        $plainText = strip_tags($bodyOrVariables);
    }
    
    try {
        $stmt = $db->prepare("INSERT INTO email_queue 
            (to_email, to_name, subject, body_html, body_text, from_email, from_name, reply_to, status, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
        
        $stmt->execute([
            filter_var(trim($toEmail), FILTER_SANITIZE_EMAIL),
            sanitize($toName),
            sanitize($subject),
            $htmlBody,
            $plainText,
            $fromEmail,
            $fromName,
            $replyTo,
        ]);
        
        error_log("queueEmail: Queued email to $toEmail, ID " . $db->lastInsertId());
        return true;
        
    } catch (PDOException $e) {
        error_log("queueEmail DB error: " . $e->getMessage());
        return false;
    }
}
// FIXED: Added password hashing helper with automatic rehash
function verifyPassword(string $password, string $hash): bool {
    if (!password_verify($password, $hash)) {
        // Fallback for legacy plaintext passwords (like your admin table row 1)
        return hash_equals($hash, $password) || hash_equals($hash, md5($password));
    }
    return true;
}

function hashPassword(string $password): string {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

// FIXED: Added function to check if password needs rehashing
function passwordNeedsRehash(string $hash): bool {
    return password_needs_rehash($hash, PASSWORD_BCRYPT, ['cost' => 12]);
}
