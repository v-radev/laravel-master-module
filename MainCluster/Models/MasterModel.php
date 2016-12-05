<?php

namespace App\Clusters\MainCluster\Models;

use Illuminate\Database\Eloquent\Model;

class MasterModel extends Model
{

    public static function tableName()
    {
        return (new static)->getTable();
    }
}
