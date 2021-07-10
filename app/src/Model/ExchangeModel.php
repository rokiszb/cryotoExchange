<?php


namespace App\Model;

use App\Exception\NegativeAmountException;
use App\Service\ExchangeService;
use InvalidArgumentException;

class ExchangeModel
{
    private string $from;
    private string $to;
    private float $amount;

    public function __construct(string $from, string $to, float $amount)
    {
        if ($amount < 0) {
            throw new NegativeAmountException('Amount cannot be negative');
        }
        if (!in_array($from, ExchangeService::ALLOWED_FIAT_CURRENCIES)) {
            throw new InvalidArgumentException('Allowed currencies: ' . implode(' ', ExchangeService::ALLOWED_FIAT_CURRENCIES));
        }
        $this->from = $from;
        $this->to = $to;
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }
}