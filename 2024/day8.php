<?php

// Part 1
$input = file_get_contents('day8.txt');
//$input  = testInput();
$lines = array_map("trim", explode("\n", $input));

$antennas = [];
$table = [];
foreach($lines as $y => $line) {
    $line = str_split($line);
    foreach($line as $x => $char) {
        $table[$y][$x] = $char;
        if ($char !== ".") {
            $antennas[$char][] = [$x, $y];
        }
    }
}
$right = count($table[0]) - 1;
$bottom = count($table) - 1;

$antiNodes = $table;

$unique = 0;
foreach($antennas as $freq => $locations) {
    $max = count($locations);

    for($i = 0; $i < $max; $i++) {
        [$x,$y] = $locations[$i];

        for($j = $i+1; $j < $max; $j++) {
            [$x2,$y2] = $locations[$j];

            $dx = $x2 - $x; // right increasing
            $dy = $y2 - $y; // down increasing
            $px = $x - $dx;
            $py = $y - $dy;

            if (isset($table[$py][$px])) {
                if ($antiNodes[$py][$px] !== "#") {
                    $antiNodes[$py][$px] = "#";
                    $unique++;
                }
                if ($table[$py][$px] === ".")
                    $table[$py][$px] = "#";
            }

            // reverse
            $px = $x2 + $dx;
            $py = $y2 + $dy;

            if (isset($table[$py][$px])) {
                if ($antiNodes[$py][$px] !== "#") {
                    $antiNodes[$py][$px] = "#";
                    $unique++;
                }
                if ($table[$py][$px] === ".")
                    $table[$py][$px] = "#";
            }
        }
    }
}
echo "Unique: $unique\n"; // 313
//printTable($table);


function printTable(array $table) {
    foreach($table as $line) {
        echo implode("", $line) . "\n";
    }
    echo "\n";
}

function testInput(): string
{
    return "............
........0...
.....0......
.......0....
....0.......
......A.....
............
............
........A...
.........A..
............
............";
}

function testResult(): string
{
    return "......#....#
...#....0...
....#0....#.
..#....0....
....0....#..
.#....A.....
...#........
#......#....
........A...
.........A..
..........#.
..........#.";
}