<link rel="stylesheet" href="/Themes/RedcontrolAdmin/css/font-awesome/css/font-awesome.min.css">
</head>
<body>
<?php echo dashboard_menu($options['dashboard-menu']); ?>
<div class="container placement">
	<div class="col-lg-6 col-offset-3 error-block"></div>
	<?php if(sizeof($options['posts']) === 0): ?>
	<div class="col-lg-6 col-offset-3 well">
		<p>Unfortunately, you don't have any posts.</p>
	</div>
	<?php else: ?>
		<?php foreach($options['posts'] as $post): ?>
		<div class="col-lg-6 col-offset-3 redblock">
			<div class="col-lg-2 btn-group-vertical">
				<?php if (@$post['state'] === 0): ?>
					<button type="button" controller="/posts/dashboard/publish/<?php echo $post['id']; ?>" class="btn btn-info locker"><i class="icon-unlock"></i></button>
				<?php else: ?>
					<button type="button" class="btn locker" controller="/posts/dashboard/unpublish/<?php echo $post['id']; ?>"><i class="icon-lock"></i></button>
				<?php endif; ?>
				<a type="button" class="btn btn-success" target="blank" href="/<?php echo $post['category_url'], '/', $post['url'];?>">
					<i class="icon-eye-open"></i>
				</a>
				<button type="button" controller="/posts/dashboard/delete/<?php echo $post['id']; ?>" class="btn btn-danger delete"><i class="icon-trash"></i></button>
			</div>
			<div class="col-lg-10">
				<h4>
					<a href="/posts/dashboard/editPost/<?php echo $post['id'];?>"><?php echo $post['title'];?></a>
					<a class="label label-warning" target="blank" href="/<?php echo $post['category_url']; ?>"><?php echo $post['category'];?></a>
				</h4>
				<p><?php echo post_excerpt($post['content']); ?></p>
			</div>
		</div>
	<?php endforeach;endif;?>
	<div class="col-lg-6 col-offset-3 text-center">
		<?php 
			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			dashboard_pagenavi($page, $options['total'], 10); 
		?>
	</div>
	</div>
<script>
	$('document').ready(function(){
		$('.locker').click(function(){
			var controller = $(this).attr('controller');
			$.post(controller, '', function(data){
				$('.error-block').html('').html(data);
			});
		});
		$('.delete').click(function(){
			var controller = $(this).attr('controller');
			cont = $(this).parent().parent();
			$.post(controller, '', function(data){
				$('.error-block').html('').html(data);
				cont.remove();
			});
		});
	});
</script>