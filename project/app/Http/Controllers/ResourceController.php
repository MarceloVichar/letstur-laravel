<?php

namespace App\Http\Shared\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

class ResourceController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;

    public function callAction($method, $parameters)
    {
        $allowedResourceMethods = ['index', 'store', 'show', 'update', 'destroy', 'restore'];

        if (! in_array($method, $allowedResourceMethods)) {
            throw new \BadMethodCallException(
                "Method [$method] is not allowed in Resource Controllers"
            );
        }

        return parent::callAction($method, $parameters);
    }
}
