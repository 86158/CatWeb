// Special ts file for the Schema page
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
function ajax_error_schema(_jqXHR: JQuery.jqXHR, textStatus: "timeout"|"error"|"abort"|"parsererror"|null, errorThrown?: string) {
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
function ajax_oefeningen_schema(data: JSON|responce, _textStatus: string|null, jqXHR: JQuery.jqXHR) {
	if(!('code' in data))
		return ajax_error_schema(jqXHR, "parsererror");
	if(data.code != 200 || data.output == undefined)
		return console.error(data);
	//get parameter from the URL of the page
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	const page = urlParams.get('page');
	let container: HTMLElement | null | Array<HTMLElement|null>;
	container = document.getElementById("js-oefeningen");
    if(container == null) return console.error("Missing element");
    // Clear placeholders
    container.innerHTML = "";
    container.classList.add('col-7', 'col-custom', 'mt-3', 'overflow-auto');
	// For each row we add a article to the container.
	// The element is created filled with data and then added to its container.
	data.output.forEach((value: site_oefeningen, _index: number, _array: site_oefeningen[]): void => {
		const article = document.createElement('article');
		article.classList.add('oefeningen', "oefeningen-schema", "border", "border-dark", "rounded", "my-3", "py-2", "me-1", "row-oefeningen", "row");
		// The header element
        const div = document.createElement('div');
        div.classList.add('col-8');
        const div2 = document.createElement('div');
        div2.classList.add("row");
		const header = document.createElement('h4');
		header.innerText = value.name;
        header.classList.add('col-12');
		div2.appendChild(header);
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
			value.spiergroepen.split(',').forEach(element => {
				// Each musslegroup has it's own span.
				const attrib = document.createElement('span');
				attrib.classList.add('musclegroup');
				attrib.innerText = element;
				atribs.appendChild(attrib);
			});
		}
		div2.appendChild(atribs);
		// The description.
		const desc = document.createElement('p');
		desc.classList.add('explanation');
		desc.innerText = value.description;
        desc.classList.add("col-12");
		div2.appendChild(desc);
        div.appendChild(div2);
        article.appendChild(div);
		// Lastly the image if one exists.
        const div3 = document.createElement('div');
        div3.classList.add("col-4");
		const img = document.createElement('img');
		img.loading = "lazy";
		img.referrerPolicy = "no-referrer";
		if(value.images && value.images[0])
			img.src = value.images[0];
		// An empty string into the alt attribute to mark it as decorative.
		img.setAttribute("alt", "");
        img.classList.add("col-4");
        div3.appendChild(img);
		// adds a button to allow oefening to be added to schema.
		const btn = document.createElement('button');
		btn.classList.add('btn', 'btn-primary');
		btn.textContent = 'Voeg toe aan schema';
		div3.appendChild(btn);
		article.appendChild(div3);

		(container as HTMLElement).appendChild(article);
	});
}
/**
 * Request the article to be added with data.
 */
function getOefeningen_Schema(): JQuery.jqXHR<any> {
	var settings: JQuery.AjaxSettings<any> = {
		accepts: {json:"application/json"},
		async: true,
		cache: true,
		dataType: "json",
		method: "GET",
		url: "./php/getOefeningen.php",
		success: ajax_oefeningen_schema,
		error: ajax_error_schema
	};
	return $.ajax(settings);
}
window.addEventListener('load', getOefeningen_Schema);