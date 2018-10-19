<?php
/**
 * Created by PhpStorm.
 * User: gurik
 * Date: 17.10.2018
 * Time: 22:08
 */

namespace gurikin\csvwork\models\Helpers;

/**
 * Class GeneratorHelper
 * @package gurikin\csvwork\models\Helpers
 */
class GeneratorHelper {
    public static function getCount($filename) {
        $functor = self::readTheFile($filename);
        return iterator_count($functor);
    }

    public static function readTheFile($filename) {
        $handle = fopen($filename, "rw");

        while(!feof($handle)) {
            yield trim(fgets($handle));
        }
        fclose($handle);
    }
}