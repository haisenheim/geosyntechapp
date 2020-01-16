<?php

namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\User;

class ProfilController extends Controller
{
    public function __invoke($id)
    {
        return view('/consultant/profile', ['user' => User::findOrFail($id)]);
    }
}