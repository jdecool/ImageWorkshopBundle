<?php

namespace JDecool\Bundle\ImageWorkshopBundle\Twig;

use JDecool\Bundle\ImageWorkshopBundle\Services\CacheManager;

class ImageWorkshopExtension extends \Twig_Extension
{
    /** @var CacheManager */
    private $cacheManager;


    /**
     * Constructor
     *
     * @param CacheManager $cacheManager
     */
    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('image_filter', [$this, 'imageFilter']),
        ];
    }

    /**
     * Get image URL
     *
     * @param string $file
     * @param string $filter
     * @return string
     */
    public function imageFilter($file, $filter)
    {
        return $this->cacheManager->getPath($file, $filter);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'image_workshop_extension';
    }
}
