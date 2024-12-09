<?php

namespace SourceSpan\Tests;

use PHPUnit\Framework\TestCase;
use SourceSpan\FileSpan;
use SourceSpan\SourceFile;

class FileLocationTest extends TestCase
{
    private SourceFile $file;

    protected function setUp(): void
    {
        $this->file = SourceFile::fromString(<<<'TXT'
foo bar baz
whiz bang boom
zip zap zop
TXT
        );
    }

    public function testReportsTheCorrectLineNumber(): void
    {
        self::assertEquals(1, $this->file->location(15)->getLine());
    }

    public function testReportsTheCorrectColumnNumber(): void
    {
        self::assertEquals(3, $this->file->location(15)->getColumn());
    }

    public function testPointSpanReturnsAFileSpan(): void
    {
        $location = $this->file->location(15);
        $span = $location->pointSpan();

        self::assertInstanceOf(FileSpan::class, $span);
        self::assertEquals($location, $span->getStart());
        self::assertEquals($location, $span->getEnd());
        self::assertEmpty($span->getText());
    }
}
