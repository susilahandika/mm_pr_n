$(document).ready(function() {
    var index_file = 0;
    var index_pnw = 0;
    var index_dtl = $("#body_table>tr").length;

    $(".dtl_satuan").load('getSatuan/');

	$("#bt_add").click(function(event) {
		index_file += 1;
		$("#fr_file").append('<div class="row" style="margin-top:5px;">' +
									'<div class="col-sm-10"><input type="file" class="form-control input-sm" name="file_upload[]" value="" placeholder=""></div>' +
									'<div class="col-sm-1"><a class="btn btn-danger btn-sm" id="bt_del"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>' +
								'</div>');
	});

	$("#bt_add_pnw").click(function(event) {
		index_pnw += 1;
		$("#fr_pnw").append('<div class="row" style="margin-top:5px;">' +
									'<div class="col-sm-10"><input type="file" class="form-control input-sm" name="file_pnw[]" value="" placeholder=""></div>' +
									'<div class="col-sm-1"><a class="btn btn-danger btn-sm" id="bt_del"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>' +
								'</div>');

	});

	$("#bt_add_dtl").click(function(event) {

		index_dtl += 1;
		$("#body_table").append('<tr>' +
									'<td>' +
										'<div class="input-group">' +
						                    '<input type="hidden" id="hd_dtl_item_' + index_dtl + '" name="hd_dtl_item[]" value="">' +
						                    '<input type="text" class="form-control input-sm dtl_item" id="dtl_item_' + index_dtl + '" name="dtl_item[]" placeholder="Search&hellip;">' +
						                    '<span class="input-group-btn">' +
						                        '<button id="cari_item" type="button" class="btn btn-default btn-sm" ><i class="fa fa-search" aria-hidden="true"></i></button>' +
						                    '</span>' +
						                '</div>' +
									'</td>' +
									'<td>' +
										'<input type="text" class="form-control input-sm" name="dtl_qty_ord[]" placeholder="qty">' +
									'</td>' +
									'<td>' +
										'<select name="dtl_satuan[]" class="form-control input-sm dtl_satuan"></select>' +
									'</td>' +
									'<td>' +
										'<input type="text" class="form-control input-sm" name="dtl_qty_app[]" placeholder="qty" disabled="disabled">' +
									'</td>' +
									'<td>' +
										'<input type="text" class="form-control input-sm" name="dtl_harga[]" placeholder="qty" disabled="disabled">' +
									'</td>' +
									'<td>' +
										'<input type="text" class="form-control input-sm" name="dtl_total[]" placeholder="qty" disabled="disabled">' +
									'</td>' +
									'<td>' +
										'<a class="btn btn-danger input-sm addBtnRemove" id="bt_del_dtl"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>' +
									'</td>' +
								'</tr>');

		$(".dtl_satuan").load('getSatuan/');

	});

    $("body").on('click', '.addBtnRemove', function(event) {
		event.preventDefault();
		$(this).parents(':eq(1)').remove();
		index_dtl -= 1;
	});

	$("body").on('click', '#bt_del', function(event) {
		event.preventDefault();
		$(this).parents(':eq(1)').remove();
	});

	$("body").on('click', '#bt_del_pnw', function(event) {
		event.preventDefault();
		$(this).parents(':eq(1)').remove();
	});

	$("body").on('change', '.txt_dept', function(event) {
		event.preventDefault();
		$(".txt_section").load('getSection/' + $('.txt_dept').val());
		$(".txt_dept_head").load('getDeptHead/' + $('.txt_dept').val());
	});

	$("body").on('click', '#cari_item', function(event) {
		event.preventDefault();
		// alert('asd' + $('#tbl_dtl tr').index($(this).closest('tr')));
		// $("#hd_item").val($('#tbl_dtl tr').index($(this).closest('tr')));

		$("#hd_item").val($(this).closest('div').find('.dtl_item').attr('id'));
		$('#myModal').modal('show');
	});

});