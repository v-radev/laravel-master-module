<?php

namespace App\Clusters\MainCluster\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The builder instance.
     *
     * @var Repository
     */
    protected $repository;


    /**
     * Create a new QueryFilters instance.
     *
     * @param Request $request
     */
    public function __construct( Request $request )
    {
        $this->request = $request;
    }

    /**
     * Apply the filters to the builder.
     *
     * @param Repository $repository
     *
     * @return Builder
     */
    public function apply( Repository $repository )
    {
        $this->repository = $repository;

        foreach ( $this->filters() as $name => $value ) {
            $name = camel_case( $this->filterURLString( $name ) );

            if ( !method_exists( $this, $name ) ) {
                continue;
            }

            if ( is_array( $value ) || $value !== false ) {
                $value = is_array( $value ) ? array_map( [ $this, 'filterURLString' ], $value ) : $this->filterURLString( $value );
                $this->$name( $value );
            } else {
                $this->$name();
            }
        }

        return $this->repository;
    }

    /**
     * Get all request filters data.
     *
     * @return array
     */
    public function filters()
    {
        return $this->request->all();
    }

    public function filterURLString( $string )
    {
        $string = preg_replace( '/[^ \w-]+/', '', $string );
        $string = substr( $string, 0, 25 );

        return $string;
    }
}
