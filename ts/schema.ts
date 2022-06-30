/** Page specific functions for schema page.*/
import {listParser, site_oefeningen} from './global.js';
import {createSchema} from './ajax.js';
/** Page specific filling of oefening data.*/
function fillSchema(container: HTMLElement) {
	// Get the data to add to the page and check it.
	const oefeningen = sessionStorage.getItem('oefeningen');
	if(oefeningen == null) return console.error('Missing session item');
	const data = JSON.parse(oefeningen);
	// More in dept type checking is too much work.
	if(!(data instanceof Array)) return console.error('Failed to parse JSON from sessionStorage');
	// Clear placeholders
	container.innerHTML = "";
	// For each row we add a article to the container.
	// The element is created filled with data and then added to its container.
	(data as site_oefeningen[]).forEach((value: site_oefeningen, _index: number, _array: site_oefeningen[]): void => {
		const article = document.createElement('article');
		article.classList.add('oefeningen', "oefeningen-schema", "border", "border-dark", "rounded", "my-3", "py-2", "me-1", "row-oefeningen", "row", "static-height");
		const div_row8 = document.createElement('div');
		div_row8.classList.add('col-8');
		const div_row = document.createElement('div');
		div_row.classList.add("row");
		// The header element
		const header = document.createElement('h4');
		header.innerText = value.name;
		header.classList.add('col-6');
		div_row.appendChild(header);
		const div_col6 = document.createElement('div');
		div_col6.classList.add('col-6');
		/** The button that changes whether the article hides overflowing text or expands to show it all.*/
		const overflowShowHide = document.createElement('button');
		overflowShowHide.type = "button";
		overflowShowHide.innerText = 'Meer tekst';
		overflowShowHide.classList.add('btn', 'btn-outline-primary', 'float-end');
		overflowShowHide.addEventListener('click', function(this: HTMLButtonElement, _ev: MouseEvent): void {
			if(article.classList.contains('static-height')) {
				article.classList.remove('static-height');
				this.innerText = 'Minder tekst';
			} else {
				article.classList.add('static-height');
				this.innerText = 'Meer tekst';
			}
		});
		div_col6.appendChild(overflowShowHide);
		div_row.appendChild(div_col6);
		/** The attributes under the header but above the description. Each attribute has its own span.*/
		const attributes = document.createElement('p');
		attributes.classList.add('attributes');
		//A span for the type of exercise.
		const oType = document.createElement('span');
		oType.classList.add('fw-bold', 'me-3');
		oType.innerText =
			(value.type)?
				value.type
				: "-";
		attributes.appendChild(oType);
		// The musclegroups a exercise uses as tags under the description.
		if(value.spiergroepen) {
			// Converting the comma seperated list into an array and iterating over it.
			value.spiergroepen.split(',').forEach(element => {
				// Each musslegroup has it's own span.
				const attrib = document.createElement('span');
				attrib.classList.add('musclegroup', 'me-3');
				attrib.innerText = element;
				attributes.appendChild(attrib);
			});
		}
		if(value.duration) {
			const duration = document.createElement('span');
				duration.classList.add('duration', 'me-3');
				duration.innerText = value.duration.toString() + ' sec';
				attributes.appendChild(duration);
		}
		//added calories to the oefeningen page
		const calor = document.createElement('span');
		calor.classList.add('calor');
		calor.innerText = "56 cal";
		attributes.appendChild(calor);
		div_row.appendChild(attributes);
		/** The description of the oefening.*/
		const desc = document.createElement('p');
		desc.classList.add('explanation');
		desc.innerText = value.description;
		desc.classList.add("col-12");
		listParser(desc);
		div_row.appendChild(desc);
		div_row8.appendChild(div_row);
		article.appendChild(div_row8);
		const div3 = document.createElement('div');
		div3.classList.add("col-4");
		// Lastly the image if one exists.
		if(value.images && value.images[0]) {
			const img = document.createElement('img');
			img.loading = "lazy";
			img.referrerPolicy = "no-referrer";
			img.src = "img/oefeningFoto/" + value.images[0];
			// An empty string into the alt attribute to mark it as decorative.
			img.setAttribute("alt", "");
			img.classList.add("col-4");
			div3.appendChild(img);
		}
		// adds a button to allow oefening to be added to schema.
		const btn = document.createElement('button');
		btn.classList.add('btn', 'btn-primary', 'w-100', 'mt-3');
		btn.textContent = 'Voeg toe aan schema';
		btn.type = 'button';
		btn.name = value.name;
		btn.value = value.ID.toString();
		if(value.duration)
			btn.setAttribute('js-data-duration', value.duration.toString());
		div3.appendChild(btn);
		article.appendChild(div3);
		(container as HTMLElement).appendChild(article);
	});
}
/** Add the functionality to the buttons to add  */
function schemaMaker(): void {
	const buttons = document.querySelectorAll<HTMLButtonElement>('section#js-oefeningen article.oefeningen-schema>div.col-4>button.btn-primary');
	const container = document.getElementById('js-selected');
	if(container == null)
		return console.error('Failed to find container for selected items.');
	// Unfortunately ts doesn't like global scope stuff https://stackoverflow.com/questions/38891522/typescript-import-only-as-declaration
	// @ts-ignore
	Sortable.create(container);
	container.classList.add('sortable-container');
	function clickListener(this: HTMLButtonElement, _ev: MouseEvent): void {
		const container = document.getElementById('js-selected');
		if(container == null) return;
		const schemaOption = document.createElement('div');
		const schemaText = document.createElement('p');
		const schemaButton = document.createElement('button');
		const schemaDragger = document.createElement('i');
		const duration = this.getAttribute('js-data-duration');
		if(duration)
			schemaOption.setAttribute('js-data-duration', duration);
		schemaOption.classList.add('js-id-'+ this.value, 'sortable-item');
		schemaButton.type = 'button';
		schemaButton.innerText = 'X';
		schemaText.innerText = this.name;
		schemaOption.appendChild(schemaDragger);
		schemaOption.appendChild(schemaText);
		schemaOption.appendChild(schemaButton);
		container.appendChild(schemaOption);
		schemaButton.addEventListener('click', function(this: HTMLButtonElement, _ev: MouseEvent): void {schemaOption.remove(); calcDuration();});
		calcDuration();
	}
	buttons.forEach(function(this: any, value: HTMLButtonElement, _key: number, _parent: NodeListOf<HTMLButtonElement>): void {
		value.addEventListener('click', clickListener);
	});
	const btnSave = document.getElementById('js-saveSchema');
	if(!(btnSave instanceof HTMLButtonElement)) return console.error('Missing button#js-saveSchema');
	btnSave.addEventListener('click', schemaSubmit);
}
function calcDuration(): void {
	const container = document.getElementById('js-selected');
	const duration = document.getElementById('js-duration');
	if(container == null || duration == null) return;
	var output: number = 0;
	// Get the ID of each item and add it to a list.
	for(let index = 0; index < container.childElementCount; index++) {
		const schemaOption = container.children[index] as HTMLElement;
		const result = schemaOption.getAttribute('js-data-duration');
		if(result == null) continue;
		output += Number(result);
	}
	duration.title = "Totale tijd van oefeningen: "+ output + " seconden";
	if(output == 0)
		duration.innerText = 'Tijd: 0';
	else if(output < 120)
		duration.innerText = 'Tijd: ~'+ output +' seconden';
	else
		duration.innerText = 'Tijd: ~'+ Math.round(output / 60) +' minuten';
}
/** Get all elements in the list and add create a new schema for the user in the database for them.*/
function schemaSubmit(): void {
	const container = document.getElementById('js-selected');
	if(container == null)
		return console.error('Failed to find container for selected items.');
	const output: number[] = [];
	// Get the ID of each item and add it to a list.
	for(let index = 0; index < container.childElementCount; index++) {
		const schemaOption = container.children[index] as HTMLElement;
		const result = /(?:^| )js-id-(\d+)(?: |$)/.exec(schemaOption.className);
		if(result == null || result.length < 2) continue;
		output.push(Number(result[1]));
	}
	if(output.length == 0) return;
	// Send the list to the createSchema function to add to the database.
	createSchema(output);
}
export {fillSchema, schemaMaker}