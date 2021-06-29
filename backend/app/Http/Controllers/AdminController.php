<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = Admin::orderBy('created_at', 'DESC')->get();
        $response = [
            'message' => 'List data Client order by time',
            'data' => $client
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'email' => ['required'],
            'no_telp' => ['required'],
            'status_iklan' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $client = Admin::create($request->all());
            $response = [
                'message' => 'client created',
                'data' => $client
            ];

            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Admin::findOrFail($id);
        $response = [
            'message' => 'Detail of client resource',
            'data' => $client
        ];

        return response()->json($response, Response::HTTP_OK);
    }
    /**
     *
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $date = \Carbon\Carbon::today()->subDays(30);
        $client = Admin::where('created_at', '>=', $date)->get();
        $response = [
            'message' => 'Last Client',
            'data' => $client
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        $client = Admin::where("nama", "like", "%" . $name . "%")->get();
        $response = [
            'message' => 'Client',
            'data' => $client
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     *
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function aktif(Request $request)
    {
        $client = \DB::table('admins')
            ->select([
                \DB::raw('count(*) as jumlah'),
                \DB::raw('DATE(created_at) as tanggal'),
                \DB::raw('status_iklan as status'),
            ])
            ->groupBy('tanggal', 'status_iklan')
            ->whereRaw('status_iklan = ? ', 'Aktif')
            ->orderBy('created_at', 'ASC')
            ->get()
            ->toArray();
        $response = [
            'data' => $client
        ];
        return response()->json($response, Response::HTTP_OK);
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
        $client = Admin::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'email' => ['required'],
            'no_telp' => ['required'],
            'status_iklan' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $client->update($request->all());
            $response = [
                'message' => 'client update',
                'data' => $client
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Admin::findOrFail($id);

        try {
            $client->delete();
            $response = [
                'message' => 'client deleted',
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }
}
