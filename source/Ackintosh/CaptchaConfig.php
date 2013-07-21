<?php
namespace Ackintosh;
/**
 * Captcha configuration class.
 */
class CaptchaConfig
{
    /* Default config values */
    private $type = 'png';
    private $width = 120;
    private $height = 50;
    private $seeds = 'あいうえおかきくけこ';
    private $stringLength = 5;

    /**
     * @var array supported image format
     */
    private $validFormats = array('jpeg', 'gif', 'png');

    /**
     * Overrides default config if passed by argument array.
     */
    public function __construct(Array $config = array())
    {
        foreach ($config as $k => $v) {
            if (isset($this->$k)) $this->$k = $v;
        }
    }

    /**
     * Returns instance of CaptchaConfig.
     *
     * @return object
     */
    public static function instance(Array $config = array())
    {
        return new self($config);
    }

    /**
     * Sets property.
     * Can't change property 'validFormats'.
     *
     * @return object Self
     */
    public function __set($name, $value)
    {
        if (!isset($this->$name) || $name === 'validFormats')
            throw new \RuntimeException('invalid property');
        $this->$name = $value;
        return $this;
    }

    public function __get($name)
    {
        if (!isset($this->$name)) throw new \RuntimeException('invalid property');
        return $this->$name;
    }

    /**
     * Validates Captcha configuration.
     * Throws RuntimeException if configuration is invalid.
     *
     * @return boolean
     */
    public function isValid()
    {
        if (!is_string($this->type))
            throw new \RuntimeException('invalid type name');
        if (!in_array($this->type, $this->validFormats))
            throw new \RuntimeException($this->type . ' is not supported');

        if (!is_int($this->width) || $this->width < 1)
            throw new \RuntimeException('width should be integer and more than 1');
        if (!is_int($this->height) || $this->height < 1)
            throw new \RuntimeException('height should be integer and more than 1');

        if (!is_string($this->seeds) || mb_strlen($this->seeds) === 0)
            throw new \RuntimeException('seeds should be string');

        if (!is_int($this->stringLength) || $this->stringLength < 1)
            throw new \RuntimeException('stringLength should be integer and more than 1');
        return true;
    }
}
