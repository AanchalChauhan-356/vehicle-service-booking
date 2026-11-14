<?php require '../includes/db.php'; require_admin(); $title='Admin Dashboard';
$q = fn($sql) => db()->query($sql)->fetchColumn();
$stats = ['Total Bookings'=>$q("SELECT COUNT(*) FROM bookings"),'Pending'=>$q("SELECT COUNT(*) FROM bookings WHERE status='Pending'"),
 'Customers'=>$q("SELECT COUNT(*) FROM users WHERE role='customer'"),
 'Revenue (Completed)'=>'&#8377;'.number_format((float)$q("SELECT COALESCE(SUM(s.price),0) FROM bookings b JOIN services s ON s.id=b.service_id WHERE b.status='Completed'"))];
$recent = db()->query("SELECT b.*, u.name AS cust, s.name AS service FROM bookings b JOIN users u ON u.id=b.user_id JOIN services s ON s.id=b.service_id ORDER BY b.id DESC LIMIT 5")->fetchAll();
require '../includes/header.php'; ?>
<h2>Admin Dashboard</h2>
<div class="stats"><?php foreach ($stats as $k=>$v) echo "<div class='stat'><b>$v</b>".e($k)."</div>"; ?></div>
<h2>Recent Bookings</h2>
<table><tr><th>#</th><th>Customer</th><th>Service</th><th>Vehicle</th><th>Date</th><th>Status</th></tr>
<?php foreach ($recent as $r): ?><tr><td><?= $r['id'] ?></td><td><?= e($r['cust']) ?></td><td><?= e($r['service']) ?></td>
<td><?= e($r['vehicle_model']) ?> (<?= e($r['reg_no']) ?>)</td><td><?= e($r['booking_date']) ?> <?= e($r['time_slot']) ?></td>
<td><span class="badge <?= e($r['status']) ?>"><?= e($r['status']) ?></span></td></tr><?php endforeach; ?></table>
<p><a class="btn" href="bookings.php">Manage all bookings</a></p>
<?php require '../includes/footer.php'; ?>
