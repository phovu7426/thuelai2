<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Home\HomeBannerRequest;
use App\Models\HomeBanner;
use Illuminate\Http\Request;

class HomeBannerController extends Controller
{
    public function edit()
    {
        $banner = HomeBanner::first();
        if (!$banner) {
            $banner = new HomeBanner([
                'status' => true,
                'button_text' => 'Tìm hiểu thêm',
            ]);
            $banner->save();
        }

        return view('admin.home-banner.edit', compact('banner'));
    }

    public function update(HomeBannerRequest $request)
    {
        $banner = HomeBanner::first();
        if (!$banner) {
            $banner = new HomeBanner();
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('home_banners', 'public');
        }

        $data['status'] = isset($data['status']) ? (bool)$data['status'] : false;
        $data['is_announcement'] = isset($data['is_announcement']) ? (bool)$data['is_announcement'] : false;

        $banner->fill($data);
        $banner->save();

        return redirect()->route('admin.home-banner.edit')->with('success', 'Cập nhật banner thành công!');
    }
}


