/**
 * Unhides all articles and then hides those not matching the constraints.
 * @param container The container containing the articles to be tested.
 * @param searchQuery A string that will be searched for in the header. If not found the article will be hidden.
 * @param tags A list of tags where if none match one in the article it will be hidden.
 */
function articleFilter(container: HTMLElement, searchQuery?: string|RegExp|undefined, tags?: Array<string>|undefined) {
	const articles = container.getElementsByTagName('article');
	if(typeof searchQuery == 'string')
		searchQuery = new RegExp(searchQuery, 'i');
	for(let index = 0; index < articles.length; index++) {
		const article = articles[index] as HTMLElement;
		article.hidden = false;
		const header = article.querySelector('h2');
		const tagParaf = article.querySelector('p.tags');
		if(searchQuery instanceof RegExp && header != null && !searchQuery.test(header.innerText)) {
			article.hidden = true;
			continue;
		}
		if(tags != undefined && tagParaf != null && tags.length > 0) {
			var noMatch = true;
			const children = tagParaf.children as HTMLCollectionOf<HTMLSpanElement>;
			for(let index = 0; index < children.length; index++) {
				const span = children[index] as HTMLSpanElement;
				const test = span.innerText.replace('#', '');
				if(tags.findIndex((value) => {value == test}) != -1) {
					noMatch = false;
					break;
				}
			}
			if(noMatch)
				article.hidden = true;
		}
	}
}
/**Extracts the results from the form and triggers `tableFilter()`*/
function handleFilter(event: MouseEvent): void {
	const form = ((event.target as HTMLButtonElement|HTMLInputElement).form as HTMLFormElement);
	form.style.pointerEvents = 'none';
	const formData = new FormData(form);
	var query: string|undefined = undefined;
	var tags: Array<string>|undefined = undefined;
	if((event.target as HTMLButtonElement|HTMLInputElement).type != 'reset') {
		for(var pair of formData.entries()) {
			switch(pair[0]) {
				case 'search':
					query = pair[1].toString();
					if(query == '') query = undefined;
					break;
				case 'tags':
					if(pair[1].toString() == '') {
						tags = undefined;
					} else {
						tags = pair[1].toString().split(',');
					}
					break;
			}
		}
	}
	const section = document.getElementById('js-oefeningen');
	if(section != null)
		articleFilter(section, query, tags);
	setTimeout(() => form.style.pointerEvents = '', 950);
}