<?php
/**
 * PHP54Compatibility_Sniffs_PHP_RemovedFunctionParametersSniff.
 *
 * This is based on Wim Godden's PHP53Compatibility code sniffs.
 * See [blog](http://techblog.wimgodden.be/tag/codesniffer) and
 * [github](https://github.com/wimg/PHP53Compat_CodeSniffer).
 *
 * PHP version 5.4
 *
 * @category  PHP
 * @package   PHP54Compatibility
 * @author    Nat McHugh nat@fishtrap.co.uk
 * @copyright 2012 Nathaniel McHugh
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link      https://github.com/proofek/PHP54Compatibility
 */


class PHP54Compatibility_Sniffs_PHP_RemovedFunctionParametersSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * A list of removed functions with an assocuiated regular expression of parameters not allowed.
     *
     *
     * @var array(string => string)
     */
    protected $forbiddenFunctionsParameters = array(
                                     'putenv'    => '/^TZ=/',
                                     'hash_init' => '/salsa([1-2])0/',
                                     'hash_file' => '/salsa[1-2]0/',
                                    );

    /**
     * A cache of removed function names, for faster lookups.
     *
     * @var array(string)
     */
    protected $forbiddenFunctionNames = array();


    /**
     * If true, an error will be thrown; otherwise a warning.
     *
     * @var bool
     */
    public $error = true;


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        $this->forbiddenFunctionNames = array_keys($this->forbiddenFunctionsParameters);
        return array(T_STRING);

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in
     *                                        the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $ignore = array(
                   T_DOUBLE_COLON,
                   T_OBJECT_OPERATOR,
                   T_FUNCTION,
                   T_CONST,
                  );

        $prevToken = $phpcsFile->findPrevious(T_WHITESPACE, ($stackPtr - 1), null, true);
        if (in_array($tokens[$prevToken]['code'], $ignore) === true) {
            // Not a call to a PHP function.
            return;
        }

        $function = strtolower($tokens[$stackPtr]['content']);
        $pattern  = null;
        // if we don't have the name function bail early
        if (in_array($function, $this->forbiddenFunctionNames) === false) {
            return;
        }
        // we have a named function find the params regexes associated with it
        $associatedRegEx = $this->forbiddenFunctionsParameters[$function];
        $ptr = $stackPtr;
        $paramValues = array();
        do {
            ++$ptr;
            // will get a  whole bunch of other tonkens inc whitespace and open_parenthsis
            $paramValues[] = trim($tokens[$ptr]['content'], '"\'');
        } while (T_CLOSE_PARENTHESIS !== $tokens[$ptr]['code']);
        foreach ($paramValues  as $paramValue) {
            if (preg_match($associatedRegEx, $paramValue)) {
                $this->addError($phpcsFile, $stackPtr, $function, $associatedRegEx);
            }
        }
    }//end process()


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
        $data  = array($function, $pattern);
        $type   = 'Removed';
        $error = '[PHP 5.4] The use of function %s() has been removed for parameters matching %s';

        if ($pattern === null) {
            $pattern = $function;
        }

        if ($this->error === true) {
            $phpcsFile->addError($error, $stackPtr, $type, $data);
        } else {
            $phpcsFile->addWarning($error, $stackPtr, $type, $data);
        }

    }//end addError()


}//end class

?>
