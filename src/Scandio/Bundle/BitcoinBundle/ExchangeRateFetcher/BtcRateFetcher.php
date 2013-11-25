<?php
namespace Scandio\Bundle\BitcoinBundle\ExchangeRateFetcher;

use Scandio\Library\Http\HttpRequestInterface;

class BtcRateFetcher implements ExchangeRateFetcherInterface
{
    /**
     * @var \Scandio\Library\Http\HttpRequestInterface
     */
    private $httpRequester;

    /**
     * @var string
     */
    private $url;

    public function __construct(HttpRequestInterface $httpRequester, $url)
    {
        $this->httpRequester = $httpRequester;
        $this->url = $url;
    }

    /**
     * @param $price
     * @param $inboundCurrency
     * @param $outboundCurrency
     * @return float|mixed
     */
    public function exchangeRate($price, $inboundCurrency, $outboundCurrency)
    {
        $markers = array('#from_currency#', '#to_currency#', '#amount#');
        $replacements = array($inboundCurrency, $outboundCurrency, $price);

        $url = str_replace($markers, $replacements, $this->url);

        $jsonData = @json_decode($this->httpRequester->get($url), true);
        $price = 0.0;
        if (!empty($jsonData)) {
            $price = $jsonData['converted'];
        }

        return $price;
    }
}