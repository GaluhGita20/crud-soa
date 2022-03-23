<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\MataKuliah;
use App\Http\Resources\MataKuliahResource;

class MataKuliahController extends Controller
{
    //
    public function index()
    {
        $data = MataKuliah::latest()->get();
        return response()->json([MataKuliahResource::collection($data), 'Mata Kuliah fetched.']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'semester' => 'required',
            'sks' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $mataKuliah = MataKuliah::create([
            'nama' => $request->nama,
            'semester' => $request->semester,
            'sks' => $request->sks
         ]);
        
        return response()->json(['Mata Kuliah created successfully.', new MataKuliahResource($mataKuliah)]);
    }

    public function show($id)
    {
        $matakuliah = MataKuliah::find($id);
        if (is_null($matakuliah)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new MahasiswaResource($matakuliah)]);
    }

    public function update(Request $request, MataKuliah $matakuliah)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'semester' => 'required',
            'sks' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $matakuliah->nama = $request->nama;
        $matakuliah->semester = $request->semester;
        $matakuliah->sks = $request->sks;
        $matakuliah->save();
        
        return response()->json(['Mata Kuliah updated successfully.', new MataKuliahResource($matakuliah)]);
    }

    public function destroy(MataKuliah $matakuliah)
    {
        $matakuliah->delete();

        return response()->json('Mata Kuliah deleted successfully');
    }
}
