<?php

declare(strict_types=1);

/*
 * This file is part of Badcow DNS Library.
 *
 * (c) Samuel Williams <sam@badcow.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Badcow\DNS\Tests\Rdata;

use Badcow\DNS\Rdata\CNAME;
use PHPUnit\Framework\TestCase;

class CnameRdataTest extends TestCase
{
    public function testOutput(): void
    {
        $target = 'foo.example.com.';
        $cname = new CNAME();
        $cname->setTarget($target);

        $this->assertEquals($target, $cname->toText());
    }

    public function testFromText(): void
    {
        $text = 'host.example.com.';
        /** @var CNAME $cname */
        $cname = CNAME::fromText($text);

        $this->assertEquals($text, $cname->getTarget());
    }

    public function testWire(): void
    {
        $host = 'host.example.com.';
        $expectation = chr(4).'host'.chr(7).'example'.chr(3).'com'.chr(0);

        /** @var CNAME $cname */
        $cname = CNAME::fromWire($expectation);

        $this->assertEquals($expectation, $cname->toWire());
        $this->assertEquals($host, $cname->getTarget());
    }
}
