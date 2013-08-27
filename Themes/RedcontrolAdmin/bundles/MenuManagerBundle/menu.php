<style>
.tab-content{
	padding-top:20px;	
}
textarea{
	margin-top:10px;
}
button.save-menu{
	margin-top:10px;
}
</style>
</head>
<body>
<?php echo dashboard_menu($options['dashboard-menu']); ?>
<div class="container placement">
	<div class="col-lg-6 col-offset-3 error-block"></div>
	<div class="col-lg-6 col-offset-3">
		<ul class="nav nav-tabs">
		  <li class="active"><a href="#edit" data-toggle="tab">Edit menu</a></li>
		  <li><a href="#add_menu" data-toggle="tab">Add menu</a></li>
		</ul>
	<div class="tab-content">
	<div id="edit" class="tab-pane active">
		<form action="#">
			<select name="menu_name">
			<?php foreach($options['menus'] as $name=>$menu): ?>
				<option><?php echo $name;?></option>
			<?php endforeach;?>
			</select>
			<div class="btn btn-success btn-small save-menu">Save menu</div>
			<textarea class="form-control edit_menu" name="menu_content" rows="12"><?php echo reset($options['menus']);?></textarea>
			<div style="display:none">
			<?php foreach($options['menus'] as $name=>$menu): ?>
				<div id="<?php echo $name;?>"><?php echo $menu;?></div>
			<?php endforeach;?>
			</div>
		</form>
	</div>
	<div id="add_menu" class="tab-pane">
		<form action="#" class="text-centered">
			<div class="form-group">
				<label for="menu_name">Menu name:</label>
				<input type="text" class="form-control" name="menu_name">
			</div>
			<textarea class="form-control add_menu" name="menu_content" rows="12">{}</textarea>
			<button class="btn btn-success save-menu col-offset-5" type="button">Add menu</button>
		</form>
	</div>
</div>
</div>
</div>
<script>
	$('document').ready(function(){
		$('select option').click(function(){
			$('.edit_menu').html(($("#"+$(this).val()).html()));
		});
		$('.save-menu').click(function(){
			console.log($(this).parent());
			$.post('/menumanager/dashboardmenumanager/saveMenu', $(this).parent().serialize(), function(data){
        		$('.error-block').html('').html(data);
     		});
		});
	});	
</script>