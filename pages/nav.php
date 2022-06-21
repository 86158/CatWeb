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
						'<div class="dropdown show">
							<a href="?page=user" class="btn btn-primary p-2 me-5" style="width: 80%;">'. $_SESSION['username'] .'</a>
							<div class="dropdown-content">
								<button role="submit" formmethod="POST" name="logout" value="logout" class="btn btn-primary dropdown-item">Logout</button>
							</div>
						</div>':
						'<button type="button" class="btn me-5 text-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</button>';
					?>
				</form>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<div class="header">
							<h3>Log In</h3>
						</div>
						<button type="button" class="btn-close position-end ms-0" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<main class="login-section">
							<form class="form login" method=POST>
								<input type=hidden name=formID value=login>
								<br><br>
								<fieldset class="fieldset-signup p-0" hidden>
									<label class="fw-bold fs-5">Voornaam<input type="text" name=FirstName></label>
									<label class="fw-bold fs-5">Achternaam<input type="text" name=LastName></label>
									<label class="email fw-bold fs-5">E-mail<input type=email autocomplete=email name=Mail></label>
								</fieldset>
								<fieldset class="login-form align-middle" style=grid-row:1>
									<label class="username fw-bold fs-5">Gebruikersnaam<input type=text autocomplete=username name=Username maxlength=60 required></label>
									<label class="password fw-bold fs-5">Wachtwoord<input type=password name=Password autocomplete=current-password required></label>
								</fieldset>
								<fieldset class="fieldset-signup p-0" hidden>
									<label class="fw-bold fs-5">Bevestig Wachtwoord<input type=password autocomplete=new-password name=confirmPassword maxlength=60></label>
								</fieldset>
								<div class="buttons d-flex flex-column mt-3">
									<input class="btn btn-primary" type=submit value="Login" style="width: 50%"></input>
									<!-- The value of onclick is from `js/loginNewUser` it switches the formtype from login to create new user and back. -->
									<button type=button class="button-below mt-3 mb-3" id=newUserButton>Heeft u nog geen account?</button> 
								</div>
							</form>
						</main>
					</div>
				</div>
			</div>
		</div>
	</nav>
</section>