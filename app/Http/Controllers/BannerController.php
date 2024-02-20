<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Http\Resources\BannerResource;
use Hossam\Licht\Controllers\LichtBaseController;
use App\Traits\ManagesFiles;

class BannerController extends Controller
{
    use ManagesFiles;
    public function index()
    {
        $banners = Banner::all();
        return view('banners', compact('banners'));
    }

    public function store(StoreBannerRequest $request)
    {
        $validData = $request->validated();
        $validData['image'] = $this->uploadFile($request->file('image'), Banner::PathToStoredImages);
        $banner = Banner::create($validData);
        return redirect()->route('banners.index');
    }

    public function show(Banner $banner)
    {
        return $this->successResponse(BannerResource::make($banner));
    }

    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $validData = $request->validated();
        if ($request->hasFile('image')) {
            $this->deleteFile($banner->image);
            $validData['image'] = $this->uploadFile($request->file('image'), Banner::PathToStoredImages);
        }
        $banner->update($validData);
        return redirect()->route('banners.index');
    }

    public function destroy(Banner $banner)
    {
        $this->deleteFile($banner->image);
        $banner->delete();
        return redirect()->route('banners.index');
    }
    public function apiIndex()
    {
        $banners = BannerResource::collection(Banner::all());
        return $this->apiResponse($banners);
    }
}
