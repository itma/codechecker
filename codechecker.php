<?php
           
/**
 * The class provides a basic tool to check whether a source code you
 * work with does not keep disallowed expressions. It is very helpful
 * while you are working on a big part of a system and you are just before
 * releasing the work to a test environment.
 *
 * @author andrew@itma.pl
 **/

namespace itma\code;

class Checker {

   /**
    * An absolute path to project
    * @var $path
    **/
    public $path;

   /**
    * An array with pathes to exclude during the check is being done
    * @var $excludePaths
    **/
    public $exclude = [];

   /**
    * An array with strings to check if they exist in the source code
    * @var $strings
    **/
    public $strings = [];

   /**
    * Things to do before the object take off
    * @var $strings
    **/
    public function init() {
        if (!is_array($this->strings) || count($this->strings) == 0) {
            throw new \Exception("You have to give a list of disallowed words to check if exist.");
        }
        if (empty($this->path) || !is_dir($this->path)) {
            throw new \Exception("The given path to grep through is incorrect.");
        }
    }

   /**
    * Checks the given source code against disallowed words
    * @return string
    **/
    public function check() {

        $this->init();

        $exclude = implode('| grep -v ', $this->exclude);
    
        // Basic stats
        $msg = "\nThe list of words with numbers\n";
        $msg .= "==================================\n\n";
    
        foreach ($this->strings as $string) {
            $output = array();
            exec("grep -r -o '{$string}' {$this->path} | grep -v {$exclude} | wc -l", $output);
            if ($output[0] > 0) {
                $msg .=  "String: {$string} appears \033[31m{$output[0]}\033[0m times.\n";
            } else {
                $msg .=  "String: {$string} appears \033[32m{$output[0]}\033[0m times.\n";
            }
        }
    
        // Files
        $msg .= "\nThe list of files containing disallowed words:\n";
        $msg .= "==================================\n\n";
        
        foreach ($this->strings as $string) {
            $output = array();
            exec("grep -r -l '{$string}' {$this->path} | grep -v {$exclude}", $output);
    
            if (count($output) > 0) {
    
                $msg .= "==================================\n";
                $msg .= $string . "\n";
                $msg .= "==================================\n";
    
                foreach ($output as $file) {
                    $msg .= $file . "\n";
                }
    
                $msg .= "\n";
            }
        }
    
        return $msg;

    }

}

// Create an instance
$codeChecker = new \itma\code\Checker();

// Set the path to grep through 
$codeChecker->path = '/your/path/to/source/code/';

// Skip these pathes
$codeChecker->exclude = [
    '/your/path/to/source/code/vendor/lib/',
];

// Disallowed words
$codeChecker->strings = [
    '1==0',
    '1== 0',
    '1 ==0',
    '1 == 0',
    '0 == 1',
    '0==1',
    '0 ==1',
    '0== 1',
    'print_r',
    'var_dump',
    '& false',
    '& true',
    'if(true)',
    'if( true )',
    'if( true)',
    'if(true )',
    'if(false)',
    'if( false )',
    'if( false)',
    'if(false )',
    'if (true)',
    'if ( true )',
    'if ( true)',
    'if (true )',
    'if (false)',
    'if ( false )',
    'if ( false)',
    'if (false )',
    'dupa',
    'debug_backtrace',
];

// Check!
echo $codeChecker->check();

?>