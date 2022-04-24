<script>
function onManageWebPushSubscriptionButtonClicked(event) {
        getSubscriptionState().then(function(state) {
            console.log('apakah ini button click')
            $('#loaderNotif').show();
            if (state.isPushEnabled) {
                /* Subscribed, opt them out */
                OneSignal.setSubscription(false);
                console.log('unsubscribe');
            } else {
                if (state.isOptedOut) {
                    /* Opted out, opt them back in */
                    OneSignal.setSubscription(true);
                    OneSignal.push(function() {
                        OneSignal.getUserId(function(userId) {
                            console.log("OneSignal User ID:", userId);
                            $.ajax({
                                url: '<?=base_url()?>notifikasi/registernotif',
                                type: 'post',
                                data: {app:userId},
                                success: function(res) {
                                    alert('Push Notifikasi sudah dikaitkan.');
                                },
                                error: function(err) {
                                    alert('Push Notifikasi gagal dikaitkan.');
                                }
                            })
                            // (Output) OneSignal User ID: 270a35cd-4dda-4b3f-b04e-41d7463a2316    
                        });
                    });
                } else {
                    /* Unsubscribed, subscribe them */
                    OneSignal.registerForPushNotifications();
                }
            }
            
            
        });
        event.preventDefault();
    }

    function updateMangeWebPushSubscriptionButton(buttonSelector) {
        console.log('sedang proses');
        var hideWhenSubscribed = false;
        var subscribeText = "Subscribe to Notifications";
        var unsubscribeText = "Unsubscribe from Notifications";

        getSubscriptionState().then(function(state) {
            var buttonText = !state.isPushEnabled || state.isOptedOut ? subscribeText : unsubscribeText;

            var element = document.querySelector(buttonSelector);
            if (element === null) {
                return;
            }

            element.removeEventListener('click', onManageWebPushSubscriptionButtonClicked);
            element.addEventListener('click', onManageWebPushSubscriptionButtonClicked);
            element.textContent = buttonText;

            if(buttonText == subscribeText) {

            }

            if (state.hideWhenSubscribed && state.isPushEnabled) {
                element.style.display = "none";
            } else {
                element.style.display = "";
            }
            $('#loaderNotif').hide();
        });
    }

    function getSubscriptionState() {
        return Promise.all([
          OneSignal.isPushNotificationsEnabled(),
          OneSignal.isOptedOut()
        ]).then(function(result) {
            var isPushEnabled = result[0];
            var isOptedOut = result[1];

            return {
                isPushEnabled: isPushEnabled,
                isOptedOut: isOptedOut
            };
        });
    }

    var OneSignal = OneSignal || [];
    var buttonSelector = "#my-notification-button";

    /* This example assumes you've already initialized OneSignal */
    OneSignal.push(function() {
        // If we're on an unsupported browser, do nothing
        if (!OneSignal.isPushNotificationsSupported()) {
            return;
        }
        updateMangeWebPushSubscriptionButton(buttonSelector);
        OneSignal.on("subscriptionChange", function(isSubscribed) {
            /* If the user's subscription state changes during the page's session, update the button text */
            updateMangeWebPushSubscriptionButton(buttonSelector);
        });
    });
</script>