<?php require 'includes/db.php'; require_login();
if (user()['role']==='admin') { header('Location: admin/dashboard.php'); exit; }
const SLOTS = ['09:00 AM','10:00 AM','11:00 AM','12:00 PM','02:00 PM','03:00 PM','04:00 PM','05:00 PM'];
const MAX_PER_SLOT = 2;   // workshop bays available per slot
$svcs = db()->query("SELECT * FROM services ORDER BY id")->fetchAll();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $sid = (int)($_POST['service_id'] ?? 0); $vt = $_POST['vehicle_type'] ?? ''; $vm = trim($_POST['vehicle_model'] ?? '');
    $reg = strtoupper(trim($_POST['reg_no'] ?? '')); $date = $_POST['booking_date'] ?? ''; $slot = $_POST['time_slot'] ?? '';
    $notes = trim($_POST['notes'] ?? '');
    $s = db()->prepare("SELECT id FROM services WHERE id=?"); $s->execute([$sid]);
    if (!$s->fetch()) $errors[] = 'Please choose a valid service.';
    if (!in_array($vt, ['Car','Bike','SUV','Truck'], true)) $errors[] = 'Select a vehicle type.';
    if ($vm === '') $errors[] = 'Vehicle model is required.';
    if (!preg_match('/^[A-Z]{2}[ -]?[0-9]{1,2}[A-Z]?[ -]?[A-Z]{0,3}[ -]?[0-9]{4}$/', $reg)) $errors[] = 'Enter a valid registration number (e.g. DL 01 AB 1234).';
    $d = DateTime::createFromFormat('Y-m-d', $date);
    if (!$d || $d->format('Y-m-d') !== $date) $errors[] = 'Choose a valid date.';
    elseif ($date < date('Y-m-d')) $errors[] = 'Booking date cannot be in the past.';
    elseif ($d->format('w') === '0') $errors[] = 'Workshop is closed on Sundays.';
    if (!in_array($slot, SLOTS, true)) $errors[] = 'Choose a time slot.';
    if (!$errors) {
        $c = db()->prepare("SELECT COUNT(*) FROM bookings WHERE booking_date=? AND time_slot=? AND status!='Cancelled'");
        $c->execute([$date,$slot]);
        if ($c->fetchColumn() >= MAX_PER_SLOT) $errors[] = "Sorry, the $slot slot on $date is fully booked. Please pick another.";
    }
    if (!$errors) {
        db()->prepare("INSERT INTO bookings(user_id,service_id,vehicle_type,vehicle_model,reg_no,booking_date,time_slot,notes) VALUES(?,?,?,?,?,?,?,?)")
            ->execute([user()['id'],$sid,$vt,$vm,$reg,$date,$slot,$notes]);
        flash('Booking #'.db()->lastInsertId().' created successfully! We will confirm it shortly.');
        header('Location: my_bookings.php'); exit;
    }
}
$sel = (int)($_POST['service_id'] ?? $_GET['service'] ?? 0);
$title='Book Service'; require 'includes/header.php'; ?>
<div class="bookgrid"><div class="card"><h2 style="margin-top:0">Book a Service</h2>
<?php foreach ($errors as $er) echo "<div class='alert error'>".e($er)."</div>"; ?>
<form method="post" id="bf"><?= csrf_field() ?>
<label>Select Service</label>
<select name="service_id" id="svc" required><option value="">-- Choose --</option>
<?php foreach ($svcs as $s): ?><option value="<?= $s['id'] ?>" data-p="<?= $s['price'] ?>" data-d="<?= $s['duration_hrs'] ?>" <?= $sel==$s['id']?'selected':'' ?>>
<?= e($s['name']) ?> - &#8377;<?= number_format($s['price']) ?></option><?php endforeach; ?></select>
<div class="row2"><div><label>Vehicle Type</label><select name="vehicle_type" required>
<?php foreach (['Car','Bike','SUV','Truck'] as $t) echo "<option ".(($_POST['vehicle_type']??'')===$t?'selected':'').">$t</option>"; ?></select></div>
<div><label>Vehicle Make / Model</label><input name="vehicle_model" placeholder="e.g. Maruti Swift VXi" value="<?= e($_POST['vehicle_model'] ?? '') ?>" required></div></div>
<div class="row2"><div><label>Registration Number</label><input name="reg_no" placeholder="DL 01 AB 1234" value="<?= e($_POST['reg_no'] ?? '') ?>" required></div>
<div><label>Preferred Date</label><input type="date" name="booking_date" min="<?= date('Y-m-d') ?>" value="<?= e($_POST['booking_date'] ?? '') ?>" required></div></div>
<label>Time Slot</label><select name="time_slot" required><option value="">-- Choose --</option>
<?php foreach (SLOTS as $t) echo "<option ".(($_POST['time_slot']??'')===$t?'selected':'').">$t</option>"; ?></select>
<label>Additional Notes (optional)</label><textarea name="notes" rows="3" placeholder="Any specific problem, e.g. strange noise from front wheel"><?= e($_POST['notes'] ?? '') ?></textarea>
<div class="summary" id="sum">Select a service to see the estimated cost and duration.</div>
<button>Confirm Booking</button></form></div>
<aside class="card side"><h3>&#128221; Before you book</h3><ul><li>Workshop open <b>Mon - Sat, 9 AM - 6 PM</b></li><li>Max <b>2 vehicles</b> per time slot</li><li>Prices are estimates; pay at the workshop</li><li>Cancel anytime from <b>My Bookings</b></li></ul>
<div class="summary">&#128161; Tip: mention any noise or warning light in the notes so our mechanics can prepare.</div></aside></div>
<script>
const s=document.getElementById('svc'),o=document.getElementById('sum');
function up(){const x=s.options[s.selectedIndex];o.innerHTML=x&&x.dataset.p?'Estimated cost: <b>&#8377;'+Number(x.dataset.p).toLocaleString('en-IN')+'</b> &middot; Approx. duration: <b>'+x.dataset.d+' hr(s)</b>':'Select a service to see the estimated cost and duration.';}
s.addEventListener('change',up);up();
</script>
<?php require 'includes/footer.php'; ?>
