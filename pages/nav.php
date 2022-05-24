<section class="navbar-section">
	<nav class="navbar navbar-expand-lg navbar-light bg-customnavbar">
		<div class="container-fluid">
			<a class="navbar-brand ms-5" href="?page=main">
				<img src="img/Logo-CatWeb.png" alt="">
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
				<ul class="navbar-nav mx-auto mb-2 mb-lg-0">
					<li class="nav-item"><a class="nav-link text-white pe-4 h5" href="?page=build">Build your workout</a></li>
					<li class="nav-item"><a class="nav-link text-white pe-4 h5" href="?page=prac">Oefeningen</a></li>
					<li class="nav-item"><a class="nav-link text-white pe-4 h5" href="?page=schema">Schema</a></li>
					<li class="nav-item"><a class="nav-link text-white pe-4 h5" href="?page=work">Workout</a></li>
					<li class="nav-item"><a class="nav-link text-white pe-4 h5" href="?page=info">Over ons</a></li>
					<li class="nav-item"><a class="nav-link text-white pe-4 h5" href="?page=contact">Contact</a></li>
				</ul>
				<form class="d-flex">
					<!-- Change the content based on whether the user is logged in or not. -->
					<?php echo (isset($_SESSION['ID']))?
						'<a href="?logout=logout">Logout</a>':
						'<a class="btn me-5 text-primary" href="?page=login">Login</a>';
					?>
				</form>
			</div>
		</div>
	</nav>
</section>