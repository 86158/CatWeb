/** Page specific functions for schema page.*/
import {site_oefeningen} from './global.js';
import {setFavorites} from './ajax.js';
/** Page specific filling of oefening data.*/
function fillUserFavorites(container: HTMLElement) {
	// Get the data to add to the page and check it.
	const oefeningen = sessionStorage.getItem('oefeningen');
	if(oefeningen == null) return console.error('Missing session item');
	const data = JSON.parse(oefeningen);
	// More in dept type checking is too much work.
	if(!(data instanceof Array)) return console.error('Failed to parse JSON from sessionStorage');
	// Clear placeholders
	container.innerHTML = "";
	// Add classes
	container.classList.add('col-12', 'col-custom', 'mt-3');
	// For each row we add a article to the container.
	// The element is created filled with data and then added to its container.
	(data as site_oefeningen[]).forEach((value: site_oefeningen, _index: number, _array: site_oefeningen[]): void => {
		if(value.favorite != true || document.querySelector('nav form button[name="logout"]') == null) return;
		const article = document.createElement('article');
		article.classList.add('oefeningen', "oefeningen-schema", "border", "border-dark", "rounded", "my-3", "py-2", "me-5", "row-oefeningen", "row", "static-height");
		const div_row8 = document.createElement('div');
		div_row8.classList.add('col-8');
		const div_row = document.createElement('div');
		div_row.classList.add("row");
		// The header element
		const header = document.createElement('h4');
		header.innerText = value.name;
		header.classList.add('col-12');
		div_row.appendChild(header);
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
		// If the user is logged in they will be able to change their favorites.
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
			// Change whether the item is favorite or not.
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
		div_row8.appendChild(checkboxLabel);
		article.appendChild(div3);
		(container as HTMLElement).appendChild(article);
	});
	if(container.childElementCount == 0) container.innerHTML = '<p class="text-center">Geen items gemarkeerd als favoriet.</p>';
}
export {fillUserFavorites}