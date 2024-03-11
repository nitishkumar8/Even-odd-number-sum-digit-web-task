<?php

function sumOfDigits($number) {
    $sum = 0;
    while ($number > 0) {
        $digit = $number % 10;
        $sum += $digit;
        $number = (int)($number / 10); 
    }
    return $sum;
}
$userInput = (int)readline("Enter a positive integer: ");

if ($userInput >= 0) {
    $result = sumOfDigits($userInput);
    echo "The sum of the digits of $userInput is $result.";
} else {
    echo "Please enter a positive integer.";
}
?>