<?php

declare(strict_types=1);

namespace CommissionTask\Model;

use CommissionTask\Validation\AppException;
use CommissionTask\Instance\Validator as ValidatorInstance;

/**
 * Describes User entity.
 */
class User
{
    const TYPE_PRIVATE = 'private';
    const TYPE_BUSINESS = 'business';

    const USER_TYPES = [
        self::TYPE_PRIVATE,
        self::TYPE_BUSINESS,
    ];

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
     * @throws AppException
     */
    public function setId(string $id)
    {
        if (!ValidatorInstance::getInstance()->isIdValid($id)) {
            throw new AppException(AppException::USER_ID_INVALID, $id);
        }

        $this->id = $id;
    }

    /**
     * Sets user's type or throws an exception if passed $userType is not valid.
     *
     * @throws AppException
     */
    public function setType(string $type)
    {
        if (!ValidatorInstance::getInstance()->isTypeValid($type)) {
            throw new AppException(AppException::USER_TYPE_INVALID, $type);
        }
        $this->type = $type;
    }
}
