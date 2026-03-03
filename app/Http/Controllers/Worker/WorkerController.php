<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;

class WorkerController extends Controller
{
    public function dashboard()
    {
        return view('worker.dashboard');
    }
}
