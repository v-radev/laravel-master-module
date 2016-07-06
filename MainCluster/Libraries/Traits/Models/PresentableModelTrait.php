<?php

namespace App\Clusters\MainCluster\Libraries\Traits\Models;

trait PresentableModelTrait
{

    /**
     * View presenter instance
     *
     * @var mixed
     */
    protected $presenterInstance;


    /**
     * Prepare a new or cached presenter instance
     *
     * @return mixed
     * @throws \Exception
     */
    public function present()
    {
        if ( !property_exists( $this, 'presenter' ) || !class_exists( $this->presenter ) ) {
            throw new \Exception( 'Please set the $presenter property to your presenter path.' );
        }

        if ( !$this->presenterInstance ) {
            $this->presenterInstance = new $this->presenter( $this );
        }

        return $this->presenterInstance;
    }
}
