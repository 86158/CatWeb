// For filling the table with data.
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
function errorHandling(_jqXHR: JQuery.jqXHR, textStatus: "timeout"|"error"|"abort"|"parsererror"|null, errorThrown?: string) {
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
function successHandling(data: JSON|site_oefeningen[], _textStatus: string|null, jqXHR: JQuery.jqXHR) {
	if(!(data instanceof Array)) {
		errorHandling(jqXHR, "parsererror");
		return;
	}
	const container = document.getElementById("js-oefeningen");
	if(container == null) return;
	// Clear placeholders
	container.innerHTML = "";
	// For each row we add a article to the container.
	// The element is created filled with data and then added to its container.
	data.forEach(element => {
		const div = document.createElement('div');
		div.classList.add('col');
		const article = document.createElement('article');
		// The header element
		const header = document.createElement('h2');
		header.innerText = element.name;
		article.appendChild(header);
		// The atributes under the header but above the description. Each atribute has its own span.
		const atribs = document.createElement('p');
		atribs.classList.add('atributes');
		// A span for the estimated duration.
		const duration = document.createElement('span');
		duration.innerText = 
			(element.duration)?
				element.duration.toString()
				: "-";
		atribs.appendChild(duration);
		// A span for the estimated callories.
		const call = document.createElement('span');
		call.innerText =
			(element.calorien)?
				element.calorien.toString()
				: "-";
		atribs.appendChild(call);
		// A span for the type of exercise.
		const oType = document.createElement('span');
		oType.innerText =
			(element.type)?
				element.type
				: "-";
		atribs.appendChild(oType);
		article.appendChild(atribs);
		// The description.
		const desc = document.createElement('p');
		desc.classList.add('description');
		desc.innerText = element.description;
		article.appendChild(desc);
		// The musslegroups a exercise uses as tags under the description.
		const groups = document.createElement('p');
		groups.classList.add('tags');
		// Check if there are any musslegroups accociated with the exercise.
		if(element.spiergroepen) {
			// Converting the comma seperated list into an array and iterating over it.
			element.spiergroepen.split(',').forEach(element => {
				// Each musslegroup has it's own span.
				const attrib = document.createElement('span');
				attrib.innerText = "#" + element;
				groups.appendChild(attrib);
			});
		}
		article.appendChild(groups);
		// Lastly the image if one exists.
		const img = document.createElement('img');
		if(element.img)
			img.src = element.img;
		// An empty string into the alt attribute to mark it as decorative.
		img.setAttribute("alt", "");
		article.appendChild(img);
		div.appendChild(article);
		container.appendChild(div);
	});
}
/**
 * Request the article to be added with data.
 * @param article Whether to get all exercises or only the favorites.
 */
function getData(article: null|"all"|"fav"): JQuery.jqXHR<any> {
	var settings: JQuery.AjaxSettings<any> = {
		accepts: {json:"application/json"},
		async: true,
		cache: true,
		dataType: "json",
		method: "GET",
		success: successHandling,
		error: errorHandling
	};
	switch(article) {
		case "fav":
			settings.url = "./php/getFavorites.php"; // Check what url to use
			break;
		default:
			settings.url = "./php/getOefeningen.php"; // Check what url to use
			break;
	}
	return $.ajax(settings);
}