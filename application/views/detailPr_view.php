<?php $this->load->view('header_view'); ?>

<script src="<?php echo base_url(); ?>/assets/js/add_dtl_pr.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#dataTables-example').DataTable({
	        responsive: true,
	        "lengthMenu": [[5], [5]],
	    });

        var tabledtl = $('#tb-dtlpr').DataTable({
	        responsive: true,
            "ordering": false,
            "searching": false,
            "lengthChange": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
	    });

	    $('#dataTables-example tbody').on('dblclick', 'tr', function () {
			var data = table.row( this ).data();
			$('#myModal').modal('toggle');
			/*$("#hd_" + $("hd_item").val()).val(data[0]);
			$("#" + $("hd_item").val()).val(data[1]);*/
			$("#"+$("#hd_item").val()).val(data[0]);
			$("#"+$("#hd_item").val()).val(data[1]);
		} );

        $('#tb-dtlpr tbody').on('change', '.qty-app', function () {
            var id = this.id;
            var idx = id.substr(7,9);

            $("#total-app"+idx).val($("#qty-app"+idx).val()*$("#harga-app"+idx).val());
		} );

        $('#tb-dtlpr tbody').on('change', '.harga-app', function () {
            var id = this.id;
            var idx = id.substr(9,11);

            $("#total-app"+idx).val($("#qty-app"+idx).val()*$("#harga-app"+idx).val());
		} );

        // $("#bt_cetakPr").click(function(){
    	// 	var idpr = $("#idpr").val();
    	// 	var param = "op=printPr&&_idpr="+idpr;
    	// 	window.open('cetak_pr.php?'+param, '_blank');
    	// });
    });
</script>

