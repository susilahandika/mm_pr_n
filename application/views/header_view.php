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
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/font-awesome.min.css"/>

    <script src="<?php echo base_url(); ?>/assets/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/select2.min.js"></script>

	<style media="screen">
		.loading{
			bottom: 0;
			height: 175px;
			left: 0;
			margin: auto;
			position: absolute;
			right: 0;
			top: 0;
			width: 175px;
			z-index:999;
		}
	</style>

    <script>
        $(document).ready(function () {
            $(".selectpicker").select2({
                placeholder: "Please Select"
            });
        });
    </script>
</head>
<body>
