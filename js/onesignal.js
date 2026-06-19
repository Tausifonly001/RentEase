/**
 * OneSignal Push Notification Integration
 * Responsibilities:
 * 1. Initialize OneSignal with App ID
 * 2. Sync Supabase User ID with OneSignal External ID
 * 3. Handle Permission Requests
 */

window.OneSignal = window.OneSignal || [];

OneSignal.push(function() {
    if (!window.RENTEASE_CONFIG || !window.RENTEASE_CONFIG.onesignal_app_id) {
        return;
    }

    OneSignal.init({
        appId: window.RENTEASE_CONFIG.onesignal_app_id,
        safari_web_id: window.RENTEASE_CONFIG.onesignal_safari_web_id,
        serviceWorkerPath: '/rentease/OneSignalSDKWorker.js',
        serviceWorkerParam: { scope: '/rentease/' },
        notifyButton: {
            enable: true,
            position: 'bottom-right',
            theme: 'default',
            colors: {
                'circle.background': '#006a65',
                'circle.foreground': 'white',
                'badge.background': 'red',
                'badge.foreground': 'white',
                'badge.border': 'white',
                'pulse.color': '#006a65',
                'dialog.button.primary.background': '#006a65',
                'dialog.button.primary.foreground': 'white',
                'dialog.button.secondary.background': 'white',
                'dialog.button.secondary.foreground': '#006a65'
            }
        },
        allowLocalhostAsSecureOrigin: true,
    });

    const userId = window.RENTEASE_CONFIG.current_user_id;
    if (userId) {
        OneSignal.login(userId);
    } else {
        OneSignal.logout();
    }

    OneSignal.on('subscriptionChange', function(isSubscribed) {
        // subscription state changed
    });

    OneSignal.on('notificationDisplay', function(event) {
        // notification displayed
    });
});
