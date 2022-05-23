/**
 * Check for permissions and send a notification to the user if we have.
 * @param {string} title The title of the notification.
 * @param {string} contents The message inside the notification.
 * @param {number|undefined} time The timestamp at which to send the notification.
 * @see https://developer.mozilla.org/en-US/docs/Web/API/notification
 */
function notifyMe(title: string, contents: string, time?: EpochTimeStamp) {
	// If the browser does not support notifications
	if(!("Notification" in window)) {
		alert("This browser does not support desktop notification");
		return;
	}
	// If permission hasn't been requested yet we request them and rerun the function.
	if(Notification.permission == "default") {
		Notification.requestPermission().then(() => notifyMe(title, contents, time));
		return;
	}
	// If the user has denied notifications: Don't do anything.
	if(Notification.permission == "denied") return;
	// Create the notification and delay it's popup if the timestamp is in the future.
	var notifSettings: NotificationOptions = {
		/**The URL of the image used to represent the notification when there is not enough space to display the notification itself.*/
		badge: undefined,
		body: contents,
		/**The text direction of the notification.*/
		dir: "ltr",
		/**The URL of the image used as an icon of the notification.*/
		icon: undefined,
		/**The URL of an image to be displayed as part of the notification.*/
		image: undefined,
		/**The language code of the notification.*/
		lang: "nl",
		/**Specifies whether the user should be notified after a new notification replaces an old one.*/
		renotify: true,
		/**A boolean value indicating that a notification should remain active until the user clicks or dismisses it, rather than closing automatically.*/
		requireInteraction: true,
		/**Specifies whether the notification should be silent — i.e., no sounds or vibrations should be issued, regardless of the device settings.*/
		silent: false,
		/**Specifies the time at which a notification is created or applicable (past, present, or future).*/
		timestamp: time,
		/**The ID of the notification (if any)*/
		tag: undefined
	};
	var timeout = 0;
	if(time != undefined) {
		timeout = time - (new Date()).getTime();
	}
	if(timeout < 1) {
		new Notification(title, notifSettings);
	} else {
		setTimeout(() => {new Notification(title, notifSettings);}, timeout);
	}
}