<div class="container">
	<div class="page-header"><h3>Edit PR | <?php echo $data_pr[0]['id_pr']; ?></h3></div>

	<form action="../ubahPr" method="POST" accept-charset="utf-8" enctype="multipart/form-data">

        <input type="hidden" name="hd_idpr" value="<?php echo $data_pr[0]['id_pr']; ?>">

		<div class="row">
			<div class="form-group"">
		        <label class="col-md-1 control-label input-sm">Department</label>
		        <div class="col-md-5">
		            <?php

						$options = array(
								'class'    => 'selectpicker form-control txt_dept disabled',
								'readonly' => 'readonly',
							);

		            	echo form_dropdown('txt_dept', $dept, $data_pr[0]['dept'], $options);

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
								'class'    => 'selectpicker form-control txt_section disabled',
                                'readonly' => 'readonly',
							);

		            	echo form_dropdown('txt_section', $section, $data_pr[0]['id_section'], $options);

		            ?>
		        </div>

		        <label class="col-md-1 control-label input-sm">Supplier</label>
		        <div class="col-md-5">
		            <?php

						$options = array(
								'class' => 'selectpicker form-control txt_supplier',
							);

		            	echo form_dropdown('txt_supplier', $supplier, $data_pr[0]['sups'], $options);

		            ?>
		        </div>
		    </div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">Detail PR</div>

					<div class="panel-body">

						<table class="table table-bordered" id="tb-dtlpr">
							<thead>
								<tr>
									<td width="30%">Item PR</td>
									<td width="10%">Qty Ord</td>
									<td width="10%">Satuan</td>
									<td width="10%">Qty App</td>
									<td width="15%">Harga</td>
									<td width="15%">Total</td>
									<!-- <td width="5%" align="center">...</td> -->
								</tr>
							</thead>

							<tbody id="body_table">

							<?php
							$index = 0;
							foreach ($data_dtl as $dtl){
								$index += 1;
							?>
								<tr>
									<td>
										<div class="input-group" id="inp_dtl">
											<input type="hidden" id="<?php echo 'hd_dtl_item_' . $index; ?>" name="hd_dtl_item[]" value="<?php echo $dtl['id_item']; ?>">
						                    <input type="text" class="form-control input-sm dtl_item" id="<?php echo 'dtl_item_' . $index; ?>" name="dtl_item[]" placeholder="Item PR" value="<?php echo $dtl['item_name']; ?>">
						                    <span class="input-group-btn">
						                        <!-- <button id="cari_item" type="button" class="btn btn-default input-sm" data-toggle="modal" data-target="#myModal">Search</button> -->
						                        <button id="cari_item" type="button" class="btn btn-default btn-sm"><i class="fa fa-search" aria-hidden="true"></i></button>
						                    </span>
						                </div>
									</td>
									<td>
										<input type="text" class="form-control input-sm" name="dtl_qty_ord[]" placeholder="qty" value="<?php echo $dtl['qty']; ?>">
									</td>
									<td>
										<?php

					        				$options = array(
					        						'class' => 'form-control input-sm',
					        					);

					                    	echo form_dropdown('dtl_satuan[]', $satuan, $dtl['unit'], $options);

					                    ?>
									</td>
									<td>
										<input type="text" id="<?php echo 'qty-app' . $index; ?>" class="form-control input-sm qty-app" name="dtl_qty_app[]" value="<?php echo $dtl['qtyApp']; ?>" placeholder="qty">
									</td>
									<td>
										<input type="text" id="<?php echo 'harga-app' . $index; ?>" class="form-control input-sm harga-app" name="dtl_harga[]" value="<?php echo $dtl['harga']; ?>" placeholder="harga">
									</td>
									<td>
										<input type="text" id="<?php echo 'total-app' . $index; ?>" class="form-control input-sm" name="dtl_total[]" value="<?php echo $dtl['total']; ?>" placeholder="total" readonly>
									</td>
									<!-- <td>
										<a class="btn btn-danger btn-sm addBtnRemove" id="bt_del_dtl"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>
									</td> -->
								</tr>
							<?php } ?>
							</tbody>
						</table>

						<div class="row">

							<div class="col-md-4" style="padding-top: 1px;">
								<!-- <a id="bt_add_dtl" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a> -->
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
		            <!-- <select id="kota" name="kota" class="selectpicker form-control">
			            <option value=""></option>
			            <option value="10">New Store</option>
			            <option value="11">Rusak</option>
			            <option value="99">Lain-lain</option>
			        </select> -->

                    <?php

                    $options = array(
                        'class' => 'selectpicker form-control txt_supplier',
                    );

                    echo form_dropdown('txt_remark', $remark, $data_pr[0]['remark'], $options);

                    ?>
		        </div>
		    </div>
		</div>

		<div class="row">
			<div class="form-group">
		        <label class="col-md-1 control-label input-sm"></label>
		        <div class="col-md-5">
		            <textarea name="txt_dtl_remark" class="form-control" rows="5"><?php echo  $data_pr[0]['dtl_remark'] ?></textarea>
		        </div>
		    </div>
		</div>

		<!-- <div class="row" style="margin-top: 5px;">
			<div class="form-group">
		        <label class="col-md-1 control-label input-sm">Mengetahui</label>
		        <div class="col-md-5">
                    <input type="txt_dept_head" class="form-control input-sm" value="<?php //echo $data_pr[0]['nama']; ?>" readonly >
		        </div>
		    </div>
		</div> -->

		<div class="row" style="margin-top: 5px;">
			<div class="form-group">
		        <label class="col-md-1 control-label input-sm">Pembayaran</label>
		        <div class="col-md-5">
                    <?php

                    $options = array(
                        'class' => 'selectpicker form-control txt_supplier',
                    );

                    echo form_dropdown('txt_pmb', $pmb, $data_pr[0]['pmb'], $options);

                    ?>
		        </div>
		    </div>
		</div>

		<div class="row">
			<div class="form-group">
				<label class="col-md-1 control-label input-sm"></label>
		        <div class="col-md-5">
		            <input type="submit" class="btn btn-primary btn-sm" name="simpan_pr" value="Simpan">
		            <a href="../goBack" class="btn btn-warning btn-sm">Back</a>
		            <a href="http://svmm014/mm_pr/app/cetak_pr.php?_idpr=<?php echo $data_pr[0]['id_pr']; ?>" class="btn btn-warning btn-sm" target="_blank">Cetak</a>
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
