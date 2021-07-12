<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/views/view.php
 */

$avatar = empty($this->session->userdata('user_img')) ? 'unknown.png' : $this->session->userdata('user_img');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $title; ?></title>
		<link rel="shortcut icon" href="<?php echo base_url('images/favicon.ico'); ?>">
		<link rel="stylesheet" href="<?php echo get_template_url(); ?>plugins/fontawesome-free/css/all.css">
		<link rel="stylesheet" href="<?php echo base_url('vendors/ionicons/2.0.1/css/ionicons.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('vendors/fonts/audiowide/font.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('vendors/trademark/style.css'); ?>">
		<link rel="stylesheet" href="<?php echo get_template_url(); ?>plugins/jquery-ui/jquery-ui.css">
		<link rel="stylesheet" href="<?php echo get_template_url(); ?>plugins/jquery-ui/jquery-ui.structure.css">
		<link rel="stylesheet" href="<?php echo get_template_url(); ?>plugins/daterangepicker/daterangepicker.css">
		<link rel="stylesheet" href="<?php echo get_template_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
		<link rel="stylesheet" href="<?php echo get_template_url(); ?>plugins/toastr/toastr.min.css">
		<link rel="stylesheet" href="<?php echo get_template_url(); ?>plugins/overlayScrollbars/css/OverlayScrollbars.css">
		<link rel="stylesheet" href="<?php echo get_template_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.css">
		<link rel="stylesheet" href="<?php echo get_template_url(); ?>plugins/select2/css/select2.css">
		<link rel="stylesheet" href="<?php echo get_template_url(); ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.css">
		<link rel="stylesheet" href="<?php echo get_template_url(); ?>dist/css/adminlte.css">
		<link rel="stylesheet" href="<?php echo base_url('styles/source_sans_pro_300_400_400i_700.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('vendors/jquery_waitme/waitMe.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('vendors/jquery_treegrid/css/treegrid.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('vendors/jquery_grid/css/grid.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('vendors/jquery_noobsautocomplete/css/noobsautocomplete.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('styles/styles.css'); ?>">

		<?php
			if (isset($source_top) && count($source_top) > 0)
			{
			    foreach ($source_top as $k)
				{
			    	echo $k;
				}
			}
		?>

	</head>
	<body class="hold-transition sidebar-mini layout-fixed text-sm accent-info">
		<div class="wrapper">
			<nav class="main-header navbar navbar-expand navbar-dark navbar-info fixed-top">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item" title="Logout">
						<a class="nav-link" href="<?php echo site_url('auth/do_logout'); ?>">
							<i class="fas fa-sign-out-alt"></i> Sign Out
						</a>
					</li>
				</ul>
			</nav>
			<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-dark-info">
				<a href="<?php echo base_url(); ?>" class="brand-link">
					<!-- <img src="<?php echo base_url('images/logo.png'); ?>" alt="Brand Logo" class="brand-image"> -->
					<span class="brand-text font-weight-light" style=""><?= NOOBS_TITLE_1 ?></span>
				</a>
				<div class="sidebar">
					<div class="user-panel mt-3 pb-3 mb-3 d-flex">
						<?php 
							$backgroud_url = base_url('images/profiles/'.$avatar);
						?>
						<div class="image" style="background-image: url('<?= $backgroud_url ?>');">
							<!-- <img src="<?php echo base_url('images/profiles/'.$avatar); ?>" class="img-circle elevation-2" alt="Avatar pengguna"> -->
						</div>
						<div class="info">
							<a href="<?php echo site_url('main/profile'); ?>" class="d-block"><?php echo $this->session->userdata('user_fullname'); ?></a>
						</div>
					</div>
					<nav class="mt-2">
						<ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
							<?php echo $menu; ?>
						</ul>
					</nav>
				</div>
			</aside>
			<div class="content-wrapper">
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0 text-dark"><?php echo $header_title; ?></h1>
							</div>
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
									<?php
										if (isset($breadcrumb))
										{
											$last_idx = count($breadcrumb) - 1;

											foreach ($breadcrumb as $k => $v)
											{
												if ($k == $last_idx)
												{
													echo '<li class="breadcrumb-item active"> '.$v[1].'</li>';
												}
												else
												{
													echo '<li class="breadcrumb-item"><a href="'.site_url($v[0]).'"> '.$v[1].'</a></li>';
												}
											}
										}
									?>
								</ol>
							</div>
						</div>
					</div>
				</div>
				<section class="content">
					<div class="container-fluid">
						<?php echo $body; ?>
					</div>
				</section>
			</div>
			<footer class="main-footer fixed-bottom">
				Copyright&copy;2020 <a href="<?php echo base_url(); ?>">RAB App</a> All rights reserved.
				<div class="float-right d-none d-sm-inline-block">Version 1.0.0</div>
			</footer>
		</div>

		<script type="text/javascript">
			var NOOBS_ENVIRONMENT = '<?php echo ENVIRONMENT; ?>';
			var NOOBS_LANGUAGE = '<?php echo NOOBS_LANGUAGE; ?>';
			var NOOBS_TITLE = '<?php echo NOOBS_TITLE; ?>';
			var BASE_URL = '<?php echo base_url(); ?>';
			var USER_FULLNAME = "<?php echo ucwords(strtolower($this->session->userdata('user_fullname'))); ?>";
		</script>
		<script src="<?php echo get_template_url(); ?>plugins/jquery/jquery.js"></script>
		<script src="<?php echo get_template_url(); ?>plugins/jquery-ui/jquery-ui.js"></script>
		<script type="text/javascript">
			$.widget.bridge('uibutton', $.ui.button)
		</script>
		<script src="<?php echo get_template_url(); ?>plugins/bootstrap/js/bootstrap.bundle.js"></script>
		<script src="<?php echo get_template_url(); ?>plugins/moment/moment.js"></script>
		<script src="<?php echo get_template_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
		<script src="<?php echo get_template_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.js"></script>
		<script src="<?php echo get_template_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
		<script src="<?php echo get_template_url(); ?>plugins/toastr/toastr.min.js"></script>
		<script src="<?php echo get_template_url(); ?>plugins/datatables/jquery.dataTables.js"></script>
		<script src="<?php echo get_template_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
		<script src="<?php echo get_template_url(); ?>plugins/select2/js/select2.full.js"></script>
		<script src="<?php echo get_template_url(); ?>plugins/inputmask/jquery.inputmask.bundle.js"></script>
		<script src="<?php echo get_template_url(); ?>plugins/chart.js/Chart.js"></script>
		<script src="<?php echo get_template_url(); ?>plugins/bootstrap-switch/js/bootstrap-switch.js"></script>
		<script src="<?php echo get_template_url(); ?>dist/js/adminlte.js"></script>
		<script src="<?php echo base_url('vendors/jquery_waitme/waitMe.js'); ?>"></script>
		<script src="<?php echo base_url('vendors/jquery_treegrid/js/treegrid.js'); ?>"></script>
		<script src="<?php echo base_url('vendors/jquery_grid/js/grid.js'); ?>"></script>
		<script src="<?php echo base_url('vendors/jquery_popup/js/popup.js'); ?>"></script>
		<script src="<?php echo base_url('vendors/jquery_noobsautocomplete/js/noobsautocomplete.js'); ?>"></script>
		<script src="<?php echo base_url('vendors/jquery_validation/js/validation.js'); ?>"></script>
		<script src="<?php echo base_url('vendors/jquery_noobsdaterangepicker/js/noobsdaterangepicker.js'); ?>"></script>
		<script src="<?php echo base_url('scripts/custom_validity.js'); ?>"></script>
		<script src="<?php echo base_url('scripts/scripts.js'); ?>"></script>
		<?php
			if (isset($source_bot) && count($source_bot) > 0)
			{
			    foreach ($source_bot as $k)
			    {
			    	echo $k;
			    }
			}
		?>
	</body>
</html>
