<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * home page
     *
     * @return object
     */
    public function home()
    {
        return view(
            'templates.' . config('app.template') . '.pages.guest.home'
        );
    }

    /**
     * admin home page
     *
     * @return object
     */
    public function adminHome()
    {
        return view(
            'templates.' . config('app.template') . '.pages.admin.home'
        );
    }
}
