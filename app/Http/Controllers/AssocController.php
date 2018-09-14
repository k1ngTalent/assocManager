<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Validator;
use App\Association;
class AssocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function showAssocInfo(Request $request)
    // {
    //     $validator = Validator::make()
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function updateAssoc(Request $request, $id)
    // {
    //     $user = User::find($id);

    // 	$validator = Validator::make($request->all(), [
    //         'email'=>'email|unique:users|required',
    //         'firstname'=>'required',
    //         'lastname'=>'required',
    //         'role'=>['required',
    //           Rule::unique('users')->where(function ($query)use($request) {
    //             //   if($request->role=='HOD'){
    //             // return $query->where('assoc_id',$request->assoc_id)->where('college_id',$request->college_id);
    //             //   }
    //             return $query->where('assoc_id', $request->assoc_id);
    //         })
    //     ],
    //         'assoc_id'=>'required|exists:associations,id',
    //         'college_id'=>'required|exists:colleges,id'

    //     ]);
	// 	if ($validator->fails()) { 
    //         return response()->json(['error'=>$validator->errors()], Response::HTTP_CREATED);            
    //     }

    // 	if($user){

    // 		if ($request->has('firstname'))
	// 		    {
	// 		    	$user->firstname = $request->input('firstname');
	// 		    }

	// 		if ($request->has('lastname'))
	// 		    {
	// 		    	$user->lastname = $request->input('lastname');
	// 		    }
	// 		if ($request->has('email'))
	// 		    {
	// 		    	$user->company = $request->input('email');
	// 		    }
	// 		if ($request->has('role'))
	// 		    {
	// 		    	$user->email = $request->input('role');
	// 		    }
	// 		if ($request->has('assoc_id'))
	// 		    {
	// 		    	$user->assoc_id = $request->input('assoc_id');
    //             }
    //         if ($request->has('college_id'))
	// 		    {
	// 		    	$user->college_id = $request->input('college_id');
	// 		    }

	// 		$user->save();

    // 		return response()->json(['status'=>'success', 'message'=>'employee_updated','data'=>$user],Response::HTTP_OK);
    // 	}

    // 	return response()->json(['status'=>'error', 'message'=>'employee_not_found'],Response::HTTP_CREATED);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function deleteAssoc($id)
    // {
    //     $assoc = Association::find($id);

    //     if($assoc){
    //     	$assoc->delete();

    //     	return response()->json(['status'=>'success', 'message'=>'association deleted'],Response::HTTP_OK);
    // 	}

    //     return response()->json(['status'=>'error', 'message'=>'association not found'],Response::HTTP_CREATED);
    // }
    
}
