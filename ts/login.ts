/** For switching login form from login mode to new user mode and back.*/
function loginNewUser() {
	/** The form on which all happens */
	const form = document.querySelector('main>form.login');
	if(!(form instanceof HTMLFormElement)) {console.error("main>form.login not found"); return;}
	// Ensure that when logging in and out the formdata is reset so favorites are properly requested.
	form.addEventListener('submit', function(this: HTMLFormElement, _ev: SubmitEvent) {
		sessionStorage.removeItem('oefeningen');
	});
	/** The button to switch the modes of the form.*/
	const button = document.getElementById('newUserButton') as HTMLButtonElement;
	if(!(button instanceof HTMLButtonElement)) {console.error("button#newUserButton not found"); return;}
	function checkPwdConform(this: HTMLInputElement, _ev: Event): void {
		/** The field used to comform the password was filled correctly.*/
		const pwdConformField = document.querySelector<HTMLInputElement>('main>form.login fieldset input[name=confirmPassword]');
		if(pwdConformField == null) {
			console.error("Required field deleted.");
			return;
		}
		// Replace the special characters in the pwd field and use it to test if the pwdConformField matches.
		pwdConformField.pattern = '^' + this.value.replace(/[^\w]/g, '\\$&') + '$';
	}
	button.addEventListener('click', function(this: HTMLButtonElement, _ev: MouseEvent): void {
		/** The hidden input is for informing the php what the form is for.*/
		const formType = document.querySelector<HTMLInputElement>('main>form.login input[type=hidden]');
		const h3 = document.querySelector<HTMLHeadingElement>('div.header>h3');
		/** The 1e and 3e fieldsets contain the imputs for creating a new user.*/
		const fieldset1 = document.querySelector<HTMLFieldSetElement>('main>form.login>fieldset:nth-of-type(1)');
		/** The 1e and 3e fieldsets contain the imputs for creating a new user.*/
		const fieldset3 = document.querySelector<HTMLFieldSetElement>('main>form.login>fieldset:nth-of-type(3)');
		/** The field the user puts in their username when creating a new account and username or email when logging in. */
		const usernameField = document.querySelector<HTMLInputElement>('main>form.login input[name=Username]');
		/** The field the user inputs their e-mail when creating a new account.*/
		const emailField = document.querySelector<HTMLInputElement>('main>form.login input[name=Mail]');
		/** The field the password is filled at. We change the autocomplete property to inform browsers whether an existing password should be used or a new one should be generated.*/
		const pwdField = document.querySelector<HTMLInputElement>('main>form.login fieldset input[name=Password]');
		/** The field to comform the password is correct. */
		const pwdConformField = document.querySelector<HTMLInputElement>('main>form.login fieldset input[name=confirmPassword]');
		/** The button used for submitting the form. We change it's value to inform users of what the action on click is.*/
		const btnChange = document.querySelector<HTMLInputElement>('main>form.login>div input[type=submit]');
		// ensure the items where correctly selected.
		if(!(formType instanceof HTMLInputElement)) {console.log("formType not found"); return;}
		if(!(h3 instanceof HTMLHeadingElement)) {console.log('h3 not found'); return;}
		if(!(fieldset1 instanceof HTMLFieldSetElement)) {console.log("fieldset1 not found"); return;}
		if(!(fieldset3 instanceof HTMLFieldSetElement)) {console.log("fieldset3 not found"); return;}
		if(!(usernameField instanceof HTMLInputElement)) {console.log('usernameField not found'); return;}
		if(!(emailField instanceof HTMLInputElement)) {console.log('emailField not found'); return;}
		if(!(pwdField instanceof HTMLInputElement)) {console.log("pwdField not found"); return;}
		if(!(pwdConformField instanceof HTMLInputElement)) {console.log("pwdConformField not found"); return;}
		if(!(btnChange instanceof HTMLInputElement)) {console.log('btnChange not found'); return;}
		// We use the visability state of the fieldset to determine the current mode.
		if(fieldset1.hidden) {
			fieldset1.hidden = fieldset3.hidden = false;
			emailField.required = pwdConformField.required = true;
			usernameField.pattern = '[\\p{L}\\p{N}_ ]+';
			usernameField.title = 'Usernames may only contain letters, numbers, underscores and spaces.';
			formType.value = 'newUser';
			this.innerText = 'Heeft u al een account?';
			pwdField.autocomplete = 'new-password';
			pwdField.title = 'Passwords may not contain NULL characters, tab characters, carriage return characters, new line characters, vertical tab characters or form feed characters.';
			btnChange.value = 'Account Aanmaken';
			pwdField.addEventListener('input', checkPwdConform);
			h3.innerText = 'Account Aanmaken';
		} else {
			fieldset1.hidden = fieldset3.hidden = true;
			emailField.required = pwdConformField.required = false;
			usernameField.pattern = '';
			usernameField.title = '';
			formType.value = 'login';
			this.innerText = 'Heeft u nog geen account?';
			pwdField.autocomplete = 'current-password';
			btnChange.value = 'Inloggen';
			pwdField.removeEventListener('input', checkPwdConform);
			h3.innerText = 'Log In';
		}
	});
}
export {loginNewUser};