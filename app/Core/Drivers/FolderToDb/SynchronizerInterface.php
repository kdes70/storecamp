<?php

namespace App\Core\Drivers\FolderToDb;

use App\Core\Models\Folder;

/**
 * Interface SynchronizerInterface.
 */
interface SynchronizerInterface
{
    /**
     * @param string $folderPath
     * @param string $disk
     *
     * @return Folder
     */
    public function findOrCreateByFolderPath(string $folderPath, $disk = 'local') : Folder;

    /**
     * @param string $path
     * @param string $disk
     */
    public function synchronize(string $path, $disk = 'local');

    /**
     * @param string $path
     * @param string $disk
     */
    public function synchronizeWithFiles(string $path, $disk = 'local');

    /**
     * @param string $root
     * @param bool   $withFolderName
     *
     * @return array
     */
    public function directoriesIterate(string $root, bool $withFolderName = false) : array;

    /**
     * @param string $root
     * @param string $format
     * @param bool   $skipFormatEnding
     *
     * @return array
     */
    public function getFilesByFormat(string $root, string $format, bool $skipFormatEnding = false): array;
}
