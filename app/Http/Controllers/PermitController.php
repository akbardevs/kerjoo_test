<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Permit;
use App\Models\User;
use App\Services\InitializationFile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Permits;

class PermitController extends Controller
{
    //
    public function index()
    {
        return Permit::with(['user.type', 'file'])->get();
    }

    public function show(Request $request)
    {
        $request->merge(['id' => $request->route('id')]);
        $request->validate([
            'id' => [
                'required',
                'exists:users,id'
            ]
        ]);
        return Permit::with(['user.type', 'file'])->find($request->route('id'));
    }

    public function save(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => [
                    'required',
                    'exists:users,id'
                ],
                'permit_date' => 'required',
                'file' => 'required|file|max:10000',
            ]);
            $file = new InitializationFile;
            $request['file_id'] = $file->save($request->file);
            return Permit::create($request->all());
        } catch (Exception $e) {
            return null;
        }
    }
}
