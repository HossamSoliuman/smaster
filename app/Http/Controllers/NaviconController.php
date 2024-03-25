<?php

namespace App\Http\Controllers;

use App\Models\Navicon;
use App\Http\Requests\StoreNaviconRequest;
use App\Http\Requests\UpdateNaviconRequest;
use App\Http\Resources\NaviconResource;
use Hossam\Licht\Controllers\LichtBaseController;

class NaviconController extends LichtBaseController
{
    public function index()
    {
        $navicons = Navicon::all();
        return view('navicons', compact('navicons'));
    }

    public function store(StoreNaviconRequest $request)
    {
        $validData = $request->validated();
        $validData['image'] = $this->uploadFile($validData['image'], Navicon::PathToStoredImages);
        $navicon = Navicon::create($validData);
        return redirect()->route('nav-icons.index');
    }

    public function show(Navicon $navicon)
    {
        return $this->successResponse(NaviconResource::make($navicon));
    }

    public function update(UpdateNaviconRequest $request, Navicon $navIcon)
    {
        $validData = $request->validated();
        if ($request->hasFile('image')) {
            $this->deleteFile($navIcon->image);
            $validData['image'] = $this->uploadFile($request->file('image'), Navicon::PathToStoredImages);
        }
        $navIcon->update($validData);
        return redirect()->route('nav-icons.index');
    }

    public function destroy(Navicon $navIcon)
    {
        $this->deleteFile($navIcon->image);
        $navIcon->delete();
        return redirect()->route('nav-icons.index');
    }
    public function apiIndex()
    {
        $navicons = Navicon::all();
        return $this->successResponse(NaviconResource::collection($navicons));
    }
}
