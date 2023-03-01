<!doctype html>
<html lang="en">
  <head>
  	<title>Magasin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="include/tpl/sidebar-09/css/style.css">
    <link rel="stylesheet" href="design/css/body.css">
    <script src="include/tpl/sidebar-09/js/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    

  </head>
  <body>
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	        </button>
        </div>
        <h3 class="logo">Magasin</h3>
        <ul class="list-unstyled components mb-5">
          <li class="active">
            <a href="home.php"><span class="fa fa-home mr-3"></span> SmartPhones</a>
          </li>
            
          <li>
            <a href="rphones.php"><span class="fa fa-headphones mr-3"></span> Phones</a>
          </li>
          <li>
            <a href="#"><span class="fa fa-users mr-3"></span> Chargeurs</a>
          </li>
          <li>
            <a href="#"><span class="fa fa-fire mr-3"></span> Stats</a>
          </li>
          <li>
            <a href="settings.php?do=Edit&userid=<?php echo $_SESSION['ID']?>"><span class="fa fa-cog mr-3"></span> Settings</a>
          </li>
          <li>
            <a href="admin/logout.php"><span class="fa fa-sign-out mr-3"></span> Sign Out</a>
          </li>
        </ul>
      </nav>