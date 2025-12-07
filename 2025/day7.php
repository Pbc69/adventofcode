<?php

$list = file('day7.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$map = array_map("str_split", $list);
$split = 0;

for ($y = 1; $y < count($map); $y++) {
    for ($x = 0; $x < count($map[0]); $x++) {
        if ($map[$y][$x] == "^") {
            if ($map[$y - 1][$x] == "|") {
                $map[$y][$x - 1] = "|";
                $map[$y][$x + 1] = "|";
                $split++;
            }
        } elseif ($map[$y - 1][$x] == "|") {
            $map[$y][$x] = "|";
        } elseif ($map[$y - 1][$x] == "S") {
            $map[$y][$x] = "|";
        }
    }
}

foreach ($map as $row) {
    echo implode("", $row) . "\n";
}
echo "splits: $split\n";
