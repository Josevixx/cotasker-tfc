<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ContactController extends Controller
{
    public function contact(): View
    {
        return view('footer.contact');
    }
}
