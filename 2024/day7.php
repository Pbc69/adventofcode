<?php

// Part 1
$input = file_get_contents('day7.txt');
$lines = array_map("trim", explode("\n", $input));

$total = 0;
foreach ($lines as $line) {
    $parts = explode(": ", $line);
    $res = $parts[0];
    $numbers = array_map("intval", explode(" ", $parts[1]));

    $maxBits = count($numbers) - 1;
    $posibilities = pow(2, $maxBits);

    for ($i = 0; $i < $posibilities; $i++) {
        $bits = str_pad(decbin($i), $maxBits, "0", STR_PAD_LEFT);
        $sum = $numbers[0];

        for ($j = 1; $j <= $maxBits; $j++) {
            if ($bits[$j - 1] == "1") {
                $sum *= $numbers[$j];
            } else {
                $sum += $numbers[$j];
            }
        }
        if ($sum == $res) {
            $total += $res;
            break;
        }
    }
}
echo "Total: $total\n"; // 267566105056

// 81 40 27
// 81 + 40 + 27 00
// 81 * 40 + 27 01
// 81 + 40 * 27 10
// 81 * 40 * 27 11


// Part 2
//