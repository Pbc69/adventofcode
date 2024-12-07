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
        $set = $split[1] . "|" . $split[0];
        $inhibitRules[$set] = $set;
    } elseif (str_contains($line, ",")) {
        $printSet[] = explode(",", $line);
    }
}

$falseSets = []; // for part2

// remove false sets
foreach($printSet as $x => $pages) {
    $pos = 0;
    for ($i = 0; $i < count($pages); $i++) {
        $pos ++;
        for ($j = $pos; $j < count($pages); $j++) {
            $set = $pages[$i] . "|" . $pages[$j];
            if (isset($inhibitRules[$set])) {
                $falseSets[] = $pages;
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
echo "Sum: $sum\n"; // 4766


// Part 2

foreach($falseSets as $x => &$pages) {

    while (true) {
        $pos = 0;
        for ($i = 0; $i < count($pages); $i++) {
            $pos ++;
            for ($j = $pos; $j < count($pages); $j++) {
                $set = $pages[$i] . "|" . $pages[$j];
                if (isset($inhibitRules[$set])) {
                    $t = $pages[$j];
                    $pages[$j] = $pages[$i];
                    $pages[$i] = $t;
                    continue 3; // while, (restart fix loop)
                }
            }
        }

        break;
    }
}
unset($pages);

$sum = 0;
foreach($falseSets as $pages) {
    $mid = $pages[floor(count($pages) / 2)];
    $sum += $mid;
}
echo "Sum: $sum\n"; // 6257
