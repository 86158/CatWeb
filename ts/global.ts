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
/** Change written lists into list elements */
function listParser(element: HTMLElement): void {
	// Match unordered lists
	var matchAll = element.innerHTML.match(/(?:<br> ?• [^<]+)+(?:<br>)?/g);
	if(matchAll != null) {
		matchAll.forEach(function(this: any, value: string, _index: number, _array: string[]): void {
			const result = value.match(/(?<= ?• )[^<]+/g);
			if(result == null) return;
			var modify = '<ul>';
			result.forEach(function(this: any, subvalue: string, _index: number, _array: string[]): void {
				modify += '<li>'+ subvalue +'</li>';
			});
			modify += '</ul>';
			element.innerHTML = element.innerHTML.replace(value, modify);
		});
	}
	// Match ordered lists and ensure they get the correct number.
	matchAll = element.innerHTML.match(/(?:<br>\d+\.[^<]+)+(?:<br>)?/g);
	if(matchAll != null) {
		matchAll.forEach(function(this: any, value: string, _index: number, _array: string[]): void {
			var index: number = 0;
			var maxValue: number = 0;
			const lines: string[] = [];
			while(index <= value.length) {
				const result = / ?(\d+)\. ([^<]+)/.exec(value.substring(index));
				if(result == null) break;
				index += (result[0] as string).length;
				const resultIndex = Number(result[1]) - 1;
				if(resultIndex > maxValue) maxValue = resultIndex;
				lines[resultIndex] = result[2] as string;
			}
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