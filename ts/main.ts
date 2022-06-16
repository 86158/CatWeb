import { loginNewUser } from "./login";
import { requestOefeningen } from "./ajax";
import { FillOefeningen } from './oefeningen';
import { FillSchema, schemaMaker } from './schema';
import { FillWorkout } from "./workout";
async function main(): Promise<void> {
	loginNewUser();
	const page = new URLSearchParams(window.location.search).get('page');
	const oefeningen = sessionStorage.getItem('oefeningen');
	switch(page) {
		case 'prac':
			if(oefeningen != null) {
				await requestOefeningen();
			}
			FillOefeningen();
			break;
		case 'schema':
			if(oefeningen != null) {
				await requestOefeningen();
			}
			FillSchema();
			schemaMaker();
			break;
		case 'work':
			if(oefeningen != null) {
				await requestOefeningen();
			}
			FillWorkout();
			break;
	}
}
window.addEventListener('load', main);