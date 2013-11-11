<?php
namespace Scandio\Library\Http;

class HtmlParser
{
    /**
     * @param $htmlData
     * @return string
     */
    public static function getTitle($htmlData)
    {
        $doc = new \DOMDocument();
        $doc->strictErrorChecking = false;
        @$doc->loadHTML($htmlData);
        $xpath = new \DOMXPath($doc);
        return $xpath->query('//title')->item(0)->nodeValue;
    }

    /**
     * @param $url
     * @return string
     */
    public static function getMetaKeywords($htmlData)
    {
        $doc = new \DOMDocument();
        @$doc->loadHTML($htmlData);

        $metas = $doc->getElementsByTagName('meta');
        $keywords = '';
        for ($i = 0; $i < $metas->length; $i++) {
            $meta = $metas->item($i);
            if($meta->getAttribute('name') == 'keywords') {
                $keywords = $meta->getAttribute('content');
            }
        }

        return $keywords;
    }
}