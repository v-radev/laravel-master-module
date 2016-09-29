<?php

namespace App\Clusters\MainCluster\Repositories;

use App\Clusters\MainCluster\Libraries\Traits\Repositories\CriteriableModelTrait;
use App\Clusters\MainCluster\Libraries\Traits\Repositories\CrudableModelTrait;
use App\Clusters\MainCluster\Libraries\Traits\Repositories\FindableModelTrait;
use App\Clusters\MainCluster\Repositories\Contracts\CriteriaInterface;
use App\Clusters\MainCluster\Repositories\Contracts\RepositoryInterface;
use App\Clusters\MainCluster\Repositories\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use League\Flysystem\Exception;
use Prophecy\Exception\Doubler\MethodNotFoundException;

abstract class Repository implements RepositoryInterface, CriteriaInterface
{

    use CriteriableModelTrait;
    use FindableModelTrait;
    use CrudableModelTrait;


    /**
     * @var App
     */
    private $app;

    /**
     * @var Model
     */
    protected $model;


    /**
     * @param App        $app
     * @param Collection $collection
     *
     * @throws RepositoryException
     */
    public function __construct( App $app, Collection $collection )
    {
        $this->app = $app;
        $this->criteria = $collection;

        $this->resetScope();
        $this->makeModel();
    }

    public function __call( $name, $arguments )
    {
        if ( method_exists( $this, $name ) ) { // method exists in the repository
            return call_user_func_array([$this, $name], $arguments);
        } elseif ( method_exists( $this->model, $name ) ) { // method exists in the model
            return call_user_func_array([$this->model, $name], $arguments);
        } else {
            try { // try to call static method to model ( e.g scopeSomething )
                return forward_static_call_array( [ $this->model, $name ], $arguments );
            } catch( Exception $e ) {
                throw new MethodNotFoundException( 'Method "'. $name .'" does not exist!', __CLASS__, $name );
            }
        }
    }


    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public abstract function model();


    /**
     * @param  string $value
     * @param  string $key
     *
     * @return array
     */
    public function lists( $value, $key = null )
    {
        $this->applyCriteria();

        $lists = $this->model->lists( $value, $key );

        if ( is_array( $lists ) ) {
            return $lists;
        }

        return $lists->all();
    }

    /**
     * @param int   $perPage
     * @param array $options
     *
     * @return mixed
     *
     */
    public function paginate( $perPage = 1, $options = [ 'columns' => [ '*' ], 'trashed' => false, 'with' => [ ] ] )
    {
        $this->applyCriteria();

        $this->applyOptions( $options );

        return $this->model->paginate( $perPage, $options['columns'] );
    }


    /**
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this->app->make( $this->model() );

        if ( !$model instanceof Model ) {
            throw new RepositoryException( "Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model" );
        }

        return $this->model = $model;
    }

    /**
     * Apply the default acceptable options to the query builder
     *
     * @param $options
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyOptions( array &$options )
    {
        $defaults = ['columns' => ['*'], 'trashed' => false, 'with' => [], 'order_by' => null];
        $options = array_merge( $defaults, $options );

        $chain = $this->model;

        if ( $options['trashed'] ) {
            $chain = $chain->withTrashed();
        }

        if ( $options['order_by'] ) {
            $chain = $chain->orderBy( $options['order_by'] );
        }

        if ( !empty( $options['with'] ) ) {
            $chain = $chain->with( $options['with'] );
        }

        $this->model = $chain;
    }

    /**
     * Apply options on the query builder
     *
     * @param $options
     */
    public function setOptions( $options = ['trashed' => false, 'with' => []] )
    {
        $this->applyOptions( $options );
    }
}
