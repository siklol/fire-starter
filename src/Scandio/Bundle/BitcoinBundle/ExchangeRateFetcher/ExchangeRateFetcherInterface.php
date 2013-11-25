<?php
namespace Scandio\Bundle\BitcoinBundle\ExchangeRateFetcher;

interface ExchangeRateFetcherInterface
{
    /**
     * @param $price
     * @param $inboundCurrency
     * @param $outboundCurrency
     * @return mixed
     */
    public function exchangeRate($price, $inboundCurrency, $outboundCurrency);
}