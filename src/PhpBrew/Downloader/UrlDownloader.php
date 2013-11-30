<?php
namespace PhpBrew\Downloader;

class UrlDownloader
{
    public $logger;

    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $url
     * @return string downloaded file (basename)
     */
    public function download($url)
    {
        $this->logger->info("===> Downloading from $url");

        preg_match('/php-.+\.tar\.bz2/', $url, $parts);
        $basename = $parts[0];

        // curl is faster than php
        system( 'curl -C - -# -L -o ' . $basename . ' ' . $url ) !== false or die('Download failed.');

        $this->logger->info("===> $basename downloaded.");

        if( ! file_exists($basename) ) {
            throw new \Exception("Download failed.");
        }
        return $basename; // return the filename
    }

}

