<body>
<form id="js-filters" aria-label="Filters">
	<fieldset id=Search>
		<legend>Zoeken:</legend>
		<div><input id=search type=search name=search aria-labelledby=Search></div>
	</fieldset><fieldset id=tags>
		<legend>Spiergroupen:</legend>
		<select id=tags name=tags multiple>
			<option value="Triceps">Triceps</option>
			<option value="Buik">Buik</option>
			<option value="Borst">Borst</option>
			<option value="Hamstrings">Hamstrings</option>
		</select>
	</fieldset><fieldset>
		<legend>Actions:</legend>
		<input type=reset value=Resetten onclick=handleFilter(event);>
		<button type=button onclick=handleFilter(event);>Indienen</button>
	</fieldset>
</form>
<section id="js-oefeningen"></section>
<div style="display:none">
	<script src="js/requestData.js"></script>
	<script src="js/tableFunctions.js"></script>
	<script>getData("prac");</script>
</div>
</body>