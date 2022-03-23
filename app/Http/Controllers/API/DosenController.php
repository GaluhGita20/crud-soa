<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Dosen;
use App\Http\Resources\DosenResource;

class DosenController extends Controller
{
    //
    public function index()
    {
        $data = Dosen::latest()->get();
        return response()->json([DosenResource::collection($data), 'Dosen fetched.']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nip' => 'required|string|max:15',
            'nama' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $dosen = Dosen::create([
            'nip' => $request->nip,
            'nama' => $request->nama
         ]);
        
        return response()->json(['Dosen created successfully.', new DosenResource($dosen)]);
    }

    public function show($id)
    {
        $dosen = Dosen::find($id);
        if (is_null($dosen)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new DosenResource($dosen)]);
    }

    public function update(Request $request, Dosen $dosen)
    {
        $validator = Validator::make($request->all(),[
            'nip' => 'required|string|max:15',
            'nama' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $dosen->nip = $request->nip;
        $dosen->nama = $request->nama;
        $dosen->save();
        
        return response()->json(['Dosen updated successfully.', new DosenResource($dosen)]);
    }

    public function destroy(Dosen $dosen)
    {
        $dosen->delete();

        return response()->json('Dosen deleted successfully');
    }
}
