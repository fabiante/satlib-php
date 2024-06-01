<?php

declare(strict_types=1);


namespace Fabiante\Satlib;

use GuzzleHttp\Psr7\Utils;
use InvalidArgumentException;
use PhpZip\ZipFile;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Throwable;

class Request
{

    private ?string $inputFsPath = null;

    public function withInputFs(string $path): void
    {
        $this->inputFsPath = $path;
    }

    public function getInputFs(): ?string
    {
        return $this->inputFsPath;
    }

    public function toGuzzleRequestOptions(): array
    {
        $multipart = [];

        $fs = new Filesystem();

        if ($this->inputFsPath) {
            if (!$fs->exists($this->inputFsPath)) {
                throw new InvalidArgumentException(sprintf("Dir %s does not exist", $this->inputFsPath));
            }
            if (!is_dir($this->inputFsPath)) {
                throw new InvalidArgumentException(sprintf("Path %s is not a directory", $this->inputFsPath));
            }

            $filePath = Path::join(sys_get_temp_dir(), (string)random_int(10000, 10000000)) . ".zip";
            $file = Utils::tryFopen($filePath, "w");

            // Get the given path as ZIP file
            $zip = new ZipFile();

            try {
                $zip->addDirRecursive($this->inputFsPath)
                    ->saveAsStream($file);
            } catch (Throwable $e) {
                throw new RuntimeException("Creating ZIP failed", 0, $e);
            }

            // Reopen closed file - is closed by zip writer
            $file = Utils::tryFopen($filePath, "r");

            $multipart[] = [
                "name" => "inputFs",
                "contents" => $file,
                "filename" => "inputFs.zip"
            ];
        }

        return [
            'multipart' => $multipart,
        ];
    }

}