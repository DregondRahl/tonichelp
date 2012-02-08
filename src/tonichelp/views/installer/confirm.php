<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo __('tonichelp.installer.title'); ?></title>
		<meta name="author" content="TonicHelp Development Team">
		<meta name="robots" content="noindex">

		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="/assets/css/main.css" rel="stylesheet">
	</head>

	<body>

		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a class="brand" href="#"><?php echo __('tonichelp.installer.title'); ?></a>
				</div>
			</div>
		</div>

		<div class="container">

			<div class="row">
				<div class="span8 offset2">
					<?php if(isset($error)): ?>
						<div class="alert alert-block alert-error">
							<a class="close" data-dismiss="alert">×</a>
							<h4 class="alert-heading">Error!</h4><?php echo $error; ?>
						</div>
					<?php endif; ?>


					<div class="page-header">
						<h1>
							<?php echo __('tonichelp.installer.step_2.title'); ?>
							<small><?php echo __('tonichelp.installer.step_2.caption'); ?></small>
						</h1>
					</div>
			
					<p><?php echo __('tonichelp.installer.step_2.introduction'); ?></p>

					<form class="form-horizontal" action="" method="post">
						<?php $val = Validation::instance(); ?>

						<div class="form-actions">
							<button class="btn btn-large btn-primary" type="submit" name="confirm"><?php echo __('tonichelp.button.confirm'); ?></button>
							<button class="btn btn-large" type="submit" name="cancel"><?php echo __('tonichelp.button.cancel'); ?></button>
						</div>
					</form>
				</div>

			</div>

		</div> <!-- /container -->

		<script src="/assets/js/jquery.min.js"></script>
		<script src="/assets/js/bootstrap.min.js"></script>
	</body>
</html>
