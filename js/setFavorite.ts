interface setFavorite {
	user: number;
	oefening: number;
	remove: boolean;
}
/**
 * Set favorites to be modified
 */
function setData(favorites: setFavorite[]): JQuery.jqXHR<any> {
	var settings: JQuery.AjaxSettings<any> = {
		accepts: {json:"application/json"},
		contentType: 'application/json; charset=UTF-8',
		async: true,
		dataType: "json",
		method: "POST",
		url: "./php/setFavorites.php",
		data: JSON.stringify(favorites),
		/** A function to be called if the request fails.
		 * The function receives three arguments:
		 ** The jqXHR (in jQuery 1.4.x, XMLHttpRequest) object,
		 ** a string describing the type of error that occurred
		 ** and an optional exception object, if one occurred.
		 * Possible values for the second argument (besides null) are "timeout", "error", "abort", and "parsererror".

		 * When an HTTP error occurs, errorThrown receives the textual portion of the HTTP status, such as "Not Found" or "Internal Server Error". (in HTTP/2 it may instead be an empty string)
		 * As of jQuery 1.5, the error setting can accept an array of functions.
		 * Each function will be called in turn.
		 * Note: This handler is not called for cross-domain script and cross-domain JSONP requests.
		 * This is an Ajax Event.*/
		error: function(_jqXHR: JQuery.jqXHR, textStatus: "timeout"|"error"|"abort"|"parsererror"|null, errorThrown?: string) {
			console.error(textStatus);
			if(errorThrown) console.error(errorThrown);
		}
	};
	return $.ajax(settings);
}