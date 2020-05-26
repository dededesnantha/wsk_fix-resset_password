<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\client;
use App\Models\log_action;

use Validator;


class ClientController extends Controller
{
    public function record($value='')
    {
        $data = log_action::count();        
        return response()->json($data,200);
    }
    public function create(Request $request)
    {   
        $valid = Validator::make($request->all(),[
            'name' => 'required',
            'domain' => 'required'
        ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(),400);        
        }
        $check =  client::where('domain','like','%'.$request->input('domain').'%')->count();
        if ($check >= 1) {
            return response()->json(['error'=> 'Domain Sudah Ada'],400);
        }


        client::create($request->all());

        return response()->json(['status'=>200],200);
    }

   
    public function store()
    {
        $data = client::orderby('id','DESC')->get();
        return response()->json($data,200); 
    }

   
    public function update(Request $request, $id)
    {
        client::find($id)->update($request->all());
        return response()->json(['status'=>200],200);    
    }

    public function destroy($id)
    {
        client::find($id)->delete();
        return response()->json(['status'=>200],200);   
    }
}