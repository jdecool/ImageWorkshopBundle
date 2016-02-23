<?php

namespace JDecool\Bundle\ImageWorkshopBundle\Services;

use JDecool\Bundle\ImageWorkshopBundle\Factory\ImageLayerFactory;

class ImageManager
{
    /** @var ImageLayerFactory */
    private $factory;


    /**
     * Constructor
     *
     * @param ImageLayerFactory $factory
     */
    public function __construct(ImageLayerFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Apply transformation to an image file
     *
     * @param string $destination
     * @param string $file
     * @param string $filter
     * @return string
     */
    public function transform($destination, $file, $filter)
    {
        if ('original' === $filter) {
            return $file;
        }

        $layer = $this->factory->initFromPath($file, true);
        if ($layer->getWidth() / 200 > $layer->getHeight() / 300) {
            $layer->resizeInPixel(200, null, true);
        } else {
            $layer->resizeInPixel(null, 300, true);
        }

        $filename = basename($file);
        $layer->save($destination, $filename);

        return sprintf('%s/%s',
            rtrim($destination, '/'),
            ltrim($filename, '/')
        );
    }
}
