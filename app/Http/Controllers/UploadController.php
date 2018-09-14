<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Documents;
use App\User;
use App\Association;
class UploadController extends Controller
{  
    
    const NUM = 5;
    public function addUpload(Request $request)
    {

        $validator = Validator::make($request->all(), Documents::entryValidationRule());
		if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], Response::HTTP_CREATED);            
        }
        $coll_slug = $request->input('coll_slug');
        $assoc_slug = $request->input('assoc_slug');

       
        for ($x = 1; $x <= self::NUM; $x++) {
            $files[] = array(
                'type' => $x,
                'filename' => 'doc'.$x,
                'file' => $request->file('doc'.$x),
            );
        }
        $user = new User();
        $password = $user->random_char();
        $hashedpass = bcrypt($password);
        $user = User::create([
            'email' => $request->input('email'),
            'password' =>$hashedpass,
            'role' => 'patron',
            'assoc_id'=>$request->input('assoc_id'),
            'college_id'=>$request->input('college_id')
        ]);
        $response['token']=$user->createToken('assocManager')->accessToken;
        $response['email']=$user->email;
        $response['password']=$password;

        
        foreach ($files as $file) {
            $assocDoc = Association::find($request->input('assoc_id'));
            if($assocDoc){
                $type = $file['type'];
                $doc = $file['file'];
                $extension = $doc->getClientOriginalExtension();
                $filename = $file['filename'] . '.' . $extension;
                $destinationPath = public_path('/documents/'.$coll_slug.'/'.$assoc_slug . '/' . date('Y'));
                $docPath = $destinationPath.'/'.$filename;
                $doc->move($destinationPath, $filename);
    
                $response = $assocDoc->documents()->create([
                    'path' => $docPath,
                    'type' => $type,
                    'status' => 'success',
                ]);
            }
            
        }
        if($response){
           return response()->json(['status'=>'success','message'=>'entry received','data'=>$response],Response::HTTP_OK);
        }
           return response()->json(['status'=>'error','message'=>'error,Try again!',],Response::HTTP_CREATED);  

    }
    public function updateUpload(Request $request,$id ,$assoc_id){
        $validator = Validator::make($request->all(), Documents::entryUpdateValidationRule());
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], Response::HTTP_CREATED);            
        }
        if($request->has('email')){
            
            $con = new User();
                $password = $con->random_char();
                 $hashedpass = bcrypt($password);
            $user = User::find($id);
            if($user){
                $user->email = $request->input('email');
                $user->password = $hashedpass;
                $user->save();
                return response()->json(['status'=>'success','message'=>'patron Updated','data'=>$user],Response::HTTP_OK);
            }else{
                $validator = Validator::make($request->all(),[
                    'college_id'=>'required'
                    ]);
                if ($validator->fails()) { 
                        return response()->json(['error'=>$validator->errors()], Response::HTTP_CREATED);            
                }
                $user = User::create([
                    'email' => $request->input('email'),
                    'password' =>$hashedpass,
                    'role' => 'patron',
                    'assoc_id'=>$assoc_id,
                    'college_id'=>$request->input('college_id')
                ]);
                $response['token']=$user->createToken('assocManager')->accessToken;
                $response['email']=$user->email;
                $response['password']=$password;
                return response()->json(['status'=>'success','message'=>'patron added','data'=>$response],Response::HTTP_OK);
            }
            return response()->json(['status'=>'success','message'=>'Try again'],Response::HTTP_CREATED);
         
        }

       

        for($x=1;$x<=self::NUM;$x++){
            if($request->has('doc'.$x)){
                $validator = Validator::make($request->all(),[
                    'doc'.$x=>'required|mimes:pdf|max:50000',
                    'coll_slug'=>'required',
                    'assoc_slug'=>'required',
                    ]);
                    if ($validator->fails()) { 
                        return response()->json(['error'=>$validator->errors()], Response::HTTP_CREATED);            
                }
                $document = Documents::find($id);
                $file = $request->file('doc'.$x);
                $extension = $file->getClientOriginalExtension();
                $filename = 'doc'.$x. '.' . $extension;
                $destinationPath = public_path('documents/'.$request->input('coll_slug').'/'.$request->input('assoc_slug') . '/' . date('Y'));
               $docPath = $destinationPath.'/'.$filename;
               
                if($document){
                    $file->move($destinationPath, $filename);
                 $document->path=$docPath;
                 $document->type=$x;
                 $document->save();
                 return response()->json(['status'=>'success','message'=>'Doc'.$x.' updated successfullly'],Response::HTTP_OK);
                }else{
                    $assocDoc = Association::find($assoc_id);
                    if($assocDoc){
                        $file->move($destinationPath, $filename);
                         
                        $response = $assocDoc->documents()->create([
                        'path' => $docPath,
                        'assoc_id'=>$assoc_id,
                        'type' => $x,
                        'status' => 'success',
                       ]);
                       return response()->json(['status'=>'success','message'=>'Doc'.$x.' uploaded successfullly'],Response::HTTP_OK);
                    }
                    return response()->json(['status'=>'success','message'=>'Please Try Again!'],Response::HTTP_OK);
               
                }
                return response()->json(['status'=>'error','message'=>'Please Try Again!'],Response::HTTP_CREATED);
            }
        }
        
       
    }
    public function userUpload(Request $request){
        $validator = Validator::make($request->json()->all(),[
            'pfname'=>'required',
            'plname'=>'required',
            'pemail'=>['required|',Rule::unique('users')->where(function ($query)use($request) {
                            return $query->where('session', date('Y').'/'.date('Y',strtotime('+1year')));
                        })
                ],
            'prole'=>['required|',Rule::unique('users')->where(function ($query)use($request) {
                return $query->where('session', date('Y').'/'.date('Y',strtotime('+1year')));
            })
    ],
            'hfname'=>'required',
            'hlname'=>'required',
            'hemail'=>['required|',Rule::unique('users')->where(function ($query)use($request) {
                return $query->where('session', date('Y').'/'.date('Y',strtotime('+1year')));
            })
    ],
            'hrole'=>['required|',Rule::unique('users')->where(function ($query)use($request) {
                return $query->where('session', date('Y').'/'.date('Y',strtotime('+1year')));
            })
    ],
            ]);
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], Response::HTTP_CREATED);            
        }

    }
}
