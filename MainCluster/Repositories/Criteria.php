<?php

namespace App\Clusters\MainCluster\Repositories;

use App\Clusters\MainCluster\Repositories\Contracts\RepositoryInterface;

abstract class Criteria
{
    /**
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public abstract function apply( $model, RepositoryInterface $repository );
}
