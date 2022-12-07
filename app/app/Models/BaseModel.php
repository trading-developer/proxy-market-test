<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
 * BaseModel
 */
class BaseModel extends Model
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_DEACTIVE = 0;

    public const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_DEACTIVE,
    ];

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return with(new static)->getTable();
    }
}
