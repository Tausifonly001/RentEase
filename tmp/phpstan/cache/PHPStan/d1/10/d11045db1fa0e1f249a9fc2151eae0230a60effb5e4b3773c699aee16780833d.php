<?php declare(strict_types = 1);

// osfsl-C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/Event.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Stripe\Event
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-ffd62bd45246d4f0913ec73f98f9339197e48e459fa81054143e8e45d6d32f34-8.2.12-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Stripe\\Event',
        'filename' => 'C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/Event.php',
      ),
    ),
    'namespace' => 'Stripe',
    'name' => 'Stripe\\Event',
    'shortName' => 'Event',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * Events are our way of letting you know when something interesting happens in
 * your account. When an interesting event occurs, we create a new <code>Event</code>
 * object. For example, when a charge succeeds, we create a <code>charge.succeeded</code>
 * event, and when an invoice payment attempt fails, we create an
 * <code>invoice.payment_failed</code> event. Certain API requests might create multiple
 * events. For example, if you create a new subscription for a
 * customer, you receive both a <code>customer.subscription.created</code> event and a
 * <code>charge.succeeded</code> event.
 *
 * Events occur when the state of another API resource changes. The event\'s data
 * field embeds the resource\'s state at the time of the change. For
 * example, a <code>charge.succeeded</code> event contains a charge, and an
 * <code>invoice.payment_failed</code> event contains an invoice.
 *
 * As with other API resources, you can use endpoints to retrieve an
 * <a href="https://stripe.com/docs/api#retrieve_event">individual event</a> or a <a href="https://stripe.com/docs/api#list_events">list of events</a>
 * from the API. We also have a separate
 * <a href="http://en.wikipedia.org/wiki/Webhook">webhooks</a> system for sending the
 * <code>Event</code> objects directly to an endpoint on your server. You can manage
 * webhooks in your
 * <a href="https://dashboard.stripe.com/account/webhooks">account settings</a>. Learn how
 * to <a href="https://docs.stripe.com/webhooks">listen for events</a>
 * so that your integration can automatically trigger reactions.
 *
 * When using <a href="https://docs.stripe.com/connect">Connect</a>, you can also receive event notifications
 * that occur in connected accounts. For these events, there\'s an
 * additional <code>account</code> attribute in the received <code>Event</code> object.
 *
 * We only guarantee access to events through the <a href="https://stripe.com/docs/api#retrieve_event">Retrieve Event API</a>
 * for 30 days.
 *
 * This class includes constants for the possible string representations of
 * event types. See https://stripe.com/docs/api#event_types for more details.
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object\'s type. Objects of the same type share the same value.
 * @property null|string $account The connected account that originates the event.
 * @property null|string $api_version The Stripe API version used to render <code>data</code>. This property is populated only for events on or after October 31, 2014.
 * @property int $created Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property \\Stripe\\StripeObject $data
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property int $pending_webhooks Number of webhooks that haven\'t been successfully delivered (for example, to return a 20x response) to the URLs you specify.
 * @property null|\\Stripe\\StripeObject $request Information on the API request that triggers the event.
 * @property string $type Description of the event (for example, <code>invoice.created</code> or <code>charge.refunded</code>).
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 53,
    'endLine' => 573,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Stripe\\ApiResource',
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
    ),
    'immediateConstants' => 
    array (
      'OBJECT_NAME' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'OBJECT_NAME',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'event\'',
          'attributes' => 
          array (
            'startLine' => 55,
            'endLine' => 55,
            'startTokenPos' => 27,
            'startFilePos' => 3458,
            'endTokenPos' => 27,
            'endFilePos' => 3464,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 55,
        'endLine' => 55,
        'startColumn' => 5,
        'endColumn' => 32,
      ),
      'ACCOUNT_APPLICATION_AUTHORIZED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ACCOUNT_APPLICATION_AUTHORIZED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'account.application.authorized\'',
          'attributes' => 
          array (
            'startLine' => 57,
            'endLine' => 57,
            'startTokenPos' => 36,
            'startFilePos' => 3513,
            'endTokenPos' => 36,
            'endFilePos' => 3544,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 57,
        'endLine' => 57,
        'startColumn' => 5,
        'endColumn' => 76,
      ),
      'ACCOUNT_APPLICATION_DEAUTHORIZED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ACCOUNT_APPLICATION_DEAUTHORIZED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'account.application.deauthorized\'',
          'attributes' => 
          array (
            'startLine' => 58,
            'endLine' => 58,
            'startTokenPos' => 45,
            'startFilePos' => 3593,
            'endTokenPos' => 45,
            'endFilePos' => 3626,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 58,
        'endLine' => 58,
        'startColumn' => 5,
        'endColumn' => 80,
      ),
      'ACCOUNT_EXTERNAL_ACCOUNT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ACCOUNT_EXTERNAL_ACCOUNT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'account.external_account.created\'',
          'attributes' => 
          array (
            'startLine' => 59,
            'endLine' => 59,
            'startTokenPos' => 54,
            'startFilePos' => 3675,
            'endTokenPos' => 54,
            'endFilePos' => 3708,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 59,
        'endLine' => 59,
        'startColumn' => 5,
        'endColumn' => 80,
      ),
      'ACCOUNT_EXTERNAL_ACCOUNT_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ACCOUNT_EXTERNAL_ACCOUNT_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'account.external_account.deleted\'',
          'attributes' => 
          array (
            'startLine' => 60,
            'endLine' => 60,
            'startTokenPos' => 63,
            'startFilePos' => 3757,
            'endTokenPos' => 63,
            'endFilePos' => 3790,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 60,
        'endLine' => 60,
        'startColumn' => 5,
        'endColumn' => 80,
      ),
      'ACCOUNT_EXTERNAL_ACCOUNT_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ACCOUNT_EXTERNAL_ACCOUNT_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'account.external_account.updated\'',
          'attributes' => 
          array (
            'startLine' => 61,
            'endLine' => 61,
            'startTokenPos' => 72,
            'startFilePos' => 3839,
            'endTokenPos' => 72,
            'endFilePos' => 3872,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 61,
        'endLine' => 61,
        'startColumn' => 5,
        'endColumn' => 80,
      ),
      'ACCOUNT_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ACCOUNT_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'account.updated\'',
          'attributes' => 
          array (
            'startLine' => 62,
            'endLine' => 62,
            'startTokenPos' => 81,
            'startFilePos' => 3904,
            'endTokenPos' => 81,
            'endFilePos' => 3920,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 62,
        'endLine' => 62,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'APPLICATION_FEE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'APPLICATION_FEE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'application_fee.created\'',
          'attributes' => 
          array (
            'startLine' => 63,
            'endLine' => 63,
            'startTokenPos' => 90,
            'startFilePos' => 3960,
            'endTokenPos' => 90,
            'endFilePos' => 3984,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 63,
        'endLine' => 63,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'APPLICATION_FEE_REFUNDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'APPLICATION_FEE_REFUNDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'application_fee.refunded\'',
          'attributes' => 
          array (
            'startLine' => 64,
            'endLine' => 64,
            'startTokenPos' => 99,
            'startFilePos' => 4025,
            'endTokenPos' => 99,
            'endFilePos' => 4050,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 64,
        'endLine' => 64,
        'startColumn' => 5,
        'endColumn' => 64,
      ),
      'APPLICATION_FEE_REFUND_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'APPLICATION_FEE_REFUND_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'application_fee.refund.updated\'',
          'attributes' => 
          array (
            'startLine' => 65,
            'endLine' => 65,
            'startTokenPos' => 108,
            'startFilePos' => 4097,
            'endTokenPos' => 108,
            'endFilePos' => 4128,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 65,
        'endLine' => 65,
        'startColumn' => 5,
        'endColumn' => 76,
      ),
      'BALANCE_AVAILABLE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'BALANCE_AVAILABLE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'balance.available\'',
          'attributes' => 
          array (
            'startLine' => 66,
            'endLine' => 66,
            'startTokenPos' => 117,
            'startFilePos' => 4162,
            'endTokenPos' => 117,
            'endFilePos' => 4180,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 66,
        'endLine' => 66,
        'startColumn' => 5,
        'endColumn' => 50,
      ),
      'BILLING_ALERT_TRIGGERED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'BILLING_ALERT_TRIGGERED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'billing.alert.triggered\'',
          'attributes' => 
          array (
            'startLine' => 67,
            'endLine' => 67,
            'startTokenPos' => 126,
            'startFilePos' => 4220,
            'endTokenPos' => 126,
            'endFilePos' => 4244,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 67,
        'endLine' => 67,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'BILLING_PORTAL_CONFIGURATION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'BILLING_PORTAL_CONFIGURATION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'billing_portal.configuration.created\'',
          'attributes' => 
          array (
            'startLine' => 68,
            'endLine' => 68,
            'startTokenPos' => 135,
            'startFilePos' => 4297,
            'endTokenPos' => 135,
            'endFilePos' => 4334,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 68,
        'endLine' => 68,
        'startColumn' => 5,
        'endColumn' => 88,
      ),
      'BILLING_PORTAL_CONFIGURATION_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'BILLING_PORTAL_CONFIGURATION_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'billing_portal.configuration.updated\'',
          'attributes' => 
          array (
            'startLine' => 69,
            'endLine' => 69,
            'startTokenPos' => 144,
            'startFilePos' => 4387,
            'endTokenPos' => 144,
            'endFilePos' => 4424,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 69,
        'endLine' => 69,
        'startColumn' => 5,
        'endColumn' => 88,
      ),
      'BILLING_PORTAL_SESSION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'BILLING_PORTAL_SESSION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'billing_portal.session.created\'',
          'attributes' => 
          array (
            'startLine' => 70,
            'endLine' => 70,
            'startTokenPos' => 153,
            'startFilePos' => 4471,
            'endTokenPos' => 153,
            'endFilePos' => 4502,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 70,
        'endLine' => 70,
        'startColumn' => 5,
        'endColumn' => 76,
      ),
      'CAPABILITY_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CAPABILITY_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'capability.updated\'',
          'attributes' => 
          array (
            'startLine' => 71,
            'endLine' => 71,
            'startTokenPos' => 162,
            'startFilePos' => 4537,
            'endTokenPos' => 162,
            'endFilePos' => 4556,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 71,
        'endLine' => 71,
        'startColumn' => 5,
        'endColumn' => 52,
      ),
      'CASH_BALANCE_FUNDS_AVAILABLE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CASH_BALANCE_FUNDS_AVAILABLE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'cash_balance.funds_available\'',
          'attributes' => 
          array (
            'startLine' => 72,
            'endLine' => 72,
            'startTokenPos' => 171,
            'startFilePos' => 4601,
            'endTokenPos' => 171,
            'endFilePos' => 4630,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 72,
        'endLine' => 72,
        'startColumn' => 5,
        'endColumn' => 72,
      ),
      'CHARGE_CAPTURED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHARGE_CAPTURED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.captured\'',
          'attributes' => 
          array (
            'startLine' => 73,
            'endLine' => 73,
            'startTokenPos' => 180,
            'startFilePos' => 4662,
            'endTokenPos' => 180,
            'endFilePos' => 4678,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 73,
        'endLine' => 73,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'CHARGE_DISPUTE_CLOSED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHARGE_DISPUTE_CLOSED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.dispute.closed\'',
          'attributes' => 
          array (
            'startLine' => 74,
            'endLine' => 74,
            'startTokenPos' => 189,
            'startFilePos' => 4716,
            'endTokenPos' => 189,
            'endFilePos' => 4738,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 74,
        'endLine' => 74,
        'startColumn' => 5,
        'endColumn' => 58,
      ),
      'CHARGE_DISPUTE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHARGE_DISPUTE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.dispute.created\'',
          'attributes' => 
          array (
            'startLine' => 75,
            'endLine' => 75,
            'startTokenPos' => 198,
            'startFilePos' => 4777,
            'endTokenPos' => 198,
            'endFilePos' => 4800,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 75,
        'endLine' => 75,
        'startColumn' => 5,
        'endColumn' => 60,
      ),
      'CHARGE_DISPUTE_FUNDS_REINSTATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHARGE_DISPUTE_FUNDS_REINSTATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.dispute.funds_reinstated\'',
          'attributes' => 
          array (
            'startLine' => 76,
            'endLine' => 76,
            'startTokenPos' => 207,
            'startFilePos' => 4848,
            'endTokenPos' => 207,
            'endFilePos' => 4880,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 76,
        'endLine' => 76,
        'startColumn' => 5,
        'endColumn' => 78,
      ),
      'CHARGE_DISPUTE_FUNDS_WITHDRAWN' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHARGE_DISPUTE_FUNDS_WITHDRAWN',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.dispute.funds_withdrawn\'',
          'attributes' => 
          array (
            'startLine' => 77,
            'endLine' => 77,
            'startTokenPos' => 216,
            'startFilePos' => 4927,
            'endTokenPos' => 216,
            'endFilePos' => 4958,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 77,
        'endLine' => 77,
        'startColumn' => 5,
        'endColumn' => 76,
      ),
      'CHARGE_DISPUTE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHARGE_DISPUTE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.dispute.updated\'',
          'attributes' => 
          array (
            'startLine' => 78,
            'endLine' => 78,
            'startTokenPos' => 225,
            'startFilePos' => 4997,
            'endTokenPos' => 225,
            'endFilePos' => 5020,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 78,
        'endLine' => 78,
        'startColumn' => 5,
        'endColumn' => 60,
      ),
      'CHARGE_EXPIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHARGE_EXPIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.expired\'',
          'attributes' => 
          array (
            'startLine' => 79,
            'endLine' => 79,
            'startTokenPos' => 234,
            'startFilePos' => 5051,
            'endTokenPos' => 234,
            'endFilePos' => 5066,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 79,
        'endLine' => 79,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'CHARGE_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHARGE_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.failed\'',
          'attributes' => 
          array (
            'startLine' => 80,
            'endLine' => 80,
            'startTokenPos' => 243,
            'startFilePos' => 5096,
            'endTokenPos' => 243,
            'endFilePos' => 5110,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 80,
        'endLine' => 80,
        'startColumn' => 5,
        'endColumn' => 42,
      ),
      'CHARGE_PENDING' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHARGE_PENDING',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.pending\'',
          'attributes' => 
          array (
            'startLine' => 81,
            'endLine' => 81,
            'startTokenPos' => 252,
            'startFilePos' => 5141,
            'endTokenPos' => 252,
            'endFilePos' => 5156,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 81,
        'endLine' => 81,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'CHARGE_REFUNDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHARGE_REFUNDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.refunded\'',
          'attributes' => 
          array (
            'startLine' => 82,
            'endLine' => 82,
            'startTokenPos' => 261,
            'startFilePos' => 5188,
            'endTokenPos' => 261,
            'endFilePos' => 5204,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 82,
        'endLine' => 82,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'CHARGE_REFUND_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHARGE_REFUND_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.refund.updated\'',
          'attributes' => 
          array (
            'startLine' => 83,
            'endLine' => 83,
            'startTokenPos' => 270,
            'startFilePos' => 5242,
            'endTokenPos' => 270,
            'endFilePos' => 5264,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 83,
        'endLine' => 83,
        'startColumn' => 5,
        'endColumn' => 58,
      ),
      'CHARGE_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHARGE_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.succeeded\'',
          'attributes' => 
          array (
            'startLine' => 84,
            'endLine' => 84,
            'startTokenPos' => 279,
            'startFilePos' => 5297,
            'endTokenPos' => 279,
            'endFilePos' => 5314,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 84,
        'endLine' => 84,
        'startColumn' => 5,
        'endColumn' => 48,
      ),
      'CHARGE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHARGE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.updated\'',
          'attributes' => 
          array (
            'startLine' => 85,
            'endLine' => 85,
            'startTokenPos' => 288,
            'startFilePos' => 5345,
            'endTokenPos' => 288,
            'endFilePos' => 5360,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 85,
        'endLine' => 85,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'CHECKOUT_SESSION_ASYNC_PAYMENT_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHECKOUT_SESSION_ASYNC_PAYMENT_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'checkout.session.async_payment_failed\'',
          'attributes' => 
          array (
            'startLine' => 86,
            'endLine' => 86,
            'startTokenPos' => 297,
            'startFilePos' => 5414,
            'endTokenPos' => 297,
            'endFilePos' => 5452,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 86,
        'endLine' => 86,
        'startColumn' => 5,
        'endColumn' => 90,
      ),
      'CHECKOUT_SESSION_ASYNC_PAYMENT_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHECKOUT_SESSION_ASYNC_PAYMENT_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'checkout.session.async_payment_succeeded\'',
          'attributes' => 
          array (
            'startLine' => 87,
            'endLine' => 87,
            'startTokenPos' => 306,
            'startFilePos' => 5509,
            'endTokenPos' => 306,
            'endFilePos' => 5550,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 87,
        'endLine' => 87,
        'startColumn' => 5,
        'endColumn' => 96,
      ),
      'CHECKOUT_SESSION_COMPLETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHECKOUT_SESSION_COMPLETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'checkout.session.completed\'',
          'attributes' => 
          array (
            'startLine' => 88,
            'endLine' => 88,
            'startTokenPos' => 315,
            'startFilePos' => 5593,
            'endTokenPos' => 315,
            'endFilePos' => 5620,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 88,
        'endLine' => 88,
        'startColumn' => 5,
        'endColumn' => 68,
      ),
      'CHECKOUT_SESSION_EXPIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CHECKOUT_SESSION_EXPIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'checkout.session.expired\'',
          'attributes' => 
          array (
            'startLine' => 89,
            'endLine' => 89,
            'startTokenPos' => 324,
            'startFilePos' => 5661,
            'endTokenPos' => 324,
            'endFilePos' => 5686,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 89,
        'endLine' => 89,
        'startColumn' => 5,
        'endColumn' => 64,
      ),
      'CLIMATE_ORDER_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CLIMATE_ORDER_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'climate.order.canceled\'',
          'attributes' => 
          array (
            'startLine' => 90,
            'endLine' => 90,
            'startTokenPos' => 333,
            'startFilePos' => 5725,
            'endTokenPos' => 333,
            'endFilePos' => 5748,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 90,
        'endLine' => 90,
        'startColumn' => 5,
        'endColumn' => 60,
      ),
      'CLIMATE_ORDER_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CLIMATE_ORDER_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'climate.order.created\'',
          'attributes' => 
          array (
            'startLine' => 91,
            'endLine' => 91,
            'startTokenPos' => 342,
            'startFilePos' => 5786,
            'endTokenPos' => 342,
            'endFilePos' => 5808,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 91,
        'endLine' => 91,
        'startColumn' => 5,
        'endColumn' => 58,
      ),
      'CLIMATE_ORDER_DELAYED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CLIMATE_ORDER_DELAYED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'climate.order.delayed\'',
          'attributes' => 
          array (
            'startLine' => 92,
            'endLine' => 92,
            'startTokenPos' => 351,
            'startFilePos' => 5846,
            'endTokenPos' => 351,
            'endFilePos' => 5868,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 92,
        'endLine' => 92,
        'startColumn' => 5,
        'endColumn' => 58,
      ),
      'CLIMATE_ORDER_DELIVERED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CLIMATE_ORDER_DELIVERED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'climate.order.delivered\'',
          'attributes' => 
          array (
            'startLine' => 93,
            'endLine' => 93,
            'startTokenPos' => 360,
            'startFilePos' => 5908,
            'endTokenPos' => 360,
            'endFilePos' => 5932,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 93,
        'endLine' => 93,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'CLIMATE_ORDER_PRODUCT_SUBSTITUTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CLIMATE_ORDER_PRODUCT_SUBSTITUTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'climate.order.product_substituted\'',
          'attributes' => 
          array (
            'startLine' => 94,
            'endLine' => 94,
            'startTokenPos' => 369,
            'startFilePos' => 5982,
            'endTokenPos' => 369,
            'endFilePos' => 6016,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 94,
        'endLine' => 94,
        'startColumn' => 5,
        'endColumn' => 82,
      ),
      'CLIMATE_PRODUCT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CLIMATE_PRODUCT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'climate.product.created\'',
          'attributes' => 
          array (
            'startLine' => 95,
            'endLine' => 95,
            'startTokenPos' => 378,
            'startFilePos' => 6056,
            'endTokenPos' => 378,
            'endFilePos' => 6080,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 95,
        'endLine' => 95,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'CLIMATE_PRODUCT_PRICING_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CLIMATE_PRODUCT_PRICING_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'climate.product.pricing_updated\'',
          'attributes' => 
          array (
            'startLine' => 96,
            'endLine' => 96,
            'startTokenPos' => 387,
            'startFilePos' => 6128,
            'endTokenPos' => 387,
            'endFilePos' => 6160,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 96,
        'endLine' => 96,
        'startColumn' => 5,
        'endColumn' => 78,
      ),
      'COUPON_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'COUPON_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'coupon.created\'',
          'attributes' => 
          array (
            'startLine' => 97,
            'endLine' => 97,
            'startTokenPos' => 396,
            'startFilePos' => 6191,
            'endTokenPos' => 396,
            'endFilePos' => 6206,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 97,
        'endLine' => 97,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'COUPON_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'COUPON_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'coupon.deleted\'',
          'attributes' => 
          array (
            'startLine' => 98,
            'endLine' => 98,
            'startTokenPos' => 405,
            'startFilePos' => 6237,
            'endTokenPos' => 405,
            'endFilePos' => 6252,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 98,
        'endLine' => 98,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'COUPON_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'COUPON_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'coupon.updated\'',
          'attributes' => 
          array (
            'startLine' => 99,
            'endLine' => 99,
            'startTokenPos' => 414,
            'startFilePos' => 6283,
            'endTokenPos' => 414,
            'endFilePos' => 6298,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 99,
        'endLine' => 99,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'CREDIT_NOTE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CREDIT_NOTE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'credit_note.created\'',
          'attributes' => 
          array (
            'startLine' => 100,
            'endLine' => 100,
            'startTokenPos' => 423,
            'startFilePos' => 6334,
            'endTokenPos' => 423,
            'endFilePos' => 6354,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 100,
        'endLine' => 100,
        'startColumn' => 5,
        'endColumn' => 54,
      ),
      'CREDIT_NOTE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CREDIT_NOTE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'credit_note.updated\'',
          'attributes' => 
          array (
            'startLine' => 101,
            'endLine' => 101,
            'startTokenPos' => 432,
            'startFilePos' => 6390,
            'endTokenPos' => 432,
            'endFilePos' => 6410,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 101,
        'endLine' => 101,
        'startColumn' => 5,
        'endColumn' => 54,
      ),
      'CREDIT_NOTE_VOIDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CREDIT_NOTE_VOIDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'credit_note.voided\'',
          'attributes' => 
          array (
            'startLine' => 102,
            'endLine' => 102,
            'startTokenPos' => 441,
            'startFilePos' => 6445,
            'endTokenPos' => 441,
            'endFilePos' => 6464,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 102,
        'endLine' => 102,
        'startColumn' => 5,
        'endColumn' => 52,
      ),
      'CUSTOMER_CASH_BALANCE_TRANSACTION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_CASH_BALANCE_TRANSACTION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer_cash_balance_transaction.created\'',
          'attributes' => 
          array (
            'startLine' => 103,
            'endLine' => 103,
            'startTokenPos' => 450,
            'startFilePos' => 6522,
            'endTokenPos' => 450,
            'endFilePos' => 6564,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 103,
        'endLine' => 103,
        'startColumn' => 5,
        'endColumn' => 98,
      ),
      'CUSTOMER_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.created\'',
          'attributes' => 
          array (
            'startLine' => 104,
            'endLine' => 104,
            'startTokenPos' => 459,
            'startFilePos' => 6597,
            'endTokenPos' => 459,
            'endFilePos' => 6614,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 104,
        'endLine' => 104,
        'startColumn' => 5,
        'endColumn' => 48,
      ),
      'CUSTOMER_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.deleted\'',
          'attributes' => 
          array (
            'startLine' => 105,
            'endLine' => 105,
            'startTokenPos' => 468,
            'startFilePos' => 6647,
            'endTokenPos' => 468,
            'endFilePos' => 6664,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 105,
        'endLine' => 105,
        'startColumn' => 5,
        'endColumn' => 48,
      ),
      'CUSTOMER_DISCOUNT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_DISCOUNT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.discount.created\'',
          'attributes' => 
          array (
            'startLine' => 106,
            'endLine' => 106,
            'startTokenPos' => 477,
            'startFilePos' => 6706,
            'endTokenPos' => 477,
            'endFilePos' => 6732,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 106,
        'endLine' => 106,
        'startColumn' => 5,
        'endColumn' => 66,
      ),
      'CUSTOMER_DISCOUNT_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_DISCOUNT_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.discount.deleted\'',
          'attributes' => 
          array (
            'startLine' => 107,
            'endLine' => 107,
            'startTokenPos' => 486,
            'startFilePos' => 6774,
            'endTokenPos' => 486,
            'endFilePos' => 6800,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 107,
        'endLine' => 107,
        'startColumn' => 5,
        'endColumn' => 66,
      ),
      'CUSTOMER_DISCOUNT_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_DISCOUNT_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.discount.updated\'',
          'attributes' => 
          array (
            'startLine' => 108,
            'endLine' => 108,
            'startTokenPos' => 495,
            'startFilePos' => 6842,
            'endTokenPos' => 495,
            'endFilePos' => 6868,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 108,
        'endLine' => 108,
        'startColumn' => 5,
        'endColumn' => 66,
      ),
      'CUSTOMER_SOURCE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_SOURCE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.source.created\'',
          'attributes' => 
          array (
            'startLine' => 109,
            'endLine' => 109,
            'startTokenPos' => 504,
            'startFilePos' => 6908,
            'endTokenPos' => 504,
            'endFilePos' => 6932,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 109,
        'endLine' => 109,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'CUSTOMER_SOURCE_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_SOURCE_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.source.deleted\'',
          'attributes' => 
          array (
            'startLine' => 110,
            'endLine' => 110,
            'startTokenPos' => 513,
            'startFilePos' => 6972,
            'endTokenPos' => 513,
            'endFilePos' => 6996,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 110,
        'endLine' => 110,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'CUSTOMER_SOURCE_EXPIRING' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_SOURCE_EXPIRING',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.source.expiring\'',
          'attributes' => 
          array (
            'startLine' => 111,
            'endLine' => 111,
            'startTokenPos' => 522,
            'startFilePos' => 7037,
            'endTokenPos' => 522,
            'endFilePos' => 7062,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 111,
        'endLine' => 111,
        'startColumn' => 5,
        'endColumn' => 64,
      ),
      'CUSTOMER_SOURCE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_SOURCE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.source.updated\'',
          'attributes' => 
          array (
            'startLine' => 112,
            'endLine' => 112,
            'startTokenPos' => 531,
            'startFilePos' => 7102,
            'endTokenPos' => 531,
            'endFilePos' => 7126,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 112,
        'endLine' => 112,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'CUSTOMER_SUBSCRIPTION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_SUBSCRIPTION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.created\'',
          'attributes' => 
          array (
            'startLine' => 113,
            'endLine' => 113,
            'startTokenPos' => 540,
            'startFilePos' => 7172,
            'endTokenPos' => 540,
            'endFilePos' => 7202,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 113,
        'endLine' => 113,
        'startColumn' => 5,
        'endColumn' => 74,
      ),
      'CUSTOMER_SUBSCRIPTION_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_SUBSCRIPTION_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.deleted\'',
          'attributes' => 
          array (
            'startLine' => 114,
            'endLine' => 114,
            'startTokenPos' => 549,
            'startFilePos' => 7248,
            'endTokenPos' => 549,
            'endFilePos' => 7278,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 114,
        'endLine' => 114,
        'startColumn' => 5,
        'endColumn' => 74,
      ),
      'CUSTOMER_SUBSCRIPTION_PAUSED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_SUBSCRIPTION_PAUSED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.paused\'',
          'attributes' => 
          array (
            'startLine' => 115,
            'endLine' => 115,
            'startTokenPos' => 558,
            'startFilePos' => 7323,
            'endTokenPos' => 558,
            'endFilePos' => 7352,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 115,
        'endLine' => 115,
        'startColumn' => 5,
        'endColumn' => 72,
      ),
      'CUSTOMER_SUBSCRIPTION_PENDING_UPDATE_APPLIED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_SUBSCRIPTION_PENDING_UPDATE_APPLIED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.pending_update_applied\'',
          'attributes' => 
          array (
            'startLine' => 116,
            'endLine' => 116,
            'startTokenPos' => 567,
            'startFilePos' => 7413,
            'endTokenPos' => 567,
            'endFilePos' => 7458,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 116,
        'endLine' => 116,
        'startColumn' => 5,
        'endColumn' => 104,
      ),
      'CUSTOMER_SUBSCRIPTION_PENDING_UPDATE_EXPIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_SUBSCRIPTION_PENDING_UPDATE_EXPIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.pending_update_expired\'',
          'attributes' => 
          array (
            'startLine' => 117,
            'endLine' => 117,
            'startTokenPos' => 576,
            'startFilePos' => 7519,
            'endTokenPos' => 576,
            'endFilePos' => 7564,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 117,
        'endLine' => 117,
        'startColumn' => 5,
        'endColumn' => 104,
      ),
      'CUSTOMER_SUBSCRIPTION_RESUMED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_SUBSCRIPTION_RESUMED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.resumed\'',
          'attributes' => 
          array (
            'startLine' => 118,
            'endLine' => 118,
            'startTokenPos' => 585,
            'startFilePos' => 7610,
            'endTokenPos' => 585,
            'endFilePos' => 7640,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 118,
        'endLine' => 118,
        'startColumn' => 5,
        'endColumn' => 74,
      ),
      'CUSTOMER_SUBSCRIPTION_TRIAL_WILL_END' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_SUBSCRIPTION_TRIAL_WILL_END',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.trial_will_end\'',
          'attributes' => 
          array (
            'startLine' => 119,
            'endLine' => 119,
            'startTokenPos' => 594,
            'startFilePos' => 7693,
            'endTokenPos' => 594,
            'endFilePos' => 7730,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 119,
        'endLine' => 119,
        'startColumn' => 5,
        'endColumn' => 88,
      ),
      'CUSTOMER_SUBSCRIPTION_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_SUBSCRIPTION_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.updated\'',
          'attributes' => 
          array (
            'startLine' => 120,
            'endLine' => 120,
            'startTokenPos' => 603,
            'startFilePos' => 7776,
            'endTokenPos' => 603,
            'endFilePos' => 7806,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 120,
        'endLine' => 120,
        'startColumn' => 5,
        'endColumn' => 74,
      ),
      'CUSTOMER_TAX_ID_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_TAX_ID_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.tax_id.created\'',
          'attributes' => 
          array (
            'startLine' => 121,
            'endLine' => 121,
            'startTokenPos' => 612,
            'startFilePos' => 7846,
            'endTokenPos' => 612,
            'endFilePos' => 7870,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 121,
        'endLine' => 121,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'CUSTOMER_TAX_ID_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_TAX_ID_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.tax_id.deleted\'',
          'attributes' => 
          array (
            'startLine' => 122,
            'endLine' => 122,
            'startTokenPos' => 621,
            'startFilePos' => 7910,
            'endTokenPos' => 621,
            'endFilePos' => 7934,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 122,
        'endLine' => 122,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'CUSTOMER_TAX_ID_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_TAX_ID_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.tax_id.updated\'',
          'attributes' => 
          array (
            'startLine' => 123,
            'endLine' => 123,
            'startTokenPos' => 630,
            'startFilePos' => 7974,
            'endTokenPos' => 630,
            'endFilePos' => 7998,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 123,
        'endLine' => 123,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'CUSTOMER_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'CUSTOMER_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.updated\'',
          'attributes' => 
          array (
            'startLine' => 124,
            'endLine' => 124,
            'startTokenPos' => 639,
            'startFilePos' => 8031,
            'endTokenPos' => 639,
            'endFilePos' => 8048,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 124,
        'endLine' => 124,
        'startColumn' => 5,
        'endColumn' => 48,
      ),
      'ENTITLEMENTS_ACTIVE_ENTITLEMENT_SUMMARY_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ENTITLEMENTS_ACTIVE_ENTITLEMENT_SUMMARY_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'entitlements.active_entitlement_summary.updated\'',
          'attributes' => 
          array (
            'startLine' => 125,
            'endLine' => 125,
            'startTokenPos' => 648,
            'startFilePos' => 8112,
            'endTokenPos' => 648,
            'endFilePos' => 8160,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 125,
        'endLine' => 125,
        'startColumn' => 5,
        'endColumn' => 110,
      ),
      'FILE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'FILE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'file.created\'',
          'attributes' => 
          array (
            'startLine' => 126,
            'endLine' => 126,
            'startTokenPos' => 657,
            'startFilePos' => 8189,
            'endTokenPos' => 657,
            'endFilePos' => 8202,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 126,
        'endLine' => 126,
        'startColumn' => 5,
        'endColumn' => 40,
      ),
      'FINANCIAL_CONNECTIONS_ACCOUNT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'FINANCIAL_CONNECTIONS_ACCOUNT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'financial_connections.account.created\'',
          'attributes' => 
          array (
            'startLine' => 127,
            'endLine' => 127,
            'startTokenPos' => 666,
            'startFilePos' => 8256,
            'endTokenPos' => 666,
            'endFilePos' => 8294,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 127,
        'endLine' => 127,
        'startColumn' => 5,
        'endColumn' => 90,
      ),
      'FINANCIAL_CONNECTIONS_ACCOUNT_DEACTIVATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'FINANCIAL_CONNECTIONS_ACCOUNT_DEACTIVATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'financial_connections.account.deactivated\'',
          'attributes' => 
          array (
            'startLine' => 128,
            'endLine' => 128,
            'startTokenPos' => 675,
            'startFilePos' => 8352,
            'endTokenPos' => 675,
            'endFilePos' => 8394,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 128,
        'endLine' => 128,
        'startColumn' => 5,
        'endColumn' => 98,
      ),
      'FINANCIAL_CONNECTIONS_ACCOUNT_DISCONNECTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'FINANCIAL_CONNECTIONS_ACCOUNT_DISCONNECTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'financial_connections.account.disconnected\'',
          'attributes' => 
          array (
            'startLine' => 129,
            'endLine' => 129,
            'startTokenPos' => 684,
            'startFilePos' => 8453,
            'endTokenPos' => 684,
            'endFilePos' => 8496,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 129,
        'endLine' => 129,
        'startColumn' => 5,
        'endColumn' => 100,
      ),
      'FINANCIAL_CONNECTIONS_ACCOUNT_REACTIVATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'FINANCIAL_CONNECTIONS_ACCOUNT_REACTIVATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'financial_connections.account.reactivated\'',
          'attributes' => 
          array (
            'startLine' => 130,
            'endLine' => 130,
            'startTokenPos' => 693,
            'startFilePos' => 8554,
            'endTokenPos' => 693,
            'endFilePos' => 8596,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 130,
        'endLine' => 130,
        'startColumn' => 5,
        'endColumn' => 98,
      ),
      'FINANCIAL_CONNECTIONS_ACCOUNT_REFRESHED_BALANCE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'FINANCIAL_CONNECTIONS_ACCOUNT_REFRESHED_BALANCE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'financial_connections.account.refreshed_balance\'',
          'attributes' => 
          array (
            'startLine' => 131,
            'endLine' => 131,
            'startTokenPos' => 702,
            'startFilePos' => 8660,
            'endTokenPos' => 702,
            'endFilePos' => 8708,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 131,
        'endLine' => 131,
        'startColumn' => 5,
        'endColumn' => 110,
      ),
      'FINANCIAL_CONNECTIONS_ACCOUNT_REFRESHED_OWNERSHIP' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'FINANCIAL_CONNECTIONS_ACCOUNT_REFRESHED_OWNERSHIP',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'financial_connections.account.refreshed_ownership\'',
          'attributes' => 
          array (
            'startLine' => 132,
            'endLine' => 132,
            'startTokenPos' => 711,
            'startFilePos' => 8774,
            'endTokenPos' => 711,
            'endFilePos' => 8824,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 132,
        'endLine' => 132,
        'startColumn' => 5,
        'endColumn' => 114,
      ),
      'FINANCIAL_CONNECTIONS_ACCOUNT_REFRESHED_TRANSACTIONS' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'FINANCIAL_CONNECTIONS_ACCOUNT_REFRESHED_TRANSACTIONS',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'financial_connections.account.refreshed_transactions\'',
          'attributes' => 
          array (
            'startLine' => 133,
            'endLine' => 133,
            'startTokenPos' => 720,
            'startFilePos' => 8893,
            'endTokenPos' => 720,
            'endFilePos' => 8946,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 133,
        'endLine' => 133,
        'startColumn' => 5,
        'endColumn' => 120,
      ),
      'IDENTITY_VERIFICATION_SESSION_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'IDENTITY_VERIFICATION_SESSION_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'identity.verification_session.canceled\'',
          'attributes' => 
          array (
            'startLine' => 134,
            'endLine' => 134,
            'startTokenPos' => 729,
            'startFilePos' => 9001,
            'endTokenPos' => 729,
            'endFilePos' => 9040,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 134,
        'endLine' => 134,
        'startColumn' => 5,
        'endColumn' => 92,
      ),
      'IDENTITY_VERIFICATION_SESSION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'IDENTITY_VERIFICATION_SESSION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'identity.verification_session.created\'',
          'attributes' => 
          array (
            'startLine' => 135,
            'endLine' => 135,
            'startTokenPos' => 738,
            'startFilePos' => 9094,
            'endTokenPos' => 738,
            'endFilePos' => 9132,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 135,
        'endLine' => 135,
        'startColumn' => 5,
        'endColumn' => 90,
      ),
      'IDENTITY_VERIFICATION_SESSION_PROCESSING' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'IDENTITY_VERIFICATION_SESSION_PROCESSING',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'identity.verification_session.processing\'',
          'attributes' => 
          array (
            'startLine' => 136,
            'endLine' => 136,
            'startTokenPos' => 747,
            'startFilePos' => 9189,
            'endTokenPos' => 747,
            'endFilePos' => 9230,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 136,
        'endLine' => 136,
        'startColumn' => 5,
        'endColumn' => 96,
      ),
      'IDENTITY_VERIFICATION_SESSION_REDACTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'IDENTITY_VERIFICATION_SESSION_REDACTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'identity.verification_session.redacted\'',
          'attributes' => 
          array (
            'startLine' => 137,
            'endLine' => 137,
            'startTokenPos' => 756,
            'startFilePos' => 9285,
            'endTokenPos' => 756,
            'endFilePos' => 9324,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 137,
        'endLine' => 137,
        'startColumn' => 5,
        'endColumn' => 92,
      ),
      'IDENTITY_VERIFICATION_SESSION_REQUIRES_INPUT' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'IDENTITY_VERIFICATION_SESSION_REQUIRES_INPUT',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'identity.verification_session.requires_input\'',
          'attributes' => 
          array (
            'startLine' => 138,
            'endLine' => 138,
            'startTokenPos' => 765,
            'startFilePos' => 9385,
            'endTokenPos' => 765,
            'endFilePos' => 9430,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 138,
        'endLine' => 138,
        'startColumn' => 5,
        'endColumn' => 104,
      ),
      'IDENTITY_VERIFICATION_SESSION_VERIFIED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'IDENTITY_VERIFICATION_SESSION_VERIFIED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'identity.verification_session.verified\'',
          'attributes' => 
          array (
            'startLine' => 139,
            'endLine' => 139,
            'startTokenPos' => 774,
            'startFilePos' => 9485,
            'endTokenPos' => 774,
            'endFilePos' => 9524,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 139,
        'endLine' => 139,
        'startColumn' => 5,
        'endColumn' => 92,
      ),
      'INVOICEITEM_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICEITEM_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoiceitem.created\'',
          'attributes' => 
          array (
            'startLine' => 140,
            'endLine' => 140,
            'startTokenPos' => 783,
            'startFilePos' => 9560,
            'endTokenPos' => 783,
            'endFilePos' => 9580,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 140,
        'endLine' => 140,
        'startColumn' => 5,
        'endColumn' => 54,
      ),
      'INVOICEITEM_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICEITEM_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoiceitem.deleted\'',
          'attributes' => 
          array (
            'startLine' => 141,
            'endLine' => 141,
            'startTokenPos' => 792,
            'startFilePos' => 9616,
            'endTokenPos' => 792,
            'endFilePos' => 9636,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 141,
        'endLine' => 141,
        'startColumn' => 5,
        'endColumn' => 54,
      ),
      'INVOICE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.created\'',
          'attributes' => 
          array (
            'startLine' => 142,
            'endLine' => 142,
            'startTokenPos' => 801,
            'startFilePos' => 9668,
            'endTokenPos' => 801,
            'endFilePos' => 9684,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 142,
        'endLine' => 142,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'INVOICE_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICE_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.deleted\'',
          'attributes' => 
          array (
            'startLine' => 143,
            'endLine' => 143,
            'startTokenPos' => 810,
            'startFilePos' => 9716,
            'endTokenPos' => 810,
            'endFilePos' => 9732,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 143,
        'endLine' => 143,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'INVOICE_FINALIZATION_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICE_FINALIZATION_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.finalization_failed\'',
          'attributes' => 
          array (
            'startLine' => 144,
            'endLine' => 144,
            'startTokenPos' => 819,
            'startFilePos' => 9776,
            'endTokenPos' => 819,
            'endFilePos' => 9804,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 144,
        'endLine' => 144,
        'startColumn' => 5,
        'endColumn' => 70,
      ),
      'INVOICE_FINALIZED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICE_FINALIZED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.finalized\'',
          'attributes' => 
          array (
            'startLine' => 145,
            'endLine' => 145,
            'startTokenPos' => 828,
            'startFilePos' => 9838,
            'endTokenPos' => 828,
            'endFilePos' => 9856,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 145,
        'endLine' => 145,
        'startColumn' => 5,
        'endColumn' => 50,
      ),
      'INVOICE_MARKED_UNCOLLECTIBLE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICE_MARKED_UNCOLLECTIBLE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.marked_uncollectible\'',
          'attributes' => 
          array (
            'startLine' => 146,
            'endLine' => 146,
            'startTokenPos' => 837,
            'startFilePos' => 9901,
            'endTokenPos' => 837,
            'endFilePos' => 9930,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 146,
        'endLine' => 146,
        'startColumn' => 5,
        'endColumn' => 72,
      ),
      'INVOICE_OVERDUE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICE_OVERDUE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.overdue\'',
          'attributes' => 
          array (
            'startLine' => 147,
            'endLine' => 147,
            'startTokenPos' => 846,
            'startFilePos' => 9962,
            'endTokenPos' => 846,
            'endFilePos' => 9978,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 147,
        'endLine' => 147,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'INVOICE_PAID' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICE_PAID',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.paid\'',
          'attributes' => 
          array (
            'startLine' => 148,
            'endLine' => 148,
            'startTokenPos' => 855,
            'startFilePos' => 10007,
            'endTokenPos' => 855,
            'endFilePos' => 10020,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 148,
        'endLine' => 148,
        'startColumn' => 5,
        'endColumn' => 40,
      ),
      'INVOICE_PAYMENT_ACTION_REQUIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICE_PAYMENT_ACTION_REQUIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.payment_action_required\'',
          'attributes' => 
          array (
            'startLine' => 149,
            'endLine' => 149,
            'startTokenPos' => 864,
            'startFilePos' => 10068,
            'endTokenPos' => 864,
            'endFilePos' => 10100,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 149,
        'endLine' => 149,
        'startColumn' => 5,
        'endColumn' => 78,
      ),
      'INVOICE_PAYMENT_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICE_PAYMENT_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.payment_failed\'',
          'attributes' => 
          array (
            'startLine' => 150,
            'endLine' => 150,
            'startTokenPos' => 873,
            'startFilePos' => 10139,
            'endTokenPos' => 873,
            'endFilePos' => 10162,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 150,
        'endLine' => 150,
        'startColumn' => 5,
        'endColumn' => 60,
      ),
      'INVOICE_PAYMENT_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICE_PAYMENT_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.payment_succeeded\'',
          'attributes' => 
          array (
            'startLine' => 151,
            'endLine' => 151,
            'startTokenPos' => 882,
            'startFilePos' => 10204,
            'endTokenPos' => 882,
            'endFilePos' => 10230,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 151,
        'endLine' => 151,
        'startColumn' => 5,
        'endColumn' => 66,
      ),
      'INVOICE_SENT' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICE_SENT',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.sent\'',
          'attributes' => 
          array (
            'startLine' => 152,
            'endLine' => 152,
            'startTokenPos' => 891,
            'startFilePos' => 10259,
            'endTokenPos' => 891,
            'endFilePos' => 10272,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 152,
        'endLine' => 152,
        'startColumn' => 5,
        'endColumn' => 40,
      ),
      'INVOICE_UPCOMING' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICE_UPCOMING',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.upcoming\'',
          'attributes' => 
          array (
            'startLine' => 153,
            'endLine' => 153,
            'startTokenPos' => 900,
            'startFilePos' => 10305,
            'endTokenPos' => 900,
            'endFilePos' => 10322,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 153,
        'endLine' => 153,
        'startColumn' => 5,
        'endColumn' => 48,
      ),
      'INVOICE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.updated\'',
          'attributes' => 
          array (
            'startLine' => 154,
            'endLine' => 154,
            'startTokenPos' => 909,
            'startFilePos' => 10354,
            'endTokenPos' => 909,
            'endFilePos' => 10370,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 154,
        'endLine' => 154,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'INVOICE_VOIDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICE_VOIDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.voided\'',
          'attributes' => 
          array (
            'startLine' => 155,
            'endLine' => 155,
            'startTokenPos' => 918,
            'startFilePos' => 10401,
            'endTokenPos' => 918,
            'endFilePos' => 10416,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 155,
        'endLine' => 155,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'INVOICE_WILL_BE_DUE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'INVOICE_WILL_BE_DUE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.will_be_due\'',
          'attributes' => 
          array (
            'startLine' => 156,
            'endLine' => 156,
            'startTokenPos' => 927,
            'startFilePos' => 10452,
            'endTokenPos' => 927,
            'endFilePos' => 10472,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 156,
        'endLine' => 156,
        'startColumn' => 5,
        'endColumn' => 54,
      ),
      'ISSUING_AUTHORIZATION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_AUTHORIZATION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_authorization.created\'',
          'attributes' => 
          array (
            'startLine' => 157,
            'endLine' => 157,
            'startTokenPos' => 936,
            'startFilePos' => 10518,
            'endTokenPos' => 936,
            'endFilePos' => 10548,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 157,
        'endLine' => 157,
        'startColumn' => 5,
        'endColumn' => 74,
      ),
      'ISSUING_AUTHORIZATION_REQUEST' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_AUTHORIZATION_REQUEST',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_authorization.request\'',
          'attributes' => 
          array (
            'startLine' => 158,
            'endLine' => 158,
            'startTokenPos' => 945,
            'startFilePos' => 10594,
            'endTokenPos' => 945,
            'endFilePos' => 10624,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 158,
        'endLine' => 158,
        'startColumn' => 5,
        'endColumn' => 74,
      ),
      'ISSUING_AUTHORIZATION_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_AUTHORIZATION_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_authorization.updated\'',
          'attributes' => 
          array (
            'startLine' => 159,
            'endLine' => 159,
            'startTokenPos' => 954,
            'startFilePos' => 10670,
            'endTokenPos' => 954,
            'endFilePos' => 10700,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 159,
        'endLine' => 159,
        'startColumn' => 5,
        'endColumn' => 74,
      ),
      'ISSUING_CARDHOLDER_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_CARDHOLDER_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_cardholder.created\'',
          'attributes' => 
          array (
            'startLine' => 160,
            'endLine' => 160,
            'startTokenPos' => 963,
            'startFilePos' => 10743,
            'endTokenPos' => 963,
            'endFilePos' => 10770,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 160,
        'endLine' => 160,
        'startColumn' => 5,
        'endColumn' => 68,
      ),
      'ISSUING_CARDHOLDER_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_CARDHOLDER_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_cardholder.updated\'',
          'attributes' => 
          array (
            'startLine' => 161,
            'endLine' => 161,
            'startTokenPos' => 972,
            'startFilePos' => 10813,
            'endTokenPos' => 972,
            'endFilePos' => 10840,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 161,
        'endLine' => 161,
        'startColumn' => 5,
        'endColumn' => 68,
      ),
      'ISSUING_CARD_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_CARD_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_card.created\'',
          'attributes' => 
          array (
            'startLine' => 162,
            'endLine' => 162,
            'startTokenPos' => 981,
            'startFilePos' => 10877,
            'endTokenPos' => 981,
            'endFilePos' => 10898,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 162,
        'endLine' => 162,
        'startColumn' => 5,
        'endColumn' => 56,
      ),
      'ISSUING_CARD_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_CARD_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_card.updated\'',
          'attributes' => 
          array (
            'startLine' => 163,
            'endLine' => 163,
            'startTokenPos' => 990,
            'startFilePos' => 10935,
            'endTokenPos' => 990,
            'endFilePos' => 10956,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 163,
        'endLine' => 163,
        'startColumn' => 5,
        'endColumn' => 56,
      ),
      'ISSUING_DISPUTE_CLOSED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_DISPUTE_CLOSED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_dispute.closed\'',
          'attributes' => 
          array (
            'startLine' => 164,
            'endLine' => 164,
            'startTokenPos' => 999,
            'startFilePos' => 10995,
            'endTokenPos' => 999,
            'endFilePos' => 11018,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 164,
        'endLine' => 164,
        'startColumn' => 5,
        'endColumn' => 60,
      ),
      'ISSUING_DISPUTE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_DISPUTE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_dispute.created\'',
          'attributes' => 
          array (
            'startLine' => 165,
            'endLine' => 165,
            'startTokenPos' => 1008,
            'startFilePos' => 11058,
            'endTokenPos' => 1008,
            'endFilePos' => 11082,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 165,
        'endLine' => 165,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'ISSUING_DISPUTE_FUNDS_REINSTATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_DISPUTE_FUNDS_REINSTATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_dispute.funds_reinstated\'',
          'attributes' => 
          array (
            'startLine' => 166,
            'endLine' => 166,
            'startTokenPos' => 1017,
            'startFilePos' => 11131,
            'endTokenPos' => 1017,
            'endFilePos' => 11164,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 166,
        'endLine' => 166,
        'startColumn' => 5,
        'endColumn' => 80,
      ),
      'ISSUING_DISPUTE_FUNDS_RESCINDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_DISPUTE_FUNDS_RESCINDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_dispute.funds_rescinded\'',
          'attributes' => 
          array (
            'startLine' => 167,
            'endLine' => 167,
            'startTokenPos' => 1026,
            'startFilePos' => 11212,
            'endTokenPos' => 1026,
            'endFilePos' => 11244,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 167,
        'endLine' => 167,
        'startColumn' => 5,
        'endColumn' => 78,
      ),
      'ISSUING_DISPUTE_SUBMITTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_DISPUTE_SUBMITTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_dispute.submitted\'',
          'attributes' => 
          array (
            'startLine' => 168,
            'endLine' => 168,
            'startTokenPos' => 1035,
            'startFilePos' => 11286,
            'endTokenPos' => 1035,
            'endFilePos' => 11312,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 168,
        'endLine' => 168,
        'startColumn' => 5,
        'endColumn' => 66,
      ),
      'ISSUING_DISPUTE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_DISPUTE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_dispute.updated\'',
          'attributes' => 
          array (
            'startLine' => 169,
            'endLine' => 169,
            'startTokenPos' => 1044,
            'startFilePos' => 11352,
            'endTokenPos' => 1044,
            'endFilePos' => 11376,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 169,
        'endLine' => 169,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'ISSUING_PERSONALIZATION_DESIGN_ACTIVATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_PERSONALIZATION_DESIGN_ACTIVATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_personalization_design.activated\'',
          'attributes' => 
          array (
            'startLine' => 170,
            'endLine' => 170,
            'startTokenPos' => 1053,
            'startFilePos' => 11433,
            'endTokenPos' => 1053,
            'endFilePos' => 11474,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 170,
        'endLine' => 170,
        'startColumn' => 5,
        'endColumn' => 96,
      ),
      'ISSUING_PERSONALIZATION_DESIGN_DEACTIVATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_PERSONALIZATION_DESIGN_DEACTIVATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_personalization_design.deactivated\'',
          'attributes' => 
          array (
            'startLine' => 171,
            'endLine' => 171,
            'startTokenPos' => 1062,
            'startFilePos' => 11533,
            'endTokenPos' => 1062,
            'endFilePos' => 11576,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 171,
        'endLine' => 171,
        'startColumn' => 5,
        'endColumn' => 100,
      ),
      'ISSUING_PERSONALIZATION_DESIGN_REJECTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_PERSONALIZATION_DESIGN_REJECTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_personalization_design.rejected\'',
          'attributes' => 
          array (
            'startLine' => 172,
            'endLine' => 172,
            'startTokenPos' => 1071,
            'startFilePos' => 11632,
            'endTokenPos' => 1071,
            'endFilePos' => 11672,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 172,
        'endLine' => 172,
        'startColumn' => 5,
        'endColumn' => 94,
      ),
      'ISSUING_PERSONALIZATION_DESIGN_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_PERSONALIZATION_DESIGN_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_personalization_design.updated\'',
          'attributes' => 
          array (
            'startLine' => 173,
            'endLine' => 173,
            'startTokenPos' => 1080,
            'startFilePos' => 11727,
            'endTokenPos' => 1080,
            'endFilePos' => 11766,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 173,
        'endLine' => 173,
        'startColumn' => 5,
        'endColumn' => 92,
      ),
      'ISSUING_TOKEN_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_TOKEN_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_token.created\'',
          'attributes' => 
          array (
            'startLine' => 174,
            'endLine' => 174,
            'startTokenPos' => 1089,
            'startFilePos' => 11804,
            'endTokenPos' => 1089,
            'endFilePos' => 11826,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 174,
        'endLine' => 174,
        'startColumn' => 5,
        'endColumn' => 58,
      ),
      'ISSUING_TOKEN_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_TOKEN_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_token.updated\'',
          'attributes' => 
          array (
            'startLine' => 175,
            'endLine' => 175,
            'startTokenPos' => 1098,
            'startFilePos' => 11864,
            'endTokenPos' => 1098,
            'endFilePos' => 11886,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 175,
        'endLine' => 175,
        'startColumn' => 5,
        'endColumn' => 58,
      ),
      'ISSUING_TRANSACTION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_TRANSACTION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_transaction.created\'',
          'attributes' => 
          array (
            'startLine' => 176,
            'endLine' => 176,
            'startTokenPos' => 1107,
            'startFilePos' => 11930,
            'endTokenPos' => 1107,
            'endFilePos' => 11958,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 176,
        'endLine' => 176,
        'startColumn' => 5,
        'endColumn' => 70,
      ),
      'ISSUING_TRANSACTION_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'ISSUING_TRANSACTION_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_transaction.updated\'',
          'attributes' => 
          array (
            'startLine' => 177,
            'endLine' => 177,
            'startTokenPos' => 1116,
            'startFilePos' => 12002,
            'endTokenPos' => 1116,
            'endFilePos' => 12030,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 177,
        'endLine' => 177,
        'startColumn' => 5,
        'endColumn' => 70,
      ),
      'MANDATE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'MANDATE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'mandate.updated\'',
          'attributes' => 
          array (
            'startLine' => 178,
            'endLine' => 178,
            'startTokenPos' => 1125,
            'startFilePos' => 12062,
            'endTokenPos' => 1125,
            'endFilePos' => 12078,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 178,
        'endLine' => 178,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'PAYMENT_INTENT_AMOUNT_CAPTURABLE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYMENT_INTENT_AMOUNT_CAPTURABLE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.amount_capturable_updated\'',
          'attributes' => 
          array (
            'startLine' => 179,
            'endLine' => 179,
            'startTokenPos' => 1134,
            'startFilePos' => 12135,
            'endTokenPos' => 1134,
            'endFilePos' => 12176,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 179,
        'endLine' => 179,
        'startColumn' => 5,
        'endColumn' => 96,
      ),
      'PAYMENT_INTENT_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYMENT_INTENT_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.canceled\'',
          'attributes' => 
          array (
            'startLine' => 180,
            'endLine' => 180,
            'startTokenPos' => 1143,
            'startFilePos' => 12216,
            'endTokenPos' => 1143,
            'endFilePos' => 12240,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 180,
        'endLine' => 180,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'PAYMENT_INTENT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYMENT_INTENT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.created\'',
          'attributes' => 
          array (
            'startLine' => 181,
            'endLine' => 181,
            'startTokenPos' => 1152,
            'startFilePos' => 12279,
            'endTokenPos' => 1152,
            'endFilePos' => 12302,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 181,
        'endLine' => 181,
        'startColumn' => 5,
        'endColumn' => 60,
      ),
      'PAYMENT_INTENT_PARTIALLY_FUNDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYMENT_INTENT_PARTIALLY_FUNDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.partially_funded\'',
          'attributes' => 
          array (
            'startLine' => 182,
            'endLine' => 182,
            'startTokenPos' => 1161,
            'startFilePos' => 12350,
            'endTokenPos' => 1161,
            'endFilePos' => 12382,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 182,
        'endLine' => 182,
        'startColumn' => 5,
        'endColumn' => 78,
      ),
      'PAYMENT_INTENT_PAYMENT_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYMENT_INTENT_PAYMENT_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.payment_failed\'',
          'attributes' => 
          array (
            'startLine' => 183,
            'endLine' => 183,
            'startTokenPos' => 1170,
            'startFilePos' => 12428,
            'endTokenPos' => 1170,
            'endFilePos' => 12458,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 183,
        'endLine' => 183,
        'startColumn' => 5,
        'endColumn' => 74,
      ),
      'PAYMENT_INTENT_PROCESSING' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYMENT_INTENT_PROCESSING',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.processing\'',
          'attributes' => 
          array (
            'startLine' => 184,
            'endLine' => 184,
            'startTokenPos' => 1179,
            'startFilePos' => 12500,
            'endTokenPos' => 1179,
            'endFilePos' => 12526,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 184,
        'endLine' => 184,
        'startColumn' => 5,
        'endColumn' => 66,
      ),
      'PAYMENT_INTENT_REQUIRES_ACTION' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYMENT_INTENT_REQUIRES_ACTION',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.requires_action\'',
          'attributes' => 
          array (
            'startLine' => 185,
            'endLine' => 185,
            'startTokenPos' => 1188,
            'startFilePos' => 12573,
            'endTokenPos' => 1188,
            'endFilePos' => 12604,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 185,
        'endLine' => 185,
        'startColumn' => 5,
        'endColumn' => 76,
      ),
      'PAYMENT_INTENT_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYMENT_INTENT_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.succeeded\'',
          'attributes' => 
          array (
            'startLine' => 186,
            'endLine' => 186,
            'startTokenPos' => 1197,
            'startFilePos' => 12645,
            'endTokenPos' => 1197,
            'endFilePos' => 12670,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 186,
        'endLine' => 186,
        'startColumn' => 5,
        'endColumn' => 64,
      ),
      'PAYMENT_LINK_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYMENT_LINK_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_link.created\'',
          'attributes' => 
          array (
            'startLine' => 187,
            'endLine' => 187,
            'startTokenPos' => 1206,
            'startFilePos' => 12707,
            'endTokenPos' => 1206,
            'endFilePos' => 12728,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 187,
        'endLine' => 187,
        'startColumn' => 5,
        'endColumn' => 56,
      ),
      'PAYMENT_LINK_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYMENT_LINK_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_link.updated\'',
          'attributes' => 
          array (
            'startLine' => 188,
            'endLine' => 188,
            'startTokenPos' => 1215,
            'startFilePos' => 12765,
            'endTokenPos' => 1215,
            'endFilePos' => 12786,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 188,
        'endLine' => 188,
        'startColumn' => 5,
        'endColumn' => 56,
      ),
      'PAYMENT_METHOD_ATTACHED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYMENT_METHOD_ATTACHED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_method.attached\'',
          'attributes' => 
          array (
            'startLine' => 189,
            'endLine' => 189,
            'startTokenPos' => 1224,
            'startFilePos' => 12826,
            'endTokenPos' => 1224,
            'endFilePos' => 12850,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 189,
        'endLine' => 189,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'PAYMENT_METHOD_AUTOMATICALLY_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYMENT_METHOD_AUTOMATICALLY_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_method.automatically_updated\'',
          'attributes' => 
          array (
            'startLine' => 190,
            'endLine' => 190,
            'startTokenPos' => 1233,
            'startFilePos' => 12903,
            'endTokenPos' => 1233,
            'endFilePos' => 12940,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 190,
        'endLine' => 190,
        'startColumn' => 5,
        'endColumn' => 88,
      ),
      'PAYMENT_METHOD_DETACHED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYMENT_METHOD_DETACHED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_method.detached\'',
          'attributes' => 
          array (
            'startLine' => 191,
            'endLine' => 191,
            'startTokenPos' => 1242,
            'startFilePos' => 12980,
            'endTokenPos' => 1242,
            'endFilePos' => 13004,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 191,
        'endLine' => 191,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'PAYMENT_METHOD_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYMENT_METHOD_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_method.updated\'',
          'attributes' => 
          array (
            'startLine' => 192,
            'endLine' => 192,
            'startTokenPos' => 1251,
            'startFilePos' => 13043,
            'endTokenPos' => 1251,
            'endFilePos' => 13066,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 192,
        'endLine' => 192,
        'startColumn' => 5,
        'endColumn' => 60,
      ),
      'PAYOUT_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYOUT_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payout.canceled\'',
          'attributes' => 
          array (
            'startLine' => 193,
            'endLine' => 193,
            'startTokenPos' => 1260,
            'startFilePos' => 13098,
            'endTokenPos' => 1260,
            'endFilePos' => 13114,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 193,
        'endLine' => 193,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'PAYOUT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYOUT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payout.created\'',
          'attributes' => 
          array (
            'startLine' => 194,
            'endLine' => 194,
            'startTokenPos' => 1269,
            'startFilePos' => 13145,
            'endTokenPos' => 1269,
            'endFilePos' => 13160,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 194,
        'endLine' => 194,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'PAYOUT_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYOUT_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payout.failed\'',
          'attributes' => 
          array (
            'startLine' => 195,
            'endLine' => 195,
            'startTokenPos' => 1278,
            'startFilePos' => 13190,
            'endTokenPos' => 1278,
            'endFilePos' => 13204,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 195,
        'endLine' => 195,
        'startColumn' => 5,
        'endColumn' => 42,
      ),
      'PAYOUT_PAID' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYOUT_PAID',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payout.paid\'',
          'attributes' => 
          array (
            'startLine' => 196,
            'endLine' => 196,
            'startTokenPos' => 1287,
            'startFilePos' => 13232,
            'endTokenPos' => 1287,
            'endFilePos' => 13244,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 196,
        'endLine' => 196,
        'startColumn' => 5,
        'endColumn' => 38,
      ),
      'PAYOUT_RECONCILIATION_COMPLETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYOUT_RECONCILIATION_COMPLETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payout.reconciliation_completed\'',
          'attributes' => 
          array (
            'startLine' => 197,
            'endLine' => 197,
            'startTokenPos' => 1296,
            'startFilePos' => 13292,
            'endTokenPos' => 1296,
            'endFilePos' => 13324,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 197,
        'endLine' => 197,
        'startColumn' => 5,
        'endColumn' => 78,
      ),
      'PAYOUT_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PAYOUT_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payout.updated\'',
          'attributes' => 
          array (
            'startLine' => 198,
            'endLine' => 198,
            'startTokenPos' => 1305,
            'startFilePos' => 13355,
            'endTokenPos' => 1305,
            'endFilePos' => 13370,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 198,
        'endLine' => 198,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'PERSON_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PERSON_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'person.created\'',
          'attributes' => 
          array (
            'startLine' => 199,
            'endLine' => 199,
            'startTokenPos' => 1314,
            'startFilePos' => 13401,
            'endTokenPos' => 1314,
            'endFilePos' => 13416,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 199,
        'endLine' => 199,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'PERSON_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PERSON_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'person.deleted\'',
          'attributes' => 
          array (
            'startLine' => 200,
            'endLine' => 200,
            'startTokenPos' => 1323,
            'startFilePos' => 13447,
            'endTokenPos' => 1323,
            'endFilePos' => 13462,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 200,
        'endLine' => 200,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'PERSON_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PERSON_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'person.updated\'',
          'attributes' => 
          array (
            'startLine' => 201,
            'endLine' => 201,
            'startTokenPos' => 1332,
            'startFilePos' => 13493,
            'endTokenPos' => 1332,
            'endFilePos' => 13508,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 201,
        'endLine' => 201,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'PLAN_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PLAN_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'plan.created\'',
          'attributes' => 
          array (
            'startLine' => 202,
            'endLine' => 202,
            'startTokenPos' => 1341,
            'startFilePos' => 13537,
            'endTokenPos' => 1341,
            'endFilePos' => 13550,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 202,
        'endLine' => 202,
        'startColumn' => 5,
        'endColumn' => 40,
      ),
      'PLAN_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PLAN_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'plan.deleted\'',
          'attributes' => 
          array (
            'startLine' => 203,
            'endLine' => 203,
            'startTokenPos' => 1350,
            'startFilePos' => 13579,
            'endTokenPos' => 1350,
            'endFilePos' => 13592,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 203,
        'endLine' => 203,
        'startColumn' => 5,
        'endColumn' => 40,
      ),
      'PLAN_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PLAN_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'plan.updated\'',
          'attributes' => 
          array (
            'startLine' => 204,
            'endLine' => 204,
            'startTokenPos' => 1359,
            'startFilePos' => 13621,
            'endTokenPos' => 1359,
            'endFilePos' => 13634,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 204,
        'endLine' => 204,
        'startColumn' => 5,
        'endColumn' => 40,
      ),
      'PRICE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PRICE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'price.created\'',
          'attributes' => 
          array (
            'startLine' => 205,
            'endLine' => 205,
            'startTokenPos' => 1368,
            'startFilePos' => 13664,
            'endTokenPos' => 1368,
            'endFilePos' => 13678,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 205,
        'endLine' => 205,
        'startColumn' => 5,
        'endColumn' => 42,
      ),
      'PRICE_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PRICE_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'price.deleted\'',
          'attributes' => 
          array (
            'startLine' => 206,
            'endLine' => 206,
            'startTokenPos' => 1377,
            'startFilePos' => 13708,
            'endTokenPos' => 1377,
            'endFilePos' => 13722,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 206,
        'endLine' => 206,
        'startColumn' => 5,
        'endColumn' => 42,
      ),
      'PRICE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PRICE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'price.updated\'',
          'attributes' => 
          array (
            'startLine' => 207,
            'endLine' => 207,
            'startTokenPos' => 1386,
            'startFilePos' => 13752,
            'endTokenPos' => 1386,
            'endFilePos' => 13766,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 207,
        'endLine' => 207,
        'startColumn' => 5,
        'endColumn' => 42,
      ),
      'PRODUCT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PRODUCT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'product.created\'',
          'attributes' => 
          array (
            'startLine' => 208,
            'endLine' => 208,
            'startTokenPos' => 1395,
            'startFilePos' => 13798,
            'endTokenPos' => 1395,
            'endFilePos' => 13814,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 208,
        'endLine' => 208,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'PRODUCT_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PRODUCT_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'product.deleted\'',
          'attributes' => 
          array (
            'startLine' => 209,
            'endLine' => 209,
            'startTokenPos' => 1404,
            'startFilePos' => 13846,
            'endTokenPos' => 1404,
            'endFilePos' => 13862,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 209,
        'endLine' => 209,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'PRODUCT_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PRODUCT_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'product.updated\'',
          'attributes' => 
          array (
            'startLine' => 210,
            'endLine' => 210,
            'startTokenPos' => 1413,
            'startFilePos' => 13894,
            'endTokenPos' => 1413,
            'endFilePos' => 13910,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 210,
        'endLine' => 210,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'PROMOTION_CODE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PROMOTION_CODE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'promotion_code.created\'',
          'attributes' => 
          array (
            'startLine' => 211,
            'endLine' => 211,
            'startTokenPos' => 1422,
            'startFilePos' => 13949,
            'endTokenPos' => 1422,
            'endFilePos' => 13972,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 211,
        'endLine' => 211,
        'startColumn' => 5,
        'endColumn' => 60,
      ),
      'PROMOTION_CODE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'PROMOTION_CODE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'promotion_code.updated\'',
          'attributes' => 
          array (
            'startLine' => 212,
            'endLine' => 212,
            'startTokenPos' => 1431,
            'startFilePos' => 14011,
            'endTokenPos' => 1431,
            'endFilePos' => 14034,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 212,
        'endLine' => 212,
        'startColumn' => 5,
        'endColumn' => 60,
      ),
      'QUOTE_ACCEPTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'QUOTE_ACCEPTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'quote.accepted\'',
          'attributes' => 
          array (
            'startLine' => 213,
            'endLine' => 213,
            'startTokenPos' => 1440,
            'startFilePos' => 14065,
            'endTokenPos' => 1440,
            'endFilePos' => 14080,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 213,
        'endLine' => 213,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'QUOTE_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'QUOTE_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'quote.canceled\'',
          'attributes' => 
          array (
            'startLine' => 214,
            'endLine' => 214,
            'startTokenPos' => 1449,
            'startFilePos' => 14111,
            'endTokenPos' => 1449,
            'endFilePos' => 14126,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 214,
        'endLine' => 214,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'QUOTE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'QUOTE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'quote.created\'',
          'attributes' => 
          array (
            'startLine' => 215,
            'endLine' => 215,
            'startTokenPos' => 1458,
            'startFilePos' => 14156,
            'endTokenPos' => 1458,
            'endFilePos' => 14170,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 215,
        'endLine' => 215,
        'startColumn' => 5,
        'endColumn' => 42,
      ),
      'QUOTE_FINALIZED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'QUOTE_FINALIZED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'quote.finalized\'',
          'attributes' => 
          array (
            'startLine' => 216,
            'endLine' => 216,
            'startTokenPos' => 1467,
            'startFilePos' => 14202,
            'endTokenPos' => 1467,
            'endFilePos' => 14218,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 216,
        'endLine' => 216,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'RADAR_EARLY_FRAUD_WARNING_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'RADAR_EARLY_FRAUD_WARNING_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'radar.early_fraud_warning.created\'',
          'attributes' => 
          array (
            'startLine' => 217,
            'endLine' => 217,
            'startTokenPos' => 1476,
            'startFilePos' => 14268,
            'endTokenPos' => 1476,
            'endFilePos' => 14302,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 217,
        'endLine' => 217,
        'startColumn' => 5,
        'endColumn' => 82,
      ),
      'RADAR_EARLY_FRAUD_WARNING_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'RADAR_EARLY_FRAUD_WARNING_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'radar.early_fraud_warning.updated\'',
          'attributes' => 
          array (
            'startLine' => 218,
            'endLine' => 218,
            'startTokenPos' => 1485,
            'startFilePos' => 14352,
            'endTokenPos' => 1485,
            'endFilePos' => 14386,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 218,
        'endLine' => 218,
        'startColumn' => 5,
        'endColumn' => 82,
      ),
      'REFUND_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'REFUND_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'refund.created\'',
          'attributes' => 
          array (
            'startLine' => 219,
            'endLine' => 219,
            'startTokenPos' => 1494,
            'startFilePos' => 14417,
            'endTokenPos' => 1494,
            'endFilePos' => 14432,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 219,
        'endLine' => 219,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'REFUND_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'REFUND_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'refund.updated\'',
          'attributes' => 
          array (
            'startLine' => 220,
            'endLine' => 220,
            'startTokenPos' => 1503,
            'startFilePos' => 14463,
            'endTokenPos' => 1503,
            'endFilePos' => 14478,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 220,
        'endLine' => 220,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'REPORTING_REPORT_RUN_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'REPORTING_REPORT_RUN_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'reporting.report_run.failed\'',
          'attributes' => 
          array (
            'startLine' => 221,
            'endLine' => 221,
            'startTokenPos' => 1512,
            'startFilePos' => 14522,
            'endTokenPos' => 1512,
            'endFilePos' => 14550,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 221,
        'endLine' => 221,
        'startColumn' => 5,
        'endColumn' => 70,
      ),
      'REPORTING_REPORT_RUN_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'REPORTING_REPORT_RUN_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'reporting.report_run.succeeded\'',
          'attributes' => 
          array (
            'startLine' => 222,
            'endLine' => 222,
            'startTokenPos' => 1521,
            'startFilePos' => 14597,
            'endTokenPos' => 1521,
            'endFilePos' => 14628,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 222,
        'endLine' => 222,
        'startColumn' => 5,
        'endColumn' => 76,
      ),
      'REPORTING_REPORT_TYPE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'REPORTING_REPORT_TYPE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'reporting.report_type.updated\'',
          'attributes' => 
          array (
            'startLine' => 223,
            'endLine' => 223,
            'startTokenPos' => 1530,
            'startFilePos' => 14674,
            'endTokenPos' => 1530,
            'endFilePos' => 14704,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 223,
        'endLine' => 223,
        'startColumn' => 5,
        'endColumn' => 74,
      ),
      'REVIEW_CLOSED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'REVIEW_CLOSED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'review.closed\'',
          'attributes' => 
          array (
            'startLine' => 224,
            'endLine' => 224,
            'startTokenPos' => 1539,
            'startFilePos' => 14734,
            'endTokenPos' => 1539,
            'endFilePos' => 14748,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 224,
        'endLine' => 224,
        'startColumn' => 5,
        'endColumn' => 42,
      ),
      'REVIEW_OPENED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'REVIEW_OPENED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'review.opened\'',
          'attributes' => 
          array (
            'startLine' => 225,
            'endLine' => 225,
            'startTokenPos' => 1548,
            'startFilePos' => 14778,
            'endTokenPos' => 1548,
            'endFilePos' => 14792,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 225,
        'endLine' => 225,
        'startColumn' => 5,
        'endColumn' => 42,
      ),
      'SETUP_INTENT_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SETUP_INTENT_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'setup_intent.canceled\'',
          'attributes' => 
          array (
            'startLine' => 226,
            'endLine' => 226,
            'startTokenPos' => 1557,
            'startFilePos' => 14830,
            'endTokenPos' => 1557,
            'endFilePos' => 14852,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 226,
        'endLine' => 226,
        'startColumn' => 5,
        'endColumn' => 58,
      ),
      'SETUP_INTENT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SETUP_INTENT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'setup_intent.created\'',
          'attributes' => 
          array (
            'startLine' => 227,
            'endLine' => 227,
            'startTokenPos' => 1566,
            'startFilePos' => 14889,
            'endTokenPos' => 1566,
            'endFilePos' => 14910,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 227,
        'endLine' => 227,
        'startColumn' => 5,
        'endColumn' => 56,
      ),
      'SETUP_INTENT_REQUIRES_ACTION' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SETUP_INTENT_REQUIRES_ACTION',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'setup_intent.requires_action\'',
          'attributes' => 
          array (
            'startLine' => 228,
            'endLine' => 228,
            'startTokenPos' => 1575,
            'startFilePos' => 14955,
            'endTokenPos' => 1575,
            'endFilePos' => 14984,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 228,
        'endLine' => 228,
        'startColumn' => 5,
        'endColumn' => 72,
      ),
      'SETUP_INTENT_SETUP_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SETUP_INTENT_SETUP_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'setup_intent.setup_failed\'',
          'attributes' => 
          array (
            'startLine' => 229,
            'endLine' => 229,
            'startTokenPos' => 1584,
            'startFilePos' => 15026,
            'endTokenPos' => 1584,
            'endFilePos' => 15052,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 229,
        'endLine' => 229,
        'startColumn' => 5,
        'endColumn' => 66,
      ),
      'SETUP_INTENT_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SETUP_INTENT_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'setup_intent.succeeded\'',
          'attributes' => 
          array (
            'startLine' => 230,
            'endLine' => 230,
            'startTokenPos' => 1593,
            'startFilePos' => 15091,
            'endTokenPos' => 1593,
            'endFilePos' => 15114,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 230,
        'endLine' => 230,
        'startColumn' => 5,
        'endColumn' => 60,
      ),
      'SIGMA_SCHEDULED_QUERY_RUN_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SIGMA_SCHEDULED_QUERY_RUN_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'sigma.scheduled_query_run.created\'',
          'attributes' => 
          array (
            'startLine' => 231,
            'endLine' => 231,
            'startTokenPos' => 1602,
            'startFilePos' => 15164,
            'endTokenPos' => 1602,
            'endFilePos' => 15198,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 231,
        'endLine' => 231,
        'startColumn' => 5,
        'endColumn' => 82,
      ),
      'SOURCE_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SOURCE_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'source.canceled\'',
          'attributes' => 
          array (
            'startLine' => 232,
            'endLine' => 232,
            'startTokenPos' => 1611,
            'startFilePos' => 15230,
            'endTokenPos' => 1611,
            'endFilePos' => 15246,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 232,
        'endLine' => 232,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'SOURCE_CHARGEABLE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SOURCE_CHARGEABLE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'source.chargeable\'',
          'attributes' => 
          array (
            'startLine' => 233,
            'endLine' => 233,
            'startTokenPos' => 1620,
            'startFilePos' => 15280,
            'endTokenPos' => 1620,
            'endFilePos' => 15298,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 233,
        'endLine' => 233,
        'startColumn' => 5,
        'endColumn' => 50,
      ),
      'SOURCE_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SOURCE_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'source.failed\'',
          'attributes' => 
          array (
            'startLine' => 234,
            'endLine' => 234,
            'startTokenPos' => 1629,
            'startFilePos' => 15328,
            'endTokenPos' => 1629,
            'endFilePos' => 15342,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 234,
        'endLine' => 234,
        'startColumn' => 5,
        'endColumn' => 42,
      ),
      'SOURCE_MANDATE_NOTIFICATION' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SOURCE_MANDATE_NOTIFICATION',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'source.mandate_notification\'',
          'attributes' => 
          array (
            'startLine' => 235,
            'endLine' => 235,
            'startTokenPos' => 1638,
            'startFilePos' => 15386,
            'endTokenPos' => 1638,
            'endFilePos' => 15414,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 235,
        'endLine' => 235,
        'startColumn' => 5,
        'endColumn' => 70,
      ),
      'SOURCE_REFUND_ATTRIBUTES_REQUIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SOURCE_REFUND_ATTRIBUTES_REQUIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'source.refund_attributes_required\'',
          'attributes' => 
          array (
            'startLine' => 236,
            'endLine' => 236,
            'startTokenPos' => 1647,
            'startFilePos' => 15464,
            'endTokenPos' => 1647,
            'endFilePos' => 15498,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 236,
        'endLine' => 236,
        'startColumn' => 5,
        'endColumn' => 82,
      ),
      'SOURCE_TRANSACTION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SOURCE_TRANSACTION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'source.transaction.created\'',
          'attributes' => 
          array (
            'startLine' => 237,
            'endLine' => 237,
            'startTokenPos' => 1656,
            'startFilePos' => 15541,
            'endTokenPos' => 1656,
            'endFilePos' => 15568,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 237,
        'endLine' => 237,
        'startColumn' => 5,
        'endColumn' => 68,
      ),
      'SOURCE_TRANSACTION_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SOURCE_TRANSACTION_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'source.transaction.updated\'',
          'attributes' => 
          array (
            'startLine' => 238,
            'endLine' => 238,
            'startTokenPos' => 1665,
            'startFilePos' => 15611,
            'endTokenPos' => 1665,
            'endFilePos' => 15638,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 238,
        'endLine' => 238,
        'startColumn' => 5,
        'endColumn' => 68,
      ),
      'SUBSCRIPTION_SCHEDULE_ABORTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SUBSCRIPTION_SCHEDULE_ABORTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_schedule.aborted\'',
          'attributes' => 
          array (
            'startLine' => 239,
            'endLine' => 239,
            'startTokenPos' => 1674,
            'startFilePos' => 15684,
            'endTokenPos' => 1674,
            'endFilePos' => 15714,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 239,
        'endLine' => 239,
        'startColumn' => 5,
        'endColumn' => 74,
      ),
      'SUBSCRIPTION_SCHEDULE_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SUBSCRIPTION_SCHEDULE_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_schedule.canceled\'',
          'attributes' => 
          array (
            'startLine' => 240,
            'endLine' => 240,
            'startTokenPos' => 1683,
            'startFilePos' => 15761,
            'endTokenPos' => 1683,
            'endFilePos' => 15792,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 240,
        'endLine' => 240,
        'startColumn' => 5,
        'endColumn' => 76,
      ),
      'SUBSCRIPTION_SCHEDULE_COMPLETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SUBSCRIPTION_SCHEDULE_COMPLETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_schedule.completed\'',
          'attributes' => 
          array (
            'startLine' => 241,
            'endLine' => 241,
            'startTokenPos' => 1692,
            'startFilePos' => 15840,
            'endTokenPos' => 1692,
            'endFilePos' => 15872,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 241,
        'endLine' => 241,
        'startColumn' => 5,
        'endColumn' => 78,
      ),
      'SUBSCRIPTION_SCHEDULE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SUBSCRIPTION_SCHEDULE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_schedule.created\'',
          'attributes' => 
          array (
            'startLine' => 242,
            'endLine' => 242,
            'startTokenPos' => 1701,
            'startFilePos' => 15918,
            'endTokenPos' => 1701,
            'endFilePos' => 15948,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 242,
        'endLine' => 242,
        'startColumn' => 5,
        'endColumn' => 74,
      ),
      'SUBSCRIPTION_SCHEDULE_EXPIRING' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SUBSCRIPTION_SCHEDULE_EXPIRING',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_schedule.expiring\'',
          'attributes' => 
          array (
            'startLine' => 243,
            'endLine' => 243,
            'startTokenPos' => 1710,
            'startFilePos' => 15995,
            'endTokenPos' => 1710,
            'endFilePos' => 16026,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 243,
        'endLine' => 243,
        'startColumn' => 5,
        'endColumn' => 76,
      ),
      'SUBSCRIPTION_SCHEDULE_RELEASED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SUBSCRIPTION_SCHEDULE_RELEASED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_schedule.released\'',
          'attributes' => 
          array (
            'startLine' => 244,
            'endLine' => 244,
            'startTokenPos' => 1719,
            'startFilePos' => 16073,
            'endTokenPos' => 1719,
            'endFilePos' => 16104,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 244,
        'endLine' => 244,
        'startColumn' => 5,
        'endColumn' => 76,
      ),
      'SUBSCRIPTION_SCHEDULE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'SUBSCRIPTION_SCHEDULE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_schedule.updated\'',
          'attributes' => 
          array (
            'startLine' => 245,
            'endLine' => 245,
            'startTokenPos' => 1728,
            'startFilePos' => 16150,
            'endTokenPos' => 1728,
            'endFilePos' => 16180,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 245,
        'endLine' => 245,
        'startColumn' => 5,
        'endColumn' => 74,
      ),
      'TAX_RATE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TAX_RATE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'tax_rate.created\'',
          'attributes' => 
          array (
            'startLine' => 246,
            'endLine' => 246,
            'startTokenPos' => 1737,
            'startFilePos' => 16213,
            'endTokenPos' => 1737,
            'endFilePos' => 16230,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 246,
        'endLine' => 246,
        'startColumn' => 5,
        'endColumn' => 48,
      ),
      'TAX_RATE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TAX_RATE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'tax_rate.updated\'',
          'attributes' => 
          array (
            'startLine' => 247,
            'endLine' => 247,
            'startTokenPos' => 1746,
            'startFilePos' => 16263,
            'endTokenPos' => 1746,
            'endFilePos' => 16280,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 247,
        'endLine' => 247,
        'startColumn' => 5,
        'endColumn' => 48,
      ),
      'TAX_SETTINGS_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TAX_SETTINGS_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'tax.settings.updated\'',
          'attributes' => 
          array (
            'startLine' => 248,
            'endLine' => 248,
            'startTokenPos' => 1755,
            'startFilePos' => 16317,
            'endTokenPos' => 1755,
            'endFilePos' => 16338,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 248,
        'endLine' => 248,
        'startColumn' => 5,
        'endColumn' => 56,
      ),
      'TERMINAL_READER_ACTION_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TERMINAL_READER_ACTION_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'terminal.reader.action_failed\'',
          'attributes' => 
          array (
            'startLine' => 249,
            'endLine' => 249,
            'startTokenPos' => 1764,
            'startFilePos' => 16384,
            'endTokenPos' => 1764,
            'endFilePos' => 16414,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 249,
        'endLine' => 249,
        'startColumn' => 5,
        'endColumn' => 74,
      ),
      'TERMINAL_READER_ACTION_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TERMINAL_READER_ACTION_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'terminal.reader.action_succeeded\'',
          'attributes' => 
          array (
            'startLine' => 250,
            'endLine' => 250,
            'startTokenPos' => 1773,
            'startFilePos' => 16463,
            'endTokenPos' => 1773,
            'endFilePos' => 16496,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 250,
        'endLine' => 250,
        'startColumn' => 5,
        'endColumn' => 80,
      ),
      'TEST_HELPERS_TEST_CLOCK_ADVANCING' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TEST_HELPERS_TEST_CLOCK_ADVANCING',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'test_helpers.test_clock.advancing\'',
          'attributes' => 
          array (
            'startLine' => 251,
            'endLine' => 251,
            'startTokenPos' => 1782,
            'startFilePos' => 16546,
            'endTokenPos' => 1782,
            'endFilePos' => 16580,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 251,
        'endLine' => 251,
        'startColumn' => 5,
        'endColumn' => 82,
      ),
      'TEST_HELPERS_TEST_CLOCK_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TEST_HELPERS_TEST_CLOCK_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'test_helpers.test_clock.created\'',
          'attributes' => 
          array (
            'startLine' => 252,
            'endLine' => 252,
            'startTokenPos' => 1791,
            'startFilePos' => 16628,
            'endTokenPos' => 1791,
            'endFilePos' => 16660,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 252,
        'endLine' => 252,
        'startColumn' => 5,
        'endColumn' => 78,
      ),
      'TEST_HELPERS_TEST_CLOCK_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TEST_HELPERS_TEST_CLOCK_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'test_helpers.test_clock.deleted\'',
          'attributes' => 
          array (
            'startLine' => 253,
            'endLine' => 253,
            'startTokenPos' => 1800,
            'startFilePos' => 16708,
            'endTokenPos' => 1800,
            'endFilePos' => 16740,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 253,
        'endLine' => 253,
        'startColumn' => 5,
        'endColumn' => 78,
      ),
      'TEST_HELPERS_TEST_CLOCK_INTERNAL_FAILURE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TEST_HELPERS_TEST_CLOCK_INTERNAL_FAILURE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'test_helpers.test_clock.internal_failure\'',
          'attributes' => 
          array (
            'startLine' => 254,
            'endLine' => 254,
            'startTokenPos' => 1809,
            'startFilePos' => 16797,
            'endTokenPos' => 1809,
            'endFilePos' => 16838,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 254,
        'endLine' => 254,
        'startColumn' => 5,
        'endColumn' => 96,
      ),
      'TEST_HELPERS_TEST_CLOCK_READY' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TEST_HELPERS_TEST_CLOCK_READY',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'test_helpers.test_clock.ready\'',
          'attributes' => 
          array (
            'startLine' => 255,
            'endLine' => 255,
            'startTokenPos' => 1818,
            'startFilePos' => 16884,
            'endTokenPos' => 1818,
            'endFilePos' => 16914,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 255,
        'endLine' => 255,
        'startColumn' => 5,
        'endColumn' => 74,
      ),
      'TOPUP_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TOPUP_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'topup.canceled\'',
          'attributes' => 
          array (
            'startLine' => 256,
            'endLine' => 256,
            'startTokenPos' => 1827,
            'startFilePos' => 16945,
            'endTokenPos' => 1827,
            'endFilePos' => 16960,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 256,
        'endLine' => 256,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'TOPUP_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TOPUP_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'topup.created\'',
          'attributes' => 
          array (
            'startLine' => 257,
            'endLine' => 257,
            'startTokenPos' => 1836,
            'startFilePos' => 16990,
            'endTokenPos' => 1836,
            'endFilePos' => 17004,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 257,
        'endLine' => 257,
        'startColumn' => 5,
        'endColumn' => 42,
      ),
      'TOPUP_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TOPUP_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'topup.failed\'',
          'attributes' => 
          array (
            'startLine' => 258,
            'endLine' => 258,
            'startTokenPos' => 1845,
            'startFilePos' => 17033,
            'endTokenPos' => 1845,
            'endFilePos' => 17046,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 258,
        'endLine' => 258,
        'startColumn' => 5,
        'endColumn' => 40,
      ),
      'TOPUP_REVERSED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TOPUP_REVERSED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'topup.reversed\'',
          'attributes' => 
          array (
            'startLine' => 259,
            'endLine' => 259,
            'startTokenPos' => 1854,
            'startFilePos' => 17077,
            'endTokenPos' => 1854,
            'endFilePos' => 17092,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 259,
        'endLine' => 259,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'TOPUP_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TOPUP_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'topup.succeeded\'',
          'attributes' => 
          array (
            'startLine' => 260,
            'endLine' => 260,
            'startTokenPos' => 1863,
            'startFilePos' => 17124,
            'endTokenPos' => 1863,
            'endFilePos' => 17140,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 260,
        'endLine' => 260,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'TRANSFER_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TRANSFER_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'transfer.created\'',
          'attributes' => 
          array (
            'startLine' => 261,
            'endLine' => 261,
            'startTokenPos' => 1872,
            'startFilePos' => 17173,
            'endTokenPos' => 1872,
            'endFilePos' => 17190,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 261,
        'endLine' => 261,
        'startColumn' => 5,
        'endColumn' => 48,
      ),
      'TRANSFER_REVERSED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TRANSFER_REVERSED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'transfer.reversed\'',
          'attributes' => 
          array (
            'startLine' => 262,
            'endLine' => 262,
            'startTokenPos' => 1881,
            'startFilePos' => 17224,
            'endTokenPos' => 1881,
            'endFilePos' => 17242,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 262,
        'endLine' => 262,
        'startColumn' => 5,
        'endColumn' => 50,
      ),
      'TRANSFER_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TRANSFER_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'transfer.updated\'',
          'attributes' => 
          array (
            'startLine' => 263,
            'endLine' => 263,
            'startTokenPos' => 1890,
            'startFilePos' => 17275,
            'endTokenPos' => 1890,
            'endFilePos' => 17292,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 263,
        'endLine' => 263,
        'startColumn' => 5,
        'endColumn' => 48,
      ),
      'TREASURY_CREDIT_REVERSAL_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_CREDIT_REVERSAL_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.credit_reversal.created\'',
          'attributes' => 
          array (
            'startLine' => 264,
            'endLine' => 264,
            'startTokenPos' => 1899,
            'startFilePos' => 17341,
            'endTokenPos' => 1899,
            'endFilePos' => 17374,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 264,
        'endLine' => 264,
        'startColumn' => 5,
        'endColumn' => 80,
      ),
      'TREASURY_CREDIT_REVERSAL_POSTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_CREDIT_REVERSAL_POSTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.credit_reversal.posted\'',
          'attributes' => 
          array (
            'startLine' => 265,
            'endLine' => 265,
            'startTokenPos' => 1908,
            'startFilePos' => 17422,
            'endTokenPos' => 1908,
            'endFilePos' => 17454,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 265,
        'endLine' => 265,
        'startColumn' => 5,
        'endColumn' => 78,
      ),
      'TREASURY_DEBIT_REVERSAL_COMPLETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_DEBIT_REVERSAL_COMPLETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.debit_reversal.completed\'',
          'attributes' => 
          array (
            'startLine' => 266,
            'endLine' => 266,
            'startTokenPos' => 1917,
            'startFilePos' => 17504,
            'endTokenPos' => 1917,
            'endFilePos' => 17538,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 266,
        'endLine' => 266,
        'startColumn' => 5,
        'endColumn' => 82,
      ),
      'TREASURY_DEBIT_REVERSAL_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_DEBIT_REVERSAL_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.debit_reversal.created\'',
          'attributes' => 
          array (
            'startLine' => 267,
            'endLine' => 267,
            'startTokenPos' => 1926,
            'startFilePos' => 17586,
            'endTokenPos' => 1926,
            'endFilePos' => 17618,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 267,
        'endLine' => 267,
        'startColumn' => 5,
        'endColumn' => 78,
      ),
      'TREASURY_DEBIT_REVERSAL_INITIAL_CREDIT_GRANTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_DEBIT_REVERSAL_INITIAL_CREDIT_GRANTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.debit_reversal.initial_credit_granted\'',
          'attributes' => 
          array (
            'startLine' => 268,
            'endLine' => 268,
            'startTokenPos' => 1935,
            'startFilePos' => 17681,
            'endTokenPos' => 1935,
            'endFilePos' => 17728,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 268,
        'endLine' => 268,
        'startColumn' => 5,
        'endColumn' => 108,
      ),
      'TREASURY_FINANCIAL_ACCOUNT_CLOSED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_FINANCIAL_ACCOUNT_CLOSED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.financial_account.closed\'',
          'attributes' => 
          array (
            'startLine' => 269,
            'endLine' => 269,
            'startTokenPos' => 1944,
            'startFilePos' => 17778,
            'endTokenPos' => 1944,
            'endFilePos' => 17812,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 269,
        'endLine' => 269,
        'startColumn' => 5,
        'endColumn' => 82,
      ),
      'TREASURY_FINANCIAL_ACCOUNT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_FINANCIAL_ACCOUNT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.financial_account.created\'',
          'attributes' => 
          array (
            'startLine' => 270,
            'endLine' => 270,
            'startTokenPos' => 1953,
            'startFilePos' => 17863,
            'endTokenPos' => 1953,
            'endFilePos' => 17898,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 270,
        'endLine' => 270,
        'startColumn' => 5,
        'endColumn' => 84,
      ),
      'TREASURY_FINANCIAL_ACCOUNT_FEATURES_STATUS_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_FINANCIAL_ACCOUNT_FEATURES_STATUS_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.financial_account.features_status_updated\'',
          'attributes' => 
          array (
            'startLine' => 271,
            'endLine' => 271,
            'startTokenPos' => 1962,
            'startFilePos' => 17965,
            'endTokenPos' => 1962,
            'endFilePos' => 18016,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 271,
        'endLine' => 271,
        'startColumn' => 5,
        'endColumn' => 116,
      ),
      'TREASURY_INBOUND_TRANSFER_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_INBOUND_TRANSFER_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.inbound_transfer.canceled\'',
          'attributes' => 
          array (
            'startLine' => 272,
            'endLine' => 272,
            'startTokenPos' => 1971,
            'startFilePos' => 18067,
            'endTokenPos' => 1971,
            'endFilePos' => 18102,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 272,
        'endLine' => 272,
        'startColumn' => 5,
        'endColumn' => 84,
      ),
      'TREASURY_INBOUND_TRANSFER_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_INBOUND_TRANSFER_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.inbound_transfer.created\'',
          'attributes' => 
          array (
            'startLine' => 273,
            'endLine' => 273,
            'startTokenPos' => 1980,
            'startFilePos' => 18152,
            'endTokenPos' => 1980,
            'endFilePos' => 18186,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 273,
        'endLine' => 273,
        'startColumn' => 5,
        'endColumn' => 82,
      ),
      'TREASURY_INBOUND_TRANSFER_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_INBOUND_TRANSFER_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.inbound_transfer.failed\'',
          'attributes' => 
          array (
            'startLine' => 274,
            'endLine' => 274,
            'startTokenPos' => 1989,
            'startFilePos' => 18235,
            'endTokenPos' => 1989,
            'endFilePos' => 18268,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 274,
        'endLine' => 274,
        'startColumn' => 5,
        'endColumn' => 80,
      ),
      'TREASURY_INBOUND_TRANSFER_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_INBOUND_TRANSFER_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.inbound_transfer.succeeded\'',
          'attributes' => 
          array (
            'startLine' => 275,
            'endLine' => 275,
            'startTokenPos' => 1998,
            'startFilePos' => 18320,
            'endTokenPos' => 1998,
            'endFilePos' => 18356,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 275,
        'endLine' => 275,
        'startColumn' => 5,
        'endColumn' => 86,
      ),
      'TREASURY_OUTBOUND_PAYMENT_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_OUTBOUND_PAYMENT_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_payment.canceled\'',
          'attributes' => 
          array (
            'startLine' => 276,
            'endLine' => 276,
            'startTokenPos' => 2007,
            'startFilePos' => 18407,
            'endTokenPos' => 2007,
            'endFilePos' => 18442,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 276,
        'endLine' => 276,
        'startColumn' => 5,
        'endColumn' => 84,
      ),
      'TREASURY_OUTBOUND_PAYMENT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_OUTBOUND_PAYMENT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_payment.created\'',
          'attributes' => 
          array (
            'startLine' => 277,
            'endLine' => 277,
            'startTokenPos' => 2016,
            'startFilePos' => 18492,
            'endTokenPos' => 2016,
            'endFilePos' => 18526,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 277,
        'endLine' => 277,
        'startColumn' => 5,
        'endColumn' => 82,
      ),
      'TREASURY_OUTBOUND_PAYMENT_EXPECTED_ARRIVAL_DATE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_OUTBOUND_PAYMENT_EXPECTED_ARRIVAL_DATE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_payment.expected_arrival_date_updated\'',
          'attributes' => 
          array (
            'startLine' => 278,
            'endLine' => 278,
            'startTokenPos' => 2025,
            'startFilePos' => 18598,
            'endTokenPos' => 2025,
            'endFilePos' => 18654,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 278,
        'endLine' => 278,
        'startColumn' => 5,
        'endColumn' => 126,
      ),
      'TREASURY_OUTBOUND_PAYMENT_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_OUTBOUND_PAYMENT_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_payment.failed\'',
          'attributes' => 
          array (
            'startLine' => 279,
            'endLine' => 279,
            'startTokenPos' => 2034,
            'startFilePos' => 18703,
            'endTokenPos' => 2034,
            'endFilePos' => 18736,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 279,
        'endLine' => 279,
        'startColumn' => 5,
        'endColumn' => 80,
      ),
      'TREASURY_OUTBOUND_PAYMENT_POSTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_OUTBOUND_PAYMENT_POSTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_payment.posted\'',
          'attributes' => 
          array (
            'startLine' => 280,
            'endLine' => 280,
            'startTokenPos' => 2043,
            'startFilePos' => 18785,
            'endTokenPos' => 2043,
            'endFilePos' => 18818,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 280,
        'endLine' => 280,
        'startColumn' => 5,
        'endColumn' => 80,
      ),
      'TREASURY_OUTBOUND_PAYMENT_RETURNED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_OUTBOUND_PAYMENT_RETURNED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_payment.returned\'',
          'attributes' => 
          array (
            'startLine' => 281,
            'endLine' => 281,
            'startTokenPos' => 2052,
            'startFilePos' => 18869,
            'endTokenPos' => 2052,
            'endFilePos' => 18904,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 281,
        'endLine' => 281,
        'startColumn' => 5,
        'endColumn' => 84,
      ),
      'TREASURY_OUTBOUND_PAYMENT_TRACKING_DETAILS_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_OUTBOUND_PAYMENT_TRACKING_DETAILS_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_payment.tracking_details_updated\'',
          'attributes' => 
          array (
            'startLine' => 282,
            'endLine' => 282,
            'startTokenPos' => 2061,
            'startFilePos' => 18971,
            'endTokenPos' => 2061,
            'endFilePos' => 19022,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 282,
        'endLine' => 282,
        'startColumn' => 5,
        'endColumn' => 116,
      ),
      'TREASURY_OUTBOUND_TRANSFER_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_OUTBOUND_TRANSFER_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_transfer.canceled\'',
          'attributes' => 
          array (
            'startLine' => 283,
            'endLine' => 283,
            'startTokenPos' => 2070,
            'startFilePos' => 19074,
            'endTokenPos' => 2070,
            'endFilePos' => 19110,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 283,
        'endLine' => 283,
        'startColumn' => 5,
        'endColumn' => 86,
      ),
      'TREASURY_OUTBOUND_TRANSFER_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_OUTBOUND_TRANSFER_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_transfer.created\'',
          'attributes' => 
          array (
            'startLine' => 284,
            'endLine' => 284,
            'startTokenPos' => 2079,
            'startFilePos' => 19161,
            'endTokenPos' => 2079,
            'endFilePos' => 19196,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 284,
        'endLine' => 284,
        'startColumn' => 5,
        'endColumn' => 84,
      ),
      'TREASURY_OUTBOUND_TRANSFER_EXPECTED_ARRIVAL_DATE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_OUTBOUND_TRANSFER_EXPECTED_ARRIVAL_DATE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_transfer.expected_arrival_date_updated\'',
          'attributes' => 
          array (
            'startLine' => 285,
            'endLine' => 285,
            'startTokenPos' => 2088,
            'startFilePos' => 19269,
            'endTokenPos' => 2088,
            'endFilePos' => 19326,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 285,
        'endLine' => 285,
        'startColumn' => 5,
        'endColumn' => 128,
      ),
      'TREASURY_OUTBOUND_TRANSFER_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_OUTBOUND_TRANSFER_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_transfer.failed\'',
          'attributes' => 
          array (
            'startLine' => 286,
            'endLine' => 286,
            'startTokenPos' => 2097,
            'startFilePos' => 19376,
            'endTokenPos' => 2097,
            'endFilePos' => 19410,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 286,
        'endLine' => 286,
        'startColumn' => 5,
        'endColumn' => 82,
      ),
      'TREASURY_OUTBOUND_TRANSFER_POSTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_OUTBOUND_TRANSFER_POSTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_transfer.posted\'',
          'attributes' => 
          array (
            'startLine' => 287,
            'endLine' => 287,
            'startTokenPos' => 2106,
            'startFilePos' => 19460,
            'endTokenPos' => 2106,
            'endFilePos' => 19494,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 287,
        'endLine' => 287,
        'startColumn' => 5,
        'endColumn' => 82,
      ),
      'TREASURY_OUTBOUND_TRANSFER_RETURNED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_OUTBOUND_TRANSFER_RETURNED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_transfer.returned\'',
          'attributes' => 
          array (
            'startLine' => 288,
            'endLine' => 288,
            'startTokenPos' => 2115,
            'startFilePos' => 19546,
            'endTokenPos' => 2115,
            'endFilePos' => 19582,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 288,
        'endLine' => 288,
        'startColumn' => 5,
        'endColumn' => 86,
      ),
      'TREASURY_OUTBOUND_TRANSFER_TRACKING_DETAILS_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_OUTBOUND_TRANSFER_TRACKING_DETAILS_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_transfer.tracking_details_updated\'',
          'attributes' => 
          array (
            'startLine' => 289,
            'endLine' => 289,
            'startTokenPos' => 2124,
            'startFilePos' => 19650,
            'endTokenPos' => 2124,
            'endFilePos' => 19702,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 289,
        'endLine' => 289,
        'startColumn' => 5,
        'endColumn' => 118,
      ),
      'TREASURY_RECEIVED_CREDIT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_RECEIVED_CREDIT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.received_credit.created\'',
          'attributes' => 
          array (
            'startLine' => 290,
            'endLine' => 290,
            'startTokenPos' => 2133,
            'startFilePos' => 19751,
            'endTokenPos' => 2133,
            'endFilePos' => 19784,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 290,
        'endLine' => 290,
        'startColumn' => 5,
        'endColumn' => 80,
      ),
      'TREASURY_RECEIVED_CREDIT_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_RECEIVED_CREDIT_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.received_credit.failed\'',
          'attributes' => 
          array (
            'startLine' => 291,
            'endLine' => 291,
            'startTokenPos' => 2142,
            'startFilePos' => 19832,
            'endTokenPos' => 2142,
            'endFilePos' => 19864,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 291,
        'endLine' => 291,
        'startColumn' => 5,
        'endColumn' => 78,
      ),
      'TREASURY_RECEIVED_CREDIT_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_RECEIVED_CREDIT_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.received_credit.succeeded\'',
          'attributes' => 
          array (
            'startLine' => 292,
            'endLine' => 292,
            'startTokenPos' => 2151,
            'startFilePos' => 19915,
            'endTokenPos' => 2151,
            'endFilePos' => 19950,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 292,
        'endLine' => 292,
        'startColumn' => 5,
        'endColumn' => 84,
      ),
      'TREASURY_RECEIVED_DEBIT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TREASURY_RECEIVED_DEBIT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.received_debit.created\'',
          'attributes' => 
          array (
            'startLine' => 293,
            'endLine' => 293,
            'startTokenPos' => 2160,
            'startFilePos' => 19998,
            'endTokenPos' => 2160,
            'endFilePos' => 20030,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 293,
        'endLine' => 293,
        'startColumn' => 5,
        'endColumn' => 78,
      ),
      'TYPE_ACCOUNT_APPLICATION_AUTHORIZED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ACCOUNT_APPLICATION_AUTHORIZED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'account.application.authorized\'',
          'attributes' => 
          array (
            'startLine' => 295,
            'endLine' => 295,
            'startTokenPos' => 2169,
            'startFilePos' => 20084,
            'endTokenPos' => 2169,
            'endFilePos' => 20115,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 295,
        'endLine' => 295,
        'startColumn' => 5,
        'endColumn' => 81,
      ),
      'TYPE_ACCOUNT_APPLICATION_DEAUTHORIZED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ACCOUNT_APPLICATION_DEAUTHORIZED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'account.application.deauthorized\'',
          'attributes' => 
          array (
            'startLine' => 296,
            'endLine' => 296,
            'startTokenPos' => 2178,
            'startFilePos' => 20169,
            'endTokenPos' => 2178,
            'endFilePos' => 20202,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 296,
        'endLine' => 296,
        'startColumn' => 5,
        'endColumn' => 85,
      ),
      'TYPE_ACCOUNT_EXTERNAL_ACCOUNT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ACCOUNT_EXTERNAL_ACCOUNT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'account.external_account.created\'',
          'attributes' => 
          array (
            'startLine' => 297,
            'endLine' => 297,
            'startTokenPos' => 2187,
            'startFilePos' => 20256,
            'endTokenPos' => 2187,
            'endFilePos' => 20289,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 297,
        'endLine' => 297,
        'startColumn' => 5,
        'endColumn' => 85,
      ),
      'TYPE_ACCOUNT_EXTERNAL_ACCOUNT_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ACCOUNT_EXTERNAL_ACCOUNT_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'account.external_account.deleted\'',
          'attributes' => 
          array (
            'startLine' => 298,
            'endLine' => 298,
            'startTokenPos' => 2196,
            'startFilePos' => 20343,
            'endTokenPos' => 2196,
            'endFilePos' => 20376,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 298,
        'endLine' => 298,
        'startColumn' => 5,
        'endColumn' => 85,
      ),
      'TYPE_ACCOUNT_EXTERNAL_ACCOUNT_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ACCOUNT_EXTERNAL_ACCOUNT_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'account.external_account.updated\'',
          'attributes' => 
          array (
            'startLine' => 299,
            'endLine' => 299,
            'startTokenPos' => 2205,
            'startFilePos' => 20430,
            'endTokenPos' => 2205,
            'endFilePos' => 20463,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 299,
        'endLine' => 299,
        'startColumn' => 5,
        'endColumn' => 85,
      ),
      'TYPE_ACCOUNT_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ACCOUNT_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'account.updated\'',
          'attributes' => 
          array (
            'startLine' => 300,
            'endLine' => 300,
            'startTokenPos' => 2214,
            'startFilePos' => 20500,
            'endTokenPos' => 2214,
            'endFilePos' => 20516,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 300,
        'endLine' => 300,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'TYPE_APPLICATION_FEE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_APPLICATION_FEE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'application_fee.created\'',
          'attributes' => 
          array (
            'startLine' => 301,
            'endLine' => 301,
            'startTokenPos' => 2223,
            'startFilePos' => 20561,
            'endTokenPos' => 2223,
            'endFilePos' => 20585,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 301,
        'endLine' => 301,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'TYPE_APPLICATION_FEE_REFUNDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_APPLICATION_FEE_REFUNDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'application_fee.refunded\'',
          'attributes' => 
          array (
            'startLine' => 302,
            'endLine' => 302,
            'startTokenPos' => 2232,
            'startFilePos' => 20631,
            'endTokenPos' => 2232,
            'endFilePos' => 20656,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 302,
        'endLine' => 302,
        'startColumn' => 5,
        'endColumn' => 69,
      ),
      'TYPE_APPLICATION_FEE_REFUND_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_APPLICATION_FEE_REFUND_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'application_fee.refund.updated\'',
          'attributes' => 
          array (
            'startLine' => 303,
            'endLine' => 303,
            'startTokenPos' => 2241,
            'startFilePos' => 20708,
            'endTokenPos' => 2241,
            'endFilePos' => 20739,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 303,
        'endLine' => 303,
        'startColumn' => 5,
        'endColumn' => 81,
      ),
      'TYPE_BALANCE_AVAILABLE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_BALANCE_AVAILABLE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'balance.available\'',
          'attributes' => 
          array (
            'startLine' => 304,
            'endLine' => 304,
            'startTokenPos' => 2250,
            'startFilePos' => 20778,
            'endTokenPos' => 2250,
            'endFilePos' => 20796,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 304,
        'endLine' => 304,
        'startColumn' => 5,
        'endColumn' => 55,
      ),
      'TYPE_BILLING_ALERT_TRIGGERED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_BILLING_ALERT_TRIGGERED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'billing.alert.triggered\'',
          'attributes' => 
          array (
            'startLine' => 305,
            'endLine' => 305,
            'startTokenPos' => 2259,
            'startFilePos' => 20841,
            'endTokenPos' => 2259,
            'endFilePos' => 20865,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 305,
        'endLine' => 305,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'TYPE_BILLING_PORTAL_CONFIGURATION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_BILLING_PORTAL_CONFIGURATION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'billing_portal.configuration.created\'',
          'attributes' => 
          array (
            'startLine' => 306,
            'endLine' => 306,
            'startTokenPos' => 2268,
            'startFilePos' => 20923,
            'endTokenPos' => 2268,
            'endFilePos' => 20960,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 306,
        'endLine' => 306,
        'startColumn' => 5,
        'endColumn' => 93,
      ),
      'TYPE_BILLING_PORTAL_CONFIGURATION_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_BILLING_PORTAL_CONFIGURATION_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'billing_portal.configuration.updated\'',
          'attributes' => 
          array (
            'startLine' => 307,
            'endLine' => 307,
            'startTokenPos' => 2277,
            'startFilePos' => 21018,
            'endTokenPos' => 2277,
            'endFilePos' => 21055,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 307,
        'endLine' => 307,
        'startColumn' => 5,
        'endColumn' => 93,
      ),
      'TYPE_BILLING_PORTAL_SESSION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_BILLING_PORTAL_SESSION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'billing_portal.session.created\'',
          'attributes' => 
          array (
            'startLine' => 308,
            'endLine' => 308,
            'startTokenPos' => 2286,
            'startFilePos' => 21107,
            'endTokenPos' => 2286,
            'endFilePos' => 21138,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 308,
        'endLine' => 308,
        'startColumn' => 5,
        'endColumn' => 81,
      ),
      'TYPE_CAPABILITY_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CAPABILITY_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'capability.updated\'',
          'attributes' => 
          array (
            'startLine' => 309,
            'endLine' => 309,
            'startTokenPos' => 2295,
            'startFilePos' => 21178,
            'endTokenPos' => 2295,
            'endFilePos' => 21197,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 309,
        'endLine' => 309,
        'startColumn' => 5,
        'endColumn' => 57,
      ),
      'TYPE_CASH_BALANCE_FUNDS_AVAILABLE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CASH_BALANCE_FUNDS_AVAILABLE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'cash_balance.funds_available\'',
          'attributes' => 
          array (
            'startLine' => 310,
            'endLine' => 310,
            'startTokenPos' => 2304,
            'startFilePos' => 21247,
            'endTokenPos' => 2304,
            'endFilePos' => 21276,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 310,
        'endLine' => 310,
        'startColumn' => 5,
        'endColumn' => 77,
      ),
      'TYPE_CHARGE_CAPTURED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHARGE_CAPTURED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.captured\'',
          'attributes' => 
          array (
            'startLine' => 311,
            'endLine' => 311,
            'startTokenPos' => 2313,
            'startFilePos' => 21313,
            'endTokenPos' => 2313,
            'endFilePos' => 21329,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 311,
        'endLine' => 311,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'TYPE_CHARGE_DISPUTE_CLOSED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHARGE_DISPUTE_CLOSED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.dispute.closed\'',
          'attributes' => 
          array (
            'startLine' => 312,
            'endLine' => 312,
            'startTokenPos' => 2322,
            'startFilePos' => 21372,
            'endTokenPos' => 2322,
            'endFilePos' => 21394,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 312,
        'endLine' => 312,
        'startColumn' => 5,
        'endColumn' => 63,
      ),
      'TYPE_CHARGE_DISPUTE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHARGE_DISPUTE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.dispute.created\'',
          'attributes' => 
          array (
            'startLine' => 313,
            'endLine' => 313,
            'startTokenPos' => 2331,
            'startFilePos' => 21438,
            'endTokenPos' => 2331,
            'endFilePos' => 21461,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 313,
        'endLine' => 313,
        'startColumn' => 5,
        'endColumn' => 65,
      ),
      'TYPE_CHARGE_DISPUTE_FUNDS_REINSTATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHARGE_DISPUTE_FUNDS_REINSTATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.dispute.funds_reinstated\'',
          'attributes' => 
          array (
            'startLine' => 314,
            'endLine' => 314,
            'startTokenPos' => 2340,
            'startFilePos' => 21514,
            'endTokenPos' => 2340,
            'endFilePos' => 21546,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 314,
        'endLine' => 314,
        'startColumn' => 5,
        'endColumn' => 83,
      ),
      'TYPE_CHARGE_DISPUTE_FUNDS_WITHDRAWN' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHARGE_DISPUTE_FUNDS_WITHDRAWN',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.dispute.funds_withdrawn\'',
          'attributes' => 
          array (
            'startLine' => 315,
            'endLine' => 315,
            'startTokenPos' => 2349,
            'startFilePos' => 21598,
            'endTokenPos' => 2349,
            'endFilePos' => 21629,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 315,
        'endLine' => 315,
        'startColumn' => 5,
        'endColumn' => 81,
      ),
      'TYPE_CHARGE_DISPUTE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHARGE_DISPUTE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.dispute.updated\'',
          'attributes' => 
          array (
            'startLine' => 316,
            'endLine' => 316,
            'startTokenPos' => 2358,
            'startFilePos' => 21673,
            'endTokenPos' => 2358,
            'endFilePos' => 21696,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 316,
        'endLine' => 316,
        'startColumn' => 5,
        'endColumn' => 65,
      ),
      'TYPE_CHARGE_EXPIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHARGE_EXPIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.expired\'',
          'attributes' => 
          array (
            'startLine' => 317,
            'endLine' => 317,
            'startTokenPos' => 2367,
            'startFilePos' => 21732,
            'endTokenPos' => 2367,
            'endFilePos' => 21747,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 317,
        'endLine' => 317,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_CHARGE_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHARGE_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.failed\'',
          'attributes' => 
          array (
            'startLine' => 318,
            'endLine' => 318,
            'startTokenPos' => 2376,
            'startFilePos' => 21782,
            'endTokenPos' => 2376,
            'endFilePos' => 21796,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 318,
        'endLine' => 318,
        'startColumn' => 5,
        'endColumn' => 47,
      ),
      'TYPE_CHARGE_PENDING' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHARGE_PENDING',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.pending\'',
          'attributes' => 
          array (
            'startLine' => 319,
            'endLine' => 319,
            'startTokenPos' => 2385,
            'startFilePos' => 21832,
            'endTokenPos' => 2385,
            'endFilePos' => 21847,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 319,
        'endLine' => 319,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_CHARGE_REFUNDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHARGE_REFUNDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.refunded\'',
          'attributes' => 
          array (
            'startLine' => 320,
            'endLine' => 320,
            'startTokenPos' => 2394,
            'startFilePos' => 21884,
            'endTokenPos' => 2394,
            'endFilePos' => 21900,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 320,
        'endLine' => 320,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'TYPE_CHARGE_REFUND_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHARGE_REFUND_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.refund.updated\'',
          'attributes' => 
          array (
            'startLine' => 321,
            'endLine' => 321,
            'startTokenPos' => 2403,
            'startFilePos' => 21943,
            'endTokenPos' => 2403,
            'endFilePos' => 21965,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 321,
        'endLine' => 321,
        'startColumn' => 5,
        'endColumn' => 63,
      ),
      'TYPE_CHARGE_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHARGE_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.succeeded\'',
          'attributes' => 
          array (
            'startLine' => 322,
            'endLine' => 322,
            'startTokenPos' => 2412,
            'startFilePos' => 22003,
            'endTokenPos' => 2412,
            'endFilePos' => 22020,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 322,
        'endLine' => 322,
        'startColumn' => 5,
        'endColumn' => 53,
      ),
      'TYPE_CHARGE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHARGE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge.updated\'',
          'attributes' => 
          array (
            'startLine' => 323,
            'endLine' => 323,
            'startTokenPos' => 2421,
            'startFilePos' => 22056,
            'endTokenPos' => 2421,
            'endFilePos' => 22071,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 323,
        'endLine' => 323,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_CHECKOUT_SESSION_ASYNC_PAYMENT_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHECKOUT_SESSION_ASYNC_PAYMENT_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'checkout.session.async_payment_failed\'',
          'attributes' => 
          array (
            'startLine' => 324,
            'endLine' => 324,
            'startTokenPos' => 2430,
            'startFilePos' => 22130,
            'endTokenPos' => 2430,
            'endFilePos' => 22168,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 324,
        'endLine' => 324,
        'startColumn' => 5,
        'endColumn' => 95,
      ),
      'TYPE_CHECKOUT_SESSION_ASYNC_PAYMENT_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHECKOUT_SESSION_ASYNC_PAYMENT_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'checkout.session.async_payment_succeeded\'',
          'attributes' => 
          array (
            'startLine' => 325,
            'endLine' => 325,
            'startTokenPos' => 2439,
            'startFilePos' => 22230,
            'endTokenPos' => 2439,
            'endFilePos' => 22271,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 325,
        'endLine' => 325,
        'startColumn' => 5,
        'endColumn' => 101,
      ),
      'TYPE_CHECKOUT_SESSION_COMPLETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHECKOUT_SESSION_COMPLETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'checkout.session.completed\'',
          'attributes' => 
          array (
            'startLine' => 326,
            'endLine' => 326,
            'startTokenPos' => 2448,
            'startFilePos' => 22319,
            'endTokenPos' => 2448,
            'endFilePos' => 22346,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 326,
        'endLine' => 326,
        'startColumn' => 5,
        'endColumn' => 73,
      ),
      'TYPE_CHECKOUT_SESSION_EXPIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CHECKOUT_SESSION_EXPIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'checkout.session.expired\'',
          'attributes' => 
          array (
            'startLine' => 327,
            'endLine' => 327,
            'startTokenPos' => 2457,
            'startFilePos' => 22392,
            'endTokenPos' => 2457,
            'endFilePos' => 22417,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 327,
        'endLine' => 327,
        'startColumn' => 5,
        'endColumn' => 69,
      ),
      'TYPE_CLIMATE_ORDER_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CLIMATE_ORDER_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'climate.order.canceled\'',
          'attributes' => 
          array (
            'startLine' => 328,
            'endLine' => 328,
            'startTokenPos' => 2466,
            'startFilePos' => 22461,
            'endTokenPos' => 2466,
            'endFilePos' => 22484,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 328,
        'endLine' => 328,
        'startColumn' => 5,
        'endColumn' => 65,
      ),
      'TYPE_CLIMATE_ORDER_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CLIMATE_ORDER_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'climate.order.created\'',
          'attributes' => 
          array (
            'startLine' => 329,
            'endLine' => 329,
            'startTokenPos' => 2475,
            'startFilePos' => 22527,
            'endTokenPos' => 2475,
            'endFilePos' => 22549,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 329,
        'endLine' => 329,
        'startColumn' => 5,
        'endColumn' => 63,
      ),
      'TYPE_CLIMATE_ORDER_DELAYED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CLIMATE_ORDER_DELAYED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'climate.order.delayed\'',
          'attributes' => 
          array (
            'startLine' => 330,
            'endLine' => 330,
            'startTokenPos' => 2484,
            'startFilePos' => 22592,
            'endTokenPos' => 2484,
            'endFilePos' => 22614,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 330,
        'endLine' => 330,
        'startColumn' => 5,
        'endColumn' => 63,
      ),
      'TYPE_CLIMATE_ORDER_DELIVERED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CLIMATE_ORDER_DELIVERED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'climate.order.delivered\'',
          'attributes' => 
          array (
            'startLine' => 331,
            'endLine' => 331,
            'startTokenPos' => 2493,
            'startFilePos' => 22659,
            'endTokenPos' => 2493,
            'endFilePos' => 22683,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 331,
        'endLine' => 331,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'TYPE_CLIMATE_ORDER_PRODUCT_SUBSTITUTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CLIMATE_ORDER_PRODUCT_SUBSTITUTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'climate.order.product_substituted\'',
          'attributes' => 
          array (
            'startLine' => 332,
            'endLine' => 332,
            'startTokenPos' => 2502,
            'startFilePos' => 22738,
            'endTokenPos' => 2502,
            'endFilePos' => 22772,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 332,
        'endLine' => 332,
        'startColumn' => 5,
        'endColumn' => 87,
      ),
      'TYPE_CLIMATE_PRODUCT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CLIMATE_PRODUCT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'climate.product.created\'',
          'attributes' => 
          array (
            'startLine' => 333,
            'endLine' => 333,
            'startTokenPos' => 2511,
            'startFilePos' => 22817,
            'endTokenPos' => 2511,
            'endFilePos' => 22841,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 333,
        'endLine' => 333,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'TYPE_CLIMATE_PRODUCT_PRICING_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CLIMATE_PRODUCT_PRICING_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'climate.product.pricing_updated\'',
          'attributes' => 
          array (
            'startLine' => 334,
            'endLine' => 334,
            'startTokenPos' => 2520,
            'startFilePos' => 22894,
            'endTokenPos' => 2520,
            'endFilePos' => 22926,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 334,
        'endLine' => 334,
        'startColumn' => 5,
        'endColumn' => 83,
      ),
      'TYPE_COUPON_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_COUPON_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'coupon.created\'',
          'attributes' => 
          array (
            'startLine' => 335,
            'endLine' => 335,
            'startTokenPos' => 2529,
            'startFilePos' => 22962,
            'endTokenPos' => 2529,
            'endFilePos' => 22977,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 335,
        'endLine' => 335,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_COUPON_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_COUPON_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'coupon.deleted\'',
          'attributes' => 
          array (
            'startLine' => 336,
            'endLine' => 336,
            'startTokenPos' => 2538,
            'startFilePos' => 23013,
            'endTokenPos' => 2538,
            'endFilePos' => 23028,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 336,
        'endLine' => 336,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_COUPON_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_COUPON_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'coupon.updated\'',
          'attributes' => 
          array (
            'startLine' => 337,
            'endLine' => 337,
            'startTokenPos' => 2547,
            'startFilePos' => 23064,
            'endTokenPos' => 2547,
            'endFilePos' => 23079,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 337,
        'endLine' => 337,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_CREDIT_NOTE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CREDIT_NOTE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'credit_note.created\'',
          'attributes' => 
          array (
            'startLine' => 338,
            'endLine' => 338,
            'startTokenPos' => 2556,
            'startFilePos' => 23120,
            'endTokenPos' => 2556,
            'endFilePos' => 23140,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 338,
        'endLine' => 338,
        'startColumn' => 5,
        'endColumn' => 59,
      ),
      'TYPE_CREDIT_NOTE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CREDIT_NOTE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'credit_note.updated\'',
          'attributes' => 
          array (
            'startLine' => 339,
            'endLine' => 339,
            'startTokenPos' => 2565,
            'startFilePos' => 23181,
            'endTokenPos' => 2565,
            'endFilePos' => 23201,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 339,
        'endLine' => 339,
        'startColumn' => 5,
        'endColumn' => 59,
      ),
      'TYPE_CREDIT_NOTE_VOIDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CREDIT_NOTE_VOIDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'credit_note.voided\'',
          'attributes' => 
          array (
            'startLine' => 340,
            'endLine' => 340,
            'startTokenPos' => 2574,
            'startFilePos' => 23241,
            'endTokenPos' => 2574,
            'endFilePos' => 23260,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 340,
        'endLine' => 340,
        'startColumn' => 5,
        'endColumn' => 57,
      ),
      'TYPE_CUSTOMER_CASH_BALANCE_TRANSACTION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_CASH_BALANCE_TRANSACTION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer_cash_balance_transaction.created\'',
          'attributes' => 
          array (
            'startLine' => 341,
            'endLine' => 341,
            'startTokenPos' => 2583,
            'startFilePos' => 23323,
            'endTokenPos' => 2583,
            'endFilePos' => 23365,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 341,
        'endLine' => 341,
        'startColumn' => 5,
        'endColumn' => 103,
      ),
      'TYPE_CUSTOMER_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.created\'',
          'attributes' => 
          array (
            'startLine' => 342,
            'endLine' => 342,
            'startTokenPos' => 2592,
            'startFilePos' => 23403,
            'endTokenPos' => 2592,
            'endFilePos' => 23420,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 342,
        'endLine' => 342,
        'startColumn' => 5,
        'endColumn' => 53,
      ),
      'TYPE_CUSTOMER_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.deleted\'',
          'attributes' => 
          array (
            'startLine' => 343,
            'endLine' => 343,
            'startTokenPos' => 2601,
            'startFilePos' => 23458,
            'endTokenPos' => 2601,
            'endFilePos' => 23475,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 343,
        'endLine' => 343,
        'startColumn' => 5,
        'endColumn' => 53,
      ),
      'TYPE_CUSTOMER_DISCOUNT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_DISCOUNT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.discount.created\'',
          'attributes' => 
          array (
            'startLine' => 344,
            'endLine' => 344,
            'startTokenPos' => 2610,
            'startFilePos' => 23522,
            'endTokenPos' => 2610,
            'endFilePos' => 23548,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 344,
        'endLine' => 344,
        'startColumn' => 5,
        'endColumn' => 71,
      ),
      'TYPE_CUSTOMER_DISCOUNT_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_DISCOUNT_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.discount.deleted\'',
          'attributes' => 
          array (
            'startLine' => 345,
            'endLine' => 345,
            'startTokenPos' => 2619,
            'startFilePos' => 23595,
            'endTokenPos' => 2619,
            'endFilePos' => 23621,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 345,
        'endLine' => 345,
        'startColumn' => 5,
        'endColumn' => 71,
      ),
      'TYPE_CUSTOMER_DISCOUNT_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_DISCOUNT_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.discount.updated\'',
          'attributes' => 
          array (
            'startLine' => 346,
            'endLine' => 346,
            'startTokenPos' => 2628,
            'startFilePos' => 23668,
            'endTokenPos' => 2628,
            'endFilePos' => 23694,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 346,
        'endLine' => 346,
        'startColumn' => 5,
        'endColumn' => 71,
      ),
      'TYPE_CUSTOMER_SOURCE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_SOURCE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.source.created\'',
          'attributes' => 
          array (
            'startLine' => 347,
            'endLine' => 347,
            'startTokenPos' => 2637,
            'startFilePos' => 23739,
            'endTokenPos' => 2637,
            'endFilePos' => 23763,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 347,
        'endLine' => 347,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'TYPE_CUSTOMER_SOURCE_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_SOURCE_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.source.deleted\'',
          'attributes' => 
          array (
            'startLine' => 348,
            'endLine' => 348,
            'startTokenPos' => 2646,
            'startFilePos' => 23808,
            'endTokenPos' => 2646,
            'endFilePos' => 23832,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 348,
        'endLine' => 348,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'TYPE_CUSTOMER_SOURCE_EXPIRING' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_SOURCE_EXPIRING',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.source.expiring\'',
          'attributes' => 
          array (
            'startLine' => 349,
            'endLine' => 349,
            'startTokenPos' => 2655,
            'startFilePos' => 23878,
            'endTokenPos' => 2655,
            'endFilePos' => 23903,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 349,
        'endLine' => 349,
        'startColumn' => 5,
        'endColumn' => 69,
      ),
      'TYPE_CUSTOMER_SOURCE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_SOURCE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.source.updated\'',
          'attributes' => 
          array (
            'startLine' => 350,
            'endLine' => 350,
            'startTokenPos' => 2664,
            'startFilePos' => 23948,
            'endTokenPos' => 2664,
            'endFilePos' => 23972,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 350,
        'endLine' => 350,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'TYPE_CUSTOMER_SUBSCRIPTION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_SUBSCRIPTION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.created\'',
          'attributes' => 
          array (
            'startLine' => 351,
            'endLine' => 351,
            'startTokenPos' => 2673,
            'startFilePos' => 24023,
            'endTokenPos' => 2673,
            'endFilePos' => 24053,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 351,
        'endLine' => 351,
        'startColumn' => 5,
        'endColumn' => 79,
      ),
      'TYPE_CUSTOMER_SUBSCRIPTION_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_SUBSCRIPTION_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.deleted\'',
          'attributes' => 
          array (
            'startLine' => 352,
            'endLine' => 352,
            'startTokenPos' => 2682,
            'startFilePos' => 24104,
            'endTokenPos' => 2682,
            'endFilePos' => 24134,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 352,
        'endLine' => 352,
        'startColumn' => 5,
        'endColumn' => 79,
      ),
      'TYPE_CUSTOMER_SUBSCRIPTION_PAUSED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_SUBSCRIPTION_PAUSED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.paused\'',
          'attributes' => 
          array (
            'startLine' => 353,
            'endLine' => 353,
            'startTokenPos' => 2691,
            'startFilePos' => 24184,
            'endTokenPos' => 2691,
            'endFilePos' => 24213,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 353,
        'endLine' => 353,
        'startColumn' => 5,
        'endColumn' => 77,
      ),
      'TYPE_CUSTOMER_SUBSCRIPTION_PENDING_UPDATE_APPLIED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_SUBSCRIPTION_PENDING_UPDATE_APPLIED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.pending_update_applied\'',
          'attributes' => 
          array (
            'startLine' => 354,
            'endLine' => 354,
            'startTokenPos' => 2700,
            'startFilePos' => 24279,
            'endTokenPos' => 2700,
            'endFilePos' => 24324,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 354,
        'endLine' => 354,
        'startColumn' => 5,
        'endColumn' => 109,
      ),
      'TYPE_CUSTOMER_SUBSCRIPTION_PENDING_UPDATE_EXPIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_SUBSCRIPTION_PENDING_UPDATE_EXPIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.pending_update_expired\'',
          'attributes' => 
          array (
            'startLine' => 355,
            'endLine' => 355,
            'startTokenPos' => 2709,
            'startFilePos' => 24390,
            'endTokenPos' => 2709,
            'endFilePos' => 24435,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 355,
        'endLine' => 355,
        'startColumn' => 5,
        'endColumn' => 109,
      ),
      'TYPE_CUSTOMER_SUBSCRIPTION_RESUMED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_SUBSCRIPTION_RESUMED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.resumed\'',
          'attributes' => 
          array (
            'startLine' => 356,
            'endLine' => 356,
            'startTokenPos' => 2718,
            'startFilePos' => 24486,
            'endTokenPos' => 2718,
            'endFilePos' => 24516,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 356,
        'endLine' => 356,
        'startColumn' => 5,
        'endColumn' => 79,
      ),
      'TYPE_CUSTOMER_SUBSCRIPTION_TRIAL_WILL_END' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_SUBSCRIPTION_TRIAL_WILL_END',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.trial_will_end\'',
          'attributes' => 
          array (
            'startLine' => 357,
            'endLine' => 357,
            'startTokenPos' => 2727,
            'startFilePos' => 24574,
            'endTokenPos' => 2727,
            'endFilePos' => 24611,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 357,
        'endLine' => 357,
        'startColumn' => 5,
        'endColumn' => 93,
      ),
      'TYPE_CUSTOMER_SUBSCRIPTION_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_SUBSCRIPTION_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.subscription.updated\'',
          'attributes' => 
          array (
            'startLine' => 358,
            'endLine' => 358,
            'startTokenPos' => 2736,
            'startFilePos' => 24662,
            'endTokenPos' => 2736,
            'endFilePos' => 24692,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 358,
        'endLine' => 358,
        'startColumn' => 5,
        'endColumn' => 79,
      ),
      'TYPE_CUSTOMER_TAX_ID_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_TAX_ID_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.tax_id.created\'',
          'attributes' => 
          array (
            'startLine' => 359,
            'endLine' => 359,
            'startTokenPos' => 2745,
            'startFilePos' => 24737,
            'endTokenPos' => 2745,
            'endFilePos' => 24761,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 359,
        'endLine' => 359,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'TYPE_CUSTOMER_TAX_ID_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_TAX_ID_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.tax_id.deleted\'',
          'attributes' => 
          array (
            'startLine' => 360,
            'endLine' => 360,
            'startTokenPos' => 2754,
            'startFilePos' => 24806,
            'endTokenPos' => 2754,
            'endFilePos' => 24830,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 360,
        'endLine' => 360,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'TYPE_CUSTOMER_TAX_ID_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_TAX_ID_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.tax_id.updated\'',
          'attributes' => 
          array (
            'startLine' => 361,
            'endLine' => 361,
            'startTokenPos' => 2763,
            'startFilePos' => 24875,
            'endTokenPos' => 2763,
            'endFilePos' => 24899,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 361,
        'endLine' => 361,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'TYPE_CUSTOMER_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_CUSTOMER_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'customer.updated\'',
          'attributes' => 
          array (
            'startLine' => 362,
            'endLine' => 362,
            'startTokenPos' => 2772,
            'startFilePos' => 24937,
            'endTokenPos' => 2772,
            'endFilePos' => 24954,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 362,
        'endLine' => 362,
        'startColumn' => 5,
        'endColumn' => 53,
      ),
      'TYPE_ENTITLEMENTS_ACTIVE_ENTITLEMENT_SUMMARY_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ENTITLEMENTS_ACTIVE_ENTITLEMENT_SUMMARY_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'entitlements.active_entitlement_summary.updated\'',
          'attributes' => 
          array (
            'startLine' => 363,
            'endLine' => 363,
            'startTokenPos' => 2781,
            'startFilePos' => 25023,
            'endTokenPos' => 2781,
            'endFilePos' => 25071,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 363,
        'endLine' => 363,
        'startColumn' => 5,
        'endColumn' => 115,
      ),
      'TYPE_FILE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_FILE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'file.created\'',
          'attributes' => 
          array (
            'startLine' => 364,
            'endLine' => 364,
            'startTokenPos' => 2790,
            'startFilePos' => 25105,
            'endTokenPos' => 2790,
            'endFilePos' => 25118,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 364,
        'endLine' => 364,
        'startColumn' => 5,
        'endColumn' => 45,
      ),
      'TYPE_FINANCIAL_CONNECTIONS_ACCOUNT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_FINANCIAL_CONNECTIONS_ACCOUNT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'financial_connections.account.created\'',
          'attributes' => 
          array (
            'startLine' => 365,
            'endLine' => 365,
            'startTokenPos' => 2799,
            'startFilePos' => 25177,
            'endTokenPos' => 2799,
            'endFilePos' => 25215,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 365,
        'endLine' => 365,
        'startColumn' => 5,
        'endColumn' => 95,
      ),
      'TYPE_FINANCIAL_CONNECTIONS_ACCOUNT_DEACTIVATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_FINANCIAL_CONNECTIONS_ACCOUNT_DEACTIVATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'financial_connections.account.deactivated\'',
          'attributes' => 
          array (
            'startLine' => 366,
            'endLine' => 366,
            'startTokenPos' => 2808,
            'startFilePos' => 25278,
            'endTokenPos' => 2808,
            'endFilePos' => 25320,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 366,
        'endLine' => 366,
        'startColumn' => 5,
        'endColumn' => 103,
      ),
      'TYPE_FINANCIAL_CONNECTIONS_ACCOUNT_DISCONNECTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_FINANCIAL_CONNECTIONS_ACCOUNT_DISCONNECTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'financial_connections.account.disconnected\'',
          'attributes' => 
          array (
            'startLine' => 367,
            'endLine' => 367,
            'startTokenPos' => 2817,
            'startFilePos' => 25384,
            'endTokenPos' => 2817,
            'endFilePos' => 25427,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 367,
        'endLine' => 367,
        'startColumn' => 5,
        'endColumn' => 105,
      ),
      'TYPE_FINANCIAL_CONNECTIONS_ACCOUNT_REACTIVATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_FINANCIAL_CONNECTIONS_ACCOUNT_REACTIVATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'financial_connections.account.reactivated\'',
          'attributes' => 
          array (
            'startLine' => 368,
            'endLine' => 368,
            'startTokenPos' => 2826,
            'startFilePos' => 25490,
            'endTokenPos' => 2826,
            'endFilePos' => 25532,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 368,
        'endLine' => 368,
        'startColumn' => 5,
        'endColumn' => 103,
      ),
      'TYPE_FINANCIAL_CONNECTIONS_ACCOUNT_REFRESHED_BALANCE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_FINANCIAL_CONNECTIONS_ACCOUNT_REFRESHED_BALANCE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'financial_connections.account.refreshed_balance\'',
          'attributes' => 
          array (
            'startLine' => 369,
            'endLine' => 369,
            'startTokenPos' => 2835,
            'startFilePos' => 25601,
            'endTokenPos' => 2835,
            'endFilePos' => 25649,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 369,
        'endLine' => 369,
        'startColumn' => 5,
        'endColumn' => 115,
      ),
      'TYPE_FINANCIAL_CONNECTIONS_ACCOUNT_REFRESHED_OWNERSHIP' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_FINANCIAL_CONNECTIONS_ACCOUNT_REFRESHED_OWNERSHIP',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'financial_connections.account.refreshed_ownership\'',
          'attributes' => 
          array (
            'startLine' => 370,
            'endLine' => 370,
            'startTokenPos' => 2844,
            'startFilePos' => 25720,
            'endTokenPos' => 2844,
            'endFilePos' => 25770,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 370,
        'endLine' => 370,
        'startColumn' => 5,
        'endColumn' => 119,
      ),
      'TYPE_FINANCIAL_CONNECTIONS_ACCOUNT_REFRESHED_TRANSACTIONS' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_FINANCIAL_CONNECTIONS_ACCOUNT_REFRESHED_TRANSACTIONS',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'financial_connections.account.refreshed_transactions\'',
          'attributes' => 
          array (
            'startLine' => 371,
            'endLine' => 371,
            'startTokenPos' => 2853,
            'startFilePos' => 25844,
            'endTokenPos' => 2853,
            'endFilePos' => 25897,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 371,
        'endLine' => 371,
        'startColumn' => 5,
        'endColumn' => 125,
      ),
      'TYPE_IDENTITY_VERIFICATION_SESSION_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_IDENTITY_VERIFICATION_SESSION_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'identity.verification_session.canceled\'',
          'attributes' => 
          array (
            'startLine' => 372,
            'endLine' => 372,
            'startTokenPos' => 2862,
            'startFilePos' => 25957,
            'endTokenPos' => 2862,
            'endFilePos' => 25996,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 372,
        'endLine' => 372,
        'startColumn' => 5,
        'endColumn' => 97,
      ),
      'TYPE_IDENTITY_VERIFICATION_SESSION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_IDENTITY_VERIFICATION_SESSION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'identity.verification_session.created\'',
          'attributes' => 
          array (
            'startLine' => 373,
            'endLine' => 373,
            'startTokenPos' => 2871,
            'startFilePos' => 26055,
            'endTokenPos' => 2871,
            'endFilePos' => 26093,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 373,
        'endLine' => 373,
        'startColumn' => 5,
        'endColumn' => 95,
      ),
      'TYPE_IDENTITY_VERIFICATION_SESSION_PROCESSING' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_IDENTITY_VERIFICATION_SESSION_PROCESSING',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'identity.verification_session.processing\'',
          'attributes' => 
          array (
            'startLine' => 374,
            'endLine' => 374,
            'startTokenPos' => 2880,
            'startFilePos' => 26155,
            'endTokenPos' => 2880,
            'endFilePos' => 26196,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 374,
        'endLine' => 374,
        'startColumn' => 5,
        'endColumn' => 101,
      ),
      'TYPE_IDENTITY_VERIFICATION_SESSION_REDACTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_IDENTITY_VERIFICATION_SESSION_REDACTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'identity.verification_session.redacted\'',
          'attributes' => 
          array (
            'startLine' => 375,
            'endLine' => 375,
            'startTokenPos' => 2889,
            'startFilePos' => 26256,
            'endTokenPos' => 2889,
            'endFilePos' => 26295,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 375,
        'endLine' => 375,
        'startColumn' => 5,
        'endColumn' => 97,
      ),
      'TYPE_IDENTITY_VERIFICATION_SESSION_REQUIRES_INPUT' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_IDENTITY_VERIFICATION_SESSION_REQUIRES_INPUT',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'identity.verification_session.requires_input\'',
          'attributes' => 
          array (
            'startLine' => 376,
            'endLine' => 376,
            'startTokenPos' => 2898,
            'startFilePos' => 26361,
            'endTokenPos' => 2898,
            'endFilePos' => 26406,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 376,
        'endLine' => 376,
        'startColumn' => 5,
        'endColumn' => 109,
      ),
      'TYPE_IDENTITY_VERIFICATION_SESSION_VERIFIED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_IDENTITY_VERIFICATION_SESSION_VERIFIED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'identity.verification_session.verified\'',
          'attributes' => 
          array (
            'startLine' => 377,
            'endLine' => 377,
            'startTokenPos' => 2907,
            'startFilePos' => 26466,
            'endTokenPos' => 2907,
            'endFilePos' => 26505,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 377,
        'endLine' => 377,
        'startColumn' => 5,
        'endColumn' => 97,
      ),
      'TYPE_INVOICEITEM_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICEITEM_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoiceitem.created\'',
          'attributes' => 
          array (
            'startLine' => 378,
            'endLine' => 378,
            'startTokenPos' => 2916,
            'startFilePos' => 26546,
            'endTokenPos' => 2916,
            'endFilePos' => 26566,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 378,
        'endLine' => 378,
        'startColumn' => 5,
        'endColumn' => 59,
      ),
      'TYPE_INVOICEITEM_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICEITEM_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoiceitem.deleted\'',
          'attributes' => 
          array (
            'startLine' => 379,
            'endLine' => 379,
            'startTokenPos' => 2925,
            'startFilePos' => 26607,
            'endTokenPos' => 2925,
            'endFilePos' => 26627,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 379,
        'endLine' => 379,
        'startColumn' => 5,
        'endColumn' => 59,
      ),
      'TYPE_INVOICE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.created\'',
          'attributes' => 
          array (
            'startLine' => 380,
            'endLine' => 380,
            'startTokenPos' => 2934,
            'startFilePos' => 26664,
            'endTokenPos' => 2934,
            'endFilePos' => 26680,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 380,
        'endLine' => 380,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'TYPE_INVOICE_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICE_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.deleted\'',
          'attributes' => 
          array (
            'startLine' => 381,
            'endLine' => 381,
            'startTokenPos' => 2943,
            'startFilePos' => 26717,
            'endTokenPos' => 2943,
            'endFilePos' => 26733,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 381,
        'endLine' => 381,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'TYPE_INVOICE_FINALIZATION_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICE_FINALIZATION_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.finalization_failed\'',
          'attributes' => 
          array (
            'startLine' => 382,
            'endLine' => 382,
            'startTokenPos' => 2952,
            'startFilePos' => 26782,
            'endTokenPos' => 2952,
            'endFilePos' => 26810,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 382,
        'endLine' => 382,
        'startColumn' => 5,
        'endColumn' => 75,
      ),
      'TYPE_INVOICE_FINALIZED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICE_FINALIZED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.finalized\'',
          'attributes' => 
          array (
            'startLine' => 383,
            'endLine' => 383,
            'startTokenPos' => 2961,
            'startFilePos' => 26849,
            'endTokenPos' => 2961,
            'endFilePos' => 26867,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 383,
        'endLine' => 383,
        'startColumn' => 5,
        'endColumn' => 55,
      ),
      'TYPE_INVOICE_MARKED_UNCOLLECTIBLE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICE_MARKED_UNCOLLECTIBLE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.marked_uncollectible\'',
          'attributes' => 
          array (
            'startLine' => 384,
            'endLine' => 384,
            'startTokenPos' => 2970,
            'startFilePos' => 26917,
            'endTokenPos' => 2970,
            'endFilePos' => 26946,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 384,
        'endLine' => 384,
        'startColumn' => 5,
        'endColumn' => 77,
      ),
      'TYPE_INVOICE_OVERDUE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICE_OVERDUE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.overdue\'',
          'attributes' => 
          array (
            'startLine' => 385,
            'endLine' => 385,
            'startTokenPos' => 2979,
            'startFilePos' => 26983,
            'endTokenPos' => 2979,
            'endFilePos' => 26999,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 385,
        'endLine' => 385,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'TYPE_INVOICE_PAID' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICE_PAID',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.paid\'',
          'attributes' => 
          array (
            'startLine' => 386,
            'endLine' => 386,
            'startTokenPos' => 2988,
            'startFilePos' => 27033,
            'endTokenPos' => 2988,
            'endFilePos' => 27046,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 386,
        'endLine' => 386,
        'startColumn' => 5,
        'endColumn' => 45,
      ),
      'TYPE_INVOICE_PAYMENT_ACTION_REQUIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICE_PAYMENT_ACTION_REQUIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.payment_action_required\'',
          'attributes' => 
          array (
            'startLine' => 387,
            'endLine' => 387,
            'startTokenPos' => 2997,
            'startFilePos' => 27099,
            'endTokenPos' => 2997,
            'endFilePos' => 27131,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 387,
        'endLine' => 387,
        'startColumn' => 5,
        'endColumn' => 83,
      ),
      'TYPE_INVOICE_PAYMENT_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICE_PAYMENT_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.payment_failed\'',
          'attributes' => 
          array (
            'startLine' => 388,
            'endLine' => 388,
            'startTokenPos' => 3006,
            'startFilePos' => 27175,
            'endTokenPos' => 3006,
            'endFilePos' => 27198,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 388,
        'endLine' => 388,
        'startColumn' => 5,
        'endColumn' => 65,
      ),
      'TYPE_INVOICE_PAYMENT_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICE_PAYMENT_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.payment_succeeded\'',
          'attributes' => 
          array (
            'startLine' => 389,
            'endLine' => 389,
            'startTokenPos' => 3015,
            'startFilePos' => 27245,
            'endTokenPos' => 3015,
            'endFilePos' => 27271,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 389,
        'endLine' => 389,
        'startColumn' => 5,
        'endColumn' => 71,
      ),
      'TYPE_INVOICE_SENT' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICE_SENT',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.sent\'',
          'attributes' => 
          array (
            'startLine' => 390,
            'endLine' => 390,
            'startTokenPos' => 3024,
            'startFilePos' => 27305,
            'endTokenPos' => 3024,
            'endFilePos' => 27318,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 390,
        'endLine' => 390,
        'startColumn' => 5,
        'endColumn' => 45,
      ),
      'TYPE_INVOICE_UPCOMING' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICE_UPCOMING',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.upcoming\'',
          'attributes' => 
          array (
            'startLine' => 391,
            'endLine' => 391,
            'startTokenPos' => 3033,
            'startFilePos' => 27356,
            'endTokenPos' => 3033,
            'endFilePos' => 27373,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 391,
        'endLine' => 391,
        'startColumn' => 5,
        'endColumn' => 53,
      ),
      'TYPE_INVOICE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.updated\'',
          'attributes' => 
          array (
            'startLine' => 392,
            'endLine' => 392,
            'startTokenPos' => 3042,
            'startFilePos' => 27410,
            'endTokenPos' => 3042,
            'endFilePos' => 27426,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 392,
        'endLine' => 392,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'TYPE_INVOICE_VOIDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICE_VOIDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.voided\'',
          'attributes' => 
          array (
            'startLine' => 393,
            'endLine' => 393,
            'startTokenPos' => 3051,
            'startFilePos' => 27462,
            'endTokenPos' => 3051,
            'endFilePos' => 27477,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 393,
        'endLine' => 393,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_INVOICE_WILL_BE_DUE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_INVOICE_WILL_BE_DUE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice.will_be_due\'',
          'attributes' => 
          array (
            'startLine' => 394,
            'endLine' => 394,
            'startTokenPos' => 3060,
            'startFilePos' => 27518,
            'endTokenPos' => 3060,
            'endFilePos' => 27538,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 394,
        'endLine' => 394,
        'startColumn' => 5,
        'endColumn' => 59,
      ),
      'TYPE_ISSUING_AUTHORIZATION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_AUTHORIZATION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_authorization.created\'',
          'attributes' => 
          array (
            'startLine' => 395,
            'endLine' => 395,
            'startTokenPos' => 3069,
            'startFilePos' => 27589,
            'endTokenPos' => 3069,
            'endFilePos' => 27619,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 395,
        'endLine' => 395,
        'startColumn' => 5,
        'endColumn' => 79,
      ),
      'TYPE_ISSUING_AUTHORIZATION_REQUEST' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_AUTHORIZATION_REQUEST',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_authorization.request\'',
          'attributes' => 
          array (
            'startLine' => 396,
            'endLine' => 396,
            'startTokenPos' => 3078,
            'startFilePos' => 27670,
            'endTokenPos' => 3078,
            'endFilePos' => 27700,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 396,
        'endLine' => 396,
        'startColumn' => 5,
        'endColumn' => 79,
      ),
      'TYPE_ISSUING_AUTHORIZATION_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_AUTHORIZATION_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_authorization.updated\'',
          'attributes' => 
          array (
            'startLine' => 397,
            'endLine' => 397,
            'startTokenPos' => 3087,
            'startFilePos' => 27751,
            'endTokenPos' => 3087,
            'endFilePos' => 27781,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 397,
        'endLine' => 397,
        'startColumn' => 5,
        'endColumn' => 79,
      ),
      'TYPE_ISSUING_CARDHOLDER_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_CARDHOLDER_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_cardholder.created\'',
          'attributes' => 
          array (
            'startLine' => 398,
            'endLine' => 398,
            'startTokenPos' => 3096,
            'startFilePos' => 27829,
            'endTokenPos' => 3096,
            'endFilePos' => 27856,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 398,
        'endLine' => 398,
        'startColumn' => 5,
        'endColumn' => 73,
      ),
      'TYPE_ISSUING_CARDHOLDER_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_CARDHOLDER_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_cardholder.updated\'',
          'attributes' => 
          array (
            'startLine' => 399,
            'endLine' => 399,
            'startTokenPos' => 3105,
            'startFilePos' => 27904,
            'endTokenPos' => 3105,
            'endFilePos' => 27931,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 399,
        'endLine' => 399,
        'startColumn' => 5,
        'endColumn' => 73,
      ),
      'TYPE_ISSUING_CARD_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_CARD_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_card.created\'',
          'attributes' => 
          array (
            'startLine' => 400,
            'endLine' => 400,
            'startTokenPos' => 3114,
            'startFilePos' => 27973,
            'endTokenPos' => 3114,
            'endFilePos' => 27994,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 400,
        'endLine' => 400,
        'startColumn' => 5,
        'endColumn' => 61,
      ),
      'TYPE_ISSUING_CARD_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_CARD_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_card.updated\'',
          'attributes' => 
          array (
            'startLine' => 401,
            'endLine' => 401,
            'startTokenPos' => 3123,
            'startFilePos' => 28036,
            'endTokenPos' => 3123,
            'endFilePos' => 28057,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 401,
        'endLine' => 401,
        'startColumn' => 5,
        'endColumn' => 61,
      ),
      'TYPE_ISSUING_DISPUTE_CLOSED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_DISPUTE_CLOSED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_dispute.closed\'',
          'attributes' => 
          array (
            'startLine' => 402,
            'endLine' => 402,
            'startTokenPos' => 3132,
            'startFilePos' => 28101,
            'endTokenPos' => 3132,
            'endFilePos' => 28124,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 402,
        'endLine' => 402,
        'startColumn' => 5,
        'endColumn' => 65,
      ),
      'TYPE_ISSUING_DISPUTE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_DISPUTE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_dispute.created\'',
          'attributes' => 
          array (
            'startLine' => 403,
            'endLine' => 403,
            'startTokenPos' => 3141,
            'startFilePos' => 28169,
            'endTokenPos' => 3141,
            'endFilePos' => 28193,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 403,
        'endLine' => 403,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'TYPE_ISSUING_DISPUTE_FUNDS_REINSTATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_DISPUTE_FUNDS_REINSTATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_dispute.funds_reinstated\'',
          'attributes' => 
          array (
            'startLine' => 404,
            'endLine' => 404,
            'startTokenPos' => 3150,
            'startFilePos' => 28247,
            'endTokenPos' => 3150,
            'endFilePos' => 28280,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 404,
        'endLine' => 404,
        'startColumn' => 5,
        'endColumn' => 85,
      ),
      'TYPE_ISSUING_DISPUTE_FUNDS_RESCINDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_DISPUTE_FUNDS_RESCINDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_dispute.funds_rescinded\'',
          'attributes' => 
          array (
            'startLine' => 405,
            'endLine' => 405,
            'startTokenPos' => 3159,
            'startFilePos' => 28333,
            'endTokenPos' => 3159,
            'endFilePos' => 28365,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 405,
        'endLine' => 405,
        'startColumn' => 5,
        'endColumn' => 83,
      ),
      'TYPE_ISSUING_DISPUTE_SUBMITTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_DISPUTE_SUBMITTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_dispute.submitted\'',
          'attributes' => 
          array (
            'startLine' => 406,
            'endLine' => 406,
            'startTokenPos' => 3168,
            'startFilePos' => 28412,
            'endTokenPos' => 3168,
            'endFilePos' => 28438,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 406,
        'endLine' => 406,
        'startColumn' => 5,
        'endColumn' => 71,
      ),
      'TYPE_ISSUING_DISPUTE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_DISPUTE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_dispute.updated\'',
          'attributes' => 
          array (
            'startLine' => 407,
            'endLine' => 407,
            'startTokenPos' => 3177,
            'startFilePos' => 28483,
            'endTokenPos' => 3177,
            'endFilePos' => 28507,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 407,
        'endLine' => 407,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'TYPE_ISSUING_PERSONALIZATION_DESIGN_ACTIVATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_PERSONALIZATION_DESIGN_ACTIVATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_personalization_design.activated\'',
          'attributes' => 
          array (
            'startLine' => 408,
            'endLine' => 408,
            'startTokenPos' => 3186,
            'startFilePos' => 28569,
            'endTokenPos' => 3186,
            'endFilePos' => 28610,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 408,
        'endLine' => 408,
        'startColumn' => 5,
        'endColumn' => 101,
      ),
      'TYPE_ISSUING_PERSONALIZATION_DESIGN_DEACTIVATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_PERSONALIZATION_DESIGN_DEACTIVATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_personalization_design.deactivated\'',
          'attributes' => 
          array (
            'startLine' => 409,
            'endLine' => 409,
            'startTokenPos' => 3195,
            'startFilePos' => 28674,
            'endTokenPos' => 3195,
            'endFilePos' => 28717,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 409,
        'endLine' => 409,
        'startColumn' => 5,
        'endColumn' => 105,
      ),
      'TYPE_ISSUING_PERSONALIZATION_DESIGN_REJECTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_PERSONALIZATION_DESIGN_REJECTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_personalization_design.rejected\'',
          'attributes' => 
          array (
            'startLine' => 410,
            'endLine' => 410,
            'startTokenPos' => 3204,
            'startFilePos' => 28778,
            'endTokenPos' => 3204,
            'endFilePos' => 28818,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 410,
        'endLine' => 410,
        'startColumn' => 5,
        'endColumn' => 99,
      ),
      'TYPE_ISSUING_PERSONALIZATION_DESIGN_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_PERSONALIZATION_DESIGN_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_personalization_design.updated\'',
          'attributes' => 
          array (
            'startLine' => 411,
            'endLine' => 411,
            'startTokenPos' => 3213,
            'startFilePos' => 28878,
            'endTokenPos' => 3213,
            'endFilePos' => 28917,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 411,
        'endLine' => 411,
        'startColumn' => 5,
        'endColumn' => 97,
      ),
      'TYPE_ISSUING_TOKEN_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_TOKEN_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_token.created\'',
          'attributes' => 
          array (
            'startLine' => 412,
            'endLine' => 412,
            'startTokenPos' => 3222,
            'startFilePos' => 28960,
            'endTokenPos' => 3222,
            'endFilePos' => 28982,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 412,
        'endLine' => 412,
        'startColumn' => 5,
        'endColumn' => 63,
      ),
      'TYPE_ISSUING_TOKEN_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_TOKEN_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_token.updated\'',
          'attributes' => 
          array (
            'startLine' => 413,
            'endLine' => 413,
            'startTokenPos' => 3231,
            'startFilePos' => 29025,
            'endTokenPos' => 3231,
            'endFilePos' => 29047,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 413,
        'endLine' => 413,
        'startColumn' => 5,
        'endColumn' => 63,
      ),
      'TYPE_ISSUING_TRANSACTION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_TRANSACTION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_transaction.created\'',
          'attributes' => 
          array (
            'startLine' => 414,
            'endLine' => 414,
            'startTokenPos' => 3240,
            'startFilePos' => 29096,
            'endTokenPos' => 3240,
            'endFilePos' => 29124,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 414,
        'endLine' => 414,
        'startColumn' => 5,
        'endColumn' => 75,
      ),
      'TYPE_ISSUING_TRANSACTION_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_ISSUING_TRANSACTION_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'issuing_transaction.updated\'',
          'attributes' => 
          array (
            'startLine' => 415,
            'endLine' => 415,
            'startTokenPos' => 3249,
            'startFilePos' => 29173,
            'endTokenPos' => 3249,
            'endFilePos' => 29201,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 415,
        'endLine' => 415,
        'startColumn' => 5,
        'endColumn' => 75,
      ),
      'TYPE_MANDATE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_MANDATE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'mandate.updated\'',
          'attributes' => 
          array (
            'startLine' => 416,
            'endLine' => 416,
            'startTokenPos' => 3258,
            'startFilePos' => 29238,
            'endTokenPos' => 3258,
            'endFilePos' => 29254,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 416,
        'endLine' => 416,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'TYPE_PAYMENT_INTENT_AMOUNT_CAPTURABLE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYMENT_INTENT_AMOUNT_CAPTURABLE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.amount_capturable_updated\'',
          'attributes' => 
          array (
            'startLine' => 417,
            'endLine' => 417,
            'startTokenPos' => 3267,
            'startFilePos' => 29316,
            'endTokenPos' => 3267,
            'endFilePos' => 29357,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 417,
        'endLine' => 417,
        'startColumn' => 5,
        'endColumn' => 101,
      ),
      'TYPE_PAYMENT_INTENT_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYMENT_INTENT_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.canceled\'',
          'attributes' => 
          array (
            'startLine' => 418,
            'endLine' => 418,
            'startTokenPos' => 3276,
            'startFilePos' => 29402,
            'endTokenPos' => 3276,
            'endFilePos' => 29426,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 418,
        'endLine' => 418,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'TYPE_PAYMENT_INTENT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYMENT_INTENT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.created\'',
          'attributes' => 
          array (
            'startLine' => 419,
            'endLine' => 419,
            'startTokenPos' => 3285,
            'startFilePos' => 29470,
            'endTokenPos' => 3285,
            'endFilePos' => 29493,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 419,
        'endLine' => 419,
        'startColumn' => 5,
        'endColumn' => 65,
      ),
      'TYPE_PAYMENT_INTENT_PARTIALLY_FUNDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYMENT_INTENT_PARTIALLY_FUNDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.partially_funded\'',
          'attributes' => 
          array (
            'startLine' => 420,
            'endLine' => 420,
            'startTokenPos' => 3294,
            'startFilePos' => 29546,
            'endTokenPos' => 3294,
            'endFilePos' => 29578,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 420,
        'endLine' => 420,
        'startColumn' => 5,
        'endColumn' => 83,
      ),
      'TYPE_PAYMENT_INTENT_PAYMENT_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYMENT_INTENT_PAYMENT_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.payment_failed\'',
          'attributes' => 
          array (
            'startLine' => 421,
            'endLine' => 421,
            'startTokenPos' => 3303,
            'startFilePos' => 29629,
            'endTokenPos' => 3303,
            'endFilePos' => 29659,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 421,
        'endLine' => 421,
        'startColumn' => 5,
        'endColumn' => 79,
      ),
      'TYPE_PAYMENT_INTENT_PROCESSING' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYMENT_INTENT_PROCESSING',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.processing\'',
          'attributes' => 
          array (
            'startLine' => 422,
            'endLine' => 422,
            'startTokenPos' => 3312,
            'startFilePos' => 29706,
            'endTokenPos' => 3312,
            'endFilePos' => 29732,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 422,
        'endLine' => 422,
        'startColumn' => 5,
        'endColumn' => 71,
      ),
      'TYPE_PAYMENT_INTENT_REQUIRES_ACTION' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYMENT_INTENT_REQUIRES_ACTION',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.requires_action\'',
          'attributes' => 
          array (
            'startLine' => 423,
            'endLine' => 423,
            'startTokenPos' => 3321,
            'startFilePos' => 29784,
            'endTokenPos' => 3321,
            'endFilePos' => 29815,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 423,
        'endLine' => 423,
        'startColumn' => 5,
        'endColumn' => 81,
      ),
      'TYPE_PAYMENT_INTENT_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYMENT_INTENT_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_intent.succeeded\'',
          'attributes' => 
          array (
            'startLine' => 424,
            'endLine' => 424,
            'startTokenPos' => 3330,
            'startFilePos' => 29861,
            'endTokenPos' => 3330,
            'endFilePos' => 29886,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 424,
        'endLine' => 424,
        'startColumn' => 5,
        'endColumn' => 69,
      ),
      'TYPE_PAYMENT_LINK_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYMENT_LINK_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_link.created\'',
          'attributes' => 
          array (
            'startLine' => 425,
            'endLine' => 425,
            'startTokenPos' => 3339,
            'startFilePos' => 29928,
            'endTokenPos' => 3339,
            'endFilePos' => 29949,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 425,
        'endLine' => 425,
        'startColumn' => 5,
        'endColumn' => 61,
      ),
      'TYPE_PAYMENT_LINK_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYMENT_LINK_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_link.updated\'',
          'attributes' => 
          array (
            'startLine' => 426,
            'endLine' => 426,
            'startTokenPos' => 3348,
            'startFilePos' => 29991,
            'endTokenPos' => 3348,
            'endFilePos' => 30012,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 426,
        'endLine' => 426,
        'startColumn' => 5,
        'endColumn' => 61,
      ),
      'TYPE_PAYMENT_METHOD_ATTACHED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYMENT_METHOD_ATTACHED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_method.attached\'',
          'attributes' => 
          array (
            'startLine' => 427,
            'endLine' => 427,
            'startTokenPos' => 3357,
            'startFilePos' => 30057,
            'endTokenPos' => 3357,
            'endFilePos' => 30081,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 427,
        'endLine' => 427,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'TYPE_PAYMENT_METHOD_AUTOMATICALLY_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYMENT_METHOD_AUTOMATICALLY_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_method.automatically_updated\'',
          'attributes' => 
          array (
            'startLine' => 428,
            'endLine' => 428,
            'startTokenPos' => 3366,
            'startFilePos' => 30139,
            'endTokenPos' => 3366,
            'endFilePos' => 30176,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 428,
        'endLine' => 428,
        'startColumn' => 5,
        'endColumn' => 93,
      ),
      'TYPE_PAYMENT_METHOD_DETACHED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYMENT_METHOD_DETACHED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_method.detached\'',
          'attributes' => 
          array (
            'startLine' => 429,
            'endLine' => 429,
            'startTokenPos' => 3375,
            'startFilePos' => 30221,
            'endTokenPos' => 3375,
            'endFilePos' => 30245,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 429,
        'endLine' => 429,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'TYPE_PAYMENT_METHOD_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYMENT_METHOD_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment_method.updated\'',
          'attributes' => 
          array (
            'startLine' => 430,
            'endLine' => 430,
            'startTokenPos' => 3384,
            'startFilePos' => 30289,
            'endTokenPos' => 3384,
            'endFilePos' => 30312,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 430,
        'endLine' => 430,
        'startColumn' => 5,
        'endColumn' => 65,
      ),
      'TYPE_PAYOUT_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYOUT_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payout.canceled\'',
          'attributes' => 
          array (
            'startLine' => 431,
            'endLine' => 431,
            'startTokenPos' => 3393,
            'startFilePos' => 30349,
            'endTokenPos' => 3393,
            'endFilePos' => 30365,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 431,
        'endLine' => 431,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'TYPE_PAYOUT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYOUT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payout.created\'',
          'attributes' => 
          array (
            'startLine' => 432,
            'endLine' => 432,
            'startTokenPos' => 3402,
            'startFilePos' => 30401,
            'endTokenPos' => 3402,
            'endFilePos' => 30416,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 432,
        'endLine' => 432,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_PAYOUT_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYOUT_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payout.failed\'',
          'attributes' => 
          array (
            'startLine' => 433,
            'endLine' => 433,
            'startTokenPos' => 3411,
            'startFilePos' => 30451,
            'endTokenPos' => 3411,
            'endFilePos' => 30465,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 433,
        'endLine' => 433,
        'startColumn' => 5,
        'endColumn' => 47,
      ),
      'TYPE_PAYOUT_PAID' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYOUT_PAID',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payout.paid\'',
          'attributes' => 
          array (
            'startLine' => 434,
            'endLine' => 434,
            'startTokenPos' => 3420,
            'startFilePos' => 30498,
            'endTokenPos' => 3420,
            'endFilePos' => 30510,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 434,
        'endLine' => 434,
        'startColumn' => 5,
        'endColumn' => 43,
      ),
      'TYPE_PAYOUT_RECONCILIATION_COMPLETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYOUT_RECONCILIATION_COMPLETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payout.reconciliation_completed\'',
          'attributes' => 
          array (
            'startLine' => 435,
            'endLine' => 435,
            'startTokenPos' => 3429,
            'startFilePos' => 30563,
            'endTokenPos' => 3429,
            'endFilePos' => 30595,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 435,
        'endLine' => 435,
        'startColumn' => 5,
        'endColumn' => 83,
      ),
      'TYPE_PAYOUT_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PAYOUT_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payout.updated\'',
          'attributes' => 
          array (
            'startLine' => 436,
            'endLine' => 436,
            'startTokenPos' => 3438,
            'startFilePos' => 30631,
            'endTokenPos' => 3438,
            'endFilePos' => 30646,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 436,
        'endLine' => 436,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_PERSON_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PERSON_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'person.created\'',
          'attributes' => 
          array (
            'startLine' => 437,
            'endLine' => 437,
            'startTokenPos' => 3447,
            'startFilePos' => 30682,
            'endTokenPos' => 3447,
            'endFilePos' => 30697,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 437,
        'endLine' => 437,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_PERSON_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PERSON_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'person.deleted\'',
          'attributes' => 
          array (
            'startLine' => 438,
            'endLine' => 438,
            'startTokenPos' => 3456,
            'startFilePos' => 30733,
            'endTokenPos' => 3456,
            'endFilePos' => 30748,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 438,
        'endLine' => 438,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_PERSON_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PERSON_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'person.updated\'',
          'attributes' => 
          array (
            'startLine' => 439,
            'endLine' => 439,
            'startTokenPos' => 3465,
            'startFilePos' => 30784,
            'endTokenPos' => 3465,
            'endFilePos' => 30799,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 439,
        'endLine' => 439,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_PLAN_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PLAN_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'plan.created\'',
          'attributes' => 
          array (
            'startLine' => 440,
            'endLine' => 440,
            'startTokenPos' => 3474,
            'startFilePos' => 30833,
            'endTokenPos' => 3474,
            'endFilePos' => 30846,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 440,
        'endLine' => 440,
        'startColumn' => 5,
        'endColumn' => 45,
      ),
      'TYPE_PLAN_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PLAN_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'plan.deleted\'',
          'attributes' => 
          array (
            'startLine' => 441,
            'endLine' => 441,
            'startTokenPos' => 3483,
            'startFilePos' => 30880,
            'endTokenPos' => 3483,
            'endFilePos' => 30893,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 441,
        'endLine' => 441,
        'startColumn' => 5,
        'endColumn' => 45,
      ),
      'TYPE_PLAN_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PLAN_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'plan.updated\'',
          'attributes' => 
          array (
            'startLine' => 442,
            'endLine' => 442,
            'startTokenPos' => 3492,
            'startFilePos' => 30927,
            'endTokenPos' => 3492,
            'endFilePos' => 30940,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 442,
        'endLine' => 442,
        'startColumn' => 5,
        'endColumn' => 45,
      ),
      'TYPE_PRICE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PRICE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'price.created\'',
          'attributes' => 
          array (
            'startLine' => 443,
            'endLine' => 443,
            'startTokenPos' => 3501,
            'startFilePos' => 30975,
            'endTokenPos' => 3501,
            'endFilePos' => 30989,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 443,
        'endLine' => 443,
        'startColumn' => 5,
        'endColumn' => 47,
      ),
      'TYPE_PRICE_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PRICE_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'price.deleted\'',
          'attributes' => 
          array (
            'startLine' => 444,
            'endLine' => 444,
            'startTokenPos' => 3510,
            'startFilePos' => 31024,
            'endTokenPos' => 3510,
            'endFilePos' => 31038,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 444,
        'endLine' => 444,
        'startColumn' => 5,
        'endColumn' => 47,
      ),
      'TYPE_PRICE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PRICE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'price.updated\'',
          'attributes' => 
          array (
            'startLine' => 445,
            'endLine' => 445,
            'startTokenPos' => 3519,
            'startFilePos' => 31073,
            'endTokenPos' => 3519,
            'endFilePos' => 31087,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 445,
        'endLine' => 445,
        'startColumn' => 5,
        'endColumn' => 47,
      ),
      'TYPE_PRODUCT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PRODUCT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'product.created\'',
          'attributes' => 
          array (
            'startLine' => 446,
            'endLine' => 446,
            'startTokenPos' => 3528,
            'startFilePos' => 31124,
            'endTokenPos' => 3528,
            'endFilePos' => 31140,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 446,
        'endLine' => 446,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'TYPE_PRODUCT_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PRODUCT_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'product.deleted\'',
          'attributes' => 
          array (
            'startLine' => 447,
            'endLine' => 447,
            'startTokenPos' => 3537,
            'startFilePos' => 31177,
            'endTokenPos' => 3537,
            'endFilePos' => 31193,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 447,
        'endLine' => 447,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'TYPE_PRODUCT_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PRODUCT_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'product.updated\'',
          'attributes' => 
          array (
            'startLine' => 448,
            'endLine' => 448,
            'startTokenPos' => 3546,
            'startFilePos' => 31230,
            'endTokenPos' => 3546,
            'endFilePos' => 31246,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 448,
        'endLine' => 448,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'TYPE_PROMOTION_CODE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PROMOTION_CODE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'promotion_code.created\'',
          'attributes' => 
          array (
            'startLine' => 449,
            'endLine' => 449,
            'startTokenPos' => 3555,
            'startFilePos' => 31290,
            'endTokenPos' => 3555,
            'endFilePos' => 31313,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 449,
        'endLine' => 449,
        'startColumn' => 5,
        'endColumn' => 65,
      ),
      'TYPE_PROMOTION_CODE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_PROMOTION_CODE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'promotion_code.updated\'',
          'attributes' => 
          array (
            'startLine' => 450,
            'endLine' => 450,
            'startTokenPos' => 3564,
            'startFilePos' => 31357,
            'endTokenPos' => 3564,
            'endFilePos' => 31380,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 450,
        'endLine' => 450,
        'startColumn' => 5,
        'endColumn' => 65,
      ),
      'TYPE_QUOTE_ACCEPTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_QUOTE_ACCEPTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'quote.accepted\'',
          'attributes' => 
          array (
            'startLine' => 451,
            'endLine' => 451,
            'startTokenPos' => 3573,
            'startFilePos' => 31416,
            'endTokenPos' => 3573,
            'endFilePos' => 31431,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 451,
        'endLine' => 451,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_QUOTE_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_QUOTE_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'quote.canceled\'',
          'attributes' => 
          array (
            'startLine' => 452,
            'endLine' => 452,
            'startTokenPos' => 3582,
            'startFilePos' => 31467,
            'endTokenPos' => 3582,
            'endFilePos' => 31482,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 452,
        'endLine' => 452,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_QUOTE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_QUOTE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'quote.created\'',
          'attributes' => 
          array (
            'startLine' => 453,
            'endLine' => 453,
            'startTokenPos' => 3591,
            'startFilePos' => 31517,
            'endTokenPos' => 3591,
            'endFilePos' => 31531,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 453,
        'endLine' => 453,
        'startColumn' => 5,
        'endColumn' => 47,
      ),
      'TYPE_QUOTE_FINALIZED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_QUOTE_FINALIZED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'quote.finalized\'',
          'attributes' => 
          array (
            'startLine' => 454,
            'endLine' => 454,
            'startTokenPos' => 3600,
            'startFilePos' => 31568,
            'endTokenPos' => 3600,
            'endFilePos' => 31584,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 454,
        'endLine' => 454,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'TYPE_RADAR_EARLY_FRAUD_WARNING_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_RADAR_EARLY_FRAUD_WARNING_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'radar.early_fraud_warning.created\'',
          'attributes' => 
          array (
            'startLine' => 455,
            'endLine' => 455,
            'startTokenPos' => 3609,
            'startFilePos' => 31639,
            'endTokenPos' => 3609,
            'endFilePos' => 31673,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 455,
        'endLine' => 455,
        'startColumn' => 5,
        'endColumn' => 87,
      ),
      'TYPE_RADAR_EARLY_FRAUD_WARNING_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_RADAR_EARLY_FRAUD_WARNING_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'radar.early_fraud_warning.updated\'',
          'attributes' => 
          array (
            'startLine' => 456,
            'endLine' => 456,
            'startTokenPos' => 3618,
            'startFilePos' => 31728,
            'endTokenPos' => 3618,
            'endFilePos' => 31762,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 456,
        'endLine' => 456,
        'startColumn' => 5,
        'endColumn' => 87,
      ),
      'TYPE_REFUND_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_REFUND_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'refund.created\'',
          'attributes' => 
          array (
            'startLine' => 457,
            'endLine' => 457,
            'startTokenPos' => 3627,
            'startFilePos' => 31798,
            'endTokenPos' => 3627,
            'endFilePos' => 31813,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 457,
        'endLine' => 457,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_REFUND_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_REFUND_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'refund.updated\'',
          'attributes' => 
          array (
            'startLine' => 458,
            'endLine' => 458,
            'startTokenPos' => 3636,
            'startFilePos' => 31849,
            'endTokenPos' => 3636,
            'endFilePos' => 31864,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 458,
        'endLine' => 458,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_REPORTING_REPORT_RUN_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_REPORTING_REPORT_RUN_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'reporting.report_run.failed\'',
          'attributes' => 
          array (
            'startLine' => 459,
            'endLine' => 459,
            'startTokenPos' => 3645,
            'startFilePos' => 31913,
            'endTokenPos' => 3645,
            'endFilePos' => 31941,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 459,
        'endLine' => 459,
        'startColumn' => 5,
        'endColumn' => 75,
      ),
      'TYPE_REPORTING_REPORT_RUN_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_REPORTING_REPORT_RUN_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'reporting.report_run.succeeded\'',
          'attributes' => 
          array (
            'startLine' => 460,
            'endLine' => 460,
            'startTokenPos' => 3654,
            'startFilePos' => 31993,
            'endTokenPos' => 3654,
            'endFilePos' => 32024,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 460,
        'endLine' => 460,
        'startColumn' => 5,
        'endColumn' => 81,
      ),
      'TYPE_REPORTING_REPORT_TYPE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_REPORTING_REPORT_TYPE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'reporting.report_type.updated\'',
          'attributes' => 
          array (
            'startLine' => 461,
            'endLine' => 461,
            'startTokenPos' => 3663,
            'startFilePos' => 32075,
            'endTokenPos' => 3663,
            'endFilePos' => 32105,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 461,
        'endLine' => 461,
        'startColumn' => 5,
        'endColumn' => 79,
      ),
      'TYPE_REVIEW_CLOSED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_REVIEW_CLOSED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'review.closed\'',
          'attributes' => 
          array (
            'startLine' => 462,
            'endLine' => 462,
            'startTokenPos' => 3672,
            'startFilePos' => 32140,
            'endTokenPos' => 3672,
            'endFilePos' => 32154,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 462,
        'endLine' => 462,
        'startColumn' => 5,
        'endColumn' => 47,
      ),
      'TYPE_REVIEW_OPENED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_REVIEW_OPENED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'review.opened\'',
          'attributes' => 
          array (
            'startLine' => 463,
            'endLine' => 463,
            'startTokenPos' => 3681,
            'startFilePos' => 32189,
            'endTokenPos' => 3681,
            'endFilePos' => 32203,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 463,
        'endLine' => 463,
        'startColumn' => 5,
        'endColumn' => 47,
      ),
      'TYPE_SETUP_INTENT_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SETUP_INTENT_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'setup_intent.canceled\'',
          'attributes' => 
          array (
            'startLine' => 464,
            'endLine' => 464,
            'startTokenPos' => 3690,
            'startFilePos' => 32246,
            'endTokenPos' => 3690,
            'endFilePos' => 32268,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 464,
        'endLine' => 464,
        'startColumn' => 5,
        'endColumn' => 63,
      ),
      'TYPE_SETUP_INTENT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SETUP_INTENT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'setup_intent.created\'',
          'attributes' => 
          array (
            'startLine' => 465,
            'endLine' => 465,
            'startTokenPos' => 3699,
            'startFilePos' => 32310,
            'endTokenPos' => 3699,
            'endFilePos' => 32331,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 465,
        'endLine' => 465,
        'startColumn' => 5,
        'endColumn' => 61,
      ),
      'TYPE_SETUP_INTENT_REQUIRES_ACTION' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SETUP_INTENT_REQUIRES_ACTION',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'setup_intent.requires_action\'',
          'attributes' => 
          array (
            'startLine' => 466,
            'endLine' => 466,
            'startTokenPos' => 3708,
            'startFilePos' => 32381,
            'endTokenPos' => 3708,
            'endFilePos' => 32410,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 466,
        'endLine' => 466,
        'startColumn' => 5,
        'endColumn' => 77,
      ),
      'TYPE_SETUP_INTENT_SETUP_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SETUP_INTENT_SETUP_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'setup_intent.setup_failed\'',
          'attributes' => 
          array (
            'startLine' => 467,
            'endLine' => 467,
            'startTokenPos' => 3717,
            'startFilePos' => 32457,
            'endTokenPos' => 3717,
            'endFilePos' => 32483,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 467,
        'endLine' => 467,
        'startColumn' => 5,
        'endColumn' => 71,
      ),
      'TYPE_SETUP_INTENT_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SETUP_INTENT_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'setup_intent.succeeded\'',
          'attributes' => 
          array (
            'startLine' => 468,
            'endLine' => 468,
            'startTokenPos' => 3726,
            'startFilePos' => 32527,
            'endTokenPos' => 3726,
            'endFilePos' => 32550,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 468,
        'endLine' => 468,
        'startColumn' => 5,
        'endColumn' => 65,
      ),
      'TYPE_SIGMA_SCHEDULED_QUERY_RUN_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SIGMA_SCHEDULED_QUERY_RUN_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'sigma.scheduled_query_run.created\'',
          'attributes' => 
          array (
            'startLine' => 469,
            'endLine' => 469,
            'startTokenPos' => 3735,
            'startFilePos' => 32605,
            'endTokenPos' => 3735,
            'endFilePos' => 32639,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 469,
        'endLine' => 469,
        'startColumn' => 5,
        'endColumn' => 87,
      ),
      'TYPE_SOURCE_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SOURCE_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'source.canceled\'',
          'attributes' => 
          array (
            'startLine' => 470,
            'endLine' => 470,
            'startTokenPos' => 3744,
            'startFilePos' => 32676,
            'endTokenPos' => 3744,
            'endFilePos' => 32692,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 470,
        'endLine' => 470,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'TYPE_SOURCE_CHARGEABLE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SOURCE_CHARGEABLE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'source.chargeable\'',
          'attributes' => 
          array (
            'startLine' => 471,
            'endLine' => 471,
            'startTokenPos' => 3753,
            'startFilePos' => 32731,
            'endTokenPos' => 3753,
            'endFilePos' => 32749,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 471,
        'endLine' => 471,
        'startColumn' => 5,
        'endColumn' => 55,
      ),
      'TYPE_SOURCE_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SOURCE_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'source.failed\'',
          'attributes' => 
          array (
            'startLine' => 472,
            'endLine' => 472,
            'startTokenPos' => 3762,
            'startFilePos' => 32784,
            'endTokenPos' => 3762,
            'endFilePos' => 32798,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 472,
        'endLine' => 472,
        'startColumn' => 5,
        'endColumn' => 47,
      ),
      'TYPE_SOURCE_MANDATE_NOTIFICATION' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SOURCE_MANDATE_NOTIFICATION',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'source.mandate_notification\'',
          'attributes' => 
          array (
            'startLine' => 473,
            'endLine' => 473,
            'startTokenPos' => 3771,
            'startFilePos' => 32847,
            'endTokenPos' => 3771,
            'endFilePos' => 32875,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 473,
        'endLine' => 473,
        'startColumn' => 5,
        'endColumn' => 75,
      ),
      'TYPE_SOURCE_REFUND_ATTRIBUTES_REQUIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SOURCE_REFUND_ATTRIBUTES_REQUIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'source.refund_attributes_required\'',
          'attributes' => 
          array (
            'startLine' => 474,
            'endLine' => 474,
            'startTokenPos' => 3780,
            'startFilePos' => 32930,
            'endTokenPos' => 3780,
            'endFilePos' => 32964,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 474,
        'endLine' => 474,
        'startColumn' => 5,
        'endColumn' => 87,
      ),
      'TYPE_SOURCE_TRANSACTION_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SOURCE_TRANSACTION_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'source.transaction.created\'',
          'attributes' => 
          array (
            'startLine' => 475,
            'endLine' => 475,
            'startTokenPos' => 3789,
            'startFilePos' => 33012,
            'endTokenPos' => 3789,
            'endFilePos' => 33039,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 475,
        'endLine' => 475,
        'startColumn' => 5,
        'endColumn' => 73,
      ),
      'TYPE_SOURCE_TRANSACTION_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SOURCE_TRANSACTION_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'source.transaction.updated\'',
          'attributes' => 
          array (
            'startLine' => 476,
            'endLine' => 476,
            'startTokenPos' => 3798,
            'startFilePos' => 33087,
            'endTokenPos' => 3798,
            'endFilePos' => 33114,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 476,
        'endLine' => 476,
        'startColumn' => 5,
        'endColumn' => 73,
      ),
      'TYPE_SUBSCRIPTION_SCHEDULE_ABORTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SUBSCRIPTION_SCHEDULE_ABORTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_schedule.aborted\'',
          'attributes' => 
          array (
            'startLine' => 477,
            'endLine' => 477,
            'startTokenPos' => 3807,
            'startFilePos' => 33165,
            'endTokenPos' => 3807,
            'endFilePos' => 33195,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 477,
        'endLine' => 477,
        'startColumn' => 5,
        'endColumn' => 79,
      ),
      'TYPE_SUBSCRIPTION_SCHEDULE_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SUBSCRIPTION_SCHEDULE_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_schedule.canceled\'',
          'attributes' => 
          array (
            'startLine' => 478,
            'endLine' => 478,
            'startTokenPos' => 3816,
            'startFilePos' => 33247,
            'endTokenPos' => 3816,
            'endFilePos' => 33278,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 478,
        'endLine' => 478,
        'startColumn' => 5,
        'endColumn' => 81,
      ),
      'TYPE_SUBSCRIPTION_SCHEDULE_COMPLETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SUBSCRIPTION_SCHEDULE_COMPLETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_schedule.completed\'',
          'attributes' => 
          array (
            'startLine' => 479,
            'endLine' => 479,
            'startTokenPos' => 3825,
            'startFilePos' => 33331,
            'endTokenPos' => 3825,
            'endFilePos' => 33363,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 479,
        'endLine' => 479,
        'startColumn' => 5,
        'endColumn' => 83,
      ),
      'TYPE_SUBSCRIPTION_SCHEDULE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SUBSCRIPTION_SCHEDULE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_schedule.created\'',
          'attributes' => 
          array (
            'startLine' => 480,
            'endLine' => 480,
            'startTokenPos' => 3834,
            'startFilePos' => 33414,
            'endTokenPos' => 3834,
            'endFilePos' => 33444,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 480,
        'endLine' => 480,
        'startColumn' => 5,
        'endColumn' => 79,
      ),
      'TYPE_SUBSCRIPTION_SCHEDULE_EXPIRING' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SUBSCRIPTION_SCHEDULE_EXPIRING',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_schedule.expiring\'',
          'attributes' => 
          array (
            'startLine' => 481,
            'endLine' => 481,
            'startTokenPos' => 3843,
            'startFilePos' => 33496,
            'endTokenPos' => 3843,
            'endFilePos' => 33527,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 481,
        'endLine' => 481,
        'startColumn' => 5,
        'endColumn' => 81,
      ),
      'TYPE_SUBSCRIPTION_SCHEDULE_RELEASED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SUBSCRIPTION_SCHEDULE_RELEASED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_schedule.released\'',
          'attributes' => 
          array (
            'startLine' => 482,
            'endLine' => 482,
            'startTokenPos' => 3852,
            'startFilePos' => 33579,
            'endTokenPos' => 3852,
            'endFilePos' => 33610,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 482,
        'endLine' => 482,
        'startColumn' => 5,
        'endColumn' => 81,
      ),
      'TYPE_SUBSCRIPTION_SCHEDULE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_SUBSCRIPTION_SCHEDULE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_schedule.updated\'',
          'attributes' => 
          array (
            'startLine' => 483,
            'endLine' => 483,
            'startTokenPos' => 3861,
            'startFilePos' => 33661,
            'endTokenPos' => 3861,
            'endFilePos' => 33691,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 483,
        'endLine' => 483,
        'startColumn' => 5,
        'endColumn' => 79,
      ),
      'TYPE_TAX_RATE_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TAX_RATE_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'tax_rate.created\'',
          'attributes' => 
          array (
            'startLine' => 484,
            'endLine' => 484,
            'startTokenPos' => 3870,
            'startFilePos' => 33729,
            'endTokenPos' => 3870,
            'endFilePos' => 33746,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 484,
        'endLine' => 484,
        'startColumn' => 5,
        'endColumn' => 53,
      ),
      'TYPE_TAX_RATE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TAX_RATE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'tax_rate.updated\'',
          'attributes' => 
          array (
            'startLine' => 485,
            'endLine' => 485,
            'startTokenPos' => 3879,
            'startFilePos' => 33784,
            'endTokenPos' => 3879,
            'endFilePos' => 33801,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 485,
        'endLine' => 485,
        'startColumn' => 5,
        'endColumn' => 53,
      ),
      'TYPE_TAX_SETTINGS_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TAX_SETTINGS_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'tax.settings.updated\'',
          'attributes' => 
          array (
            'startLine' => 486,
            'endLine' => 486,
            'startTokenPos' => 3888,
            'startFilePos' => 33843,
            'endTokenPos' => 3888,
            'endFilePos' => 33864,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 486,
        'endLine' => 486,
        'startColumn' => 5,
        'endColumn' => 61,
      ),
      'TYPE_TERMINAL_READER_ACTION_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TERMINAL_READER_ACTION_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'terminal.reader.action_failed\'',
          'attributes' => 
          array (
            'startLine' => 487,
            'endLine' => 487,
            'startTokenPos' => 3897,
            'startFilePos' => 33915,
            'endTokenPos' => 3897,
            'endFilePos' => 33945,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 487,
        'endLine' => 487,
        'startColumn' => 5,
        'endColumn' => 79,
      ),
      'TYPE_TERMINAL_READER_ACTION_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TERMINAL_READER_ACTION_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'terminal.reader.action_succeeded\'',
          'attributes' => 
          array (
            'startLine' => 488,
            'endLine' => 488,
            'startTokenPos' => 3906,
            'startFilePos' => 33999,
            'endTokenPos' => 3906,
            'endFilePos' => 34032,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 488,
        'endLine' => 488,
        'startColumn' => 5,
        'endColumn' => 85,
      ),
      'TYPE_TEST_HELPERS_TEST_CLOCK_ADVANCING' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TEST_HELPERS_TEST_CLOCK_ADVANCING',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'test_helpers.test_clock.advancing\'',
          'attributes' => 
          array (
            'startLine' => 489,
            'endLine' => 489,
            'startTokenPos' => 3915,
            'startFilePos' => 34087,
            'endTokenPos' => 3915,
            'endFilePos' => 34121,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 489,
        'endLine' => 489,
        'startColumn' => 5,
        'endColumn' => 87,
      ),
      'TYPE_TEST_HELPERS_TEST_CLOCK_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TEST_HELPERS_TEST_CLOCK_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'test_helpers.test_clock.created\'',
          'attributes' => 
          array (
            'startLine' => 490,
            'endLine' => 490,
            'startTokenPos' => 3924,
            'startFilePos' => 34174,
            'endTokenPos' => 3924,
            'endFilePos' => 34206,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 490,
        'endLine' => 490,
        'startColumn' => 5,
        'endColumn' => 83,
      ),
      'TYPE_TEST_HELPERS_TEST_CLOCK_DELETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TEST_HELPERS_TEST_CLOCK_DELETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'test_helpers.test_clock.deleted\'',
          'attributes' => 
          array (
            'startLine' => 491,
            'endLine' => 491,
            'startTokenPos' => 3933,
            'startFilePos' => 34259,
            'endTokenPos' => 3933,
            'endFilePos' => 34291,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 491,
        'endLine' => 491,
        'startColumn' => 5,
        'endColumn' => 83,
      ),
      'TYPE_TEST_HELPERS_TEST_CLOCK_INTERNAL_FAILURE' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TEST_HELPERS_TEST_CLOCK_INTERNAL_FAILURE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'test_helpers.test_clock.internal_failure\'',
          'attributes' => 
          array (
            'startLine' => 492,
            'endLine' => 492,
            'startTokenPos' => 3942,
            'startFilePos' => 34353,
            'endTokenPos' => 3942,
            'endFilePos' => 34394,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 492,
        'endLine' => 492,
        'startColumn' => 5,
        'endColumn' => 101,
      ),
      'TYPE_TEST_HELPERS_TEST_CLOCK_READY' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TEST_HELPERS_TEST_CLOCK_READY',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'test_helpers.test_clock.ready\'',
          'attributes' => 
          array (
            'startLine' => 493,
            'endLine' => 493,
            'startTokenPos' => 3951,
            'startFilePos' => 34445,
            'endTokenPos' => 3951,
            'endFilePos' => 34475,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 493,
        'endLine' => 493,
        'startColumn' => 5,
        'endColumn' => 79,
      ),
      'TYPE_TOPUP_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TOPUP_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'topup.canceled\'',
          'attributes' => 
          array (
            'startLine' => 494,
            'endLine' => 494,
            'startTokenPos' => 3960,
            'startFilePos' => 34511,
            'endTokenPos' => 3960,
            'endFilePos' => 34526,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 494,
        'endLine' => 494,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_TOPUP_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TOPUP_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'topup.created\'',
          'attributes' => 
          array (
            'startLine' => 495,
            'endLine' => 495,
            'startTokenPos' => 3969,
            'startFilePos' => 34561,
            'endTokenPos' => 3969,
            'endFilePos' => 34575,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 495,
        'endLine' => 495,
        'startColumn' => 5,
        'endColumn' => 47,
      ),
      'TYPE_TOPUP_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TOPUP_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'topup.failed\'',
          'attributes' => 
          array (
            'startLine' => 496,
            'endLine' => 496,
            'startTokenPos' => 3978,
            'startFilePos' => 34609,
            'endTokenPos' => 3978,
            'endFilePos' => 34622,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 496,
        'endLine' => 496,
        'startColumn' => 5,
        'endColumn' => 45,
      ),
      'TYPE_TOPUP_REVERSED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TOPUP_REVERSED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'topup.reversed\'',
          'attributes' => 
          array (
            'startLine' => 497,
            'endLine' => 497,
            'startTokenPos' => 3987,
            'startFilePos' => 34658,
            'endTokenPos' => 3987,
            'endFilePos' => 34673,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 497,
        'endLine' => 497,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'TYPE_TOPUP_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TOPUP_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'topup.succeeded\'',
          'attributes' => 
          array (
            'startLine' => 498,
            'endLine' => 498,
            'startTokenPos' => 3996,
            'startFilePos' => 34710,
            'endTokenPos' => 3996,
            'endFilePos' => 34726,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 498,
        'endLine' => 498,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'TYPE_TRANSFER_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TRANSFER_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'transfer.created\'',
          'attributes' => 
          array (
            'startLine' => 499,
            'endLine' => 499,
            'startTokenPos' => 4005,
            'startFilePos' => 34764,
            'endTokenPos' => 4005,
            'endFilePos' => 34781,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 499,
        'endLine' => 499,
        'startColumn' => 5,
        'endColumn' => 53,
      ),
      'TYPE_TRANSFER_REVERSED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TRANSFER_REVERSED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'transfer.reversed\'',
          'attributes' => 
          array (
            'startLine' => 500,
            'endLine' => 500,
            'startTokenPos' => 4014,
            'startFilePos' => 34820,
            'endTokenPos' => 4014,
            'endFilePos' => 34838,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 500,
        'endLine' => 500,
        'startColumn' => 5,
        'endColumn' => 55,
      ),
      'TYPE_TRANSFER_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TRANSFER_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'transfer.updated\'',
          'attributes' => 
          array (
            'startLine' => 501,
            'endLine' => 501,
            'startTokenPos' => 4023,
            'startFilePos' => 34876,
            'endTokenPos' => 4023,
            'endFilePos' => 34893,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 501,
        'endLine' => 501,
        'startColumn' => 5,
        'endColumn' => 53,
      ),
      'TYPE_TREASURY_CREDIT_REVERSAL_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_CREDIT_REVERSAL_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.credit_reversal.created\'',
          'attributes' => 
          array (
            'startLine' => 502,
            'endLine' => 502,
            'startTokenPos' => 4032,
            'startFilePos' => 34947,
            'endTokenPos' => 4032,
            'endFilePos' => 34980,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 502,
        'endLine' => 502,
        'startColumn' => 5,
        'endColumn' => 85,
      ),
      'TYPE_TREASURY_CREDIT_REVERSAL_POSTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_CREDIT_REVERSAL_POSTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.credit_reversal.posted\'',
          'attributes' => 
          array (
            'startLine' => 503,
            'endLine' => 503,
            'startTokenPos' => 4041,
            'startFilePos' => 35033,
            'endTokenPos' => 4041,
            'endFilePos' => 35065,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 503,
        'endLine' => 503,
        'startColumn' => 5,
        'endColumn' => 83,
      ),
      'TYPE_TREASURY_DEBIT_REVERSAL_COMPLETED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_DEBIT_REVERSAL_COMPLETED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.debit_reversal.completed\'',
          'attributes' => 
          array (
            'startLine' => 504,
            'endLine' => 504,
            'startTokenPos' => 4050,
            'startFilePos' => 35120,
            'endTokenPos' => 4050,
            'endFilePos' => 35154,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 504,
        'endLine' => 504,
        'startColumn' => 5,
        'endColumn' => 87,
      ),
      'TYPE_TREASURY_DEBIT_REVERSAL_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_DEBIT_REVERSAL_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.debit_reversal.created\'',
          'attributes' => 
          array (
            'startLine' => 505,
            'endLine' => 505,
            'startTokenPos' => 4059,
            'startFilePos' => 35207,
            'endTokenPos' => 4059,
            'endFilePos' => 35239,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 505,
        'endLine' => 505,
        'startColumn' => 5,
        'endColumn' => 83,
      ),
      'TYPE_TREASURY_DEBIT_REVERSAL_INITIAL_CREDIT_GRANTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_DEBIT_REVERSAL_INITIAL_CREDIT_GRANTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.debit_reversal.initial_credit_granted\'',
          'attributes' => 
          array (
            'startLine' => 506,
            'endLine' => 506,
            'startTokenPos' => 4068,
            'startFilePos' => 35307,
            'endTokenPos' => 4068,
            'endFilePos' => 35354,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 506,
        'endLine' => 506,
        'startColumn' => 5,
        'endColumn' => 113,
      ),
      'TYPE_TREASURY_FINANCIAL_ACCOUNT_CLOSED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_FINANCIAL_ACCOUNT_CLOSED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.financial_account.closed\'',
          'attributes' => 
          array (
            'startLine' => 507,
            'endLine' => 507,
            'startTokenPos' => 4077,
            'startFilePos' => 35409,
            'endTokenPos' => 4077,
            'endFilePos' => 35443,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 507,
        'endLine' => 507,
        'startColumn' => 5,
        'endColumn' => 87,
      ),
      'TYPE_TREASURY_FINANCIAL_ACCOUNT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_FINANCIAL_ACCOUNT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.financial_account.created\'',
          'attributes' => 
          array (
            'startLine' => 508,
            'endLine' => 508,
            'startTokenPos' => 4086,
            'startFilePos' => 35499,
            'endTokenPos' => 4086,
            'endFilePos' => 35534,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 508,
        'endLine' => 508,
        'startColumn' => 5,
        'endColumn' => 89,
      ),
      'TYPE_TREASURY_FINANCIAL_ACCOUNT_FEATURES_STATUS_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_FINANCIAL_ACCOUNT_FEATURES_STATUS_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.financial_account.features_status_updated\'',
          'attributes' => 
          array (
            'startLine' => 509,
            'endLine' => 509,
            'startTokenPos' => 4095,
            'startFilePos' => 35606,
            'endTokenPos' => 4095,
            'endFilePos' => 35657,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 509,
        'endLine' => 509,
        'startColumn' => 5,
        'endColumn' => 121,
      ),
      'TYPE_TREASURY_INBOUND_TRANSFER_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_INBOUND_TRANSFER_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.inbound_transfer.canceled\'',
          'attributes' => 
          array (
            'startLine' => 510,
            'endLine' => 510,
            'startTokenPos' => 4104,
            'startFilePos' => 35713,
            'endTokenPos' => 4104,
            'endFilePos' => 35748,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 510,
        'endLine' => 510,
        'startColumn' => 5,
        'endColumn' => 89,
      ),
      'TYPE_TREASURY_INBOUND_TRANSFER_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_INBOUND_TRANSFER_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.inbound_transfer.created\'',
          'attributes' => 
          array (
            'startLine' => 511,
            'endLine' => 511,
            'startTokenPos' => 4113,
            'startFilePos' => 35803,
            'endTokenPos' => 4113,
            'endFilePos' => 35837,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 511,
        'endLine' => 511,
        'startColumn' => 5,
        'endColumn' => 87,
      ),
      'TYPE_TREASURY_INBOUND_TRANSFER_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_INBOUND_TRANSFER_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.inbound_transfer.failed\'',
          'attributes' => 
          array (
            'startLine' => 512,
            'endLine' => 512,
            'startTokenPos' => 4122,
            'startFilePos' => 35891,
            'endTokenPos' => 4122,
            'endFilePos' => 35924,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 512,
        'endLine' => 512,
        'startColumn' => 5,
        'endColumn' => 85,
      ),
      'TYPE_TREASURY_INBOUND_TRANSFER_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_INBOUND_TRANSFER_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.inbound_transfer.succeeded\'',
          'attributes' => 
          array (
            'startLine' => 513,
            'endLine' => 513,
            'startTokenPos' => 4131,
            'startFilePos' => 35981,
            'endTokenPos' => 4131,
            'endFilePos' => 36017,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 513,
        'endLine' => 513,
        'startColumn' => 5,
        'endColumn' => 91,
      ),
      'TYPE_TREASURY_OUTBOUND_PAYMENT_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_OUTBOUND_PAYMENT_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_payment.canceled\'',
          'attributes' => 
          array (
            'startLine' => 514,
            'endLine' => 514,
            'startTokenPos' => 4140,
            'startFilePos' => 36073,
            'endTokenPos' => 4140,
            'endFilePos' => 36108,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 514,
        'endLine' => 514,
        'startColumn' => 5,
        'endColumn' => 89,
      ),
      'TYPE_TREASURY_OUTBOUND_PAYMENT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_OUTBOUND_PAYMENT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_payment.created\'',
          'attributes' => 
          array (
            'startLine' => 515,
            'endLine' => 515,
            'startTokenPos' => 4149,
            'startFilePos' => 36163,
            'endTokenPos' => 4149,
            'endFilePos' => 36197,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 515,
        'endLine' => 515,
        'startColumn' => 5,
        'endColumn' => 87,
      ),
      'TYPE_TREASURY_OUTBOUND_PAYMENT_EXPECTED_ARRIVAL_DATE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_OUTBOUND_PAYMENT_EXPECTED_ARRIVAL_DATE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_payment.expected_arrival_date_updated\'',
          'attributes' => 
          array (
            'startLine' => 516,
            'endLine' => 516,
            'startTokenPos' => 4158,
            'startFilePos' => 36274,
            'endTokenPos' => 4158,
            'endFilePos' => 36330,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 516,
        'endLine' => 516,
        'startColumn' => 5,
        'endColumn' => 131,
      ),
      'TYPE_TREASURY_OUTBOUND_PAYMENT_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_OUTBOUND_PAYMENT_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_payment.failed\'',
          'attributes' => 
          array (
            'startLine' => 517,
            'endLine' => 517,
            'startTokenPos' => 4167,
            'startFilePos' => 36384,
            'endTokenPos' => 4167,
            'endFilePos' => 36417,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 517,
        'endLine' => 517,
        'startColumn' => 5,
        'endColumn' => 85,
      ),
      'TYPE_TREASURY_OUTBOUND_PAYMENT_POSTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_OUTBOUND_PAYMENT_POSTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_payment.posted\'',
          'attributes' => 
          array (
            'startLine' => 518,
            'endLine' => 518,
            'startTokenPos' => 4176,
            'startFilePos' => 36471,
            'endTokenPos' => 4176,
            'endFilePos' => 36504,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 518,
        'endLine' => 518,
        'startColumn' => 5,
        'endColumn' => 85,
      ),
      'TYPE_TREASURY_OUTBOUND_PAYMENT_RETURNED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_OUTBOUND_PAYMENT_RETURNED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_payment.returned\'',
          'attributes' => 
          array (
            'startLine' => 519,
            'endLine' => 519,
            'startTokenPos' => 4185,
            'startFilePos' => 36560,
            'endTokenPos' => 4185,
            'endFilePos' => 36595,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 519,
        'endLine' => 519,
        'startColumn' => 5,
        'endColumn' => 89,
      ),
      'TYPE_TREASURY_OUTBOUND_PAYMENT_TRACKING_DETAILS_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_OUTBOUND_PAYMENT_TRACKING_DETAILS_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_payment.tracking_details_updated\'',
          'attributes' => 
          array (
            'startLine' => 520,
            'endLine' => 520,
            'startTokenPos' => 4194,
            'startFilePos' => 36667,
            'endTokenPos' => 4194,
            'endFilePos' => 36718,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 520,
        'endLine' => 520,
        'startColumn' => 5,
        'endColumn' => 121,
      ),
      'TYPE_TREASURY_OUTBOUND_TRANSFER_CANCELED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_OUTBOUND_TRANSFER_CANCELED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_transfer.canceled\'',
          'attributes' => 
          array (
            'startLine' => 521,
            'endLine' => 521,
            'startTokenPos' => 4203,
            'startFilePos' => 36775,
            'endTokenPos' => 4203,
            'endFilePos' => 36811,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 521,
        'endLine' => 521,
        'startColumn' => 5,
        'endColumn' => 91,
      ),
      'TYPE_TREASURY_OUTBOUND_TRANSFER_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_OUTBOUND_TRANSFER_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_transfer.created\'',
          'attributes' => 
          array (
            'startLine' => 522,
            'endLine' => 522,
            'startTokenPos' => 4212,
            'startFilePos' => 36867,
            'endTokenPos' => 4212,
            'endFilePos' => 36902,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 522,
        'endLine' => 522,
        'startColumn' => 5,
        'endColumn' => 89,
      ),
      'TYPE_TREASURY_OUTBOUND_TRANSFER_EXPECTED_ARRIVAL_DATE_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_OUTBOUND_TRANSFER_EXPECTED_ARRIVAL_DATE_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_transfer.expected_arrival_date_updated\'',
          'attributes' => 
          array (
            'startLine' => 523,
            'endLine' => 523,
            'startTokenPos' => 4221,
            'startFilePos' => 36980,
            'endTokenPos' => 4221,
            'endFilePos' => 37037,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 523,
        'endLine' => 523,
        'startColumn' => 5,
        'endColumn' => 133,
      ),
      'TYPE_TREASURY_OUTBOUND_TRANSFER_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_OUTBOUND_TRANSFER_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_transfer.failed\'',
          'attributes' => 
          array (
            'startLine' => 524,
            'endLine' => 524,
            'startTokenPos' => 4230,
            'startFilePos' => 37092,
            'endTokenPos' => 4230,
            'endFilePos' => 37126,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 524,
        'endLine' => 524,
        'startColumn' => 5,
        'endColumn' => 87,
      ),
      'TYPE_TREASURY_OUTBOUND_TRANSFER_POSTED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_OUTBOUND_TRANSFER_POSTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_transfer.posted\'',
          'attributes' => 
          array (
            'startLine' => 525,
            'endLine' => 525,
            'startTokenPos' => 4239,
            'startFilePos' => 37181,
            'endTokenPos' => 4239,
            'endFilePos' => 37215,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 525,
        'endLine' => 525,
        'startColumn' => 5,
        'endColumn' => 87,
      ),
      'TYPE_TREASURY_OUTBOUND_TRANSFER_RETURNED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_OUTBOUND_TRANSFER_RETURNED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_transfer.returned\'',
          'attributes' => 
          array (
            'startLine' => 526,
            'endLine' => 526,
            'startTokenPos' => 4248,
            'startFilePos' => 37272,
            'endTokenPos' => 4248,
            'endFilePos' => 37308,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 526,
        'endLine' => 526,
        'startColumn' => 5,
        'endColumn' => 91,
      ),
      'TYPE_TREASURY_OUTBOUND_TRANSFER_TRACKING_DETAILS_UPDATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_OUTBOUND_TRANSFER_TRACKING_DETAILS_UPDATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.outbound_transfer.tracking_details_updated\'',
          'attributes' => 
          array (
            'startLine' => 527,
            'endLine' => 527,
            'startTokenPos' => 4257,
            'startFilePos' => 37381,
            'endTokenPos' => 4257,
            'endFilePos' => 37433,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 527,
        'endLine' => 527,
        'startColumn' => 5,
        'endColumn' => 123,
      ),
      'TYPE_TREASURY_RECEIVED_CREDIT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_RECEIVED_CREDIT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.received_credit.created\'',
          'attributes' => 
          array (
            'startLine' => 528,
            'endLine' => 528,
            'startTokenPos' => 4266,
            'startFilePos' => 37487,
            'endTokenPos' => 4266,
            'endFilePos' => 37520,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 528,
        'endLine' => 528,
        'startColumn' => 5,
        'endColumn' => 85,
      ),
      'TYPE_TREASURY_RECEIVED_CREDIT_FAILED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_RECEIVED_CREDIT_FAILED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.received_credit.failed\'',
          'attributes' => 
          array (
            'startLine' => 529,
            'endLine' => 529,
            'startTokenPos' => 4275,
            'startFilePos' => 37573,
            'endTokenPos' => 4275,
            'endFilePos' => 37605,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 529,
        'endLine' => 529,
        'startColumn' => 5,
        'endColumn' => 83,
      ),
      'TYPE_TREASURY_RECEIVED_CREDIT_SUCCEEDED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_RECEIVED_CREDIT_SUCCEEDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.received_credit.succeeded\'',
          'attributes' => 
          array (
            'startLine' => 530,
            'endLine' => 530,
            'startTokenPos' => 4284,
            'startFilePos' => 37661,
            'endTokenPos' => 4284,
            'endFilePos' => 37696,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 530,
        'endLine' => 530,
        'startColumn' => 5,
        'endColumn' => 89,
      ),
      'TYPE_TREASURY_RECEIVED_DEBIT_CREATED' => 
      array (
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'name' => 'TYPE_TREASURY_RECEIVED_DEBIT_CREATED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'treasury.received_debit.created\'',
          'attributes' => 
          array (
            'startLine' => 531,
            'endLine' => 531,
            'startTokenPos' => 4293,
            'startFilePos' => 37749,
            'endTokenPos' => 4293,
            'endFilePos' => 37781,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 531,
        'endLine' => 531,
        'startColumn' => 5,
        'endColumn' => 83,
      ),
    ),
    'immediateProperties' => 
    array (
    ),
    'immediateMethods' => 
    array (
      'all' => 
      array (
        'name' => 'all',
        'parameters' => 
        array (
          'params' => 
          array (
            'name' => 'params',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 547,
                'endLine' => 547,
                'startTokenPos' => 4310,
                'startFilePos' => 38450,
                'endTokenPos' => 4310,
                'endFilePos' => 38453,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 547,
            'endLine' => 547,
            'startColumn' => 32,
            'endColumn' => 45,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
          'opts' => 
          array (
            'name' => 'opts',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 547,
                'endLine' => 547,
                'startTokenPos' => 4317,
                'startFilePos' => 38464,
                'endTokenPos' => 4317,
                'endFilePos' => 38467,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 547,
            'endLine' => 547,
            'startColumn' => 48,
            'endColumn' => 59,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * List events, going back up to 30 days. Each event data is rendered according to
 * Stripe API version at its creation time, specified in <a
 * href="https://docs.stripe.com/api/events/object">event object</a>
 * <code>api_version</code> attribute (not according to your current Stripe API
 * version or <code>Stripe-Version</code> header).
 *
 * @param null|array $params
 * @param null|array|string $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Collection<\\Stripe\\Event> of ApiResources
 */',
        'startLine' => 547,
        'endLine' => 552,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'currentClassName' => 'Stripe\\Event',
        'aliasName' => NULL,
      ),
      'retrieve' => 
      array (
        'name' => 'retrieve',
        'parameters' => 
        array (
          'id' => 
          array (
            'name' => 'id',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 565,
            'endLine' => 565,
            'startColumn' => 37,
            'endColumn' => 39,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'opts' => 
          array (
            'name' => 'opts',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 565,
                'endLine' => 565,
                'startTokenPos' => 4373,
                'startFilePos' => 39136,
                'endTokenPos' => 4373,
                'endFilePos' => 39139,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 565,
            'endLine' => 565,
            'startColumn' => 42,
            'endColumn' => 53,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Retrieves the details of an event if it was created in the last 30 days. Supply
 * the unique identifier of the event, which you might have received in a webhook.
 *
 * @param array|string $id the ID of the API resource to retrieve, or an options array containing an `id` key
 * @param null|array|string $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Event
 */',
        'startLine' => 565,
        'endLine' => 572,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Event',
        'implementingClassName' => 'Stripe\\Event',
        'currentClassName' => 'Stripe\\Event',
        'aliasName' => NULL,
      ),
    ),
    'traitsData' => 
    array (
      'aliases' => 
      array (
      ),
      'modifiers' => 
      array (
      ),
      'precedences' => 
      array (
      ),
      'hashes' => 
      array (
      ),
    ),
  ),
));