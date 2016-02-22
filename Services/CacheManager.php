<?php

namespace JDecool\Bundle\ImageWorkshopBundle\Services;

class CacheManager
{
    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * Gets filtered path for rendering in the browser
     *
     * @param string $file
     * @param string $filter
     * @return string
     */
    public function getPath($file, $filter)
    {
        return $file;
    }
}
