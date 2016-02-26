<?php

namespace JDecool\Bundle\ImageWorkshopBundle\Services;

use Symfony\Component\Routing\RequestContext;

class CacheManager
{
    /** @var RequestContext */
    private $requestContext;

    /** @var ImageManager */
    private $imageManager;

    /** @var string */
    private $webRoot;

    /** @var string */
    private $cachePrefix;


    /**
     * Constructor
     *
     * @param RequestContext $requestContext
     * @param ImageManager   $imageManager
     * @param string         $webRoot
     * @param string         $cachePrefix
     */
    public function __construct(RequestContext $requestContext, ImageManager $imageManager, $webRoot, $cachePrefix)
    {
        $this->requestContext = $requestContext;
        $this->imageManager   = $imageManager;
        $this->webRoot        = $webRoot;
        $this->cachePrefix    = $cachePrefix;
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
        $cachedFile = $this->getFilePath($file, $filter);
        if (is_file($cachedFile)) {
            return $this->getUrlPath($file, $filter);
        }

        $directory = dirname($cachedFile);
        if (!is_dir($directory) && !mkdir($directory, 0777, true)) {
            throw new \RuntimeException(sprintf('Unable to create "%s" directory', $directory));
        }

        $this->imageManager->transform(realpath($directory), $file, $filter);

        return $this->getUrlPath($file, $filter);
    }

    /**
     * Get cached image file path
     *
     * @param string $file
     * @param string $filter
     * @return string
     */
    protected function getFilePath($file, $filter)
    {
        return sprintf('%s/%s', $this->webRoot, $this->getBasePath($file, $filter));
    }

    /**
     * Get cached image URL
     *
     * @param string $file
     * @param string $filter
     * @return string
     */
    protected function getUrlPath($file, $filter)
    {
        return sprintf('%s/%s', $this->getBaseUrl(), $this->getBasePath($file, $filter));
    }

    /**
     * Get image path
     *
     * @param string $file
     * @param string $filter
     * @return string
     */
    protected function getBasePath($file, $filter)
    {
        if ('original' === $filter) {
            return $file;
        }

        $file = str_replace('://', '---', $file);

        return sprintf('%s/%s/%s',
            ltrim($this->cachePrefix, '/'),
            $filter,
            ltrim($file, '/')
        );
    }

    /**
     * @return string
     */
    protected function getBaseUrl()
    {
        $port = '';
        if ('https' == $this->requestContext->getScheme() && $this->requestContext->getHttpsPort() != 443) {
            $port = ":{$this->requestContext->getHttpsPort()}";
        }

        if ('http' == $this->requestContext->getScheme() && $this->requestContext->getHttpPort() != 80) {
            $port = ":{$this->requestContext->getHttpPort()}";
        }

        $baseUrl = $this->requestContext->getBaseUrl();
        if ('.php' == substr($this->requestContext->getBaseUrl(), -4)) {
            $baseUrl = pathinfo($this->requestContext->getBaseurl(), PATHINFO_DIRNAME);
        }
        $baseUrl = rtrim($baseUrl, '/\\');

        return sprintf('%s://%s%s%s',
            $this->requestContext->getScheme(),
            $this->requestContext->getHost(),
            $port,
            $baseUrl
        );
    }
}
