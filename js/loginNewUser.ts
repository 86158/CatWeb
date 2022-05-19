/* Switching the modes of `login.html`.
 * Must be manually added to page.
*/
const button = document.getElementById('newUserButton') as HTMLButtonElement;
button.addEventListener('click', () => {
	// See pages/login.html for where this is implemented.
	const fieldset2 = document.querySelector<HTMLFieldSetElement>('main>form>fieldset:nth-of-type(2)');
	const formType = document.querySelector<HTMLInputElement>('main>form input[type=hidden]');
	const pwdField = document.querySelector<HTMLInputElement>('main>form input[type=password]');
	if(!(pwdField instanceof HTMLInputElement) || !(formType instanceof HTMLInputElement) || !(fieldset2 instanceof HTMLFieldSetElement)) return;
	if(fieldset2.hidden) {
		fieldset2.hidden = false;
		formType.value = 'newUser';
		button.innerText = 'Modus: Nieuw gebruiker aanmaken';
		pwdField.autocomplete = 'new-password';
	} else {
		fieldset2.hidden = true;
		formType.value = 'login';
		button.innerText = 'Modus: Inloggen';
		pwdField.autocomplete = 'current-password';
	}
});