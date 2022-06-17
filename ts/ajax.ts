import {responce, setFavorite} from './global.js';
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
function ajax_error(_jqXHR: JQuery.jqXHR|null = null, textStatus: "timeout"|"error"|"abort"|"parsererror"|null = null, errorThrown?: string): void {
	// Send the error messages to the console.
	console.error(textStatus, errorThrown);
}
/**
 * A function to be called if the request succeeds.
 * The function gets passed three arguments:
 ** The data returned from the server, formatted according to the dataType parameter or the dataFilter callback function,
 ** if specified; a string describing the status;
 ** and the jqXHR (in jQuery 1.4.x, XMLHttpRequest) object.
*/
function ajax_success(this: JQuery.Ajax.AjaxSettingsBase<any>, data: JSON|responce, _textStatus: string|null, jqXHR: JQuery.jqXHR): void {
	// Check if the request was a success
	if(!('code' in data))
		return ajax_error(jqXHR, "parsererror");
	if(data.code != 200)
		return console.error(data);
}

/**
 * Request the article to be added with data.
 */
function requestOefeningen(): JQuery.jqXHR<any> {
	// Settings object for calling getOefeningen.php
	const settings: JQuery.AjaxSettings<any> = {
		accepts: {json:"application/json"},
		async: true,
		cache: true,
		dataType: "json",
		method: "GET",
		url: "./php/getOefeningen.php",
		/**
		 * A function to be called if the request succeeds.
		 * The function gets passed three arguments:
		 ** The data returned from the server, formatted according to the dataType parameter or the dataFilter callback function,
		 ** if specified; a string describing the status;
		 ** and the jqXHR (in jQuery 1.4.x, XMLHttpRequest) object.*/
		success: function ajax_success_oefening(data: JSON|responce, _textStatus: string|null, jqXHR: JQuery.jqXHR): void {
			// Check if data is of the expected type.
			if(!('code' in data))
				return ajax_error(jqXHR, "parsererror");
			// Check if the request was a success.
			if(data.code != 200 || data.output == undefined)
				return console.error("Response with error code: ", data);
			// Store output in sessionstorage. This is to prevent the data being requested every time a page is loaded.
			sessionStorage.setItem('oefeningen', JSON.stringify(data.output));
		},
		error: ajax_error
	};
	return $.ajax(settings);
}
/**
 * Set favorites to be modified
*/
function setFavorites(favorites: setFavorite[]): JQuery.jqXHR<any> {
	// Settings object for calling setFavorites.php
	var settings: JQuery.AjaxSettings<any> = {
		accepts: {json:"application/json"},
		contentType: 'application/json; charset=UTF-8',
		async: true,
		dataType: "json",
		method: "POST",
		url: "./php/setFavorites.php",
		data: JSON.stringify(favorites),
		error: ajax_error,
		success: ajax_success
	};
	return $.ajax(settings);
}
function createSchema(ids: number[]): JQuery.jqXHR<any> {
	// Settings object for calling createSchema.php
	var settings: JQuery.AjaxSettings<any> = {
		accepts: {json:"application/json"},
		contentType: 'application/json; charset=UTF-8',
		async: true,
		dataType: "json",
		method: "POST",
		url: "./php/createSchema.php",
		data: JSON.stringify(ids),
		error: ajax_error,
		success: ajax_success
	};
	return $.ajax(settings);
}
export {requestOefeningen, setFavorites, createSchema}