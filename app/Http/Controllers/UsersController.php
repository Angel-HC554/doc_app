<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = array();//this will return a set of users and doctor data
        $user = Auth::user();
        $doctor = User::where('type', 'doctor')->get();
        $doctorData = Doctor::all();

        //collect user data and all doctor data
        foreach ($doctorData as $data) {
            //sorting doctor name and doctor details 
            foreach ($doctor as $info) {
                if ($data['doc_id'] == $info['id']) {
                    $data['doctor_name'] = $info['name'];
                    $data['doctor_profile'] = $info['profile_photo_url'];
                }
            }
        }

        $user['doctor'] = $doctorData;
        return $user; //return all data
    }

     /**
     * login.
     */
    public function login(Request $request)
    {
        //create a controller to handle incoming request and return some data
        //validate incoming inputs
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        //check matching user
        $user = User::where('email', $request->email)->first();

        //check password
        if(!$user || ! Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email'=>['The provided credentials are incorrect'],
            ]);
        }

        //then return generated token
        return $user->createToken($request->email)->plainTextToken;

        // Devolver token como JSON
        //return response()->json([
        //'token' => $user->createToken($request->email)->plainTextToken,
        //]);
    }

     /**
     * register.
     */
    public function register(Request $request)
    {
        //create a controller to handle incoming request and return some data
        //validate incoming inputs
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'type'=>'user',
            'password'=>Hash::make($request->password),
        ]);

        $userInfo = UserDetails::create([
            'user_id'=>$user->id,
            'status'=>'active',
        ]);

        return $user;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
