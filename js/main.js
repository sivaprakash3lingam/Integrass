$(document).ready(function (e) {

	function useragent() {
		return (navigator.userAgent.match(/Android|Silk/i) ? "Android" : (navigator.userAgent.match(/iPhone|iPad|iPod/i) ? "iOS" : (navigator.userAgent.match(/IEMobile/i) ? "Windows" : "Default")));
	};


	$(document).on("click", "#sidebarCollapse", function () { $(".sidebar").toggleClass('active'); });

	$('.carousel').carousel();

	$(".collapse.show").each(function () { $(this).prev(".card-header .catd-title").find(".fas").addClass("fa-minus").removeClass("fa-plus"); });
	$(".collapse").on('show.bs.collapse', function () { $(this).prev(".card-header").find(".fas").removeClass("fa-plus").addClass("fa-minus"); })
		.on('hide.bs.collapse', function () { $(this).prev(".card-header").find(".fas").removeClass("fa-minus").addClass("fa-plus"); });

	$(document).on("click", ".cmc", function (e) {
		e.preventDefault();
		var cthis = $(this); var md = {}, input = {};
		$.each(cthis.data(), function (key, value) { (key.search('form_') == -1 ? md[key] = value : input[key.replace("form_", "")] = value); }); md['input'] = input;
		modalprocess(md);
		setTimeout(() => { (typeof eval(jQuery(e.currentTarget).data("callback")) == 'function' ? eval(jQuery(e.currentTarget).data("callback"))() : ''); }, 1000);
		return false;
	});

	($('[data-fancybox="gallery"]').length > 0 ? $('[data-fancybox="gallery"]').fancybox({ loop: true, transitionEffect: "zoom-in-out", touch: { vertical: true, momentum: true } }) : '');
});
/****************************************************************************************************
	Modal Processing..
****************************************************************************************************/
function modalprocess(arg) {
	var status = false;
	if ('affect' in arg) {
		$("div#" + arg.affect).removeClass().addClass('modal fade ' + ('position' in arg ? arg.position : ""));
		$("div#" + arg.affect + " .modal-dialog").removeClass().addClass('modal-dialog ' + ('style' in arg ? arg.style : ""));
		$("div#" + arg.affect + " div.modal-dialog div.modal-content div.modal-header .modal-title").html('title' in arg ? arg.title : "");
		$("div#" + arg.affect + " div.modal-dialog div.modal-content div.modal-body").html('msg' in arg ? arg.msg : "");
		('footer' in arg && arg.footer == true && 'footer_text' in arg && arg.footer_text != '' ? $("div" + arg.affect + " div.modal-dialog div.modal-content div.modal-footer").removeClass('d-none').html(arg.footer_text) : $("div" + arg.affect + " div.modal-dialog div.modal-content div.modal-footer").addClass('d-none').html(''));
		var common_modal = new mdb.Modal(document.getElementById(arg.affect), {});
		common_modal.show();
		setTimeout(() => {
			if ('target' in arg) {
				$("div#" + arg.affect + " div.modal-dialog div.modal-content div.modal-body").html('<p class="text-center h3"><i class="spinner-border text-primary"></i></p>');
				setTimeout(function () {
					var fv = new FormData();
					if ('input' in arg) { $.each(arg.input, function (key, value) { fv.set(key, value); }); }
					var returns = formsubmission({ "target": arg.target, "formdata": fv });
					$("div#" + arg.affect + " div.modal-dialog div.modal-content div.modal-body").html(returns.msg);
					document.querySelectorAll('.form-outline').forEach((formOutline) => {
						new mdb.Input(formOutline).init();
						($(formOutline).find('input').attr('type') == 'file' ? $(formOutline).find('input').addClass('active') : '');
					});
				}, 1000);
			}
		}, 1);
		setTimeout(() => { ('callback' in arg && typeof eval(arg.callback) == 'function' ? eval(arg.callback) : ''); }, 1);
	}
	return status;
};
/****************************************************************************************************
	Ajax Form Submitting...
****************************************************************************************************/
function formsubmission(arg) {
	var returns = { 'access': false, 'status': false, 'title': 'Error', 'msg': 'Somthing went Wrong...' };
	var btn = ('btn' in arg && typeof arg.btn === 'object' ? { 'txt': ('txt' in arg.btn ? arg.btn['txt'] : "submit"), 'pro': ('pro' in arg.btn ? arg.btn['pro'] : "Submitting...") } : { "txt": "Submit", "pro": "Submitting..." });
	$.ajax({
		type: ('method' in arg && arg.method != '' ? arg.method : "GET"), dataType: "JSON", url: arg.target, data: arg.formdata, async: false, cache: false, contentType: false, processData: false, headers: { "cache-control": "no-cache" }, iframe: true, enctype: 'multipart/form-data',
		timeout: 30000, beforeSend: function () { },
		error: function (xmlhttprequest, textstatus, message) {
			returns['title'] = (textstatus === "timeout" ? 'Process Timeout' : 'Error Occured');
			returns['msg'] = (textstatus === "timeout" ? 'Process Timeout. Please Try Again.' : 'Something went wrong...');
		},
		success: function (m) { returns = m; },
		complete: function (m) { returns = m.responseJSON; }
	});
	return returns;
};

