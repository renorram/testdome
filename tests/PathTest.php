<?php

namespace App\Tests;

use App\Path;
use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{
    /** @var Path */
    private $path;

    public function setUp(): void
    {
        $this->path = new Path('/a/b/c/d');
    }

    public function testCdRelativePath()
    {
        $this->path->cd('../x');
        $this->assertEquals('/a/b/c/x', $this->path->currentPath);
    }

    public function testHardPath()
    {
        $this->path->cd('/b/a/c');
        $this->assertEquals('/b/a/c', $this->path->currentPath);
    }

    public function testHardParentPath()
    {
        $this->path->cd('/b/../c');
        $this->assertEquals('/c', $this->path->currentPath);
    }

    public function testHardParentParentPath()
    {
        $this->path->cd('/b/../../c');
        $this->assertEquals('/c', $this->path->currentPath);
    }

    public function testSelectParentDirectory()
    {
        $this->path->cd('..');
        $this->assertEquals('/a/b/c', $this->path->currentPath);
    }

    public function testSelectParentParentDirectory()
    {
        $this->path->cd('../..');
        $this->assertEquals('/a/b', $this->path->currentPath);
    }

    public function testSelectParentParentDirectoryFinalPath()
    {
        $this->path->cd('../../x');
        $this->assertEquals('/a/b/x', $this->path->currentPath);
    }

    public function testIsNotInvalidPath()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->path->cd('12[adasdx');
    }

    public function testValidatePath()
    {
        $this->assertFalse((new Path(''))->validatePath('12[adasdx'));
    }
}
