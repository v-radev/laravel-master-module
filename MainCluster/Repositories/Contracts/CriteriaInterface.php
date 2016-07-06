<?php

namespace App\Clusters\MainCluster\Repositories\Contracts;

use App\Clusters\MainCluster\Repositories\Criteria;

interface CriteriaInterface
{

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function skipCriteria( $status = true );

    /**
     * @return mixed
     */
    public function getCriteria();

    /**
     * @param Criteria $criteria
     *
     * @return $this
     */
    public function getByCriteria( Criteria $criteria );

    /**
     * @param Criteria $criteria
     *
     * @return $this
     */
    public function pushCriteria( Criteria $criteria );

    /**
     * @return $this
     */
    public function  applyCriteria();
}
