/** Page specific functions for workout page.*/
import {listParser, site_oefeningen} from './global.js';
import {setFavorites} from './ajax.js';
/** Page specific filling of oefening data.*/
function fillWorkout(): void {
	// We use multiple containers on this page.
	const containers = [
		document.getElementById("js-cardio"),
		document.getElementById("js-kracht"),
		document.getElementById("js-rug"),
		document.getElementById("js-biceps"),
		document.getElementById("js-triceps"),
		document.getElementById("js-buik"),
		document.getElementById("js-borst"),
		document.getElementById("js-benen"),
		document.getElementById("js-schouders")
	];
	if(containers[0] == null || containers[1] == null || containers[2] == null) {
		return console.error("Missing element");
	}
	/** @const {HTMLElement[]} container */
	const oefeningen = sessionStorage.getItem('oefeningen');
	if(oefeningen == null) return console.error('Missing session item');
	const data = JSON.parse(oefeningen);
	if(!(data instanceof Array)) return console.error('Failed to parse JSON from sessionStorage');
	// The element is created filled with data and then added to its container.
	(data as site_oefeningen[]).forEach(function(this: any, value: site_oefeningen, _index: number, _array: site_oefeningen[]): void {
		if(value.workout == null || value.workout.length < 1) return;
		const article = document.createElement('article');
		article.classList.add("border", "border-dark", "rounded", "my-3", "py-2", "me-1", "row");
		// The header element
		const div_row8 = document.createElement('div');
		div_row8.classList.add('col-8');
		const header = document.createElement('h4');
		header.innerText = value.name;
		div_row8.appendChild(header);
		/** The attributes under the header but above the description. Each attribute has its own span.*/
		const attributes = document.createElement('p');
		attributes.classList.add('attributes');
		/** A span for the type of exercise.*/
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
			value.spiergroepen.split(',').forEach(function(this: any, value: string, _index: number, _array: string[]): void {
				/**A span for each musslegroup.*/
				const attrib = document.createElement('span');
				attrib.classList.add('musclegroup', 'me-3');
				attrib.innerText = value;
				attributes.appendChild(attrib);
			});
		}
		if(value.duration) {
			const duration = document.createElement('span');
				duration.classList.add('duration');
				duration.innerText = value.duration.toString() + ' sec';
				attributes.appendChild(duration);
		}
		div_row8.appendChild(attributes);
		// The description.
		const desc = document.createElement('p');
		desc.classList.add('explanation');
		desc.innerText = value.description;
		listParser(desc);
		div_row8.appendChild(desc);
		article.appendChild(div_row8);
		const div3 = document.createElement('div');
		div3.classList.add("col-4");
		// Lastly the image if one exists. While multiple images may exist we currently only use the first one.
		if(value.images && value.images[0]) {
			const img = document.createElement('img');
			// Only load the images on screen to save on load time.
			img.loading = "lazy";
			img.referrerPolicy = "no-referrer";
			img.src = "img/oefeningFoto/" + value.images[0];
			// An empty string into the alt attribute to mark it as decorative.
			img.setAttribute("alt", "");
			div3.appendChild(img);
			article.appendChild(div3);
		}
		// If the user is logged in they will be able to change their favorites.
		if(value.favorite != undefined && document.querySelector('nav form button[name="logout"]') != null) {
			const checkboxLabel = document.createElement('label');
			checkboxLabel.classList.add('customCheckbox');
			// Add the svg used for the graphic and the input used for the functionality.
			checkboxLabel.innerHTML = `<svg viewbox="0 0 22 22" height="4em" width="4em"><use xlink:href="./assets/star.svg#svg-star"/></svg><input type="checkbox" hidden />`;
			// Select the created input.
			const checkboxInput = checkboxLabel.querySelector('input') as HTMLInputElement;
			checkboxLabel.style.fill = (value.favorite)? "yellow" : "none";
			checkboxLabel.style.cursor = "pointer";
			checkboxInput.checked = value.favorite;
			// checkboxInput.id = element.ID.toString();
			checkboxInput.addEventListener('input',
				// Change whether the item is marked favorite or not.
				function(this: HTMLInputElement, ev: Event): void {
					// Disable the button from being triggered while handling this function.
					this.disabled = true;
					// Prevent the button from changing it's own state. We do that in the function itself.
					ev.preventDefault();
					const checked = (checkboxLabel.style.fill == "yellow");
					var waiter = setFavorites([{
						oefening: value.ID,
						remove: checked
					}]);
					waiter.done(() => {
						this.checked = !checked;
						checkboxLabel.style.fill = (checked)? "none": "yellow";
						// The stored information no longer represents the data on the server so re-request it next time the page is loaded.
						sessionStorage.removeItem('oefeningen');
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
		// Because there's potentially multiple or no categories the article belongs to we add a copy to each and delete the original.
		(value.workout as string[]).forEach(function(this: HTMLElement[], value: string, _index: number, _obj: string[]): void {
			switch(value) {
				case "Cardio":
					(this[0] as HTMLElement).appendChild(article.cloneNode(true));
					break;
				case "Kracht":
					(this[1] as HTMLElement).appendChild(article.cloneNode(true));
					break;
				case "Rug":
					(this[2] as HTMLElement).appendChild(article.cloneNode(true));
					break;
				case "Biceps":
					(this[3] as HTMLElement).appendChild(article.cloneNode(true));
					break;
				case "Triceps":
					(this[4] as HTMLElement).appendChild(article.cloneNode(true));
					break;
				case "Buik":
					(this[5] as HTMLElement).appendChild(article.cloneNode(true));
					break;
				case "Borst":
					(this[6] as HTMLElement).appendChild(article.cloneNode(true));
					break;
				case "Benen":
					(this[7] as HTMLElement).appendChild(article.cloneNode(true));
					break;
				case "Schouders":
					(this[8] as HTMLElement).appendChild(article.cloneNode(true));
					break;
			}
		}, (containers as HTMLElement[]));
		article.remove();
	});
}
export {fillWorkout}