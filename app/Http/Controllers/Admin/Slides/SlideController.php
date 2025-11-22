<?php

namespace App\Http\Controllers\Admin\Slides;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use App\Http\Requests\Admin\Slides\SlideRequest;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    public function index()
    {
        $slides = Slide::all();
        return view('admin.slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.slides.create');
    }

    public function store(SlideRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('slides', 'public');
        }
        Slide::create($data);
        return redirect()->route('admin.slides.index')->with('success', 'Thêm slide thành công!');
    }

    /**
     * Hiển thị chi tiết slide
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        try {
            $slide = Slide::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Lấy thông tin slide thành công.',
                'data' => $slide
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Slide không tồn tại.',
                'data' => null
            ], 404);
        }
    }

    public function edit($id)
    {
        $slide = Slide::findOrFail($id);
        return view('admin.slides.edit', compact('slide'));
    }

    public function update(SlideRequest $request, $id)
    {
        $slide = Slide::findOrFail($id);
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('slides', 'public');
        }
        $slide->update($data);
        return redirect()->route('admin.slides.index')->with('success', 'Cập nhật slide thành công!');
    }

    public function destroy($id)
    {
        $slide = Slide::findOrFail($id);
        $slide->delete();
        return redirect()->route('admin.slides.index')->with('success', 'Xoá slide thành công!');
    }

    public function toggleStatus($id)
    {
        try {
            $slide = Slide::findOrFail($id);
            $slide->status = !$slide->status;
            $slide->save();

            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật trạng thái thành công',
                'new_status' => $slide->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleFeatured($id)
    {
        try {
            $slide = Slide::findOrFail($id);
            $slide->is_featured = !$slide->is_featured;
            $slide->save();

            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật trạng thái nổi bật thành công',
                'new_featured' => $slide->is_featured
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