/****************************************************************************************************
	Notification Alert
****************************************************************************************************/
function notification(arg) {
	const alert = document.createElement('div');
	var alerttype = {
		'type': {
			'primary': 'alert-primary', 'secondary': 'alert-secondary', 'info': 'alert-info', 'warning': 'alert-warning',
			'danger': 'alert-danger', 'success': 'alert-success', 'light': 'alert-light'
		},
		'icon': {
			'primary': '<i class="fas fa-info fa-2x float-start pe-1"></i>', 'secondary': '<i class="fas fa-bell fa-2x float-start pe-1 pe-2"></i>',
			'info': '<i class="fas fa-info-circle fa-2x float-start pe-1"></i>', 'warning': '<i class="fas fa-exclamation-triangle fa-2x float-start pe-1 pe-2"></i>',
			'danger': '<i class="fas fa-exclamation-triangle fa-2x float-start pe-1"></i>', 'success': '<i class="fas fa-check-circle fa-2x float-start pe-1 pe-2"></i>',
			'light': '<i class="fas fa-bell fa-2x float-start pe-1"></i>',
		},
		'position': {
			'top-center': 'alert-top-center', 'top-right': 'alert-top-right', 'bottom-right': 'alert-bottom-right',
			'bottom-center': 'alert-bottom-center', 'bottom-left': 'alert-bottom-left', 'top-left': 'alert-top-left'
		}
	};
	alert.innerHTML = '<label type="button" class="btn-sm btn-close p-2" data-mdb-dismiss="alert" aria-label="Close" ></label>' +
		'<div class="row"><div class="col-auto pe-0">' + ('type' in arg && arg.type != '' && arg.type != null && arg.type in alerttype.type ? alerttype.icon[arg.type] : alerttype.icon['primary']) + '</div>' +
		'<div class="col-auto small ps-0"><p class="alert-heading font-weight-bold small mb-0">' + ('title' in arg && arg.title != '' && arg.title != null ? arg.title : '') + '</p>' + ('msg' in arg && arg.msg != '' && arg.title != null ? '<p class="small mb-0">' + arg.msg + '</p>' : '') + '</div></div>';
	alert.classList.add('alert', 'alert-notification', 'alert-dismissible', 'fade', 'show', 'alert-fixed', 'p-1', 'd-print-none', 'd-flex', 'align-items-center');
	alert.classList.add('type' in arg && arg.type != '' && arg.type != null && arg.type in alerttype.type ? alerttype.type[arg.type] : alerttype.type['primary']);
	alert.classList.add('position' in arg && arg.position != '' && arg.position != null && arg.position in alerttype.position ? alerttype.position[arg.position] : alerttype.position['bottom-center']);
	document.body.appendChild(alert);
	('timer' in arg && arg.timer != '' && arg.timer != null ? setTimeout(() => { $('.alert.alert-notification .btn-close').trigger('click'); }, (parseInt(arg.timer) * 1000)) : '');
	return false;
};