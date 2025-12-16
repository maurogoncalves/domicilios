

<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <title>BD Servi&ccedil;os</title>



        <!-- Bootstrap -->

        <link href="<?php echo $this->config->base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <link href="<?php echo $this->config->base_url(); ?>assets/css/waves.min.css" type="text/css" rel="stylesheet">

		<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>assets/css/nanoscroller.css">

        <!--        <link rel="stylesheet" href="css/nanoscroller.css">-->

        <link href="<?php echo $this->config->base_url(); ?>assets/css/style.css" type="text/css" rel="stylesheet">

        <link href="<?php echo $this->config->base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

        <!--[if lt IE 9]>

          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

        <![endif]-->

    </head>

    <body class="account">

        <div class="container">

            <div class="row">

                <div class="account-col text-center">

                    <h1>Domicilios SmartFit</h1>

                    <h3>Acesse sua conta</h3>

					<?php

			  $attributes = array('class' => 'm-t');

			  echo form_open('verificalogin', $attributes); 

			  ?>

			  

			  <?php if(!empty($mensagem)){

							echo utf8_encode($mensagem); 

						}	?>

                    

						<div class="form-group">

                            <input type="text" name='cnpj' class="form-control" data-masked="" data-inputmask="'mask': '99.999.999/9999-99'" placeholder="CNPJ" required="">

                        </div>

                         <div class="form-group">

                            <input type="email" class="form-control" name='email_usuario' placeholder="Email" required="">

                        </div>

                        <div class="form-group">

                            <input type="password" name='senha' class="form-control" placeholder="Senha" required="">

                        </div>

                        <button type="submit" class="btn btn-primary btn-block ">Login</button>

                <p>BD Serviços &copy; 2016</p>

                    </form>

                </div>

            </div>

        </div>

        <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/jquery.min.js"></script>

        <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>

        <script src="<?php echo $this->config->base_url(); ?>assets/js/metisMenu.min.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.nanoscroller.min.js"></script>

        <script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-jvectormap-1.2.2.min.js"></script>

        <script src="<?php echo $this->config->base_url(); ?>assets/js/pace.min.js"></script>

        <script src="<?php echo $this->config->base_url(); ?>assets/js/waves.min.js"></script>

        <script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-jvectormap-world-mill-en.js"></script>

        <!--        <script src="js/jquery.nanoscroller.min.js"></script>-->

        <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/custom.js"></script>

        <!--page plugins-->

        <script src="<?php echo $this->config->base_url(); ?>assets/js/select/fancySelect.js"></script>

        <script src="<?php echo $this->config->base_url(); ?>assets/js/input-mask/jquery.inputmask.bundle.min.js"></script>

        <script src="<?php echo $this->config->base_url(); ?>assets/js/select/select2.js"></script>

        <script src="<?php echo $this->config->base_url(); ?>assets/js/slider/bootstrap-slider.min.js"></script>

        <script src="<?php echo $this->config->base_url(); ?>assets/js/custom-advanced-form.js"></script>

    </body>

</html>

