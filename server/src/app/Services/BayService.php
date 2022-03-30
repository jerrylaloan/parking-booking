<?php

namespace App\Services;

use App\Models\Bay;

class BayService {
    public function getAll($status) {
        if ($status == 'all') return Bay::all();

        return Bay::where('available', $status == 'available' ? true : false)->get();
    }

    public function bayIsAvailable($id){
        return (Bay::find($id))->available;
    }
}