<?php
declare(strict_types=1);

namespace common\components;

use common\models\PaymentSystem;
use common\models\Product;
use RuntimeException;
use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class Converter
 *
 * @package common\components
 */
class Converter extends Component
{
    /** @var string */
    private const CACHE_KEY = 'v2';
    /** @var string */
    public string $defaultCurrency;
    /** @var array */
    public array $codes;
    /** @var string */
    private string $cbrUrl = 'http://www.cbr.ru/scripts/XML_daily.asp';
    /** @var array */
    private array $data = [];

    /**
     * @throws \Exception
     */
    public function init()
    {
        parent::init();

        $this->defaultCurrency();
        $this->parseCbrXml();
    }

    /**
     *
     */
    private function defaultCurrency()
    {
        $this->data[$this->defaultCurrency] = [
            'CharCode' => $this->defaultCurrency,
            'Name' => 'Российский рубль',
            'Nominal' => '1',
            'Value' => '1',
        ];
    }

    /**
     *
     */
    private function parseCbrXml()
    {
        $cacheKey = [Yii::$app->id, __METHOD__, self::CACHE_KEY];
        $data = Yii::$app->cache->get($cacheKey);
        if (!is_array($data)) {
            $cbrXml = simplexml_load_file($this->cbrUrl);
            foreach ($cbrXml as $valute) {
                if (in_array($valute->CharCode, $this->codes)) {
                    $this->data[(string)$valute->CharCode] = [
                        'CharCode' => (string)$valute->CharCode,
                        'Name' => (string)$valute->Name,
                        'Nominal' => (int)$valute->Nominal,
                        'Value' => (float)str_replace(',', '.', $valute->Value),
                    ];
                }
            }
            Yii::$app->cache->set($cacheKey, $this->data);
        } else {
            $this->data = $data;
        }
    }

    /**
     * @param string $code
     *
     * @return mixed
     */
    public function getData(string $code)
    {
        if (!$this->data[$code]) {
            throw new RuntimeException('Неправильный код валюты');
        }

        return $this->data[$code];
    }

    /**
     * @return array
     */
    public function currencies() : array
    {
        return ArrayHelper::map($this->data, 'CharCode', 'Name');
    }

    /**
     * @param Product $product
     * @param PaymentSystem $paymentSystem
     *
     * @return array
     */
    public function convert(Product $product, PaymentSystem $paymentSystem) : array
    {
        $result = [
            'amount' => $product->price,
            'currency' => $product->currency,
        ];

        if (!in_array($product->currency, Json::decode($paymentSystem->currencies))) {
            $result['amount'] = $product->price * $this->data[$product->currency]['Value'] / $this->data[$product->currency]['Nominal'];
            $result['currency'] = $this->defaultCurrency;
        }

        return $result;
    }

}