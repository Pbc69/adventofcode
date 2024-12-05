<?php

# Part 1
$input = file_get_contents('day3.txt');
$input = trim($input);

$sum = calc($input);
echo "Part1 Sum: $sum\n";


# Part 2
$sum = 0;

$search = "don't()"; // is enabled at start
while($input) {
    $pos = strpos($input, $search);

    if ($pos !== false) {
        $sub = substr($input, 0, $pos + strlen($search));
        $input = substr($input, $pos + strlen($search));
        if ($search == "don't()")
            $sum += calc($sub);

        $search = $search == "don't()" ? "do()" : "don't()";
    } else {
        if ($search == "don't()")
            $sum += calc($input);
        $input = null;
    }
}
echo "Part2 Sum: $sum\n";


function calc(string $input): int {
    if (!preg_match_all("/mul\((\d+),(\d+)\)/m", $input, $matches))
        return 0;
    $sum = 0;
    foreach($matches[1] as $i => $m1) {
        $sum += $m1 * $matches[2][$i];
    }
    return $sum;
}

