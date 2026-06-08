<?php declare(strict_types = 1);

// odsl-C:\xampp\htdocs\rentease\backend\src\Services\RewardService.php-PHPStan\BetterReflection\Reflection\ReflectionClass-RentEase\Services\RewardService
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.70.0.1-8.2.12-7aef8168d1c00c1db01dd852b8e2805ba7974eb9d99437eb34bdbd488d276342',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'RentEase\\Services\\RewardService',
        'filename' => 'C:/xampp/htdocs/rentease/backend/src/Services/RewardService.php',
      ),
    ),
    'namespace' => 'RentEase\\Services',
    'name' => 'RentEase\\Services\\RewardService',
    'shortName' => 'RewardService',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 32,
    'docComment' => '/**
 * Service for managing loyalty rewards and points.
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 10,
    'endLine' => 100,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'RentEase\\Services\\BaseSupabaseService',
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
      'getUserRewards' => 
      array (
        'name' => 'getUserRewards',
        'parameters' => 
        array (
          'userId' => 
          array (
            'name' => 'userId',
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
            'startLine' => 18,
            'endLine' => 18,
            'startColumn' => 36,
            'endColumn' => 49,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'array',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the reward points balance and tier for a user.
 *
 * @param string $userId
 * @return array<string, mixed>
 */',
        'startLine' => 18,
        'endLine' => 38,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'RentEase\\Services',
        'declaringClassName' => 'RentEase\\Services\\RewardService',
        'implementingClassName' => 'RentEase\\Services\\RewardService',
        'currentClassName' => 'RentEase\\Services\\RewardService',
        'aliasName' => NULL,
      ),
      'getRewardsCatalog' => 
      array (
        'name' => 'getRewardsCatalog',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'array',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the catalog of available rewards.
 *
 * @return array<int, array<string, mixed>>
 */',
        'startLine' => 45,
        'endLine' => 81,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'RentEase\\Services',
        'declaringClassName' => 'RentEase\\Services\\RewardService',
        'implementingClassName' => 'RentEase\\Services\\RewardService',
        'currentClassName' => 'RentEase\\Services\\RewardService',
        'aliasName' => NULL,
      ),
      'getRedemptionHistory' => 
      array (
        'name' => 'getRedemptionHistory',
        'parameters' => 
        array (
          'userId' => 
          array (
            'name' => 'userId',
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
            'startLine' => 89,
            'endLine' => 89,
            'startColumn' => 42,
            'endColumn' => 55,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'array',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get redemption history for a user.
 *
 * @param string $userId
 * @return array<int, array<string, mixed>>
 */',
        'startLine' => 89,
        'endLine' => 99,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'RentEase\\Services',
        'declaringClassName' => 'RentEase\\Services\\RewardService',
        'implementingClassName' => 'RentEase\\Services\\RewardService',
        'currentClassName' => 'RentEase\\Services\\RewardService',
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