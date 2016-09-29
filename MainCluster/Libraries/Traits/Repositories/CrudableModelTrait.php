<?php

namespace App\Clusters\MainCluster\Libraries\Traits\Repositories;

use App\Clusters\MainCluster\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

trait CrudableModelTrait
{

    /**
     * Apply the default acceptable options to the query builder
     *
     * @param $options
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected abstract function applyOptions( array &$options );

    /**
     * Apply criteria to the model query
     *
     * @return Repository
     */
    public abstract function applyCriteria();


    /**
     * @param array $options
     *
     * @return mixed
     *
     */
    public function all( $options = ['columns' => ['*'], 'trashed' => false, 'with' => [], 'order_by' => null] )
    {
        $this->applyCriteria();

        $this->applyOptions( $options );

        return $this->model->get( $options['columns'] );
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create( array $data )
    {
        return $this->model->create( $data );
    }

    /**
     * @param array                              $data
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return mixed
     */
    public function update( array $data, Model $model )
    {
        return $model->update( $data );
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return mixed
     */
    public function delete( Model $model )
    {
        return $model->delete();
    }
}
