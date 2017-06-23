# The Basic Goal

The basic goal is to avoid pushing messy source code into a repository and makes a developer sure that before the code goes to a test or production environment, it is free from any problem causing strings.

## How To Use The Class

Pull the class on your local machine. Then configure it as below:

```php
// Create an instance of the code checker
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
```

Run the command as it is showed below (remember to use the path you actually placed the file with the class):

```
dev@dev:$ php codechecker.php
```

The result you will get should be similar to the below:
```


The list of words with numbers
==================================

String: 1==0 appears 0 times.
String: 1== 0 appears 0 times.
String: 1 ==0 appears 0 times.
String: 1 == 0 appears 4 times.
String: 0 == 1 appears 0 times.
String: 0==1 appears 0 times.
String: 0 ==1 appears 0 times.
String: 0== 1 appears 0 times.
String: print_r appears 35 times.
String: var_dump appears 59 times.
String: & false appears 0 times.
String: & true appears 6 times.
String: if(true) appears 3 times.
String: if( true ) appears 0 times.
String: if( true) appears 0 times.
String: if(true ) appears 0 times.
String: if(false) appears 0 times.
String: if( false ) appears 0 times.
String: if( false) appears 0 times.
String: if(false ) appears 0 times.
String: if (true) appears 6 times.
String: if ( true ) appears 0 times.
String: if ( true) appears 0 times.
String: if (true ) appears 0 times.
String: if (false) appears 0 times.
String: if ( false ) appears 0 times.
String: if ( false) appears 0 times.
String: if (false ) appears 0 times.
String: dupa appears 0 times.
String: debug_backtrace appears 6 times.

The list of files containing disallowed words:
==================================

==================================
1 == 0
==================================
/your/path/to/source/code/file.php
/your/path/to/source/code/class.php

```
