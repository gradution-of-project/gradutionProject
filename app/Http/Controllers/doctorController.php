<?php

namespace App\Http\Controllers;

use App\user;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class doctorController extends Controller
{
    //

    public function signup(Request $request){

        $doctor =new user();
        if($this->validation($request)) {
            $data=$request->input();

            $request->session()->put("data",$data);

            $doctor->fristname = $request->input('fname');
            $doctor->lastname = $request->input('lname');
            $doctor->email = $request->input('email');
            $doctor->password = bcrypt($request->input('password'));
            $doctor->gender = $request->input('sl-gender');
            $doctor->brithdate = $request->input('brithdate');
            $doctor->phone = $request->input('phone');
            $doctor->describtion=$request->input('description');
            $doctor->clenicAdress=$request->input('clenicAdress');
            $doctor->role=$request->input('sl-role');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $exetantion = $file->getClientOriginalName();
                $namefile=time() .'.'. $exetantion;
                $file->move(  'publicimages/',$namefile);
                $doctor->image=$namefile;
            } else {
                return $request;
                $doctor->image='';
            }
           if( $doctor->save()){
               $this->signin($request);
           }
            return  redirect()->route('/');
        }

        }




    public function signin(Request $request){

        $this->validate($request,[

            'email'=>'required',
            'password'=>'required'
        ]);
     //   print_r(Auth::attempt(['email'=> $request['email'], 'password'=>$request['password']]));
        if(Auth::attempt(['email'=> $request['email'], 'password'=>$request['password']])){
            return redirect()->route('/');
        }else{
            return redirect()->back()->with('doctor','sorry email or password is invalid tray again');
        }

    }

    public function validation(Request $request){
        $this->validate($request,[
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required|email',
            'password'=>'required|min:8',
            'confrimpassword'=>'required',
            'clenicAdress'=>'required',
            'description'=>'required',
            'sl-role'=>'required'
        ]);
        return $request->all();
    }


}
