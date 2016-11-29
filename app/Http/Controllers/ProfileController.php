<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    function editUser () {

      return view('private.profile.edit.user');
    }

    function updateUser (Request $request) {


      if(Hash::check($request->input('password'), Auth::user()->password)){

        $validateData = $this->validatorData($request->except(['new-password','new-password_confirmation', 'change-password']));

        if ($request->input('change-password')){
          $validateNewPassword = $this->validatorNewPassword($request->only(['new-password','new-password_confirmation']));
        }

        if (isset($validateNewPassword) && $validateNewPassword->fails()){
          return redirect('/home/profile/edit/user')->withInput($request->except('change-password'))->withErrors($validateNewPassword);
        }

        if ($validateData->fails()){ // Have to fix so it shows the last data
          return redirect('/home/profile/edit/user')->withInput($request->except('change-password'))->withErrors($validateData);
        }

          $this->changeData($request->except(['new-password','new-password_confirmation', 'change-password']));

          if(isset($validateNewPassword)) $this->changePassword($request->only(['new-password','new-password_confirmation']));

          return redirect('/home');
      }

      return redirect(url('/home/profile/edit/user'))
          ->withInput($request->except('change-password'))
          ->withErrors(['password' => 'Contraseña incorrecta', // FIX THIS!!!!!!!!!! the error message should come from... ¿Some other place?
          ]);
    }


    private function validatorData(array $data)
    {
        return Validator::make($data, [
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:255',
            'password' => 'required|min:6|',
        ]);
    }

    private function validatorNewPassword (array $data){
      return Validator::make($data, [
          'new-password' => 'required|min:6|confirmed',
          'new-password_confirmation' => 'required',
      ]);
    }

    private function changeData ($data) {

      Auth::user()->fill([
        'firstName' => $data['firstName'],
        'lastName' => $data['lastName'],
        'address' => $data['address'],
        'phone' => $data['phone'],
      ])->save();


  //    $user->profilePicture = $data['profilePicture']; // FIX THIS!!!!!!!!!! should be saved

    }

    private function changePassword ($data) {

      Auth::user()->fill([
        'password' => bcrypt($data['new-password']),
      ])->save();
    }

}
