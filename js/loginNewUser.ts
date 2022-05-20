/*
 * For switching the modes of `login.html`.
 * Made to be useable seperatly yet I've manually added it to the page.
 * See `pages/login.html` for where this is implemented.
*/
const button = document.getElementById('newUserButton') as HTMLButtonElement;
button.addEventListener('click', () => {
	// The second fieldset contains the imputs for creating a new user.
	const fieldset2 = document.querySelector<HTMLFieldSetElement>('main>form>fieldset:nth-of-type(2)');
	// The hidden input is for informing the php what the form is for.
	const formType = document.querySelector<HTMLInputElement>('main>form input[type=hidden]');
	const pwdField = document.querySelector<HTMLInputElement>('main>form input[type=password]');
	// ensure the items where correctly selected.
	if(!(pwdField instanceof HTMLInputElement) || !(formType instanceof HTMLInputElement) || !(fieldset2 instanceof HTMLFieldSetElement)) return;
	// We use the visability state of the second fieldset to determine the current mode.
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