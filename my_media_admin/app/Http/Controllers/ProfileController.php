<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationData;

class ProfileController extends Controller
{
    //direct admin home page
    public function index()
    {
        $id = Auth::user()->id;
        $user = User::select('id', 'name', 'email', 'address', 'phone', 'gender')->where('id', $id)->first();
        return view('admin.profile.index', compact('user'));
    }

    //update admin acc
    public function updateAdminAccount(Request $request)
    {
        $userData = $this->getUserInfo($request);

        //validation
        $validator = $this->userValidationCheck($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        //update in database
        User::where('id', Auth::user()->id)->update($userData);
        return back()->with(['updateSuccess' => 'Admin account updated successfully']);
    }

    //direct change password page
    public function directChangePassword()
    {
        return view('admin.profile.changePassword');
    }

    //change password
    public function changePassword(Request $request)
    {
        //checkpasswordvalidation
        $validator = $this->changePasswordValidationCheck($request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        //getdbpassword
        //hashnewpassword
        //storenewpasswordinarray
        //checkoldandnewsameornot
        //ifsame,update

        $dbData = User::where('id', Auth::user()->id)->first();
        $dbPassword = $dbData->password;
        $hashUserPassword = Hash::make($request->newPassword);

        $updateData = [
            'password' => $hashUserPassword,
            'updated_at' => Carbon::now()
        ];

        if (Hash::check($request->oldPassword, $dbPassword)) {
            User::where('id', Auth::user()->id)->update($updateData);
            return redirect()->route('dashboard');
        } else {
            return back()->with(['fail' => 'Old Password does not match']);
        }
    }

    //changePasswordValidationCheck
    private function changePasswordValidationCheck($request)
    {
        return Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:8|max:15',
            'confirmPassword' => 'required|same:newPassword|min:8|max:15'
        ]);
    }

    //userValidationCheck
    private function userValidationCheck($request)
    {
        return Validator::make($request->all(), [
            'adminName' => 'required',
            'adminEmail' => 'required'
        ], [
            // 'adminName.required' => 'Name is required',
            // 'adminEmail.required' => 'Email is required'
        ]);
    }

    //get user info
    private function getUserInfo($request)
    {
        return [
            'name' => $request->adminName,
            'email' => $request->adminEmail,
            'phone' => $request->adminPhone,
            'address' => $request->adminAddress,
            'gender' => $request->adminGender,
            'updated_at' => Carbon::now()
        ];
    }
}
