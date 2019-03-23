<?php $this->load->view('header_view'); ?>

<script>
    $(document).ready(function () {
        var table = $('#dataTables-example').DataTable({
            "responsive": true,
            "order": [[ 1, "desc" ]],
            "scrollX": "true",
            "ordering": false,
            "searching": false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            "stateSave": true,
            "lengthChange": false,
            "oLanguage": {
                       "sProcessing": '<img class="loading" src="<?php echo base_url() . 'assets/images/loading.gif'; ?>">',
                     },
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo base_url()?>purchaseRequisition/listpr",
                "type": "POST",
                "data": function(data){
                    data.idpr = $("#filter_id").val();
                }
            }
        });


        $('#btn-filter').click(function(){ //button filter event click
            table.ajax.reload();  //just reload table
        });

        $('#clear-state').click(function(){ //button filter event click
            table.state.clear();
            $('#form-filter')[0].reset();
            table.ajax.reload();
        });

        $("body").on('click', '#filter_pr', function(event) {
            event.preventDefault();

            $(".selectpicker").select2({
                placeholder: "Please Select"
            });

            $('#myModal').modal('toggle');
        });
    });
</script>

<div class="container" style="margin-top: 10px;">

    <div style="padding-bottom: 10px;">
        <button id="filter_pr" class="btn btn-success btn-sm"><i class="fa fa-filter" aria-hidden="true"></i> Filter</button>
        <button id="clear-state" class="btn btn-success btn-sm"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</button>
        <!-- <a href="<?php //echo base_url(); ?>purchaseRequisition/newPr" class="btn btn-primary btn-sm" title="">PR Baru</a> -->
    </div>

	<div class="panel panel-primary">
		<div class="panel-heading">Data Purchase Requisition</div>

		<div class="panel-body">
			<table width="100%" class="table table-hover" id="dataTables-example" style='table-layout: fixed;'>
				<thead>
					<tr>
						<td width="10%">ID PR</td>
						<td width="15%">Tanggal PR</td>
						<td width="15%">Departemen</td>
                        <td width="10%">Section</td>
                        <td width="20%">User</td>
                        <td width="15%">Supplier</td>
                        <td width="15%">Proses BM</td>
					</tr>
				</thead>
			</table>
		</div>
	</div>

    <!-- <div style="padding-bottom: 10px;">
        <a href="<?php //echo base_url(); ?>purchaseRequisition/newPr" class="btn btn-primary input-sm" title="">PR Baru</a>
    </div> -->

</div>

<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Filter Purchase Requisition</h4>
            </div>
            <form action="<?php echo base_url(); ?>purchaseRequisition/filterPr" id="form-filter" method="GET" accept-charset="utf-8">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label input-sm">ID PR</label>
                            <div class="col-md-8">
                                <input type="text" name="filter_id" id="filter_id" class="form-control input-sm" placeholder="id pr">
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label input-sm">Tanggal PR</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" name="filter_tgl1" class="form-control input-sm" placeholder="id pr">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" name="filter_tgl2" class="form-control input-sm" placeholder="id pr">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label input-sm">Departemen</label>
                            <div class="col-md-8">
                                <?php

                                    // $options = array(
                                    //         'class' => 'selectpicker form-control',
                                    //         'style' => 'width:100%',
                                    //     );
                                    //
                                    // echo form_dropdown('filter_dept', $dept, '', $options);

                                ?>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label input-sm">Section</label>
                            <div class="col-md-8">
                                <?php

                                    // $options = array(
                                    //         'class' => 'selectpicker form-control',
                                    //         'style' => 'width:100%',
                                    //     );
                                    //
                                    // echo form_dropdown('filter_section', $section, '', $options);

                                ?>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label input-sm">User</label>
                            <div class="col-md-8">
                                <?php

                                    // $options = array(
                                    //         'class' => 'selectpicker form-control',
                                    //         'style' => 'width:100%',
                                    //     );
                                    //
                                    // echo form_dropdown('filter_user', $user, '', $options);

                                ?>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="row" style="padding-bottom: 10px;">
                        <div class="form-group">
                            <label class="col-md-2 control-label input-sm">Remark</label>
                            <div class="col-md-8">
                                <textarea name="filter_remark" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label input-sm">Approve BM</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" name="filter_tglbm1" class="form-control input-sm" placeholder="id pr">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" name="filter_tglbm2" class="form-control input-sm" placeholder="id pr">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->


                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                    <button type="button" class="btn btn-primary" id="btn-filter" data-dismiss="modal">Filter</button>
                    <!-- <input type="submit" class="btn btn-primary" value="Filter"> -->
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('footer_view'); ?>
