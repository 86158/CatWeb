<section class="oefening-section">
	<form id="js-filters" aria-label="Filters">
		<div class="container">
			<div class="heading text-center">
				<h1 class="mb-3">Oefeningen</h1>
				<p class="h5">Hier kunt u alle oefeningen zien die er zijn op onze website.</p>
			</div>
			<div class="filters row">
				<div class="col-2">
					<fieldset id=Search>
						<legend>
							Zoeken
						</legend>
						<div>
							<input id=search type=search name=search aria-labelledby=Search>
						</div>
					</fieldset>
				</div>
				<div class="col-2">
					<fieldset id=tags>
						<legend>
							Spiergroupen
						</legend>
						<select id=tags name=tags multiple>
							<option value="Triceps">Triceps</option>
							<option value="Buik">Buik</option>
							<option value="Borst">Borst</option>
							<option value="Hamstrings">Hamstrings</option>
						</select>
					</fieldset>
				</div>
				<div class="col-2">
					<fieldset>
						<legend>Actions:</legend>
						<input type=reset value=Resetten onclick=handleFilter(event);>
						<button type=button onclick=handleFilter(event)>Indienen</button>
					</fieldset>
				</div>
			</div>
		</div>
	</form>
</section>
<section id="js-oefeningen">
	<div class="container" hidden>
		<div class="row">
			<script src="js/requestData.js"></script>
			<script src="js/tableFunctions.js"></script> 
		</div>
	</div>
</section>