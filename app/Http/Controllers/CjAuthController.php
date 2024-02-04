<?php

namespace App\Http\Controllers;

use App\Models\CjAuth;
use App\Http\Requests\StoreCjAuthRequest;
use App\Http\Requests\UpdateCjAuthRequest;
use App\Http\Resources\CjAuthResource;
use Hossam\Licht\Controllers\LichtBaseController;

class CjAuthController extends LichtBaseController
{

    public function index()
    {
        $cjAuths = CjAuth::all();
        return view('cjAuths', compact('cjAuths'));
    }

    public function store(StoreCjAuthRequest $request)
    {
        $cjAuth = CjAuth::create($request->validated());
        return redirect()->route('cj-auths.index');
    }

    public function show(CjAuth $cjAuth)
    {
        return $this->successResponse(CjAuthResource::make($cjAuth));
    }

    public function update(UpdateCjAuthRequest $request, CjAuth $cjAuth)
    {
        $cjAuth->update($request->validated());
        return redirect()->route('cj-auths.index');
    }

    public function destroy(CjAuth $cjAuth)
    {
        $cjAuth->delete();
        return redirect()->route('cj-auths.index');
    }
}
