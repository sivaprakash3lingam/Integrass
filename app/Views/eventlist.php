<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
<?php echo view("stylesheet"); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('css/datatables.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('css/datatables.bootstrap5.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('css/datepicker.min.css'); ?>">
</head>

<body>
<?php echo view('topheader', ['menu'=>[]]); ?>
	<section class="grey lighten-4 py-2 d-print-none">
		<div class="container-fluid">
			<h1 class="h5 font-weight-bold mb-0">List of Events</h1>
		</div>
	</section>

	<section class="py-3">
		<div class="container-fluid">
			<?php echo (isset($alert) && !empty($alert) ? $alert : ''); ?>
			<div class="row">
				<div class="col-lg-2 col-md-3">
					<div class="form-outline mb-3">
						<input type="text" name="from" id="from" class="form-control" value="<?= date('Y-m-01') ?>" />
						<label class="form-label">Start Date</label>
					</div>
				</div>
				<div class="col-lg-2 col-md-3">
					<div class="form-outline mb-3">
						<input type="text" name="to" id="to" class="form-control" value="<?= date('Y-m-d'); ?>" />
						<label class="form-label">End Date</label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
					<div class="form-outline mb-3">
						<input type="text" name="title" id="title" class="form-control" value="" />
						<label class="form-label">Title</label>
					</div>
				</div>
				<div class="col-lg-2 col-md-2"><button type="button" class="btn btn-primary w-100 mb-3" id="btn_filter">Filter</button></div>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered table-sm" id="eventlist"><thead class="table-active"></thead></table>
			</div>
		</div>
	</section>

	<?php echo view('footer'); ?>
</div>
<?php echo view("javascript"); ?>
<script type="text/javascript" src="<?= base_url('js/datatables.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('js/datatables.bootstrap5.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('js/datepicker.min.js'); ?>"></script>
<script>
$(document).ready(function() {
	$("input[name='from']").datepicker({ format: "yyyy-mm-dd", autoclose: true, todayHighlight: true })
	.on('changeDate', function(){
		document.querySelectorAll('.form-outline').forEach((formOutline) => { new mdb.Input(formOutline).init();
			($(formOutline).find('input').attr('type') == 'file' ? $(formOutline).find('input').addClass('active') : '');
		});
		$("input[name='to']").datepicker('setfrom', new Date($(this).val()));
	});
	$("input[name='to']").datepicker({ format: "yyyy-mm-dd", autoclose: true, todayHighlight: true })
	.on('changeDate', function(){
		document.querySelectorAll('.form-outline').forEach((formOutline) => { new mdb.Input(formOutline).init();
			($(formOutline).find('input').attr('type') == 'file' ? $(formOutline).find('input').addClass('active') : '');
		});
		$("input[name='from']").datepicker('setto', new Date($(this).val()));
	});
	$('table#eventlist').DataTable({
		processing: true,
		serverSide : true,
		searching: false,
		fixedHeader: true,
		bLengthChange: false,
		bAutoWidth: false,
		ajax: {
			type: "GET",
			url: "<?= base_url('eventlist'); ?>",
			data: { "from": function() { return $("input[name='from']").val(); },
					"to": function() { return $("input[name='to']").val() },
					"title": function() { return $("input[name='title']").val() },
					"privacy": function() { return $("select[name='privacy']").val() },
					"status": function() { return $("select[name='status']").val() }
			},
			async: false,
			catch: false,
			error: function (xhr, textstatus) { console.log(xhr); },
		},
		lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
		bSort: false,
		destroy: true,
		initComplete: function (settings, json) {
		},
		columns: [
			{ title: "Start Date / Time", class: "text-center p-1", data: null, width:"10%",
				render: function (data, type, full, meta) { return full.startdate+' / '+full.starttime; }
			},
			{ title: "End Date / Time", class: "text-center p-1", data: null, width:"10%",
				render: function (data, type, full, meta) { return full.enddate+' / '+full.endtime; }
			},
			{ title: "Event Details", data: null, class: "p-1",
				render: function (data, type, full, meta) {
					return '<p class="text-primary fw-bold mb-0">'+full.title+'</p>' + (full.desc != '' && full.desc != null ? '<p>'+full.desc+'</p>' : '');
				}
			},
			{ title: "Others", data: null, class: " p-1", width:"25%",
				render: function (data, type, full, meta) {
					return '<p class="mb-0"><strong class="fw-bold">Privacy: </strong>'+full.privacy+'</p>' +
						'<p class="mb-0"><strong class="fw-bold">Status: </strong>'+full.status+'</p>'+
						(full.created != '' && full.created != null ? '<p class="small mb-0"><strong class="fw-bold">Created: </strong>'+full.created+'</p>' : '') +
						(full.updated != '' && full.updated != null ? '<p class="small mb-0"><strong class="fw-bold">Last Updated: </strong>'+full.updated+'</p>' : '');
				}
			}]
	});
	$(document).on("click", "button#btn_filter", function(e) {
		$('table#eventlist').DataTable().ajax.reload(null, false);
	});
});
</script>
</body>
</html>