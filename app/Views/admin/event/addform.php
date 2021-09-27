<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
<?php echo view("admin/stylesheet"); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('css/datepicker.min.css'); ?>">
</head>

<body>
<?php echo view('admin/topheader', ['menu'=>[]]); ?>

<div class="wrapper">
	<?php echo view('admin/sidebar', ['profile'=>$profile, 'menu'=>['event', '']]); ?>

	<div class="content">
		<section class="grey lighten-4 py-2 d-print-none">
			<div class="container-fluid">
				<a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-primary p-1 float-end event_add"><i class="fas fa-reply"></i> Back to List</a>
				<h1 class="h5 font-weight-bold mb-0">Add New Event</h1>
			</div>
		</section>

		<section class="py-3">
			<div class="container-fluid">
				<form name="form_event_add" id="form_event_add" method="post" action="#">
					<div class="form-outline mb-3">
						<input type="text" name="title" id="title" class="form-control" value="" required />
						<label class="form-label">Event Title *</label>
					</div>
					<div class="form-outline mb-3">
						<textarea name="desc" id="desc" class="form-control"></textarea>
						<label class="form-label">Event Description</label>
					</div>
					<div class="row">
						<div class="col-lg-3 col-sm-6">
							<div class="form-outline mb-3">
								<input type="text" name="startdate" id="startdate" class="form-control" value="" required />
								<label class="form-label">Start Date *</label>
							</div>
						</div>
						<div class="col-lg-3 col-sm-6">
							<div class="form-outline mb-3">
								<input type="text" name="starttime" id="starttime" class="form-control" value="" />
								<label class="form-label">Start Time *</label>
							</div>
						</div>
						<div class="col-lg-3 col-sm-6">
							<div class="form-outline mb-3">
								<input type="text" name="enddate" id="enddate" class="form-control" value="" required />
								<label class="form-label">End Date *</label>
							</div>
						</div>
						<div class="col-lg-3 col-sm-6">
							<div class="form-outline mb-3">
								<input type="text" name="endtime" id="endtime" class="form-control" value="" />
								<label class="form-label">End Time *</label>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary fw-bold">Create</button>
				</form>
			</div>
		</section>

		<?php echo view('admin/footer'); ?>
	</div>
</div>
<?php echo view("admin/javascript"); ?>
<script type="text/javascript" src="<?= base_url('js/datepicker.min.js'); ?>"></script>
<script>
$(document).ready(function(e) {
	// $(document).on("click", ".event_add", function(e) {
	// 	modalprocess({"affect":"common_modal", "title":"Add New Event Details", "style":"modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-md-down", "target":"<?= base_url('admin/event/add/form/'); ?>" });
	$("form#form_event_add input[name='startdate']").datepicker({ format: "yyyy-mm-dd", autoclose: true, todayHighlight: true })
	.on('changeDate', function(){
		$(this).valid();
		document.querySelectorAll('.form-outline').forEach((formOutline) => { new mdb.Input(formOutline).init();
			($(formOutline).find('input').attr('type') == 'file' ? $(formOutline).find('input').addClass('active') : '');
		});
		$("form#form_event_add input[name='enddate']").datepicker('setStartDate', new Date($(this).val()));
	});
	$("form#form_event_add input[name='enddate']").datepicker({ format: "yyyy-mm-dd", autoclose: true, todayHighlight: true })
	.on('changeDate', function(){
		document.querySelectorAll('.form-outline').forEach((formOutline) => { new mdb.Input(formOutline).init();
			($(formOutline).find('input').attr('type') == 'file' ? $(formOutline).find('input').addClass('active') : '');
		});
		$(this).valid();
		$("form#form_event_add input[name='startdate']").datepicker('setEndDate', new Date($(this).val()));
	});
	//$('table#eventlist');
	$('form#form_event_add').validate({
		//debug: true,
		onclick: false,
		errorClass: "invalid-feedback font-italic text-right",
		validClass: "valid-feedback font-italic text-right",
		errorElement : 'small',
		highlight: function(element, errorClass, validClass) { $(element).removeClass('invalid is-invalid valid is-valid').addClass('invalid is-invalid').parents('.form-outline:first').removeClass('mb-3').addClass('mb-5'); },
		unhighlight: function(element, errorClass, validClass) { $(element).removeClass('invalid is-invalid valid is-valid').addClass('valid is-valid').parents('.form-outline:first').removeClass('mb-5').addClass('mb-3'); },
		rules: {
			title: { required: true},
			startdate: { required: true},
			enddate: { required: true}
		},
		messages: {
			title: { required: '<i class="fas fa-exclamation-triangle"></i> Enter Event Title !'},
			startdate: { required: '<i class="fas fa-exclamation-triangle"></i> Select Event Start Date !'},
			enddate: { required: '<i class="fas fa-exclamation-triangle"></i> Select Event End Date !'}
		},
		submitHandler: function(form){	var gg = {}; var validator = this;
			$(form).find('button:submit').prop({'disabled':true}).html('<i class="spinner-border spinner-border-sm"></i> Creating...');
			setTimeout(() => {
				var fd = new FormData(form);
				var returns = formsubmission({"method":"POST", "target":'<?= base_url('admin/event/add'); ?>', "formdata":fd });
				$(form).find('button:submit').prop({'disabled':false}).html('Create');
				
				if(returns.access == false) { window.location.replace("<?= base_url('admin'); ?>"); }
				else if(returns.status == false) { notification({ 'type': 'danger', 'position': 'bottom-center', 'timer':5, 'title':returns.title, 'msg': returns.msg }); }
				else { window.location.replace("<?= base_url('admin/dashboard'); ?>"); }
			}, 1);
			return false;
		}
	});
});
</script>
</body>
</html>