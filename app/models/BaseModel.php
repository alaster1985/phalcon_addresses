<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 08.09.2019
 * Time: 13:17
 */

namespace App\Models;

use Phalcon\Mvc\Model;

class BaseModel extends Model
{

    public static function getColumns($columnName)
    {
        $items = self::find()->toArray();
        $columns = [];
        foreach ($items as $item) {
            array_push($columns, $item[$columnName]);
        }
        return $columns;
    }
}