</head>
<body class="login">
	<div class="container">
		<div class="col-lg-6 col-offset-3 modal-content auth">
			<div class="text-center">
			<img src="/Themes/RedcontrolAdmin/img/redbox-big-dark.png" alt="Redbox logo" height="75px">
			</div>
			<hr/>
			<form action="/redcontrol/access/auth" method="POST">
				<label for="username">Username: </label>
				<input type="text" class="form-control" name="username">
				<label for="password">Password: </label>
				<input type="password" class="form-control" name="password">
				<button type="submit" class="btn btn-danger form-control pagination-center">Log in</button>
			</form>
		</div>
	</div>