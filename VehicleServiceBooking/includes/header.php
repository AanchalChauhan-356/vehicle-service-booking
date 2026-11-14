<?php require_once __DIR__ . '/db.php'; $b = base(); $u = user(); $cur = basename($_SERVER['SCRIPT_NAME']);
function act($f){ global $cur; return $cur===$f ? 'class="on"' : ''; } ?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title ?? 'Vehicle Service Booking') ?> | AutoCare</title>
<link rel="stylesheet" href="<?= $b ?>assets/style.css"></head><body>
<header class="nav"><div class="wrap navin">
  <a class="brand" href="<?= $b ?>index.php"><span class="logo">&#9881;</span><span class="bt">Auto<span>Care</span></span></a>
  <input type="checkbox" id="mn" class="mn-t"><label for="mn" class="burger">&#9776;</label>
  <nav>
    <a <?= act('index.php') ?> href="<?= $b ?>index.php">Home</a>
    <a <?= act('services.php') ?> href="<?= $b ?>services.php">Services</a>
    <?php if ($u && $u['role']==='admin'): ?>
      <a href="<?= $b ?>admin/dashboard.php">Dashboard</a>
      <a href="<?= $b ?>admin/bookings.php">Bookings</a>
      <a href="<?= $b ?>admin/services.php">Manage Services</a>
    <?php elseif ($u): ?>
      <a <?= act('book.php') ?> href="<?= $b ?>book.php">Book Service</a>
      <a <?= act('my_bookings.php') ?> href="<?= $b ?>my_bookings.php">My Bookings</a>
    <?php endif; ?>
    <?php if ($u): ?><span class="hi">&#128100; <?= e(explode(' ',$u['name'])[0]) ?></span><a class="btn sm" href="<?= $b ?>logout.php">Logout</a>
    <?php else: ?><a <?= act('login.php') ?> href="<?= $b ?>login.php">Login</a><a class="btn sm" href="<?= $b ?>register.php">Register</a><?php endif; ?>
  </nav></div></header>
<main class="wrap"><?= flash() ?>
