<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProyekResource;
use App\Models\proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyek = proyek::all();
        return response(['proyeks' => ProyekResource::collection($proyek), 'message' => 'Data berhasil'],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'nama' => 'required|max:50',
            'harga' => 'required'
        ]);
        if($validation->fails()){
            return response(['error' => $validation->errors(), 'Validasi gagal']);
        }

        $proyek = proyek::create($data);
        return response(['proyek' => new ProyekResource($proyek), 'message' => 'Data berhasil'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function show(proyek $proyek)
    {
        return response(['proyek' => new ProyekResource($proyek), 'message' => 'Data berhasil diambil'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, proyek $proyek)
    {
        $proyek->update($request->all());
        return response(['proyek' => new ProyekResource($proyek), 'message' => 'Data berhasil diubah'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function destroy(proyek $proyek)
    {
        $proyek->delete();
        return response(['proyek' => 'Data berhasil dihapus']);
    }
}
