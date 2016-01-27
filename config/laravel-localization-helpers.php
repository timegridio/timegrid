<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Folders where to search for lemmas
    |--------------------------------------------------------------------------
    |
    | Localization::Missing will search recursively for lemmas in all php files
    | included in these folders. You can use these keywords :
    | - %APP     : the laravel app folder of your project
    | - %BASE    : the laravel base folder of your project
    | - %PUBLIC  : the laravel public folder of your project
    | - %STORAGE : the laravel storage folder of your project
    | No error or exception is thrown when a folder does not exist.
    |
    */
    'folders'             => [
        '%BASE/resources/views',
        '%APP/Http/Controllers',
    ],

    /*
    |--------------------------------------------------------------------------
    | Lang file to ignore
    |--------------------------------------------------------------------------
    |
    | These lang files will not be written
    |
    */
    'ignore_lang_files'   => [
        'validation',
    ],

    /*
    |--------------------------------------------------------------------------
    | Lang folder
    |--------------------------------------------------------------------------
    |
    | You can overwrite where is located your lang folder
    | If null or missing, Localization::Missing will search :
    | - first in app_path() . DIRECTORY_SEPARATOR . 'lang',
    | - then  in base_path() . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'lang',
    |
    */
    'lang_folder_path'    => null,

    /*
    |--------------------------------------------------------------------------
    | Methods or functions to search for
    |--------------------------------------------------------------------------
    |
    | Localization::Missing will search lemmas by using these regular expressions
    | Several regular expressions can be used for a single method or function.
    |
    */
    'trans_methods'       => [
        'trans'        => [
            '@trans\(\s*(\'.*\')\s*(,.*)*\)@U',
            '@trans\(\s*(".*")\s*(,.*)*\)@U',
        ],
        'Lang::Get'    => [
            '@Lang::Get\(\s*(\'.*\')\s*(,.*)*\)@U',
            '@Lang::Get\(\s*(".*")\s*(,.*)*\)@U',
            '@Lang::get\(\s*(\'.*\')\s*(,.*)*\)@U',
            '@Lang::get\(\s*(".*")\s*(,.*)*\)@U',
        ],
        'trans_choice' => [
            '@trans_choice\(\s*(\'.*\')\s*,.*\)@U',
            '@trans_choice\(\s*(".*")\s*,.*\)@U',
        ],
        'Lang::choice' => [
            '@Lang::choice\(\s*(\'.*\')\s*,.*\)@U',
            '@Lang::choice\(\s*(".*")\s*,.*\)@U',
        ],
        '@lang'        => [
            '@\@lang\(\s*(\'.*\')\s*(,.*)*\)@U',
            '@\@lang\(\s*(".*")\s*(,.*)*\)@U',
        ],
        '@choice'      => [
            '@\@choice\(\s*(\'.*\')\s*,.*\)@U',
            '@\@choice\(\s*(".*")\s*,.*\)@U',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Keywords for obsolete check
    |--------------------------------------------------------------------------
    |
    | Localization::Missing will search lemmas in existing lang files.
    | Then it searches in all PHP source files.
    | When using dynamic or auto-generated lemmas, you must tell Localization::Missing
    | that there are dynamic because it cannot guess them.
    |
    | Example :
    |   - in PHP blade code : <span>{{{ trans( "message.user.dynamo.$s" ) }}}</span>
    |   - in lang/en.message.php :
    |     - 'user' => array(
    |         'dynamo' => array(
    |           'lastname'  => 'Family name',
    |           'firstname' => 'Name',
    |           'email'     => 'Email address',
    |           ...
    |   Then you can define in this parameter value dynamo for example so that
    |   Localization::Missing will not exclude lastname, firstname and email from
    |   translation files.
    |
    */
    'never_obsolete_keys' => [
        'dynamic',
        'fields',
    ],

    /*
    |--------------------------------------------------------------------------
    | Editor
    |--------------------------------------------------------------------------
    |
    | when using option editor, package will use this command to open your files
    |
    */
    'editor_command_line' => '/Applications/Sublime\\ Text.app/Contents/SharedSupport/bin/subl',

    /*
    |--------------------------------------------------------------------------
    | Code Style
    |--------------------------------------------------------------------------
    |
    | You can set a level and or fixers for the code style applied to the generated
    | lang files. More informations about the accomplished job available here :
    | http://cs.sensiolabs.org
    |
    | Level is one of null, 'psr0', 'psr1', 'psr2' or 'symfony'
    |
    | Fixers is an array one or several of these fixers :
    | - psr0 [PSR-0] : Classes must be in a path that matches their namespace, be at least one namespace deep, and the class name should match the file name.
    | - encoding [PSR-1] : PHP code MUST use only UTF-8 without BOM (remove BOM).
    | - short_tag [PSR-1] : PHP code must use the long <?php ?> tags or the short-echo <?= ?> tags; it must not use the other tag variations.
    | - braces [PSR-2] : The body of each structure MUST be enclosed by braces. Braces should be properly placed. Body of braces should be properly indented.
    | - elseif [PSR-2] : The keyword elseif should be used instead of else if so that all control keywords looks like single words.
    | - eof_ending [PSR-2] : A file must always end with a single empty line feed.
    | - function_call_space [PSR-2] : When making a method or function call, there MUST NOT be a space between the method or function name and the opening parenthesis.
    | - function_declaration [PSR-2] : Spaces should be properly placed in a function declaration.
    | - indentation [PSR-2] : Code MUST use an indent of 4 spaces, and MUST NOT use tabs for indenting.
    | - line_after_namespace [PSR-2] : There MUST be one blank line after the namespace declaration.
    | - linefeed [PSR-2] : All PHP files must use the Unix LF (linefeed) line ending.
    | - lowercase_constants [PSR-2] : The PHP constants true, false, and null MUST be in lower case.
    | - lowercase_keywords [PSR-2] : PHP keywords MUST be in lower case.
    | - method_argument_space [PSR-2] : In method arguments and method call, there MUST NOT be a space before each comma and there MUST be one space after each comma.
    | - multiple_use [PSR-2] : There MUST be one use keyword per declaration.
    | - parenthesis [PSR-2] : There MUST NOT be a space after the opening parenthesis. There MUST NOT be a space before the closing parenthesis.
    | - php_closing_tag [PSR-2] : The closing ?> tag MUST be omitted from files containing only PHP.
    | - single_line_after_imports [PSR-2] : Each namespace use MUST go on its own line and there MUST be one blank line after the use statements block.
    | - trailing_spaces [PSR-2] : Remove trailing whitespace at the end of non-blank lines.
    | - visibility [PSR-2] : Visibility MUST be declared on all properties and methods; abstract and final MUST be declared before the visibility; static MUST be declared after the visibility.
    | - array_element_no_space_before_comma [symfony] : In array declaration, there MUST NOT be a whitespace before each comma.
    | - array_element_white_space_after_comma [symfony] : In array declaration, there MUST be a whitespace after each comma.
    | - blankline_after_open_tag [symfony] : Ensure there is no code on the same line as the PHP open tag and it is followed by a blankline.
    | - concat_without_spaces [symfony] : Concatenation should be used without spaces.
    | - double_arrow_multiline_whitespaces [symfony] : Operator => should not be surrounded by multi-line whitespaces.
    | - duplicate_semicolon [symfony] : Remove duplicated semicolons.
    | - empty_return [symfony] : A return statement wishing to return nothing should be simply "return".
    | - extra_empty_lines [symfony] : Removes extra empty lines.
    | - function_typehint_space [symfony] : Add missing space between function's argument and its typehint.
    | - include [symfony] : Include and file path should be divided with a single space. File path should not be placed under brackets.
    | - join_function [symfony] : Implode function should be used instead of join function.
    | - list_commas [symfony] : Remove trailing commas in list function calls.
    | - multiline_array_trailing_comma [symfony] : PHP multi-line arrays should have a trailing comma.
    | - namespace_no_leading_whitespace [symfony] : The namespace declaration line shouldn't contain leading whitespace.
    | - new_with_braces [symfony] : All instances created with new keyword must be followed by braces.
    | - no_blank_lines_after_class_opening [symfony] : There should be no empty lines after class opening brace.
    | - no_empty_lines_after_phpdocs [symfony] : There should not be blank lines between docblock and the documented element.
    | - object_operator [symfony] : There should not be space before or after object T_OBJECT_OPERATOR.
    | - operators_spaces [symfony] : Binary operators should be surrounded by at least one space.
    | - phpdoc_indent [symfony] : Docblocks should have the same indentation as the documented subject.
    | - phpdoc_inline_tag [symfony] : Fix PHPDoc inline tags, make inheritdoc always inline.
    | - phpdoc_no_access [symfony] : @access annotations should be omitted from phpdocs.
    | - phpdoc_no_empty_return [symfony] : @return void and @return null annotations should be omitted from phpdocs.
    | - phpdoc_no_package [symfony] : @package and @subpackage annotations should be omitted from phpdocs.
    | - phpdoc_params [symfony] : All items of the @param, @throws, @return, @var, and @type phpdoc tags must be aligned vertically.
    | - phpdoc_scalar [symfony] : Scalar types should always be written in the same form. "int", not "integer"; "bool", not "boolean"; "float", not "real" or "double".
    | - phpdoc_separation [symfony] : Annotations in phpdocs should be grouped together so that annotations of the same type immediately follow each other, and annotations of a different type are separated by a single blank line.
    | - phpdoc_short_description [symfony] : Phpdocs short descriptions should end in either a full stop, exclamation mark, or question mark.
    | - phpdoc_to_comment [symfony] : Docblocks should only be used on structural elements.
    | - phpdoc_trim [symfony] : Phpdocs should start and end with content, excluding the very first and last line of the docblocks.
    | - phpdoc_type_to_var [symfony] : @type should always be written as @var.
    | - phpdoc_types [symfony] : The correct case must be used for standard PHP types in phpdoc.
    | - phpdoc_var_without_name [symfony] : @var and @type annotations should not contain the variable name.
    | - pre_increment [symfony] : Pre incrementation/decrementation should be used if possible.
    | - print_to_echo [symfony] : Converts print language construct to echo if possible.
    | - remove_leading_slash_use [symfony] : Remove leading slashes in use clauses.
    | - remove_lines_between_uses [symfony] : Removes line breaks between use statements.
    | - return [symfony] : An empty line feed should precede a return statement.
    | - self_accessor [symfony] : Inside a classy element "self" should be preferred to the class name itself.
    | - short_bool_cast [symfony] : Short cast bool using double exclamation mark should not be used.
    | - single_array_no_trailing_comma [symfony] : PHP single-line arrays should not have trailing comma.
    | - single_blank_line_before_namespace [symfony] : There should be exactly one blank line before a namespace declaration.
    | - single_quote [symfony] : Convert double quotes to single quotes for simple strings.
    | - spaces_before_semicolon [symfony] : Single-line whitespace before closing semicolon are prohibited.
    | - spaces_cast [symfony] : A single space should be between cast and variable.
    | - standardize_not_equal [symfony] : Replace all <> with !=.
    | - ternary_spaces [symfony] : Standardize spaces around ternary operator.
    | - trim_array_spaces [symfony] : Arrays should be formatted like function/method arguments, without leading or trailing single line space.
    | - unalign_double_arrow [symfony] : Unalign double arrow symbols.
    | - unalign_equals [symfony] : Unalign equals symbols.
    | - unary_operators_spaces [symfony] : Unary operators should be placed adjacent to their operands.
    | - unneeded_control_parentheses [symfony] : Removes unneeded parentheses around control statements.
    | - unused_use [symfony] : Unused use statements must be removed.
    | - whitespacy_lines [symfony] : Remove trailing whitespace at the end of blank lines.
    | - align_double_arrow [contrib] : Align double arrow symbols in consecutive lines.
    | - align_equals [contrib] : Align equals symbols in consecutive lines.
    | - concat_with_spaces [contrib] : Concatenation should be used with at least one whitespace around.
    | - echo_to_print [contrib] : Converts echo language construct to print if possible.
    | - ereg_to_preg [contrib] : Replace deprecated ereg regular expression functions with preg. Warning! This could change code behavior.
    | - header_comment [contrib] : Add, replace or remove header comment.
    | - logical_not_operators_with_spaces [contrib] : Logical NOT operators (!) should have leading and trailing whitespaces.
    | - logical_not_operators_with_successor_space [contrib] : Logical NOT operators (!) should have one trailing whitespace.
    | - long_array_syntax [contrib] : Arrays should use the long syntax.
    | - multiline_spaces_before_semicolon [contrib] : Multi-line whitespace before closing semicolon are prohibited.
    | - newline_after_open_tag [contrib] : Ensure there is no code on the same line as the PHP open tag.
    | - no_blank_lines_before_namespace [contrib] : There should be no blank lines before a namespace declaration.
    | - ordered_use [contrib] : Ordering use statements.
    | - php4_constructor [contrib] : Convert PHP4-style constructors to __construct. Warning! This could change code behavior.
    | - php_unit_construct [contrib] : PHPUnit assertion method calls like "->assertSame(true, $foo)" should be written with dedicated method like "->assertTrue($foo)". Warning! This could change code behavior.
    | - php_unit_strict [contrib] : PHPUnit methods like "assertSame" should be used instead of "assertEquals". Warning! This could change code behavior.
    | - phpdoc_order [contrib] : Annotations in phpdocs should be ordered so that param annotations come first, then throws annotations, then return annotations.
    | - phpdoc_var_to_type [contrib] : @var should always be written as @type.
    | - short_array_syntax [contrib] : PHP arrays should use the PHP 5.4 short-syntax.
    | - short_echo_tag [contrib] : Replace short-echo <?= with long format <?php echo syntax.
    | - strict [contrib] : Comparison should be strict. Warning! This could change code behavior.
    | - strict_param [contrib] : Functions should be used with $strict param. Warning! This could change code behavior.
    |
    | If both parameters are empty, no Code Style will be applied
    */
    'code_style' => [
        'level'  => 'psr2',
        'fixers' => [
                        'alias_functions',
                        'array_element_no_space_before_comma',
                        'array_element_white_space_after_comma',
                        'align_double_arrow',
                        'blankline_after_open_tag',
                        'braces',
                        'class_definition',
                        'concat_without_spaces',
                        'double_arrow_multiline_whitespaces',
                        'duplicate_semicolon',
                        'elseif',
                        'empty_return',
                        'encoding',
                        'eof_ending',
                        'extra_empty_lines',
                        'function_call_space',
                        'function_declaration',
                        'function_typehint_space',
                        'include',
                        'indentation',
                        'linefeed',
                        'line_after_namespace',
                        'list_commas',
                        'lowercase_constants',
                        'lowercase_keywords',
                        'method_argument_space',
                        'method_separation',
                        'multiline_array_trailing_comma',
                        'multiline_spaces_before_semicolon',
                        'multiple_use',
                        'namespace_no_leading_whitespace',
                        'new_with_braces',
                        'no_blank_lines_after_class_opening',
                        'no_empty_lines_after_phpdocs',
                        'object_operator',
                        'operators_spaces',
                        'ordered_use',
                        'parenthesis',
                        'phpdoc_align',
                        'phpdoc_indent',
                        'phpdoc_inline_tag',
                        'phpdoc_no_access',
                        'phpdoc_no_package',
                        'phpdoc_order',
                        'phpdoc_scalar',
                        'phpdoc_separation',
                        'phpdoc_summary',
                        'phpdoc_to_comment',
                        'phpdoc_trim',
                        'phpdoc_type_to_var',
                        'phpdoc_types',
                        'phpdoc_var_without_name',
                        'php_closing_tag',
                        'psr4',
                        'remove_leading_slash_use',
                        'remove_lines_between_uses',
                        'return',
                        'self_accessor',
                        'short_array_syntax',
                        'short_tag',
                        'single_array_no_trailing_comma',
                        'single_blank_line_before_namespace',
                        'single_line_after_imports',
                        'single_quote',
                        'spaces_after_semicolon',
                        'spaces_before_semicolon',
                        'spaces_cast',
                        'standardize_not_equal',
                        'ternary_spaces',
                        'trailing_spaces',
                        'trim_array_spaces',
                        'unalign_equals',
                        'unary_operators_spaces',
                        'unused_use',
                        'visibility',
                        'whitespacy_lines',
                    ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Translator
    |--------------------------------------------------------------------------
    |
    | Use the Microsoft translator by default. This is the only available translator now
    |
    */
    'translator' => 'Microsoft',

    /*
    |--------------------------------------------------------------------------
    | Translators configuration
    |--------------------------------------------------------------------------
    |
    | Microsoft
    |
    | #### default_language
    |
    | Set the default language used in your PHP code. If set to null, the translator
    | will try to guess it. The default language in your code is the language you use
    | in this PHP line for example :
    |
    | trans( 'message.This is a message in english' );
    |
    | Supported languages are : ar, bg, ca, cs, da, de, el, en, es, et, fa, fi, fr,
    | he, hi, ht, hu, id, it, ja, ko, lt, lv, ms, mww, nl, no, pl, pt, ro, ru, sk,
    | sl, sv, th, tr, uk, ur, vi, zh-CHS, zh-CHT
    |
    | #### client_id ans client_secret
    |
    | Package can automatically translate your lemma. Please create :
    | - You need to create an account on Microsoft Translation service
    |	https://datamarket.azure.com/dataset/bing/microsofttranslator
    | - Then you need to create an application to get a `client_id` and a `client_secret`
    |	https://datamarket.azure.com/developer/applications
    |
    | If you don't want to set these credentials here, set both to null and set both
    | environment parameters on your computer/server:
    | - LLH_MICROSOFT_TRANSLATOR_CLIENT_ID
    | - LLH_MICROSOFT_TRANSLATOR_CLIENT_SECRET
    |
    */
    'translators' => [
        'Microsoft' => [
            'default_language' => null,
            'client_id'        => null,
            'client_secret'    => null,
        ],
    ],
];
