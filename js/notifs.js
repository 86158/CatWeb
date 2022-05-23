"use strict";
function notifyMe(title, contents, time) {
	if(!("Notification" in window)) {
		alert("This browser does not support desktop notification");
		return;
	}
	if(Notification.permission == "default") {
		Notification.requestPermission().then(() => notifyMe(title, contents, time));
		return;
	}
	if(Notification.permission == "denied")
		return;
	var notifSettings = {
		badge: undefined,
		body: contents,
		dir: "ltr",
		icon: undefined,
		image: undefined,
		lang: "nl",
		renotify: true,
		requireInteraction: true,
		silent: false,
		timestamp: time,
		tag: undefined
	};
	var timeout = 0;
	if(time != undefined) {
		timeout = time - (new Date()).getTime();
	}
	if(timeout < 1) {
		new Notification(title, notifSettings);
	} else {
		setTimeout(() => { new Notification(title, notifSettings); }, timeout);
	}
}
