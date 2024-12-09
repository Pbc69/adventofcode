<?php

// Part 2
// very slow, but works

$input = file_get_contents('day7.txt');
//$input = testInput();
$lines = array_map("trim", explode("\n", $input));

$total = 0;
foreach ($lines as $line) {
    $parts = explode(": ", $line);
    $res = intval($parts[0]);
    $numbers = array_map("intval", explode(" ", $parts[1]));

    $maxBits = count($numbers) - 1;
    $posibilities = pow(3, $maxBits);

    for ($i = 0; $i < $posibilities; $i++) {
        $bits = str_pad(dec2three($i), $maxBits, "0", STR_PAD_LEFT);
        $sum = $numbers[0];

        for ($j = 1; $j <= $maxBits; $j++) {
            if ($bits[$j - 1] === "2") {
                $sum = intval("{$sum}{$numbers[$j]}");
            } elseif ($bits[$j - 1] === "1") {
                $sum *= $numbers[$j];
            } else {
                $sum += $numbers[$j];
            }
            if ($sum > $res) {
                break;
            }
        }

        if ($sum == $res) {
            $total += $res;
            break;
        }
    }
}
echo "Total: $total\n"; // 116094961956019



function dec2three(int $x): string
{
    if ($x === 0) {
        return "0";
    }
    $res = "";
    while ($x > 0) {
        $res = $x % 3 . $res;
        $x = intdiv($x, 3);
    }
    return $res;
}

// expect 11387
function testInput(): string
{
    return "190: 10 19
3267: 81 40 27
83: 17 5
156: 15 6
7290: 6 8 6 15
161011: 16 10 13
192: 17 8 14
21037: 9 7 18 13
292: 11 6 16 20";
}