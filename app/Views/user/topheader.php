<header class="sticky-top bg-primary d-print-none">
	<section class="container-fluid">
	<nav class="navbar text-white navbar-dark py-0">
		<a class="navbar-brand" href="#">INTEGRASS</a>
		<?php if(isset($menu) && is_array($menu)) { ?>
		<button type="button" id="sidebarCollapse" class="navbar-toggler"><i class="fa fa-bars"></i><span class="sr-only">Toggle Menu</span></button>
		<ul class="navbar-nav ml-auto nav-flex-icons d-none d-xl-flex">
			<li class="nav-item dropdown">
				<a class="nav-link" id="navbarDropdownMenuLink" data-mdb-toggle="dropdown"><i class="fas fa-user-tie"></i>  </a>
				<div class="dropdown-menu dropdown-menu-end py-0">
					<a class="dropdown-item" href="<?php echo base_url('user/signout'); ?>"><i class="fas fa-sign-out-alt"></i> Signout</a>
				</div>
			</li>
		</ul>
		<?php } ?>
	</nav>
	</section>
</header>