<?php
// CREATE TABLE `page_requests` (
//   `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
//   `ref` VARCHAR(255) NOT NULL,
//   `ip` VARCHAR(45) NOT NULL,            -- يدعم IPv4 و IPv6
//   `user_agent` TEXT NULL,
//   `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
//   PRIMARY KEY (`id`),
//   INDEX (`ref`),
//   INDEX (`created_at`)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

// track.php

// === إعدادات قاعدة البيانات - عدّلهم حسب بيئتك ===
$dbHost = '127.0.0.1';
$dbName = 'mubasher_db';
$dbUser = 'mubasher_user';
$dbPass = '!BIyBXyQrB+L';
$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => false,
    ]);
} catch (PDOException $e) {
    // لو حاب تعرض خطأ أثناء التطوير:
    // die("DB connection failed: " . $e->getMessage());
    http_response_code(500);
    exit;
}

function get_client_ip() {
    $keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];

    foreach ($keys as $k) {
        if (!empty($_SERVER[$k])) {
            $ipList = explode(',', $_SERVER[$k]);
            $ip = trim(current($ipList));
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) ||
                filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
    return '0.0.0.0';
}

// قراءة الـ ref بأمان
$ref = isset($_GET['ref']) ? trim($_GET['ref']) : '';
if ($ref === '') {
    http_response_code(400);
    echo 'Missing ref parameter';
    exit;
}

$ref = mb_substr($ref, 0, 255);

$ip = get_client_ip();
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;

$sql = "INSERT INTO page_requests (`ref`, `ip`, `user_agent`) VALUES (:ref, :ip, :ua)";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        ':ref' => $ref,
        ':ip'  => $ip,
        ':ua'  => $userAgent
    ]);
    // رد بسيط أو إعادة توجيه أو تحميل محتوى الصفحة إللي تريد
    // echo 'OK';
} catch (PDOException $e) {
    // في الإنتاج لا تطبع رسالة الخطأ الكاملة
    http_response_code(500);
    // error_log($e->getMessage());
    exit;
}
