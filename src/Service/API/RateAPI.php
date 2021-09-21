<?php

declare(strict_types=1);

namespace CommissionTask\Service\API;

use CommissionTask\Contract\Entity\Currency;
use CommissionTask\Exception\Validation\Currency\InvalidCode as InvalidCurrencyCodeException;
use CommissionTask\Factory\Service\Config as ConfigFactory;
use CommissionTask\Factory\Validator\Operation as OperationValidatorFactory;
use Curl\Curl;

/**
 * Third party API for getting rates
 *
 */
class RateAPI
{

    private static $instances = [];

    private $access_token;
    private $_client;
    public $endpoint;

    /**
     * Setting configuration for Rate API service
     * Getting the instance of Rate API service
     */
    public function __construct()
    {
        $this->access_token = ConfigFactory::getInstance()->get('app.exchangeRatesApi.token');
        $this->endpoint = ConfigFactory::getInstance()->get('app.exchangeRatesApi.endpoint');
        $this->_client = new Curl();
    }

    /**
     * Returns new or existing instance of the MemoryStorage class.
     */
    public static function getInstance(): RateAPI
    {
        $className = static::class;

        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new static();
        }

        return self::$instances[$className];
    }

    /**
     * Get the response for API call GET method
     * @param array $params
     * @return false|string|null
     */
    public function get(array $params = [])
    {
       $this->_client->get($this->endpoint, $params);

        if ($this->_client->error) {
            return json_encode(
                [
                'success' => false,
                'error' => $this->_client->error_code,
                'rates' => [],
                ]);
        }
        else {
            return $this->_client->response;
        }
    }

    /**
     * Get the formatted rates data from get response of API call
     * @param null $base Base currency (default EUR)
     * @param array $symbols preferred currencies to get
     * @return array|mixed
     */
    public function getRates($base = null, array $symbols = []): array
    {
        $params = [
            'access_key' => $this->access_token,
        ];
        if ($base) {
            $params['base'] = $base;
        }
        if ($symbols) {
            $params['symbols'] = implode(',',$symbols);
        }
        $response = $this->get($params);
        $response = json_decode($response, true);
        return $response['rates'] ?? [];
    }


    /**
     *
     * As the converting option is not allowed for free plan of this API,
     * we will convert currency here manually
     *
     * @param string $toCurrency Currency convert to
     * @param float $amount amount
     * @throws InvalidCurrencyCodeException
     */
    public function convertToEur(float $amount, string $toCurrency)
    {
        $toCurrency = strtolower($toCurrency);
        if (!OperationValidatorFactory::getInstance()->isCurrencyCodeValid($toCurrency)) {
            throw new InvalidCurrencyCodeException($toCurrency);
        }

        /**
         * Data example
         *  [
         *      [EUR] => 1
         *      [USD] => 1.170775
         *      [JPY] => 128.177041
         *  ]
         */
        $rates = $this->getRates(Currency::CURRENCY_EUR, [Currency::CURRENCY_EUR, Currency::CURRENCY_USD, Currency::CURRENCY_JPY]);
        $rate = $rates[strtoupper($toCurrency)];
        return $amount/$rate;
    }

    /**
     *
     * As the converting option is not allowed for free plan of this API,
     * we will convert currency here manually
     *
     * @param string $toCurrency Currency convert to
     * @param float $amount amount
     * @throws InvalidCurrencyCodeException
     */
    public function convertFromEur(float $amount, string $toCurrency)
    {
        $toCurrency = strtolower($toCurrency);
        if (!OperationValidatorFactory::getInstance()->isCurrencyCodeValid($toCurrency)) {
            throw new InvalidCurrencyCodeException($toCurrency);
        }

        /**
         * Data example
         *  [
         *      [EUR] => 1
         *      [USD] => 1.170775
         *      [JPY] => 128.177041
         *  ]
         */
        $rates = $this->getRates(Currency::CURRENCY_EUR, [Currency::CURRENCY_EUR, Currency::CURRENCY_USD, Currency::CURRENCY_JPY]);
        $rate = $rates[strtoupper($toCurrency)];
        return $amount*$rate;

    }


}
