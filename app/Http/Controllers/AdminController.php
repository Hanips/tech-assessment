<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $productsCount = Product::count();
        $activeProductsCount = Product::where('status', 'active')->count();
        $usersCount = User::count();
        $activeUsersCount = User::where('status', 'active')->count();
        $latestProducts = Product::latest()->take(10)->get();

        return view('admin.home', compact('productsCount', 'activeProductsCount', 'usersCount', 'activeUsersCount', 'latestProducts'));
    }

    public function userList()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
}
