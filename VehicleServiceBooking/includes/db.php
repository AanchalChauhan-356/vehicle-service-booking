<?php
// Database layer: SQLite via PDO (no MySQL/XAMPP needed). DB file is created automatically.
session_start();
function db(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;
    $dir = __DIR__ . '/../data';
    if (!is_dir($dir)) @mkdir($dir, 0777, true);   // GitHub does not keep empty folders, so create it here
    @chmod($dir, 0777);
    $path = $dir . '/vsbs.sqlite';
    $new = !file_exists($path);
    $pdo = new PDO('sqlite:' . $path);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec("CREATE TABLE IF NOT EXISTS users(
        id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT UNIQUE NOT NULL,
        phone TEXT, password TEXT NOT NULL, role TEXT DEFAULT 'customer', created_at TEXT DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS services(
        id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, description TEXT, price REAL NOT NULL, duration_hrs REAL DEFAULT 1)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS bookings(
        id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER NOT NULL, service_id INTEGER NOT NULL,
        vehicle_type TEXT, vehicle_model TEXT, reg_no TEXT, booking_date TEXT NOT NULL, time_slot TEXT NOT NULL,
        notes TEXT, status TEXT DEFAULT 'Pending', created_at TEXT DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(user_id) REFERENCES users(id), FOREIGN KEY(service_id) REFERENCES services(id))");
    if ($new) seed($pdo);
    return $pdo;
}
function seed(PDO $pdo): void {
    $pdo->prepare("INSERT INTO users(name,email,phone,password,role) VALUES(?,?,?,?,?)")
        ->execute(['Administrator','admin@vsbs.com','9999999999',password_hash('admin123',PASSWORD_DEFAULT),'admin']);
    $svc = [
        ['General Service','Engine oil, oil filter, 21-point inspection and wash',1800,3],
        ['Oil Change','Synthetic engine oil and filter replacement',1200,1],
        ['Brake Service','Pad inspection/replacement, disc check, brake oil top-up',2500,2],
        ['Wheel Alignment & Balancing','Computerised 4-wheel alignment and balancing',900,1.5],
        ['AC Service','AC gas top-up, filter clean, cooling check',2200,2],
        ['Battery Replacement','Battery test and replacement with warranty',4500,1],
        ['Full Body Wash & Detailing','Foam wash, interior vacuum, polish',1500,2.5],
    ];
    $st = $pdo->prepare("INSERT INTO services(name,description,price,duration_hrs) VALUES(?,?,?,?)");
    foreach ($svc as $s) $st->execute($s);
    // demo customer with sample bookings so the site never looks empty
    $pdo->prepare("INSERT INTO users(name,email,phone,password,role) VALUES(?,?,?,?,?)")
        ->execute(['Demo Customer','demo@vsbs.com','9876500000',password_hash('demo123',PASSWORD_DEFAULT),'customer']);
    $b = $pdo->prepare("INSERT INTO bookings(user_id,service_id,vehicle_type,vehicle_model,reg_no,booking_date,time_slot,notes,status) VALUES(2,?,?,?,?,?,?,?,?)");
    $b->execute([1,'Car','Maruti Swift VXi','DL 01 AB 1234',date('Y-m-d',strtotime('-6 days')),'10:00 AM','Regular service','Completed']);
    $b->execute([3,'SUV','Hyundai Creta SX','DL 8C AX 4521',date('Y-m-d',strtotime('+2 days')),'11:00 AM','Brake noise','Confirmed']);
    $b->execute([5,'Car','Honda City ZX','HR 26 DK 9087',date('Y-m-d',strtotime('+4 days')),'03:00 PM','','Pending']);
}
function svc_icon(string $n): string {
    $map = ['general'=>'&#128295;','oil'=>'&#128738;&#65039;','brake'=>'&#128721;','wheel'=>'&#128735;','ac '=>'&#10052;&#65039;','ac s'=>'&#10052;&#65039;','battery'=>'&#128267;','wash'=>'&#128703;','diagnos'=>'&#129658;'];
    $n = strtolower($n);
    foreach ($map as $k => $v) if (str_contains($n, $k)) return $v;
    return '&#9881;&#65039;';
}
function e($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function flash(?string $msg = null, string $type = 'success') {
    if ($msg !== null) { $_SESSION['flash'] = [$msg, $type]; return; }
    if (!empty($_SESSION['flash'])) { [$m,$t] = $_SESSION['flash']; unset($_SESSION['flash']);
        return "<div class='alert $t'>".e($m)."</div>"; }
    return '';
}
function csrf(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16)); return $_SESSION['csrf']; }
function csrf_field(): string { return "<input type='hidden' name='csrf' value='".csrf()."'>"; }
function check_csrf(): void { if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(400); die('Invalid request token.'); } }
function user() { return $_SESSION['user'] ?? null; }
function base(): string { return str_contains($_SERVER['SCRIPT_NAME'], '/admin/') ? '../' : ''; }
function require_login(): void { if (!user()) { flash('Please login first.','error'); header('Location: ' . base() . 'login.php'); exit; } }
function require_admin(): void { if (!user() || user()['role'] !== 'admin') { flash('Admin access only.','error'); header('Location: ' . base() . 'login.php'); exit; } }
