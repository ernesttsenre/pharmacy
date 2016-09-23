<?php

/**
 * Created by PhpStorm.
 * User: olegivanov
 * Date: 23.09.16
 * Time: 15:35
 */
abstract class FileConverterAbstract implements FileConverterInterface
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     */
    protected $raw;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;

        $this->readFile();
        $this->parse();
    }

    /**
     * @return array
     */
    public function getData()
    {
        $raw = [];
        foreach ($this->data as $exist) {
            list($pharmacy, $product, $count) = $exist;

            if (!isset($raw[$pharmacy][$product])) {
                $raw[$pharmacy][$product] = 0;
            }

            $raw[$pharmacy][$product] += floatval($count);
        }

        $result = [];
        foreach ($raw as $pharmacy => $products) {
            foreach ($products as $product => $count) {
                $result[] = [
                    FileExist::FIELD_PHARMACY => $pharmacy,
                    FileExist::FIELD_PRODUCT => $product,
                    FileExist::FIELD_COUNT => $count,
                ];
            }
        }

        return $result;
    }

    protected function readFile()
    {
        $handle = fopen($this->path, 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $this->raw[] = $line;
            }

            fclose($handle);
        }
    }

    /**
     * Parse file strings into array: distributor, pharmacy, count
     */
    abstract protected function parse();
}