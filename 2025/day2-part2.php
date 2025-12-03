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
        $mid = (int)($len / 2);

        while ($mid > 0) {
            $first = substr($i, 0, $mid);
            $expected = $len / strlen($first);
            //echo "i: $i, len: $len, first: $first, substr_count: ".substr_count($i, $first).", expected: ".$expected."\n";

            if (substr_count($i, $first) == $expected ) {
                $invalid[] = $i;
                //echo "  invalid!\n";
            }
            $mid--;
        }
    }
    $invalid = array_unique($invalid);

    echo "{$start}-{$end} has ".count($invalid)." invalid IDs: ".implode(", ", $invalid);
    echo "\n";
    array_push($list, ...$invalid);
}


$x = array_sum($list);
echo "Sum of invalid ranges: $x\n";