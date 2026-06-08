<?php declare(strict_types = 1);

// osfsl-C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/Invoice.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Stripe\Invoice
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-ed5554bbd5001f0c49ab58338d121c732ec98d033d4a4922006f5e73320612f1-8.2.12-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Stripe\\Invoice',
        'filename' => 'C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/Invoice.php',
      ),
    ),
    'namespace' => 'Stripe',
    'name' => 'Stripe\\Invoice',
    'shortName' => 'Invoice',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * Invoices are statements of amounts owed by a customer, and are either
 * generated one-off, or generated periodically from a subscription.
 *
 * They contain <a href="https://stripe.com/docs/api#invoiceitems">invoice items</a>, and proration adjustments
 * that may be caused by subscription upgrades/downgrades (if necessary).
 *
 * If your invoice is configured to be billed through automatic charges,
 * Stripe automatically finalizes your invoice and attempts payment. Note
 * that finalizing the invoice,
 * <a href="https://stripe.com/docs/invoicing/integration/automatic-advancement-collection">when automatic</a>, does
 * not happen immediately as the invoice is created. Stripe waits
 * until one hour after the last webhook was successfully sent (or the last
 * webhook timed out after failing). If you (and the platforms you may have
 * connected to) have no webhooks configured, Stripe waits one hour after
 * creation to finalize the invoice.
 *
 * If your invoice is configured to be billed by sending an email, then based on your
 * <a href="https://dashboard.stripe.com/account/billing/automatic">email settings</a>,
 * Stripe will email the invoice to your customer and await payment. These
 * emails can contain a link to a hosted page to pay the invoice.
 *
 * Stripe applies any customer credit on the account before determining the
 * amount due for the invoice (i.e., the amount that will be actually
 * charged). If the amount due for the invoice is less than Stripe\'s <a href="/docs/currencies#minimum-and-maximum-charge-amounts">minimum allowed charge
 * per currency</a>, the
 * invoice is automatically marked paid, and we add the amount due to the
 * customer\'s credit balance which is applied to the next invoice.
 *
 * More details on the customer\'s credit balance are
 * <a href="https://stripe.com/docs/billing/customer/balance">here</a>.
 *
 * Related guide: <a href="https://stripe.com/docs/billing/invoices/sending">Send invoices to customers</a>
 *
 * @property null|string $id Unique identifier for the object. This property is always present unless the invoice is an upcoming invoice. See <a href="https://stripe.com/docs/api/invoices/upcoming">Retrieve an upcoming invoice</a> for more details.
 * @property string $object String representing the object\'s type. Objects of the same type share the same value.
 * @property null|string $account_country The country of the business associated with this invoice, most often the business creating the invoice.
 * @property null|string $account_name The public name of the business associated with this invoice, most often the business creating the invoice.
 * @property null|(string|\\Stripe\\TaxId)[] $account_tax_ids The account tax IDs associated with the invoice. Only editable when the invoice is a draft.
 * @property int $amount_due Final amount due at this time for this invoice. If the invoice\'s total is smaller than the minimum charge amount, for example, or if there is account credit that can be applied to the invoice, the <code>amount_due</code> may be 0. If there is a positive <code>starting_balance</code> for the invoice (the customer owes money), the <code>amount_due</code> will also take that into account. The charge that gets generated for the invoice will be for the amount specified in <code>amount_due</code>.
 * @property int $amount_paid The amount, in cents (or local equivalent), that was paid.
 * @property int $amount_remaining The difference between amount_due and amount_paid, in cents (or local equivalent).
 * @property int $amount_shipping This is the sum of all the shipping amounts.
 * @property null|string|\\Stripe\\Application $application ID of the Connect Application that created the invoice.
 * @property null|int $application_fee_amount The fee in cents (or local equivalent) that will be applied to the invoice and transferred to the application owner\'s Stripe account when the invoice is paid.
 * @property int $attempt_count Number of payment attempts made for this invoice, from the perspective of the payment retry schedule. Any payment attempt counts as the first attempt, and subsequently only automatic retries increment the attempt count. In other words, manual payment attempts after the first attempt do not affect the retry schedule. If a failure is returned with a non-retryable return code, the invoice can no longer be retried unless a new payment method is obtained. Retries will continue to be scheduled, and attempt_count will continue to increment, but retries will only be executed if a new payment method is obtained.
 * @property bool $attempted Whether an attempt has been made to pay the invoice. An invoice is not attempted until 1 hour after the <code>invoice.created</code> webhook, for example, so you might not want to display that invoice as unpaid to your users.
 * @property null|bool $auto_advance Controls whether Stripe performs <a href="https://stripe.com/docs/invoicing/integration/automatic-advancement-collection">automatic collection</a> of the invoice. If <code>false</code>, the invoice\'s state doesn\'t automatically advance without an explicit action.
 * @property \\Stripe\\StripeObject $automatic_tax
 * @property null|int $automatically_finalizes_at The time when this invoice is currently scheduled to be automatically finalized. The field will be <code>null</code> if the invoice is not scheduled to finalize in the future. If the invoice is not in the draft state, this field will always be <code>null</code> - see <code>finalized_at</code> for the time when an already-finalized invoice was finalized.
 * @property null|string $billing_reason <p>Indicates the reason why the invoice was created.</p><p>* <code>manual</code>: Unrelated to a subscription, for example, created via the invoice editor. * <code>subscription</code>: No longer in use. Applies to subscriptions from before May 2018 where no distinction was made between updates, cycles, and thresholds. * <code>subscription_create</code>: A new subscription was created. * <code>subscription_cycle</code>: A subscription advanced into a new period. * <code>subscription_threshold</code>: A subscription reached a billing threshold. * <code>subscription_update</code>: A subscription was updated. * <code>upcoming</code>: Reserved for simulated invoices, per the upcoming invoice endpoint.</p>
 * @property null|string|\\Stripe\\Charge $charge ID of the latest charge generated for this invoice, if any.
 * @property string $collection_method Either <code>charge_automatically</code>, or <code>send_invoice</code>. When charging automatically, Stripe will attempt to pay this invoice using the default source attached to the customer. When sending an invoice, Stripe will email this invoice to the customer with payment instructions.
 * @property int $created Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property string $currency Three-letter <a href="https://www.iso.org/iso-4217-currency-codes.html">ISO currency code</a>, in lowercase. Must be a <a href="https://stripe.com/docs/currencies">supported currency</a>.
 * @property null|\\Stripe\\StripeObject[] $custom_fields Custom fields displayed on the invoice.
 * @property null|string|\\Stripe\\Customer $customer The ID of the customer who will be billed.
 * @property null|\\Stripe\\StripeObject $customer_address The customer\'s address. Until the invoice is finalized, this field will equal <code>customer.address</code>. Once the invoice is finalized, this field will no longer be updated.
 * @property null|string $customer_email The customer\'s email. Until the invoice is finalized, this field will equal <code>customer.email</code>. Once the invoice is finalized, this field will no longer be updated.
 * @property null|string $customer_name The customer\'s name. Until the invoice is finalized, this field will equal <code>customer.name</code>. Once the invoice is finalized, this field will no longer be updated.
 * @property null|string $customer_phone The customer\'s phone number. Until the invoice is finalized, this field will equal <code>customer.phone</code>. Once the invoice is finalized, this field will no longer be updated.
 * @property null|\\Stripe\\StripeObject $customer_shipping The customer\'s shipping information. Until the invoice is finalized, this field will equal <code>customer.shipping</code>. Once the invoice is finalized, this field will no longer be updated.
 * @property null|string $customer_tax_exempt The customer\'s tax exempt status. Until the invoice is finalized, this field will equal <code>customer.tax_exempt</code>. Once the invoice is finalized, this field will no longer be updated.
 * @property null|\\Stripe\\StripeObject[] $customer_tax_ids The customer\'s tax IDs. Until the invoice is finalized, this field will contain the same tax IDs as <code>customer.tax_ids</code>. Once the invoice is finalized, this field will no longer be updated.
 * @property null|string|\\Stripe\\PaymentMethod $default_payment_method ID of the default payment method for the invoice. It must belong to the customer associated with the invoice. If not set, defaults to the subscription\'s default payment method, if any, or to the default payment method in the customer\'s invoice settings.
 * @property null|string|\\Stripe\\Account|\\Stripe\\BankAccount|\\Stripe\\Card|\\Stripe\\Source $default_source ID of the default payment source for the invoice. It must belong to the customer associated with the invoice and be in a chargeable state. If not set, defaults to the subscription\'s default source, if any, or to the customer\'s default source.
 * @property \\Stripe\\TaxRate[] $default_tax_rates The tax rates applied to this invoice, if any.
 * @property null|string $description An arbitrary string attached to the object. Often useful for displaying to users. Referenced as \'memo\' in the Dashboard.
 * @property null|\\Stripe\\Discount $discount Describes the current discount applied to this invoice, if there is one. Not populated if there are multiple discounts.
 * @property (string|\\Stripe\\Discount)[] $discounts The discounts applied to the invoice. Line item discounts are applied before invoice discounts. Use <code>expand[]=discounts</code> to expand each discount.
 * @property null|int $due_date The date on which payment for this invoice is due. This value will be <code>null</code> for invoices where <code>collection_method=charge_automatically</code>.
 * @property null|int $effective_at The date when this invoice is in effect. Same as <code>finalized_at</code> unless overwritten. When defined, this value replaces the system-generated \'Date of issue\' printed on the invoice PDF and receipt.
 * @property null|int $ending_balance Ending customer balance after the invoice is finalized. Invoices are finalized approximately an hour after successful webhook delivery or when payment collection is attempted for the invoice. If the invoice has not been finalized yet, this will be null.
 * @property null|string $footer Footer displayed on the invoice.
 * @property null|\\Stripe\\StripeObject $from_invoice Details of the invoice that was cloned. See the <a href="https://stripe.com/docs/invoicing/invoice-revisions">revision documentation</a> for more details.
 * @property null|string $hosted_invoice_url The URL for the hosted invoice page, which allows customers to view and pay an invoice. If the invoice has not been finalized yet, this will be null.
 * @property null|string $invoice_pdf The link to download the PDF for the invoice. If the invoice has not been finalized yet, this will be null.
 * @property \\Stripe\\StripeObject $issuer
 * @property null|\\Stripe\\StripeObject $last_finalization_error The error encountered during the previous attempt to finalize the invoice. This field is cleared when the invoice is successfully finalized.
 * @property null|string|\\Stripe\\Invoice $latest_revision The ID of the most recent non-draft revision of this invoice
 * @property \\Stripe\\Collection<\\Stripe\\InvoiceLineItem> $lines The individual line items that make up the invoice. <code>lines</code> is sorted as follows: (1) pending invoice items (including prorations) in reverse chronological order, (2) subscription items in reverse chronological order, and (3) invoice items added after invoice creation in chronological order.
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property null|\\Stripe\\StripeObject $metadata Set of <a href="https://stripe.com/docs/api/metadata">key-value pairs</a> that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
 * @property null|int $next_payment_attempt The time at which payment will next be attempted. This value will be <code>null</code> for invoices where <code>collection_method=send_invoice</code>.
 * @property null|string $number A unique, identifying string that appears on emails sent to the customer for this invoice. This starts with the customer\'s unique invoice_prefix if it is specified.
 * @property null|string|\\Stripe\\Account $on_behalf_of The account (if any) for which the funds of the invoice payment are intended. If set, the invoice will be presented with the branding and support information of the specified account. See the <a href="https://stripe.com/docs/billing/invoices/connect">Invoices with Connect</a> documentation for details.
 * @property bool $paid Whether payment was successfully collected for this invoice. An invoice can be paid (most commonly) with a charge or with credit from the customer\'s account balance.
 * @property bool $paid_out_of_band Returns true if the invoice was manually marked paid, returns false if the invoice hasn\'t been paid yet or was paid on Stripe.
 * @property null|string|\\Stripe\\PaymentIntent $payment_intent The PaymentIntent associated with this invoice. The PaymentIntent is generated when the invoice is finalized, and can then be used to pay the invoice. Note that voiding an invoice will cancel the PaymentIntent.
 * @property \\Stripe\\StripeObject $payment_settings
 * @property int $period_end End of the usage period during which invoice items were added to this invoice. This looks back one period for a subscription invoice. Use the <a href="/api/invoices/line_item#invoice_line_item_object-period">line item period</a> to get the service period for each price.
 * @property int $period_start Start of the usage period during which invoice items were added to this invoice. This looks back one period for a subscription invoice. Use the <a href="/api/invoices/line_item#invoice_line_item_object-period">line item period</a> to get the service period for each price.
 * @property int $post_payment_credit_notes_amount Total amount of all post-payment credit notes issued for this invoice.
 * @property int $pre_payment_credit_notes_amount Total amount of all pre-payment credit notes issued for this invoice.
 * @property null|string|\\Stripe\\Quote $quote The quote this invoice was generated from.
 * @property null|string $receipt_number This is the transaction number that appears on email receipts sent for this invoice.
 * @property null|\\Stripe\\StripeObject $rendering The rendering-related settings that control how the invoice is displayed on customer-facing surfaces such as PDF and Hosted Invoice Page.
 * @property null|\\Stripe\\StripeObject $shipping_cost The details of the cost of shipping, including the ShippingRate applied on the invoice.
 * @property null|\\Stripe\\StripeObject $shipping_details Shipping details for the invoice. The Invoice PDF will use the <code>shipping_details</code> value if it is set, otherwise the PDF will render the shipping address from the customer.
 * @property int $starting_balance Starting customer balance before the invoice is finalized. If the invoice has not been finalized yet, this will be the current customer balance. For revision invoices, this also includes any customer balance that was applied to the original invoice.
 * @property null|string $statement_descriptor Extra information about an invoice for the customer\'s credit card statement.
 * @property null|string $status The status of the invoice, one of <code>draft</code>, <code>open</code>, <code>paid</code>, <code>uncollectible</code>, or <code>void</code>. <a href="https://stripe.com/docs/billing/invoices/workflow#workflow-overview">Learn more</a>
 * @property \\Stripe\\StripeObject $status_transitions
 * @property null|string|\\Stripe\\Subscription $subscription The subscription that this invoice was prepared for, if any.
 * @property null|\\Stripe\\StripeObject $subscription_details Details about the subscription that created this invoice.
 * @property null|int $subscription_proration_date Only set for upcoming invoices that preview prorations. The time used to calculate prorations.
 * @property int $subtotal Total of all subscriptions, invoice items, and prorations on the invoice before any invoice level discount or exclusive tax is applied. Item discounts are already incorporated
 * @property null|int $subtotal_excluding_tax The integer amount in cents (or local equivalent) representing the subtotal of the invoice before any invoice level discount or tax is applied. Item discounts are already incorporated
 * @property null|int $tax The amount of tax on this invoice. This is the sum of all the tax amounts on this invoice.
 * @property null|string|\\Stripe\\TestHelpers\\TestClock $test_clock ID of the test clock this invoice belongs to.
 * @property null|\\Stripe\\StripeObject $threshold_reason
 * @property int $total Total after discounts and taxes.
 * @property null|\\Stripe\\StripeObject[] $total_discount_amounts The aggregate amounts calculated per discount across all line items.
 * @property null|int $total_excluding_tax The integer amount in cents (or local equivalent) representing the total amount of the invoice including all discounts but excluding all tax.
 * @property null|\\Stripe\\StripeObject[] $total_pretax_credit_amounts
 * @property \\Stripe\\StripeObject[] $total_tax_amounts The aggregate amounts calculated per tax rate for all line items.
 * @property null|\\Stripe\\StripeObject $transfer_data The account (if any) the payment will be attributed to for tax reporting, and where funds from the payment will be transferred to for the invoice.
 * @property null|int $webhooks_delivered_at Invoices are automatically paid or sent 1 hour after webhooks are delivered, or until all webhook delivery attempts have <a href="https://stripe.com/docs/billing/webhooks#understand">been exhausted</a>. This field tracks the time when webhooks for this invoice were successfully delivered. If the invoice had no webhooks to deliver, this will be set while the invoice is being created.
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 126,
    'endLine' => 496,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Stripe\\ApiResource',
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
      0 => 'Stripe\\ApiOperations\\NestedResource',
      1 => 'Stripe\\ApiOperations\\Update',
    ),
    'immediateConstants' => 
    array (
      'OBJECT_NAME' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'OBJECT_NAME',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'invoice\'',
          'attributes' => 
          array (
            'startLine' => 128,
            'endLine' => 128,
            'startTokenPos' => 27,
            'startFilePos' => 19067,
            'endTokenPos' => 27,
            'endFilePos' => 19075,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 128,
        'endLine' => 128,
        'startColumn' => 5,
        'endColumn' => 34,
      ),
      'BILLING_REASON_AUTOMATIC_PENDING_INVOICE_ITEM_INVOICE' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'BILLING_REASON_AUTOMATIC_PENDING_INVOICE_ITEM_INVOICE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'automatic_pending_invoice_item_invoice\'',
          'attributes' => 
          array (
            'startLine' => 133,
            'endLine' => 133,
            'startTokenPos' => 46,
            'startFilePos' => 19219,
            'endTokenPos' => 46,
            'endFilePos' => 19258,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 133,
        'endLine' => 133,
        'startColumn' => 5,
        'endColumn' => 107,
      ),
      'BILLING_REASON_MANUAL' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'BILLING_REASON_MANUAL',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'manual\'',
          'attributes' => 
          array (
            'startLine' => 134,
            'endLine' => 134,
            'startTokenPos' => 55,
            'startFilePos' => 19296,
            'endTokenPos' => 55,
            'endFilePos' => 19303,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 134,
        'endLine' => 134,
        'startColumn' => 5,
        'endColumn' => 43,
      ),
      'BILLING_REASON_QUOTE_ACCEPT' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'BILLING_REASON_QUOTE_ACCEPT',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'quote_accept\'',
          'attributes' => 
          array (
            'startLine' => 135,
            'endLine' => 135,
            'startTokenPos' => 64,
            'startFilePos' => 19347,
            'endTokenPos' => 64,
            'endFilePos' => 19360,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 135,
        'endLine' => 135,
        'startColumn' => 5,
        'endColumn' => 55,
      ),
      'BILLING_REASON_SUBSCRIPTION' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'BILLING_REASON_SUBSCRIPTION',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription\'',
          'attributes' => 
          array (
            'startLine' => 136,
            'endLine' => 136,
            'startTokenPos' => 73,
            'startFilePos' => 19404,
            'endTokenPos' => 73,
            'endFilePos' => 19417,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 136,
        'endLine' => 136,
        'startColumn' => 5,
        'endColumn' => 55,
      ),
      'BILLING_REASON_SUBSCRIPTION_CREATE' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'BILLING_REASON_SUBSCRIPTION_CREATE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_create\'',
          'attributes' => 
          array (
            'startLine' => 137,
            'endLine' => 137,
            'startTokenPos' => 82,
            'startFilePos' => 19468,
            'endTokenPos' => 82,
            'endFilePos' => 19488,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 137,
        'endLine' => 137,
        'startColumn' => 5,
        'endColumn' => 69,
      ),
      'BILLING_REASON_SUBSCRIPTION_CYCLE' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'BILLING_REASON_SUBSCRIPTION_CYCLE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_cycle\'',
          'attributes' => 
          array (
            'startLine' => 138,
            'endLine' => 138,
            'startTokenPos' => 91,
            'startFilePos' => 19538,
            'endTokenPos' => 91,
            'endFilePos' => 19557,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 138,
        'endLine' => 138,
        'startColumn' => 5,
        'endColumn' => 67,
      ),
      'BILLING_REASON_SUBSCRIPTION_THRESHOLD' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'BILLING_REASON_SUBSCRIPTION_THRESHOLD',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_threshold\'',
          'attributes' => 
          array (
            'startLine' => 139,
            'endLine' => 139,
            'startTokenPos' => 100,
            'startFilePos' => 19611,
            'endTokenPos' => 100,
            'endFilePos' => 19634,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 139,
        'endLine' => 139,
        'startColumn' => 5,
        'endColumn' => 75,
      ),
      'BILLING_REASON_SUBSCRIPTION_UPDATE' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'BILLING_REASON_SUBSCRIPTION_UPDATE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'subscription_update\'',
          'attributes' => 
          array (
            'startLine' => 140,
            'endLine' => 140,
            'startTokenPos' => 109,
            'startFilePos' => 19685,
            'endTokenPos' => 109,
            'endFilePos' => 19705,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 140,
        'endLine' => 140,
        'startColumn' => 5,
        'endColumn' => 69,
      ),
      'BILLING_REASON_UPCOMING' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'BILLING_REASON_UPCOMING',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'upcoming\'',
          'attributes' => 
          array (
            'startLine' => 141,
            'endLine' => 141,
            'startTokenPos' => 118,
            'startFilePos' => 19745,
            'endTokenPos' => 118,
            'endFilePos' => 19754,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 141,
        'endLine' => 141,
        'startColumn' => 5,
        'endColumn' => 47,
      ),
      'COLLECTION_METHOD_CHARGE_AUTOMATICALLY' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'COLLECTION_METHOD_CHARGE_AUTOMATICALLY',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge_automatically\'',
          'attributes' => 
          array (
            'startLine' => 143,
            'endLine' => 143,
            'startTokenPos' => 127,
            'startFilePos' => 19811,
            'endTokenPos' => 127,
            'endFilePos' => 19832,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 143,
        'endLine' => 143,
        'startColumn' => 5,
        'endColumn' => 74,
      ),
      'COLLECTION_METHOD_SEND_INVOICE' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'COLLECTION_METHOD_SEND_INVOICE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'send_invoice\'',
          'attributes' => 
          array (
            'startLine' => 144,
            'endLine' => 144,
            'startTokenPos' => 136,
            'startFilePos' => 19879,
            'endTokenPos' => 136,
            'endFilePos' => 19892,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 144,
        'endLine' => 144,
        'startColumn' => 5,
        'endColumn' => 58,
      ),
      'CUSTOMER_TAX_EXEMPT_EXEMPT' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'CUSTOMER_TAX_EXEMPT_EXEMPT',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'exempt\'',
          'attributes' => 
          array (
            'startLine' => 146,
            'endLine' => 146,
            'startTokenPos' => 145,
            'startFilePos' => 19937,
            'endTokenPos' => 145,
            'endFilePos' => 19944,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 146,
        'endLine' => 146,
        'startColumn' => 5,
        'endColumn' => 48,
      ),
      'CUSTOMER_TAX_EXEMPT_NONE' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'CUSTOMER_TAX_EXEMPT_NONE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'none\'',
          'attributes' => 
          array (
            'startLine' => 147,
            'endLine' => 147,
            'startTokenPos' => 154,
            'startFilePos' => 19985,
            'endTokenPos' => 154,
            'endFilePos' => 19990,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 147,
        'endLine' => 147,
        'startColumn' => 5,
        'endColumn' => 44,
      ),
      'CUSTOMER_TAX_EXEMPT_REVERSE' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'CUSTOMER_TAX_EXEMPT_REVERSE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'reverse\'',
          'attributes' => 
          array (
            'startLine' => 148,
            'endLine' => 148,
            'startTokenPos' => 163,
            'startFilePos' => 20034,
            'endTokenPos' => 163,
            'endFilePos' => 20042,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 148,
        'endLine' => 148,
        'startColumn' => 5,
        'endColumn' => 50,
      ),
      'STATUS_DRAFT' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'STATUS_DRAFT',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'draft\'',
          'attributes' => 
          array (
            'startLine' => 150,
            'endLine' => 150,
            'startTokenPos' => 172,
            'startFilePos' => 20073,
            'endTokenPos' => 172,
            'endFilePos' => 20079,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 150,
        'endLine' => 150,
        'startColumn' => 5,
        'endColumn' => 33,
      ),
      'STATUS_OPEN' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'STATUS_OPEN',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'open\'',
          'attributes' => 
          array (
            'startLine' => 151,
            'endLine' => 151,
            'startTokenPos' => 181,
            'startFilePos' => 20107,
            'endTokenPos' => 181,
            'endFilePos' => 20112,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 151,
        'endLine' => 151,
        'startColumn' => 5,
        'endColumn' => 31,
      ),
      'STATUS_PAID' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'STATUS_PAID',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'paid\'',
          'attributes' => 
          array (
            'startLine' => 152,
            'endLine' => 152,
            'startTokenPos' => 190,
            'startFilePos' => 20140,
            'endTokenPos' => 190,
            'endFilePos' => 20145,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 152,
        'endLine' => 152,
        'startColumn' => 5,
        'endColumn' => 31,
      ),
      'STATUS_UNCOLLECTIBLE' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'STATUS_UNCOLLECTIBLE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'uncollectible\'',
          'attributes' => 
          array (
            'startLine' => 153,
            'endLine' => 153,
            'startTokenPos' => 199,
            'startFilePos' => 20182,
            'endTokenPos' => 199,
            'endFilePos' => 20196,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 153,
        'endLine' => 153,
        'startColumn' => 5,
        'endColumn' => 49,
      ),
      'STATUS_VOID' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'STATUS_VOID',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'void\'',
          'attributes' => 
          array (
            'startLine' => 154,
            'endLine' => 154,
            'startTokenPos' => 208,
            'startFilePos' => 20224,
            'endTokenPos' => 208,
            'endFilePos' => 20229,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 154,
        'endLine' => 154,
        'startColumn' => 5,
        'endColumn' => 31,
      ),
      'BILLING_CHARGE_AUTOMATICALLY' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'BILLING_CHARGE_AUTOMATICALLY',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'charge_automatically\'',
          'attributes' => 
          array (
            'startLine' => 273,
            'endLine' => 273,
            'startTokenPos' => 640,
            'startFilePos' => 24557,
            'endTokenPos' => 640,
            'endFilePos' => 24578,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 273,
        'endLine' => 273,
        'startColumn' => 5,
        'endColumn' => 64,
      ),
      'BILLING_SEND_INVOICE' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'BILLING_SEND_INVOICE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'send_invoice\'',
          'attributes' => 
          array (
            'startLine' => 274,
            'endLine' => 274,
            'startTokenPos' => 649,
            'startFilePos' => 24615,
            'endTokenPos' => 649,
            'endFilePos' => 24628,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 274,
        'endLine' => 274,
        'startColumn' => 5,
        'endColumn' => 48,
      ),
      'PATH_LINES' => 
      array (
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'name' => 'PATH_LINES',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'/lines\'',
          'attributes' => 
          array (
            'startLine' => 481,
            'endLine' => 481,
            'startTokenPos' => 1686,
            'startFilePos' => 31123,
            'endTokenPos' => 1686,
            'endFilePos' => 31130,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 481,
        'endLine' => 481,
        'startColumn' => 5,
        'endColumn' => 32,
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
                'startLine' => 169,
                'endLine' => 169,
                'startTokenPos' => 225,
                'startFilePos' => 20825,
                'endTokenPos' => 225,
                'endFilePos' => 20828,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 169,
            'endLine' => 169,
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
                'startLine' => 169,
                'endLine' => 169,
                'startTokenPos' => 232,
                'startFilePos' => 20842,
                'endTokenPos' => 232,
                'endFilePos' => 20845,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 169,
            'endLine' => 169,
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
 * This endpoint creates a draft invoice for a given customer. The invoice remains
 * a draft until you <a href="#finalize_invoice">finalize</a> the invoice, which
 * allows you to <a href="#pay_invoice">pay</a> or <a href="#send_invoice">send</a>
 * the invoice to your customers.
 *
 * @param null|array $params
 * @param null|array|string $options
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice the created resource
 */',
        'startLine' => 169,
        'endLine' => 179,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
        'aliasName' => NULL,
      ),
      'delete' => 
      array (
        'name' => 'delete',
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
                'startLine' => 194,
                'endLine' => 194,
                'startTokenPos' => 327,
                'startFilePos' => 21759,
                'endTokenPos' => 327,
                'endFilePos' => 21762,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 194,
            'endLine' => 194,
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
                'startLine' => 194,
                'endLine' => 194,
                'startTokenPos' => 334,
                'startFilePos' => 21773,
                'endTokenPos' => 334,
                'endFilePos' => 21776,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 194,
            'endLine' => 194,
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
 * Permanently deletes a one-off invoice draft. This cannot be undone. Attempts to
 * delete invoices that are no longer in a draft state will fail; once an invoice
 * has been finalized or if an invoice is for a subscription, it must be <a
 * href="#void_invoice">voided</a>.
 *
 * @param null|array $params
 * @param null|array|string $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice the deleted resource
 */',
        'startLine' => 194,
        'endLine' => 203,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
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
                'startLine' => 217,
                'endLine' => 217,
                'startTokenPos' => 417,
                'startFilePos' => 22534,
                'endTokenPos' => 417,
                'endFilePos' => 22537,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 217,
            'endLine' => 217,
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
                'startLine' => 217,
                'endLine' => 217,
                'startTokenPos' => 424,
                'startFilePos' => 22548,
                'endTokenPos' => 424,
                'endFilePos' => 22551,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 217,
            'endLine' => 217,
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
 * You can list all invoices, or list the invoices for a specific customer. The
 * invoices are returned sorted by creation date, with the most recently created
 * invoices appearing first.
 *
 * @param null|array $params
 * @param null|array|string $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Collection<\\Stripe\\Invoice> of ApiResources
 */',
        'startLine' => 217,
        'endLine' => 222,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
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
            'startLine' => 234,
            'endLine' => 234,
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
                'startLine' => 234,
                'endLine' => 234,
                'startTokenPos' => 480,
                'startFilePos' => 23095,
                'endTokenPos' => 480,
                'endFilePos' => 23098,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 234,
            'endLine' => 234,
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
 * Retrieves the invoice with the given ID.
 *
 * @param array|string $id the ID of the API resource to retrieve, or an options array containing an `id` key
 * @param null|array|string $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice
 */',
        'startLine' => 234,
        'endLine' => 241,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
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
            'startLine' => 261,
            'endLine' => 261,
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
                'startLine' => 261,
                'endLine' => 261,
                'startTokenPos' => 543,
                'startFilePos' => 24157,
                'endTokenPos' => 543,
                'endFilePos' => 24160,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 261,
            'endLine' => 261,
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
                'startLine' => 261,
                'endLine' => 261,
                'startTokenPos' => 550,
                'startFilePos' => 24171,
                'endTokenPos' => 550,
                'endFilePos' => 24174,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 261,
            'endLine' => 261,
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
 * Draft invoices are fully editable. Once an invoice is <a
 * href="/docs/billing/invoices/workflow#finalized">finalized</a>, monetary values,
 * as well as <code>collection_method</code>, become uneditable.
 *
 * If you would like to stop the Stripe Billing engine from automatically
 * finalizing, reattempting payments on, sending reminders for, or <a
 * href="/docs/billing/invoices/reconciliation">automatically reconciling</a>
 * invoices, pass <code>auto_advance=false</code>.
 *
 * @param string $id the ID of the resource to update
 * @param null|array $params
 * @param null|array|string $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice the updated resource
 */',
        'startLine' => 261,
        'endLine' => 271,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
        'aliasName' => NULL,
      ),
      'addLines' => 
      array (
        'name' => 'addLines',
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
                'startLine' => 284,
                'endLine' => 284,
                'startTokenPos' => 664,
                'startFilePos' => 24903,
                'endTokenPos' => 664,
                'endFilePos' => 24906,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 284,
            'endLine' => 284,
            'startColumn' => 30,
            'endColumn' => 43,
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
                'startLine' => 284,
                'endLine' => 284,
                'startTokenPos' => 671,
                'startFilePos' => 24917,
                'endTokenPos' => 671,
                'endFilePos' => 24920,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 284,
            'endLine' => 284,
            'startColumn' => 46,
            'endColumn' => 57,
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
 * @return \\Stripe\\Invoice the added invoice
 */',
        'startLine' => 284,
        'endLine' => 291,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
        'aliasName' => NULL,
      ),
      'createPreview' => 
      array (
        'name' => 'createPreview',
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
                'startLine' => 301,
                'endLine' => 301,
                'startTokenPos' => 750,
                'startFilePos' => 25429,
                'endTokenPos' => 750,
                'endFilePos' => 25432,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 301,
            'endLine' => 301,
            'startColumn' => 42,
            'endColumn' => 55,
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
                'startLine' => 301,
                'endLine' => 301,
                'startTokenPos' => 757,
                'startFilePos' => 25443,
                'endTokenPos' => 757,
                'endFilePos' => 25446,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 301,
            'endLine' => 301,
            'startColumn' => 58,
            'endColumn' => 69,
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
 * @return \\Stripe\\Invoice the created invoice
 */',
        'startLine' => 301,
        'endLine' => 309,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
        'aliasName' => NULL,
      ),
      'finalizeInvoice' => 
      array (
        'name' => 'finalizeInvoice',
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
                'startLine' => 319,
                'endLine' => 319,
                'startTokenPos' => 848,
                'startFilePos' => 26039,
                'endTokenPos' => 848,
                'endFilePos' => 26042,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 319,
            'endLine' => 319,
            'startColumn' => 37,
            'endColumn' => 50,
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
                'startLine' => 319,
                'endLine' => 319,
                'startTokenPos' => 855,
                'startFilePos' => 26053,
                'endTokenPos' => 855,
                'endFilePos' => 26056,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 319,
            'endLine' => 319,
            'startColumn' => 53,
            'endColumn' => 64,
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
 * @return \\Stripe\\Invoice the finalized invoice
 */',
        'startLine' => 319,
        'endLine' => 326,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
        'aliasName' => NULL,
      ),
      'markUncollectible' => 
      array (
        'name' => 'markUncollectible',
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
                'startLine' => 336,
                'endLine' => 336,
                'startTokenPos' => 932,
                'startFilePos' => 26567,
                'endTokenPos' => 932,
                'endFilePos' => 26570,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 336,
            'endLine' => 336,
            'startColumn' => 39,
            'endColumn' => 52,
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
                'startLine' => 336,
                'endLine' => 336,
                'startTokenPos' => 939,
                'startFilePos' => 26581,
                'endTokenPos' => 939,
                'endFilePos' => 26584,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 336,
            'endLine' => 336,
            'startColumn' => 55,
            'endColumn' => 66,
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
 * @return \\Stripe\\Invoice the uncollectible invoice
 */',
        'startLine' => 336,
        'endLine' => 343,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
        'aliasName' => NULL,
      ),
      'pay' => 
      array (
        'name' => 'pay',
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
                'startLine' => 353,
                'endLine' => 353,
                'startTokenPos' => 1016,
                'startFilePos' => 27082,
                'endTokenPos' => 1016,
                'endFilePos' => 27085,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 353,
            'endLine' => 353,
            'startColumn' => 25,
            'endColumn' => 38,
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
                'startLine' => 353,
                'endLine' => 353,
                'startTokenPos' => 1023,
                'startFilePos' => 27096,
                'endTokenPos' => 1023,
                'endFilePos' => 27099,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 353,
            'endLine' => 353,
            'startColumn' => 41,
            'endColumn' => 52,
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
 * @return \\Stripe\\Invoice the paid invoice
 */',
        'startLine' => 353,
        'endLine' => 360,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
        'aliasName' => NULL,
      ),
      'removeLines' => 
      array (
        'name' => 'removeLines',
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
                'startLine' => 370,
                'endLine' => 370,
                'startTokenPos' => 1100,
                'startFilePos' => 27593,
                'endTokenPos' => 1100,
                'endFilePos' => 27596,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 370,
            'endLine' => 370,
            'startColumn' => 33,
            'endColumn' => 46,
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
                'startLine' => 370,
                'endLine' => 370,
                'startTokenPos' => 1107,
                'startFilePos' => 27607,
                'endTokenPos' => 1107,
                'endFilePos' => 27610,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 370,
            'endLine' => 370,
            'startColumn' => 49,
            'endColumn' => 60,
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
 * @return \\Stripe\\Invoice the removed invoice
 */',
        'startLine' => 370,
        'endLine' => 377,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
        'aliasName' => NULL,
      ),
      'sendInvoice' => 
      array (
        'name' => 'sendInvoice',
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
                'startLine' => 387,
                'endLine' => 387,
                'startTokenPos' => 1184,
                'startFilePos' => 28110,
                'endTokenPos' => 1184,
                'endFilePos' => 28113,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 387,
            'endLine' => 387,
            'startColumn' => 33,
            'endColumn' => 46,
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
                'startLine' => 387,
                'endLine' => 387,
                'startTokenPos' => 1191,
                'startFilePos' => 28124,
                'endTokenPos' => 1191,
                'endFilePos' => 28127,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 387,
            'endLine' => 387,
            'startColumn' => 49,
            'endColumn' => 60,
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
 * @return \\Stripe\\Invoice the sent invoice
 */',
        'startLine' => 387,
        'endLine' => 394,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
        'aliasName' => NULL,
      ),
      'upcoming' => 
      array (
        'name' => 'upcoming',
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
                'startLine' => 404,
                'endLine' => 404,
                'startTokenPos' => 1270,
                'startFilePos' => 28627,
                'endTokenPos' => 1270,
                'endFilePos' => 28630,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 404,
            'endLine' => 404,
            'startColumn' => 37,
            'endColumn' => 50,
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
                'startLine' => 404,
                'endLine' => 404,
                'startTokenPos' => 1277,
                'startFilePos' => 28641,
                'endTokenPos' => 1277,
                'endFilePos' => 28644,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 404,
            'endLine' => 404,
            'startColumn' => 53,
            'endColumn' => 64,
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
 * @return \\Stripe\\Invoice the upcoming invoice
 */',
        'startLine' => 404,
        'endLine' => 412,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
        'aliasName' => NULL,
      ),
      'upcomingLines' => 
      array (
        'name' => 'upcomingLines',
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
                'startLine' => 422,
                'endLine' => 422,
                'startTokenPos' => 1370,
                'startFilePos' => 29268,
                'endTokenPos' => 1370,
                'endFilePos' => 29271,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 422,
            'endLine' => 422,
            'startColumn' => 42,
            'endColumn' => 55,
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
                'startLine' => 422,
                'endLine' => 422,
                'startTokenPos' => 1377,
                'startFilePos' => 29282,
                'endTokenPos' => 1377,
                'endFilePos' => 29285,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 422,
            'endLine' => 422,
            'startColumn' => 58,
            'endColumn' => 69,
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
 * @return \\Stripe\\Collection<\\Stripe\\InvoiceLineItem> list of invoice line items
 */',
        'startLine' => 422,
        'endLine' => 430,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
        'aliasName' => NULL,
      ),
      'updateLines' => 
      array (
        'name' => 'updateLines',
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
                'startLine' => 440,
                'endLine' => 440,
                'startTokenPos' => 1468,
                'startFilePos' => 29871,
                'endTokenPos' => 1468,
                'endFilePos' => 29874,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 440,
            'endLine' => 440,
            'startColumn' => 33,
            'endColumn' => 46,
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
                'startLine' => 440,
                'endLine' => 440,
                'startTokenPos' => 1475,
                'startFilePos' => 29885,
                'endTokenPos' => 1475,
                'endFilePos' => 29888,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 440,
            'endLine' => 440,
            'startColumn' => 49,
            'endColumn' => 60,
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
 * @return \\Stripe\\Invoice the updated invoice
 */',
        'startLine' => 440,
        'endLine' => 447,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
        'aliasName' => NULL,
      ),
      'voidInvoice' => 
      array (
        'name' => 'voidInvoice',
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
                'startLine' => 457,
                'endLine' => 457,
                'startTokenPos' => 1552,
                'startFilePos' => 30390,
                'endTokenPos' => 1552,
                'endFilePos' => 30393,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 457,
            'endLine' => 457,
            'startColumn' => 33,
            'endColumn' => 46,
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
                'startLine' => 457,
                'endLine' => 457,
                'startTokenPos' => 1559,
                'startFilePos' => 30404,
                'endTokenPos' => 1559,
                'endFilePos' => 30407,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 457,
            'endLine' => 457,
            'startColumn' => 49,
            'endColumn' => 60,
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
 * @return \\Stripe\\Invoice the voided invoice
 */',
        'startLine' => 457,
        'endLine' => 464,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
        'aliasName' => NULL,
      ),
      'search' => 
      array (
        'name' => 'search',
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
                'startLine' => 474,
                'endLine' => 474,
                'startTokenPos' => 1638,
                'startFilePos' => 30933,
                'endTokenPos' => 1638,
                'endFilePos' => 30936,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 474,
            'endLine' => 474,
            'startColumn' => 35,
            'endColumn' => 48,
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
                'startLine' => 474,
                'endLine' => 474,
                'startTokenPos' => 1645,
                'startFilePos' => 30947,
                'endTokenPos' => 1645,
                'endFilePos' => 30950,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 474,
            'endLine' => 474,
            'startColumn' => 51,
            'endColumn' => 62,
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
 * @return \\Stripe\\SearchResult<\\Stripe\\Invoice> the invoice search results
 */',
        'startLine' => 474,
        'endLine' => 479,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
        'aliasName' => NULL,
      ),
      'allLines' => 
      array (
        'name' => 'allLines',
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
            'startLine' => 492,
            'endLine' => 492,
            'startColumn' => 37,
            'endColumn' => 39,
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
                'startLine' => 492,
                'endLine' => 492,
                'startTokenPos' => 1706,
                'startFilePos' => 31550,
                'endTokenPos' => 1706,
                'endFilePos' => 31553,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 492,
            'endLine' => 492,
            'startColumn' => 42,
            'endColumn' => 55,
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
                'startLine' => 492,
                'endLine' => 492,
                'startTokenPos' => 1713,
                'startFilePos' => 31564,
                'endTokenPos' => 1713,
                'endFilePos' => 31567,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 492,
            'endLine' => 492,
            'startColumn' => 58,
            'endColumn' => 69,
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
 * @param string $id the ID of the invoice on which to retrieve the invoice line items
 * @param null|array $params
 * @param null|array|string $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Collection<\\Stripe\\InvoiceLineItem> the list of invoice line items
 */',
        'startLine' => 492,
        'endLine' => 495,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Invoice',
        'implementingClassName' => 'Stripe\\Invoice',
        'currentClassName' => 'Stripe\\Invoice',
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