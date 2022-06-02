/** For switching login form from login mode to new user mode and back.*/
function main() {
	function checkPwdConform(this: HTMLInputElement, _ev: MouseEvent): boolean {
		/** The field the password is filled at.*/
		const pwdField = document.querySelector<HTMLInputElement>('main>form.login fieldset input[name=Password]');
		/** The field used to comform the password was filled correctly.*/
		const pwdConformField = document.querySelector<HTMLInputElement>('main>form.login fieldset input[name=confirmPassword]');
		if(pwdField == null || pwdConformField == null) {
			console.error("Required field deleted.");
			return false;
		}
		return pwdConformField.value == pwdField.value;
	}
	/** The button to switch the modes of the form.*/
	const button = document.getElementById('newUserButton') as HTMLButtonElement;
	if(!(button instanceof HTMLButtonElement)) {console.error("button#newUserButton not found"); return;}
	button.addEventListener('click', function(this: HTMLButtonElement, _ev: MouseEvent): void {
		/** The hidden input is for informing the php what the form is for.*/
		const formType = document.querySelector<HTMLInputElement>('main>form.login input[type=hidden]');
		const h2 = document.querySelector<HTMLHeadingElement>('main>form h2');
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
		if(!(h2 instanceof HTMLHeadingElement)) {console.log('h2 not found'); return;}
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
			usernameField.pattern = '^[^@]+$';
			formType.value = 'newUser';
			this.innerText = 'Heeft u al een account?';
			pwdField.autocomplete = 'new-password';
			btnChange.value = 'Account Aanmaken';
			btnChange.addEventListener('click', checkPwdConform);
			h2.innerText = 'Account Aanmaken';
		} else {
			fieldset1.hidden = fieldset3.hidden = true;
			emailField.required = pwdConformField.required = false;
			usernameField.pattern = '';
			formType.value = 'login';
			this.innerText = 'Heeft u nog geen account?';
			pwdField.autocomplete = 'current-password';
			btnChange.value = 'Inloggen';
			btnChange.removeEventListener('click', checkPwdConform);
			h2.innerText = 'Log In';
		}
	});
}
main();