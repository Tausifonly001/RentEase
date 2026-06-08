<?php declare(strict_types = 1);

// odsl-C:\xampp\htdocs\rentease\backend\src\Middleware\ApiSecurity.php-PHPStan\BetterReflection\Reflection\ReflectionClass-RentEase\Middleware\ApiSecurity
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.70.0.1-8.2.12-8585b15e56add4296328df848eb6e5586c550fea460bd74db9435a07b4bd6d69',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'RentEase\\Middleware\\ApiSecurity',
        'filename' => 'C:/xampp/htdocs/rentease/backend/src/Middleware/ApiSecurity.php',
      ),
    ),
    'namespace' => 'RentEase\\Middleware',
    'name' => 'RentEase\\Middleware\\ApiSecurity',
    'shortName' => 'ApiSecurity',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 32,
    'docComment' => '/**
 * Class ApiSecurity
 *
 * Provides CORS and rate-limiting enforcement for JSON API endpoints.
 * Usage: Call ApiSecurity::enforce($config) at the top of every /api/*.php file.
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 13,
    'endLine' => 93,
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
      'enforce' => 
      array (
        'name' => 'enforce',
        'parameters' => 
        array (
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
            'startColumn' => 36,
            'endColumn' => 48,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'requireAuth' => 
          array (
            'name' => 'requireAuth',
            'default' => 
            array (
              'code' => 'false',
              'attributes' => 
              array (
                'startLine' => 21,
                'endLine' => 21,
                'startTokenPos' => 46,
                'startFilePos' => 582,
                'endTokenPos' => 46,
                'endFilePos' => 586,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'bool',
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
            'endColumn' => 75,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'void',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Enforce CORS headers and basic rate limiting on API endpoints.
 *
 * @param array<string, mixed> $config The application config
 * @param bool $requireAuth Whether the endpoint requires authentication
 */',
        'startLine' => 21,
        'endLine' => 92,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'RentEase\\Middleware',
        'declaringClassName' => 'RentEase\\Middleware\\ApiSecurity',
        'implementingClassName' => 'RentEase\\Middleware\\ApiSecurity',
        'currentClassName' => 'RentEase\\Middleware\\ApiSecurity',
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