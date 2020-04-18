<?php
namespace Web64\LaravelHelpers\Tests;

use PHPUnit\Framework\TestCase;

class sqlTest extends TestCase
{
    /** @test */
    public function correct_sql_with_no_bindings()
    {
        $baseSql = "SELECT * FROM users LIMIT 100";
        $sql = sql($baseSql);

        $this->assertEquals($baseSql, $sql);
    }

    /** @test */
    public function correct_sql_with_with_standard_bindings()
    {
        $bindings = ["test value", 'barbar', 'bar', 100, 'id' ];

$baseSql = "SELECT * FROM 
    users 
WHERE
    test > ? AND 
    foooo = ?
    foo = ?
LIMIT ?
ORDER BY ?";

        $sql = sql($baseSql, $bindings);
        echo PHP_EOL;

$expectedSql = "SELECT * FROM 
    users 
WHERE
    test > 'test value' AND 
    foooo = 'barbar'
    foo = 'bar'
LIMIT 100
ORDER BY 'id'";

        //echo $sql . PHP_EOL;

        $this->assertEquals($sql, $expectedSql);
    }

    /** @test */
    public function correct_sql_with_with_named_bindings()
    {
        $bindings = [
            'test' => "test value",
            'foo' => 'bar',
            'foooo' => 'barbar',
            'limit' => 100,
            'orderby'=> 'id'
        ];

$baseSql = "SELECT * FROM 
    users 
WHERE
    test > :test AND 
    foooo = :foooo
    foo = :foo
LIMIT :limit
ORDER BY :orderby";

        $sql = sql($baseSql, $bindings);
        echo PHP_EOL;

$expectedSql = "SELECT * FROM 
    users 
WHERE
    test > 'test value' AND 
    foooo = 'barbar'
    foo = 'bar'
LIMIT 100
ORDER BY 'id'";

        //echo $sql . PHP_EOL;

        $this->assertEquals($sql, $expectedSql);
    }
}
