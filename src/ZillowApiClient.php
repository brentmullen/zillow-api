<?php

namespace ZillowApi;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Message\ResponseInterface;
use ZillowApi\Model\Response;

/**
 * Zillow PHP API Client
 *
 * @author Brent Mullen <brent.mullen@gmail.com>
 */
class ZillowApiClient
{
    /**
     * @var string
     */
    protected $url = 'http://www.zillow.com/webservice/';

    /**
     * @var GuzzleClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $zwsid;

    /**
     * @var int
     */
    protected $responseCode = 0;

    /**
     * @var string
     */
    protected $responseMessage = null;

    /**
     * @var array
     */
    protected $response;

    /**
     * @var array
     */
    protected $results;

    /**
     * @var array
     */
    protected $photos = [];

    /**
     * @var array
     *
     * Valid API functions
     */
    public static $validMethods = [
        'GetZestimate',
        'GetSearchResults',
        'GetChart',
        'GetComps',
        'GetDeepComps',
        'GetDeepSearchResults',
        'GetUpdatedPropertyDetails',
        'GetDemographics',
        'GetRegionChildren',
        'GetRegionChart',
        'GetRateSummary',
        'GetMonthlyPayments',
        'CalculateMonthlyPaymentsAdvanced',
        'CalculateAffordability',
        'CalculateRefinance',
        'CalculateAdjustableMortgage',
        'CalculateMortgageTerms',
        'CalculateDiscountPoints',
        'CalculateBiWeeklyPayment',
        'CalculateNoCostVsTraditional',
        'CalculateTaxSavings',
        'CalculateFixedVsAdjustableRate',
        'CalculateInterstOnlyVsTraditional',
        'CalculateHELOC',
    ];

    /**
     * @param string $zwsid
     * @param string|null $url
     */
    public function __construct($zwsid, $url = null)
    {
        $this->zwsid = $zwsid;

        if ($url) {
            $this->url = $url;
        }
    }

    /**
     * @return string
     */
    protected function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    protected function getZwsid()
    {
        return $this->zwsid;
    }

    /**
     * @param GuzzleClientInterface $client
     *
     * @return ZillowApiClient
     */
    public function setClient(GuzzleClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return GuzzleClient
     */
    public function getClient()
    {
        if (!$this->client) {
            $this->client = new GuzzleClient(
                [
                    'defaults' => [
                        'allow_redirects' => false,
                        'cookies'         => true
                    ]
                ]
            );
        }

        return $this->client;
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return Response
     */
    public function execute($name, $arguments)
    {
        if (!in_array($name, self::$validMethods)) {
            throw new ZillowException(sprintf('Invalid Zillow API method (%s)', $name));
        }

        return $this->doRequest($name, $arguments);
    }

    /**
     * @param string $call
     * @param array $params
     *
     * @return Response
     * @throws ZillowException
     */
    protected function doRequest($call, array $params)
    {
        if (!$this->getZwsid()) {
            throw new ZillowException('Missing ZWS-ID');
        }

        $response = $this->getClient()->get(
            $this->url . $call . '.htm',
            [
                'query' => array_merge(
                    ['zws-id' => $this->getZwsid()],
                    $params
                ),
            ]
        );

        return $this->parseResponse($call, $response);
    }

    /**
     * @param string $call
     * @param ResponseInterface $rawResponse
     *
     * @return Response
     */
    protected function parseResponse($call, ResponseInterface $rawResponse)
    {
        $response      = new Response();
        $responseArray = json_decode(json_encode($rawResponse->xml()), true);
        $response->setMethod($call);

        if (!array_key_exists('message', $responseArray)) {
            $response->setCode(999);
            $response->setMessage('Invalid response received.');
        } else {
            $response->setCode(intval($responseArray['message']['code']));
            $response->setMessage($responseArray['message']['text']);
        }

        if ($response->isSuccessful() && array_key_exists('response', $responseArray)) {
            $response->setData($responseArray['response']);
        }

        return $response;
    }
}