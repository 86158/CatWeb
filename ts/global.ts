/** Global ts functions and definitions */

/** The format the php returns the tabledata in.*/
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
	images: Array<{
		src: string;
		width: number|null;
		height: number|null;
	}>|null;
	/** Videos */
	videos: Array<string>|null;
	workout: Array<string>|null;
	/** If logged in shows whether the item is marked as a favorite */
	favorite?: boolean;
}
/** The way the php responds to requests.*/
interface responce {
	code: number;
	error?: string;
	trace?: string;
	output?: site_oefeningen[];
}
/** The way setFavorites.php expects the data.*/
interface setFavorite {
	/** The ID of the oefening to favorite */
	oefening: number;
	/** Set to true to remove it instead of add a favorite.*/
	remove: boolean;
}
/**
 * Change written lists into list elements.
 * @param {HTMLElement} element The element where the innerHTML will be searched for the tags.
 * @param {boolean} skipNumbers Whether to add empty lines to make the line numbers match up.
 * @example With element.innerHTML as:
 * ```html
 * <br>• line1<br>• line2<br>3. line3<br>4. line4<br>
 * ```
 * and `skipNumbers=false` it will change the innerHTML to:
 * ```html
 * <ul><li>line1</li><li>line2</li></ul><ol><li>line3</li><li>line4</li></ol>
 * ```
 * With `skipNumbers=true` it will instead be changed to:
 * ```html
 * <ul><li>line1</li><li>line2</li></ul><ol><li></li><li></li><li>line3</li><li>line4</li></ol>
 * ```
 */
function listParser(element: HTMLElement, skipNumbers: boolean = false): void {
	// Match unordered lists
	var matchAll = element.innerHTML.match(/(?:<br> *• [^<]+)+(?:<br>)?/g);
	if(matchAll != null) {
		matchAll.forEach(function(this: any, value: string, _index: number, _array: string[]): void {
			// Get each element of each match.
			const result = value.match(/(?<= *• )[^<]+/g);
			if(result == null) return;
			var modify = '<ul>';
			// And give each entry a listitem and each match a list.
			result.forEach(function(this: any, subvalue: string, _index: number, _array: string[]): void {
				modify += '<li>'+ subvalue +'</li>';
			});
			modify += '</ul>';
			element.innerHTML = element.innerHTML.replace(value, modify);
		});
	}
	// Match ordered lists and ensure they get the correct number.
	matchAll = element.innerHTML.match(/(?:<br> *\d+\.[^<]+)+(?:<br>)?/g);
	if(matchAll != null) {
		// Go trough all matches.
		matchAll.forEach(function(this: any, value: string, _index: number, _array: string[]): void {
			var index: number = 0;
			var maxValue: number = 0;
			const lines: string[] = [];
			// Extract each line into the lines array.
			while(index <= value.length) {
				const result = / *(\d+)\. ([^<]+)/.exec(value.substring(index));
				if(result == null) break;
				index += (result[0] as string).length;
				if(skipNumbers) {
					// Give each the correct index if skipping missing numbers.
					const resultIndex = Number(result[1]) - 1;
					if(resultIndex > maxValue) maxValue = resultIndex;
					lines[resultIndex] = result[2] as string;
				} else {
					// Otherwise just add them to the array.
					lines.push(result[2] as string);
				}
			}
			if(!skipNumbers) maxValue = lines.length;
			// And give each entry a listitem and fill in the content.
			var modify = '<ol>';
			for(let index = 0; index <= maxValue; index++) {
				const result = lines[index];
				modify += '<li>';
				if(result != undefined) modify += result;
				modify += '</li>';
			}
			modify += '</ol>';
			element.innerHTML = element.innerHTML.replace(value, modify);
		});
	}
}
export {listParser, site_oefeningen, responce, setFavorite}