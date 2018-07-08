# exec
Run command line processes from within PHP

Full documentation is available at http://duncan3dc.github.io/exec/  
PHPDoc API documentation is also available at [http://duncan3dc.github.io/exec/api/](http://duncan3dc.github.io/exec/api/namespaces/duncan3dc.Exec.html)  

[![Latest Version](https://poser.pugx.org/duncan3dc/exec/version.svg)](https://packagist.org/packages/duncan3dc/exec)
[![Build Status](https://travis-ci.org/duncan3dc/exec.svg?branch=master)](https://travis-ci.org/duncan3dc/exec)
[![Coverage Status](https://coveralls.io/repos/github/duncan3dc/exec/badge.svg)](https://coveralls.io/github/duncan3dc/exec)


Quick Examples
--------------

```php
$session = new \duncan3dc\Sessions\SessionInstance("my-app");
$session->set("current-status", 4);
$currentStatus = $session->get("current-status");
```

```php
$composer = new Composer($output);
            $composer->setPath($path);
            $composer->env("COMPOSER", $tmp);
            $composer->exec("update");
```

_Read more at http://duncan3dc.github.io/sessions/_  


Changelog
---------
A [Changelog](CHANGELOG.md) has been available since the beginning of time


## Where to get help
Found a bug? Got a question? Just not sure how something works?  
Please [create an issue](//github.com/duncan3dc/exec/issues) and I'll do my best to help out.  
Alternatively you can catch me on [Twitter](https://twitter.com/duncan3dc)
