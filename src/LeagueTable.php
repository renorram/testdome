<?php

namespace App;

class LeagueTable
{
    public function __construct(array $players)
    {
        $this->standings = [];
        foreach ($players as $index => $p) {
            $this->standings[$p] = [
                'index' => $index,
                'games_played' => 0,
                'score' => 0,
            ];
        }
    }

    public function recordResult(string $player, int $score): void
    {
        ++$this->standings[$player]['games_played'];
        $this->standings[$player]['score'] += $score;
        \uasort($this->standings, [$this, 'uSortStandings']);
    }

    public function playerRank(int $rank): string
    {
        if ($rank < 1 || $rank > \count($this->standings)) {
            throw new \UnexpectedValueException(\sprintf('%d is not a valid rank number.', $rank));
        }

        $players = \array_keys($this->standings);

        return $players[$rank - 1];
    }

    private function uSortStandings($a, $b)
    {
        if ($a['score'] === $b['score'] && $a['games_played'] === $b['games_played']) {
            return $a['index'] < $b['index'] ? -1 : 1;
        }

        if ($a['score'] > $b['score']) {
            return -1;
        }

        if ($a['score'] === $b['score']) {
            return $a['games_played'] < $b['games_played'] ? -1 : 1;
        }

        return 1;
    }
}
