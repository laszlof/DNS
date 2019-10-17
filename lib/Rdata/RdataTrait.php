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

namespace Badcow\DNS\Rdata;

trait RdataTrait
{
    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        /* @const TYPE */
        return static::TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function getTypeCode(): int
    {
        /* @const TYPE_CODE */
        return static::TYPE_CODE;
    }

    /**
     * @deprecated
     *
     * @return string
     */
    public function output(): string
    {
        @trigger_error('Method RdataInterface::output() has been deprecated. Use RdataInterface::toText().', E_USER_DEPRECATED);

        return $this->toText();
    }

    /**
     * Encode a domain name as a sequence of labels.
     *
     * @param string $name
     *
     * @return string
     */
    public static function encodeName(string $name): string
    {
        if ('.' === $name) {
            return chr(0);
        }

        $name = rtrim($name, '.').'.';
        $res = '';

        foreach (explode('.', $name) as $label) {
            $res .= chr(strlen($label)).$label;
        }

        return $res;
    }

    /**
     * @param string $string
     * @param int    $offset
     *
     * @return string
     */
    public static function decodeName(string $string, int &$offset = 0): string
    {
        $len = ord($string[$offset]);
        ++$offset;

        if (0 === $len) {
            return '.';
        }

        $name = '';
        while (0 !== $len) {
            $name .= substr($string, $offset, $len).'.';
            $offset += $len;
            $len = ord($string[$offset]);
            ++$offset;
        }

        return $name;
    }
}
