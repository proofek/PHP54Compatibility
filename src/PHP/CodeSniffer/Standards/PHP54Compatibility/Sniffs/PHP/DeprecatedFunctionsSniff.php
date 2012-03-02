<?php
/**
 * PHP54Compatibility_Sniffs_PHP_DeprecatedFunctionsSniff.
 * 
 * This is based on Wim Godden's PHP53Compatibility code sniffs. 
 * See [blog](http://techblog.wimgodden.be/tag/codesniffer) and 
 * [github](https://github.com/wimg/PHP53Compat_CodeSniffer).
 * 
 * PHP version 5.4
 *
 * @category  PHP
 * @package   PHP54Compatibility
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2012 Sebastian Marek
 */

/**
 * PHP54Compatibility_Sniffs_PHP_DeprecatedFunctionsSniff.
 *
 * @category  PHP
 * @package   PHP54Compatibility
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2012 Sebastian Marek
 */
class PHP54Compatibility_Sniffs_PHP_DeprecatedFunctionsSniff extends Generic_Sniffs_PHP_ForbiddenFunctionsSniff
{
    /**
     * A list of forbidden functions with their alternatives.
     *
     * The value is NULL if no alternative exists. IE, the
     * function should just not be used.
     *
     * @var array(string => string|null)
     */
    protected $forbiddenFunctions = array(
        'import_request_variables' => null,
        'session_is_registered' => null,
        'session_register' => null,
        'session_unregister' => null,
    );

    /**
     * If true, an error will be thrown; otherwise a warning.
     *
     * @var bool
     */
    public $error = true;
}