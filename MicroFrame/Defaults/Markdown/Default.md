---
title: MicroFrame Docs
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
- navigation
---

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

2. [ ] Redis / Local caching.
3. [X] Custom route declaration.
4. [X] Path based routing.
5. [X] Multiple content type for `$this->response` YAML/JSON/XML


