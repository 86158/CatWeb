// For switching login form from login mode to new user mode and back.

/** The button to switch the modes of the form.*/
const button = document.getElementById('newUserButton') as HTMLButtonElement;
button.addEventListener('click', function(this: HTMLButtonElement, _ev: MouseEvent): void {
	/** The 1e and 3e fieldsets contain the imputs for creating a new user.*/
	const fieldset1 = document.querySelector<HTMLFieldSetElement>('main>form>fieldset:nth-of-type(1)');
	/** The 1e and 3e fieldsets contain the imputs for creating a new user.*/
	const fieldset3 = document.querySelector<HTMLFieldSetElement>('main>form>fieldset:nth-of-type(3)');
	const h2 = document.querySelector<HTMLHeadingElement>('main>form h2');
	/** The hidden input is for informing the php what the form is for.*/
	const formType = document.querySelector<HTMLInputElement>('main>form input[type=hidden]');
	/** The field the password is filled at. We change the autocomplete property to inform browsers whether an existing password should be used or a new one should be generated.*/
	const pwdField = document.querySelector<HTMLInputElement>('main>form input[type=password]');
	/** The button used for submitting the form. We change it's value to inform users of what the action on click is.*/
	const btnChange = document.querySelector<HTMLInputElement>('main>form>div input[type=submit]');
	// ensure the items where correctly selected.
	if(!(pwdField instanceof HTMLInputElement)) {console.log("pwdField not found"); return;}
	if(!(formType instanceof HTMLInputElement)) {console.log("formType not found"); return;}
	if(!(fieldset3 instanceof HTMLFieldSetElement)) {console.log("fieldset3 not found"); return;}
	if(!(fieldset1 instanceof HTMLFieldSetElement)) {console.log("fieldset1 not found"); return;}
	if(!(btnChange instanceof HTMLInputElement)) {console.log('btnChange not found'); return;}
	if(!(h2 instanceof HTMLHeadingElement)) {console.log('h2 not found'); return;}
	// We use the visability state of the fieldset to determine the current mode.
	if(fieldset1.hidden) {
		fieldset1.hidden = fieldset3.hidden = false;
		formType.value = 'newUser';
		this.innerText = 'Heeft u al een account?';
		pwdField.autocomplete = 'new-password';
		btnChange.value = 'Account Aanmaken';
		h2.innerText = 'Account Aanmaken';
	} else {
		fieldset1.hidden = fieldset3.hidden = true;
		formType.value = 'login';
		this.innerText = 'Heeft u nog geen account?';
		pwdField.autocomplete = 'current-password';
		btnChange.value = 'Inloggen';
		h2.innerText = 'Log In';
	}
});