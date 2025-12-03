<?php

$input = file_get_contents('day1.txt');
$lines = array_filter(explode("\n", $input));

$c0 = 0; //part2
$ctr = 0;
$i = 50;
echo "The dial starts by pointing at $i\n";

foreach ($lines as $line) {
    $direction = $line[0];
    $steps = (int)substr($line, 1);
    if ($steps == 0)
        continue;

    $wasZero = $i == 0;

    if ($direction === 'L')
        $i -= $steps;
    else
        $i += $steps;

    $p0 = 0;

    if ($i == 0) {
        $ctr++;
    }
    if ($i == 100) {
        $i = 0;
        $ctr++;
    }
    if ($i < 0) {
        $p0 = abs((int)($i / 100));
        if (!$wasZero)
            $p0++;
        $i = $i % 100 + 100;
    }

    if ($i >= 100) {
        if ($i !== 100)
            $p0 = (int)($i / 100);
        else
            $po = 1;
        $i = $i % 100;
    }
    $c0 += $p0;

    echo "The dial is rotated $line to point at $i.";
    if ($p0 > 0)
        echo " during this rotation, it points at 0 $p0.";
    echo "\n";
}

echo "final part1: " . $ctr . "\n";
echo "final part2: " . ($ctr + $c0) . "\n";
