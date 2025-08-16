<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */    
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $page_title = 'Dashboard';

        $role = Auth::user()->user_type;

        return match ($role) {
            'admin'    => view('backend.dashboard.index', compact('page_title')),
            'customer' => view('backend.dashboard.customer'),
            'seller'   => view('dashboard.seller'),
            'staff'    => view('dashboard.staff'),
            default    => abort(403, 'Unauthorized access'),
        };
    }

}
