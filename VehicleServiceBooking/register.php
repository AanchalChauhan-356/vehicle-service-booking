<?php require 'includes/db.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $name = trim($_POST['name'] ?? ''); $email = strtolower(trim($_POST['email'] ?? ''));
    $phone = trim($_POST['phone'] ?? ''); $pw = $_POST['password'] ?? ''; $pw2 = $_POST['password2'] ?? '';
    if (strlen($name) < 3) $errors[] = 'Name must be at least 3 characters.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
    if (!preg_match('/^[0-9]{10}$/', $phone)) $errors[] = 'Phone must be exactly 10 digits.';
    if (strlen($pw) < 6) $errors[] = 'Password must be at least 6 characters.';
    if ($pw !== $pw2) $errors[] = 'Passwords do not match.';
    if (!$errors) {
        $chk = db()->prepare("SELECT id FROM users WHERE email=?"); $chk->execute([$email]);
        if ($chk->fetch()) $errors[] = 'This email is already registered.';
        else {
            db()->prepare("INSERT INTO users(name,email,phone,password) VALUES(?,?,?,?)")
                ->execute([$name,$email,$phone,password_hash($pw, PASSWORD_DEFAULT)]);
            flash('Registration successful! Please login.'); header('Location: login.php'); exit;
        }
    }
}
$title='Register'; require 'includes/header.php'; ?>
<div class="auth"><aside class="auth-side"><div class="big">&#128295;</div><h2>Join AutoCare</h2><p>Create a free account and book your first service in under a minute.</p><ul><li>&#10003; Transparent pricing</li><li>&#10003; No phone calls</li><li>&#10003; Secure and private</li></ul></aside>
<div class="card formbox"><h2 style="margin-top:0">Create your account</h2>
<?php foreach ($errors as $er) echo "<div class='alert error'>".e($er)."</div>"; ?>
<form method="post"><?= csrf_field() ?>
<label>Full Name</label><input name="name" value="<?= e($_POST['name'] ?? '') ?>" required>
<div class="row2"><div><label>Email</label><input type="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" required></div>
<div><label>Phone (10 digits)</label><input name="phone" maxlength="10" pattern="[0-9]{10}" value="<?= e($_POST['phone'] ?? '') ?>" required></div></div>
<div class="row2"><div><label>Password</label><input type="password" name="password" minlength="6" required></div>
<div><label>Confirm Password</label><input type="password" name="password2" required></div></div>
<button>Register</button> <span class="mut">Already a member? <a href="login.php">Login</a></span></form></div></div>
<?php require 'includes/footer.php'; ?>
