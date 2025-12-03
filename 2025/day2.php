<?php

$input = file_get_contents('day2.txt');
$ranges = array_filter(explode(",", $input));

$list = [];

foreach($ranges as $range) {
    [$start, $end] = explode("-", $range, 2);
    $start = intval($start);
    $end = intval($end);

    $invalid = [];
    for($i = $start; $i <= $end; $i++) {
        $len = strlen($i);
        if ($len % 2 != 0)
            continue;

        $first = substr($i, 0, (int)($len / 2));
        $last = substr($i, (int)($len / 2));
        //echo "i: $i, len: $len, first: $first, last $last\n";

        if ($first == $last) {
            $invalid[] = intval($i);
        }
    }

    echo "{$start}-{$end} has ".count($invalid)." invalid IDs: ".implode(", ", $invalid);
    echo "\n";
    array_push($list, ...$invalid);
}


$x = array_sum($list);
echo "Sum of invalid ranges: $x\n";