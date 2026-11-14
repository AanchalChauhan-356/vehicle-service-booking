<?php require '../includes/db.php'; require_admin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $status = $_POST['status'] ?? '';
    if (in_array($status, ['Pending','Confirmed','Completed','Cancelled'], true)) {
        db()->prepare("UPDATE bookings SET status=? WHERE id=?")->execute([$status,(int)$_POST['id']]);
        flash("Booking #".(int)$_POST['id']." marked as $status.");
    }
    header('Location: bookings.php' . (!empty($_GET['status']) ? '?status='.urlencode($_GET['status']) : '')); exit;
}
$f = $_GET['status'] ?? '';
$sql = "SELECT b.*, u.name AS cust, u.phone, s.name AS service, s.price FROM bookings b JOIN users u ON u.id=b.user_id JOIN services s ON s.id=b.service_id";
$args = []; if ($f !== '') { $sql .= " WHERE b.status=?"; $args[] = $f; }
$st = db()->prepare($sql . " ORDER BY b.booking_date ASC, b.id DESC"); $st->execute($args); $rows = $st->fetchAll();
$title='Manage Bookings'; require '../includes/header.php'; ?>
<h2>All Bookings</h2>
<form method="get" style="display:flex;gap:10px;align-items:center;margin-bottom:14px"><span class="mut">Filter:</span>
<select name="status" style="width:auto"><option value="">All</option><?php foreach (['Pending','Confirmed','Completed','Cancelled'] as $s) echo "<option ".($f===$s?'selected':'').">$s</option>"; ?></select>
<button style="margin:0;padding:9px 18px">Apply</button></form>
<table><tr><th>#</th><th>Customer</th><th>Service</th><th>Vehicle / Reg.</th><th>Date &amp; Slot</th><th>Status</th><th>Update</th></tr>
<?php if (!$rows) echo "<tr><td colspan='7' class='mut'>No bookings found.</td></tr>";
foreach ($rows as $r): ?><tr><td><?= $r['id'] ?></td><td><?= e($r['cust']) ?><br><span class="mut"><?= e($r['phone']) ?></span></td>
<td><?= e($r['service']) ?><br><span class="mut">&#8377;<?= number_format($r['price']) ?></span></td>
<td><?= e($r['vehicle_type']) ?> - <?= e($r['vehicle_model']) ?><br><span class="mut"><?= e($r['reg_no']) ?></span></td>
<td><?= e($r['booking_date']) ?><br><span class="mut"><?= e($r['time_slot']) ?></span></td>
<td><span class="badge <?= e($r['status']) ?>"><?= e($r['status']) ?></span></td>
<td><form method="post" class="inline"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $r['id'] ?>">
<select name="status"><?php foreach (['Pending','Confirmed','Completed','Cancelled'] as $s) echo "<option ".($r['status']===$s?'selected':'').">$s</option>"; ?></select> <button>Save</button></form></td></tr>
<?php endforeach; ?></table>
<?php require '../includes/footer.php'; ?>
