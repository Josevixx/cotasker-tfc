<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class TermsController extends Controller
{
    public function terms(): View
    {
        return view('footer.terms');
    }
}
