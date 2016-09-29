<?php

namespace App\Clusters\MainCluster\Libraries\Traits\Repositories;

use App\Clusters\MainCluster\Repositories\Repository;

trait FindableModelTrait
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
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find( $id, $columns = ['*'] )
    {
        $this->applyCriteria();

        return $this->model->find( $id, $columns );
    }

    /**
     * @param       $id
     * @param array $options
     *
     * @return mixed
     *
     */
    public function findOrFail( $id, $options = ['columns' => ['*'], 'trashed' => false, 'with' => []] )
    {
        $this->applyCriteria();

        $this->applyOptions( $options );

        return $this->model->findOrFail( $id, $options['columns'] );
    }

    /**
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findBy( $attribute, $value, $columns = ['*'] )
    {
        $this->applyCriteria();

        return $this->model->where( $attribute, '=', $value )->first( $columns );
    }

    /**
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findAllBy( $attribute, $value, $columns = ['*'] )
    {
        $this->applyCriteria();

        return $this->model->where( $attribute, '=', $value )->get( $columns );
    }

    /**
     * Find a collection of models by the given query conditions.
     *
     * @param array $where
     * @param array $columns
     * @param bool  $or
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function findWhere( $where, $columns = ['*'], $or = false )
    {
        $this->applyCriteria();

        $model = $this->model;

        foreach ( $where as $field => $value ) {
            if ( $value instanceof \Closure ) {
                $model = ( !$or )
                    ? $model->where( $value )
                    : $model->orWhere( $value );
            } elseif ( is_array( $value ) ) {
                if ( count( $value ) === 3 ) {
                    list( $field, $operator, $search ) = $value;
                    $model = ( !$or )
                        ? $model->where( $field, $operator, $search )
                        : $model->orWhere( $field, $operator, $search );
                } elseif ( count( $value ) === 2 ) {
                    list( $field, $search ) = $value;
                    $model = ( !$or )
                        ? $model->where( $field, '=', $search )
                        : $model->orWhere( $field, '=', $search );
                }
            } else {
                $model = ( !$or )
                    ? $model->where( $field, '=', $value )
                    : $model->orWhere( $field, '=', $value );
            }
        }

        return $model->get( $columns );
    }
}
