<?php

namespace App\Tests;

use App\LeagueTable;
use PHPUnit\Framework\TestCase;

class LeagueTableTest extends TestCase
{
    /** @var LeagueTable */
    private $leagueTable;

    protected function setUp(): void
    {
        $this->leagueTable = new LeagueTable(['Mike', 'Chris', 'Arnold']);
        $this->leagueTable->recordResult('Mike', 2);
        $this->leagueTable->recordResult('Mike', 3);
        $this->leagueTable->recordResult('Arnold', 5);
        $this->leagueTable->recordResult('Chris', 5);
    }

    public function testHighestRank()
    {
        $this->assertEquals('Chris', $this->leagueTable->playerRank(1));
    }

    public function testOutOfRank()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->leagueTable->playerRank(0);
    }
}
