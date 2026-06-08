<?php declare(strict_types = 1);

// osfsl-C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/Service/InvoiceRenderingTemplateService.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Stripe\Service\InvoiceRenderingTemplateService
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-36abbf370df0d27b4878ecf90e2046fbd55c37d75202af149a98330c17aae810-8.2.12-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Stripe\\Service\\InvoiceRenderingTemplateService',
        'filename' => 'C:/xampp/htdocs/rentease/vendor/composer/../stripe/stripe-php/lib/Service/InvoiceRenderingTemplateService.php',
      ),
    ),
    'namespace' => 'Stripe\\Service',
    'name' => 'Stripe\\Service\\InvoiceRenderingTemplateService',
    'shortName' => 'InvoiceRenderingTemplateService',
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
    'endLine' => 82,
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
                'startLine' => 24,
                'endLine' => 24,
                'startTokenPos' => 33,
                'startFilePos' => 772,
                'endTokenPos' => 33,
                'endFilePos' => 775,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 24,
            'endLine' => 24,
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
                'startLine' => 24,
                'endLine' => 24,
                'startTokenPos' => 40,
                'startFilePos' => 786,
                'endTokenPos' => 40,
                'endFilePos' => 789,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 24,
            'endLine' => 24,
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
 * List all templates, ordered by creation date, with the most recently created
 * template appearing first.
 *
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\Collection<\\Stripe\\InvoiceRenderingTemplate>
 */',
        'startLine' => 24,
        'endLine' => 27,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceRenderingTemplateService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceRenderingTemplateService',
        'currentClassName' => 'Stripe\\Service\\InvoiceRenderingTemplateService',
        'aliasName' => NULL,
      ),
      'archive' => 
      array (
        'name' => 'archive',
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
            'startLine' => 43,
            'endLine' => 43,
            'startColumn' => 29,
            'endColumn' => 31,
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
                'startLine' => 43,
                'endLine' => 43,
                'startTokenPos' => 81,
                'startFilePos' => 1587,
                'endTokenPos' => 81,
                'endFilePos' => 1590,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 43,
            'endLine' => 43,
            'startColumn' => 34,
            'endColumn' => 47,
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
                'startLine' => 43,
                'endLine' => 43,
                'startTokenPos' => 88,
                'startFilePos' => 1601,
                'endTokenPos' => 88,
                'endFilePos' => 1604,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 43,
            'endLine' => 43,
            'startColumn' => 50,
            'endColumn' => 61,
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
 * Updates the status of an invoice rendering template to ‘archived’ so no new
 * Stripe objects (customers, invoices, etc.) can reference it. The template can
 * also no longer be updated. However, if the template is already set on a Stripe
 * object, it will continue to be applied on invoices generated by it.
 *
 * @param string $id
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\InvoiceRenderingTemplate
 */',
        'startLine' => 43,
        'endLine' => 46,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceRenderingTemplateService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceRenderingTemplateService',
        'currentClassName' => 'Stripe\\Service\\InvoiceRenderingTemplateService',
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
            'startLine' => 61,
            'endLine' => 61,
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
                'startLine' => 61,
                'endLine' => 61,
                'startTokenPos' => 137,
                'startFilePos' => 2288,
                'endTokenPos' => 137,
                'endFilePos' => 2291,
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
                'startLine' => 61,
                'endLine' => 61,
                'startTokenPos' => 144,
                'startFilePos' => 2302,
                'endTokenPos' => 144,
                'endFilePos' => 2305,
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
 * Retrieves an invoice rendering template with the given ID. It by default returns
 * the latest version of the template. Optionally, specify a version to see
 * previous versions.
 *
 * @param string $id
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\InvoiceRenderingTemplate
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
        'declaringClassName' => 'Stripe\\Service\\InvoiceRenderingTemplateService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceRenderingTemplateService',
        'currentClassName' => 'Stripe\\Service\\InvoiceRenderingTemplateService',
        'aliasName' => NULL,
      ),
      'unarchive' => 
      array (
        'name' => 'unarchive',
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
            'startLine' => 78,
            'endLine' => 78,
            'startColumn' => 31,
            'endColumn' => 33,
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
                'startLine' => 78,
                'endLine' => 78,
                'startTokenPos' => 193,
                'startFilePos' => 2887,
                'endTokenPos' => 193,
                'endFilePos' => 2890,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 78,
            'endLine' => 78,
            'startColumn' => 36,
            'endColumn' => 49,
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
                'startLine' => 78,
                'endLine' => 78,
                'startTokenPos' => 200,
                'startFilePos' => 2901,
                'endTokenPos' => 200,
                'endFilePos' => 2904,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 78,
            'endLine' => 78,
            'startColumn' => 52,
            'endColumn' => 63,
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
 * Unarchive an invoice rendering template so it can be used on new Stripe objects
 * again.
 *
 * @param string $id
 * @param null|array $params
 * @param null|RequestOptionsArray|\\Stripe\\Util\\RequestOptions $opts
 *
 * @throws \\Stripe\\Exception\\ApiErrorException if the request fails
 *
 * @return \\Stripe\\InvoiceRenderingTemplate
 */',
        'startLine' => 78,
        'endLine' => 81,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Stripe\\Service',
        'declaringClassName' => 'Stripe\\Service\\InvoiceRenderingTemplateService',
        'implementingClassName' => 'Stripe\\Service\\InvoiceRenderingTemplateService',
        'currentClassName' => 'Stripe\\Service\\InvoiceRenderingTemplateService',
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