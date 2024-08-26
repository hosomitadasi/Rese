<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Store;

class AdminController extends Controller
{
    public function indexManager()
    {
        return view('admin.manager');
    }

    public function addOwner()
    {
        return view('admin.addOwner');
    }

    public function editOwner()
    {
        return view('admin.editOwner');
    }

    public function indexOwner()
    {
        return view('admin.owner');
    }

    public function indexMenu3()
    {
        return view('menu.menu3');
    }
}
