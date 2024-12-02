<?php
class BankAccount implements AccountInterface {
    const MIN_BALANCE = 0;
    public $balance;
    public $currency;

    public function __construct($initialBalance, $currency) {
        if ($initialBalance < self::MIN_BALANCE) {
            throw new Exception("Начальный баланс не может быть меньше " . self::MIN_BALANCE);
        }
        $this->balance = $initialBalance;
        $this->currency = $currency;
    }

    public function deposit($amount) {
        if ($amount <= 0) {
            throw new Exception("Сумма пополнения должна быть больше нуля");
        }
        $this->balance += $amount;
    }

    public function withdraw($amount) {
        if ($amount <= 0) {
            throw new Exception("Сумма снятия должна быть больше нуля");
        }
        if ($this->balance - $amount < self::MIN_BALANCE) {
            throw new Exception("Недостаточно средств для снятия");
        }
        $this->balance -= $amount;
    }

    public function getBalance() {
        return $this->balance;
    }
}
