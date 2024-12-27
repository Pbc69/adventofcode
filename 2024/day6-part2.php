<?php

# reuse Part 1
$time = microtime(true);
$actions = [
    "^" => fn($x,$y) => [$x, $y - 1],
    ">" => fn($x,$y) => [$x + 1, $y],
    "v" => fn($x,$y) => [$x, $y + 1],
    "<" => fn($x,$y) => [$x - 1, $y],
];
$directions = array_keys($actions);
$directionIndex = 0;
$direction = $directions[$directionIndex];

$input = file_get_contents('day6.txt');
$lines = array_map("trim", explode("\n", $input));

$pos = null;
$table = [];
foreach($lines as $y => $line) {
    $row = str_split($line);
    $x = array_search($direction, $row);
    if ($x !== false) {
        $pos = [$x, $y];
    }
    $table[] = $row;
}

// Part 1 extended run and cals guards way
if (!run($table, $pos, $directionIndex))
    die("Guard is stuck\n");


// Part 2
$stucks = 0;

// Use guards base route (X)
foreach($table as $y => $row) {
    foreach($row as $x => $cell) {
        if ($cell !== "X") continue;

        $testTable = $table;
        $testTable[$y][$x] = "#"; // new obstacle
        if (!run($testTable, $pos, $directionIndex)) {
            $stucks++;
        }
    }
}
echo "Stucks: $stucks\n"; // 1719
echo "Duration: ".(microtime(true) - $time)."\n";
// Bad performance, but the easies way i think
// better would be to not start at first position (snake), but i guess there is a way smarter version


function run(array &$table, array $pos, int $directionIndex): bool {
    global $actions, $directions;

    // Mark each position with the direction
    $directionHits = [];
    $direction = $directions[$directionIndex];

    // Do the work
    [$x, $y] = $pos;
    while (true) {
        // remember all directions per field, if it hit twice, the guard
        // is in an infinite loop
        $directionHits[$y][$x][$direction] = true;


        // find next position
        while(true) {
            $next = $actions[$direction]($x, $y);
            $char = $table[$next[1]][$next[0]] ?? null;
            if (!$char)
                break; // going to move outside
            if ($char !== "#")
                break;
            // rotate
            $direction = $directions[$directionIndex++ % 4];
        }

        // move
        $table[$y][$x] = "X";
        [$x, $y] = $next;

        // check if we are done
        if ($x < 0 || $y < 0 || $x >= count($table[0]) || $y >= count($table)) {
            break;
        }

        // Stuck Detection
        if (isset($directionHits[$y][$x][$direction])) {
            return false;
        }
    }
    return true;
}


function testInput() {
    return "....#.....
.........#
..........
..#.......
.......#..
..........
.#..^.....
........#.
#.........
......#...";
}

function printTable(array $table) {
    foreach($table as $row) {
        echo implode("", $row) . "\n";
    }
    echo "\n";
}