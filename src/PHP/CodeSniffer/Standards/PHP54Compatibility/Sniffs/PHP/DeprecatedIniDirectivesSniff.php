<?php
/**
 * PHP54Compatibility_Sniffs_PHP_DeprecatedIniDirectivesSniff.
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
 * PHP54Compatibility_Sniffs_PHP_DeprecatedIniDirectivesSniff.
 *
 * Discourages the use of deprecated INI directives through ini_set() or ini_get().
 *
 * @category  PHP
 * @package   PHP54Compatibility
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2012 Sebastian Marek
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link      https://github.com/proofek/PHP54Compatibility
 */
class PHP54Compatibility_Sniffs_PHP_DeprecatedIniDirectivesSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * A list of deprecated INI directives
     *
     * @var array(string)
     */
    protected $deprecatedIniDirectives = array(
        'y2k_compliance',
        'session.bug_compat_42',
        'session.bug_compat_warn',
        'define_syslog_variables',
        'highlight.bg',
        'register_globals',
        'register_long_arrays',
        'allow_call_time_pass_reference',
    );

    /**
     * A list of removed INI directives
     *
     * @var array(string)
     */
    protected $removedIniDirectives = array(
        'define_syslog_variables',
        'register_globals',
        'register_long_arrays',
        'safe_mode',
        'safe_mode_exec_dir',
        'magic_quotes_gpc',
        'magic_quotes_runtime',
        'magic_quotes_sybase',
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
        if ($function != 'ini_get' && $function != 'ini_set') {
            return;
        }
        $iniToken = $phpcsFile->findNext(T_CONSTANT_ENCAPSED_STRING, $stackPtr, null);
        $iniDirective = str_replace("'", "", $tokens[$iniToken]['content']);
        if (in_array($iniDirective, $this->deprecatedIniDirectives) === true) {
            $error = "[PHP 5.4] INI directive " . $tokens[$iniToken]['content'] . " is deprecated.";
            $phpcsFile->addWarning($error, $stackPtr);
        } else if (in_array($iniDirective, $this->removedIniDirectives) === true) {
            $error = "[PHP 5.4] INI directive " . $tokens[$iniToken]['content'] . " is removed.";
            $phpcsFile->addError($error, $stackPtr);
        }
    }
}