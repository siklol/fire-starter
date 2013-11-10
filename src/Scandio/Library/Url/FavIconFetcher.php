<?php
namespace Scandio\Library\Url;

/**
 * Class FavIconFetcher
 * @package Scandio\Library\Url
 * http://stackoverflow.com/questions/5701593/how-to-get-a-websites-favicon-with-php
 */
class FavIconFetcher
{
    private $imageDir;
    private $documentRoot;

    public function __construct($imageDir, $documentRoot)
    {
        $this->imageDir = $imageDir;
        $this->documentRoot = $documentRoot;

        if (!is_dir($imageDir)) {
            @mkdir($imageDir, 0777, true);
        }

        if (!is_dir($imageDir)) {
            throw new \Exception(sprintf("Image Dir could not be created: %s", $imageDir));
        }
    }

    /**
     * @param $url
     * @return string
     */
    public function getByGoogleService($url)
    {
        $iconData = file_get_contents("http://www.google.com/s2/favicons?domain=$url");
        $fileName = md5($url).'.png';

        file_put_contents($this->imageDir.'/'.$fileName, $iconData);

        return $this->documentRoot.'/'.$fileName;
    }
}