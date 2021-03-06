<?php
require_once(__DIR__ . '/../../runtime/underscore.php');

use PHPUnit\Framework\TestCase;

final class UnderscoreTest extends TestCase
{
    public function testExtend(): void
    {
        $target = ["foo" => "FOO", "bar" => "BAR"];
        $source = ["bar" => "bar", "coo" => "COO"];
        _::extend($target, $source);

        $this->assertEquals([
            "foo" => "FOO",
            "bar" => "bar",
            "coo" => "COO"
        ], $target);
    }
    public function testEach(): void
    {
        $result = "";
        $iter = function ($val, $key) use (&$result) {
            $result .= $key . ":" . $val . ";";
        };
        _::each(["foo", "bar", "coo"], $iter);
        $this->assertEquals(
            "0:foo;1:bar;2:coo;",
            $result
        );
    }
    public function testEachBreak(): void
    {
        $result = "";
        $iter = function ($val, $key) use (&$result) {
            $result .= $key . ":" . $val . ";";
            if ($key == 1) return false;
        };
        _::each(["foo", "bar", "coo"], $iter);
        $this->assertEquals(
            "0:foo;1:bar;",
            $result
        );
    }
    public function testContainsWhenContains(): void
    {
        $this->assertEquals(
            true,
            _::contains(["foo", "bar", "coo"], "bar")
        );
    }
    public function testContainsWhenNotContains(): void
    {
        $this->assertEquals(
            false,
            _::contains(["foo", "bar", "coo"], "haa")
        );
    }
    public function testHtmlFilterReplacer(): void {
        $this->assertEquals(
            "&gt;",
            _::htmlFilterReplacer(">")
        );
    }
    public function testOutput(): void {
        $this->assertEquals(
            "&lt;a class=&#039;&amp;&quot;&#039;&gt;",
            _::output("<a class='&\"'>", "escape")
        );
    }
    public function testClassFilter(): void {
        $this->assertEquals(
            "foo bar coo",
            _::classFilter(["foo", "bar", "coo"])
        );
    }
    public function testStyleFilter(): void {
        $this->assertEquals(
            "height:20px;width:30px;",
            _::styleFilter(["height" => "20px", "width" => "30px"])
        );
    }
    public function testXClassFilter(): void {
        $this->assertEquals(
            "haha foo bar coo",
            _::xclassFilter(["foo", "bar", "coo"], "haha")
        );
    }
    public function testXStyleFilter(): void {
        $this->assertEquals(
            "haha;height:20px;width:30px;",
            _::xstyleFilter(["height" => "20px", "width" => "30px"], "haha")
        );
    }
    public function testAttrFilter(): void {
        $this->assertEquals(
            ' height="20px"',
            _::attrFilter("height", "20px")
        );
    }
    public function testBoolAttrFilterFalse(): void {
        $this->assertEquals(
            '',
            _::boolAttrFilter("checked", false)
        );
    }
    public function testBoolAttrFilterTrue(): void {
        $this->assertEquals(
            ' checked',
            _::boolAttrFilter("checked", "true")
        );
    }
    public function testStringifyStyles(): void {
        $this->assertEquals(
            'height:20px;',
            _::stringifyStyles(["height" => "20px"])
        );
    }
}
