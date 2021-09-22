<?php

namespace CommissionTask\Service\FeePolicy;

use CommissionTask\Factory\Calendar;
use CommissionTask\Factory\FeePolicy as FeePolicyFactory;
use CommissionTask\Model\Operation;
use CommissionTask\Instance\{
    Operation as OperationRepositoryInstance,
    Calendar as CalendarServiceInstance,
    Math as MathServiceInstance,
    RateAPI as RateServiceInstance,
};
use CommissionTask\Validation\AppException;


class FeePolicy implements FeePolicyFactory
{
    /** @var string */
    private $feePercent;

    /** @var array */
    private $freeOfCharge;

    /** @var Calendar */
    private $calendarService;

    /** @var RateServiceInstance */
    private $apiService;

    /** @var MathServiceInstance */
    private $mathService;

    /** @var OperationRepositoryInstance */
    private $operationRepository;

    public function __construct(string $feePercent, array $freeOfCharge)
    {
        $this->feePercent = $feePercent;
        $this->freeOfCharge = $freeOfCharge;
        $this->calendarService = CalendarServiceInstance::getInstance();
        $this->operationRepository = OperationRepositoryInstance::getInstance();
        $this->apiService = RateServiceInstance::getInstance();
        $this->mathService = MathServiceInstance::getInstance();
    }

    public static function getInstance( $feePercent, array $freeOfCharge): FeePolicyFactory
    {
        return new static($feePercent, $freeOfCharge);
    }

    /**
     * Calculates commission fee for provided operation based on user
     *
     * @throws AppException
     */
    public function getFeeForOperation(Operation $operation)
    {
        $operationAmount = $operation->getAmountCurrency()->getAmount();
        if($this->freeOfCharge) {
            $userOperationHistoryForWeek = $this->getWithdrawOperationsByUserAndWeek($operation);
            if (!$this->isFreeLimitExceeded($userOperationHistoryForWeek)) {
                $previousTotalEurForWeek = $this->previousTotalEurWithdrawAmountForWeek($userOperationHistoryForWeek);
                $remainedEurLimit = $this->getRemainedFreeAmount($previousTotalEurForWeek);
                $remainedLimit = $this->apiService->convertFromEur($remainedEurLimit,$operation->getAmountCurrency()->getCurrency());
                if ($remainedLimit > $operationAmount) {
                    return 0.00;
                }
                $operationAmount =  $this->mathService->sub($operationAmount, $remainedLimit);
            }
        }
        return $this->mathService->percentage($operationAmount, $this->feePercent);
    }

    /**
     * Returns operations array based on user and weekstart
     */
    private function getWithdrawOperationsByUserAndWeek(Operation $operation): array
    {
        $user = $operation->getUser();
        $date = $operation->getDate()->format($this->calendarService->getSupportedDateFormat());
        $weekStart = $this->calendarService->getStartDayOfWeekForDate($date);
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
     * Returns remained free amount or 0
     */
    private function getRemainedFreeAmount($totalPreviousAmountForWeek)
    {
        $amountLimit = $this->freeOfCharge['amount'];
        return $this->mathService->max($amountLimit, $totalPreviousAmountForWeek);
    }
}