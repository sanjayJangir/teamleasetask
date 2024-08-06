<?php

namespace App\Http\Controllers;

use App\Imports\ImportUsers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        Excel::import(new ImportUsers, $request->file('file'));

        return redirect()->back()->with('success', 'Users imported successfully.');
    }
}
