<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bay;
use App\Services\BayService;
use Illuminate\Http\Request;

class BayController extends Controller
{
    protected $bayService;

    public function __construct(BayService $bayService)
    {
        $this->bayService = $bayService;
    }

    public function get(Request $request) {

        if(Bay::count() === 0) {
		    Bay::insert([
	      		['name' => 'bay 1', 'location' => 'location 1', 'available' => true],
	      		['name' => 'bay 2', 'location' => 'location 2', 'available' => true],
	      		['name' => 'bay 3', 'location' => 'location 3', 'available' => true],
		    ]);
        }

        $status = $request->query('status', 'all');
        $result = $this->bayService->getAll($status);

        return response()->json($result);
    }




    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
