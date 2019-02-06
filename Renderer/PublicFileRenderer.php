<?php

namespace Dnd\Bundle\GoogleManufacturerBundle\Renderer;

use Akeneo\Component\StorageUtils\Exception\InvalidPropertyException;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class PublicFileRenderer
 *
 * @category  Class
 * @package   Dnd\Bundle\GoogleManufacturerBundle\Renderer
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2019 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class PublicFileRenderer
{
    /** @var CacheManager $cacheManager */
    private $cacheManager;
    /** @var string $cacheFilter */
    private $cacheFilter;

    /**
     * PublicFileRenderer constructor
     *
     * @param CacheManager $cacheManager
     * @param string       $cacheFilter
     */
    public function __construct(
        CacheManager $cacheManager,
        string $cacheFilter
    ) {
        $this->cacheManager = $cacheManager;
        $this->cacheFilter = $cacheFilter;
    }

    /**
     * Get a public URL link for a file hosted in PIM server
     *
     * @param string $filePath
     *
     * @return string
     */
    public function getBrowserUrlPath(string $filePath): string
    {
        /** @var Filesystem $fileSystem */
        $fileSystem = new Filesystem();
        if ($fileSystem->exists($filePath)) {
            throw new FileNotFoundException(sprintf('The file : %s does not exist in the server.', $filePath));
        }
        /** @var \SplFileInfo $file */
        $file = new \SplFileInfo($filePath);
        /** @var \SplFileInfo $fileInfo */
        $fileInfo = $file->getFileInfo();
        if (!$fileInfo) {
            throw new InvalidPropertyException('file_info', 'fileInfo', \SplFileInfo::class);
        }
        /** @var string $filePathKey */
        $filePathKey = $fileInfo->getKey();

        return $this->cacheManager->getBrowserPath($filePathKey, $this->cacheFilter);
    }
}
