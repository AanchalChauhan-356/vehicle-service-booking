<?php $title='Services'; require 'includes/header.php';
$svcs = db()->query("SELECT * FROM services ORDER BY id")->fetchAll(); ?>
<div class="sec" style="margin-top:6px"><h2>Our Services</h2><p>Transparent pricing. Approximate duration shown for each package.</p>
<input class="search" id="q" type="search" placeholder="&#128269; Search services (e.g. brake, oil, AC)"></div>
<div class="grid" id="list"><?php foreach ($svcs as $s): ?>
  <div class="card svc" data-n="<?= e(strtolower($s['name'].' '.$s['description'])) ?>"><div class="ic"><?= svc_icon($s['name']) ?></div><h3><?= e($s['name']) ?></h3><p class="mut"><?= e($s['description']) ?></p>
  <div class="meta"><span class="price">&#8377;<?= number_format($s['price']) ?></span><span class="tag">&#9201; ~<?= e($s['duration_hrs']) ?> hr</span></div><br>
  <a class="btn sm" href="book.php?service=<?= (int)$s['id'] ?>">Book now &rarr;</a></div><?php endforeach; ?></div>
<p class="mut" id="none" style="display:none;text-align:center">No service matches your search.</p>
<script>const q=document.getElementById('q'),cs=[...document.querySelectorAll('#list .svc')];
q.addEventListener('input',()=>{const v=q.value.toLowerCase().trim();let c=0;cs.forEach(x=>{const m=x.dataset.n.includes(v);x.style.display=m?'':'none';if(m)c++});document.getElementById('none').style.display=c?'none':'block'});</script>
<?php require 'includes/footer.php'; ?>
