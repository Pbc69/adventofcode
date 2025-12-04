<?php

$input = file_get_contents('day3.txt');
$list = array_filter(explode("\n", $input));

$sum = 0;
foreach ($list as $numbers) {

    // 1. größte Zahl finden
    $index = null;
    $first = null;
    for ($i = 0; $i < strlen($numbers) - 1; $i++) {
        $num = $numbers[$i];
        if ($first === null || $num > $first) {
            $first = $num;
            $index = $i;
        }
    }

    // 2. zweitgrößte Zahl nach der größten finden
    $sec = null;
    for ($i = $index + 1; $i < strlen($numbers); $i++) {
        $num = $numbers[$i];
        if ($sec === null || $num > $sec) {
            $sec = $num;
        }
    }

    $joltage = $first * 10 + $sec;
    $sum += $joltage;
    //echo " $joltage \n";
}

echo "done $sum\n";
