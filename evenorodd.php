<?php

    function evenOrOdd($number) {
        if ($number % 2 == 0) {
            return "Even";
        } else {
            return "Odd";
        }
    }

    $input  = (int)readline("Enter a number: ");
    $output = evenOrOdd($input);
    echo "The number $input is $output.";


?>