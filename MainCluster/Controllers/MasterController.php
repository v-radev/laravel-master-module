<?php

namespace App\Clusters\MainCluster\Controllers;

use App\Clusters\AuthCluster\Models\User;
use App\Http\Controllers\Controller;

abstract class MasterController extends Controller
{

    /**
     * @var User
     */
    public $currentUser = null;


    public function __construct()
    {
        $this->currentUser = \Auth::user();
        $routeName = \Request::route() ? \Request::route()->getName() : '';

        view()->share('route', $routeName);
        view()->share('user', $this->currentUser);
    }
}
