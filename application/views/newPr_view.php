<?php $this->load->view('header_view'); ?>

<script src="<?php echo base_url(); ?>/assets/js/add_pr.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#dataTables-example').DataTable({
	        responsive: true,
	        "lengthMenu": [[5], [5]],
	    });

	    $('#dataTables-example tbody').on('dblclick', 'tr', function () {
			var data = table.row( this ).data();
			$('#myModal').modal('toggle');
			/*$("#hd_" + $("hd_item").val()).val(data[0]);
			$("#" + $("hd_item").val()).val(data[1]);*/

			/*$("#hd_dtl_item_"+$("#hd_item").val()).val(data[0]);
			$("#dtl_item_"+$("#hd_item").val()).val(data[1]);*/

			$("#"+$("#hd_item").val()).val(data[0]);
			$("#"+$("#hd_item").val()).val(data[1]);
		} );
    });
</script>

<div class="container">
	<div class="page-header"><h3>PR Baru</h3></div>

	<?php if(isset($error) and $error){ ?>
        <div class="alert alert-danger" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <ul class="">
                <?php 
                	echo validation_errors(); 
                	echo $this->upload->display_errors();
                ?>
            </ul>
        </div>
    <?php } ?>

	<form action="<?php echo base_url(); ?>purchaseRequisition/submit_pr" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
		<div class="row">
			<div class="form-group"">
		        <label class="col-md-1 control-label input-sm">Department</label>
		        <div class="col-md-5">
		            <?php 

						$options = array(
								'class' => 'selectpicker form-control txt_dept',
							);

		            	echo form_dropdown('txt_dept', $dept, set_value('txt_dept'), $options); 

		            ?>
		        </div>

		        <label class="col-md-1 control-label input-sm">PR Date</label>
		        <div class="col-md-5">
		            <input type="text" name="txt_date" class="form-control input-sm" value="<?php echo $tanggal; ?>" placeholder="" disabled="disabled">
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

		            	echo form_dropdown('txt_section', $section, set_value('txt_section'), $options); 

		            ?>
		        </div>

		        <label class="col-md-1 control-label input-sm">Supplier</label>
		        <div class="col-md-5">
		            <?php 

						$options = array(
								'class' => 'selectpicker form-control txt_supplier disabled',
								'disabled' => 'disabled',
							);

		            	echo form_dropdown('txt_supplier', $supplier, set_value('txt_supplier'), $options); 

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
									<td width="10%">Qty Ord</td>
									<td width="10%">Satuan</td>
									<td width="10%">Qty App</td>
									<td width="15%">Harga</td>
									<td width="15%">Total</td>
									<td width="5%" align="center">...</td>
								</tr>
							</thead>

							<tbody id="body_table">
								<?php if(isset($error) and $error){ ?>

								<?php for($x=0; $x<count(set_value('hd_dtl_item')); $x++){ ?>

									<tr>
										<td>
											<div class="input-group">
												<input type="hidden" id="<?php echo 'hd_dtl_item_' . $x; ?>" name="hd_dtl_item[]" value="<?php echo set_value('hd_dtl_item[' . $x . ']'); ?>">
							                    <input type="text" class="form-control input-sm dtl_item" id="<?php echo 'dtl_item_' . $x; ?>" name="dtl_item[]" value="<?php echo set_value('dtl_item[' . $x . ']'); ?>" placeholder="Item PR">
							                    <span class="input-group-btn">
							                        <button id="cari_item" type="button" class="btn btn-default btn-sm"><i class="fa fa-search" aria-hidden="true"></i></button>
							                    </span>
							                </div>
										</td>
										<td>
											<input type="text" class="form-control input-sm" name="dtl_qty_ord[]" value="<?php echo set_value('dtl_qty_ord[' . $x . ']'); ?>" placeholder="qty">
										</td>
										<td>
						                    <?php 

						        				$options = array(
						        						'class' => 'form-control input-sm',
						        					);

						                    	echo form_dropdown('dtl_satuan[]', $satuan, set_value('dtl_satuan[' . $x . ']'), $options); 

						                    ?>
										</td>
										<td>
											<input type="text" class="form-control input-sm" name="dtl_qty_app[]" value="<?php echo set_value('dtl_qty_app[' . $x . ']'); ?>" placeholder="qty" disabled="disabled">
										</td>
										<td>
											<input type="text" class="form-control input-sm" name="dtl_harga[]" value="<?php echo set_value('dtl_harga[' . $x . ']'); ?>" placeholder="harga" disabled="disabled">
										</td>
										<td>
											<input type="text" class="form-control input-sm" name="dtl_total[]" value="<?php echo set_value('dtl_total[' . $x . ']'); ?>" placeholder="total" disabled="disabled">
										</td>
										<td>
											<a class="btn btn-danger btn-sm addBtnRemove" id="bt_del_dtl"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
										</td>
									</tr>

									<?php } ?>

								<?php } else{ ?>

									<tr>
										<td>
											<div class="input-group">
												<input type="hidden" id="hd_dtl_item_1" name="hd_dtl_item[]" value="">
							                    <input type="text" class="form-control input-sm dtl_item" id="dtl_item_1" name="dtl_item[]" placeholder="Item PR">
							                    <span class="input-group-btn">
							                        <button id="cari_item" type="button" class="btn btn-default btn-sm"><i class="fa fa-search" aria-hidden="true"></i></button>
							                    </span>
							                </div>
										</td>
										<td>
											<input type="text" class="form-control input-sm" name="dtl_qty_ord[]" placeholder="qty">
										</td>
										<td>
											<select name="dtl_satuan[]" class="form-control input-sm dtl_satuan">
									        </select>
										</td>
										<td>
											<input type="text" class="form-control input-sm" name="dtl_qty_app[]" placeholder="qty" disabled="disabled">
										</td>
										<td>
											<input type="text" class="form-control input-sm" name="dtl_harga[]" placeholder="harga" disabled="disabled">
										</td>
										<td>
											<input type="text" class="form-control input-sm" name="dtl_total[]" placeholder="total" disabled="disabled">
										</td>
										<td>
											<a class="btn btn-danger btn-sm addBtnRemove" id="bt_del_dtl"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
										</td>
									</tr>

								<?php } ?>
							</tbody>
						</table>

						<div class="row">

							<div class="col-md-4" style="padding-top: 1px;">
								<a id="bt_add_dtl" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
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
                    <?php 

                    	$remark = array(
							''   =>'',
							'10' =>'New Store',
							'11' =>'Rusak',
							'99' =>'Lain-lain',
                    	);

        				$options = array(
        						'class' => 'selectpicker form-control txt_remark',
        					);

                    	echo form_dropdown('txt_remark', $remark, set_value('txt_remark'), $options); 

                    ?>
		        </div>
		    </div>	
		</div>

		<div class="row">
			<div class="form-group">
		        <label class="col-md-1 control-label input-sm"></label>
		        <div class="col-md-5">
		            <textarea name="txt_dtl_remark" class="form-control" rows="5"><?php echo set_value('txt_dtl_remark'); ?></textarea>
		        </div>
		    </div>	
		</div>

		<div class="row" style="margin-top: 5px;">
			<div class="form-group">
		        <label class="col-md-1 control-label input-sm">Mengetahui</label>
		        <div class="col-md-5">
		            <!-- <select id="txt_dept_head" name="txt_dept_head" class="selectpicker form-control txt_dept_head"></select> -->
	                <?php 

	    				$options = array(
	    						'class' => 'selectpicker form-control txt_dept_head',
	    					);

	                	echo form_dropdown('txt_dept_head', $dept_head, set_value('txt_dept_head'), $options); 

	                ?>
		        </div>
		    </div>	
		</div>

		<div class="row">
			<div class="form-group">
		        <label class="col-md-1 control-label input-sm">Pembayaran</label>
		        <div class="col-md-5">
		            <select id="kota" name="txt_pmb" class="selectpicker form-control">
			            <option value=""></option>
			            <option value="1">Cash</option>
			            <option value="2">Credit</option>
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
								<div class="col-sm-10"><input type="file" class="form-control input-sm" name="file_upload[]" value="" placeholder=""></div>
							</div>
						</div>

		            	<a style="margin-top: 5px;" class="btn btn-warning btn-sm" id="bt_add"><span class="glyphicon glyphicon-plus" aria-hidden="true"></a>
		            </div>
		        </div>
		    </div>	
		</div>

		<!-- <div class="row">
			<div class="form-group">
		        <label class="col-md-1 control-label input-sm">Penawaran</label>
		        <div class="col-md-5">
		            <div style="border: 1px solid grey; padding: 5px; margin-bottom: 5px; border-radius: 5px;">
		            	
						<div id="fr_pnw">
							<div class="row">
								<div class="col-sm-10"><input type="file" class="form-control input-sm" name="file_pnw[]" value="" placeholder=""></div>
							</div>
						</div>
		
		            	<a style="margin-top: 5px;" class="btn btn-warning input-sm" id="bt_add_pnw"><span class="glyphicon glyphicon-plus" aria-hidden="true"></a>
		            </div>
		        </div>
		    </div>	
		</div> -->

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
		            <input type="submit" class="btn btn-primary btn-sm" name="simpan_pr" value="Simpan">
		            <a href="<?php echo base_url() ?>purchaseRequisition" class="btn btn-warning btn-sm">Back</a>
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

<?php $this->load->view('footer_view'); ?>