/** Page specific functions for oefeningen page.*/
import {listParser, site_oefeningen} from './global.js';
import {setFavorites} from './ajax.js';
/** Page specific filling of oefening data.*/
function fillOefeningen(container: HTMLElement): void {
	// Get the data to add to the page and check it.
	const oefeningen = sessionStorage.getItem('oefeningen');
	if(oefeningen == null) return console.error('Missing session item');
	const data = JSON.parse(oefeningen);
	// More in dept type checking is too much work.
	if(!(data instanceof Array)) return console.error('Failed to parse JSON from sessionStorage');
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
		// Lastly the image if one exists. While multiple images may exist we currently only use the first one.
		if(value.images && value.images[0]) {
			const img = document.createElement('img');
			// Only load the images on screen to save on load time.
			img.loading = "lazy";
			img.referrerPolicy = "no-referrer";
			img.src = value.images[0].src;
			// Set the width and height properties of the image the scr links to so the page knows how much space it might take up.
			// An empty string into the alt attribute to mark it as decorative.
			img.setAttribute("alt", "");
			article.appendChild(img);
		}
		// If the user is logged in they will be able to change their favorites.
		if(value.favorite != undefined) {
			const checkboxLabel = document.createElement('label');
			checkboxLabel.classList.add('customCheckbox');
			// Add the svg used for the grafic and the input used for the functionality.
			checkboxLabel.innerHTML = `<svg vieuwBox="0 0 22 22" height="4em" width="4em"><use xlink:href="./assets/star.svg#svg-star"/></svg><input type="checkbox" hidden />`;
			// Select the created input.
			const checkboxInput = checkboxLabel.querySelector('input') as HTMLInputElement;
			checkboxLabel.style.fill = (value.favorite)? "yellow" : "none";
			checkboxLabel.style.cursor = "pointer";
			checkboxInput.checked = value.favorite;
			// checkboxInput.id = element.ID.toString();
			checkboxInput.addEventListener('input',
				// Change whether the item is favorited or not.
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
		// Add the now complete article to the container.
		container.appendChild(article);
	});
}
export {fillOefeningen}