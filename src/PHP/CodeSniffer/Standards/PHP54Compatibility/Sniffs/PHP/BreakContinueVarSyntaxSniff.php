<?php
/**
 * PHP54Compatibility_Sniffs_PHP_BreakContinueVarSyntaxSniff.
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
 * PHP54Compatibility_Sniffs_PHP_BreakContinueVarSyntaxSniff.
 *
 * Prohibits the use of break/continue $var syntax
 *
 * @category  PHP
 * @package   PHP54Compatibility
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2012 Sebastian Marek
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link      https://github.com/proofek/PHP54Compatibility
 */
class PHP54Compatibility_Sniffs_PHP_BreakContinueVarSyntaxSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_BREAK, T_CONTINUE);
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
        $currentToken = $tokens[$stackPtr]['content'];

        $nextToken = $stackPtr + 1;
        while ($tokens[$nextToken]['type'] == 'T_WHITESPACE') {

            $nextToken++;
        }

        if ($tokens[$nextToken]['type'] == "T_VARIABLE") {

            $error = "[PHP 5.4] $currentToken \$var syntax is not supported!";
            $phpcsFile->addError($error, $stackPtr);
        }
    }
}