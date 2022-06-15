function schemaMaker(): void {
	const buttons = document.querySelectorAll<HTMLButtonElement>('section#js-oefeningen article.oefeningen-schema>div.col-4>button.btn-primary');
	const container = document.getElementById('js-selected');
	if(container == null)
		return console.error('Failed to find container for selected items.');
	buttons.forEach(
		function(this: any, value: HTMLButtonElement, _key: number, _parent: NodeListOf<HTMLButtonElement>): void {
			value.addEventListener('click', function(this: HTMLButtonElement, _ev: MouseEvent): void {
				const schemaOption = document.createElement('div');
				const schemaText = document.createElement('p');
				const schemaButton = document.createElement('button');
				schemaOption.classList.add('js-id-'+ this.value);
				schemaButton.type = 'button';
				schemaButton.innerText = 'X';
				schemaText.innerText = this.name;
				schemaOption.appendChild(schemaText);
				schemaOption.appendChild(schemaButton);
				container.appendChild(schemaOption);
				schemaButton.addEventListener('click', function(this: HTMLButtonElement, _ev: MouseEvent): void {schemaOption.remove();});
			});
		}
	);
}
function schemaSubmit(): void {
	const container = document.getElementById('js-selected');
	if(container == null)
		return console.error('Failed to find container for selected items.');
	const output: number[] = [];
	for(let index = 0; index < container.childElementCount; index++) {
		const schemaOption = container.children[index] as HTMLElement;
		const result = /(?:^| )js-id-(\d+)(?: |$)/.exec(schemaOption.className);
		if(result == null || result.length < 2) continue;
		output.push(Number(result[1]));
	}
	var settings: JQuery.AjaxSettings<any> = {
		accepts: {json:"application/json"},
		contentType: 'application/json; charset=UTF-8',
		async: true,
		dataType: "json",
		method: "POST",
		url: "./php/setFavorites.php",
		data: JSON.stringify(output),
		error: ajax_error,
		/**
		 * A function to be called if the request succeeds.
		 * The function gets passed three arguments:
		 ** The data returned from the server, formatted according to the dataType parameter or the dataFilter callback function,
		 ** if specified; a string describing the status;
		 ** and the jqXHR (in jQuery 1.4.x, XMLHttpRequest) object.*/
		success: function(this: JQuery.Ajax.AjaxSettingsBase<any>, data: JSON|responce, _textStatus: string|null, jqXHR: JQuery.jqXHR): void {
			if(!('code' in data))
				return ajax_error(jqXHR, "parsererror");
			if(data.code != 200)
				return console.error(data);
		}
	};
	$.ajax(settings);
}