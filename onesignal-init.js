var OneSignal = window.OneSignal || [];
OneSignal.push(["init", {
	appId: "66f4ac3c-5360-4957-b5ef-e0ec3cc8f156",
	autoRegister: false,
	/* Set to true to automatically prompt visitors */
	subdomainName: 'notifier1234',
	httpPermissionRequest: {
		enable: true
	},
	notifyButton: {
		enable: true /* Set to false to hide */
	}
}]);
OneSignal.push(function () {});

OneSignal.push(function () {
	OneSignal.setDefaultNotificationUrl(
		"http://notifier.esy.es/personal.html");
	// Occurs when the user's subscription changes to a new value.
	OneSignal.on('subscriptionChange', function (isSubscribed) {
		if (isSubscribed) {
			OneSignal.getUserId(function (userId) {
				console.log("OneSignal User ID:", userId);
				$.ajax({
					url: '/server/player_id.php',
					type: 'POST',
					data: {
						player_id: userId
					}
				}).done(function (data) {
					console.log('player id sent successfully', data);
					location.href = './personal.html';
				}).fail(function (event, jqxhr, settings, thrownError) {
					console.log(event + jqxhr.status + settings + thrownError);
				});

			});
		}
	});
});
