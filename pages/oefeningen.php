<body>
<form id="js-filters" aria-label="Filters">
	<fieldset id=Search>
		<legend>Zoeken:</legend>
		<div><input id=search type=search name=search aria-labelledby=Search></div>
	</fieldset><fieldset id=Maat>
		<legend>Maat:</legend>
		<select id=tags name=tags multiple>
			<option value="ExampleTagg" title="Tag for x items">#tagging</option>
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
	<script>getData("prac");</script>
</div>
</body>