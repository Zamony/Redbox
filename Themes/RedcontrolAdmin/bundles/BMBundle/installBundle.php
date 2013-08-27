<style>
input[type="file"]{
	display:inline-block !important;
}
.error-block{
	margin-top:20px;
}
</style>
</head>
<body>
<?php echo dashboard_menu($options['dashboard-menu']); ?>
<div class="container placement">
	<div class="col-lg-6 col-offset-3">
		<form action="" enctype="multipart/form-data" method="POST">
			<input type="file" name="bundle" accept="application/zip">
			<input type="submit" class="btn btn-primary submit" value="Upload bundle"></input>
		</form>
	</div>
	<div class="col-lg-6 col-offset-3 error-block">
		<?php if(isset($options['msg'])):?>
			<div class="alert alert-danger">
				<?php echo $options['msg']; ?>
			</div>
		<?php elseif (!empty($_POST)): ?>
			<div class="alert alert-success">Bundle is successfully installed</div>
		<?php endif;?>
	</div>
</div>