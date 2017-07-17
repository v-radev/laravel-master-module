<?php

namespace Clusters\MainCluster\Libraries\Traits\Repositories;

use Clusters\MainCluster\Repositories\QueryFilter;
use Clusters\MainCluster\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

trait FilterableModelTrait
{
    /**
     * Filter a result set.
     *
     * @param  Builder     $builder
     * @param  QueryFilter $filters
     *
     * @return Builder
     */
    public function scopeFilter($builder, QueryFilter $filters)
    {
        return $filters->apply( $this->getRepo() );
    }

    /**
     * @return Repository
     */
    public abstract function getRepo();
}
