<?php

// Part 1
$input = file_get_contents('day10.txt');

$matrix = [];
$lines = explode("\n", $input);
foreach($lines as $line) {
    $matrix[] = array_map("intval", str_split(trim($line)));
}

$starts = [];
foreach ($matrix as $y => $row) {
    foreach ($row as $x => $cell) {
        if ($cell === 0) {
            $starts[] = [$y, $x];
        }
    }
}


$score = [];
$trails = 0;
$paths = [];

echo "Start\n";
$trails = [];
foreach ($starts as [$y, $x]) {
    $trails[] = findTrail($matrix, $y, $x);
}

foreach ($trails as $index => $trail) {
    echo "Trail #" . ($index+1) . "\n";
    echo "Score: {$trail['score']}\n";
    $totalScore += $trail['score'];

    foreach ($trail['paths'] as $pathNum => $path) {
        echo "Path $pathNum:\n";
        foreach ($path as $step => $pos) {
            echo "  $step: $pos\n";
        }
    }
    echo "\n";
}

echo "Total score: $totalScore\n";



function findTrail(array $matrix, int $startY, int $startX): array {
    $trail = [
        'score' => 0,
        'paths' => [[]],
        'visited' => [],
    ];

    followTrail($matrix, $startY, $startX, 0, $trail, []);

    return $trail;
}

function followTrail(array $matrix, int $y, int $x, int $step, array &$trail, array $currentPath) {
    if (isset($trail['visited']["$y,$x"])) {
        return;
    }

    $cur = $matrix[$y][$x] ?? null;
    if ($cur === null || $cur !== $step) {
        return;
    }

    $trail['visited']["$y,$x"] = true;
    $currentPath[$step] = "$y,$x ($step)";

    if ($step === 9) {
        $trail['paths'][] = $currentPath;
        $trail['score']++;
        return;
    }

    $nextStep = $step + 1;
    $directions = [
        [$y, $x+1], // rechts
        [$y, $x-1], // links
        [$y-1, $x], // oben
        [$y+1, $x], // unten
    ];

    foreach ($directions as [$ny, $nx]) {
        followTrail($matrix, $ny, $nx, $nextStep, $trail, $currentPath);
    }

    unset($trail['visited']["$y,$x"]);
}