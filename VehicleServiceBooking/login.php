<?php require 'includes/db.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $st = db()->prepare("SELECT * FROM users WHERE email=?"); $st->execute([strtolower(trim($_POST['email'] ?? ''))]);
    $u = $st->fetch();
    if ($u && password_verify($_POST['password'] ?? '', $u['password'])) {
        session_regenerate_id(true); unset($u['password']); $_SESSION['user'] = $u;
        header('Location: ' . ($u['role']==='admin' ? 'admin/dashboard.php' : 'my_bookings.php')); exit;
    }
    $err = 'Invalid email or password.';
}
$title='Login'; require 'includes/header.php'; ?>
<div class="auth"><aside class="auth-side"><div class="big">&#128663;</div><h2>Welcome back!</h2><p>Log in to book services and track your vehicle.</p><ul><li>&#10003; Live slot availability</li><li>&#10003; Track every booking</li><li>&#10003; Cancel anytime</li></ul></aside>
<div class="card formbox"><h2 style="margin-top:0">Welcome back</h2>
<?php if ($err) echo "<div class='alert error'>".e($err)."</div>"; ?>
<form method="post"><?= csrf_field() ?>
<label>Email</label><input type="email" name="email" required>
<label>Password</label><input type="password" name="password" required>
<button>Login</button> <span class="mut">New here? <a href="register.php">Register</a></span></form>
<p class="mut" style="margin-top:18px">Demo customer: demo@vsbs.com / demo123<br>Demo admin: admin@vsbs.com / admin123</p></div></div>
<?php require 'includes/footer.php'; ?>
