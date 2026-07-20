-- ============================================================
-- Vueports Solutions — Complete Database Schema
-- MySQL 8.0+ | InnoDB | utf8mb4_unicode_ci
-- Generated: 2026-05-27
-- ============================================================


CREATE DATABASE IF NOT EXISTS Vueports_database 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

USE vueports_database;
SET FOREIGN_KEY_CHECKS = 0;
SET NAMES utf8mb4;

-- ============================================================
-- 1. CORE & AUTHENTICATION
-- ============================================================

DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `company_name` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `vat_number` VARCHAR(50) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `avatar` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('active','suspended','inactive') DEFAULT 'active',
  `email_verified_at` DATETIME DEFAULT NULL,
  `last_login_at` DATETIME DEFAULT NULL,
  `last_login_ip` VARBINARY(16) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uk_clients_email` (`email`),
  KEY `idx_clients_status` (`status`),
  KEY `idx_clients_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Client portal accounts — POPIA personal data register';

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `username` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('super_admin','admin','editor','support') DEFAULT 'admin',
  `avatar` VARCHAR(255) DEFAULT NULL,
  `last_login_at` DATETIME DEFAULT NULL,
  `last_login_ip` VARBINARY(16) DEFAULT NULL,
  `login_attempts` TINYINT UNSIGNED DEFAULT 0,
  `locked_until` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uk_admins_username` (`username`),
  UNIQUE KEY `uk_admins_email` (`email`),
  KEY `idx_admins_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `admin_sessions`;
