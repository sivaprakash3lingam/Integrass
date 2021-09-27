<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
<?php echo view("admin/stylesheet"); ?>
</head>

<body>
<?php echo view('admin/topheader'); ?>
<section class="bg-black" style="min-height:calc(100vh - 75px); padding-top:calc(100vh - 80vh); padding-bottom:calc(100vh - 80vh);">
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-10">
				<div class="card shadow-1-strong">
					<div class="card-header bg-primary text-white text-center">
						<p class="font-weight-bold mb-0">Login to Continue...</p>
					</div>
					<div class="card-body">
						<?= $alert; ?>
						<form name="form_master_login" id="form_master_login" method="post" action="<?= base_url('admin/login'); ?>">
							<div class="form-outline input-group mb-3">
								<input type="text" name="username" id="username" class="form-control" value="<?= (array_key_exists('username', $input) && !empty($input['username']) && !is_null($input['username']) ? $input['username'] : ''); ?>" />
								<label class="form-label" for="username">Login Username</label>
							</div>
							<div class="form-outline mb-3">
								<input type="password" name="password" id="password" class="form-control"  autocomplete="off">
								<label class="form-label" for="password">Login Password</label>
							</div>
							<button type="submit" class="btn btn-block btn-success font-weight-bold">Signin <i class="fas fa-sign-in-alt"></i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
echo view('admin/footer');
echo view("admin/javascript");
?>
<script>
$(document).ready(function(e) {
	$('form#form_master_login').validate({
		//debug: true,
		onclick: false,
		errorClass: "invalid-feedback font-italic text-right",
		validClass: "valid-feedback font-italic text-right",
		errorElement : 'small',
		highlight: function(element, errorClass, validClass) { $(element).removeClass('invalid is-invalid valid is-valid').addClass('invalid is-invalid').parents('.form-outline:first').removeClass('mb-3').addClass('mb-5'); },
		unhighlight: function(element, errorClass, validClass) { $(element).removeClass('invalid is-invalid valid is-valid').addClass('valid is-valid').parents('.form-outline:first').removeClass('mb-5').addClass('mb-3'); },
		rules: {
			username: { required: true},
			password: { required: true}
		},
		messages: {
			username: { required: '<i class="fas fa-exclamation-triangle"></i> Enter Login Username !'},
			password: { required: '<i class="fas fa-exclamation-triangle"></i> Enter Login Password !',}
		},
		submitHandler: function(form){	var gg = {}; var validator = this;
			var fd = new FormData(form);
			$(form).find('button:submit').prop({'disabled':true}).html('<i class="fas fa-sync-alt fa-spin"></i> Authenticating...');
			form.submit();
		}
	}).showErrors(<?= json_encode($error); ?>);
});
</script>
</body>
</html>