/**
 * Basis for notification stuff that will be properly added later.
 * @see https://developer.mozilla.org/en-US/docs/Web/API/notification
 */
function notifyMe() {
	// If the browser does not support notifications
	if (!("Notification" in window)) {
		alert("This browser does not support desktop notification");
		return;
	}
	// If permission hasn't been requested yet we request them and rerun the function.
	if(Notification.permission == "default") {
		Notification.requestPermission().then(() => notifyMe());
		return;
	}
	// If the user has denied notifications: Don't do anything.
	if(Notification.permission == "denied") return;
	// TODO do notification stuff.
}
