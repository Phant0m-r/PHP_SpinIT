<?php

namespace Adil\SpinitPhp\Models;

use \Exception;

class DatabasePDO extends \PDO
{
    public function __construct(string $file)
    {
        if (!$settings = parse_ini_file($file, true)) throw new Exception('Unable to open' . $file . '.');

        $dns = $settings['database']['driver'] .
            ':host=' . $settings['database']['host'] .
            ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
            ';dbname=' . $settings['database']['schema'];

        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
    }
}