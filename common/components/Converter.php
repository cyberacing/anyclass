<?php
declare(strict_types=1);

namespace common\components;

use RuntimeException;
use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;

/**
 * Class Converter
 *
 * @package common\components
 */
class Converter extends Component
{
    /** @var string */
    public string $defaultCurrency = 'RUB';
    /** @var array */
    public array $currencies;
    /** @var string */
    public string $cbrUrl = 'http://www.cbr.ru/scripts/XML_daily.asp';
    /** @var array */
    public array $data = [];
    /** @var string */
    public const CACHE_KEY = 'v1';

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
        if(!is_array($data)) {
            $cbrXml = simplexml_load_file($this->cbrUrl);
            foreach ($cbrXml as $valute) {
                if (in_array($valute->CharCode, $this->currencies)) {
                    $this->data[(string)$valute->CharCode] = [
                        'CharCode' => (string)$valute->CharCode,
                        'Name' => (string)$valute->Name,
                        'Nominal' => (string)$valute->Nominal,
                        'Value' => (string)$valute->Value,
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
     * @return string
     */
    public function nameByCode(string $code) : string
    {
        if (!$this->data[$code]) {
            throw new RuntimeException('Неправильный код валюты');
        }

        return $this->data[$code]['Name'];
    }

    /**
     * @return array
     */
    public function currencies() : array
    {
        return ArrayHelper::map($this->data, 'CharCode', 'Name');
    }

}