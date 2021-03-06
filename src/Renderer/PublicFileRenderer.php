<?php

declare(strict_types=1);

namespace Dnd\GoogleManufacturerBundle\Renderer;

use Akeneo\Tool\Component\StorageUtils\Exception\InvalidPropertyException;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class PublicFileRenderer
 *
 * @package   Dnd\Google\Manufacturer\Component\Renderer
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2020 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class PublicFileRenderer
{
    /**
     * Description $cacheManager field
     *
     * @var CacheManager $cacheManager
     */
    private $cacheManager;
    /**
     * Description $cacheFilter field
     *
     * @var string $cacheFilter
     */
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
        if (!$fileInfo || false === $file instanceof \SplFileInfo) {
            throw new InvalidPropertyException('file_info', 'fileInfo', \SplFileInfo::class);
        }
        /** @var string $filePathKey */
        $filePathKey = $fileInfo->getPathname();

        return $this->cacheManager->getBrowserPath($filePathKey, $this->cacheFilter);
    }
}
