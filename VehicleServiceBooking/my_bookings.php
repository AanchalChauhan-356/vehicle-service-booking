<?php require 'includes/db.php'; require_login();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {   // customer cancels own booking
    check_csrf();
    $st = db()->prepare("UPDATE bookings SET status='Cancelled' WHERE id=? AND user_id=? AND status IN ('Pending','Confirmed')");
    $st->execute([(int)$_POST['id'], user()['id']]);
    flash($st->rowCount() ? 'Booking cancelled.' : 'Unable to cancel this booking.', $st->rowCount() ? 'success' : 'error');
    header('Location: my_bookings.php'); exit;
}
$st = db()->prepare("SELECT b.*, s.name AS service, s.price FROM bookings b JOIN services s ON s.id=b.service_id WHERE b.user_id=? ORDER BY b.booking_date DESC, b.id DESC");
$st->execute([user()['id']]); $rows = $st->fetchAll();
$title='My Bookings'; require 'includes/header.php'; ?>
<h2 style="display:flex;justify-content:space-between;align-items:center">My Bookings <a class="btn sm" href="book.php">+ New Booking</a></h2>
<table><tr><th>#</th><th>Service</th><th>Vehicle</th><th>Reg. No</th><th>Date &amp; Slot</th><th>Cost</th><th>Status</th><th></th></tr>
<?php if (!$rows) echo "<tr><td colspan='8' class='mut'>No bookings yet. Book your first service!</td></tr>";
foreach ($rows as $r): ?><tr><td><?= $r['id'] ?></td><td><?= e($r['service']) ?></td>
<td><?= e($r['vehicle_type']) ?> - <?= e($r['vehicle_model']) ?></td><td><?= e($r['reg_no']) ?></td>
<td><?= e($r['booking_date']) ?><br><span class="mut"><?= e($r['time_slot']) ?></span></td><td>&#8377;<?= number_format($r['price']) ?></td>
<td><span class="badge <?= e($r['status']) ?>"><?= e($r['status']) ?></span></td>
<td><?php if (in_array($r['status'],['Pending','Confirmed'])): ?><form method="post" class="inline" onsubmit="return confirm('Cancel this booking?')"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $r['id'] ?>"><button class="red">Cancel</button></form><?php endif; ?></td></tr>
<?php endforeach; ?></table>
<?php require 'includes/footer.php'; ?>
