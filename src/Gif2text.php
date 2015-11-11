<?php

namespace Bigweb\Gif2text;

use Intervention\Image\ImageManagerStatic as Image;
use Bigweb\Gif2text\GifFrameExtractor;

class Gif2text
{

    private $maxLen = 100;
    private $template, $fileName;

    public function __construct($fileName, $template, $options = []) {
        if (!file_exists($fileName)) {
            die("file " .$fileName." not found!");
        }
        $this->fileName = $fileName;
        $this->template = $template;
    }

    public function render() {

        $newColor = "MNHQ\$OC?7>!:-;. ";

        if (!GifFrameExtractor::isAnimatedGif($this->fileName)) {
            throw new Exception("Not Animated GIF File", 1);
        }

        $gif = new GifFrameExtractor();
        $frames = $gif->extract($this->fileName);

        $strings = [];
        foreach ($frames as $frame) {
            $img = Image::make($frame['image']);

            $this->generateWidth  = $img->width();
            $this->generateHeight = $img->height();

            if ($this->generateWidth > 100 && !$this->maxLen) {
                $this->maxLen = 100;
            }
            if ($this->maxLen) {
                $rate = number_format($this->maxLen / max($this->generateWidth, $this->generateHeight), 1);
                $this->generateWidth = intval($rate * $this->generateWidth);
                $this->generateHeight = intval($rate * $this->generateHeight);
                $img->resize($this->generateWidth, $this->generateHeight);
            }

            $string  = "";
            for ($h = 0; $h < $this->generateHeight; $h++) { 
                for ($w = 0; $w < $this->generateWidth; $w++) { 
                    $color = $img->pickColor($w, $h, 'array');  //array: array(255, 255, 255, 1) rgb: rgb(255, 255, 255)
                    $string .= $newColor[intval(array_sum($color) / 3.0 / 256.0 * 16)];
                }
                $string .= "\n";
            }
            $strings[] = $string; 
        }
        ob_start();
        include $this->template;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
