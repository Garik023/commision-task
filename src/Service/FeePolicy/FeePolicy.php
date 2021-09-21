<?php

namespace CommissionTask\Service\FeePolicy;

use CommissionTask\Contract\Service\FeePolicy as FeePolicyContract;
use CommissionTask\Factory\Repository\Operation as OperationRepositoryFactory;
use CommissionTask\Factory\Service\Calendar as CalendarServiceFactory;
use CommissionTask\Factory\Service\Config as ConfigFactory;
use CommissionTask\Model\Operation;
use CommissionTask\Service\API\RateAPI;
use CommissionTask\Service\Math;

class FeePolicy implements FeePolicyContract
{
    private $feePercent;
    private $freeOfCharge;
    private $calendarService;
    private $apiService;
    private $mathService;
    private $operationRepository;


    public function __construct(string $feePercent, array $freeOfCharge)
    {
        $this->feePercent = $feePercent;
        $this->freeOfCharge = $freeOfCharge;
        $this->calendarService = CalendarServiceFactory::getInstance();
        $this->operationRepository = OperationRepositoryFactory::getInstance();
        $this->apiService = RateAPI::getInstance();
        $this->mathService = new Math(ConfigFactory::getInstance()->get('math.scale'));
    }

    public static function getInstance(string $feePercent, array $freeOfCharge): FeePolicyContract
    {
        return new static($feePercent, $freeOfCharge);
    }

    /**
     * Calculates commission fee for provided operation based on user
     *
     */
    public function getFeeForOperation(Operation $operation)
    {
        $operationAmount = $operation->getAmountCurrency()->getAmount();
        $scale = ConfigFactory::getInstance()->get('math.scale');
        if($this->freeOfCharge) {
            $userOperationHistoryForWeek = $this->getWithdrowOperationsByUserAndWeek($operation);
            if (!$this->isFreeLimitExceeded($userOperationHistoryForWeek)) {
                $previousTotalEurForWeek = $this->previousTotalEurWithdrawAmountForWeek($userOperationHistoryForWeek);
                $remainedEurLimit = $this->getRemainedFreeAmount($previousTotalEurForWeek);
                $remainedLimit = $this->apiService->convertFromEur($remainedEurLimit,$operation->getAmountCurrency()->getCurrency());
                if ($remainedLimit > $operationAmount) {
                    return 0.00;
                }
                $operationAmount =  $operationAmount-$remainedLimit;
            }
        }
        return $this->mathService->percentage($operationAmount, $this->feePercent);
    }

    /**
     * Returns operations array based on user and weekstart
     */
    private function getWithdrowOperationsByUserAndWeek(Operation $operation): array
    {
        // operation user
        $user = $operation->getUser();
        // operation date's string representation
        $date = $operation->getDate()->format($this->calendarService->getSupportedDateFormat());
        // operation date's week boundaries
        $weekStart = $this->calendarService->getStartDayOfWeekForDate($date);
        // list of all operations performed by the user on the same week as current operation
        return $this->operationRepository->getUserWithdrawForWeekStart($user, $weekStart);
    }

    /**
     * Checks if free limit is exceeded defined in configs
     */
    private function isFreeLimitExceeded(array $userOperationHistory): bool
    {
        $withdrawOperationsCount = count($userOperationHistory);
        $limit = $this->freeOfCharge['free_operation_limit'] ?? 0;
        return $withdrawOperationsCount >= ((int) $limit);
    }

    /**
     * Checks total withdraw amount converted in EUR
     */
    private function previousTotalEurWithdrawAmountForWeek(array $userOperationHistory)
    {
        $totalForWeek = 0;
        foreach ($userOperationHistory as $operation) {
            $amount  = $operation->getAmountCurrency()->getAmount();
            $totalForWeek = $this->apiService->convertToEur($amount, $operation->getAmountCurrency()->getCurrency());
        }
        return $totalForWeek;
    }

    /**
     * Returns remained free amount
     */
    private function getRemainedFreeAmount($totalPreviousAmountForWeek)
    {
        $amountLimit = $this->freeOfCharge['amount'];
        return max($amountLimit-$totalPreviousAmountForWeek, 0);
    }
}