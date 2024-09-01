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
        return view('admin.index');
    }

    public function addOwner()
    {
        return view('admin.create');
    }

    public function editOwner($id)
    {
        $owner = User::find($id);
        return view('admin.edit', compact('owner'));
    }

    public function indexOwner()
    {
        $owners = User::role('owner')->get();
        return view('admin.index', compact('owners'));
    }

    public function indexMenu3()
    {
        return view('menu.menu3');
    }
}
