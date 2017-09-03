<?php

namespace App\Http\Controllers;

use App\Utils\ValidatesRequestsWithWrapper;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Utils\Uploader;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequestsWithWrapper, Uploader;
}
