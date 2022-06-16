import {listParser, site_oefeningen} from './global';
import {setFavorites} from './ajax';
function FillOefeningen(): void {
	const container = document.getElementById("js-oefeningen");
	if(container == null) return console.error("Missing element");
	const oefeningen = sessionStorage.getItem('oefeningen');
	if(oefeningen == null) return console.error('Missing session item');
	const data = JSON.parse(oefeningen);
	if(!(data instanceof Array<site_oefeningen>)) return console.error('Failed to parse JSON from sessionStorage');
	// Clear placeholders
	container.innerHTML = "";
	// The element is created filled with data and then added to its container.
	(data as site_oefeningen[]).forEach(function(this: any, value: site_oefeningen, _index: number, _array: site_oefeningen[]): void {
		const article = document.createElement('article');
		article.classList.add('oefeningen', "oefeningen-schema", "border", "border-dark", "rounded", "my-3", "py-2", "me-1");
		// The header element
		const header = document.createElement('h4');
		header.innerText = value.name;
		article.appendChild(header);
		// The atributes under the header but above the description. Each atribute has its own span.
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
			value.spiergroepen.split(',').forEach(function(this: any, value: string, _index: number, _array: string[]): void {
				// Each musslegroup has it's own span.
				const attrib = document.createElement('span');
				attrib.classList.add('musclegroup');
				attrib.innerText = value;
				atribs.appendChild(attrib);
			});
		}
		article.appendChild(atribs);
		// The description.
		const desc = document.createElement('p');
		desc.classList.add('explanation');
		desc.innerText = value.description;
		listParser(desc);
		article.appendChild(desc);
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
			article.appendChild(img);
		}
		if(value.favorite != undefined) {
			const checkboxLabel = document.createElement('label');
			checkboxLabel.classList.add('customCheckbox');
			checkboxLabel.innerHTML = `<svg><use xlink:href="./assets/star.svg#svg-star"/></svg><input type="checkbox"/>`;
			const checkboxInput = checkboxLabel.querySelector('input') as HTMLInputElement;
			checkboxLabel.style.fill = (value.favorite)? "yellow" : "none";
			checkboxLabel.style.cursor = "pointer";
			checkboxInput.checked = value.favorite;
			// checkboxInput.id = element.ID.toString();
			checkboxInput.hidden = true;
			checkboxInput.addEventListener('input',
				function(this: HTMLInputElement, ev: Event): void {
					ev.preventDefault();
					this.disabled = true;
					const checked = (checkboxLabel.style.fill == "yellow");
					var waiter = setFavorites([{
						oefening: value.ID,
						remove: checked
					}]);
					waiter.done(() => {
						this.checked = !checked;
						checkboxLabel.style.fill = (checked)? "none": "yellow";
						this.disabled = false;
					});
					waiter.fail(() => {
						console.error("Failed to update favorite status");
						this.disabled = false;
					});
				}
			);
			article.appendChild(checkboxLabel);
		}
		container.appendChild(article);
	});
}
export {FillOefeningen}