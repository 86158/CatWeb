/*
 * For switching the modes of `login.html`.
 * Made to be useable seperatly yet I've manually added it to the page.
 * See `pages/login.html` for where this is implemented.
*/
const button = document.getElementById('newUserButton') as HTMLButtonElement;
button.addEventListener('click', () => {
	// The second fieldset contains the imputs for creating a new user.
	const fieldset3 = document.querySelector<HTMLFieldSetElement>('main>form>fieldset:nth-of-type(3)');
	const fieldset1 = document.querySelector<HTMLFieldSetElement>('main>form>fieldset:nth-of-type(1)');
	const h2 = document.querySelector<HTMLHeadingElement>('main>form h2');
	// The hidden input is for informing the php what the form is for.
	const formType = document.querySelector<HTMLInputElement>('main>form input[type=hidden]');
	const pwdField = document.querySelector<HTMLInputElement>('main>form input[type=password]');
	const btnChange = document.querySelector<HTMLInputElement>('main>form>div input[type=submit]');
	// ensure the items where correctly selected.
	if(!(pwdField instanceof HTMLInputElement)) {console.log("pwdField not found"); return;};
	if(!(formType instanceof HTMLInputElement)) {console.log("formType not found"); return;};
	if(!(fieldset3 instanceof HTMLFieldSetElement)) {console.log("fieldset3 not found"); return;}
	if(!(fieldset1 instanceof HTMLFieldSetElement)) {console.log("fieldset1 not found"); return;}
	if(!(btnChange instanceof HTMLInputElement)) {console.log('btnChange not found'); return;}
	if(!(h2 instanceof HTMLHeadingElement)) {console.log('h2 not found'); return;}
	// We use the visability state of the second fieldset to determine the current mode.
	if(fieldset1.hidden && fieldset3.hidden) {
		fieldset1.hidden = false;
		fieldset3.hidden = false;
		formType.value = 'newUser';
		button.innerText = 'Account aanmaken';
		pwdField.autocomplete = 'new-password';
		btnChange.value = 'Account aanmaken';
		h2.innerText = 'Account Aanmaken';
	} else {
		fieldset1.hidden = true;
		fieldset3.hidden = true;
		formType.value = 'login';
		button.innerText = 'Inloggen';
		pwdField.autocomplete = 'current-password';
		btnChange.defaultValue = btnChange.value = 'Inloggen';
		h2.innerText = 'Log In';
	}
});