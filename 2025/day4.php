<?php

$input = file_get_contents('day4.txt'); // better $list = file('day4.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$list = array_filter(explode("\n", $input));
$map = array_map("str_split", $list);
$output = $map;
$rolls = 0;

foreach ($map as $y => $row) {
    foreach ($row as $x => $val) {
        if ($val == "@") {
            $can = check($map, $y, $x);
            if ($can) {
                $output[$y][$x] = "x";
                $rolls++;
            }
        }
    }
}

foreach ($output as $row) {
    echo implode("", $row) . "\n";
}
echo "Rolls: $rolls\n";


function check($map, $y, $x)
{
    $height = count($map);
    $width = count($map[0]);

    $directions = [
        [0, -1], // up
        [1, 0],  // right
        [0, 1],  // down
        [-1, 0], // left
        [-1, -1], // left up
        [1, -1],  // right up
        [1, 1],   // right down
        [-1, 1],  // left down
    ];
    $hits = 0;

    foreach ($directions as [$dx, $dy]) {
        $nx = $x + $dx;
        $ny = $y + $dy;

        if ($nx >= 0 && $nx < $width && $ny >= 0 && $ny < $height) {
            if ($map[$ny][$nx] == "@") {
                $hits++;
                if ($hits == 4) {
                    return false;
                }
            }
        }
    }
    return true;
}
