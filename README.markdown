PHP 5.4 Compatibility Coding Standard for PHP_CodeSniffer
=========================================================

This is a set of sniffs for [PHP_CodeSniffer](http://pear.php.net/PHP_CodeSniffer) that checks for PHP 5.4 compatibility.

This is based on Wim Godden's PHP53Compatibility code sniffs. See [blog](http://techblog.wimgodden.be/tag/codesniffer) and [github](https://github.com/wimg/PHP53Compat_CodeSniffer).

Installation
------------

* Discover PEAR channel with `pear channel-discover proofek.github.com/pear`
* Install PHP54Compatibility with `pear install proofek/PHP54Compatibility` (requires PHP_CodeSniffer 1.3+)
* Use the coding standard with `phpcs --standard=PHP54Compatibility`.

Sniffs 
------

* Prohibits the use of break/continue $var syntax (PHP54Compatibility_Sniffs_PHP_BreakContinueVarSyntaxSniff)
* Checks for usage of deprecated functions (PHP54Compatibility_Sniffs_PHP_DeprecatedFunctionsSniff)
 * get_magic_quotes_gpc
 * get_magic_quotes_runtime
 * set_magic_quotes_runtime
* Checks for usage of removed functions (PHP54Compatibility_Sniffs_PHP_RemovedFunctionsSniff)
 * define_syslog_variables
 * import_request_variables
 * session_is_registered
 * session_register
 * session_unregister
 * mysqli_bind_param
 * mysqli_bind_result
 * mysqli_client_encoding
 * mysqli_fetch
 * mysqli_param_count
 * mysqli_get_metadata
 * mysqli_send_long_data
* Checks for deprecated INI directives (PHP54Compatibility_Sniffs_PHP_DeprecatedIniDirectivesSniff)
 * y2k_compliance
 * session.bug_compat_42
 * session.bug_compat_warn
 * define_syslog_variables
 * highlight.bg
 * register_globals
 * register_long_arrays
 * allow_call_time_pass_reference
* Discourages the use of removed extensions. Suggests alternative extensions if available (PHP54Compatibility_Sniffs_PHP_RemovedExtensionsSniff)
 * sqlite
* Usage of particular parameter names is now forbidden (PHP54Compatibility_Sniffs_PHP_ForbiddenParameterNamesSniff)
 * $GLOBALS
 * $_SERVER
 * $_GET
 * $_SET
 * $_FILES
 * $_COOKIE
 * $_SESSION
 * $_REQUEST
 * $_ENV
* Usage of functions with particular parameters is now forbidden (PHP54Compatibility_Sniffs_PHP_RemovedFunctionParametersSniff)
 * putenv("TZ=(.*)")
 * hash_init('salsa10')
 * hash_init('salsa20')
 * hash_file('salsa10')
 * hash_file('salsa20')

Build package
-------------

* Clone with `git clone git://github.com/proofek/PHP54Compatibility.git`
* Create the package with `phing pear-package`
* Package will be created in dist subdirectory
