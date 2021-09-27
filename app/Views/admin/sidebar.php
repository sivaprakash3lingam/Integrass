<?php 	//defined('BASEPATH') OR exit('No direct script access allowed');
$m[0] = (array_key_exists(0, $menu) && !is_null($menu[0]) && !empty($menu[0]) ? $menu[0] : NULL);
$m[1] = (array_key_exists(1, $menu) && !is_null($menu[1]) && !empty($menu[1]) ? $menu[1] : NULL);
$m[2] = (array_key_exists(2, $menu) && !is_null($menu[2]) && !empty($menu[2]) ? $menu[2] : NULL);
?>
<nav class="sidebar">
	<div class="custom-menu"></div>
	<ul class="list-unstyled components mb-5">
		<?php /*<li<?= ($m[0] == 'invoice' ? ' class="active"' : ''); ?>>
			<a href="#submuenu_events" data-mdb-toggle="collapse" aria-expanded="false" class="dropdown-toggle<?= ($m[0] == 'invoice' ? '' : ' collapsed'); ?>"><i class="fas fa-receipt"></i> List of Events</a>
			<ul class="collapse<?= ($m[0] == 'events' && in_array($m[1], ['list']) ? ' show' : ''); ?> list-unstyled" id="submuenu_events">
				<li<?= ($m[0] == 'events' && $m[1] == 'approved' ? ' class="bg-black"' : ''); ?>>
					<a href="<?= base_url('user/events/approved'); ?>"><i class="fas fa-check"></i> Approved Events</a>
				</li>
				<li<?= ($m[0] == 'events' && $m[1] == 'pending' ? ' class="bg-black"' : ''); ?>>
					<a href="<?= base_url('user/events/pending'); ?>"><i class="fas fa-pause-circle"></i> Pending Events</a>
				</li>
				<li<?= ($m[0] == 'events' && $m[1] == 'rejected' ? ' class="bg-black"' : ''); ?>>
					<a href="<?= base_url('events/rejected'); ?>"><i class="fas fa-times"></i> Rejected Events</a>
				</li>
				<li<?= ($m[0] == 'events' && $m[1] == 'rejected' ? ' class="bg-black"' : ''); ?>>
					<a href="<?= base_url('user/events/all'); ?>"><i class="fas fa-list"></i> All Events List</a>
				</li>
			</ul>
		</li> */ ?>
		<li<?= ($m[0] == 'event' ? ' class="active"' : ''); ?>>
			<a href="<?= base_url('admin/dashboard'); ?>"><i class="fas fa-list"></i> Events List</a>
		</li>
		<li>
			<a href="<?= base_url('admin/signout'); ?>"><i class="fas fa-sign-out-alt"></i> Signout</a>
		</li>
	</ul>
</nav>