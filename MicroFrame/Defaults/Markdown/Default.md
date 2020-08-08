---
title: "MicroFrame Docs - Sample page :fire: :boom: :zap:"
author: Godwin peter .O
date: 06-Aug-2020
image: ""
root: ""
middleware: ""
tags:
- Markdown
- PHP
- MVC
- Experiments
- Navigation
---

### Introducing to using MicroFrame.

Try it to potentially make life easy, no time for a story yet.

#### Features

1. [X] Query based models within Controllers & Tasks.

    **A simple query with default db.**
    
    ````php
    <?php
    
    $exec = $this->model()->query('sample.sample')
    ->params()->execute()
    ->result();
    
    var_dump($exec);
    
    ````
   
   **Single instance multiple queries.**
       
   ````php
   <?php
   
   $exec = $this->model('db1')->query(['sample', 'sample.sample'])
   ->params()->execute()
   ->result();
   
   var_dump($exec);
   
   ````
   
   **Single verbose instances and queries.**
       
   ````php
   <?php
   
   $exec = $this->model()->query(array('instance' => 'db1', 'model' => 'sample1.default', 'params' => array()))
   ->params()->execute()
   ->result();
   
   var_dump($exec);
   
   ````
    
    **Multiple instances and queries.**
    
    ````php
    <?php
    
    $multiUniqueInstance = array(
        array('instance' => 'db1', 'model' => 'sample1.default', 'params' => array()),
        array('instance' => 'db2', 'model' => 'sample2', 'params' => array())
    );
    
    $exec = $this->model()->query($multiUniqueInstance)
    ->params()->execute()
    ->result();
    
    var_dump($exec);
    
    ````

2. [ ] Redis / ~~Local~~ caching :bulb: on our :rocket:
3. [X] Custom route declaration.
4. [X] Path based routing.
5. [X] Multiple content type for `$this->response` YAML/JSON/XML

## A sample image inclusion.

![Kitten](/resources/images/php.jpg "A cute kitten")

## Sample complex string filter for texts between and return in a string or array.

```php
<?php
/**
* 
* No value method required, if the 4th & 5th are true, false an array of string
* is returned that matched the conditions.
* The 3rd parameter specifies if the that start and end delimiter will be included in result 
* The 6th parameter specify the max string length that will be returned.
*/
Strings::filter('testX with foo 1 bar 2333 foo 33 bar all foods yikes..')->between('foo', 'bar', false, true, false, 25);

/**
* Returns
* 
* array (size=2)
*    0 => string ' 1 ' (length=3)
*    1 => string ' 33 ' (length=4)
* 
*/
```
