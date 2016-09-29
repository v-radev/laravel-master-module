<?php

namespace App\Clusters\MainCluster\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{

    /**
     * @param array $options
     *
     * @return mixed
     *
     */
    public function all( $options = [ 'columns' => [ '*' ], 'trashed' => false, 'with' => [ ] ] );

    /**
     * @param int   $perPage
     * @param array $options
     *
     * @return mixed
     *
     */
    public function paginate( $perPage = 1, $options = [ 'columns' => [ '*' ], 'trashed' => false, 'with' => [ ] ] );

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create( array $data );

    /**
     * @param array                              $data
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return mixed
     */
    public function update( array $data, Model $model );

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return mixed
     */
    public function delete( Model $model );

    /**
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find( $id, $columns = [ '*' ] );

    /**
     * @param       $id
     * @param array $options
     *
     * @return mixed
     *
     */
    public function findOrFail( $id, $options = [ 'columns' => [ '*' ], 'trashed' => false, 'with' => [ ] ] );

    /**
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findBy( $field, $value, $columns = [ '*' ] );

    /**
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findAllBy( $field, $value, $columns = [ '*' ] );

    /**
     * @param       $where
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhere( $where, $columns = [ '*' ] );

}
