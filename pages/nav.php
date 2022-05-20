<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
  	<a class="navbar-brand" href="index.php">
    <img src="img/Logo-CatWeb.png" alt="">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
	  	<li class="nav-item"><a class="nav-link" href="?page=build">Build your workout</a></li>
        <li class="nav-item"><a class="nav-link" href="?page=prac">Oefeningen</a></li>
        <li class="nav-item"><a class="nav-link" href="?page=schema">Schema</a></li>
		<li class="nav-item"><a class="nav-link" href="?page=work">Workout</a></li>
		<li class="nav-item"><a class="nav-link" href="?page=info">Over ons</a></li>
		<li class="nav-item"><a class="nav-link" href="?page=info">Contact</a></li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<nav aria-label=Main>
	<a href="?page=main">
		<img scr="" alt="home" />
	</a>
	<a href="?page=build">Build your workout</a>
	<a href="?page=prac">Oefeningen</a>
	<a href="?page=schema">Schema</a>
	<a href="?page=work">Workout</a>
	<a href="?page=info">Over ons</a>
	<a href="?page=info">Contact</a>
	<!-- Change the content based on whether the user is logged in or not. -->
	<?php echo (isset($_SESSION['ID']))?
		'<a href="?logout=logout">Logout</a>':
		'<a href="?page=login">Login</a>';
	?>
</nav>