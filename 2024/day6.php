<?php

# Part 1

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


// Do the work
[$x, $y] = $pos;
while (true) {

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

    // We expect that the guard will be able to find the exit
    // else it will be an infinite loop
}

// Count the number of X
$sum = 0;
foreach($table as $row) {
    $sum += count(array_filter($row, fn($x) => $x === "X"));
}
echo "Sum: $sum\n"; // 4752

