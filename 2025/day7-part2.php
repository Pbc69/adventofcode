<?php

$list = file('day7.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$map = array_map("str_split", $list);
$ctr = $map;
$split = 0;

for ($y = 1; $y < count($map); $y++) {
    for ($x = 0; $x < count($map[0]); $x++) {
        if ($map[$y][$x] == "^") {
            if ($map[$y - 1][$x] == "|") {
                $map[$y][$x - 1] = "|";
                $map[$y][$x + 1] = "|";
                $split++;

                $up = $ctr[$y - 1][$x];

                $left   = $ctr[$y][$x - 1];
                $leftUp = $ctr[$y - 1][$x - 1];
                $right      = $ctr[$y][$x + 1];

                $rightUp    = $ctr[$y - 1][$x + 1];

                // left
                if ($left == ".") {
                    $add = is_string($leftUp) ? 0 : $leftUp;
                    $left = $up + $add;
                } else {
                    $left += $up;
                }

                // right
                if ($right  == ".") {
                    $add = is_string($rightUp) ? 0 : $rightUp;
                    $right = $up + $add;
                } else {
                    $right += $up;
                }
                $ctr[$y][$x - 1] = $left;
                $ctr[$y][$x + 1] = $right;
            }
        } elseif ($map[$y - 1][$x] == "|") {
            $map[$y][$x] = "|";
            if (is_string($ctr[$y][$x])) {
                $ctr[$y][$x] = $ctr[$y - 1][$x];
            }
        } elseif ($map[$y - 1][$x] == "S") {
            $map[$y][$x] = "|";
            $ctr[$y][$x] = 1;
        }
    }
}

//_print($map);
_print($ctr, $ctr);


function _print($map, $ctr = null)
{
    foreach ($map as $y => $row) {
        printf("%02d   ", $y);

        foreach ($row as $x => $cell) {
            if (strlen($cell) == 1) {
                echo " " . $cell . " ";
            } else {
                echo $cell . " ";
            }
        }

        if ($ctr) {
            $arr = array_map(fn($v) => is_string($v) ? 0 : $v, $ctr[$y]);
            $total = array_sum($arr);
            printf("     total: %d", $total);
        }
        echo "\n";
    }
    echo "\n";
}
