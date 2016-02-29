<?php

namespace JDecool\Bundle\ImageWorkshopBundle\Tests\Units\Services;

use atoum;

class ImageManager extends atoum
{
    public function testTransform()
    {
        $this
            ->given(
                $layer = $this->createMockLayer(),
                $factory = new \mock\JDecool\Bundle\ImageWorkshopBundle\Factory\ImageLayerFactory(),
                $factory->getMockController()->initFromPath = function() use ($layer) {
                    return $layer;
                },
                $formats = ['thumbnail' => [
                    'width'  => 300,
                    'height' => 200,
                ]]
            )
            ->if($this->newTestedInstance($factory, $formats))
            ->then
                ->string($this->testedInstance->transform('/path/to/dest', '/path/to/file.png', 'original'))
                    ->isEqualTo('/path/to/file.png')
                ->mock($factory)
                    ->wasNotCalled()

                ->string($this->testedInstance->transform('/path/to/dest', '/path/to/file.png', 'thumbnail'))
                    ->isEqualTo('/path/to/dest/file.png')
                ->mock($factory)
                    ->call('initFromPath')
                        ->withAtLeastArguments(['/path/to/file.png'])
                        ->once()
                ->mock($layer)
                    ->call('resizeInPixel')
                        ->once()
                    ->call('save')
                        ->withAtLeastArguments(['/path/to/dest', 'file.png'])
                        ->once()
        ;
    }

    private function createMockLayer()
    {
        $controller = new \atoum\mock\controller();
        $controller->__construct = function() {};

        $layer = new \mock\PHPImageWorkshop\Core\ImageWorkshopLayer('', [], $controller);
        $layer->getMockController()->getWidth = function() { return 1024; };
        $layer->getMockController()->getHeight = function() { return 800; };
        $layer->getMockController()->resizeInPixel = function() {};
        $layer->getMockController()->save = function() {};

        return $layer;
    }
}
