<?php


function _run()
{
    $file = file('day8.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $list = array_map(fn($s) => new JunctionBox(...explode(",", $s)), $file);
    $total = count($list);
    echo "Total points: $total\n";

    $distances = _buildDistances($list);
    //_printDistances($distances, 50, true);

    $cons = [];
    foreach ($distances as $item) {
        /** @var JunctionBox */
        $from = $item['from'];
        /** @var JunctionBox */
        $to   = $item['to'];
        echo "From: {$from} To: {$to} Distance: {$item['dist']}\n";

        if (!$from->connectTo($to)) {
            continue;
        }

        echo "  Connected:\n";
        echo "    Distance: {$item['dist']}\n";
        echo "    circuit: {$from->circuit}, cons: {$from->count}\n";

        $cons[$from->circuit] ??= [];
        $cons[$from->circuit][$from->__toString()] = $from;
        $cons[$from->circuit][$to->__toString()] = $to;

        // if (count($cons) >= 10) {
        //     break;
        // }
    }

    $res = [];
    echo "\n\ncircuit summary: " . count($cons) . "\n";
    foreach ($cons as $circuit => $nodes) {
        echo "\nCircuit $circuit has " . count($nodes) . " unique nodes:\n";
        foreach ($nodes as $n) {
            echo "  $n\n";
        }
        $res[$circuit] = count($nodes);
    }
    rsort($res);

    $mul = $res[0] * $res[1] * $res[2];
    echo "\nTop 3 connection counts multiplied: {$res[0]} * {$res[1]} * {$res[2]} = $mul\n";
}

/**
 * @param array<JunctionBox> $list
 * @return array
 */
function _buildDistances(array $list): array
{
    $distances = [];

    for ($i = 0; $i < count($list); $i++) {
        if (!isset($list[$i])) continue;

        for ($j = $i + 1; $j < count($list); $j++) {
            if (!isset($list[$j])) continue;

            $dist = $list[$i]->distanceTo($list[$j]);
            $distances[] = [
                'from_index' => $i,
                'to_index' => $j,
                'from' => $list[$i],
                'to' => $list[$j],
                'dist' => $dist,
            ];
        }
    }
    usort($distances, function ($a, $b) {
        return $a['dist'] <=> $b['dist'];
    });
    return $distances;
}



function _printDistances(array $distances, int $num = 99999, bool $unconnectedOnly = false): void
{
    usort($distances, function ($a, $b) {
        return $a['dist'] <=> $b['dist'];
    });
    $j = 0;
    foreach ($distances as $i => $d) {
        if ($unconnectedOnly) {
            if (!empty($d['from']->isConnectedTo) && !empty($d['to']->isConnectedTo)) {
                continue;
            }
        }
        echo "  $i: From ({$d['from']}) To ({$d['to']}) distance: {$d['dist']}\n";

        if ($j >= $num - 1) {
            break;
        }
        $j++;
    }
}

class JunctionBox
{
    private static int $circuitGen = 0;

    public array $isConnectedTo = [];
    public int $count = 1;
    public ?int $circuit = null;

    public function __construct(
        public float $x,
        public float $y,
        public float $z
    ) {}

    public function connectTo(self $other): bool
    {
        if ($this->circuit && $other->circuit) {
            // already connected
            return false;
        }

        $c = $this->circuit;
        $c ??= $other->circuit;
        if ($c === null) {
            static::$circuitGen++;
            $c = static::$circuitGen;
        }
        $this->circuit = $other->circuit = $c;

        $this->isConnectedTo[] = $other;
        $other->isConnectedTo[] = $this;

        $other->count++;
        $this->count++;
        return true;
    }

    function distanceTo(self $other): float
    {
        return sqrt(
            pow($other->x - $this->x, 2) +
                pow($other->y - $this->y, 2) +
                pow($other->z - $this->z, 2)
        );
    }

    public function __toString()
    {
        return "$this->x,$this->y,$this->z";
    }
}

_run();

// function _shortestPath(array $distances, bool $noCon): ?array
// {
//     if ($noCon) {
//         $filtered = [];
//         foreach ($distances as $d) {
//             if (!empty($d['from']->isConnectedTo) && !empty($d['to']->isConnectedTo)) {
//                 continue;
//             }
//             $filtered[] = $d;
//         }
//         $distances = $filtered;
//     }
//     usort($distances, function ($a, $b) {
//         return $a['dist'] <=> $b['dist'];
//     });
//     return $distances[0] ?? null;
// }


