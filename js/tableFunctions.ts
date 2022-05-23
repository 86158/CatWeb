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
		if(tags != undefined && tagParaf != null) {
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