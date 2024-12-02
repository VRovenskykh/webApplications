<?php
// Файл client.php
require_once 'AccountInterface.php';
require_once 'BankAccount.php';
require_once 'SavingsAccount.php';

try {
    

    $account1 = new BankAccount(100, 'USD');
    echo "Создан счет с балансом: {$account1->getBalance()} {$account1->currency}\n";


    $account1->deposit(50);
    echo "После пополнения баланс: {$account1->getBalance()} {$account1->currency}\n";


    $account1->withdraw(30);
    echo "После снятия баланс: {$account1->getBalance()} {$account1->currency}\n";


    try {
        $account1->withdraw(150);
    } catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage() . "\n";
    }


    $savingsAccount = new SavingsAccount(200, 'USD');
    echo "Создан накопительный счет с балансом: {$savingsAccount->getBalance()} {$savingsAccount->currency}\n";


    $savingsAccount->applyInterest();
    echo "После применения процентов баланс: {$savingsAccount->getBalance()} {$savingsAccount->currency}\n";


    try {
        $savingsAccount->deposit(-10);
    } catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage() . "\n";
    }


    try {
        $savingsAccount->withdraw(-20);
    } catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage() . "\n";
    }

    
} catch (Exception $e) {
    echo "Произошла ошибка: " . $e->getMessage();
}
