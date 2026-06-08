<?php declare(strict_types = 1);

// osfsl-C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/BaseStripeClient.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Stripe\BaseStripeClient
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-081e1a553a75364914bdb6209539e5ee4922488916b8e1ffa192a5437375b706-8.2.12-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Stripe\\BaseStripeClient',
        'filename' => 'C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/BaseStripeClient.php',
      ),
    ),
    'namespace' => 'Stripe',
    'name' => 'Stripe\\BaseStripeClient',
    'shortName' => 'BaseStripeClient',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => NULL,
    'attributes' => 
    array (
    ),
    'startLine' => 7,
    'endLine' => 466,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => NULL,
    'implementsClassNames' => 
    array (
      0 => 'Stripe\\StripeClientInterface',
      1 => 'Stripe\\StripeStreamingClientInterface',
    ),
    'traitClassNames' => 
    array (
    ),
    'immediateConstants' => 
    array (
      'DEFAULT_API_BASE' => 
      array (
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'name' => 'DEFAULT_API_BASE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'https://api.stripe.com\'',
          'attributes' => 
          array (
            'startLine' => 10,
            'endLine' => 10,
            'startTokenPos' => 33,
            'startFilePos' => 234,
            'endTokenPos' => 33,
            'endFilePos' => 257,
          ),
        ),
        'docComment' => '/** @var string default base URL for Stripe\'s API */',
        'attributes' => 
        array (
        ),
        'startLine' => 10,
        'endLine' => 10,
        'startColumn' => 5,
        'endColumn' => 54,
      ),
      'DEFAULT_CONNECT_BASE' => 
      array (
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'name' => 'DEFAULT_CONNECT_BASE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'https://connect.stripe.com\'',
          'attributes' => 
          array (
            'startLine' => 13,
            'endLine' => 13,
            'startTokenPos' => 44,
            'startFilePos' => 360,
            'endTokenPos' => 44,
            'endFilePos' => 387,
          ),
        ),
        'docComment' => '/** @var string default base URL for Stripe\'s OAuth API */',
        'attributes' => 
        array (
        ),
        'startLine' => 13,
        'endLine' => 13,
        'startColumn' => 5,
        'endColumn' => 62,
      ),
      'DEFAULT_FILES_BASE' => 
      array (
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'name' => 'DEFAULT_FILES_BASE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'https://files.stripe.com\'',
          'attributes' => 
          array (
            'startLine' => 16,
            'endLine' => 16,
            'startTokenPos' => 55,
            'startFilePos' => 488,
            'endTokenPos' => 55,
            'endFilePos' => 513,
          ),
        ),
        'docComment' => '/** @var string default base URL for Stripe\'s Files API */',
        'attributes' => 
        array (
        ),
        'startLine' => 16,
        'endLine' => 16,
        'startColumn' => 5,
        'endColumn' => 58,
      ),
      'DEFAULT_METER_EVENTS_BASE' => 
      array (
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'name' => 'DEFAULT_METER_EVENTS_BASE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '\'https://meter-events.stripe.com\'',
          'attributes' => 
          array (
            'startLine' => 19,
            'endLine' => 19,
            'startTokenPos' => 66,
            'startFilePos' => 628,
            'endTokenPos' => 66,
            'endFilePos' => 660,
          ),
        ),
        'docComment' => '/** @var string default base URL for Stripe\'s Meter Events API */',
        'attributes' => 
        array (
        ),
        'startLine' => 19,
        'endLine' => 19,
        'startColumn' => 5,
        'endColumn' => 72,
      ),
      'DEFAULT_CONFIG' => 
      array (
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'name' => 'DEFAULT_CONFIG',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '[\'api_key\' => null, \'app_info\' => null, \'client_id\' => null, \'stripe_account\' => null, \'stripe_context\' => null, \'stripe_version\' => \\Stripe\\Util\\ApiVersion::CURRENT, \'api_base\' => self::DEFAULT_API_BASE, \'connect_base\' => self::DEFAULT_CONNECT_BASE, \'files_base\' => self::DEFAULT_FILES_BASE, \'meter_events_base\' => self::DEFAULT_METER_EVENTS_BASE]',
          'attributes' => 
          array (
            'startLine' => 22,
            'endLine' => 33,
            'startTokenPos' => 77,
            'startFilePos' => 737,
            'endTokenPos' => 159,
            'endFilePos' => 1182,
          ),
        ),
        'docComment' => '/** @var array<string, null|string> */',
        'attributes' => 
        array (
        ),
        'startLine' => 22,
        'endLine' => 33,
        'startColumn' => 5,
        'endColumn' => 6,
      ),
    ),
    'immediateProperties' => 
    array (
      'config' => 
      array (
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'name' => 'config',
        'modifiers' => 4,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/** @var array<string, mixed> */',
        'attributes' => 
        array (
        ),
        'startLine' => 36,
        'endLine' => 36,
        'startColumn' => 5,
        'endColumn' => 20,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'defaultOpts' => 
      array (
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'name' => 'defaultOpts',
        'modifiers' => 4,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/** @var \\Stripe\\Util\\RequestOptions */',
        'attributes' => 
        array (
        ),
        'startLine' => 39,
        'endLine' => 39,
        'startColumn' => 5,
        'endColumn' => 25,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
    ),
    'immediateMethods' => 
    array (
      '__construct' => 
      array (
        'name' => '__construct',
        'parameters' => 
        array (
          'config' => 
          array (
            'name' => 'config',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 75,
                'endLine' => 75,
                'startTokenPos' => 188,
                'startFilePos' => 3561,
                'endTokenPos' => 189,
                'endFilePos' => 3562,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 75,
            'endLine' => 75,
            'startColumn' => 33,
            'endColumn' => 44,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Initializes a new instance of the {@link BaseStripeClient} class.
 *
 * The constructor takes a single argument. The argument can be a string, in which case it
 * should be the API key. It can also be an array with various configuration settings.
 *
 * Configuration settings include the following options:
 *
 * - api_key (null|string): the Stripe API key, to be used in regular API requests.
 * - app_info (null|array): information to identify a plugin that integrates Stripe using this library.
 *                          Expects: array{name: string, version?: string, url?: string, partner_id?: string}
 * - client_id (null|string): the Stripe client ID, to be used in OAuth requests.
 * - stripe_account (null|string): a Stripe account ID. If set, all requests sent by the client
 *   will automatically use the {@code Stripe-Account} header with that account ID.
 * - stripe_context (null|string): a Stripe account or compartment ID. If set, all requests sent by the client
 *   will automatically use the {@code Stripe-Context} header with that ID.
 * - stripe_version (null|string): a Stripe API version. If set, all requests sent by the client
 *   will include the {@code Stripe-Version} header with that API version.
 *
 * The following configuration settings are also available, though setting these should rarely be necessary
 * (only useful if you want to send requests to a mock server like stripe-mock):
 *
 * - api_base (string): the base URL for regular API requests. Defaults to
 *   {@link DEFAULT_API_BASE}.
 * - connect_base (string): the base URL for OAuth requests. Defaults to
 *   {@link DEFAULT_CONNECT_BASE}.
 * - files_base (string): the base URL for file creation requests. Defaults to
 *   {@link DEFAULT_FILES_BASE}.
 * - meter_events_base (string): the base URL for high throughput requests. Defaults to
 *   {@link DEFAULT_METER_EVENTS_BASE}.
 *
 * @param array<string, mixed>|string $config the API key as a string, or an array containing
 *   the client configuration settings
 */',
        'startLine' => 75,
        'endLine' => 93,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'getApiKey' => 
      array (
        'name' => 'getApiKey',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Gets the API key used by the client to send requests.
 *
 * @return null|string the API key used by the client to send requests
 */',
        'startLine' => 100,
        'endLine' => 103,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'getClientId' => 
      array (
        'name' => 'getClientId',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Gets the client ID used by the client in OAuth requests.
 *
 * @return null|string the client ID used by the client in OAuth requests
 */',
        'startLine' => 110,
        'endLine' => 113,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'getApiBase' => 
      array (
        'name' => 'getApiBase',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Gets the base URL for Stripe\'s API.
 *
 * @return string the base URL for Stripe\'s API
 */',
        'startLine' => 120,
        'endLine' => 123,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'getConnectBase' => 
      array (
        'name' => 'getConnectBase',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Gets the base URL for Stripe\'s OAuth API.
 *
 * @return string the base URL for Stripe\'s OAuth API
 */',
        'startLine' => 130,
        'endLine' => 133,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'getFilesBase' => 
      array (
        'name' => 'getFilesBase',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Gets the base URL for Stripe\'s Files API.
 *
 * @return string the base URL for Stripe\'s Files API
 */',
        'startLine' => 140,
        'endLine' => 143,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'getMeterEventsBase' => 
      array (
        'name' => 'getMeterEventsBase',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Gets the base URL for Stripe\'s Meter Events API.
 *
 * @return string the base URL for Stripe\'s Meter Events API
 */',
        'startLine' => 150,
        'endLine' => 153,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'getAppInfo' => 
      array (
        'name' => 'getAppInfo',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Gets the app info for this client.
 *
 * @return null|array information to identify a plugin that integrates Stripe using this library
 */',
        'startLine' => 160,
        'endLine' => 163,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'request' => 
      array (
        'name' => 'request',
        'parameters' => 
        array (
          'method' => 
          array (
            'name' => 'method',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 175,
            'endLine' => 175,
            'startColumn' => 29,
            'endColumn' => 35,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'path' => 
          array (
            'name' => 'path',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 175,
            'endLine' => 175,
            'startColumn' => 38,
            'endColumn' => 42,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
          'params' => 
          array (
            'name' => 'params',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 175,
            'endLine' => 175,
            'startColumn' => 45,
            'endColumn' => 51,
            'parameterIndex' => 2,
            'isOptional' => false,
          ),
          'opts' => 
          array (
            'name' => 'opts',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 175,
            'endLine' => 175,
            'startColumn' => 54,
            'endColumn' => 58,
            'parameterIndex' => 3,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Sends a request to Stripe\'s API.
 *
 * @param \'delete\'|\'get\'|\'post\' $method the HTTP method
 * @param string $path the path of the request
 * @param array $params the parameters of the request
 * @param array|\\Stripe\\Util\\RequestOptions $opts the special modifiers of the request
 *
 * @return \\Stripe\\StripeObject the object returned by Stripe\'s API
 */',
        'startLine' => 175,
        'endLine' => 195,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'rawRequest' => 
      array (
        'name' => 'rawRequest',
        'parameters' => 
        array (
          'method' => 
          array (
            'name' => 'method',
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
            'startColumn' => 32,
            'endColumn' => 38,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'path' => 
          array (
            'name' => 'path',
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
            'startColumn' => 41,
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
                'startLine' => 209,
                'endLine' => 209,
                'startTokenPos' => 722,
                'startFilePos' => 7954,
                'endTokenPos' => 722,
                'endFilePos' => 7957,
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
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 209,
                'endLine' => 209,
                'startTokenPos' => 729,
                'startFilePos' => 7968,
                'endTokenPos' => 730,
                'endFilePos' => 7969,
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
            'startColumn' => 64,
            'endColumn' => 73,
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
 * Sends a raw request to Stripe\'s API. This is the lowest level method for interacting
 * with the Stripe API. This method is useful for interacting with endpoints that are not
 * covered yet in stripe-php.
 *
 * @param \'delete\'|\'get\'|\'post\' $method the HTTP method
 * @param string $path the path of the request
 * @param null|array $params the parameters of the request
 * @param array $opts the special modifiers of the request
 *
 * @return \\Stripe\\ApiResponse
 */',
        'startLine' => 209,
        'endLine' => 236,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'requestStream' => 
      array (
        'name' => 'requestStream',
        'parameters' => 
        array (
          'method' => 
          array (
            'name' => 'method',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 250,
            'endLine' => 250,
            'startColumn' => 35,
            'endColumn' => 41,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'path' => 
          array (
            'name' => 'path',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 250,
            'endLine' => 250,
            'startColumn' => 44,
            'endColumn' => 48,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
          'readBodyChunkCallable' => 
          array (
            'name' => 'readBodyChunkCallable',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 250,
            'endLine' => 250,
            'startColumn' => 51,
            'endColumn' => 72,
            'parameterIndex' => 2,
            'isOptional' => false,
          ),
          'params' => 
          array (
            'name' => 'params',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 250,
            'endLine' => 250,
            'startColumn' => 75,
            'endColumn' => 81,
            'parameterIndex' => 3,
            'isOptional' => false,
          ),
          'opts' => 
          array (
            'name' => 'opts',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 250,
            'endLine' => 250,
            'startColumn' => 84,
            'endColumn' => 88,
            'parameterIndex' => 4,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Sends a request to Stripe\'s API, passing chunks of the streamed response
 * into a user-provided $readBodyChunkCallable callback.
 *
 * @param \'delete\'|\'get\'|\'post\' $method the HTTP method
 * @param string $path the path of the request
 * @param callable $readBodyChunkCallable a function that will be called
 * @param array $params the parameters of the request
 * @param array|\\Stripe\\Util\\RequestOptions $opts the special modifiers of the request
 *
 * with chunks of bytes from the body if the request is successful
 */',
        'startLine' => 250,
        'endLine' => 257,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'requestCollection' => 
      array (
        'name' => 'requestCollection',
        'parameters' => 
        array (
          'method' => 
          array (
            'name' => 'method',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 269,
            'endLine' => 269,
            'startColumn' => 39,
            'endColumn' => 45,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'path' => 
          array (
            'name' => 'path',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 269,
            'endLine' => 269,
            'startColumn' => 48,
            'endColumn' => 52,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
          'params' => 
          array (
            'name' => 'params',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 269,
            'endLine' => 269,
            'startColumn' => 55,
            'endColumn' => 61,
            'parameterIndex' => 2,
            'isOptional' => false,
          ),
          'opts' => 
          array (
            'name' => 'opts',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 269,
            'endLine' => 269,
            'startColumn' => 64,
            'endColumn' => 68,
            'parameterIndex' => 3,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Sends a request to Stripe\'s API.
 *
 * @param \'delete\'|\'get\'|\'post\' $method the HTTP method
 * @param string $path the path of the request
 * @param array $params the parameters of the request
 * @param array|\\Stripe\\Util\\RequestOptions $opts the special modifiers of the request
 *
 * @return \\Stripe\\Collection|\\Stripe\\V2\\Collection of ApiResources
 */',
        'startLine' => 269,
        'endLine' => 291,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'requestSearchResult' => 
      array (
        'name' => 'requestSearchResult',
        'parameters' => 
        array (
          'method' => 
          array (
            'name' => 'method',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 303,
            'endLine' => 303,
            'startColumn' => 41,
            'endColumn' => 47,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'path' => 
          array (
            'name' => 'path',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 303,
            'endLine' => 303,
            'startColumn' => 50,
            'endColumn' => 54,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
          'params' => 
          array (
            'name' => 'params',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 303,
            'endLine' => 303,
            'startColumn' => 57,
            'endColumn' => 63,
            'parameterIndex' => 2,
            'isOptional' => false,
          ),
          'opts' => 
          array (
            'name' => 'opts',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 303,
            'endLine' => 303,
            'startColumn' => 66,
            'endColumn' => 70,
            'parameterIndex' => 3,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Sends a request to Stripe\'s API.
 *
 * @param \'delete\'|\'get\'|\'post\' $method the HTTP method
 * @param string $path the path of the request
 * @param array $params the parameters of the request
 * @param array|\\Stripe\\Util\\RequestOptions $opts the special modifiers of the request
 *
 * @return \\Stripe\\SearchResult of ApiResources
 */',
        'startLine' => 303,
        'endLine' => 315,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'apiKeyForRequest' => 
      array (
        'name' => 'apiKeyForRequest',
        'parameters' => 
        array (
          'opts' => 
          array (
            'name' => 'opts',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 324,
            'endLine' => 324,
            'startColumn' => 39,
            'endColumn' => 43,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * @param \\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\AuthenticationException
 *
 * @return string
 */',
        'startLine' => 324,
        'endLine' => 337,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'validateConfig' => 
      array (
        'name' => 'validateConfig',
        'parameters' => 
        array (
          'config' => 
          array (
            'name' => 'config',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 344,
            'endLine' => 344,
            'startColumn' => 37,
            'endColumn' => 43,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * @param array<string, mixed> $config
 *
 * @throws \\Stripe\\Exception\\InvalidArgumentException
 */',
        'startLine' => 344,
        'endLine' => 418,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'deserialize' => 
      array (
        'name' => 'deserialize',
        'parameters' => 
        array (
          'json' => 
          array (
            'name' => 'json',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 428,
            'endLine' => 428,
            'startColumn' => 33,
            'endColumn' => 37,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'apiMode' => 
          array (
            'name' => 'apiMode',
            'default' => 
            array (
              'code' => '\'v1\'',
              'attributes' => 
              array (
                'startLine' => 428,
                'endLine' => 428,
                'startTokenPos' => 2115,
                'startFilePos' => 17104,
                'endTokenPos' => 2115,
                'endFilePos' => 17107,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 428,
            'endLine' => 428,
            'startColumn' => 40,
            'endColumn' => 54,
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
 * Deserializes the raw JSON string returned by rawRequest into a similar class.
 *
 * @param string $json
 * @param \'v1\'|\'v2\' $apiMode
 *
 * @return \\Stripe\\StripeObject
 * */',
        'startLine' => 428,
        'endLine' => 431,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
        'aliasName' => NULL,
      ),
      'parseThinEvent' => 
      array (
        'name' => 'parseThinEvent',
        'parameters' => 
        array (
          'payload' => 
          array (
            'name' => 'payload',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 451,
            'endLine' => 451,
            'startColumn' => 36,
            'endColumn' => 43,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'sigHeader' => 
          array (
            'name' => 'sigHeader',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 451,
            'endLine' => 451,
            'startColumn' => 46,
            'endColumn' => 55,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
          'secret' => 
          array (
            'name' => 'secret',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 451,
            'endLine' => 451,
            'startColumn' => 58,
            'endColumn' => 64,
            'parameterIndex' => 2,
            'isOptional' => false,
          ),
          'tolerance' => 
          array (
            'name' => 'tolerance',
            'default' => 
            array (
              'code' => '\\Stripe\\Webhook::DEFAULT_TOLERANCE',
              'attributes' => 
              array (
                'startLine' => 451,
                'endLine' => 451,
                'startTokenPos' => 2166,
                'startFilePos' => 18193,
                'endTokenPos' => 2168,
                'endFilePos' => 18218,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 451,
            'endLine' => 451,
            'startColumn' => 67,
            'endColumn' => 105,
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
 * Returns a V2\\Events instance using the provided JSON payload. Throws an
 * Exception\\UnexpectedValueException if the payload is not valid JSON, and
 * an Exception\\SignatureVerificationException if the signature
 * verification fails for any reason.
 *
 * @param string $payload the payload sent by Stripe
 * @param string $sigHeader the contents of the signature header sent by
 *  Stripe
 * @param string $secret secret used to generate the signature
 * @param int $tolerance maximum difference allowed between the header\'s
 *  timestamp and the current time. Defaults to 300 seconds (5 min)
 *
 * @throws Exception\\SignatureVerificationException if the verification fails
 * @throws Exception\\UnexpectedValueException if the payload is not valid JSON,
 *
 * @return \\Stripe\\ThinEvent
 */',
        'startLine' => 451,
        'endLine' => 465,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\BaseStripeClient',
        'implementingClassName' => 'Stripe\\BaseStripeClient',
        'currentClassName' => 'Stripe\\BaseStripeClient',
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