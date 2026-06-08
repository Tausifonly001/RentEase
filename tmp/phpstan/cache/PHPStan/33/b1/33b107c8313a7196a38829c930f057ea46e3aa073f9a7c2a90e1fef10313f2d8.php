<?php declare(strict_types = 1);

// odsl-C:\xampp\htdocs\rentease\backend\src\Services\Email\EmailDriverFactory.php-PHPStan\BetterReflection\Reflection\ReflectionClass-RentEase\Services\Email\EmailDriverFactory
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.70.0.1-8.2.12-ac95f3b8ee544e7bbf17beed44a9004606c5350c7b6cffc4e9a9124d0e935d8d',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'RentEase\\Services\\Email\\EmailDriverFactory',
        'filename' => 'C:/xampp/htdocs/rentease/backend/src/Services/Email/EmailDriverFactory.php',
      ),
    ),
    'namespace' => 'RentEase\\Services\\Email',
    'name' => 'RentEase\\Services\\Email\\EmailDriverFactory',
    'shortName' => 'EmailDriverFactory',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * Class EmailDriverFactory
 * Responsible for creating instances of email drivers.
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 11,
    'endLine' => 29,
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
          'driver' => 
          array (
            'name' => 'driver',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 21,
            'endLine' => 21,
            'startColumn' => 35,
            'endColumn' => 48,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'config' => 
          array (
            'name' => 'config',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 21,
            'endLine' => 21,
            'startColumn' => 51,
            'endColumn' => 63,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'RentEase\\Services\\Email\\EmailInterface',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Create a driver instance based on the provided type.
 *
 * @param string $driver \'resend\' or \'phpmailer\'
 * @param array<string, mixed> $config Configuration array
 * @return EmailInterface
 * @throws \\InvalidArgumentException If driver type is unknown
 */',
        'startLine' => 21,
        'endLine' => 28,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => true,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'RentEase\\Services\\Email',
        'declaringClassName' => 'RentEase\\Services\\Email\\EmailDriverFactory',
        'implementingClassName' => 'RentEase\\Services\\Email\\EmailDriverFactory',
        'currentClassName' => 'RentEase\\Services\\Email\\EmailDriverFactory',
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