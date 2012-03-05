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
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link      https://github.com/proofek/PHP54Compatibility
 */

/**
 * PHP54Compatibility_Sniffs_PHP_DeprecatedFunctionsSniff.
 *
 * @category  PHP
 * @package   PHP54Compatibility
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2012 Sebastian Marek
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link      https://github.com/proofek/PHP54Compatibility
 */
class PHP54Compatibility_Sniffs_PHP_DeprecatedFunctionsSniff extends Generic_Sniffs_PHP_ForbiddenFunctionsSniff
{
    /**
     * A list of deprecated functions with their alternatives.
     *
     * The value is NULL if no alternative exists. IE, the
     * function should just not be used.
     *
     * @var array(string => string|null)
     */
    protected $forbiddenFunctions = array(
        'get_magic_quotes_gpc' => null,
        'get_magic_quotes_runtime' => null,
        'set_magic_quotes_runtime' => null,
    );

    /**
     * If true, an error will be thrown; otherwise a warning.
     *
     * @var bool
     */
    public $error = false;

    /**
     * Generates the error or wanrning for this sniff.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the forbidden function
     *                                        in the token array.
     * @param string               $function  The name of the forbidden function.
     * @param string               $pattern   The pattern used for the match.
     *
     * @return void
     */
    protected function addError($phpcsFile, $stackPtr, $function, $pattern=null)
    {
        $data  = array($function);
        $error = 'The use of function %s() is ';
        $type   = 'Deprecated';
        $error .= 'deprecated';

        if ($pattern === null) {
            $pattern = $function;
        }

        if ($this->forbiddenFunctions[$pattern] !== null) {
            $type  .= 'WithAlternative';
            $data[] = $this->forbiddenFunctions[$pattern];
            $error .= '; use %s() instead';
        }

        if ($this->error === true) {
            $phpcsFile->addError("[PHP 5.4] $error", $stackPtr, $type, $data);
        } else {
            $phpcsFile->addWarning("[PHP 5.4] $error", $stackPtr, $type, $data);
        }

    }
}