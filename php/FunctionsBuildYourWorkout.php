<!-- This page contains all the sections of the page Build Your Workout -->
<?php
	
	function QuestionSpier()
	{
		?>
		<!-- The section of the question about which part of the muscle you want to work on -->
		<div class="section-muscle row justify-content-center mt-5">
			<div class="col-3">
				<div class="mb-3">
					<h4>Welke spiergroep(en) wilt u trainen?</h4>
					<!-- Triceps -->
					<div class="form-check fs-5">
						<input class="form-check-input" type="checkbox" name="triceps" id="inputTriceps" value="Triceps">
						<label class="form-check-label" for="inputTriceps">
							Triceps
						</label>
					</div>
					<!-- Rug -->
					<div class="form-check fs-5">
						<input class="form-check-input" type="checkbox" name="rug" id="inputRug" value="Rug">
						<label class="form-check-label" for="inputRug">
							Rug
						</label>
					</div>
					<!-- Buik -->
					<div class="form-check fs-5">
						<input class="form-check-input" type="checkbox" name="buik" id="inputBuik" value="Buik">
						<label class="form-check-label" for="inputBuik">
							Buik
						</label>
					</div>
					<!-- Hamstring -->
					<div class="form-check fs-5">
						<input class="form-check-input" type="checkbox" name="hamstring" id="inputHamstring" value="Hamstring">
						<label class="form-check-label" for="inputHamstring">
							Hamstring
						</label>
					</div>
					<!-- Biceps -->
					<div class="form-check fs-5">
						<input class="form-check-input" type="checkbox" name="biceps" id="inputBiceps" value="Biceps">
						<label class="form-check-label" for="inputBiceps">
							Biceps
						</label>
					</div>
					<!-- The submit button -->
					<?php SubmitButton();?>
				</div>
			</div>
			<!-- Image of the page -->
			<div class="col-3">
				<img src="img/BYW3.png" alt="Muscles">
			</div>
		</div>
		<?php
	}

	// The section where Build Your Workout begins on
	function BeginForm()
	{
		?>
		<section class="buildYourWorkout-Section">
			<div class="container">
				<h1 class="text-center">Build your workout</h1>
				<form action="" method="post">
					<input type=hidden name="page" value="build">
					<div class="row">
		<?php
	}

	// The end of the page where we conclude every section of each function
	function EndForm() {
		echo '</div>';
		echo '</form></div></section>';
	}

	// The section of the question about the gender
	function QuestionGeslacht() {
		?>
		<div class="section-gender row justify-content-center">
			<div class="col-3 first">
				<br>
				<br>
				<br>
				<h3> Wat is uw geslacht?</h3>
				<!-- Vrouw -->
				<div class="form-check fs-5">
					<input class="form-check-input" type="radio" name="geslacht" id="inputVrouw" value="vrouw">
					<label class="form-check-label" for="inputVrouw">
						Vrouw
					</label>
				</div>
				<!-- Man -->
				<div class="form-check fs-5">
					<input class="form-check-input" type="radio" name="geslacht" id="inputMan" value="man">
					<label class="form-check-label" for="inputMan">
						Man
					</label>
				</div>
				<!-- Neutraal -->
				<div class="form-check fs-5">
					<input class="form-check-input" type="radio" name="geslacht" id="inputNeutraal" value="neutraal">
					<label class="form-check-label" for="inputNeutraal">
						Neutraal
					</label>
				</div>
				<!-- The submit button -->
				 <?php SubmitButton();?>
			</div>
			<!-- The Image of the page -->
			<div class="col-3">
				<img src="img/BYW1.jpg" alt="Gender">
			</div>
		</div>
		<?php
	}


	// The section of the question about which goal you wanna achieve
	function QuestionDoel() {
		?>
		<div class="section-goal row justify-content-center mt-5">
			<div class="col-3 mt-5">
				<div class="mb-3">
					<h4>Wat is uw doel?</h4>
					<!-- Afslanken -->
					<div class="form-check fs-5">
						<input class="form-check-input" type="checkbox" name="afslanken" id="inputAfslanken" value="afslanken">
						<label class="form-check-label" for="inputAfslanken">
							Afslanken
						</label>
					</div>
					<!-- Spier Opbouw -->
					<div class="form-check fs-5">
						<input class="form-check-input" type="checkbox" name="spier" id="inputSpier" value="Kracht">
						<label class="form-check-label" for="inputSpier">
							Spier Opbouw
						</label>
					</div>
					<!-- Conditie -->
					<div class="form-check fs-5">
						<input class="form-check-input" type="checkbox" name="conditie" id="inputConditie" value="Cardio">
						<label class="form-check-label" for="inputConditie">
							Conditie
						</label>
					</div>
					<!-- The submit button -->
					<?php SubmitButton();?>
				</div>
			</div>
			<!-- Image of the page -->
			<div class="col-3">
				<img src="img/BYW2.jpg" alt="Goal">
			</div>
		</div>
		<?php
	}

	// The section of the question about how much exercises you wanna do
	function QuestionAantal() {
		?>
		<div class="section-exercises row justify-content-center mt-5">
			<div class="col-3">
				<div class="mb-3">
					<h4>Wat is het aantal oefeningen dat u wilt doen?</h4>
					<!-- 3 oefeningen -->
					<div class="form-check fs-5">
						<input class="form-check-input" type="radio" name="oefeningen" id="inputDrieOefeningen" value="3">
						<label class="form-check-label" for="inputDrieOefeningen">
							3 oefeningen
						</label>
					</div>
					<!-- 4 oefeningen -->
					<div class="form-check fs-5">
						<input class="form-check-input" type="radio" name="oefeningen" id="inputVierOefeningen" value="4">
						<label class="form-check-label" for="inputVierOefeningen">
							4 oefeningen
						</label>
					</div>
					<!-- 5 oefeningen -->
					<div class="form-check fs-5">
						<input class="form-check-input" type="radio" name="oefeningen" id="inputVijfOefeningen" value="5">
						<label class="form-check-label" for="inputVijfOefeningen">
							5 oefeningen
						</label>
					</div>
					<!-- The submit button -->
					<?php SubmitButton();?>
				</div>
			</div>
			<!-- Image of the page -->
			<div class="col-3">
				<img src="img/BYW4.png" alt="Exercises">
			</div>
		</div>
		<?php
	}

	// Every session is added by making it in order
	function SessionAdd(){
		if(!isset($_SESSION['workoutStart']))
		{
			$_SESSION['workoutStart'] = '';
		}
		if(!isset($_SESSION['workoutGeslacht']))
		{
			$_SESSION['workoutGeslacht'] = '';
		}
		if(!isset($_SESSION['workoutDoel']))
		{
			$_SESSION['workoutDoel'] = array();
		}
		if(!isset($_SESSION['workoutSpier']))
		{
			$_SESSION['workoutSpier'] = array();
		}
		if(!isset($_SESSION['workoutAantal']))
		{
			$_SESSION['workoutAantal'] = '';
		}
	}

	// Making a function where we can change the session if the button is pressed
	function SessionChange(){
		if(isset($_POST['start'])) {
			$_SESSION['workoutStart'] = $_POST['start'];
		}
		if(isset($_POST['geslacht'])) {
			$_SESSION['workoutGeslacht'] = $_POST['geslacht'];
		}
		$doel = ['afslanken', 'spier', 'conditie'];
		foreach($doel as $value) {
			if(isset($_POST[$value])) {
				array_push($_SESSION['workoutDoel'], $_POST[$value]);
			}
		}
		$spierNames = ['triceps', 'rug', 'buik', 'biceps', 'hamstring'];
		foreach($spierNames as $value) {
			if(isset($_POST[$value])) {
				array_push($_SESSION['workoutSpier'], $_POST[$value]);
			}
		}
		if(isset($_POST['oefeningen'])){
			$_SESSION['workoutAantal'] = $_POST['oefeningen'];
		}
	}

	// Checking if the page is reloading
	function CheckIfPageReloaded(){
		if($_SERVER['REQUEST_METHOD'] != 'POST'){
			unset($_SESSION['workoutStart']);
			unset($_SESSION['workoutGeslacht']);
			unset($_SESSION['workoutDoel']);
			unset($_SESSION['workoutSpier']);
			unset($_SESSION['workoutAantal']);
		}
	}

	// The beginning page of Build Your Workout
	function ParagraphBYW(){
		echo '<p class="beginning-text fs-5 text-center width="60%"">Welkom bij Build your workout. Op deze pagina kunt u uw eigen workout samen stellen met het maken door een paar simpele vragen te beantwoorden.</p>';
		echo '<input type=hidden name="start" value="true">';
	}
	
	// The images of the beginning session
	function ImagesBYW(){
		SubmitButton();
		?>
		<div class="images d-flex justify-content-around mt-5">
			<img class="" src="img/water.jpg" alt="water" style="width: 15%">
			<img class="" src="img/graph.jpg" alt="graph" style="width: 15%">
			<img class="" src="img/weight.jpg" alt="weight" style="width: 15%">
		</div>
		<?php
	}

	function AddJS() {
		echo '<div class="js-local" hidden><script src="js/ajax_communication.js" defer></script><script src="js/tableFunctions.js" defer></script></div>';
	}

	// Function of the submit button
	function SubmitButton() {
		if($_SESSION['workoutStart'] == false) {
			echo '<div class="button-start d-flex justify-content-center mt-4"><button type=submit class="btn btn-primary" style="color: white;">Start</button></div>';
		} elseif(empty($_SESSION['workoutSpier'])) {
			echo '<button type=submit class="btn btn-primary align-self-center mt-4" style="color: white;">Volgende</button>';
		} elseif($_SESSION['workoutAantal'] == '') {
			echo '<button type=submit class="btn btn-primary mt-4" style="color: white;">Finish</button>';
		}
	}

	function ShowInfo(){
		//construct a string for database request
		echo '<div class="section-resultBYW"><div class="sub-title text-center"><p>Bedankt voor het invullen van de vragenlijst, veel plezier met uw eigen gemaakte workout!</p></div><div class="content"><div class="rounded border border-dark p-2">';
		$string = "SELECT o.*, 
			GROUP_CONCAT(DISTINCT m.link ORDER BY m.ID ASC SEPARATOR '\n') AS images
			FROM site_oefeningen o
			LEFT JOIN (
				site_link_media ml JOIN site_media m ON ml.mediaID = m.ID
			) ON ml.oefeningenID = o.ID WHERE ";
		foreach($_SESSION['workoutDoel'] as $value) {
			if('afslanken' != $value) {
				$string .= "`type` LIKE '$value' ";
			} else {
				$string .= '`loseWeight` LIKE 1';
			}
			if($value != end($_SESSION['workoutDoel'])) {
				$string .= ' OR ';
			}
		}
		$string .= ' OR ';
		foreach($_SESSION['workoutSpier'] as $value){
			$string .= "`spiergroepen` LIKE '$value'";
			if($value != end($_SESSION['workoutSpier'])){
				$string .= ' OR ';
			}
		}
		$string .= 'GROUP BY o.ID ORDER BY o.ID';
		// make the sql request
		$oefening = DatbQuery(null, $string);
		//output data of each row
		while($row = $oefening->fetch_all(MYSQLI_ASSOC)) {
			//add each row to oefeningen
			$oefeningen[] = $row;
		}
		$amount =  count($oefeningen[0]);
		$Cycle = 0;
		while ($Cycle < $_SESSION['workoutAantal']){
			$selectedArray = rand(0, $amount - 1);
			?>
			<div class="row">
				<div class="col-8">
					<h4><?php echo $oefeningen[0][$selectedArray]['name'] ?></h4>
					<div class="sub d-flex gap-3">
						<p class="type"><?php echo $oefeningen[0][$selectedArray]['type'] ?></p>
						<p class="spiergroep"><?php echo $oefeningen[0][$selectedArray]['spiergroepen'] ?></p>
					</div>
					<p class="description"><?php echo $oefeningen[0][$selectedArray]['description'] ?></p>
				</div>
				<div class="col-4">
					<img src="img/oefeningFoto/<?php echo explode("\n", $oefeningen[0][$selectedArray]['images'])[0] ?>" alt="image" style="width: 60%; margin: 0;">
				</div>
			</div>
			<?php
			$Cycle++;
		}
		echo "</div></div></div>";
		//var_dump($oefeningen);
	}
?>