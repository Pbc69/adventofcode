<?php

$list = file('day7.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$map = array_map("str_split", $list);

 // todo
