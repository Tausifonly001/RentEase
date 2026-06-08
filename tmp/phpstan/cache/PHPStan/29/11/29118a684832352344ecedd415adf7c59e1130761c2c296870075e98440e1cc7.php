<?php declare(strict_types = 1);

// osfsl-C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/Exception/SignatureVerificationException.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Stripe\Exception\SignatureVerificationException
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-073fcc2392eee074e6a56b665d3fd7f9747912ebccfd1648d46bc92bc59b1b6c-8.2.12-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Stripe\\Exception\\SignatureVerificationException',
        'filename' => 'C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/Exception/SignatureVerificationException.php',
      ),
    ),
    'namespace' => 'Stripe\\Exception',
    'name' => 'Stripe\\Exception\\SignatureVerificationException',
    'shortName' => 'SignatureVerificationException',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * SignatureVerificationException is thrown when the signature verification for
 * a webhook fails.
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 9,
    'endLine' => 74,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Exception',
    'implementsClassNames' => 
    array (
      0 => 'Stripe\\Exception\\ExceptionInterface',
    ),
    'traitClassNames' => 
    array (
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
      'httpBody' => 
      array (
        'declaringClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'implementingClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'name' => 'httpBody',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 11,
        'endLine' => 11,
        'startColumn' => 5,
        'endColumn' => 24,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'sigHeader' => 
      array (
        'declaringClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'implementingClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'name' => 'sigHeader',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 12,
        'endLine' => 12,
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
      'factory' => 
      array (
        'name' => 'factory',
        'parameters' => 
        array (
          'message' => 
          array (
            'name' => 'message',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 24,
            'endLine' => 24,
            'startColumn' => 9,
            'endColumn' => 16,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'httpBody' => 
          array (
            'name' => 'httpBody',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 25,
                'endLine' => 25,
                'startTokenPos' => 51,
                'startFilePos' => 707,
                'endTokenPos' => 51,
                'endFilePos' => 710,
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
            'startColumn' => 9,
            'endColumn' => 24,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
          'sigHeader' => 
          array (
            'name' => 'sigHeader',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 26,
                'endLine' => 26,
                'startTokenPos' => 58,
                'startFilePos' => 735,
                'endTokenPos' => 58,
                'endFilePos' => 738,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 26,
            'endLine' => 26,
            'startColumn' => 9,
            'endColumn' => 25,
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
 * Creates a new SignatureVerificationException exception.
 *
 * @param string $message the exception message
 * @param null|string $httpBody the HTTP body as a string
 * @param null|string $sigHeader the `Stripe-Signature` HTTP header
 *
 * @return SignatureVerificationException
 */',
        'startLine' => 23,
        'endLine' => 33,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'Stripe\\Exception',
        'declaringClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'implementingClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'currentClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'aliasName' => NULL,
      ),
      'getHttpBody' => 
      array (
        'name' => 'getHttpBody',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Gets the HTTP body as a string.
 *
 * @return null|string
 */',
        'startLine' => 40,
        'endLine' => 43,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Exception',
        'declaringClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'implementingClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'currentClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'aliasName' => NULL,
      ),
      'setHttpBody' => 
      array (
        'name' => 'setHttpBody',
        'parameters' => 
        array (
          'httpBody' => 
          array (
            'name' => 'httpBody',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 50,
            'endLine' => 50,
            'startColumn' => 33,
            'endColumn' => 41,
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
 * Sets the HTTP body as a string.
 *
 * @param null|string $httpBody
 */',
        'startLine' => 50,
        'endLine' => 53,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Exception',
        'declaringClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'implementingClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'currentClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'aliasName' => NULL,
      ),
      'getSigHeader' => 
      array (
        'name' => 'getSigHeader',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Gets the `Stripe-Signature` HTTP header.
 *
 * @return null|string
 */',
        'startLine' => 60,
        'endLine' => 63,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Exception',
        'declaringClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'implementingClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'currentClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'aliasName' => NULL,
      ),
      'setSigHeader' => 
      array (
        'name' => 'setSigHeader',
        'parameters' => 
        array (
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
            'startLine' => 70,
            'endLine' => 70,
            'startColumn' => 34,
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
 * Sets the `Stripe-Signature` HTTP header.
 *
 * @param null|string $sigHeader
 */',
        'startLine' => 70,
        'endLine' => 73,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Exception',
        'declaringClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'implementingClassName' => 'Stripe\\Exception\\SignatureVerificationException',
        'currentClassName' => 'Stripe\\Exception\\SignatureVerificationException',
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