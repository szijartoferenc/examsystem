<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\PasswordReset;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    //
    public function loadRegister()
    {
        return view('register');
    }

    public function studentRegister(Request $request)
    {
          $request->validate([
            'name' => 'string|required|min:5',
            'email' => 'string|email|required|max:100|unique:users',
            'password'=>'string|required|confirmed|min:8'
          ]);

          $user = new User;
          $user->name = $request->name;
          $user->email = $request->email;
          $user->password = Hash::make($request->password);
          $user->save();

          return back()->with('success', 'Your registration has been successfull');
    }

    public function loadLogin()
    {
        if(Auth::user() && Auth::user()->admin_role == 1){
            return redirect('/admin/dashboard');
        }
        else if(Auth::user() && Auth::user()->admin_role == 0){
                return redirect('/dashboard');
        }
        return view('login');
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'email'=> 'string|required|email',
            'password'=> 'string|required'
        ]);

        $userCredential = $request->only('email','password');
        if(Auth::attempt($userCredential))
        {
            if(Auth::user()->admin_role == 1)
            {
                return redirect('/admin/dashboard');
            }
            else{

                return redirect('/dashboard');
            }
        }
        else {

            return back()->with('error','Username and password is incorrect');
        }
    }

    public function loadDashboard()
    {
       $exams = Exam::with('subjects')->orderBy('date')->get();
        return view('student.dashboard', ['exams'=>$exams]);
    }

    public function adminDashboard()
    {
        $subjects = Subject::all();
        return view('admin.dashboard', compact('subjects'));
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }

    //forget-password
    public function forgetPasswordLoad()
    {
        return view('forget-password');
    }

    public function forgetPassword(Request $request)
    {
        try{

            $user = User::where('email', $request->email)->get();

            if (count($user) > 0) {

                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain.'/reset-password?token='.$token;

                $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = 'Jelszócsere';
                $data['body'] = 'A jelszócseréhez kattintson az alábbi linkre!';

                Mail::send('forgetPasswordMail',['data'=>$data],function($message) use ($data){
                    $message->to($data['email'])->subject($data['title']);
                });

                $dateTime = Carbon::now()->format('Y-m-d H:i:s');

                PasswordReset::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'email'=>$request->email,
                        'token'=>$token,
                        'created_at'=>$dateTime
                    ]

                );
                return back()->with('success', 'A jelszó újraindításhoz ellenőrizze az emailt');


            }
            else{
                return back()->with('error', 'Az email cím nem létezik');
            }

        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function resetPasswordLoad(Request $request)
    {
        try{

            $resetData = PasswordReset::where('token', $request->token)->get();

            if (isset($request->token) && count($resetData) > 0) {

              $user = User::where('email',$resetData[0]['email'])->get();


                return view('resetPassword', compact('user'));


            }
            else{
                return view('404');
            }

        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password'=> 'required|string|min:8|confirmed'
        ]);

        $user = User::find($request->id);
        $user->password = Hash::make($request->password);
        $user->save();

        PasswordReset::where('email', $user->email)->delete();

        return "<h2>A jelszócsere sikeres volt!</h2>";

    }






}