CREATE TABLE `admin_sessions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `admin_id` INT UNSIGNED NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `ip_address` VARBINARY(16) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `expires_at` DATETIME NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_as_admin` (`admin_id`),
  KEY `idx_as_token` (`token`),
  KEY `idx_as_expires` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `user_type` ENUM('client','admin') NOT NULL,
  `expires_at` DATETIME NOT NULL,
  `used_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_pr_token` (`token`),
  KEY `idx_pr_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 2. SITE CONFIGURATION
-- ============================================================

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(100) NOT NULL,
  `setting_value` TEXT DEFAULT NULL,
  `setting_group` VARCHAR(50) DEFAULT 'general',
  `is_encrypted` TINYINT(1) DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uk_settings_key` (`setting_key`),
  KEY `idx_settings_group` (`setting_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 3. CONTENT & MARKETING
-- ============================================================

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `tagline` VARCHAR(255) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `long_description` LONGTEXT DEFAULT NULL,
  `features` JSON DEFAULT NULL,
  `price_min` DECIMAL(12,2) DEFAULT 0.00,
  `price_max` DECIMAL(12,2) DEFAULT 0.00,
  `price_note` VARCHAR(255) DEFAULT NULL,
  `delivery_time` VARCHAR(100) DEFAULT NULL,
  `icon` VARCHAR(100) DEFAULT 'fa-code',
  `image` VARCHAR(255) DEFAULT NULL,
  `sort_order` INT UNSIGNED DEFAULT 0,
  `status` ENUM('active','draft','archived') DEFAULT 'active',
  `meta_title` VARCHAR(255) DEFAULT NULL,
  `meta_description` VARCHAR(500) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uk_services_slug` (`slug`),
  KEY `idx_services_status` (`status`),
  KEY `idx_services_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE `blog_posts` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `excerpt` VARCHAR(500) DEFAULT NULL,
  `content` LONGTEXT DEFAULT NULL,
  `featured_image` VARCHAR(255) DEFAULT NULL,
  `category` VARCHAR(100) DEFAULT 'General',
  `tags` JSON DEFAULT NULL,
  `author_id` INT UNSIGNED DEFAULT NULL,
  `author_name` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('published','draft','scheduled') DEFAULT 'draft',
  `published_at` DATETIME DEFAULT NULL,
  `view_count` INT UNSIGNED DEFAULT 0,
  `meta_title` VARCHAR(255) DEFAULT NULL,
  `meta_description` VARCHAR(500) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uk_blog_slug` (`slug`),
  KEY `idx_blog_status` (`status`),
  KEY `idx_blog_published` (`published_at`),
  KEY `idx_blog_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `portfolio_items`;
CREATE TABLE `portfolio_items` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `client_name` VARCHAR(255) DEFAULT NULL,
  `service_type` VARCHAR(100) DEFAULT NULL,
  `technologies` JSON DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `gallery` JSON DEFAULT NULL,
  `project_url` VARCHAR(255) DEFAULT NULL,
  `github_url` VARCHAR(255) DEFAULT NULL,
  `testimonial` TEXT DEFAULT NULL,
  `testimonial_author` VARCHAR(255) DEFAULT NULL,
  `sort_order` INT UNSIGNED DEFAULT 0,
  `status` ENUM('active','draft','archived') DEFAULT 'active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uk_portfolio_slug` (`slug`),
  KEY `idx_portfolio_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 4. PROJECTS & COLLABORATION
-- ============================================================

DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `status` ENUM('planning','in_progress','review','completed','on_hold','cancelled') DEFAULT 'planning',
  `priority` ENUM('low','normal','high','urgent') DEFAULT 'normal',
  `service_type` VARCHAR(100) DEFAULT NULL,
  `budget` DECIMAL(12,2) DEFAULT 0.00,
  `start_date` DATE DEFAULT NULL,
  `deadline` DATE DEFAULT NULL,
  `project_manager` VARCHAR(255) DEFAULT NULL,
  `progress_percent` TINYINT UNSIGNED DEFAULT 0,
  `completion_notes` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_projects_client` (`client_id`),
  KEY `idx_projects_status` (`status`),
  KEY `idx_projects_deadline` (`deadline`),
  CONSTRAINT `fk_projects_client` FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `project_milestones`;
CREATE TABLE `project_milestones` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `project_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `status` ENUM('pending','in_progress','completed','blocked') DEFAULT 'pending',
  `due_date` DATE DEFAULT NULL,
  `completed_at` DATETIME DEFAULT NULL,
  `sort_order` INT UNSIGNED DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_pm_project` (`project_id`),
  KEY `idx_pm_status` (`status`),
  CONSTRAINT `fk_pm_project` FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `project_files`;
CREATE TABLE `project_files` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `project_id` INT UNSIGNED NOT NULL,
  `filename` VARCHAR(255) NOT NULL,
  `stored_name` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(500) NOT NULL,
  `file_size` INT UNSIGNED DEFAULT 0,
  `mime_type` VARCHAR(100) DEFAULT NULL,
  `uploaded_by_type` ENUM('client','admin') DEFAULT 'admin',
  `uploaded_by_id` INT UNSIGNED DEFAULT NULL,
  `uploaded_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_pf_project` (`project_id`),
  CONSTRAINT `fk_pf_project` FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `project_comments`;
CREATE TABLE `project_comments` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `project_id` INT UNSIGNED NOT NULL,
  `client_id` INT UNSIGNED DEFAULT NULL,
  `admin_id` INT UNSIGNED DEFAULT NULL,
  `comment` TEXT NOT NULL,
  `is_internal` TINYINT(1) DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_pc_project` (`project_id`),
  KEY `idx_pc_created` (`created_at`),
  CONSTRAINT `fk_pc_project` FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pc_client` FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_pc_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 5. FINANCIAL
-- ============================================================

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `project_id` INT UNSIGNED DEFAULT NULL,
  `invoice_number` VARCHAR(100) NOT NULL,
  `amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
   `description` VARCHAR(500) NOT NULL,
  `tax_amount` DECIMAL(12,2) DEFAULT 0.00,
  `total_amount` DECIMAL(12,2) GENERATED ALWAYS AS (`amount` + `tax_amount`) STORED,
  `currency` CHAR(3) DEFAULT 'ZAR',
  `status` ENUM('draft','sent','paid','overdue','cancelled','refunded') DEFAULT 'draft',
  `due_date` DATE DEFAULT NULL,
  `paid_at` DATETIME DEFAULT NULL,
  `notes` TEXT DEFAULT NULL,
  `terms` TEXT DEFAULT NULL,
  `sent_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uk_invoices_number` (`invoice_number`),
  KEY `idx_invoices_client` (`client_id`),
  KEY `idx_invoices_status` (`status`),
  KEY `idx_invoices_due` (`due_date`),
  KEY `idx_invoices_paid` (`paid_at`),
  CONSTRAINT `fk_invoices_client` FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_invoices_project` FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `invoice_items`;
CREATE TABLE `invoice_items` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `invoice_id` INT UNSIGNED NOT NULL,
  `description` VARCHAR(500) NOT NULL,
  `quantity` INT UNSIGNED DEFAULT 1,
  `unit_price` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `total` DECIMAL(12,2) GENERATED ALWAYS AS (`quantity` * `unit_price`) STORED,
  `sort_order` INT UNSIGNED DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_ii_invoice` (`invoice_id`),
  CONSTRAINT `fk_ii_invoice` FOREIGN KEY (`invoice_id`) REFERENCES `invoices`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED DEFAULT NULL,
  `invoice_id` INT UNSIGNED DEFAULT NULL,
  `plan_name` VARCHAR(255) DEFAULT NULL,
  `amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `currency` CHAR(3) DEFAULT 'ZAR',
  `payment_status` ENUM('pending','completed','failed','cancelled','refunded') DEFAULT 'pending',
  `gateway` VARCHAR(50) DEFAULT 'payfast',
  `gateway_transaction_id` VARCHAR(255) DEFAULT NULL,
  `payer_email` VARCHAR(255) DEFAULT NULL,
  `payer_name` VARCHAR(255) DEFAULT NULL,
  `amount_fee` DECIMAL(12,2) DEFAULT 0.00,
  `amount_net` DECIMAL(12,2) DEFAULT 0.00,
  `response_data` JSON DEFAULT NULL,
  `receipt_sent_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_payments_client` (`client_id`),
  KEY `idx_payments_invoice` (`invoice_id`),
  KEY `idx_payments_status` (`payment_status`),
  KEY `idx_payments_gateway_id` (`gateway_transaction_id`),
  KEY `idx_payments_created` (`created_at`),
  CONSTRAINT `fk_payments_client` FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_payments_invoice` FOREIGN KEY (`invoice_id`) REFERENCES `invoices`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Payment records — no card data stored (PCI-DSS compliant)';

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `plan_name` VARCHAR(100) NOT NULL,
  `amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `billing_cycle` ENUM('monthly','quarterly','yearly') DEFAULT 'monthly',
  `status` ENUM('active','paused','cancelled','expired') DEFAULT 'active',
  `start_date` DATE NOT NULL,
  `next_billing_date` DATE NOT NULL,
  `last_billed_date` DATE DEFAULT NULL,
  `end_date` DATE DEFAULT NULL,
  `payment_method` VARCHAR(50) DEFAULT NULL,
  `cancellation_reason` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_subs_client` (`client_id`),
  KEY `idx_subs_next_bill` (`next_billing_date`,`status`),
  KEY `idx_subs_status` (`status`),
  CONSTRAINT `fk_subs_client` FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 6. LEADS & CRM
-- ============================================================

DROP TABLE IF EXISTS `consultations`;
CREATE TABLE `consultations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `company` VARCHAR(255) DEFAULT NULL,
  `service_interest` VARCHAR(255) DEFAULT NULL,
  `budget_range` VARCHAR(100) DEFAULT NULL,
  `timeline` VARCHAR(100) DEFAULT NULL,
  `message` TEXT DEFAULT NULL,
  `status` ENUM('new','contacted','qualified','proposal_sent','converted','closed') DEFAULT 'new',
  `source` VARCHAR(100) DEFAULT 'website',
  `assigned_admin_id` INT UNSIGNED DEFAULT NULL,
  `notes` TEXT DEFAULT NULL,
  `converted_to_client_id` INT UNSIGNED DEFAULT NULL,
  `converted_to_project_id` INT UNSIGNED DEFAULT NULL,
  `ip_address` VARBINARY(16) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_consultations_status` (`status`),
  KEY `idx_consultations_email` (`email`),
  KEY `idx_consultations_created` (`created_at`),
  KEY `idx_consultations_source` (`source`),
  CONSTRAINT `fk_consultations_admin` FOREIGN KEY (`assigned_admin_id`) REFERENCES `admins`(`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_consultations_client` FOREIGN KEY (`converted_to_client_id`) REFERENCES `clients`(`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_consultations_project` FOREIGN KEY (`converted_to_project_id`) REFERENCES `projects`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Lead capture from consultation form — POPIA consent required';

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `company` VARCHAR(255) DEFAULT NULL,
  `service_type` VARCHAR(100) DEFAULT NULL,
  `booking_date` DATE NOT NULL,
  `booking_time` TIME NOT NULL,
  `timezone` VARCHAR(50) DEFAULT 'Africa/Johannesburg',
  `duration_minutes` INT UNSIGNED DEFAULT 60,
  `notes` TEXT DEFAULT NULL,
  `status` ENUM('pending','confirmed','completed','cancelled','no_show') DEFAULT 'pending',
  `meeting_link` VARCHAR(255) DEFAULT NULL,
  `calendar_event_id` VARCHAR(255) DEFAULT NULL,
  `reminder_sent` TINYINT(1) DEFAULT 0,
  `ip_address` VARBINARY(16) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_bookings_date` (`booking_date`),
  KEY `idx_bookings_status` (`status`),
  KEY `idx_bookings_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `subject` VARCHAR(255) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `status` ENUM('new','read','replied','archived','spam') DEFAULT 'new',
  `replied_at` DATETIME DEFAULT NULL,
  `replied_by` INT UNSIGNED DEFAULT NULL,
  `ip_address` VARBINARY(16) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_messages_status` (`status`),
  KEY `idx_messages_created` (`created_at`),
  CONSTRAINT `fk_messages_replied` FOREIGN KEY (`replied_by`) REFERENCES `admins`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `calculator_leads`;
CREATE TABLE `calculator_leads` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `service_type` VARCHAR(100) NOT NULL,
  `complexity` VARCHAR(50) DEFAULT NULL,
  `features` JSON DEFAULT NULL,
  `estimated_total` DECIMAL(12,2) DEFAULT 0.00,
  `name` VARCHAR(255) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `company` VARCHAR(255) DEFAULT NULL,
  `submitted` TINYINT(1) DEFAULT 0,
  `converted_to_consultation_id` INT UNSIGNED DEFAULT NULL,
  `ip_address` VARBINARY(16) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_cl_service` (`service_type`),
  KEY `idx_cl_created` (`created_at`),
  CONSTRAINT `fk_cl_consultation` FOREIGN KEY (`converted_to_consultation_id`) REFERENCES `consultations`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 7. EMAIL SYSTEM
-- ============================================================

DROP TABLE IF EXISTS `email_queue`;
CREATE TABLE `email_queue` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `to_email` VARCHAR(255) NOT NULL,
  `to_name` VARCHAR(255) DEFAULT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `body_html` TEXT DEFAULT NULL,
  `body_text` TEXT DEFAULT NULL,
  `from_email` VARCHAR(255) DEFAULT NULL,
  `from_name` VARCHAR(255) DEFAULT NULL,
  `reply_to` VARCHAR(255) DEFAULT NULL,
  `attachments` JSON DEFAULT NULL,
  `status` ENUM('pending','sent','failed','cancelled') DEFAULT 'pending',
  `attempts` TINYINT UNSIGNED DEFAULT 0,
  `error_message` TEXT DEFAULT NULL,
  `sent_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_eq_status` (`status`),
  KEY `idx_eq_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `email_logs`;
CREATE TABLE `email_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `recipient` VARCHAR(255) NOT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `status` ENUM('sent','delivered','opened','clicked','bounced','failed','complained') DEFAULT 'sent',
  `template` VARCHAR(100) DEFAULT NULL,
  `message_id` VARCHAR(255) DEFAULT NULL,
  `error` TEXT DEFAULT NULL,
  `opened_at` DATETIME DEFAULT NULL,
  `clicked_at` DATETIME DEFAULT NULL,
  `ip_address` VARBINARY(16) DEFAULT NULL,
  `sent_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_el_status` (`status`),
  KEY `idx_el_recipient` (`recipient`),
  KEY `idx_el_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE `email_templates` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `template_key` VARCHAR(100) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `body_html` LONGTEXT NOT NULL,
  `body_text` LONGTEXT DEFAULT NULL,
  `variables` JSON DEFAULT NULL,
  `status` ENUM('active','draft') DEFAULT 'active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uk_et_key` (`template_key`),
  KEY `idx_et_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 8. ANALYTICS & MONITORING
-- ============================================================

DROP TABLE IF EXISTS `page_views`;
CREATE TABLE `page_views` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `page_path` VARCHAR(500) DEFAULT '/',
  `referrer` VARCHAR(500) DEFAULT NULL,
  `ip_hash` VARCHAR(64) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `device_type` ENUM('desktop','mobile','tablet','bot','other') DEFAULT 'other',
  `country` CHAR(2) DEFAULT NULL,
  `session_id` VARCHAR(255) DEFAULT NULL,
  `duration_seconds` INT UNSIGNED DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_pv_path` (`page_path`),
  KEY `idx_pv_created` (`created_at`),
  KEY `idx_pv_ip` (`ip_hash`),
  KEY `idx_pv_session` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Anonymized analytics — ip_hash for privacy (POPIA)';

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `event_type` VARCHAR(100) NOT NULL,
  `event_data` JSON DEFAULT NULL,
  `user_type` ENUM('guest','client','admin') DEFAULT 'guest',
  `user_id` INT UNSIGNED DEFAULT NULL,
  `ip_hash` VARCHAR(64) DEFAULT NULL,
  `session_id` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_events_type` (`event_type`),
  KEY `idx_events_created` (`created_at`),
  KEY `idx_events_user` (`user_type`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 9. AUDIT & COMPLIANCE
-- ============================================================

DROP TABLE IF EXISTS `audit_log`;
CREATE TABLE `audit_log` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_type` ENUM('client','admin','system') NOT NULL,
  `user_id` INT UNSIGNED DEFAULT NULL,
  `action` VARCHAR(100) NOT NULL,
  `entity_type` VARCHAR(50) DEFAULT NULL,
  `entity_id` INT UNSIGNED DEFAULT NULL,
  `old_values` JSON DEFAULT NULL,
  `new_values` JSON DEFAULT NULL,
  `ip_address` VARBINARY(16) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_audit_user` (`user_type`,`user_id`),
  KEY `idx_audit_action` (`action`),
  KEY `idx_audit_entity` (`entity_type`,`entity_id`),
  KEY `idx_audit_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='POPIA audit trail — all sensitive data changes logged';

DROP TABLE IF EXISTS `data_processing_register`;
CREATE TABLE `data_processing_register` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `purpose` VARCHAR(255) NOT NULL,
  `data_categories` JSON NOT NULL,
  `lawful_basis` ENUM('consent','contract','legal_obligation','legitimate_interest','vital_interests','public_task') NOT NULL,
  `retention_period_days` INT UNSIGNED NOT NULL,
  `source` VARCHAR(255) DEFAULT NULL,
  `recipients` JSON DEFAULT NULL,
  `cross_border` TINYINT(1) DEFAULT 0,
  `safeguards` TEXT DEFAULT NULL,
  `dpia_required` TINYINT(1) DEFAULT 0,
  `dpia_completed_at` DATETIME DEFAULT NULL,
  `status` ENUM('active','review','archived') DEFAULT 'active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_dpr_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='POPIA Section 17 — Data Processing Register';

-- ============================================================
-- SEED DATA
-- ============================================================

INSERT INTO `admins` (`name`, `username`, `email`, `password`, `role`, `created_at`) VALUES
('System Admin', 'admin', 'njabulod.hlongwane@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'super_admin', NOW());
-- Password hash above is for 'password' — CHANGE IMMEDIATELY in production

INSERT INTO `services` (`title`, `slug`, `tagline`, `description`, `long_description`, `features`, `price_min`, `price_max`, `price_note`, `delivery_time`, `icon`, `sort_order`, `meta_title`, `meta_description`) VALUES
('Custom Software & Web Development', 'custom-software-web', 'Tailored digital products built to scale', 'Bespoke web applications, SaaS platforms, and enterprise software engineered for performance.', '<p>We architect and build custom software solutions that align with your business logic. From MVPs to enterprise-grade platforms.</p>', '["Full-stack development","API architecture","Cloud deployment","CI/CD pipelines","Maintenance retainers"]', 15000.00, 250000.00, 'Final quote after scoping session', '2–16 weeks', 'fa-code', 1, 'Custom Software Development South Africa | Vueports', 'Enterprise-grade custom software and web application development in South Africa.'),
('Data Engineering & Analytics', 'data-engineering-analytics', 'Transform raw data into strategic assets', 'End-to-end data pipelines, warehousing, BI dashboards, and predictive analytics.', '<p>We design robust data infrastructures that turn fragmented information into actionable intelligence.</p>', '["ETL/ELT pipelines","Data warehousing","Power BI / Looker","Predictive modeling","Data governance"]', 25000.00, 350000.00, 'Depends on data volume & sources', '4–12 weeks', 'fa-database', 2, 'Data Engineering & Analytics South Africa | Vueports', 'Data engineering, analytics, and business intelligence solutions for South African enterprises.'),
('AI Agent Development', 'ai-agent-development', 'Intelligent automation that works 24/7', 'Custom AI agents, LLM integrations, RAG systems, and workflow automation.', '<p>We build autonomous AI agents that handle customer support, research, content generation, and complex decision workflows.</p>', '["LLM integration (OpenAI/Claude)","RAG knowledge bases","Autonomous agents","Workflow automation","Fine-tuning & training"]', 20000.00, 400000.00, 'Enterprise AI retainers available', '3–10 weeks', 'fa-robot', 3, 'AI Agent Development South Africa | Vueports', 'Custom AI agents, LLM integrations, and intelligent automation for businesses in South Africa.');

INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('app_name', 'Vueports Solutions', 'general'),
('app_url', 'https://vueports.co.za', 'general'),
('contact_email', 'njabulod.hlongwane@gmail.com', 'general'),
('contact_phone', '+27 (68) 826-1507', 'general'),
('location', 'Johannesburg, South Africa', 'general'),
('currency', 'ZAR', 'general'),
('vat_number', '', 'general'),
('company_reg', '', 'general'),
('maintenance_mode', '0', 'system'),
('recaptcha_site_key', '', 'security'),
('recaptcha_secret_key', '', 'security'),
('smtp_host', 'smtp.gmail.com', 'email'),
('smtp_port', '587', 'email'),
('smtp_user', 'njabulod.hlongwane@gmail.com', 'email'),
('smtp_from_name', 'Vueports Solutions', 'email'),
('payfast_merchant_id', '', 'payment'),
('payfast_merchant_key', '', 'payment'),
('payfast_passphrase', '', 'payment'),
('payfast_sandbox', '1', 'payment'),
('zapier_api_key', '', 'integrations'),
('google_client_id', '', 'integrations'),
('google_client_secret', '', 'integrations'),
('redis_enabled', '0', 'cache'),
('session_lifetime', '120', 'security'),
('max_login_attempts', '5', 'security'),
('lockout_duration', '30', 'security'),
('backup_retention_days', '14', 'system'),
('s3_bucket', '', 'system'),
('s3_region', 'af-south-1', 'system');

INSERT INTO `data_processing_register` (`purpose`, `data_categories`, `lawful_basis`, `retention_period_days`, `source`, `recipients`, `cross_border`, `safeguards`, `dpia_required`) VALUES
('Client onboarding & service delivery', '["contact_details","company_info","project_requirements"]', 'contract', 2555, 'Website forms, direct contact', '["internal_staff","payfast"]', 0, 'Encrypted storage, role-based access, password hashing', 0),
('Payment processing', '["payment_records","billing_address"]', 'contract', 2555, 'PayFast gateway', '["payfast","accounting_software"]', 0, 'PCI-DSS via PayFast (no card data stored)', 0),
('Marketing communications', '["contact_details","preferences"]', 'consent', 730, 'Website newsletter signup', '["email_service_provider"]', 0, 'Opt-in consent, unsubscribe links, encrypted DB', 0),
('Website analytics', '["ip_address_hashed","browser_info","usage_data"]', 'legitimate_interest', 395, 'Website cookies & logs', '["internal_analytics"]', 0, 'IP hashing, no PII in analytics, 13-month retention', 0),
('Customer support & communication', '["contact_details","communication_history"]', 'contract', 2555, 'Email, contact form, chat', '["internal_staff"]', 0, 'Access logs, encrypted email storage', 0);

INSERT INTO `email_templates` (`template_key`, `name`, `subject`, `body_html`, `body_text`, `variables`) VALUES
('welcome_client', 'Welcome Email', 'Welcome to Vueports Solutions', '<p>Hi {{name}},</p><p>Welcome to Vueports Solutions. Your client portal is now active.</p><p><a href="{{portal_url}}">Access Portal</a></p>', 'Hi {{name}}, Welcome to Vueports Solutions. Access your portal: {{portal_url}}', '["name","portal_url"]'),
('consultation_received', 'Consultation Received', 'We received your consultation request', '<p>Hi {{name}},</p><p>Thank you for reaching out. We have received your consultation request for {{service}}.</p><p>We will be in touch within 24 hours.</p>', 'Hi {{name}}, Thank you for your consultation request for {{service}}. We will contact you within 24 hours.', '["name","service"]'),
('booking_confirmed', 'Booking Confirmed', 'Your meeting is confirmed', '<p>Hi {{name}},</p><p>Your meeting on {{date}} at {{time}} is confirmed.</p><p>{{meeting_link}}</p>', 'Hi {{name}}, Your meeting on {{date}} at {{time}} is confirmed. Link: {{meeting_link}}', '["name","date","time","meeting_link"]'),
('invoice_sent', 'New Invoice', 'Invoice {{invoice_number}} from Vueports Solutions', '<p>Hi {{name}},</p><p>Please find your invoice attached.</p><p>Amount: R{{amount}}<br>Due: {{due_date}}</p><p><a href="{{pay_url}}">Pay Now</a></p>', 'Hi {{name}}, Invoice {{invoice_number}} for R{{amount}} is due {{due_date}}. Pay: {{pay_url}}', '["name","invoice_number","amount","due_date","pay_url"]'),
('payment_receipt', 'Payment Receipt', 'Payment Confirmation — {{invoice_number}}', '<p>Hi {{name}},</p><p>Thank you for your payment of R{{amount}}.</p><p>Transaction ID: {{transaction_id}}</p><p>This serves as your official receipt.</p>', 'Hi {{name}}, Payment of R{{amount}} confirmed. Transaction: {{transaction_id}}', '["name","amount","transaction_id","invoice_number"]'),
('password_reset', 'Password Reset', 'Reset your Vueports password', '<p>Hi {{name}},</p><p>Click below to reset your password. This link expires in 1 hour.</p><p><a href="{{reset_url}}">Reset Password</a></p>', 'Hi {{name}}, Reset your password: {{reset_url}} (expires in 1 hour)', '["name","reset_url"]'),
('project_update', 'Project Update', 'Update on your project: {{project_title}}', '<p>Hi {{name}},</p><p>There is a new update on your project <strong>{{project_title}}</strong>.</p><p><a href="{{project_url}}">View Project</a></p>', 'Hi {{name}}, New update on {{project_title}}. View: {{project_url}}', '["name","project_title","project_url"]');

SET FOREIGN_KEY_CHECKS = 1;
