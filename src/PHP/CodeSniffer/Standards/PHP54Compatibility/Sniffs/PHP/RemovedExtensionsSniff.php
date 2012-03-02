<?php
/**
 * PHP54Compatibility_Sniffs_PHP_RemovedExtensionsSniff.
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
 * PHP54Compatibility_Sniffs_PHP_RemovedExtensionsSniff.
 *
 * Discourages the use of removed extensions. Suggests alternative extensions if available
 *
 * @category  PHP
 * @package   PHP54Compatibility
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2012 Sebastian Marek
 */
class PHP54Compatibility_Sniffs_PHP_RemovedExtensionsSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * A list of removed extensions with their alternative, if any
     *
     * @var array(string|null)
     */
    protected $removedExtensions = array(
        'sqlite' => 'pecl/sqlite',
    );

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_STRING);
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
        $tokens = $phpcsFile->getTokens();

        // Find the next non-empty token.
        $openBracket = $phpcsFile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, ($stackPtr + 1), null, true);

        if ($tokens[$openBracket]['code'] !== T_OPEN_PARENTHESIS) {
            // Not a function call.
            return;
        }

        if (isset($tokens[$openBracket]['parenthesis_closer']) === false) {
            // Not a function call.
            return;
        }

        // Find the previous non-empty token.
        $search   = PHP_CodeSniffer_Tokens::$emptyTokens;
        $search[] = T_BITWISE_AND;
        $previous = $phpcsFile->findPrevious($search, ($stackPtr - 1), null, true);
        if ($tokens[$previous]['code'] === T_FUNCTION) {
            // It's a function definition, not a function call.
            return;
        }

        if ($tokens[$previous]['code'] === T_NEW) {
            // We are creating an object, not calling a function.
            return;
        }

        if ( $tokens[$previous]['code'] === T_OBJECT_OPERATOR ) {
            // We are calling a method of an object
            return;
        }

        foreach ($this->removedExtensions as $extension => $alternative) {
            if (strpos($tokens[$stackPtr]['content'], $extension) === 0) {
                if (!is_null($alternative)) {
                    $error = "Extension '" . $extension . "' is not available in PHP 5.4 - use the '" . $alternative . "' extension instead";
                } else {
                    $error = "Extension '" . $extension . "' is not available in PHP 5.4 anymore";
                }
                $phpcsFile->addError($error, $stackPtr);
            }
        }

    }
}
