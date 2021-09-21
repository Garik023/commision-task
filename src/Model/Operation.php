<?php

declare(strict_types=1);

namespace CommissionTask\Model;

use DateTime;
use Exception;
use CommissionTask\Contract\Entity\Operation as OperationEntityContract;
use CommissionTask\Exception\Validation\{
    Operation\InvalidDate as InvalidOperationDateException,
    Operation\InvalidType as InvalidOperationTypeException,
    ValidationException
};
use CommissionTask\Factory\{
    Service\FeePolicy as FeePolicyFactory,
    Service\Config as ConfigFactory,
    Validator\Operation as OperationValidatorFactory
};

/**
 * Describes Operation entity.
 */
class Operation implements OperationEntityContract
{
    /** @var DateTime */
    protected $date;

    /** @var string */
    protected $type;

    /** @var User */
    protected $user;

    /** @var AmountCurrency */
    protected $amountCurrency;

    /***
     * Builds new Operation instance from raw string data.
     * @throws ValidationException|Exception
     */
    public function __construct(
        string $dateStr,
        string $operationType,
        User $user,
        AmountCurrency $amountCurrency
    ) {
        $this->setDate($dateStr);
        $this->setType($operationType);
        $this->setUser($user);
        $this->setAmountCurrency($amountCurrency);
    }

    /**
     *
     * Returns commission fee calculated by defined policy on configurations
     */
    public function getFee()
    {
        // get commission fee policy name from configuration for the operation
        $policyName = $this->getFeePolicyName();
        // get commission fee policy instance
        $commissionFeePolicy = FeePolicyFactory::getInstanceByName($policyName);

        // calculate commission fee for the operation
        return $commissionFeePolicy->getFeeForOperation($this);
    }

    /**
     * Converts given date to DateTime stores it to the class property
     *
     * @throws InvalidOperationDateException|Exception
     */
    public function setDate(string $date)
    {
        if (!OperationValidatorFactory::getInstance()->isDateValid($date)) {
            throw new InvalidOperationDateException($date);
        }

        $this->date = new DateTime($date);
    }

    /**
     * Sets operation type or throws an exception if passed type is not valid.
     *
     * @throws InvalidOperationTypeException
     */
    public function setType(string $type)
    {
        if (!OperationValidatorFactory::getInstance()->isOperationTypeValid($type)) {
            throw new InvalidOperationTypeException($type);
        }

        $this->type = $type;
    }

    /**
     * Sets user for operation
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * Sets amount and currency code for operation
     */
    public function setAmountCurrency(AmountCurrency $amountCurrency)
    {
        $this->amountCurrency = $amountCurrency;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getAmountCurrency(): AmountCurrency
    {
        return $this->amountCurrency;
    }

    /**
     * Returns name of a commission fee policy defined for such operation in configurations.
     */
    protected function getFeePolicyName(): string
    {
        $operationType = $this->getType();
        $operationUserType = $this->user->getType();
        return ConfigFactory::getInstance()
            ->get("fee_operations.operation_type.{$operationType}.user_type.{$operationUserType}.policy");
    }
}
