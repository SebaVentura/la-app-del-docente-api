<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PerfilRequest;

class PerfilController extends Controller
{
    public function show(Request $request)
    {
        return response()->json(['data' => $request->user()->perfilDocente]);
    }

    public function update(PerfilRequest $request)
    {
        $data = $request->validated();
        $profile = $request->user()->perfilDocente()->updateOrCreate(
            ['user_id' => $request->user()->id],
            $data
        );

        return response()->json(['data' => $profile]);
    }
}
