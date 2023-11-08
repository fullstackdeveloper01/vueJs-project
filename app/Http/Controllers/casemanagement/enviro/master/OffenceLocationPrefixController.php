<?php

namespace App\Http\Controllers\casemanagement\enviro\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\casemanagement\enviro\master\OffenceLocationPrefix;
use App\Models\casemanagement\enviro\master\OffenceLocationSuffix;
use App\Http\Resources\casemanagement\enviro\master\OffenceLocationPrefixResource;

class OffenceLocationPrefixController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $searchQuery  = $request->get('q');
        $status = $request->get('status');
        $perPage = $request->get('perPage', 10);
        $currentPage = $request->get('currentPage', 1);
        $data = OffenceLocationPrefix::when($searchQuery , function ($query) use ($searchQuery ) {
            $query->where(function($query) use ($searchQuery) {
             $query->where('textOnMachine', 'LIKE', '%' . $searchQuery  . '%')
                ->orWhere('textOnLetter', 'LIKE', '%' . $searchQuery  . '%');
            });
        })
        ->when(isset($status), function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json([
            'data' => OffenceLocationPrefixResource::collection($data),
            'pagination' => [
                'currentPage' => $data->currentPage(),
                'perPage' => $data->perPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
            ],
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'textOnMachine' => 'required|max:255',
            'textOnLetter' => 'required|max:255',
        ]);

        $data = OffenceLocationPrefix::create($validatedData);

        return response()->json(['message' => 'Offence Location Prefix has been added successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = OffenceLocationPrefix::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $validatedData = $request->validate([
            'textOnMachine' => 'required|max:255',
            'textOnLetter' => 'required|max:255',
        ]);

        $item->textOnMachine = $validatedData['textOnMachine'];
        $item->textOnLetter = $validatedData['textOnLetter'];
        $item->save();

        return response()->json(['message' => 'Offence Location Prefix has been updated successfully'], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $item = OffenceLocationPrefix::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $validatedData = $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $item->status = $validatedData['status'];
        $item->save();

        return response()->json(['message' => 'Offence Location Prefix Status has been updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function fetch_locs_prefix()
    {
        $raw = OffenceLocationPrefix::where('status', '1')->get();
        $data = [];
        foreach($raw as $obj)
        {
            $item = [
                'id' => $obj->id,
                'name' => $obj->textOnMachine
            ];
            array_push($data, $item);
        }

        return response()->json($data);
    }

    public function fetch_locs_sufix()
    {
        $raw = OffenceLocationSuffix::where('status', '1')->get();
        $data = [];
        foreach($raw as $obj)
        {
            $item = [
                'id' => $obj->id,
                'name' => $obj->textOnMachine
            ];
            array_push($data, $item);
        }

        return response()->json($data);
    }
}
