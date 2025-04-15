<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PrivacyController extends Controller
{
    public function privacy(): View
    {
        return view('footer.privacy');
    }
}
