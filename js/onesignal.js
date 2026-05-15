/**
 * OneSignal Push Notification Integration
 * Responsibilities:
 * 1. Initialize OneSignal with App ID
 * 2. Sync Supabase User ID with OneSignal External ID
 * 3. Handle Permission Requests
 */

window.OneSignal = window.OneSignal || [];

console.log('[OneSignal] Script loaded, current config:', window.RENTEASE_CONFIG);

OneSignal.push(function() {
    console.log('[OneSignal] SDK Push callback triggered');
    
    if (!window.RENTEASE_CONFIG || !window.RENTEASE_CONFIG.onesignal_app_id) {
        console.error('[OneSignal] Missing App ID or RENTEASE_CONFIG');
        return;
    }

    // 1. Initialize with configuration
    console.log('[OneSignal] Initializing with App ID:', window.RENTEASE_CONFIG.onesignal_app_id);
    
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
        allowLocalhostAsSecureOrigin: true, // For XAMPP development
    });

    // 2. Identify User if logged in
    const userId = window.RENTEASE_CONFIG.current_user_id;
    if (userId) {
        console.log('[OneSignal] Identifying user:', userId);
        OneSignal.login(userId);
    } else {
        console.log('[OneSignal] Guest user session');
        OneSignal.logout();
    }

    // 3. Subscription handling
    OneSignal.on('subscriptionChange', function(isSubscribed) {
        console.log('[OneSignal] The user\'s subscription state is now:', isSubscribed);
    });

    // 4. Notification handling (Foreground)
    OneSignal.on('notificationDisplay', function(event) {
        console.warn('[OneSignal] Notification displayed:', event);
    });
});
