<?php
namespace Ackintosh;
require_once(dirname(__FILE__) . '/CaptchaConfig.php');

class Captcha
{
    private $config;

    public function __construct(CaptchaConfig $config)
    {
        $this->isRunnableEnvironment();
        $config->isValid();
        $this->config = $config;
    }

    public function isRunnableEnvironment()
    {
        if (!function_exists('imagettftext')) throw new \RuntimeException("can't use FreeType");
        if (session_id() === '') throw new \RuntimeException('session is not started');
    }

    /**
     * Outputs the Captcha image and save captcha code to session.
     *
     */
    public function output()
    {
        $image = imagecreate($this->config->width, $this->config->height);
        imagecolorallocate($image, 255, 255, 255);// background color

        // Add a few random lines
        $lineColor = imagecolorallocate($image, 196, 196, 196);
        for ($i = 0; $i < $this->config->stringLength; $i++) {
            imageline(
                $image,
                mt_rand(0, $this->config->width - 1),
                mt_rand(0, $this->config->height - 1),
                mt_rand(0, $this->config->width - 1),
                mt_rand(0, $this->config->height - 1),
                $lineColor
            );
        }

        $captchaCode = $this->generateCode();
        $_SESSION['captcha_code'] = $captchaCode;

        // Draw text
        $textColor = imagecolorallocate($image, 0, 0, 0);
        $widthPerText = $this->config->width / $this->config->stringLength;
        $fontFilepath = __DIR__ . '/ipaexg.ttf';
        for ($i = 0; $i < $this->config->stringLength; $i++) {
            $size = mt_rand(10, 18);
            $angle = mt_rand(-45, 45);
            $x = $widthPerText * $i + mt_rand(0, $widthPerText / 3);
            $y = mt_rand($this->config->height / 4, $this->config->height - $this->config->height / 4);

            imagettftext(
                $image,
                $size,
                $angle,
                $x,
                $y,
                $textColor,
                $fontFilepath,
                mb_substr(mb_convert_encoding($captchaCode, 'UTF-8'), $i, 1)
            );
        }

        $outputFuncName = 'image' . $this->config->type;
        header('Content-Type: image/' . $this->config->type);
        call_user_func($outputFuncName, $image);
        imagedestroy($image);
    }

    /**
     * Generates a Captcha code.
     *
     * @return string The challenge answer
     */
    public function generateCode()
    {
        $str = '';
        for ($i = 0; $i < $this->config->stringLength; $i++) {
            $str .= mb_substr($this->config->seeds, mt_rand(0, mb_strlen($this->config->seeds) - 1), 1);
        }
        return $str;
    }

    /**
     * Validates user's Captcha response.
     *
     * @param string $response User's captcha response
     * @return boolean
     */
    public static function isValidCode($response)
    {
        return $_SESSION['captcha_code'] === $response;
    }
}
