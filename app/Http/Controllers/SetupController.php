<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    function roles(Request $request){
        if ($request->isMethod('post')){
            $request->validate([
                'name' => 'required|string',
                'display_name' => 'nullable|string',
                'description' => 'nullable|string',
            ]);
            $role = new Role();
            $role->name = $request->get('name');
            $role->display_name = $request->get('display_name');
            $role->description = $request->get('description');
            $role->save();
            return response('Successfully added',202);
        } else {
            return response()->json(['data' => Role::all()],200);
        }

    }
}
