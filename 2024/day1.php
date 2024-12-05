<?php

# Part 1
$arr1 = [];
$arr2 = [];

$input = file_get_contents('day1.txt');
$lines = array_filter(explode("\n", $input));

foreach ($lines as $line) {
    [$arr1[], $arr2[]] = array_map("trim", explode("   ", $line));
}


sort($arr1);
sort($arr2);

$d = 0;
foreach ($arr1 as $i => $v) {
    $d += abs($v - $arr2[$i]);
}
echo "Part1 Distance: $d\n";


###########################
# Part 2 - similarity score

$arr = [];
$map = [];

foreach ($lines as $line) {
    [$arr[], $y] = array_map("trim", explode("   ", $line));

    $map[$y] ??= 0;
    $map[$y]++;
}

$d = 0;
foreach ($arr as $v) {
    $d += $v * ($map[$v] ?? 0);
}

echo "Part2 Distance: $d\n";