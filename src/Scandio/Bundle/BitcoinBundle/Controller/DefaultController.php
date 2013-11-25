<?php

namespace Scandio\Bundle\BitcoinBundle\Controller;

use Scandio\Bundle\BitcoinBundle\ExchangeRateFetcher\ExchangeRateFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/bitcoins")
 *
 * Class DefaultController
 * @package Scandio\Bundle\BitcoinBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/exchange", name="bitcoins_exchange")
     * @Route("/exchange/from:{inboundCurrency}/to:{outboundCurrency}", name="bitcoins_exchange_from_to")
     *
     */
    public function currentExchangeRateAction($inboundCurrency = 'btc', $outboundCurrency = 'usd')
    {
        /** @var ExchangeRateFetcherInterface $rateFetcher */
        $rateFetcher = $this->get('scandio_bitcoin.rate_fetcher');
        return new JsonResponse(array(
            'price' => round($rateFetcher->exchangeRate(1, $inboundCurrency, $outboundCurrency), 2)
        ));
    }
}
