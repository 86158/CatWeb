import { loginNewUser } from "./login.js";
import { requestOefeningen } from "./ajax.js";
import { FillOefeningen } from './oefeningen.js';
import { FillSchema, schemaMaker } from './schema.js';
import { FillWorkout } from "./workout.js";
async function main(): Promise<void> {
	loginNewUser();
	const page = new URLSearchParams(window.location.search).get('page');
	const oefeningen = sessionStorage.getItem('oefeningen');
	switch(page) {
		case 'prac':
			if(oefeningen == null) {
				await requestOefeningen();
			}
			FillOefeningen();
			break;
		case 'schema':
			if(oefeningen == null) {
				await requestOefeningen();
			}
			FillSchema();
			schemaMaker();
			break;
		case 'work':
			if(oefeningen == null) {
				await requestOefeningen();
			}
			FillWorkout();
			break;
	}
}
window.addEventListener('load', main);