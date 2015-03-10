<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="author" content="Ziad El-Wali">
        <meta name="description" content="Auction Kings Website">
        <title>Auction Kings Website</title>
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		
		<link href="css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
		
        <!-- Responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
		
        <!--Custom Styles-->
        <link href="css/style.css" rel="stylesheet">
		
	</head>
    <body>
    <?php 
    include_once 'analyticstracking.php';
    ?>
		<div class = "navbar navbar-inverse navbar-static-top">
			<div class = "container">
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Navigation Menu<span class="caret"></span>
					</button>
					
					<ul class="dropdown-menu" role="menu">
						<li><a href="homepage.php">HomePage</a></li>
						<li><a href="auctions.php">Auctions</a></li>
						<li><a href="CreateItem.php">Create Auction</a></li>
						<li><a href="forum/forumindex.php">Forum</a></li>
						<li class="divider"></li>
						<li><a href="profile/profile.php">Your profile</a></li>
					</ul>
				</div>
			</div>
			<!-- Logout Button -->
			<center><a href="logout.php">Logout</a></center>
		</div>
		<!--If you are using this file separately then put your stuff in the body here-->	
		