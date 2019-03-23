<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/dataTables.bootstrap.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/select2.min.css"/>

    <script src="<?php echo base_url(); ?>/assets/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/select2.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/add_pr.js"></script>

    <script>
        $(document).ready(function () {
            $(".selectpicker").select2({
                placeholder: "Please Select"
            });

            var table = $('#dataTables-example').DataTable({
		        responsive: true,
		        "lengthMenu": [[5], [5]],
		    });

		    $('#dataTables-example tbody').on('dblclick', 'tr', function () {
				var data = table.row( this ).data();
				$('#myModal').modal('toggle');
				/*$("#hd_" + $("hd_item").val()).val(data[0]);
				$("#" + $("hd_item").val()).val(data[1]);*/

				$("#hd_dtl_item_"+$("#hd_item").val()).val(data[0]);
				$("#dtl_item_"+$("#hd_item").val()).val(data[1]);
			} );
        });
    </script>
</head>
<body>

<div class="container">
	<div class="page-header"><h3>PR Baru</h3></div>

	<form action="submit_pr" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
		<div class="row">
			<div class="form-group"">
		        <label class="col-md-1 control-label input-sm">Department</label>
		        <div class="col-md-5">
		            <?php 

						$options = array(
								'class' => 'selectpicker form-control txt_dept',
							);

		            	echo form_dropdown('dept', $dept, '', $options); 

		            ?>
		        </div>

		        <label class="col-md-1 control-label input-sm">PR Date</label>
		        <div class="col-md-5">
		            <input type="text" name="" class="form-control input-sm" value="<?php echo $tanggal; ?>" placeholder="" disabled="disabled">
		        </div>
		    </div>
		</div>

		<div class="row" style="margin-top: 5px;">
			<div class="form-group">
		        <label class="col-md-1 control-label input-sm">Section</label>
		        <div class="col-md-5">
		            <?php 

						$options = array(
								'class' => 'selectpicker form-control txt_section',
							);

		            	echo form_dropdown('section', '', '', $options); 

		            ?>
		        </div>

		        <label class="col-md-1 control-label input-sm">Supplier</label>
		        <div class="col-md-5">
		            <?php 

						$options = array(
								'class' => 'selectpicker form-control txt_supplier',
							);

		            	echo form_dropdown('supplier', $supplier, '', $options); 

		            ?>
		        </div>
		    </div>	
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">Detail PR</div>

					<div class="panel-body">

						<table class="table table-bordered" id="tbl_dtl">
							<thead>
								<tr>
									<td width="30%">Item PR</td>
									<td width="15%">Qty Ordered</td>
									<td width="15%">Satuan</td>
									<td width="15%">Qty Apprpoved</td>
									<td width="15%" align="center">...</td>
								</tr>
							</thead>

							<tbody id="body_table">
								<tr>
									<td width="30%">
										<div class="input-group">
											<input type="hidden" id="hd_dtl_item_1" name="hd_dtl_item[]" value="">
						                    <input type="text" class="form-control input-sm dtl_item" id="dtl_item_1" name="dtl_item[]" placeholder="Item PR">
						                    <span class="input-group-btn">
						                        <!-- <button id="cari_item" type="button" class="btn btn-default input-sm" data-toggle="modal" data-target="#myModal">Search</button> -->
						                        <button id="cari_item" type="button" class="btn btn-default input-sm">Search</button>
						                    </span>
						                </div>
									</td>
									<td width="15%">
										<input type="text" class="form-control input-sm" name="dtl_qty_ord[]" placeholder="qty">
									</td>
									<td width="15%">
										<select name="dtl_satuan[]" class="form-control input-sm dtl_satuan">
								        </select>
									</td>
									<td width="15%">
										<input type="text" class="form-control input-sm" name="dtl_qty_app[]" placeholder="qty">
									</td>
									<td width="15%"></td>
								</tr>
							</tbody>
						</table>

						<div class="row">

							<div class="col-md-4" style="padding-top: 1px;">
								<a id="bt_add_dtl" class="btn btn-warning input-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
		        <label class="col-md-1 control-label input-sm">Remark</label>
		        <div class="col-md-5">
		            <select id="kota" name="kota" class="selectpicker form-control">
			            <option value=""></option>
			            <option value="Jakarta">New Store</option>
			            <option value="Bogor">Rusak</option>
			            <option value="Depok">Lain-lain</option>
			        </select>
		        </div>
		    </div>	
		</div>

		<div class="row">
			<div class="form-group">
		        <label class="col-md-1 control-label input-sm"></label>
		        <div class="col-md-5">
		            <textarea name="" class="form-control" rows="5"></textarea>
		        </div>
		    </div>	
		</div>

		<div class="row" style="margin-top: 5px;">
			<div class="form-group">
		        <label class="col-md-1 control-label input-sm">Mengetahui</label>
		        <div class="col-md-5">
		            <select id="kota" name="kota" class="selectpicker form-control">
			            <option value=""></option>
			            <option value="Jakarta">New Store</option>
			            <option value="Bogor">Rusak</option>
			            <option value="Depok">Lain-lain</option>
			        </select>
		        </div>
		    </div>	
		</div>

		<div class="row">
			<div class="form-group">
		        <label class="col-md-1 control-label input-sm">Pembayaran</label>
		        <div class="col-md-5">
		            <select id="kota" name="kota" class="selectpicker form-control">
			            <option value=""></option>
			            <option value="Jakarta">New Store</option>
			            <option value="Bogor">Cash</option>
			            <option value="Depok">Credit</option>
			        </select>
		        </div>
		    </div>	
		</div>

		<div class="row">
			<div class="form-group">
		        <label class="col-md-1 control-label input-sm">File Upload</label>
		        <div class="col-md-5">
		            <div style="border: 1px solid grey; padding: 5px; margin-bottom: 5px; border-radius: 5px;">
		            	
						<div id="fr_file">
							<div class="row">
								<div class="col-md-12" id="fr_file2">
									<div class="form-group">
										<div class="col-sm-11 row"><input type="file" class="form-control input-sm" name="file_upload[]" value="" placeholder=""></div>
										<!-- <div class="col-sm-1 "><a class="btn btn-danger" id="bt_del">del</a></div> -->
									</div>
								</div>
							</div>
						</div>

		            	<a class="btn btn-warning input-sm" id="bt_add"><span class="glyphicon glyphicon-plus" aria-hidden="true"></a>
		            </div>
		        </div>
		    </div>	
		</div>

		<div class="row">
			<div class="form-group">
		        <label class="col-md-1 control-label input-sm">Penawaran</label>
		        <div class="col-md-5">
		            <div style="border: 1px solid grey; padding: 5px; margin-bottom: 5px; border-radius: 5px;">
		            	
						<div id="fr_pnw">
							<div class="row">
								<div class="col-md-12" id="fr_pnw2">
									<div class="form-group">
										<div class="col-sm-11 row"><input type="file" class="form-control input-sm" name="file_pnw[]" value="" placeholder=""></div>
										<!-- <div class="col-sm-1 "><a class="btn btn-danger" id="bt_del">del</a></div> -->
									</div>
								</div>
							</div>
						</div>

		            	<a class="btn btn-warning input-sm" id="bt_add_pnw"><span class="glyphicon glyphicon-plus" aria-hidden="true"></a>
		            </div>
		        </div>
		    </div>	
		</div>

		<div class="row">
			<div class="form-group">
		        <label class="col-md-1 control-label input-sm">Menyetujui</label>
		        <div class="col-md-5">
		            <div style="border: 1px solid grey; padding: 5px; margin-bottom: 5px; border-radius: 5px;">
		            	asd
		            	asd
		            	asd
		            	asd
		            	asd
		            </div>
		        </div>
		    </div>	
		</div>

		<div class="row">
			<div class="form-group">
				<label class="col-md-1 control-label input-sm"></label>
		        <div class="col-md-5">
		            <input type="submit" class="btn btn-primary input-sm" name="simpan_pr" value="Simpan">
		        </div>
		    </div>	
		</div>
	</form>

</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
            	<input type="hidden" id="hd_item" name="" value="">
                <table width="100%" class="table table-striped table-hover" id="dataTables-example">
                	<thead>
                		<tr>
                			<td>Nomer Item</td>
                			<td>Nama Item</td>
                		</tr>
                	</thead>

                	<tbody>
                	<?php foreach ($item as $value): ?>
                		<tr>
                			<td><?php echo $value['item_no']; ?></td>
                			<td><?php echo $value['item_name']; ?></td>
                		</tr>
                	<?php endforeach ?>
                	</tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

</body>
</html>