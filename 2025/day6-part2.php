<?php

$list = file('day6.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$max = max(array_map(fn($line) => strlen($line), $list));

$res = [];
$nums = [];

// von rechts nach links
for ($j = $max - 1; $j >= 0; $j--) {
    $str = "";
    foreach ($list as $i => $line) {
        $c = $line[$j] ?? " ";

        $fn = match ($c) {
            "+" => fn($a) => array_sum($a),
            "*" => fn($a) => array_product($a),
            default => null,
        };
        if ($fn) {
            $nums[] = intval($str);
            $res[] = $fn($nums);
            $nums = [];
            continue 2;
        }

        $str .= $c;
    }
    $num = intval($str);
    if ($num)
        $nums[] = $num;
}

print_r($res);
$final = array_sum($res);
echo "Final: $final\n";
