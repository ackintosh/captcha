#Captcha for php

This is Captcha library for php.

![sample captcha](https://dl.dropboxusercontent.com/u/22083548/github/Captcha/sample.png)

##Installation
`composer.json`

```
{
    "require": {
        "ackintosh/captcha": "dev-master"
    }
}
```

```
$ php composer.phar install
```

#Usage
###Output a default Captcha image
```php
<?php
require_once 'vendor/autoload.php';
use Ackintosh\Captcha;
use Ackintosh\CaptchaConfig;

$cap = new Captcha(CaptchaConfig::instance());
$cap->output();
```

###With settings
We can override setting.

```php
<?php
$config = array(
    'type'         => 'jpeg',
    'width'        => 200,
    'height'       => 100,
    'seeds'        => 'ABCDEFG1234567',
    'stringLength' =>10,
);
$cap = new Captcha(CaptchaConfig::instance($config));
$cap->output();
```

###Validate

```php
<?php
require_once 'vendor/autoload.php';

if (Ackintosh\Captcha::isValidCode($_POST['code']))
    echo 'ok';
else
    echo 'ng';

```


#Requirements
- PHP 5.3 or greater
- GD
- FreeType


#Thanks
- IPAex Fonts (<a href="http://ipafont.ipa.go.jp/" target="_blank">http://ipafont.ipa.go.jp/</a>)
