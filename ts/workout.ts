import {listParser, site_oefeningen} from './global';
function FillWorkout(): void {
	const container = [
		document.getElementById("js-cardio"),
		document.getElementById("js-kracht"),
		document.getElementById("js-rug")
	];
	if(container[0] == null || container[1] == null || container[2] == null) {
		return console.error("Missing element");
	}
	/** @const {HTMLElement[]} container */
	const oefeningen = sessionStorage.getItem('oefeningen');
	if(oefeningen == null) return console.error('Missing session item');
	const data = JSON.parse(oefeningen);
	if(!(data instanceof Array<site_oefeningen>)) return console.error('Failed to parse JSON from sessionStorage');
	// The element is created filled with data and then added to its container.
	(data as site_oefeningen[]).forEach(function(this: any, value: site_oefeningen, _index: number, _array: site_oefeningen[]): void {
		if(value.workout == null || value.workout.length < 1) return;
		const article = document.createElement('article');
		article.classList.add('oefeningen', "oefeningen-schema", "border", "border-dark", "rounded", "my-3", "py-2", "me-1");
		// The header element
		const header = document.createElement('h4');
		header.innerText = value.name;
		article.appendChild(header);
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
			value.spiergroepen.split(',').forEach(function(this: any, value: string, _index: number, _array: string[]): void {
				// Each musslegroup has it's own span.
				const attrib = document.createElement('span');
				attrib.classList.add('musclegroup');
				attrib.innerText = value;
				atribs.appendChild(attrib);
			});
		}
		article.appendChild(atribs);
		// The description.
		const desc = document.createElement('p');
		desc.classList.add('explanation');
		desc.innerText = value.description;
		listParser(desc);
		article.appendChild(desc);
		// Lastly the image if one exists.
		if(value.images && value.images[0]) {
			const img = document.createElement('img');
			img.loading = "lazy";
			img.referrerPolicy = "no-referrer";
			img.src = value.images[0].src;
			if(value.images[0].height && value.images[0].width) {
				img.height = value.images[0].height;
				img.width = value.images[0].width;
			}
			// An empty string into the alt attribute to mark it as decorative.
			img.setAttribute("alt", "");
			article.appendChild(img);
		}
		// Because there's potentually mulitple or no categories the article belongs to we add a copy to each and delete the original.
		(value.workout as string[]).forEach(function(this: HTMLElement[], value: string, _index: number, _obj: string[]): void {
			switch(value) {
				case "Cardio":
					(this[0] as HTMLElement).appendChild(article.cloneNode(true));
					break;
				case "Kracht":
					(this[1] as HTMLElement).appendChild(article.cloneNode(true));
					break;
				case "Rug":
					(this[2] as HTMLElement).appendChild(article.cloneNode(true));
					break;
			}
		}, (container as HTMLElement[]));
		article.remove();
	});
}
export {FillWorkout}