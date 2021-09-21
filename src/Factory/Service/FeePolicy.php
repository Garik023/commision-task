<?php

declare(strict_types=1);

namespace CommissionTask\Factory\Service;

use CommissionTask\Contract\Service\FeePolicy as FeePolicyContract;
use CommissionTask\Factory\Service\Config as ConfigFactory;

/**
 * Class CommissionFeePolicy.
 *
 * Provides with instances of Commission Fee Policy resolvers.
 */
class FeePolicy
{

    /**
     * Provides with a Commission Fee Policy instance based on passed policy name.
     */
    public static function getInstanceByName(string $commissionFeePolicyName): FeePolicyContract
    {
        // get full name of target policy handler class
        $policyConfigurations = ConfigFactory::getInstance()->get('fee_policies.'.$commissionFeePolicyName);
        $policyHandlerClassName = $policyConfigurations['policy_handler'];
        $feePercent = $policyConfigurations['percent'];
        $freeOfCharge = $policyConfigurations['free_of_charge'];

        // builds new instance based parameters defined in configurations
        return $policyHandlerClassName::getInstance($feePercent, $freeOfCharge);
    }
}
