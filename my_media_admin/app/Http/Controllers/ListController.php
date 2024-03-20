<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class ListController extends Controller
{
    //direct list page
    public function index()
    {
        $userData = User::get();
        return view('admin.list.index', compact('userData'));
    }

    //delete admin account
    public function deleteAccount($id)
    {
        User::where('id', $id)->delete();
        return back()->with(['deleteSuccess' => 'User Account has been deleted successfully']);
    }

    //admin list search
    public function adminListSearch(Request $request)
    {
        $userData = User::orWhere('name', 'like', '%' . $request->adminSearchKey . '%')
            ->orWhere('email', 'like', '%' . $request->adminSearchKey . '%')
            ->orWhere('phone', 'like', '%' . $request->adminSearchKey . '%')
            ->orWhere('address', 'like', '%' . $request->adminSearchKey . '%')
            ->orWhere('gender', 'like', '%' . $request->adminSearchKey . '%')
            ->get();
        return view('admin.list.index', compact('userData'));
    }
}
