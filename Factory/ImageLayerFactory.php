<?php

namespace JDecool\Bundle\ImageWorkshopBundle\Factory;

use PHPImageWorkshop\ImageWorkshop;
use PHPImageWorkshop\Core\ImageWorkshopLayer;

class ImageLayerFactory
{
    /**
     * Initialize a layer from a given image path
     *
     * From an upload form, you can give the "tmp_name" path
     *
     * @param string $path
     * @param bool   $fixOrientation
     * @return ImageWorkshopLayer
     */
    public function initFromPath($path, $fixOrientation = false)
    {
        return ImageWorkshop::initFromPath($path, $fixOrientation);
    }

    /**
     * Initialize a text layer
     *
     * @param string  $text
     * @param string  $fontPath
     * @param integer $fontSize
     * @param string  $fontColor
     * @param integer $textRotation
     * @param integer $backgroundColor
     * @return ImageWorkshopLayer
     */
    public function initTextLayer($text, $fontPath, $fontSize = 13, $fontColor = 'ffffff', $textRotation = 0, $backgroundColor = null)
    {
        return ImageWorkshop::initTextLayer($text, $fontPath, $fontSize, $fontColor, $textRotation, $backgroundColor);
    }

    /**
     * Initialize a new virgin layer
     *
     * @param integer $width
     * @param integer $height
     * @param string  $backgroundColor
     * @return ImageWorkshopLayer
     */
    public function initVirginLayer($width = 100, $height = 100, $backgroundColor = null)
    {
        return ImageWorkshop::initVirginLayer($width, $height, $backgroundColor);
    }

    /**
     * Initialize a layer from a resource image var
     *
     * @param \resource $image
     * @return ImageWorkshopLayer
     */
    public function initFromResourceVar($image)
    {
        return ImageWorkshop::initFromResourceVar($image);
    }

    /**
     * Initialize a layer from a string (obtains with file_get_contents, cURL...)
     *
     * This not recommanded to initialize JPEG string with this method, GD displays bugs !
     *
     * @param string $imageString
     * @return ImageWorkshopLayer
     */
    public function initFromString($imageString)
    {
        return ImageWorkshop::initFromString($imageString);
    }
}
