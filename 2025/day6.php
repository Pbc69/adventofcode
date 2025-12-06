<?php

$list = file('day6.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$list = array_map(function ($line) {
    return explode(" ", preg_replace("/\s+/", " ", trim($line)));
}, $list);

$flipped = [];
foreach ($list as $i => $values) {
    foreach ($values as $j => $v) {
        $flipped[$j][$i] = $v;
    }
}


$res = [];
foreach ($flipped as $row) {
    $action = array_pop($row);
    $fn = match ($action) {
        "+" => fn($a) => array_sum($a),
        "*" => fn($a) => array_product($a),
    };
    $res[] = $fn($row);
}
print_r($res);
$final = array_sum($res);
echo "Final: $final\n";
