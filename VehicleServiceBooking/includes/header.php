<?php require_once __DIR__ . '/db.php'; $b = base(); $u = user(); ?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title ?? 'Vehicle Service Booking') ?> | AutoCare</title>
<link rel="stylesheet" href="<?= $b ?>assets/style.css"></head><body>
<header class="nav"><div class="wrap navin">
  <a class="brand" href="<?= $b ?>index.php">&#9881; Auto<span>Care</span></a>
  <nav>
    <a href="<?= $b ?>index.php">Home</a>
    <a href="<?= $b ?>services.php">Services</a>
    <?php if ($u && $u['role']==='admin'): ?>
      <a href="<?= $b ?>admin/dashboard.php">Dashboard</a>
      <a href="<?= $b ?>admin/bookings.php">Bookings</a>
      <a href="<?= $b ?>admin/services.php">Manage Services</a>
    <?php elseif ($u): ?>
      <a href="<?= $b ?>book.php">Book Service</a>
      <a href="<?= $b ?>my_bookings.php">My Bookings</a>
    <?php endif; ?>
    <?php if ($u): ?><span class="hi">Hi, <?= e(explode(' ',$u['name'])[0]) ?></span><a class="btn sm" href="<?= $b ?>logout.php">Logout</a>
    <?php else: ?><a href="<?= $b ?>login.php">Login</a><a class="btn sm" href="<?= $b ?>register.php">Register</a><?php endif; ?>
  </nav></div></header>
<main class="wrap"><?= flash() ?>
