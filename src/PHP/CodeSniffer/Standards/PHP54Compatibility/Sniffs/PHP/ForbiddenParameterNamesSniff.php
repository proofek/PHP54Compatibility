<?php
/**
 * PHP54Compatibility_Sniffs_PHP_ForbiddenParameterNameSniff.
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
 * PHP54Compatibility_Sniffs_PHP_ForbiddenParameterNamesSniff.
 *
 * Prohibits the use of particular parameter names.
 *
 * @category  PHP
 * @package   PHP54Compatibility
 * @author    LB Denker <lb@elblinkin.info>
 * @copyright 2012 LB Denker
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link      https://github.com/proofek/PHP54Compatibility
 */
class PHP54Compatibility_Sniffs_PHP_ForbiddenParameterNamesSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * A list of forbidden parameter names.
     *
     * @var array(string)
     */
    public $forbiddenParameterNames = array(
        '$GLOBALS',
        '$_SERVER',
        '$_GET',
        '$_SET',
        '$_FILES',
        '$_COOKIE',
        '$_SESSION',
        '$_REQUEST',
        '$_ENV',
    );
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_FUNCTION);
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        foreach ($phpcsFile->getMethodParameters($stackPtr) as $param) {
            if (in_array($param, $this->forbiddenParameterNames) === true) {
                $error = "[PHP 5.4] $param is not a valid parameter name.";
                $phpcsFile->addError($error, $stackPtr);
            }
        }
    }
}