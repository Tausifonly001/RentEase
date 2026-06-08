<?php declare(strict_types = 1);

// osfsl-C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/Webhook.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Stripe\Webhook
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-1459465859db1ef840dba1cbbdf9bd67a1c72b50a8c3b36a6122e9966cb2e181-8.2.12-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Stripe\\Webhook',
        'filename' => 'C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/Webhook.php',
      ),
    ),
    'namespace' => 'Stripe',
    'name' => 'Stripe\\Webhook',
    'shortName' => 'Webhook',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 64,
    'docComment' => NULL,
    'attributes' => 
    array (
    ),
    'startLine' => 5,
    'endLine' => 42,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => NULL,
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
    ),
    'immediateConstants' => 
    array (
      'DEFAULT_TOLERANCE' => 
      array (
        'declaringClassName' => 'Stripe\\Webhook',
        'implementingClassName' => 'Stripe\\Webhook',
        'name' => 'DEFAULT_TOLERANCE',
        'modifiers' => 1,
        'type' => NULL,
        'value' => 
        array (
          'code' => '300',
          'attributes' => 
          array (
            'startLine' => 7,
            'endLine' => 7,
            'startTokenPos' => 21,
            'startFilePos' => 87,
            'endTokenPos' => 21,
            'endFilePos' => 89,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 7,
        'endLine' => 7,
        'startColumn' => 5,
        'endColumn' => 34,
      ),
    ),
    'immediateProperties' => 
    array (
    ),
    'immediateMethods' => 
    array (
      'constructEvent' => 
      array (
        'name' => 'constructEvent',
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
            'startLine' => 27,
            'endLine' => 27,
            'startColumn' => 43,
            'endColumn' => 50,
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
            'startLine' => 27,
            'endLine' => 27,
            'startColumn' => 53,
            'endColumn' => 62,
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
            'startLine' => 27,
            'endLine' => 27,
            'startColumn' => 65,
            'endColumn' => 71,
            'parameterIndex' => 2,
            'isOptional' => false,
          ),
          'tolerance' => 
          array (
            'name' => 'tolerance',
            'default' => 
            array (
              'code' => 'self::DEFAULT_TOLERANCE',
              'attributes' => 
              array (
                'startLine' => 27,
                'endLine' => 27,
                'startTokenPos' => 47,
                'startFilePos' => 1042,
                'endTokenPos' => 49,
                'endFilePos' => 1064,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 27,
            'endLine' => 27,
            'startColumn' => 74,
            'endColumn' => 109,
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
 * Returns an Events instance using the provided JSON payload. Throws an
 * Exception\\UnexpectedValueException if the payload is not valid JSON, and
 * an Exception\\SignatureVerificationException if the signature
 * verification fails for any reason.
 *
 * @param string $payload the payload sent by Stripe
 * @param string $sigHeader the contents of the signature header sent by
 *  Stripe
 * @param string $secret secret used to generate the signature
 * @param int $tolerance maximum difference allowed between the header\'s
 *  timestamp and the current time
 *
 * @throws Exception\\UnexpectedValueException if the payload is not valid JSON,
 * @throws Exception\\SignatureVerificationException if the verification fails
 *
 * @return Event the Events instance
 */',
        'startLine' => 27,
        'endLine' => 41,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe',
        'declaringClassName' => 'Stripe\\Webhook',
        'implementingClassName' => 'Stripe\\Webhook',
        'currentClassName' => 'Stripe\\Webhook',
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