<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ColorsModel;
use App\Models\BrandingKitsModel;
use App\Models\ThemeModel;
use App\Models\FontModel;
use App\Models\User;

class DashboardController extends Controller
{
    function index(Request $request) {

        $services = Service::count();
        $colors = ColorsModel::count();
        $brandingkits = BrandingKitsModel::count();
        $themes = ThemeModel::count();
        $fonts = FontModel::count();
        $users = User::count();
        return view('admin.dashboard',compact('services','colors','brandingkits','themes','fonts','users'));
    }
}
