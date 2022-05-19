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