<?php if(is_array($flash)&& sizeof($flash) > 0) { ?>
<div class="alert alert-<?= $flash['type'];?> alert-dismissible py-1 d-print-none" role="alert">
	<button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
	<p class="mb-0"><i class="fas fa-<?= ($flash['type']=='danger'?'exclamation-triangle':($flash['type']=='success'?'thumbs-up':'info-circle')); ?>"></i> <label class="alert-heading fw-bold"><?= $flash['title']; ?> !</label></p><hr class="my-1" /><p class="small mb-0"><small><?= $flash['msg']; ?></small></p>
</div>
<?php } ?>