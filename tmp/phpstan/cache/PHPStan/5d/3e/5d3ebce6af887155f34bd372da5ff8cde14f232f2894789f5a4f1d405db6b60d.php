<?php declare(strict_types = 1);

// osfsl-C:/xampp/htdocs/rentease/vendor/composer/../resend/resend-php/src/Service/Service.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Resend\Service\Service
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-1ddaee2276074452f6d25a7970630c221fee94a766190cf2a83f64c6aeb69173-8.2.12-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Resend\\Service\\Service',
        'filename' => 'C:/xampp/htdocs/rentease/vendor/composer/../resend/resend-php/src/Service/Service.php',
      ),
    ),
    'namespace' => 'Resend\\Service',
    'name' => 'Resend\\Service\\Service',
    'shortName' => 'Service',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 64,
    'docComment' => NULL,
    'attributes' => 
    array (
    ),
    'startLine' => 14,
    'endLine' => 53,
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
      'mapping' => 
      array (
        'declaringClassName' => 'Resend\\Service\\Service',
        'implementingClassName' => 'Resend\\Service\\Service',
        'name' => 'mapping',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'api-keys\' => \\Resend\\ApiKey::class, \'audiences\' => \\Resend\\Audience::class, \'contacts\' => \\Resend\\Contact::class, \'domains\' => \\Resend\\Domain::class, \'emails\' => \\Resend\\Email::class]',
          'attributes' => 
          array (
            'startLine' => 19,
            'endLine' => 25,
            'startTokenPos' => 63,
            'startFilePos' => 338,
            'endTokenPos' => 110,
            'endFilePos' => 535,
          ),
        ),
        'docComment' => '/**
 * @var array<string, \\Resend\\Resource>
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 19,
        'endLine' => 25,
        'startColumn' => 5,
        'endColumn' => 6,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'transporter' => 
      array (
        'declaringClassName' => 'Resend\\Service\\Service',
        'implementingClassName' => 'Resend\\Service\\Service',
        'name' => 'transporter',
        'modifiers' => 130,
        'type' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'Resend\\Contracts\\Transporter',
            'isIdentifier' => false,
          ),
        ),
        'default' => NULL,
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 31,
        'endLine' => 31,
        'startColumn' => 9,
        'endColumn' => 51,
        'isPromoted' => true,
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
          'transporter' => 
          array (
            'name' => 'transporter',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'Resend\\Contracts\\Transporter',
                'isIdentifier' => false,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => true,
            'attributes' => 
            array (
            ),
            'startLine' => 31,
            'endLine' => 31,
            'startColumn' => 9,
            'endColumn' => 51,
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
 * Create a transportable instance with the given transporter.
 */',
        'startLine' => 30,
        'endLine' => 34,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Resend\\Service',
        'declaringClassName' => 'Resend\\Service\\Service',
        'implementingClassName' => 'Resend\\Service\\Service',
        'currentClassName' => 'Resend\\Service\\Service',
        'aliasName' => NULL,
      ),
      'createResource' => 
      array (
        'name' => 'createResource',
        'parameters' => 
        array (
          'resourceType' => 
          array (
            'name' => 'resourceType',
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
            'startLine' => 39,
            'endLine' => 39,
            'startColumn' => 39,
            'endColumn' => 58,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'attributes' => 
          array (
            'name' => 'attributes',
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
            'startLine' => 39,
            'endLine' => 39,
            'startColumn' => 61,
            'endColumn' => 77,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Create a new resource for the given  with the given attributes.
 */',
        'startLine' => 39,
        'endLine' => 52,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Resend\\Service',
        'declaringClassName' => 'Resend\\Service\\Service',
        'implementingClassName' => 'Resend\\Service\\Service',
        'currentClassName' => 'Resend\\Service\\Service',
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