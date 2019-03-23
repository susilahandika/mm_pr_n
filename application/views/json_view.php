<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/dataTables.bootstrap.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/select2.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/font-awesome.min.css"/>

    <script src="<?php echo base_url(); ?>/assets/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/select2.min.js"></script>

    <script type="text/javascript">
    	$(document).ready(function() {
    	    $('#example').DataTable( {
    	        "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
         
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo base_url()?>json/listpr",
                    "type": "POST"
                }
    	    } );
    	} );
    </script>
</head>
<body>

<table id="example" class="table table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>id_pr</th>
            <th>tgl_pr</th>
            <th>deptname</th>
            <th>secname</th>
            <th>nama</th>
            <th>sup_name</th>
            <th>tgl_prs_bm</th>
        </tr>
    </thead>
</table>
	
</body>
</html>