"use strict";
function errorHandling(_jqXHR, textStatus, errorThrown) {
	console.error(textStatus);
	if(errorThrown)
		console.error(errorThrown);
}
function successHandling(data, _textStatus, jqXHR) {
	if(!(data instanceof Array)) {
		errorHandling(jqXHR, "parsererror");
		return;
	}
	const container = document.getElementById("js-oefeningen");
	if(container == null)
		return;
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
		img.setAttribute("alt", "");
		article.appendChild(img);
		container.appendChild(article);
	});
}
function getData(article) {
	var settings = {
		accepts: { json: "application/json" },
		async: true,
		cache: true,
		dataType: "json",
		method: "GET",
		success: successHandling,
		error: errorHandling
	};
	switch(article) {
		case "fav":
			settings.url = "./php/getFavorites.php";
			break;
		default:
			settings.url = "./php/getOefeningen.php";
			break;
	}
	return $.ajax(settings);
}
