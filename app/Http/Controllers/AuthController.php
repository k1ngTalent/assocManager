<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\ValidationException;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request){ 

        $validator = Validator::make($request->all(),[
            'email'=>'email|required',
            'password'=>'required'
        ]);
		if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], Response::HTTP_UNAUTHORIZED);            
        }

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('assocManager')->accessToken; 
            return response()->json(['status'=>'success','message'=>'Login successful','data' => $success], Response::HTTP_OK); 
        } 
        else{ 
            return response()->json(['status'=>'error','message'=>'Email or password is incorrect'], Response::HTTP_UNAUTHORIZED); 
        } 
    }

    public function addUser(Request $request){
        $assoc_id = $request->input('assoc_id');
        $validator = Validator::make($request->all(),[
            'email'=>'email|unique:users|required',
            'firstname'=>'required',
            'password'=>'required',
            'assoc_id'=>'required|exists:associations,id',
            'role'=>['required',
              Rule::unique('users')->where(function ($query)use($request) {
                //   if($request->role=='HOD'){
                // return $query->where('assoc_id',$request->assoc_id)->where('college_id',$request->college_id);
                //   }
                return $query->where('assoc_id', $request->assoc_id);
            })
        ],
            
            'college_id'=>'required|exists:colleges,id'

        ]);
		if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], Response::HTTP_UNAUTHORIZED);            
        }
		$input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('assocManager')->accessToken; 
        $success['email'] =  $user->email;
		return response()->json(['success'=>$success], Response::HTTP_OK); 
    }

    public function update(Request $request, $id){

    	$user = User::find($id);

    	$validator = Validator::make($request->all(), [
            'email'=>'email|unique:users|required',
            'firstname'=>'required',
            'lastname'=>'required',
            'role'=>['required',
              Rule::unique('users')->where(function ($query)use($request) {
                //   if($request->role=='HOD'){
                // return $query->where('assoc_id',$request->assoc_id)->where('college_id',$request->college_id);
                //   }
                return $query->where('assoc_id', $request->assoc_id);
            })
        ],
            'assoc_id'=>'required|exists:associations,id',
            'college_id'=>'required|exists:colleges,id'

        ]);
		if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], Response::HTTP_CREATED);            
        }

    	if($user){

    		if ($request->has('firstname'))
			    {
			    	$user->firstname = $request->input('firstname');
			    }

			if ($request->has('lastname'))
			    {
			    	$user->lastname = $request->input('lastname');
			    }
			if ($request->has('email'))
			    {
			    	$user->company = $request->input('email');
			    }
			if ($request->has('role'))
			    {
			    	$user->email = $request->input('role');
			    }
			if ($request->has('assoc_id'))
			    {
			    	$user->assoc_id = $request->input('assoc_id');
                }
            if ($request->has('college_id'))
			    {
			    	$user->college_id = $request->input('college_id');
			    }

			$user->save();

    		return response()->json(['status'=>'success', 'message'=>'employee_updated','data'=>$user],Response::HTTP_OK);
    	}

    	return response()->json(['status'=>'error', 'message'=>'employee_not_found'],Response::HTTP_CREATED);
    }
    public function deleteUser(Request $request, $id)
    {
        $user = User::find($id);

        if($user){
        	$user->delete();

        	return response()->json(['status'=>'success', 'message'=>'user deleted'],Response::HTTP_OK);
    	}

        return response()->json(['status'=>'error', 'message'=>'user not found'],Response::HTTP_CREATED);
    }
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], Response::HTTP_OK); 
    }
}
