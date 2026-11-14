<?php require '../includes/db.php'; require_admin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf(); $a = $_POST['action'] ?? '';
    if ($a === 'add') {
        $n = trim($_POST['name'] ?? ''); $p = (float)($_POST['price'] ?? 0); $d = (float)($_POST['duration'] ?? 1);
        if ($n === '' || $p <= 0) flash('Name and a positive price are required.', 'error');
        else { db()->prepare("INSERT INTO services(name,description,price,duration_hrs) VALUES(?,?,?,?)")->execute([$n, trim($_POST['description'] ?? ''), $p, $d]); flash('Service added.'); }
    } elseif ($a === 'delete') {
        $used = db()->prepare("SELECT COUNT(*) FROM bookings WHERE service_id=?"); $used->execute([(int)$_POST['id']]);
        if ($used->fetchColumn() > 0) flash('Cannot delete: this service has existing bookings.', 'error');
        else { db()->prepare("DELETE FROM services WHERE id=?")->execute([(int)$_POST['id']]); flash('Service deleted.'); }
    }
    header('Location: services.php'); exit;
}
$rows = db()->query("SELECT * FROM services ORDER BY id")->fetchAll();
$title='Manage Services'; require '../includes/header.php'; ?>
<h2>Manage Services</h2>
<div class="card" style="margin-bottom:22px"><h3>Add new service</h3>
<form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="add">
<div class="row2"><div><label>Service Name</label><input name="name" required></div><div><label>Description</label><input name="description"></div></div>
<div class="row2"><div><label>Price (&#8377;)</label><input type="number" name="price" min="1" step="0.01" required></div><div><label>Duration (hrs)</label><input type="number" name="duration" min="0.5" step="0.5" value="1"></div></div>
<button>Add Service</button></form></div>
<table><tr><th>#</th><th>Service</th><th>Description</th><th>Price</th><th>Hours</th><th></th></tr>
<?php foreach ($rows as $r): ?><tr><td><?= $r['id'] ?></td><td><b><?= e($r['name']) ?></b></td><td class="mut"><?= e($r['description']) ?></td>
<td>&#8377;<?= number_format($r['price']) ?></td><td><?= e($r['duration_hrs']) ?></td>
<td><form method="post" class="inline" onsubmit="return confirm('Delete this service?')"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $r['id'] ?>"><button class="red">Delete</button></form></td></tr><?php endforeach; ?></table>
<?php require '../includes/footer.php'; ?>
