<?php declare(strict_types = 1);

// osfsl-C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/Checkout/Session.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Stripe\Checkout\Session
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-d79dda338ee4d8609ba02bb47e3444792a8b8ec2acd69e3a0e7f75b9dc87bfd8-8.2.12-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Stripe\\Checkout\\Session',
        'filename' => 'C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/Checkout/Session.php',
      ),
    ),
    'namespace' => 'Stripe\\Checkout',
    'name' => 'Stripe\\Checkout\\Session',
    'shortName' => 'Session',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * A Checkout Session represents your customer\'s session as they pay for
 * one-time purchases or subscriptions through <a href="https://stripe.com/docs/payments/checkout">Checkout</a>
 * or <a href="https://stripe.com/docs/payments/payment-links">Payment Links</a>. We recommend creating a
 * new Session each time your customer attempts to pay.
 *
 * Once payment is successful, the Checkout Session will contain a reference
 * to the <a href="https://stripe.com/docs/api/customers">Customer</a>, and either the successful
 * <a href="https://stripe.com/docs/api/payment_intents">PaymentIntent</a> or an active
 * <a href="https://stripe.com/docs/api/subscriptions">Subscription</a>.
 *
 * You can create a Checkout Session on your server and redirect to its URL
 * to begin Checkout.
 *
 * Related guide: <a href="https://stripe.com/docs/checkout/quickstart">Checkout quickstart</a>
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object\'s type. Objects of the same type share the same value.
 * @property null|\\Stripe\\StripeObject $after_expiration When set, provides configuration for actions to take if this Checkout Session expires.
 * @property null|bool $allow_promotion_codes Enables user redeemable promotion codes.
 * @property null|int $amount_subtotal Total of all items before discounts or taxes are applied.
 * @property null|int $amount_total Total of all items after discounts and taxes are applied.
 * @property \\Stripe\\StripeObject $automatic_tax
 * @property null|string $billing_address_collection Describes whether Checkout should collect the customer\'s billing address. Defaults to <code>auto</code>.
 * @property null|string $cancel_url If set, Checkout displays a back button and customers will be directed to this URL if they decide to cancel payment and return to your website.
 * @property null|string $client_reference_id A unique string to reference the Checkout Session. This can be a customer ID, a cart ID, or similar, and can be used to reconcile the Session with your internal systems.
 * @property null|string $client_secret Client secret to be used when initializing Stripe.js embedded checkout.
 * @property null|\\Stripe\\StripeObject $consent Results of <code>consent_collection</code> for this session.
 * @property null|\\Stripe\\StripeObject $consent_collection When set, provides configuration for the Checkout Session to gather active consent from customers.
 * @property int $created Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property null|string $currency Three-letter <a href="https://www.iso.org/iso-4217-currency-codes.html">ISO currency code</a>, in lowercase. Must be a <a href="https://stripe.com/docs/currencies">supported currency</a>.
 * @property null|\\Stripe\\StripeObject $currency_conversion Currency conversion details for <a href="https://docs.stripe.com/payments/checkout/adaptive-pricing">Adaptive Pricing</a> sessions
 * @property \\Stripe\\StripeObject[] $custom_fields Collect additional information from your customer using custom fields. Up to 3 fields are supported.
 * @property \\Stripe\\StripeObject $custom_text
 * @property null|string|\\Stripe\\Customer $customer The ID of the customer for this Session. For Checkout Sessions in <code>subscription</code> mode or Checkout Sessions with <code>customer_creation</code> set as <code>always</code> in <code>payment</code> mode, Checkout will create a new customer object based on information provided during the payment flow unless an existing customer was provided when the Session was created.
 * @property null|string $customer_creation Configure whether a Checkout Session creates a Customer when the Checkout Session completes.
 * @property null|\\Stripe\\StripeObject $customer_details The customer details including the customer\'s tax exempt status and the customer\'s tax IDs. Customer\'s address details are not present on Sessions in <code>setup</code> mode.
 * @property null|string $customer_email If provided, this value will be used when the Customer object is created. If not provided, customers will be asked to enter their email address. Use this parameter to prefill customer data if you already have an email on file. To access information about the customer once the payment flow is complete, use the <code>customer</code> attribute.
 * @property int $expires_at The timestamp at which the Checkout Session will expire.
 * @property null|string|\\Stripe\\Invoice $invoice ID of the invoice created by the Checkout Session, if it exists.
 * @property null|\\Stripe\\StripeObject $invoice_creation Details on the state of invoice creation for the Checkout Session.
 * @property null|\\Stripe\\Collection<\\Stripe\\LineItem> $line_items The line items purchased by the customer.
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property null|string $locale The IETF language tag of the locale Checkout is displayed in. If blank or <code>auto</code>, the browser\'s locale is used.
 * @property null|\\Stripe\\StripeObject $metadata Set of <a href="https://stripe.com/docs/api/metadata">key-value pairs</a> that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
 * @property string $mode The mode of the Checkout Session.
 * @property null|string|\\Stripe\\PaymentIntent $payment_intent The ID of the PaymentIntent for Checkout Sessions in <code>payment</code> mode. You can\'t confirm or cancel the PaymentIntent for a Checkout Session. To cancel, <a href="https://stripe.com/docs/api/checkout/sessions/expire">expire the Checkout Session</a> instead.
 * @property null|string|\\Stripe\\PaymentLink $payment_link The ID of the Payment Link that created this Session.
 * @property null|string $payment_method_collection Configure whether a Checkout Session should collect a payment method. Defaults to <code>always</code>.
 * @property null|\\Stripe\\StripeObject $payment_method_configuration_details Information about the payment method configuration used for this Checkout session if using dynamic payment methods.
 * @property null|\\Stripe\\StripeObject $payment_method_options Payment-method-specific configuration for the PaymentIntent or SetupIntent of this CheckoutSession.
 * @property string[] $payment_method_types A list of the types of payment methods (e.g. card) this Checkout Session is allowed to accept.
 * @property string $payment_status The payment status of the Checkout Session, one of <code>paid</code>, <code>unpaid</code>, or <code>no_payment_required</code>. You can use this value to decide when to fulfill your customer\'s order.
 * @property null|\\Stripe\\StripeObject $phone_number_collection
 * @property null|string $recovered_from The ID of the original expired Checkout Session that triggered the recovery flow.
 * @property null|string $redirect_on_completion This parameter applies to <code>ui_mode: embedded</code>. Learn more about the <a href="https://stripe.com/docs/payments/checkout/custom-success-page?payment-ui=embedded-form">redirect behavior</a> of embedded sessions. Defaults to <code>always</code>.
 * @property null|string $return_url Applies to Checkout Sessions with <code>ui_mode: embedded</code>. The URL to redirect your customer back to after they authenticate or cancel their payment on the payment method\'s app or site.
 * @property null|\\Stripe\\StripeObject $saved_payment_method_options Controls saved payment method settings for the session. Only available in <code>payment</code> and <code>subscription</code> mode.
 * @property null|string|\\Stripe\\SetupIntent $setup_intent The ID of the SetupIntent for Checkout Sessions in <code>setup</code> mode. You can\'t confirm or cancel the SetupIntent for a Checkout Session. To cancel, <a href="https://stripe.com/docs/api/checkout/sessions/expire">expire the Checkout Session</a> instead.
 * @property null|\\Stripe\\StripeObject $shipping_address_collection When set, provides configuration for Checkout to collect a shipping address from a customer.
 * @property null|\\Stripe\\StripeObject $shipping_cost The details of the customer cost of shipping, including the customer chosen ShippingRate.
 * @property null|\\Stripe\\StripeObject $shipping_details Shipping information for this Checkout Session.
 * @property \\Stripe\\StripeObject[] $shipping_options The shipping rate options applied to this Session.
 * @property null|string $status The status of the Checkout Session, one of <code>open</code>, <code>complete</code>, or <code>expired</code>.
 * @property null|string $submit_type Describes the type of transaction being performed by Checkout in order to customize relevant text on the page, such as the submit button. <code>submit_type</code> can only be specified on Checkout Sessions in <code>payment</code> mode. If blank or <code>auto</code>, <code>pay</code> is used.
 * @property null|string|\\Stripe\\Subscription $subscription The ID of the subscription for Checkout Sessions in <code>subscription</code> mode.
 * @property null|string $success_url The URL the customer will be directed to after the payment or subscription creation is successful.
 * @property null|\\Stripe\\StripeObject $tax_id_collection
 * @property null|\\Stripe\\StripeObject $total_details Tax and discount details for the computed total amount.
 * @property null|string $ui_mode The UI mode of the Session. Defaults to <code>hosted</code>.
 * @property null|string $url The URL to the Checkout Session. Redirect customers to this URL to take them to Checkout. If you’re using <a href="https://stripe.com/docs/payments/checkout/custom-domains">Custom Domains</a>, the URL will use your subdomain. Otherwise, it’ll use <code>checkout.stripe.com.</code> This value is only present when the session is active.
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 79,
    'endLine' => 234,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Stripe\\ApiResource',
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
      0 => 'Stripe\\ApiOperations\\Update',
    ),
    'immediateConstants' => 
    array (
      'OBJECT_NAME' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'OBJECT_NAME',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'checkout.session\'',
          'attributes' => 
          array (
            'startLine' => 81,
            'endLine' => 81,
            'startTokenPos' => 27,
            'startFilePos' => 10132,
            'endTokenPos' => 27,
            'endFilePos' => 10149,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 81,
        'endLine' => 81,
        'startColumn' => 5,
        'endColumn' => 43,
      ),
      'BILLING_ADDRESS_COLLECTION_AUTO' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'BILLING_ADDRESS_COLLECTION_AUTO',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'auto\'',
          'attributes' => 
          array (
            'startLine' => 85,
            'endLine' => 85,
            'startTokenPos' => 41,
            'startFilePos' => 10240,
            'endTokenPos' => 41,
            'endFilePos' => 10245,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 85,
        'endLine' => 85,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'BILLING_ADDRESS_COLLECTION_REQUIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'BILLING_ADDRESS_COLLECTION_REQUIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'required\'',
          'attributes' => 
          array (
            'startLine' => 86,
            'endLine' => 86,
            'startTokenPos' => 50,
            'startFilePos' => 10297,
            'endTokenPos' => 50,
            'endFilePos' => 10306,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 86,
        'endLine' => 86,
        'startColumn' => 5,
        'endColumn' => 59,
      ),
      'CUSTOMER_CREATION_ALWAYS' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'CUSTOMER_CREATION_ALWAYS',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'always\'',
          'attributes' => 
          array (
            'startLine' => 88,
            'endLine' => 88,
            'startTokenPos' => 59,
            'startFilePos' => 10349,
            'endTokenPos' => 59,
            'endFilePos' => 10356,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 88,
        'endLine' => 88,
        'startColumn' => 5,
        'endColumn' => 46,
      ),
      'CUSTOMER_CREATION_IF_REQUIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'CUSTOMER_CREATION_IF_REQUIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'if_required\'',
          'attributes' => 
          array (
            'startLine' => 89,
            'endLine' => 89,
            'startTokenPos' => 68,
            'startFilePos' => 10402,
            'endTokenPos' => 68,
            'endFilePos' => 10414,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 89,
        'endLine' => 89,
        'startColumn' => 5,
        'endColumn' => 56,
      ),
      'MODE_PAYMENT' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'MODE_PAYMENT',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'payment\'',
          'attributes' => 
          array (
            'startLine' => 91,
            'endLine' => 91,
            'startTokenPos' => 77,
            'startFilePos' => 10445,
            'endTokenPos' => 77,
            'endFilePos' => 10453,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 91,
        'endLine' => 91,
        'startColumn' => 5,
        'endColumn' => 35,
      ),
      'MODE_SETUP' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'MODE_SETUP',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'setup\'',
          'attributes' => 
          array (
            'startLine' => 92,
            'endLine' => 92,
            'startTokenPos' => 86,
            'startFilePos' => 10480,
            'endTokenPos' => 86,
            'endFilePos' => 10486,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 92,
        'endLine' => 92,
        'startColumn' => 5,
        'endColumn' => 31,
      ),
      'MODE_SUBSCRIPTION' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'MODE_SUBSCRIPTION',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription\'',
          'attributes' => 
          array (
            'startLine' => 93,
            'endLine' => 93,
            'startTokenPos' => 95,
            'startFilePos' => 10520,
            'endTokenPos' => 95,
            'endFilePos' => 10533,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 93,
        'endLine' => 93,
        'startColumn' => 5,
        'endColumn' => 45,
      ),
      'PAYMENT_METHOD_COLLECTION_ALWAYS' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'PAYMENT_METHOD_COLLECTION_ALWAYS',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'always\'',
          'attributes' => 
          array (
            'startLine' => 95,
            'endLine' => 95,
            'startTokenPos' => 104,
            'startFilePos' => 10584,
            'endTokenPos' => 104,
            'endFilePos' => 10591,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 95,
        'endLine' => 95,
        'startColumn' => 5,
        'endColumn' => 54,
      ),
      'PAYMENT_METHOD_COLLECTION_IF_REQUIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'PAYMENT_METHOD_COLLECTION_IF_REQUIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'if_required\'',
          'attributes' => 
          array (
            'startLine' => 96,
            'endLine' => 96,
            'startTokenPos' => 113,
            'startFilePos' => 10645,
            'endTokenPos' => 113,
            'endFilePos' => 10657,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 96,
        'endLine' => 96,
        'startColumn' => 5,
        'endColumn' => 64,
      ),
      'PAYMENT_STATUS_NO_PAYMENT_REQUIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'PAYMENT_STATUS_NO_PAYMENT_REQUIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'no_payment_required\'',
          'attributes' => 
          array (
            'startLine' => 98,
            'endLine' => 98,
            'startTokenPos' => 122,
            'startFilePos' => 10710,
            'endTokenPos' => 122,
            'endFilePos' => 10730,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 98,
        'endLine' => 98,
        'startColumn' => 5,
        'endColumn' => 69,
      ),
      'PAYMENT_STATUS_PAID' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'PAYMENT_STATUS_PAID',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'paid\'',
          'attributes' => 
          array (
            'startLine' => 99,
            'endLine' => 99,
            'startTokenPos' => 131,
            'startFilePos' => 10766,
            'endTokenPos' => 131,
            'endFilePos' => 10771,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 99,
        'endLine' => 99,
        'startColumn' => 5,
        'endColumn' => 39,
      ),
      'PAYMENT_STATUS_UNPAID' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'PAYMENT_STATUS_UNPAID',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'unpaid\'',
          'attributes' => 
          array (
            'startLine' => 100,
            'endLine' => 100,
            'startTokenPos' => 140,
            'startFilePos' => 10809,
            'endTokenPos' => 140,
            'endFilePos' => 10816,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 100,
        'endLine' => 100,
        'startColumn' => 5,
        'endColumn' => 43,
      ),
      'REDIRECT_ON_COMPLETION_ALWAYS' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'REDIRECT_ON_COMPLETION_ALWAYS',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'always\'',
          'attributes' => 
          array (
            'startLine' => 102,
            'endLine' => 102,
            'startTokenPos' => 149,
            'startFilePos' => 10864,
            'endTokenPos' => 149,
            'endFilePos' => 10871,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 102,
        'endLine' => 102,
        'startColumn' => 5,
        'endColumn' => 51,
      ),
      'REDIRECT_ON_COMPLETION_IF_REQUIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'REDIRECT_ON_COMPLETION_IF_REQUIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'if_required\'',
          'attributes' => 
          array (
            'startLine' => 103,
            'endLine' => 103,
            'startTokenPos' => 158,
            'startFilePos' => 10922,
            'endTokenPos' => 158,
            'endFilePos' => 10934,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 103,
        'endLine' => 103,
        'startColumn' => 5,
        'endColumn' => 61,
      ),
      'REDIRECT_ON_COMPLETION_NEVER' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'REDIRECT_ON_COMPLETION_NEVER',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'never\'',
          'attributes' => 
          array (
            'startLine' => 104,
            'endLine' => 104,
            'startTokenPos' => 167,
            'startFilePos' => 10979,
            'endTokenPos' => 167,
            'endFilePos' => 10985,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 104,
        'endLine' => 104,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'STATUS_COMPLETE' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'STATUS_COMPLETE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'complete\'',
          'attributes' => 
          array (
            'startLine' => 106,
            'endLine' => 106,
            'startTokenPos' => 176,
            'startFilePos' => 11019,
            'endTokenPos' => 176,
            'endFilePos' => 11028,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 106,
        'endLine' => 106,
        'startColumn' => 5,
        'endColumn' => 39,
      ),
      'STATUS_EXPIRED' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'STATUS_EXPIRED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'expired\'',
          'attributes' => 
          array (
            'startLine' => 107,
            'endLine' => 107,
            'startTokenPos' => 185,
            'startFilePos' => 11059,
            'endTokenPos' => 185,
            'endFilePos' => 11067,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 107,
        'endLine' => 107,
        'startColumn' => 5,
        'endColumn' => 37,
      ),
      'STATUS_OPEN' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'STATUS_OPEN',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'open\'',
          'attributes' => 
          array (
            'startLine' => 108,
            'endLine' => 108,
            'startTokenPos' => 194,
            'startFilePos' => 11095,
            'endTokenPos' => 194,
            'endFilePos' => 11100,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 108,
        'endLine' => 108,
        'startColumn' => 5,
        'endColumn' => 31,
      ),
      'SUBMIT_TYPE_AUTO' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'SUBMIT_TYPE_AUTO',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'auto\'',
          'attributes' => 
          array (
            'startLine' => 110,
            'endLine' => 110,
            'startTokenPos' => 203,
            'startFilePos' => 11135,
            'endTokenPos' => 203,
            'endFilePos' => 11140,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 110,
        'endLine' => 110,
        'startColumn' => 5,
        'endColumn' => 36,
      ),
      'SUBMIT_TYPE_BOOK' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'SUBMIT_TYPE_BOOK',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'book\'',
          'attributes' => 
          array (
            'startLine' => 111,
            'endLine' => 111,
            'startTokenPos' => 212,
            'startFilePos' => 11173,
            'endTokenPos' => 212,
            'endFilePos' => 11178,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 111,
        'endLine' => 111,
        'startColumn' => 5,
        'endColumn' => 36,
      ),
      'SUBMIT_TYPE_DONATE' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'SUBMIT_TYPE_DONATE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'donate\'',
          'attributes' => 
          array (
            'startLine' => 112,
            'endLine' => 112,
            'startTokenPos' => 221,
            'startFilePos' => 11213,
            'endTokenPos' => 221,
            'endFilePos' => 11220,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 112,
        'endLine' => 112,
        'startColumn' => 5,
        'endColumn' => 40,
      ),
      'SUBMIT_TYPE_PAY' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'SUBMIT_TYPE_PAY',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'pay\'',
          'attributes' => 
          array (
            'startLine' => 113,
            'endLine' => 113,
            'startTokenPos' => 230,
            'startFilePos' => 11252,
            'endTokenPos' => 230,
            'endFilePos' => 11256,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 113,
        'endLine' => 113,
        'startColumn' => 5,
        'endColumn' => 34,
      ),
      'UI_MODE_EMBEDDED' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'UI_MODE_EMBEDDED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'embedded\'',
          'attributes' => 
          array (
            'startLine' => 115,
            'endLine' => 115,
            'startTokenPos' => 239,
            'startFilePos' => 11291,
            'endTokenPos' => 239,
            'endFilePos' => 11300,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 115,
        'endLine' => 115,
        'startColumn' => 5,
        'endColumn' => 40,
      ),
      'UI_MODE_HOSTED' => 
      array (
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'name' => 'UI_MODE_HOSTED',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'hosted\'',
          'attributes' => 
          array (
            'startLine' => 116,
            'endLine' => 116,
            'startTokenPos' => 248,
            'startFilePos' => 11331,
            'endTokenPos' => 248,
            'endFilePos' => 11338,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 116,
        'endLine' => 116,
        'startColumn' => 5,
        'endColumn' => 36,
      ),
    ),
    'immediateProperties' => 
    array (
    ),
    'immediateMethods' => 
    array (
      'create' => 
      array (
        'name' => 'create',
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
                'startLine' => 128,
                'endLine' => 128,
                'startTokenPos' => 265,
                'startFilePos' => 11675,
                'endTokenPos' => 265,
                'endFilePos' => 11678,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 128,
            'endLine' => 128,
            'startColumn' => 35,
            'endColumn' => 48,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
          'options' => 
          array (
            'name' => 'options',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 128,
                'endLine' => 128,
                'startTokenPos' => 272,
                'startFilePos' => 11692,
                'endTokenPos' => 272,
                'endFilePos' => 11695,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 128,
            'endLine' => 128,
            'startColumn' => 51,
            'endColumn' => 65,
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
 * Creates a Session object.
 *
 * @param null|array $params
 * @param null|array|string $options
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Checkout\\Session the created resource
 */',
        'startLine' => 128,
        'endLine' => 138,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe\\Checkout',
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'currentClassName' => 'Stripe\\Checkout\\Session',
        'aliasName' => NULL,
      ),
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
                'startLine' => 150,
                'endLine' => 150,
                'startTokenPos' => 369,
                'startFilePos' => 12385,
                'endTokenPos' => 369,
                'endFilePos' => 12388,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 150,
            'endLine' => 150,
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
                'startLine' => 150,
                'endLine' => 150,
                'startTokenPos' => 376,
                'startFilePos' => 12399,
                'endTokenPos' => 376,
                'endFilePos' => 12402,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 150,
            'endLine' => 150,
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
 * Returns a list of Checkout Sessions.
 *
 * @param null|array $params
 * @param null|array|string $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Collection<\\Stripe\\Checkout\\Session> of ApiResources
 */',
        'startLine' => 150,
        'endLine' => 155,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe\\Checkout',
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'currentClassName' => 'Stripe\\Checkout\\Session',
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
            'startLine' => 167,
            'endLine' => 167,
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
                'startLine' => 167,
                'endLine' => 167,
                'startTokenPos' => 432,
                'startFilePos' => 12942,
                'endTokenPos' => 432,
                'endFilePos' => 12945,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 167,
            'endLine' => 167,
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
 * Retrieves a Session object.
 *
 * @param array|string $id the ID of the API resource to retrieve, or an options array containing an `id` key
 * @param null|array|string $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Checkout\\Session
 */',
        'startLine' => 167,
        'endLine' => 174,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe\\Checkout',
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'currentClassName' => 'Stripe\\Checkout\\Session',
        'aliasName' => NULL,
      ),
      'update' => 
      array (
        'name' => 'update',
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
            'startLine' => 187,
            'endLine' => 187,
            'startColumn' => 35,
            'endColumn' => 37,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'params' => 
          array (
            'name' => 'params',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 187,
                'endLine' => 187,
                'startTokenPos' => 495,
                'startFilePos' => 13522,
                'endTokenPos' => 495,
                'endFilePos' => 13525,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 187,
            'endLine' => 187,
            'startColumn' => 40,
            'endColumn' => 53,
            'parameterIndex' => 1,
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
                'startLine' => 187,
                'endLine' => 187,
                'startTokenPos' => 502,
                'startFilePos' => 13536,
                'endTokenPos' => 502,
                'endFilePos' => 13539,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 187,
            'endLine' => 187,
            'startColumn' => 56,
            'endColumn' => 67,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Updates a Session object.
 *
 * @param string $id the ID of the resource to update
 * @param null|array $params
 * @param null|array|string $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Checkout\\Session the updated resource
 */',
        'startLine' => 187,
        'endLine' => 197,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe\\Checkout',
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'currentClassName' => 'Stripe\\Checkout\\Session',
        'aliasName' => NULL,
      ),
      'expire' => 
      array (
        'name' => 'expire',
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
                'startLine' => 207,
                'endLine' => 207,
                'startTokenPos' => 598,
                'startFilePos' => 14159,
                'endTokenPos' => 598,
                'endFilePos' => 14162,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 207,
            'endLine' => 207,
            'startColumn' => 28,
            'endColumn' => 41,
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
                'startLine' => 207,
                'endLine' => 207,
                'startTokenPos' => 605,
                'startFilePos' => 14173,
                'endTokenPos' => 605,
                'endFilePos' => 14176,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 207,
            'endLine' => 207,
            'startColumn' => 44,
            'endColumn' => 55,
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
 * @param null|array $params
 * @param null|array|string $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Checkout\\Session the expired session
 */',
        'startLine' => 207,
        'endLine' => 214,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Checkout',
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'currentClassName' => 'Stripe\\Checkout\\Session',
        'aliasName' => NULL,
      ),
      'allLineItems' => 
      array (
        'name' => 'allLineItems',
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
            'startLine' => 225,
            'endLine' => 225,
            'startColumn' => 41,
            'endColumn' => 43,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'params' => 
          array (
            'name' => 'params',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 225,
                'endLine' => 225,
                'startTokenPos' => 687,
                'startFilePos' => 14732,
                'endTokenPos' => 687,
                'endFilePos' => 14735,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 225,
            'endLine' => 225,
            'startColumn' => 46,
            'endColumn' => 59,
            'parameterIndex' => 1,
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
                'startLine' => 225,
                'endLine' => 225,
                'startTokenPos' => 694,
                'startFilePos' => 14746,
                'endTokenPos' => 694,
                'endFilePos' => 14749,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 225,
            'endLine' => 225,
            'startColumn' => 62,
            'endColumn' => 73,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * @param string $id
 * @param null|array $params
 * @param null|array|string $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Collection<\\Stripe\\LineItem> list of line items
 */',
        'startLine' => 225,
        'endLine' => 233,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe\\Checkout',
        'declaringClassName' => 'Stripe\\Checkout\\Session',
        'implementingClassName' => 'Stripe\\Checkout\\Session',
        'currentClassName' => 'Stripe\\Checkout\\Session',
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