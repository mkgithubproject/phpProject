<?php
include_once dirname(__FILE__) . "/../config/connection.php";
?>
<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo URL; ?>css/style.css">
	<script src="<?php echo URL; ?>script/validation.js" type="text/javascript"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
	<script src="<?php echo URL ?>script/ajax_script.js" type="text/javascript"></script>
	<title><?php if (!empty($TITLE)) {
				echo $TITLE;
			} else {
				echo "MK Site";
			} ?></title>

</head>

<body>
	<div id="container">
		<header>
			<div id="header">
				<div class="container-fluid mycontainer-fluid ">
					<nav class="navbar navbar-expand-md navbar-dark  " style="background-color: #004d80;">
						<button data-toggle="collapse" data-target="#navbar-toggler" type="button" class="navbar-toggler "><span class="navbar-toggler-icon"></span></button>
						<?php if (isset($_SESSION["sg"]["loggedin"]) && $_SESSION["sg"]["loggedin"] === true) {
						?>
							<div class="collapse navbar-collapse " id="navbar-toggler">
								<ul class="navbar-nav ml-auto ">
									<li class="nav-item">
										<a class="nav-link" href="<?php echo URL; ?>users/user_profile.php">Profile</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="<?php echo URL; ?>users/project.php">Projects</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="<?php echo URL; ?>users/logout.php">Logout</a>
									</li>
								</ul>
							</div>
						<?php
						} else {
						?>
							<div class="collapse navbar-collapse " id="navbar-toggler">
								<ul class="navbar-nav ml-auto ">

									<li class="nav-item">
										<a class="nav-link" href="<?php echo URL; ?>index.php">Register</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="<?php echo URL; ?>users/login.php">Login</a>
									</li>
								</ul>
							</div>
						<?php
						} ?>
					</nav>
				</div>
			</div>
		</header>