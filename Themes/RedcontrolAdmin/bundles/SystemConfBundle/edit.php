</head>
<body>
<?php echo dashboard_menu($options['dashboard-menu']); ?>
<div class="container placement">
	<div class="col-lg-6 col-offset-3 error-block"></div>
	<div class="col-lg-6 col-offset-3">
		<form action="">
			<div class="form-group">
				<label for="login">Admin login:</label>
				<input type="text" class="form-control" name="login" value="<?php echo isset($options['info']['login']) ? $options['info']['login'] : '';?>">
			</div>
			<div class="form-group">
				<label for="password">New admin password:</label>
				<input type="text" class="form-control" name="password">
			</div>
			<div class="form-group">
				<label for="name">App name:</label>
				<input type="text" class="form-control" name="name" value="<?php echo isset($options['info']['name']) ? $options['info']['name'] : '';?>">
			</div>
			<div class="form-group">
				<label for="theme">App theme:</label>
				<input type="text" class="form-control" name="theme" value="<?php echo isset($options['info']['theme']) ? $options['info']['theme'] : '';?>">
			</div>
			<div class="form-group">
				<label for="admin_theme">Dashboard theme:</label>
				<input type="text" class="form-control" name="admin_theme" value="<?php echo isset($options['info']['admin_theme']) ? $options['info']['admin_theme'] : '';?>">
			</div>
			<div class="btn btn-primary send">Save configuration</div>
		</form>
	</div>
</div>
<script>
	$('document').ready(function(){
		$('.send').click(function(){
			$.post('/systemconf/dashboardsystemconf/saveConf', $(this).parent().serialize(), function(data){
        		$('.error-block').html('').html(data);
     		});
		});
	});	
</script>