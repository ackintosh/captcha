<?php
session_start();
require_once 'vendor/autoload.php';
use Ackintosh\Captcha;
use Ackintosh\CaptchaConfig;

$cap = new Captcha(CaptchaConfig::instance());
$cap->output();
