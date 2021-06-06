<?php /** @noinspection PhpIllegalPsrClassPathInspection */
declare(strict_types=1);

namespace common\tests\unit\components;

use Codeception\Test\Unit;
use common\components\Converter;
use common\models\PaymentSystem;
use common\models\Product;
use frontend\models\BuyProductForm;
use Yii;
use yii\helpers\Json;

/**
 * Class ConverterTest
 *
 * @package common\components\unit\components
 */
class ConverterTest extends Unit
{
    /** @var \common\components\Converter|null */
    protected ?Converter $converter;

    /**
     * @throws \Exception
     */
    protected function _before()
    {
        $this->converter = Yii::$app->converter;
    }

    /**
     *
     */
    public function testCurrencies()
    {
        $currencies = $this->converter->currencies();
        self::assertArrayHasKey($this->converter->defaultCurrency, $currencies);
        foreach ($this->converter->codes as $code) {
            self::assertArrayHasKey($code, $currencies);
        }
    }

    /**
     *
     */
    public function testNameByCode()
    {
        $expectName = 'Российский рубль';
        $nameByCode = $this->converter->nameByCode($this->converter->defaultCurrency);
        self::assertEquals($expectName, $nameByCode);

        $currencies = $this->converter->currencies();
        if (array_key_exists('USD', $currencies)) {
            $expectName = 'Доллар США';
            $nameByCode = $this->converter->nameByCode('USD');
            self::assertEquals($expectName, $nameByCode);
        }
        if (array_key_exists('EUR', $currencies)) {
            $expectName = 'Евро';
            $nameByCode = $this->converter->nameByCode('EUR');
            self::assertEquals($expectName, $nameByCode);
        }
        if (array_key_exists('CNY', $currencies)) {
            $expectName = 'Китайский юань';
            $nameByCode = $this->converter->nameByCode('CNY');
            self::assertEquals($expectName, $nameByCode);
        }
        if (array_key_exists('INR', $currencies)) {
            $expectName = 'Индийских рупий';
            $nameByCode = $this->converter->nameByCode('INR');
            self::assertEquals($expectName, $nameByCode);
        }
    }

    /**
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function testConvert()
    {
        /** @var PaymentSystem $paymentSystem */
        $paymentSystem = Yii::createObject([
            'class' => PaymentSystem::class,
        ]);
        $paymentSystem->currencies = Json::encode(['USD']);

        /** @var Product $product */
        $product = Yii::createObject([
            'class' => Product::class,
        ]);
        $product->price = 10;
        $product->currency = 'USD';

        $convert = $this->converter->convert($product, $paymentSystem);
        self::assertEquals($product->price, $convert['amount']);
        self::assertEquals($product->currency, $convert['currency']);

        $currencies = $this->converter->currencies();

        if (array_key_exists('EUR', $currencies)) {
            $product->currency = 'EUR';
            $convert = $this->converter->convert($product, $paymentSystem);
            $data = $this->converter->getData($product->currency);
            $price = $product->price * $data['Value'] / $data['Nominal'];
            self::assertEquals($price, $convert['amount']);
            self::assertEquals($this->converter->defaultCurrency, $convert['currency']);
        }

        if (array_key_exists('INR', $currencies)) {
            $product->currency = 'INR';
            $convert = $this->converter->convert($product, $paymentSystem);
            $data = $this->converter->getData($product->currency);
            $price = $product->price * $data['Value'] / $data['Nominal'];
            self::assertEquals($price, $convert['amount']);
            self::assertEquals($this->converter->defaultCurrency, $convert['currency']);
        }

    }
}
