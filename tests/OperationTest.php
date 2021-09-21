<?php

declare(strict_types=1);

namespace CommissionTask\Tests;

use DateTime;
use CommissionTask\Model\User;
use PHPUnit\Framework\TestCase;
use CommissionTask\Model\Operation;
use CommissionTask\Model\AmountCurrency;
use CommissionTask\Contract\Entity\Operation as AbstractOperationEntity;
use CommissionTask\Contract\Entity\User as AbstractUserEntity;
use CommissionTask\Contract\Entity\Currency as AbstractCurrencyEntity;
use CommissionTask\Exception\Validation\Operation\InvalidDate as InvalidOperationDateException;
use CommissionTask\Exception\Validation\Operation\InvalidType as InvalidOperationTypeException;

class OperationTest extends TestCase
{
    /** @var Operation */
    protected $operation;

    protected function setUp()
    {
        $operationUser = new User('1', AbstractUserEntity::TYPE_PRIVATE);
        $operationAmountCurrency = new AmountCurrency('1', AbstractCurrencyEntity::CURRENCY_EUR);

        $this->operation = new Operation(
            '2021-09-21',
            AbstractOperationEntity::TYPE_WITHDRAW,
            $operationUser,
            $operationAmountCurrency
        );
    }

    public function testGetDate()
    {
        $this->assertEquals(new DateTime('2021-09-21'), $this->operation->getDate());
    }

    public function testGetType()
    {
        $this->assertEquals(AbstractOperationEntity::TYPE_WITHDRAW, $this->operation->getType());
    }

    public function testGetUser()
    {
        $this->assertInstanceOf(User::class, $this->operation->getUser());
        $this->assertEquals('1', $this->operation->getUser()->getId());
        $this->assertEquals(AbstractUserEntity::TYPE_PRIVATE, $this->operation->getUser()->getType());
    }

    public function testGetAmountCurrency()
    {
        $this->assertInstanceOf(AmountCurrency::class, $this->operation->getAmountCurrency());
        $this->assertEquals('1', $this->operation->getAmountCurrency()->getAmount());
        $this->assertEquals(
            AbstractCurrencyEntity::CURRENCY_EUR,
            $this->operation->getAmountCurrency()->getCurrency()
        );
    }

    /** @dataProvider dataProviderForSuccessSetDateTest */
    public function testSuccessSetDate(string $newDate)
    {
        $this->operation->setDate($newDate);
        $this->assertEquals(new DateTime($newDate), $this->operation->getDate());
    }

    /** @dataProvider dataProviderForSuccessSetTypeTest */
    public function testSuccessSetType(string $newType)
    {
        $this->operation->setType($newType);
        $this->assertEquals($newType, $this->operation->getType());
    }

    /** @dataProvider dataProviderForSuccessSetUserTest */
    public function testSuccessSetUser(User $newUser)
    {
        $this->operation->setUser($newUser);

        $this->assertEquals($newUser->getId(), $this->operation->getUser()->getId());
        $this->assertEquals($newUser->getType(), $this->operation->getUser()->getType());
    }

    /** @dataProvider dataProviderForSuccessSetAmountCurrencyTest */
    public function testSuccessSetAmountCurrency(AmountCurrency $newAmountCurrency)
    {
        $this->operation->setAmountCurrency($newAmountCurrency);

        $this->assertEquals(
            $newAmountCurrency->getAmount(),
            $this->operation->getAmountCurrency()->getAmount()
        );

        $this->assertEquals(
            $newAmountCurrency->getCurrency(),
            $this->operation->getAmountCurrency()->getCurrency()
        );
    }

    /** @dataProvider dataProviderForSuccessCreatedTest */
    public function testSuccessCreated(string $date, string $type, User $user, AmountCurrency $amountCurrency)
    {
        $newOperation = new Operation($date, $type, $user, $amountCurrency);
        $this->assertInstanceOf(Operation::class, $newOperation);
    }

    /** @dataProvider dataProviderForValidationErrorOnSetIncorrectDateTest */
    public function testValidationErrorOnSetIncorrectDate(string $newIncorrectDate)
    {
        $this->expectException(InvalidOperationDateException::class);
        $this->operation->setDate($newIncorrectDate);
    }

    /** @dataProvider dataProviderForValidationErrorOnSetIncorrectTypeTest */
    public function testValidationErrorOnSetIncorrectType(string $newIncorrectType)
    {
        $this->expectException(InvalidOperationTypeException::class);
        $this->operation->setType($newIncorrectType);
    }

    public function dataProviderForSuccessSetDateTest(): array
    {
        return [
            'set new date in valid format' => ['2021-09-21'],
        ];
    }

    public function dataProviderForSuccessSetTypeTest(): array
    {
        return [
            'set withdraw operation type' => [AbstractOperationEntity::TYPE_WITHDRAW],
            'set deposit operation type' => [AbstractOperationEntity::TYPE_DEPOSIT],
        ];
    }

    public function dataProviderForSuccessSetUserTest(): array
    {
        return [
            'set Private User' => [new User('1', AbstractUserEntity::TYPE_PRIVATE)],
            'set Business User' => [new User('2', AbstractUserEntity::TYPE_BUSINESS)],
        ];
    }

    public function dataProviderForSuccessSetAmountCurrencyTest(): array
    {
        return [
            'set amount and currency in EUR' => [
                new AmountCurrency('100', AbstractCurrencyEntity::CURRENCY_EUR)
            ],
            'set amount and currency in USD' => [
                new AmountCurrency('100', AbstractCurrencyEntity::CURRENCY_USD)
            ],
            'set amount and currency in JPY' => [
                new AmountCurrency('100', AbstractCurrencyEntity::CURRENCY_JPY)
            ],
        ];
    }

    public function dataProviderForSuccessCreatedTest(): array
    {
        return [
            'create operation by given data' => [
                '2021-09-21',
                AbstractOperationEntity::TYPE_WITHDRAW,
                new User('1', AbstractUserEntity::TYPE_PRIVATE),
                new AmountCurrency('200', AbstractCurrencyEntity::CURRENCY_EUR)
            ]
        ];
    }

    public function dataProviderForValidationErrorOnSetIncorrectDateTest(): array
    {
        return [
            'incorrect date' => ['incorrect date'],
            'incorrect date format' => ['2021/09/21'],
        ];
    }

    public function dataProviderForValidationErrorOnSetIncorrectTypeTest(): array
    {
        return [
            'unsupported operation type' => ['unsupported operation type']
        ];
    }
}