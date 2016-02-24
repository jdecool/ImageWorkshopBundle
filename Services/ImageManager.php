<?php

namespace JDecool\Bundle\ImageWorkshopBundle\Services;

use JDecool\Bundle\ImageWorkshopBundle\Factory\ImageLayerFactory;

class ImageManager
{
    /** @var ImageLayerFactory */
    private $factory;

    /** @var array */
    private $formats;


    /**
     * Constructor
     *
     * @param ImageLayerFactory $factory
     * @param array             $formats
     */
    public function __construct(ImageLayerFactory $factory, array $formats)
    {
        $this->factory = $factory;
        $this->formats = $formats;
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

        if (!isset($this->formats[$filter])) {
            throw new \RuntimeException(sprintf('"%s" format is not defined.', $filter));
        }

        $width  = $this->formats[$filter]['width'];
        $height = $this->formats[$filter]['height'];

        $layer = $this->factory->initFromPath($file, true);
        if ($layer->getWidth() / $width > $layer->getHeight() / $height) {
            $layer->resizeInPixel($width, null, true);
        } else {
            $layer->resizeInPixel(null, $height, true);
        }

        $filename = basename($file);
        $layer->save($destination, $filename);

        return sprintf('%s/%s',
            rtrim($destination, '/'),
            ltrim($filename, '/')
        );
    }
}
