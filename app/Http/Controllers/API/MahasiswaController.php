<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Mahasiswa;
use App\Http\Resources\MahasiswaResource;


class MahasiswaController extends Controller
{
    //
    public function index()
    {
        $data = Mahasiswa::latest()->get();
        return response()->json([MahasiswaResource::collection($data), 'Mahasiswa fetched.']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nim' => 'required|string|max:15',
            'nama' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $mahasiswa = Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama
         ]);
        
        return response()->json(['Mahasiswa created successfully.', new MahasiswaResource($mahasiswa)]);
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        if (is_null($mahasiswa)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new MahasiswaResource($mahasiswa)]);
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validator = Validator::make($request->all(),[
            'nim' => 'required|string|max:15',
            'nama' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $mahasiswa->nim = $request->nim;
        $mahasiswa->nama = $request->nama;
        $mahasiswa->save();
        
        return response()->json(['Mahasiswa updated successfully.', new MahasiswaResource($mahasiswa)]);
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return response()->json('Mahasiswa deleted successfully');
    }
}
