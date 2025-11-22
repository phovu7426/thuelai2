<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Helpers\ContactInfoHelper;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'author', 'tags'])
                    ->published();

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Filter by tag
        if ($request->has('tag')) {
            $query->byTag($request->tag);
        }

        $posts = $query->latest('published_at')
                      ->paginate(12);

        // Get popular posts
        $popularPosts = Post::published()
                           ->popular(5)
                           ->get();

        // Get categories with post counts
        $categories = PostCategory::active()
                                ->withCount(['posts' => function($query) {
                                    $query->published();
                                }])

                                ->get();

        // Get category counts for filter buttons
        $categoryCounts = [];
        foreach ($categories as $category) {
            $categoryCounts[$category->slug] = $category->posts_count;
        }

        // Get total posts count
        $totalPosts = Post::published()->count();

        // Get contact info
        $contactInfo = ContactInfoHelper::getContactInfo();

        return view('driver.news', compact(
            'posts',
            'popularPosts',
            'categories',
            'categoryCounts',
            'totalPosts',
            'contactInfo'
        ));
    }

    public function show($slug)
    {
        $post = Post::with(['category', 'author', 'tags'])
                   ->published()
                   ->where('slug', $slug)
                   ->firstOrFail();

        // Increment views
        $post->incrementViews();

        // Get related posts
        $relatedPosts = Post::published()
                           ->where('id', '!=', $post->id)
                           ->where('category_id', $post->category_id)
                           ->latest('published_at')
                           ->limit(3)
                           ->get();

        // If not enough related posts by category, get by tags
        if ($relatedPosts->count() < 3) {
            $tagIds = $post->tags->pluck('id');
            $additionalPosts = Post::published()
                                 ->where('id', '!=', $post->id)
                                 ->whereHas('tags', function($query) use ($tagIds) {
                                     $query->whereIn('id', $tagIds);
                                 })
                                 ->latest('published_at')
                                 ->limit(3 - $relatedPosts->count())
                                 ->get();

            $relatedPosts = $relatedPosts->merge($additionalPosts);
        }

        // If still not enough, get latest posts
        if ($relatedPosts->count() < 3) {
            $existingIds = $relatedPosts->pluck('id')->push($post->id);
            $latestPosts = Post::published()
                             ->whereNotIn('id', $existingIds)
                             ->latest('published_at')
                             ->limit(3 - $relatedPosts->count())
                             ->get();

            $relatedPosts = $relatedPosts->merge($latestPosts);
        }

        return view('driver.news-detail', compact('post', 'relatedPosts'));
    }

    public function category($slug)
    {
        $category = PostCategory::where('slug', $slug)
                               ->active()
                               ->firstOrFail();

        $posts = Post::with(['author', 'tags'])
                    ->published()
                    ->byCategory($slug)
                    ->latest('published_at')
                    ->paginate(12);

        return view('driver.news-category', compact('category', 'posts'));
    }

    public function tag($slug)
    {
        $tag = PostTag::where('slug', $slug)
                     ->active()
                     ->firstOrFail();

        $posts = Post::with(['category', 'author'])
                    ->published()
                    ->byTag($slug)
                    ->latest('published_at')
                    ->paginate(12);

        return view('driver.news-tag', compact('tag', 'posts'));
    }
}




