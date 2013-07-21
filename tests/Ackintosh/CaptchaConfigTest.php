<?php
use Ackintosh\CaptchaConfig;

class CaptchaConfigTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function instance_returns_self_instance()
    {
        $cc = CaptchaConfig::instance();
        $this->assertInstanceOf('Ackintosh\CaptchaConfig', $cc);
    }

    /**
     * @test
     */
    public function constructor_sets_property_from_argument_array()
    {
        $arrConfig = array(
            'type'          => 'jpeg',
            'width'         => 400,
            'height'        => 200,
            'seeds'         => 'abcdefg123456',
            'stringLength'  => 10,
        );
        $cc = new CaptchaConfig($arrConfig);

        foreach ($arrConfig as $k => $v) {
            $this->assertEquals($v, $cc->$k);
        }

        $cc2 = CaptchaConfig::instance($arrConfig);
        foreach ($arrConfig as $k => $v) {
            $this->assertEquals($v, $cc2->$k);
        }

    }

    /* --- CaptchaConfig#isValid --- */
    /* tests of VALID case */
    /**
     * @test
     */
    public function isValid_returns_true_when_type_is_string_and_valid_format_name()
    {
        $validFormats = CaptchaConfig::instance()->validFormats;
        foreach ($validFormats as $f) {
            $result = CaptchaConfig::instance(array('type' => $f))->isValid();
            $this->assertTrue($result);
        }
    }

    /**
     * @test
     */
    public function isValid_returns_true_when_width_is_integer()
    {
        $this->assertTrue(CaptchaConfig::instance(array('width' => 100))->isValid());
    }

    /**
     * @test
     */
    public function isValid_returns_true_then_seeds_is_string_and_1_or_more_chars()
    {
        $this->assertTrue(CaptchaConfig::instance(array('seeds' => 'abdc'))->isValid());
    }

    /**
     * @test
     */
    public function isValid_returns_true_when_height_is_integer()
    {
        $this->assertTrue(CaptchaConfig::instance(array('height' => 100))->isValid());
    }

    /**
     * @test
     */
    public function isValid_returns_true_when_stringLength_is_integer()
    {
        $this->assertTrue(CaptchaConfig::instance(array('stringLength' => 10))->isValid());
    }

    /* tests of INVALID case */

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage invalid type name
     */
    public function isValid_throws_RuntimeException_when_type_is_not_string()
    {
        $cc = new CaptchaConfig(array('type' => 123));
        $cc->isValid();
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage tiff is not supported
     */
    public function isValid_throws_RuntimeException_when_type_is_not_supported()
    {
        $cc = new CaptchaConfig(array('type' => 'tiff'));
        $cc->isValid();
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage width should be integer and more than 1
     */
    public function isValid_throws_RuntimeException_when_width_is_not_integer()
    {
        CaptchaConfig::instance(array('width' => "100"))->isValid();
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage width should be integer and more than 1
     */
    public function isValid_throws_RuntimeException_when_width_is_zero()
    {
        CaptchaConfig::instance(array('width' => 0))->isValid();
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage width should be integer and more than 1
     */
    public function isValid_throws_RuntimeException_when_width_is_negative()
    {
        CaptchaConfig::instance(array('width' => -1))->isValid();
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage height should be integer and more than 1
     */
    public function isValid_throws_RuntimeException_when_height_is_not_integer()
    {
        CaptchaConfig::instance(array('height' => "100"))->isValid();
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage height should be integer and more than 1
     */
    public function isValid_throws_RuntimeException_when_height_is_zero()
    {
        CaptchaConfig::instance(array('height' => 0))->isValid();
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage height should be integer and more than 1
     */
    public function isValid_throws_RuntimeException_when_height_is_negative()
    {
        CaptchaConfig::instance(array('height' => -1))->isValid();
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage seeds should be string
     */
    public function isValid_throws_RuntimeException_when_seeds_is_not_string()
    {
        CaptchaConfig::instance(array('seeds' => 1234))->isValid();
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage seeds should be string
     */
    public function isValid_throws_RuntimeException_when_seeds_length_is_zero()
    {
        CaptchaConfig::instance(array('seeds' => ''))->isValid();
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage stringLength should be integer and more than 1
     */
    public function isValid_throws_RuntimeException_when_stringLength_is_not_ingeter()
    {
        CaptchaConfig::instance(array('stringLength' => '10'))->isValid();
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage stringLength should be integer and more than 1
     */
    public function isValid_throws_RuntimeException_when_stringLength_is_zero()
    {
        CaptchaConfig::instance(array('stringLength' => 0))->isValid();
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage stringLength should be integer and more than 1
     */
    public function isValid_throws_RuntimeException_when_stringLength_is_negative()
    {
        CaptchaConfig::instance(array('stringLength' => -1))->isValid();
    }
}
