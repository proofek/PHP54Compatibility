PHP 5.4 Compatibility Coding Standard for PHP_CodeSniffer
=========================================================

This is a set of sniffs for [PHP_CodeSniffer](http://pear.php.net/PHP_CodeSniffer) that checks for PHP 5.4 compatibility.

This is based on Wim Godden's PHP53Compatibility code sniffs. See [blog](http://techblog.wimgodden.be/tag/codesniffer) and [github](https://github.com/wimg/PHP53Compat_CodeSniffer).

Installation
------------

* Install PHP54Compatibility with `pear install proofek/PHP54Compatibility` (requires PHP_CodeSniffer 1.3+)
* Use the coding standard with `phpcs --standard=PHP54Compatibility`.

Sniffs 
------

* Prohibits the use of break/continue $var syntax (PHP54Compatibility_Sniffs_PHP_BreakContinueVarSyntaxSniff)
* Checks for usage of deprecated functions (PHP54Compatibility_Sniffs_PHP_DeprecatedFunctionsSniff)
 * import_request_variables
 * session_is_registered
 * session_register
 * session_unregister
* Checks for deprecated INI directives
 * y2k_compliance
 * session.bug_compat42
 * session.bug_compat_warn
 * define_syslog_variables
 * highlight.bg
 * register_globals
 * register_long_arrays
 * allow_call_time_pass_reference
* Discourages the use of removed extensions. Suggests alternative extensions if available
 * sqlite

Build package
-------------

* Clone with `git clone git://github.com/proofek/PHP54Compatibility.git`
* Create the package with `phing pear package`
* Package will be created in dist subdirectory
