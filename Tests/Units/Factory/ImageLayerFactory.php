<?php

namespace JDecool\Bundle\ImageWorkshopBundle\Tests\Units\Factory;

use atoum;
use PHPImageWorkshop\ImageWorkshop;

class ImageLayerFactory extends atoum
{
    public $imageSamplePath;
    public $fontSamplePath;

    public function beforeTestMethod($method)
    {
        $this->imageSamplePath = __DIR__.'/../../Fixtures/sample1.jpg';
        $this->fontSamplePath  = __DIR__.'/../../Fixtures/arial.ttf';
    }

    public function testInitFromPath()
    {
        $this
            ->if($this->newTestedInstance())
            ->then
                ->object($this->testedInstance->initFromPath($this->imageSamplePath))
                    ->isInstanceOf('PHPImageWorkshop\Core\ImageWorkshopLayer')
                ->exception(function() {
                    $this->testedInstance->initFromPath('fakePath');
                })
                    ->hasCode(ImageWorkshop::ERROR_IMAGE_NOT_FOUND)
        ;
    }

    public function testInitTextLayer()
    {
        $this
            ->if($this->newTestedInstance())
            ->then
                ->object($this->testedInstance->initTextLayer('Hello John Doe !', $this->fontSamplePath, 15, 'ff0000', 10, 'ffffff'))
                    ->isInstanceOf('PHPImageWorkshop\Core\ImageWorkshopLayer')
        ;
    }

    public function testInitVirginLayer()
    {
        $this
            ->if($this->newTestedInstance())
            ->then
                ->object($this->testedInstance->initVirginLayer(189, 242, 'ff0000'))
                    ->isInstanceOf('PHPImageWorkshop\Core\ImageWorkshopLayer')
        ;
    }

    public function testInitFromResourceVar()
    {
        $this
            ->if($this->newTestedInstance())
            ->then
                ->object($this->testedInstance->initFromResourceVar(imageCreateFromJPEG($this->imageSamplePath)))
                    ->isInstanceOf('PHPImageWorkshop\Core\ImageWorkshopLayer')
        ;
    }

    public function testInitFromString()
    {
        $this
            ->if($this->newTestedInstance())
            ->then
                ->object($this->testedInstance->initFromString(file_get_contents($this->imageSamplePath)))
                    ->isInstanceOf('PHPImageWorkshop\Core\ImageWorkshopLayer')
        ;
    }
}

