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
	// Add classes
	container.classList.add('col-7', 'col-custom', 'mt-3', 'overflow-auto');
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
		/** The atributes under the header but above the description. Each atribute has its own span.*/
		const atribs = document.createElement('p');
		atribs.classList.add('atributes');
		//A span for the type of exercise.
		const oType = document.createElement('span');
		oType.classList.add('difficulty');
		oType.innerText =
			(value.type)?
				value.type
				: "-";
		atribs.appendChild(oType);
		// The musslegroups a exercise uses as tags under the description.
		if(value.spiergroepen) {
			// Converting the comma seperated list into an array and iterating over it.
			value.spiergroepen.split(',').forEach(element => {
				// Each musslegroup has it's own span.
				const attrib = document.createElement('span');
				attrib.classList.add('musclegroup');
				attrib.innerText = element;
				atribs.appendChild(attrib);
			});
		}
		div_row.appendChild(atribs);
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
			img.src = value.images[0].src;
			if(value.images[0].height && value.images[0].width) {
				img.height = value.images[0].height;
				img.width = value.images[0].width;
			}
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
	function clickListener(this: HTMLButtonElement, _ev: MouseEvent): void {
		const container = document.getElementById('js-selected');
		if(container == null) return;
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
	}
	buttons.forEach(function(this: any, value: HTMLButtonElement, _key: number, _parent: NodeListOf<HTMLButtonElement>): void {
		value.addEventListener('click', clickListener);
	});
	const btnSave = document.getElementById('js-saveSchema');
	if(!(btnSave instanceof HTMLButtonElement)) return console.error('Missing button#js-saveSchema');
	btnSave.addEventListener('click', schemaSubmit);
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