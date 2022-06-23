import { loginNewUser } from "./login.js";
import { requestOefeningen } from "./ajax.js";
import { fillOefeningen } from './oefeningen.js';
import { fillSchema, schemaMaker } from './schema.js';
import { fillWorkout } from "./workout.js";
import { setupFilters } from './tableFunctions.js';
async function main(): Promise<void> {
	// Called on every page.
	loginNewUser();
	// Get the page we are on.
	const searchParams = new URLSearchParams(window.location.search);
	const alert = searchParams.get('alert');
	if(alert != null) {
		console.warn(alert);
		const modalButton = document.querySelector<HTMLButtonElement>('nav button[data-bs-target="#exampleModal"]');
		if(modalButton != null) {
			modalButton.click();
			const modalHeader = document.querySelector<HTMLDivElement>('nav div.modal-header');
			if(modalHeader != null) {
				const alertDiv = document.createElement('div');
				alertDiv.innerText = alert;
				alertDiv.classList.add('alert');
				modalHeader.insertBefore(alertDiv, modalHeader.lastChild);
			} else console.error('Failed to find modal header.');
		} else console.error('Failed to find modal button.');
	}
	const page = searchParams.get('page');
	// Get the elements we'll need prepaired. We don't check if they exist yet as we may not actually use them.
	const oefeningen = sessionStorage.getItem('oefeningen');
	const filterform = document.getElementById('js-filters');
	const container = document.getElementById('js-oefeningen');
	// For each page check if the needed items exist and activate the needed funtions.
	switch(page) {
		case 'prac':
			if(container == null) {
				console.error('Failed to find element#js-oefeningen');
				break;
			}
			// For those that use oefeningen we ensure we have the data stored.
			if(oefeningen == null) {
				await requestOefeningen();
			}
			fillOefeningen(container);
			if(!(filterform instanceof HTMLFormElement)) {
				console.warn('Failed to find form#js-filters');
				break;
			}
			setupFilters(filterform, container);
			break;
		case 'schema':
			if(container == null) {
				console.error('Failed to find element#js-oefeningen');
				break;
			}
			if(oefeningen == null) {
				await requestOefeningen();
			}
			fillSchema(container);
			schemaMaker();
			if(!(filterform instanceof HTMLFormElement)) {
				console.warn('Failed to find form#js-filters');
				break;
			}
			setupFilters(filterform, container);
			break;
		case 'work':
			if(oefeningen == null) {
				await requestOefeningen();
			}
			fillWorkout();
			break;
	}
}
// The main function handles the loading of every script and is the only one with an effect when ran.
window.addEventListener('load', main);