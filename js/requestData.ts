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
	data.forEach(element => {
		const article = document.createElement('article');
		const header = document.createElement('h2');
		header.innerText = element.name;
		article.appendChild(header);
		const atribs = document.createElement('p');
		atribs.classList.add('atributes');
		const duration = document.createElement('span');
		duration.innerText = 
			(element.duration)?
				element.duration.toString()
				: "-";
		atribs.appendChild(duration);
		const call = document.createElement('span');
		call.innerText =
			(element.calorien)?
			element.calorien.toString()
			: "-";
		atribs.appendChild(call);
		const oType = document.createElement('span');
		oType.innerText =
			(element.type)?
			element.type
			: "-";
		atribs.appendChild(oType);
		article.appendChild(atribs);
		const desc = document.createElement('p');
		desc.classList.add('description');
		desc.innerText = element.description;
		article.appendChild(desc);
		const groups = document.createElement('p');
		groups.classList.add('tags');
		if(element.spiergroepen) {
			element.spiergroepen.split(',').forEach(element => {
				const attrib = document.createElement('span');
				attrib.innerText = "#" + element;
				groups.appendChild(attrib);
			});
		}
		article.appendChild(groups);
		const img = document.createElement('img');
		if(element.img)
			img.src = element.img;
		article.appendChild(img);
		container.appendChild(article);
	});
}
function getData(article: "prac"|"fav") {
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