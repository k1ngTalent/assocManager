<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use App\Approval;
use App\Documents;

class VeriController extends Controller
{
    public function approveOne(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'by'=>'required|exists:users,id',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()]);
        }
        // $Approval = Approval::find($id);
        // if($Approval){
        //   $Approval->approved='true';
        //   $Approval->save();
        //   return response()->json(['status' => 'success', 'message' => 'approved successfully'], Response::HTTP_OK);
        // }
        $document = Documents::find($id);
        $response=$document->approval()->create([
            'doc_id'=>$id,
            'by'=>$request->input('by'),
            'approved'=>'true'
        ]);
        if($response){
            return response()->json(['status' => 'success', 'message' => 'approved successfully'], Response::HTTP_OK);
        }
        return response()->json(['status' => 'error', 'message' => 'Not Approved'], Response::HTTP_CREATED);
        
        
    }
    public function approveAll(Request $request)
    {
         $validator = Validator::make($request->all(),[
            'by'=>'required|exists:users,id',
            'assoc_id'=>'required|exists:associations,id'
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()]);
        }
        $association = Association::find($request->input('assoc_id'));
        $response=$association->approval()->create([
            'assoc_id'=>$request->input('associ_id'),
            'by'=>$request->input('by'),
            'approved'=>'true'
        ]);
        if($response){
            return response()->json(['status' => 'success', 'message' => 'approved successfully'], Response::HTTP_OK);
        }
        return response()->json(['status' => 'error', 'message' => 'Not Approved'], Response::HTTP_CREATED);
      
    }
    
    
    public function disApproveOne(Request $request)
    {

        $validator = Validate::make($request->all(),[
            'assoc_id'=>'required|exists:associations,id',
            'by'=>'required|esists:users,id',
            'comments'=>'required'
        ]);
        if($validator->fails()){
            return resposne()->json(['error'=>$validator->errors()]);
        }
        $association = App\Association::find($request->input('assoc_id'));
        $comment = self::addComment($request);
            if($comment==true){
                return response()->json(['status' => 'success', 'message' => 'disapproved successfully'], Response::HTTP_OK);
            }
          
        
        return response()->json(['status' => 'error', 'message' => 'Not disapproved'], Response::HTTP_CREATED);


    }

    protected function addComment(Request $request,$id)
    {
        $input = $request->all();
    $comment = App\Comments::create($input);
    if($comment){
        return true;
    }
    return false;
    }
}
