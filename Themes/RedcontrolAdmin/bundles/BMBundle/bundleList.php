<style>
	.panel ul{
		padding: 0;
		margin-top: 10px;
	}
	.panel ul li{
		list-style: none;
		float:left;
		margin-right: 10px;
	}
	.nav-tabs{
		margin-bottom: 10px;
	}
</style>
</head>
<body>
<?php echo dashboard_menu($options['dashboard-menu']); ?>
<div class="container placement">
	<div class="col-lg-6 col-offset-3 error-block"></div>
	<div class="col-lg-6 col-offset-3">
		<ul class="nav nav-tabs">
		  <li class="active"><a href="#activated" data-toggle="tab">Activated</a></li>
		  <li><a href="#deactivated" data-toggle="tab">Deactiavated</a></li>
		</ul>
	<div class="tab-content">
	<div id="activated" class="tab-pane active">
		<?php foreach($options['activated'] as $name => $active): ?>	
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title"><?php echo $active['name']; ?></h3>
			  </div>
			  <div class="panel-body">
			    <?php echo $active['desc']; ?>
			    <div class="clearfix">
				    <ul>
					    <li><a href="<?php echo $active['configuration_url']; ?>">Config</a></li>
					    <li><a href="#" class="controller" action="deactivate" controller="/bm/dashboardbm/deactivate/<?php echo $name;?>">Deactivate</a></li>
					    <li class="pull-right"><span>Version: <?php echo $active['version']; ?></span></li>
					</ul>
				</div>
			  </div>
			</div>
		<?php endforeach; ?>
	</div>
	<div id="deactivated" class="tab-pane">
		<?php foreach($options['deactivated'] as $name => $active): ?>	
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title"><?php echo $active['name']; ?></h3>
			  </div>
			  <div class="panel-body">
			    <?php echo $active['desc']; ?>
			    <div class="clearfix">
				    <ul>
					    <li><a href="<?php echo $active['configuration_url']; ?>">Config</a></li>
					    <li><a href="#" class="controller" action="activate" controller="/bm/dashboardbm/activate/<?php echo $name;?>">Activate</a></li>
					    <li class="pull-right"><span>Version: <?php echo $active['version']; ?></span></li>
					</ul>
				</div>
			  </div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
</div>
</div>
<script>
	$('document').ready(function(){
		$('.controller').click(function(){
			var controller = $(this).attr('controller');
			cont = $(this).parent().parent();
			$.get(controller, '', function(data){
				$('.error-block').html('').html(data);
				cont.html('');
			});
		});
	});	
</script>