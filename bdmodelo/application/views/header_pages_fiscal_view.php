<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>BD Serviços</title>

        <!-- Bootstrap -->
		
        <link href="<?php echo $this->config->base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $this->config->base_url(); ?>assets/css/waves.min.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>assets/css/nanoscroller.css">
		
         <link href="<?php echo $this->config->base_url(); ?>assets/css/morris-0.4.3.min.css" rel="stylesheet">
        <link href="<?php echo $this->config->base_url(); ?>assets/css/menu-light.css" type="text/css" rel="stylesheet">
        <link href="<?php echo $this->config->base_url(); ?>assets/css/style.css" type="text/css" rel="stylesheet">
        <link href="<?php echo $this->config->base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo $this->config->base_url(); ?>assets/css/select.css" type="text/css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>assets/css/jquery.fileupload.css">
		
		<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap-editable.css">
		
		<link href="<?php echo $this->config->base_url(); ?>assets/css/fullcalendar.min.css" type="text/css" rel="stylesheet">		<link href="<?php echo $this->config->base_url(); ?>assets/css/summernote.css" rel="stylesheet">		<link href="<?php echo $this->config->base_url(); ?>assets/css/summernote-bs3.css" rel="stylesheet">
		
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- Static navbar -->

        <?php include('header_include.php');?>
        <section class="page">

             <?php 			if($_SESSION['login_walmart']['primeiro_acesso'] == 1){				include('sidebarfiscal.php');			}			?>

            
        </section>