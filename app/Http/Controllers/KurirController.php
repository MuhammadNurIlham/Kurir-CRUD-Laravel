<?php

namespace App\Http\Controllers;

use App\Models\Kurir;
use App\Http\Requests\StoreKurirRequest;
use App\Http\Requests\UpdateKurirRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KurirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kurir = Kurir::all();
        return response()->json([
            'message' => 'Get All Success',
            'data' => ($kurir)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi dari setiap field input menggunakan Validator sebagai data mandatory
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|numeric',
            'action' => 'required|in:Success,On The Way,Pending,Canceled'
        ], [
            'action.in' => 'The action field must be either: Success, On The Way, Pending, Canceled'
        ]);

        // Pengujian jika data yang dimasukkan tidak lolos pada tahap validasi maka akan mengembali pesan error secara informatif
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], 422);
        }

        // Membuat data baru berdasarkan value dari request body
        $kurir = Kurir::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'action' => $request->action,
        ]);

        // mengembalikan nilai berupa data json ketika data berhasil ditambahkan dan mengembalikan http status code 201
        return response()->json([
            'message' => 'Add Data Kurir Success',
            'data' => $kurir
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kurir $kurir, $id)
    {
        // handling error menggunakan try catch blok
        try {
            // mencari data Kurir berdasarkan ID
            $kurir = Kurir::findOrFail($id);

            // mengembalikan response json jika data ditemukan
            return response()->json([
                'message' => 'Get Kurir with ID: ' . $id . ' Success',
                'data' => $kurir
            ], 200);;
        } catch (ModelNotFoundException $e) {

            // mengembalikan response json dengan status 404 jika tidak ada data yang ditemukan
            return response()->json([
                'message' => 'Get Kurir Failed',
                'error' => 'Data Kurir with id ' . $id . ' not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    // 

    public function update(Request $request, Kurir $kurir, $id)
    {
        // Validasi dari setiap field input menggunakan Validator sebagai data mandatory
        // dengan method sometimes agar tetap lolos validasi jika tidak ada data yang dirubah
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|max:255',
            'address' => 'sometimes|max:255',
            'phone' => 'sometimes|numeric',
            'action' => 'sometimes|in:Success,On The Way,Pending,Canceled'
        ], [
            'action.in' => 'The action field must be either: Success, On The Way, Pending, Canceled'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Update Kurir Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $kurir = Kurir::findOrFail($id);
            $kurir->update($request->all());

            return response()->json([
                'message' => 'Data Kurir Updated Success',
                'data' => $kurir
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Update Kurir Failed',
                'error' => 'Data Kurir with id ' . $id . ' not found'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Update Kurir Failed',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kurir $kurir, $id)
    {
        try {
            $kurir = Kurir::findOrFail($id);
            $kurir->delete();

            return response()->json([
                'message' => 'Delete Data Kurir Success',
                'data' => ($kurir)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Delete Kurir Failed',
                'error' => 'Data Kurir with id ' . $id . ' not found'
            ], 404);
        }
    }
}
