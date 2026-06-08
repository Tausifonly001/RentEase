<?php declare(strict_types = 1);

// osfsl-C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/Service/InvoiceService.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Stripe\Service\InvoiceService
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-e2b6db242de9429d52de6695fdbd386c602a9cf71f3b512f9c7ce277c381b7d6-8.2.12-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Stripe\\Service\\InvoiceService',
        'filename' => 'C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/Service/InvoiceService.php',
      ),
    ),
    'namespace' => 'Stripe\\Service',
    'name' => 'Stripe\\Service\\InvoiceService',
    'shortName' => 'InvoiceService',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * @phpstan-import-type RequestOptionsArray from \\Stripe\\Util\\RequestOptions
 * @psalm-import-type RequestOptionsArray from \\Stripe\\Util\\RequestOptions
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 11,
    'endLine' => 416,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Stripe\\Service\\AbstractService',
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
    ),
    'immediateMethods' => 
    array (
      'addLines' => 
      array (
        'name' => 'addLines',
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
            'startLine' => 25,
            'endLine' => 25,
            'startColumn' => 30,
            'endColumn' => 32,
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
                'startLine' => 25,
                'endLine' => 25,
                'startTokenPos' => 36,
                'startFilePos' => 747,
                'endTokenPos' => 36,
                'endFilePos' => 750,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 25,
            'endLine' => 25,
            'startColumn' => 35,
            'endColumn' => 48,
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
                'startLine' => 25,
                'endLine' => 25,
                'startTokenPos' => 43,
                'startFilePos' => 761,
                'endTokenPos' => 43,
                'endFilePos' => 764,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 25,
            'endLine' => 25,
            'startColumn' => 51,
            'endColumn' => 62,
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
 * Adds multiple line items to an invoice. This is only possible when an invoice is
 * still a draft.
 *
 * @param string $id
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice
 */',
        'startLine' => 25,
        'endLine' => 28,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
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
                'startLine' => 42,
                'endLine' => 42,
                'startTokenPos' => 89,
                'startFilePos' => 1406,
                'endTokenPos' => 89,
                'endFilePos' => 1409,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 42,
            'endLine' => 42,
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
                'startLine' => 42,
                'endLine' => 42,
                'startTokenPos' => 96,
                'startFilePos' => 1420,
                'endTokenPos' => 96,
                'endFilePos' => 1423,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 42,
            'endLine' => 42,
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
 * You can list all invoices, or list the invoices for a specific customer. The
 * invoices are returned sorted by creation date, with the most recently created
 * invoices appearing first.
 *
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Collection<\\Stripe\\Invoice>
 */',
        'startLine' => 42,
        'endLine' => 45,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
        'aliasName' => NULL,
      ),
      'allLines' => 
      array (
        'name' => 'allLines',
        'parameters' => 
        array (
          'parentId' => 
          array (
            'name' => 'parentId',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 61,
            'endLine' => 61,
            'startColumn' => 30,
            'endColumn' => 38,
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
                'startLine' => 61,
                'endLine' => 61,
                'startTokenPos' => 137,
                'startFilePos' => 2159,
                'endTokenPos' => 137,
                'endFilePos' => 2162,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 61,
            'endLine' => 61,
            'startColumn' => 41,
            'endColumn' => 54,
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
                'startLine' => 61,
                'endLine' => 61,
                'startTokenPos' => 144,
                'startFilePos' => 2173,
                'endTokenPos' => 144,
                'endFilePos' => 2176,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 61,
            'endLine' => 61,
            'startColumn' => 57,
            'endColumn' => 68,
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
 * When retrieving an invoice, you’ll get a <strong>lines</strong> property
 * containing the total count of line items and the first handful of those items.
 * There is also a URL where you can retrieve the full (paginated) list of line
 * items.
 *
 * @param string $parentId
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Collection<\\Stripe\\InvoiceLineItem>
 */',
        'startLine' => 61,
        'endLine' => 64,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
        'aliasName' => NULL,
      ),
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
                'startLine' => 79,
                'endLine' => 79,
                'startTokenPos' => 190,
                'startFilePos' => 2909,
                'endTokenPos' => 190,
                'endFilePos' => 2912,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 79,
            'endLine' => 79,
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
                'startLine' => 79,
                'endLine' => 79,
                'startTokenPos' => 197,
                'startFilePos' => 2923,
                'endTokenPos' => 197,
                'endFilePos' => 2926,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 79,
            'endLine' => 79,
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
 * This endpoint creates a draft invoice for a given customer. The invoice remains
 * a draft until you <a href="#finalize_invoice">finalize</a> the invoice, which
 * allows you to <a href="#pay_invoice">pay</a> or <a href="#send_invoice">send</a>
 * the invoice to your customers.
 *
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice
 */',
        'startLine' => 79,
        'endLine' => 82,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
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
                'startLine' => 118,
                'endLine' => 118,
                'startTokenPos' => 235,
                'startFilePos' => 4991,
                'endTokenPos' => 235,
                'endFilePos' => 4994,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 118,
            'endLine' => 118,
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
                'startLine' => 118,
                'endLine' => 118,
                'startTokenPos' => 242,
                'startFilePos' => 5005,
                'endTokenPos' => 242,
                'endFilePos' => 5008,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 118,
            'endLine' => 118,
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
 * At any time, you can preview the upcoming invoice for a customer. This will show
 * you all the charges that are pending, including subscription renewal charges,
 * invoice item charges, etc. It will also show you any discounts that are
 * applicable to the invoice.
 *
 * Note that when you are viewing an upcoming invoice, you are simply viewing a
 * preview – the invoice has not yet been created. As such, the upcoming invoice
 * will not show up in invoice listing calls, and you cannot use the API to pay or
 * edit the invoice. If you want to change the amount that your customer will be
 * billed, you can add, remove, or update pending invoice items, or update the
 * customer’s discount.
 *
 * You can preview the effects of updating a subscription, including a preview of
 * what proration will take place. To ensure that the actual proration is
 * calculated exactly the same as the previewed proration, you should pass the
 * <code>subscription_details.proration_date</code> parameter when doing the actual
 * subscription update. The recommended way to get only the prorations being
 * previewed is to consider only proration line items where
 * <code>period[start]</code> is equal to the
 * <code>subscription_details.proration_date</code> value passed in the request.
 *
 * Note: Currency conversion calculations use the latest exchange rates. Exchange
 * rates may vary between the time of the preview and the time of the actual
 * invoice creation. <a href="https://docs.stripe.com/currencies/conversions">Learn
 * more</a>
 *
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice
 */',
        'startLine' => 118,
        'endLine' => 121,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
        'aliasName' => NULL,
      ),
      'delete' => 
      array (
        'name' => 'delete',
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
            'startLine' => 137,
            'endLine' => 137,
            'startColumn' => 28,
            'endColumn' => 30,
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
                'startLine' => 137,
                'endLine' => 137,
                'startTokenPos' => 283,
                'startFilePos' => 5735,
                'endTokenPos' => 283,
                'endFilePos' => 5738,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 137,
            'endLine' => 137,
            'startColumn' => 33,
            'endColumn' => 46,
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
                'startLine' => 137,
                'endLine' => 137,
                'startTokenPos' => 290,
                'startFilePos' => 5749,
                'endTokenPos' => 290,
                'endFilePos' => 5752,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 137,
            'endLine' => 137,
            'startColumn' => 49,
            'endColumn' => 60,
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
 * Permanently deletes a one-off invoice draft. This cannot be undone. Attempts to
 * delete invoices that are no longer in a draft state will fail; once an invoice
 * has been finalized or if an invoice is for a subscription, it must be <a
 * href="#void_invoice">voided</a>.
 *
 * @param string $id
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice
 */',
        'startLine' => 137,
        'endLine' => 140,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
        'aliasName' => NULL,
      ),
      'finalizeInvoice' => 
      array (
        'name' => 'finalizeInvoice',
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
            'startLine' => 155,
            'endLine' => 155,
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
                'startLine' => 155,
                'endLine' => 155,
                'startTokenPos' => 339,
                'startFilePos' => 6413,
                'endTokenPos' => 339,
                'endFilePos' => 6416,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 155,
            'endLine' => 155,
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
                'startLine' => 155,
                'endLine' => 155,
                'startTokenPos' => 346,
                'startFilePos' => 6427,
                'endTokenPos' => 346,
                'endFilePos' => 6430,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 155,
            'endLine' => 155,
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
 * Stripe automatically finalizes drafts before sending and attempting payment on
 * invoices. However, if you’d like to finalize a draft invoice manually, you can
 * do so using this method.
 *
 * @param string $id
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice
 */',
        'startLine' => 155,
        'endLine' => 158,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
        'aliasName' => NULL,
      ),
      'markUncollectible' => 
      array (
        'name' => 'markUncollectible',
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
            'startLine' => 172,
            'endLine' => 172,
            'startColumn' => 39,
            'endColumn' => 41,
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
                'startLine' => 172,
                'endLine' => 172,
                'startTokenPos' => 395,
                'startFilePos' => 7033,
                'endTokenPos' => 395,
                'endFilePos' => 7036,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 172,
            'endLine' => 172,
            'startColumn' => 44,
            'endColumn' => 57,
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
                'startLine' => 172,
                'endLine' => 172,
                'startTokenPos' => 402,
                'startFilePos' => 7047,
                'endTokenPos' => 402,
                'endFilePos' => 7050,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 172,
            'endLine' => 172,
            'startColumn' => 60,
            'endColumn' => 71,
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
 * Marking an invoice as uncollectible is useful for keeping track of bad debts
 * that can be written off for accounting purposes.
 *
 * @param string $id
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice
 */',
        'startLine' => 172,
        'endLine' => 175,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
        'aliasName' => NULL,
      ),
      'pay' => 
      array (
        'name' => 'pay',
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
            'startLine' => 192,
            'endLine' => 192,
            'startColumn' => 25,
            'endColumn' => 27,
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
                'startLine' => 192,
                'endLine' => 192,
                'startTokenPos' => 451,
                'startFilePos' => 7904,
                'endTokenPos' => 451,
                'endFilePos' => 7907,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 192,
            'endLine' => 192,
            'startColumn' => 30,
            'endColumn' => 43,
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
                'startLine' => 192,
                'endLine' => 192,
                'startTokenPos' => 458,
                'startFilePos' => 7918,
                'endTokenPos' => 458,
                'endFilePos' => 7921,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 192,
            'endLine' => 192,
            'startColumn' => 46,
            'endColumn' => 57,
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
 * Stripe automatically creates and then attempts to collect payment on invoices
 * for customers on subscriptions according to your <a
 * href="https://dashboard.stripe.com/account/billing/automatic">subscriptions
 * settings</a>. However, if you’d like to attempt payment on an invoice out of the
 * normal collection schedule or for some other reason, you can do so.
 *
 * @param string $id
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice
 */',
        'startLine' => 192,
        'endLine' => 195,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
        'aliasName' => NULL,
      ),
      'removeLines' => 
      array (
        'name' => 'removeLines',
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
            'startLine' => 209,
            'endLine' => 209,
            'startColumn' => 33,
            'endColumn' => 35,
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
                'startLine' => 209,
                'endLine' => 209,
                'startTokenPos' => 507,
                'startFilePos' => 8488,
                'endTokenPos' => 507,
                'endFilePos' => 8491,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 209,
            'endLine' => 209,
            'startColumn' => 38,
            'endColumn' => 51,
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
                'startLine' => 209,
                'endLine' => 209,
                'startTokenPos' => 514,
                'startFilePos' => 8502,
                'endTokenPos' => 514,
                'endFilePos' => 8505,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 209,
            'endLine' => 209,
            'startColumn' => 54,
            'endColumn' => 65,
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
 * Removes multiple line items from an invoice. This is only possible when an
 * invoice is still a draft.
 *
 * @param string $id
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice
 */',
        'startLine' => 209,
        'endLine' => 212,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
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
            'startLine' => 225,
            'endLine' => 225,
            'startColumn' => 30,
            'endColumn' => 32,
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
                'startTokenPos' => 563,
                'startFilePos' => 9010,
                'endTokenPos' => 563,
                'endFilePos' => 9013,
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
            'startColumn' => 35,
            'endColumn' => 48,
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
                'startTokenPos' => 570,
                'startFilePos' => 9024,
                'endTokenPos' => 570,
                'endFilePos' => 9027,
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
            'startColumn' => 51,
            'endColumn' => 62,
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
 * Retrieves the invoice with the given ID.
 *
 * @param string $id
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice
 */',
        'startLine' => 225,
        'endLine' => 228,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
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
                'startLine' => 245,
                'endLine' => 245,
                'startTokenPos' => 616,
                'startFilePos' => 9958,
                'endTokenPos' => 616,
                'endFilePos' => 9961,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 245,
            'endLine' => 245,
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
                'startLine' => 245,
                'endLine' => 245,
                'startTokenPos' => 623,
                'startFilePos' => 9972,
                'endTokenPos' => 623,
                'endFilePos' => 9975,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 245,
            'endLine' => 245,
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
 * Search for invoices you’ve previously created using Stripe’s <a
 * href="/docs/search#search-query-language">Search Query Language</a>. Don’t use
 * search in read-after-write flows where strict consistency is necessary. Under
 * normal operating conditions, data is searchable in less than a minute.
 * Occasionally, propagation of new or updated data can be up to an hour behind
 * during outages. Search functionality is not available to merchants in India.
 *
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\SearchResult<\\Stripe\\Invoice>
 */',
        'startLine' => 245,
        'endLine' => 248,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
        'aliasName' => NULL,
      ),
      'sendInvoice' => 
      array (
        'name' => 'sendInvoice',
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
            'startLine' => 268,
            'endLine' => 268,
            'startColumn' => 33,
            'endColumn' => 35,
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
                'startLine' => 268,
                'endLine' => 268,
                'startTokenPos' => 664,
                'startFilePos' => 10972,
                'endTokenPos' => 664,
                'endFilePos' => 10975,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 268,
            'endLine' => 268,
            'startColumn' => 38,
            'endColumn' => 51,
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
                'startLine' => 268,
                'endLine' => 268,
                'startTokenPos' => 671,
                'startFilePos' => 10986,
                'endTokenPos' => 671,
                'endFilePos' => 10989,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 268,
            'endLine' => 268,
            'startColumn' => 54,
            'endColumn' => 65,
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
 * Stripe will automatically send invoices to customers according to your <a
 * href="https://dashboard.stripe.com/account/billing/automatic">subscriptions
 * settings</a>. However, if you’d like to manually send an invoice to your
 * customer out of the normal schedule, you can do so. When sending invoices that
 * have already been paid, there will be no reference to the payment in the email.
 *
 * Requests made in test-mode result in no emails being sent, despite sending an
 * <code>invoice.sent</code> event.
 *
 * @param string $id
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice
 */',
        'startLine' => 268,
        'endLine' => 271,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
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
                'startLine' => 307,
                'endLine' => 307,
                'startTokenPos' => 717,
                'startFilePos' => 13080,
                'endTokenPos' => 717,
                'endFilePos' => 13083,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 307,
            'endLine' => 307,
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
                'startLine' => 307,
                'endLine' => 307,
                'startTokenPos' => 724,
                'startFilePos' => 13094,
                'endTokenPos' => 724,
                'endFilePos' => 13097,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 307,
            'endLine' => 307,
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
 * At any time, you can preview the upcoming invoice for a customer. This will show
 * you all the charges that are pending, including subscription renewal charges,
 * invoice item charges, etc. It will also show you any discounts that are
 * applicable to the invoice.
 *
 * Note that when you are viewing an upcoming invoice, you are simply viewing a
 * preview – the invoice has not yet been created. As such, the upcoming invoice
 * will not show up in invoice listing calls, and you cannot use the API to pay or
 * edit the invoice. If you want to change the amount that your customer will be
 * billed, you can add, remove, or update pending invoice items, or update the
 * customer’s discount.
 *
 * You can preview the effects of updating a subscription, including a preview of
 * what proration will take place. To ensure that the actual proration is
 * calculated exactly the same as the previewed proration, you should pass the
 * <code>subscription_details.proration_date</code> parameter when doing the actual
 * subscription update. The recommended way to get only the prorations being
 * previewed is to consider only proration line items where
 * <code>period[start]</code> is equal to the
 * <code>subscription_details.proration_date</code> value passed in the request.
 *
 * Note: Currency conversion calculations use the latest exchange rates. Exchange
 * rates may vary between the time of the preview and the time of the actual
 * invoice creation. <a href="https://docs.stripe.com/currencies/conversions">Learn
 * more</a>
 *
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice
 */',
        'startLine' => 307,
        'endLine' => 310,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
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
                'startLine' => 325,
                'endLine' => 325,
                'startTokenPos' => 762,
                'startFilePos' => 13803,
                'endTokenPos' => 762,
                'endFilePos' => 13806,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 325,
            'endLine' => 325,
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
                'startLine' => 325,
                'endLine' => 325,
                'startTokenPos' => 769,
                'startFilePos' => 13817,
                'endTokenPos' => 769,
                'endFilePos' => 13820,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 325,
            'endLine' => 325,
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
 * When retrieving an upcoming invoice, you’ll get a <strong>lines</strong>
 * property containing the total count of line items and the first handful of those
 * items. There is also a URL where you can retrieve the full (paginated) list of
 * line items.
 *
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Collection<\\Stripe\\InvoiceLineItem>
 */',
        'startLine' => 325,
        'endLine' => 328,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
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
            'startLine' => 348,
            'endLine' => 348,
            'startColumn' => 28,
            'endColumn' => 30,
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
                'startLine' => 348,
                'endLine' => 348,
                'startTokenPos' => 810,
                'startFilePos' => 14784,
                'endTokenPos' => 810,
                'endFilePos' => 14787,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 348,
            'endLine' => 348,
            'startColumn' => 33,
            'endColumn' => 46,
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
                'startLine' => 348,
                'endLine' => 348,
                'startTokenPos' => 817,
                'startFilePos' => 14798,
                'endTokenPos' => 817,
                'endFilePos' => 14801,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 348,
            'endLine' => 348,
            'startColumn' => 49,
            'endColumn' => 60,
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
 * @param string $id
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice
 */',
        'startLine' => 348,
        'endLine' => 351,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
        'aliasName' => NULL,
      ),
      'updateLine' => 
      array (
        'name' => 'updateLine',
        'parameters' => 
        array (
          'parentId' => 
          array (
            'name' => 'parentId',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 370,
            'endLine' => 370,
            'startColumn' => 32,
            'endColumn' => 40,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
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
            'startLine' => 370,
            'endLine' => 370,
            'startColumn' => 43,
            'endColumn' => 45,
            'parameterIndex' => 1,
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
                'startLine' => 370,
                'endLine' => 370,
                'startTokenPos' => 869,
                'startFilePos' => 15769,
                'endTokenPos' => 869,
                'endFilePos' => 15772,
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
            'startColumn' => 48,
            'endColumn' => 61,
            'parameterIndex' => 2,
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
                'startTokenPos' => 876,
                'startFilePos' => 15783,
                'endTokenPos' => 876,
                'endFilePos' => 15786,
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
            'startColumn' => 64,
            'endColumn' => 75,
            'parameterIndex' => 3,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Updates an invoice’s line item. Some fields, such as <code>tax_amounts</code>,
 * only live on the invoice line item, so they can only be updated through this
 * endpoint. Other fields, such as <code>amount</code>, live on both the invoice
 * item and the invoice line item, so updates on this endpoint will propagate to
 * the invoice item as well. Updating an invoice’s line item is only possible
 * before the invoice is finalized.
 *
 * @param string $parentId
 * @param string $id
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\InvoiceLineItem
 */',
        'startLine' => 370,
        'endLine' => 373,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
        'aliasName' => NULL,
      ),
      'updateLines' => 
      array (
        'name' => 'updateLines',
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
            'startLine' => 387,
            'endLine' => 387,
            'startColumn' => 33,
            'endColumn' => 35,
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
                'startLine' => 387,
                'endLine' => 387,
                'startTokenPos' => 928,
                'startFilePos' => 16367,
                'endTokenPos' => 928,
                'endFilePos' => 16370,
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
            'startColumn' => 38,
            'endColumn' => 51,
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
                'startLine' => 387,
                'endLine' => 387,
                'startTokenPos' => 935,
                'startFilePos' => 16381,
                'endTokenPos' => 935,
                'endFilePos' => 16384,
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
            'startColumn' => 54,
            'endColumn' => 65,
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
 * Updates multiple line items on an invoice. This is only possible when an invoice
 * is still a draft.
 *
 * @param string $id
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice
 */',
        'startLine' => 387,
        'endLine' => 390,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
        'aliasName' => NULL,
      ),
      'voidInvoice' => 
      array (
        'name' => 'voidInvoice',
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
            'startLine' => 412,
            'endLine' => 412,
            'startColumn' => 33,
            'endColumn' => 35,
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
                'startLine' => 412,
                'endLine' => 412,
                'startTokenPos' => 984,
                'startFilePos' => 17546,
                'endTokenPos' => 984,
                'endFilePos' => 17549,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 412,
            'endLine' => 412,
            'startColumn' => 38,
            'endColumn' => 51,
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
                'startLine' => 412,
                'endLine' => 412,
                'startTokenPos' => 991,
                'startFilePos' => 17560,
                'endTokenPos' => 991,
                'endFilePos' => 17563,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 412,
            'endLine' => 412,
            'startColumn' => 54,
            'endColumn' => 65,
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
 * Mark a finalized invoice as void. This cannot be undone. Voiding an invoice is
 * similar to <a href="#delete_invoice">deletion</a>, however it only applies to
 * finalized invoices and maintains a papertrail where the invoice can still be
 * found.
 *
 * Consult with local regulations to determine whether and how an invoice might be
 * amended, canceled, or voided in the jurisdiction you’re doing business in. You
 * might need to <a href="#create_invoice">issue another invoice</a> or <a
 * href="#create_credit_note">credit note</a> instead. Stripe recommends that you
 * consult with your legal counsel for advice specific to your business.
 *
 * @param string $id
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Invoice
 */',
        'startLine' => 412,
        'endLine' => 415,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceService',
        'currentClassName' => 'Stripe\\Service\\InvoiceService',
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