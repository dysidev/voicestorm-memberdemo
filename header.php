<!DOCTYPE html>
<html lang="en">
  <head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <title><?php echo $title ?></title>
	  <link rel="shortcut icon" href="imgs/favicon.png"> 
	  <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet"><!-- Bootstrap core CSS -->
	  <link href="css/offcanvas.css" rel="stylesheet"><!-- Custom styles for this template -->
	  <link href="css/main.css" rel="stylesheet">
	  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	  <!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	  <![endif]-->
  </head>
  <body>
    <div class="navbar navbar-fixed-top navbar-default" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" data-bind="visible: SampleSite.headerHelpers.showHeader()">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo substr(substr(__FILE__, strlen(realpath($_SERVER['DOCUMENT_ROOT']))), 0, - strlen(basename(__FILE__))); ?>">Sample App</a>
        </div>
        <div class="collapse navbar-collapse">
	        <ul class="nav navbar-nav header-list"  data-bind="visible: SampleSite.headerHelpers.showHeader()">	        	
	        	<li><a href="home.php">Home</a></li>			
				<li><a href="leaderboard.php">Leaderboard</a></li>
				<li><a href="createpost.php">Post</a></li>
				<li><a class="visible-xs" href="profile.php">My Profile</a></li>
	            <li class="divider"></li>
	            <li><a class="visible-xs" href="#" data-bind="click: SampleSite.headerHelpers.btnLogout">Logout</a></li>
	        </ul>
          	<ul class="nav navbar-nav navbar-right"  data-bind="visible: SampleSite.headerHelpers.showHeader()">
          		<li class="dropdown hidden-xs">
	              	<a href="#" class="dropdown-toggle hidden-xs" data-toggle="dropdown">
	              		<span id="userDisplayName" data-bind="text: SampleSite.headerHelpers.userDisplayName()"></span>
	              		<b class="caret"></b>
	              	</a>
	              	<ul class="dropdown-menu">
	              		<li><a href="profile.php">My Profile</a></li>
	              		<li class="divider"></li>
	                	<li><a href="#" data-bind="click: SampleSite.headerHelpers.btnLogout">Logout</a></li>
	              	</ul>
            	</li>
      		</ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </div><!-- /.navbar -->


