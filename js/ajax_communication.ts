// For filling the table with data.
interface site_oefeningen {
	/**A positive integer.*/
	ID: number;
	/** The name of the exercise.*/
	name: string;
	/** The description of the exercise.*/
	description: string;
	/** Comma separated list of types.*/
	type: string|null;
	/** Comma separated list of musslegroups used in the exercise.*/
	spiergroepen: string|null;
	/** Estimated duration in seconds.*/
	duration: number|null;
	/** Estimated callori usage.*/
	calorien: number|null;
	/** Images */
	images: Array<string>|null;
	/** Videos */
	videos: Array<string>|null;
	workout: Array<string>|null;
	/** If logged in shows whether the item is marked as a favorite */
	favorite?: boolean;
}
interface responce { 
	code: number;
	error?: string;
	trace?: string;
	output?: site_oefeningen[];
}
interface setFavorite {
	/** The ID of the oefening to favorite */
	oefening: number;
	/** Set to true to remove it instead of add a favorite.*/
	remove: boolean;
}
/**
 * A function to be called if the request fails.
 * The function receives three arguments:
 ** The jqXHR (in jQuery 1.4.x, XMLHttpRequest) object,
 ** a string describing the type of error that occurred
 ** and an optional exception object, if one occurred.
 * Possible values for the second argument (besides null) are "timeout", "error", "abort", and "parsererror".

 * When an HTTP error occurs, errorThrown receives the textual portion of the HTTP status, such as "Not Found" or "Internal Server Error". (in HTTP/2 it may instead be an empty string)
 * As of jQuery 1.5, the error setting can accept an array of functions.
 * Each function will be called in turn.
 * Note: This handler is not called for cross-domain script and cross-domain JSONP requests.
 * This is an Ajax Event.
 */
function ajax_error(_jqXHR: JQuery.jqXHR, textStatus: "timeout"|"error"|"abort"|"parsererror"|null, errorThrown?: string) {
	console.error(textStatus);
	if(errorThrown)
		console.error(errorThrown);
}
/**
 * A function to be called if the request succeeds.
 * The function gets passed three arguments:
 ** The data returned from the server, formatted according to the dataType parameter or the dataFilter callback function,
 ** if specified; a string describing the status;
 ** and the jqXHR (in jQuery 1.4.x, XMLHttpRequest) object.
 */
function ajax_oefeningen(data: JSON|responce, _textStatus: string|null, jqXHR: JQuery.jqXHR) {
	if(!('code' in data))
		return errorHandling(jqXHR, "parsererror");
	if(data.code != 200 || data.output == undefined)
		return console.error(data);
	//get parameter from the URL of the page
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	const page = urlParams.get('page');
	console.log(page); // DEBUG
	const container = document.getElementById("js-oefeningen");
	if(container == null) return;
	// Clear placeholders
	container.innerHTML = "";
	// For each row we add a article to the container.
	// The element is created filled with data and then added to its container.
	data.output.forEach(element => {
		const div = document.createElement('div');
		div.classList.add('col');
		div.classList.add('oefeningen');
		const article = document.createElement('article');
		// The header element
		const header = document.createElement('h2');
		header.innerText = element.name;
		article.appendChild(header);
		// The atributes under the header but above the description. Each atribute has its own span.
		const atribs = document.createElement('p');
		atribs.classList.add('atributes');
		// //A span for the estimated duration.
		// const duration = document.createElement('p');
		// duration.innerText = 
		// 	(element.duration)?
		// 		element.duration.toString()
		// 		: "-";
		// atribs.appendChild(duration);
		// // A span for the estimated callories.
		// const call = document.createElement('p');
		// call.innerText =
		// 	(element.calorien)?
		// 		element.calorien.toString()
		// 		: "-";
		// atribs.appendChild(call);
		//A span for the type of exercise.
		const oType = document.createElement('p');
		oType.classList.add('difficulty');
		oType.innerText =
			(element.type)?
				element.type
				: "-";
		atribs.appendChild(oType);
		// The musslegroups a exercise uses as tags under the description.
		if(element.spiergroepen) {
			// Converting the comma seperated list into an array and iterating over it.
			element.spiergroepen.split(',').forEach(element => {
				// Each musslegroup has it's own span.
				const attrib = document.createElement('p');
				attrib.classList.add('musclegroup');
				attrib.innerText = element;
				atribs.appendChild(attrib);
			});
		}
		article.appendChild(atribs);
		// The description.
		const desc = document.createElement('p');
		desc.classList.add('explanation');
		desc.innerText = element.description;
		article.appendChild(desc);
		const groups = document.createElement('span');
		groups.classList.add('tags');
		article.appendChild(groups);
		// Lastly the image if one exists.
		const img = document.createElement('img');
		if(element.images && element.images[0])
			img.src = element.images[0];
		// An empty string into the alt attribute to mark it as decorative.
		img.setAttribute("alt", "");
		article.appendChild(img);
		// adds a button to allow oefening to be added to schema.
		if(page == 'schema') {
			const btn = document.createElement('button');
			btn.textContent = 'Voeg toe aan schema';
			article.appendChild(btn);
		}
		if(element.favorite != undefined) {
			const checkboxLabel = document.createElement('label');
			checkboxLabel.innerHTML = `<label><svg><use xlink:href="./assets/star.svg#svg-star"/></svg><input type="checkbox"/></label>`;
			const checkboxInput = checkboxLabel.querySelector('input') as HTMLInputElement;
			checkboxInput.style.fill = (element.favorite)? "yellow" : "none";
			checkboxInput.checked = element.favorite;
			checkboxInput.id = element.ID.toString();
			checkboxInput.addEventListener('input',
				function(this: HTMLInputElement, ev: Event): void {
					ev.preventDefault();
					this.disabled = true;
					const checked = (this.style.fill == "yellow");
					var waiter = setFavorites([{
						oefening: Number(this.id),
						remove: checked
					}]);
					waiter.done(() => {
						this.checked = !checked;
						this.style.fill = (checked)? "none": "yellow";
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
		div.appendChild(article);
		container.appendChild(div);
	});
}
/**
 * Request the article to be added with data.
 */
function getOefeningen(): JQuery.jqXHR<any> {
	var settings: JQuery.AjaxSettings<any> = {
		accepts: {json:"application/json"},
		async: true,
		cache: true,
		dataType: "json",
		method: "GET",
		url: "./php/getOefeningen2.php",
		success: ajax_oefeningen,
		error: ajax_error
	};
	return $.ajax(settings);
}
/**
 * Set favorites to be modified
 */
 function setFavorites(favorites: setFavorite[]): JQuery.jqXHR<any> {
	var settings: JQuery.AjaxSettings<any> = {
		accepts: {json:"application/json"},
		contentType: 'application/json; charset=UTF-8',
		async: true,
		dataType: "json",
		method: "POST",
		url: "./php/setFavorites2.php",
		data: JSON.stringify(favorites),
		error: ajax_error,
		/**
		 * A function to be called if the request succeeds.
		 * The function gets passed three arguments:
		 ** The data returned from the server, formatted according to the dataType parameter or the dataFilter callback function,
		 ** if specified; a string describing the status;
		 ** and the jqXHR (in jQuery 1.4.x, XMLHttpRequest) object.*/
		success: function(data: JSON|responce, _textStatus: string|null, jqXHR: JQuery.jqXHR) {
			if(!('code' in data))
				return errorHandling(jqXHR, "parsererror");
			if(data.code != 200)
				return console.error(data);
		}
	};
	return $.ajax(settings);
}
window.addEventListener('load', getOefeningen);