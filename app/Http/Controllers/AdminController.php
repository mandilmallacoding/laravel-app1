<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        //toaster
        $notification = array(
            'message' => 'Admin logged out successfully.',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    }

    public function profile(){
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile',compact('adminData'));
    }

    public function EditProfile(){
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_edit_profile',compact('adminData'));
    }

    public function UpdateProfile(Request $request):RedirectResponse{
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        if($request->file('profile_img')){
            $file = $request->file('profile_img');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['profile_image'] = $filename;
        }
        $data->save();
        //toaster
        $notification = array(
            'message' => 'Admin profile updated successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.profile')->with($notification);
    }

    public function ChangePassword(){
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_change_password',compact('adminData'));
    }

    public function UpdatePassword(Request $request): RedirectResponse
    {
        // echo "mandil";
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required|confirmed',
            // 'confirmpassword' => 'required|same:newpassword',
        ]);
        $hashedpassword = Auth::user()->password;
        if(Hash::check($request->oldpassword, $hashedpassword)){
            $id = Auth::user()->id;
            $users = User::find($id);
            $users->password = bcrypt($request->newpassword);
            $users->save();
            //toaster
            $notification = array(
            'message' => 'old & new pw matched',
            'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{

            // session()->flash('message',"old password doesn't match");
            $notification = array(
                'message' => 'old password not match',
                'alert-type' => 'success'
                );
            return back()->with($notification);
        }
    }
}
