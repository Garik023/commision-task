<?php

declare(strict_types=1);

namespace CommissionTask\Model;

use CommissionTask\Contract\Entity\User as UserEntityContract;
use CommissionTask\Exception\Validation\User\{
    InvalidId as InvalidUserIdException,
    InvalidType as InvalidUserTypeException
};
use CommissionTask\Factory\Validator\User as UserValidatorFactory;

/**
 * Describes User entity.
 */
class User implements UserEntityContract
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $type;

    public function __construct(string $id, string $type)
    {
        $this->setId($id);
        $this->setType($type);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets user id or throws an exception if passed currencyCode is not valid.
     *
     * @throws InvalidUserIdException
     */
    public function setId(string $id)
    {
        if (!UserValidatorFactory::getInstance()->isIdValid($id)) {
            throw new InvalidUserIdException($id);
        }

        $this->id = $id;
    }

    /**
     * Sets user's type or throws an exception if passed $userType is not valid.
     *
     * @throws InvalidUserTypeException
     */
    public function setType(string $type)
    {
        if (!UserValidatorFactory::getInstance()->isTypeValid($type)) {
            throw new InvalidUserTypeException($type);
        }

        $this->type = $type;
    }
}
