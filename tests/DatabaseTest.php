<?php
namespace KCS\Config;
use PHPUnit\Framework\TestCase;

final class DatabaseTest extends TestCase
{
    public function testCanBeConstruct(){
        $db = new Database();
        
        $this->assertEmpty($db);
    }
}