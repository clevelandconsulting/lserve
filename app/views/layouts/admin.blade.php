<!DOCTYPE html>
<html ng-app='app'>
  <head>
    <title>cci-licensing-webviewer-admin</title>

    <link rel="stylesheet" type="text/css" href="css/app.css" media="all" />
  </head>
  
</html>
<body>
	<div ng-controller='navCtrl as nav'>
  <nav class='navbar navbar-inverse navbar-static-top navbar-top' role='navigation'>
	   <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">Licensing Server Administration</a>
	    </div>
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Menu<span class="caret"></span></a>
	          <ul class="dropdown-menu" role="menu">
	            <li><a ng-click='nav.$location.path("accounts")'>Accounts</a></li>
	            <li><a ng-click='nav.$location.path("users")'>Users</a></li>
	          </ul>
	        </li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a ng-click='nav.$location.path("profile/")' ng-bind='nav.username'></a></li>
									<li><a href='/logout'>Logout</a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	   </div><!-- /.container-fluid -->
   </nav>
  </div>
	@section('content')
	@show
	<script type="text/javascript" src="private/js/admin.app.js"></script>
	</body>
</html>