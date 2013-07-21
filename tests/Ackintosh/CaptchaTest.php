<?php
use Ackintosh\Captcha;
use Ackintosh\CaptchaConfig;

class CaptchaTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        session_start();
        $this->config = new CaptchaConfig();
    }

    public function tearDown()
    {
        if (session_id() !== '') session_destroy();
    }

    /**
     * @test
     */
    public function captcha_code_length_equals_stringLength()
    {
        $seeds = 'abcdefghijklmn';

        $expectLength = 7;
        $cap = new Captcha(CaptchaConfig::instance(
            array(
                'stringLength' => $expectLength,
                'seeds' => $seeds,
            )));
        $this->assertEquals($expectLength, mb_strlen($cap->generateCode()));

        $expectLength = 1;
        $cap = new Captcha(CaptchaConfig::instance(
            array(
                'stringLength' => $expectLength,
                'seeds' => $seeds,
            )));
        $this->assertEquals($expectLength, mb_strlen($cap->generateCode()));

    }

    /**
     * @test
     */
    public function save_captcha_code_to_session()
    {
        $length = 3;
        $cap = new Captcha(CaptchaConfig::instance(array('stringLength' => $length)));
        ob_start();
        $cap->output();
        ob_end_clean();
        $this->assertTrue(isset($_SESSION['captcha_code']));
        $this->assertEquals($length, mb_strlen($_SESSION['captcha_code']));
    }

    /**
     * @test
     */
    public function isValidCode_returns_true_if_passed_valid_code()
    {
        $code = 'validcode';
        $_SESSION['captcha_code'] = $code;
        $this->assertTrue(Captcha::isValidCode($code));
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function isRunnableEnvironment_throws_RuntimeException_when_session_is_not_started()
    {
        session_destroy();
        $cap = new Captcha($this->config);
    }
}
