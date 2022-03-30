<?php

namespace App\Services;

use App\Models\Bay;

class BayService {

    /**
     * Fetch all bay
     * 
     * @param  string $status - enum of status ('all'|'available'|'not_available')
     * @return Bay[] - list of bay
     */
    public function getAll($status) {
        if ($status == 'all') return Bay::all();

        return Bay::where('available', $status == 'available' ? true : false)->get();
    }

    /**
     * Check bay availability by id
     * 
     * @param  string $id - bay id
     * @return boolean - value of available attributes
     */
    public function bayIsAvailable($id){
        return (Bay::find($id))->available;
    }
}