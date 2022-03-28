<?php

namespace App\Services;

use App\Models\Bay;

class BayService {
    public function getAll($status) {
        if ($status == 'all') return Bay::all();

        return Bay::where('availabe', $status == 'available' ? true : false);
    }
}