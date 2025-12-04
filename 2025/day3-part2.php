<?php

$input = file_get_contents('day3.txt');
$list = array_filter(explode("\n", $input));

$sum = 0;
foreach ($list as $row) {
    $joltage = find($row);
    $sum += $joltage;
}
echo "done $sum\n"; // live: 172664333119298, test: 3121910778619


function find($numbers)
{
    $result = [];
    $n = strlen($numbers);
    $maxLen = 12;
    $deletionsLeft = $n - $maxLen;

    for ($i = 0; $i < $n; $i++) {
        $num = $numbers[$i];

        // wenn die aktuelle zahl größer ist als die letzte im result und wir noch löschungen übrig haben, dann löschen wir die letzte zahl
        while (
            $deletionsLeft > 0 &&
            !empty($result) &&
            $num > end($result)
        ) {
            array_pop($result);
            $deletionsLeft--;
        }

        $result[] = $num;
    }

    if (count($result) > $maxLen) {
        $result = array_slice($result, 0, $maxLen);
    }

    return implode('', $result);
}
