<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/auth/views/auth_view.php
 */
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= NOOBS_TITLE ?></title>
    <meta name="author" content="phpmu.com">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="<?php echo base_url('vendors/template/login/'); ?>images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('vendors/template/login/'); ?>vendor/bootstrap/css/bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url('vendors/template/login/'); ?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url('vendors/template/login/'); ?>vendor/animate/animate.css">
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url('vendors/template/login/'); ?>vendor/css-hamburgers/hamburgers.min.css">
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url('vendors/template/login/'); ?>vendor/select2/select2.min.css">
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url('vendors/template/login/'); ?>css/util.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendors/template/login/'); ?>css/main.css">

  </head>
  <body>
    
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="<?php echo base_url('images/'); ?>logo.png" alt="IMG">
                </div>

                <form id="formLogin" action="#" method="post" autocomplete="off">
                    <span class="login100-form-title">
                        Login
                    </span>

                    <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text"  id="txtUsername" name="txt_username" placeholder="Username">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate = "Password is required">
                        <input class="input100" type="password" id="txtPassword" name="txt_password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    
                    <div class="container-login100-form-btn">
                        <input type="hidden" name="action" value="do_login">
                        <button type="submit" class="login100-form-btn">
                            Login
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <span class="txt1">
                            Forgot
                        </span>
                        <a class="txt2" href="#">
                            Username / Password?
                        </a>
                    </div>

                    <div class="text-center p-t-136">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    <script type="text/javascript">
		var NOOBS_ENVIRONMENT = '<?php echo ENVIRONMENT; ?>';
		var NOOBS_LANGUAGE = '<?php echo NOOBS_LANGUAGE; ?>';
		var NOOBS_TITLE = '<?php echo NOOBS_TITLE; ?>';
		var BASE_URL = '<?php echo base_url(); ?>';
	</script>
    
	<script src="<?php echo base_url('vendors/template/login/'); ?>vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="<?php echo base_url('vendors/template/login/'); ?>vendor/bootstrap/js/popper.js"></script>
    <script src="<?php echo base_url('vendors/template/login/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('vendors/template/login/'); ?>vendor/select2/select2.min.js"></script>
	<script src="<?php echo base_url('vendors/template/login/'); ?>vendor/tilt/tilt.jquery.min.js"></script>
    <script src="<?php echo base_url('scripts/custom_validity.js'); ?>"></script>
    <script src="<?php echo base_url('vendors/jquery_waitme/waitMe.js'); ?>"></script>
    <script src="<?php echo base_url('scripts/scripts.js'); ?>"></script>
    <script src="<?php echo base_url('scripts/auth/auth.js'); ?>"></script>
    <script >
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
	<script src="<?php echo base_url('vendors/template/login/'); ?>js/main.js"></script>

</body>
</html>   

