<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\DriverService;
use App\Models\DriverPricingRule;
use App\Models\DriverPricingTier;
use App\Models\DriverDistanceTier;
use App\Models\Testimonial;
use App\Models\Post;
use App\Models\HomeBanner;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use App\Helpers\ContactInfoHelper;

class HomeController extends Controller
{
    public function index()
    {
        $services = DriverService::where('status', true)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $featuredServices = DriverService::where('status', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        $testimonials = Testimonial::where('status', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $posts = Post::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Lấy dữ liệu bảng giá từ database
        $pricingRules = DriverPricingRule::with(['pricingDistances.distanceTier'])->active()->ordered()->get();
        $distanceTiers = DriverDistanceTier::active()->ordered()->get();

        // Lấy thông tin liên hệ từ ContactInfoHelper
        $contactInfo = ContactInfoHelper::getContactInfo();

        $homeBanner = HomeBanner::where('status', true)->first();

        return view('driver.home', compact('services', 'featuredServices', 'testimonials', 'posts', 'pricingRules', 'distanceTiers', 'contactInfo', 'homeBanner'));
    }

    public function about()
    {
        return view('driver.about');
    }

    public function services()
    {
        $services = DriverService::where('status', true)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('driver.services', compact('services'));
    }

    public function pricing()
    {
        $services = DriverService::where('status', true)
            ->orderBy('sort_order')
            ->get();

        $pricingRules = DriverPricingRule::with(['pricingDistances.distanceTier'])->active()->ordered()->get();
        $distanceTiers = DriverDistanceTier::active()->ordered()->get();

        // Lấy thông tin liên hệ từ ContactInfoHelper
        $contactInfo = ContactInfoHelper::getContactInfo();

        return view('driver.pricing', compact('services', 'pricingRules', 'distanceTiers', 'contactInfo'));
    }

    public function news()
    {
        $posts = Post::with(['category', 'author', 'tags'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        // Get popular posts
        $popularPosts = Post::where('status', 'published')
            ->orderBy('views', 'desc')
            ->take(4)
            ->get();

        // Get categories with post counts
        $categories = \App\Models\PostCategory::where('status', true)
            ->withCount(['posts' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('sort_order')
            ->get();

        // Get category counts for filter buttons
        $categoryCounts = [];
        foreach ($categories as $category) {
            $categoryCounts[$category->slug] = $category->posts_count;
        }

        // Get total posts count
        $totalPosts = Post::where('status', 'published')->count();

        // Lấy thông tin liên hệ từ ContactInfoHelper
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

    public function contact()
    {
        return view('driver.contact');
    }

    public function newsDetail($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $relatedPosts = Post::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('driver.news-detail', compact('post', 'relatedPosts'));
    }
}
