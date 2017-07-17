<?php

namespace Clusters\MainCluster\Models;

use Illuminate\Database\Eloquent\Model;

abstract class MasterModel extends Model
{

    public static function tableName()
    {
        return (new static)->getTable();
    }
}
