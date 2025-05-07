<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class SuscriptionController extends Controller
{
    public function suscription(): View
    {
        return view('suscription');
    }
}
