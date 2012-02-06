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

		<link href="/assets/css/bootstrap.css" rel="stylesheet">
		<style>body {padding-top: 60px;}</style>
		<link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
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
					<div class="page-header">
						<h1>
							<?php echo __('tonichelp.installer.step_1.title'); ?>
							<small><?php echo __('tonichelp.installer.step_1.caption'); ?></small>
						</h1>
					</div>
			
					<p><?php echo __('tonichelp.installer.step_1.introduction'); ?></p>

					<form class="form-horizontal" action="">
						<fieldset>
							<legend><?php echo __('tonichelp.installer.step_1.admin_user');?></legend>

							<div class="control-group">
								<label class="control-label" for="username"><?php echo __('tonichelp.label.name'); ?></label>

								<div class="controls">
									<input name="username" id="username" class="input-xlarge" type="text" />
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="email"><?php echo __('tonichelp.label.email'); ?></label>

								<div class="controls">
									<input name="email" id="email" class="input-xlarge" type="text" />
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="name"><?php echo __('tonichelp.label.password'); ?></label>

								<div class="controls">
									<input name="name" id="name" class="input-xlarge" type="password" />
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="name"><?php echo __('tonichelp.label.repeat_password'); ?></label>

								<div class="controls">
									<input name="name" id="name" class="input-xlarge" type="password" />
								</div>
							</div>
						</fieldset>

						<fieldset>
							<legend><?php echo __('tonichelp.installer.step_1.general_config');?></legend>

							<div class="control-group">
								<label class="control-label" for="name"><?php echo __('tonichelp.label.name'); ?></label>

								<div class="controls">
									<input name="name" id="name" class="input-xlarge" type="text" value="TonicHelp | Ticket Support System" />
									<p class="help-block"><?php echo __('tonichelp.installer.step_1.general_name_help');?></p>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="system_email"><?php echo __('tonichelp.label.default_email'); ?></label>

								<div class="controls">
									<input name="system_email" id="system_email" class="input-xlarge" type="text" value="" />
									<p class="help-block"><?php echo __('tonichelp.installer.step_1.general_email_help');?></p>
								</div>
							</div>
						</fieldset>

						<fieldset>
							<legend><?php echo __('tonichelp.installer.step_1.mysql_database');?></legend>

							<div class="control-group">
								<label class="control-label" for="db_name"><?php echo __('tonichelp.label.name'); ?></label>

								<div class="controls">
									<input name="db_name" id="db_name" class="input-xlarge" type="text" />
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="db_user"><?php echo __('tonichelp.label.username'); ?></label>

								<div class="controls">
									<input name="db_user" id="db_user" class="input-xlarge" type="text" />
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="db_password"><?php echo __('tonichelp.label.password'); ?></label>

								<div class="controls">
									<input name="db_password" id="db_password" class="input-xlarge" type="password" />
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="db_prefix"><?php echo __('tonichelp.label.table_prefix'); ?></label>

								<div class="controls">
									<input name="db_prefix" id="db_prefix" class="input-xlarge" type="text" />
									<p class="help-block"><?php echo __('tonichelp.installer.step_1.mysql_prefix_help');?></p>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="db_engine"><?php echo __('tonichelp.label.table_engine'); ?></label>

								<div class="controls">
									<select id="db_engine" name="db_engine" class="input-xlarge">
										<option value="0">InnoDB <i>(<?php echo __('tonichelp.installer.step_1.mysql_engine_default');?>)</i></option>
										<option value="1">TokuDB</option>
									</select>
									<p class="help-block"><?php echo __('tonichelp.installer.step_1.mysql_engine_help');?></p>
								</div>
							</div>							

						</fieldset>

						<div class="form-actions">
							<button class="btn btn-primary" type="submit"><?php echo __('tonichelp.button.install'); ?></button>
							<button class="btn" type="reset"><?php echo __('tonichelp.button.cancel'); ?></button>
						</div>
					</form>
				</div>

			</div>

		</div> <!-- /container -->

		<script src="/assets/js/jquery.min.js"></script>
		<script src="/assets/js/bootstrap.min.js"></script>
	</body>
</html>
