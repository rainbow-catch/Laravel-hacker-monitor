<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Data::orderBy('id', 'DESC')->get();
        return view('admin.data.index', ['data' => $data]);
    }

    public function data_save(Request $request) {
        $data = $request->parms;
        $data_id = $data[0];
        $data_check = Data::where('id', $data_id)->get();

        if(!$data[0])
        {
            Data::create([
                'title' => $data[1],
                'content' => $data[2],
                'date' => $data[3],
            ]);
        }
        else
        {
            $dataUpdate = [
                'title' => $data[1],
                'content' => $data[2],
                'date' => $data[3],
            ];
            Data::where('id', $data_id)->update($dataUpdate);
        }

        return response()->json('success');
    }

    public function data_delete(Request $request) {
        Data::where('id', $request->id)->delete();
    }

    public function getData(Request $request) {
        $data = $request->all();
        return $data;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
     * @param  \App\Models\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function show(Data $data)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function edit(Data $data)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Data $data)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function destroy(Data $data)
    {
        //
    }
}
