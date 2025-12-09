<?php



function _run()
{
    $file = file('day8.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $list = array_map(fn($s) => new Vector3D(...explode(",", $s)), $file);
    $total = count($list);
    echo "Total points: $total\n";


    $distances = _buildDistances($list);
    _printDistances($distances, 10);
    // $shortest = _shortestPath($distances);
    // echo "\nShortest path:\n";
    // echo "From: {$shortest['from']} To: {$shortest['to']} Distance: {$shortest['dist']}\n";


    for ($i = 0; $i < $total; $i++) {
        $distances = _buildDistances($list);

        $shortest = _shortestPath($distances, true);
        if ($shortest === null) {
            echo "\nNo more unconnected paths found.\n";
            break;
        }
        /** @var Vector3D */
        $from = $shortest['from'];
        /** @var Vector3D */
        $to   = $shortest['to'];

        $from->connectTo($to);

        echo "\nShortest unconnected path:\n";
        echo "From: {$from} To: {$shortest['to']} Distance: {$shortest['dist']}, circle: {$from->circle}, cons: {$from->connectionCount}\n";
        _printDistances($distances, 2);
    }

    // sort by connection count
    usort($list, function (Vector3D $a, Vector3D $b) {
        return $b->connectionCount <=> $a->connectionCount;
    });

    $mul = $list[0]->connectionCount * $list[1]->connectionCount * $list[2]->connectionCount;
    echo "\nTop 3 connection counts multiplied: {$list[0]->connectionCount} * {$list[1]->connectionCount} * {$list[2]->connectionCount} = $mul\n";
}

/**
 * @param array<Vector3D> $list
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
    return $distances;
}

function _shortestPath(array $distances, bool $noCon): ?array
{
    if ($noCon) {
        $filtered = [];
        foreach ($distances as $d) {
            if (!empty($d['from']->isConnectedTo) && !empty($d['to']->isConnectedTo)) {
                continue;
            }
            $filtered[] = $d;
        }
        $distances = $filtered;
    }
    usort($distances, function ($a, $b) {
        return $a['dist'] <=> $b['dist'];
    });
    return $distances[0] ?? null;
}

function _printDistances(array $distances, int $num = 99999)
{
    usort($distances, function ($a, $b) {
        return $a['dist'] <=> $b['dist'];
    });
    foreach ($distances as $i => $d) {
        echo "  $i: From ({$d['from']}) To ({$d['to']}) distance: {$d['dist']}\n";

        if ($i >= $num - 1) {
            break;
        }
    }
}

class Vector3D
{
    static int $circleCounter = 0;
    public array $isConnectedTo = [];
    public int $connectionCount = 0;
    public int $circle;

    public function __construct(
        public float $x,
        public float $y,
        public float $z
    ) {
        static::$circleCounter++;
        $this->circle = static::$circleCounter;
    }

    public function connectTo(self $other): void
    {
        $this->isConnectedTo[] = $other;
        $other->isConnectedTo[] = $this;

        $this->connectionCount++;
        $other->connectionCount++;

        $other->circle = $this->circle;
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
