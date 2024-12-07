<?php

# Part 1
$inhibitRules = [];
$printSet = [];

$input = file_get_contents('day5.txt');
$lines = explode("\n", $input);

foreach ($lines as $line) {
    $line = trim($line);
    if (str_contains($line, "|")) {
        $split = explode("|", $line);
        $inhibitRules[] = $split[1] . "|" . $split[0];
    } elseif (str_contains($line, ",")) {
        $printSet[] = explode(",", $line);
    }
}

// remove false sets
foreach($printSet as $x => $pages) {
    $pos = 0;
    for ($i = 0; $i < count($pages); $i++) {
        $pos ++;
        for ($j = $pos; $j < count($pages); $j++) {
            $set = $pages[$i] . "|" . $pages[$j];
            if (in_array($set, $inhibitRules)) {
                unset($printSet[$x]);
                break 2;
            }
        }
    }
}

$sum = 0;
foreach($printSet as $pages) {
    $mid = $pages[floor(count($pages) / 2)];
    $sum += $mid;
}
echo "Sum: $sum\n";