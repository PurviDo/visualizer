<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $successStatus = 200;
    protected $insertStatus = 201;
    protected $validationStatus = 400;
    protected $errorStatus = 500;
    protected $unauthorizedStatus = 401;
    protected $notFoundStatus = 404;
    protected $failedStatus = 451;
}

