/**
 * Unhides all articles and then hides those not matching the constraints.
 * @param container The container containing the articles to be tested.
 * @param searchQuery A string that will be searched for in the header. If not found the article will be hidden.
 * @param tags A list of tags where if none match one in the article it will be hidden.
 */
function articleFilter(container: HTMLElement, searchQuery?: string|RegExp|undefined, tags?: Array<string>|undefined) {
	// Get the articles we need to check.
	const articles = container.getElementsByTagName('article');
	// If the searchQuery is a string convert it to a regex query.
	if(typeof searchQuery == 'string')
		searchQuery = new RegExp(searchQuery, 'i');
	// Go over each article to check whether it matches the filters.
	for(let index = 0; index < articles.length; index++) {
		const article = articles[index] as HTMLElement;
		// Ensure none are hidden hidden then if it doesn't match the filters hide it.
		article.hidden = false;
		const header = article.querySelector('h4');
		const tagParaf = article.querySelectorAll<HTMLSpanElement>('p.atributes>span.musclegroup');
		// Check whether the header doesn't match the text from the searchQuery if one exist.
		if(searchQuery instanceof RegExp && header != null && !searchQuery.test(header.innerText)) {
			article.hidden = true;
			// No need to check for other things if it already failed here.
			continue;
		}
		// Check whether it has the tags if any where specified.
		if(tags != undefined && tagParaf != null && tags.length > 0) {
			var noMatch = true;
			// Go over each tagg to check.
			for(let index = 0; index < tagParaf.length; index++) {
				const spanText = (tagParaf[index] as HTMLSpanElement).innerText.toLowerCase();
				if(tags.findIndex((value: string, _index: number, _obj: string[]) => {return value.toLowerCase() == spanText;}) != -1) {
					noMatch = false;
					break;
				}
			}
			if(noMatch)
				article.hidden = true;
		}
	}
}
/** Add eventlisteners to the form to handle the filtering.
 * @param {HTMLFormElement} filterForm The form to which the eventlistener should be added.
 * @param {HTMLElement} itemContainer The container that contains the elements to be checked.
*/
function setupFilters(filterForm: HTMLFormElement, itemContainer: HTMLElement) {
	filterForm.addEventListener('submit', function(this: HTMLFormElement, _ev: SubmitEvent) {
		// Prevent the form from being triggered again while busy.
		this.style.pointerEvents = 'none';
		// Get the formdata and extract the values.
		const formData = new FormData(this);
		var query: string|undefined = undefined;
		var tags: Array<string>|undefined = undefined;
		for(var pair of formData.entries()) {
			switch(pair[0]) {
				case 'search':
					query = pair[1].toString();
					if(query == '') query = undefined;
					break;
				case 'tags':
					tags = (pair[1].toString() == '')?
						undefined :
						pair[1].toString().split(',');
					break;
			}
		}
		// Send the data to the articleFilter function to test each element.
		articleFilter(itemContainer, query, tags);
		// Re-enable the form after a delay.
		setTimeout(() => this.style.pointerEvents = '', 950);
	});
	filterForm.addEventListener('reset', function(this: HTMLFormElement, _ev: Event) {
		// Prevent the form from being triggered again while busy.
		this.style.pointerEvents = 'none';
		// Calling the function without secondary arguments to unhide all items.
		articleFilter(itemContainer);
		// Re-enable the form after a delay.
		setTimeout(() => this.style.pointerEvents = '', 950);
	});
}
export {setupFilters}