<?php

declare(strict_types=1);

namespace CommissionTask\Instance;

use CommissionTask\Factory\FeePolicy as FeePolicyFactory;
use CommissionTask\Instance\Config as ConfigInstance;

/**
 * Make FeePolicy instance
 *
 */
class FeePolicy
{
    /**
     * Makes Fee Policy instance based on passed policy name with options from config.
     */
    public static function getInstanceByName(string $commissionFeePolicyName): FeePolicyFactory
    {
        $policyConfigurations = ConfigInstance::getInstance()->get('fee_policies.'.$commissionFeePolicyName);
        $policyHandlerClassName = $policyConfigurations['policy_handler'];
        $feePercent = $policyConfigurations['percent'];
        $freeOfCharge = $policyConfigurations['free_of_charge'];

        return $policyHandlerClassName::getInstance($feePercent, $freeOfCharge);
    }
}
