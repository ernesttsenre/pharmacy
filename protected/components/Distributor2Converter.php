<?php

/**
 * Created by PhpStorm.
 * User: olegivanov
 * Date: 23.09.16
 * Time: 13:00
 */
class Distributor2Converter extends FileConverterAbstract
{
    protected function parse()
    {
        array_shift($this->raw);

        foreach ($this->raw as $row) {
            preg_match('/^(.*)\t(.*)\t(\d+)/', $row, $matches);
            if ($matches && count($matches) == 4) {
                array_shift($matches);

                list($product, $pharmacy, $count) = $matches;

                $this->data[] = [$pharmacy, $product, floatval($count)];
            } else {
                throw new Exception('Parse function is failed');
            }
        }
    }
}