<?php

/***********************************************************************
 * The AUTODOC application requires that each line of source code be
 * packaged in HTML for browser display.  PackagerTests examines the
 * code line to see what kind of line it is and puts the appropriate
 * HTML line around the line.
 *
 * Which tests get executed for each file type (.js, .php, .css, .sql)
 * is determined in the PackagerFactory.
 *
 * PackagerTests creates an associative array of anonymous functions.
 * Each function in the packager test array is called for each line
 * of code.  If the codeline already has HTML around it, the line is
 * identified as wrapped.  If extended comments are encountered, the
 * $block flag is set to indicate that the program is in the middle
 * of a comment block.
 *
 * Putting code int an array using anonymous functions is called the
 * Strategy Pattern by Stoyan Stefanov ("Javascript Patterns", p. 155).
 * This class is modeled after "validator.js," which uses the same
 * pattern and follows Stefanov.  See BIT561/base/validator.js.
 *
 **********************************************************************/

class PackagerTests {

    private $tests = array();

    function __construct() {

        // These are closure variables used within the anonymous functions
        // created for the tests.
        $block = false;
        $wrapper = false;

        // comment
        $this->tests['comment'] = function($fileLine, &$bracecount) use (&$block, &$wrapper) {
            $fileLine = trim($fileLine);

            // ^(\/\/) matches // at the line beginning.
            // ^(\/\*) matches /* at the line beginning.
            // $(\*\/) matches */ at line end.
            if ((preg_match('/^(\/\/)|^(\/\*)|$(\*\/)/', $fileLine) || $block) && !$wrapper) {
                $fileLine = '<span class="comment">'.$fileLine.'</span><br />';
                if (strpos($fileLine, '>/*') > 0) {
                    $block = true;
                }
                if (strrpos($fileLine, '*/<') > 0) {
                    $block = false;
                }
                $wrapper = true;
            }
            return $fileLine;
        };

        // class
        $this->tests['class'] = function($fileLine, &$bracecount) use (&$block, &$wrapper) {
            if (preg_match('/class/', $fileLine)
                && strpos($fileLine, 'class') === 0
                && !$wrapper
                && !$block) {
                    $fileLine = '<span class="classDefinition">'
                        .$fileLine.'</span><div class="class body">';
                    $bracecount++;
                    $wrapper = true;
                }
            return $fileLine;
        };

        // function
        $this->tests['function'] = function($fileLine, &$bracecount) use (&$block, &$wrapper) {
            if (preg_match('/function/', $fileLine)
                && !$wrapper
                && !$block) {
                    $fileLine = trim($fileLine);

                    // Some lines include the word "function" but do not
                    // end in "{".
                    if (preg_match('/function/', $fileLine) &&
                        substr($fileLine, -1) !== "{" ) {
                            $fileLine = '<span class="codeline">'.$fileLine.'</span><br />';
                            $wrapper = true;
                            return $fileLine;
                        }


                    // If we have a simple javascript function, the keyword
                    // "function" will be in column 0 after trimming and the
                    // bracecount will be 0.  All other collapsible lines
                    // containing "function" occur when the bracecount is 1.
                    if ( (strpos($fileLine, "function") === 0 && $bracecount === 0)
                        || $bracecount === 1) {
                            $fileLine = '<span class="functionDefinition">'.
                                $fileLine.
                                '</span><div class="function body"><br />';
                            $fileLine = '<div class="functionDeclaration">'.
                                '<span class="expandFunction">++&nbsp;&nbsp;&nbsp;</span>'
                                .$fileLine;
                        } else {

                            // If the "(function() {" format is encountered
                            // in Javascript, don't treat as requiring
                            // indentation.  Other function uses establish
                            // a new statement block and require indentation
                            // (class="function body").
                            if (strpos($fileLine, "(") === 0) {
                                $fileLine = '<span class="codeline">'
                                    .$fileLine.'</span><div class="function"><br />';
                            } else {
                                $fileLine = '<span class="codeline">'
                                    .$fileLine.'</span><div class="class body"><br />';
                            }
                        }
                    $bracecount++;
                    $nestingCount = $bracecount - 1;
                    $wrapper = true;
                }
            return $fileLine;
        };

        //codeline
        $this->tests['codeline'] = function($fileLine, &$bracecount) use (&$block, &$wrapper) {
            if (!$wrapper && !$block) {

                // Prep the codeline for display in html. Remove < and >.
                $fileLine = trim($fileLine);
                $pieces = explode('<', $fileLine);
                $fileLine = implode('&lt;', $pieces);
                $pieces = explode('>', $fileLine);
                $fileLine = implode('&gt;', $pieces);

                // Handle comments at the end of code line,
                //   e.g., "bracecount++;
                // increment the counter."
                if ( strpos($fileLine, '//') > -1
                    && strpos($fileLine, ';') < strpos($fileLine, '//') ) {
                        $parts = explode('//', $fileLine);
                        $parts[1] = '<span class="comment">//'.$parts[1].'</span>';
                        $fileLine = implode('', $parts);
                    }

                $fileLine = '<span class="codeline">'.$fileLine.'</span><br />';
                $wrapper = true;

                // If there was an open brace ({) at the end of the fileLine...
                if (strrpos($fileLine, "{<") > 0) {
                    $bracecount++;
                    $fileLine = $fileLine.'<div class="body">';
                }

                // If there was a close brace (}) at the beginning of the fileLine...
                if ( $bracecount > 0 && strpos($fileLine, '>}') > 0) {
                    $fileLine = '</div>' . $fileLine;
                    $bracecount--;
                    // A function's closing brace is identified when the 
                    // brace count equals the nesting count of that 
                    // function. A zero nesting count means that the 
                    // function is not nested. A function can be nested in 
                    // a class and in other functions.
                    if ($bracecount === $nestingCount) {
                        $nestingCount--;
                        $fileLine .= '</div>';
                    }
                }
            }
            return $fileLine;
        };

        // Looking for CSS selectors.
        $this->tests['selector'] = function($fileLine, $bracecount) use (&$block, &$wrapper){
            if (!$wrapper && !$block) {
                $fileLine = trim($fileLine);
                if (strpos($fileLine, '{') || strpos($fileLine, '}') === 0)  {
                    $fileLine = '<span class="selector">'.$fileLine.'</span><br />';
                }
                if (strpos($fileLine, '}')) {
                    $fileLine = '<span class="closeSelector">'.$fileLine.'</span><br />';
                }
                $wrapper = true;
            }
            return $fileLine;
        };

        // Testing for css rules
        $this->tests['rule'] = function($fileLine, $bracecount) use (&$block, &$wrapper){
            if (!$wrapper || !$block) {
                $fileLine = trim($fileLine);
                if (strpos($fileLine, ';')) {
                    $fileLine = '<span class="rule">'.$fileLine.'</span><br />';
                }
                $wrapper = true;
            }
            return $fileLine;
        };

        // These last two functions are present to gain access to the closure variables.
        $this->tests['setFlags'] = function() use (&$wrapper, &$block) {
            $wrapper = false;
            $block = false;
        };

        $this->tests['setWrapper'] = function() use (&$wrapper) {
            $wrapper = false;
        };

    }

    public function getTests() {
        return $this->tests;
    }
}

?>
