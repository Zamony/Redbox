</head>
<body>
<?php echo dashboard_menu($options['dashboard-menu']); ?>
<div class="container">
	<div class="col-lg-6 col-offset-3">
		<ul class="nav nav-tabs">
		  <li class="active"><a href="#category" data-toggle="tab">Categories</a></li>
		  <li><a href="#tags" data-toggle="tab">Tags</a></li>
		</ul>
		<div class="tab-content">
			<div id="category" class="tab-pane active">
				<table class="table table-bordered table-hover">
					<tr>
						<th>Category</th>
						<th>Post's ids</th>
					</tr>
					<?php foreach ($options['cats'] as $k_cat=>$cat): ?>
					<tr>
						<td><?php echo $k_cat; ?></td>
						<td>
						<?php foreach($cat as $id): ?>
							<a href="/posts/dashboard/editPost/<?php echo $id; ?>"><?php echo "$id"; ?></a>  
						<?php endforeach; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
			<div id="tags" class="tab-pane">
				<table class="table table-bordered table-hover">
					<tr>
						<th>Tags</th>
						<th>Post's ids</th>
					</tr>
					<?php foreach ($options['tags'] as $k_tag=>$tag): ?>
					<tr>
						<td><?php echo $k_tag; ?></td>
						<td>
						<?php foreach($tag as $id): ?>
							<a href="/posts/dashboard/editPost/<?php echo $id; ?>"><?php echo $id; ?></a>, 
						<?php endforeach; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</div>