<?php

use App\Http\Controllers\Driver\HomeController;

use App\Http\Controllers\Driver\ContactController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::name('driver.')->group(function () {
    Route::get('/gioi-thieu', [HomeController::class, 'about'])->name('about');
    Route::get('/dich-vu', [HomeController::class, 'services'])->name('services');

    Route::get('/bang-gia', [HomeController::class, 'pricing'])->name('pricing');

    // Debug route
    Route::get('/debug-pricing', function () {
        $services = \App\Models\DriverService::where('status', true)->orderBy('sort_order')->get();
        $pricingRules = \App\Models\DriverPricingRule::with(['pricingDistances.distanceTier'])->active()->ordered()->get();
        $distanceTiers = \App\Models\DriverDistanceTier::active()->ordered()->get();

        // Build pricing matrix for easy viewing
        $pricingMatrix = [];
        foreach ($pricingRules as $rule) {
            $row = [
                'time_slot' => $rule->time_slot,
                'time_icon' => $rule->time_icon,
                'time_color' => $rule->time_color,
                'prices' => []
            ];

            foreach ($distanceTiers as $tier) {
                $pricingDistance = $rule->pricingDistances
                    ->where('distance_tier_id', $tier->id)
                    ->first();

                if ($pricingDistance) {
                    $row['prices'][$tier->display_text] = $pricingDistance->price_text ?: number_format($pricingDistance->price / 1000, 0) . 'k';
                } else {
                    $row['prices'][$tier->display_text] = '-';
                }
            }

            $pricingMatrix[] = $row;
        }

        return response()->json([
            'summary' => [
                'services_count' => $services->count(),
                'pricing_rules_count' => $pricingRules->count(),
                'distance_tiers_count' => $distanceTiers->count(),
            ],
            'pricing_matrix' => $pricingMatrix,
            'raw_data' => [
                'services' => $services->toArray(),
                'pricing_rules' => $pricingRules->toArray(),
                'distance_tiers' => $distanceTiers->toArray(),
            ]
        ], 200, [], JSON_PRETTY_PRINT);
    })->name('debug-pricing');

    // Create sample data route
    Route::get('/create-sample-data', function () {
        try {
            // 1. Create Distance Tiers
            $tiers = [
                [
                    'name' => '5km đầu',
                    'display_text' => '5km đầu',
                    'description' => 'Khoảng cách từ 0 đến 5km',
                    'from_distance' => 0,
                    'to_distance' => 5,
                    'is_active' => true,
                    'sort_order' => 1
                ],
                [
                    'name' => '6-10km',
                    'display_text' => '6-10km',
                    'description' => 'Khoảng cách từ 6 đến 10km',
                    'from_distance' => 6,
                    'to_distance' => 10,
                    'is_active' => true,
                    'sort_order' => 2
                ],
                [
                    'name' => '>10km',
                    'display_text' => '>10km',
                    'description' => 'Khoảng cách từ 11 đến 30km',
                    'from_distance' => 11,
                    'to_distance' => 30,
                    'is_active' => true,
                    'sort_order' => 3
                ],
                [
                    'name' => '>30km',
                    'display_text' => '>30km',
                    'description' => 'Khoảng cách trên 30km',
                    'from_distance' => 31,
                    'to_distance' => null,
                    'is_active' => true,
                    'sort_order' => 4
                ]
            ];

            foreach ($tiers as $tierData) {
                \App\Models\DriverDistanceTier::updateOrCreate(
                    ['name' => $tierData['name']],
                    $tierData
                );
            }

            // 2. Create Pricing Rules
            $rules = [
                [
                    'time_slot' => 'Trước 22h',
                    'time_icon' => 'fas fa-sun',
                    'time_color' => '#f59e0b',
                    'is_active' => true,
                    'sort_order' => 1
                ],
                [
                    'time_slot' => '22h-24h',
                    'time_icon' => 'fas fa-moon',
                    'time_color' => '#6366f1',
                    'is_active' => true,
                    'sort_order' => 2
                ],
                [
                    'time_slot' => 'Sau 24h',
                    'time_icon' => 'fas fa-star',
                    'time_color' => '#8b5cf6',
                    'is_active' => true,
                    'sort_order' => 3
                ]
            ];

            foreach ($rules as $ruleData) {
                \App\Models\DriverPricingRule::updateOrCreate(
                    ['time_slot' => $ruleData['time_slot']],
                    $ruleData
                );
            }

            // 3. Create Pricing Rule Distances
            $priceMatrix = [
                'Trước 22h' => [
                    '5km đầu' => ['price' => 245000.00, 'price_text' => null],
                    '6-10km' => ['price' => 20000.00, 'price_text' => null],
                    '>10km' => ['price' => 15000.00, 'price_text' => null],
                    '>30km' => ['price' => null, 'price_text' => 'Thỏa thuận']
                ],
                '22h-24h' => [
                    '5km đầu' => ['price' => 260000.00, 'price_text' => null],
                    '6-10km' => ['price' => 25000.00, 'price_text' => null],
                    '>10km' => ['price' => 20000.00, 'price_text' => null],
                    '>30km' => ['price' => null, 'price_text' => 'Thỏa thuận']
                ],
                'Sau 24h' => [
                    '5km đầu' => ['price' => 299000.00, 'price_text' => null],
                    '6-10km' => ['price' => 20000.00, 'price_text' => null],
                    '>10km' => ['price' => 20000.00, 'price_text' => null],
                    '>30km' => ['price' => null, 'price_text' => 'Thỏa thuận']
                ]
            ];

            foreach ($priceMatrix as $timeSlot => $prices) {
                $rule = \App\Models\DriverPricingRule::where('time_slot', $timeSlot)->first();
                if ($rule) {
                    foreach ($prices as $tierName => $priceData) {
                        $tier = \App\Models\DriverDistanceTier::where('name', $tierName)->first();
                        if ($tier) {
                            \App\Models\DriverPricingRuleDistance::updateOrCreate(
                                [
                                    'pricing_rule_id' => $rule->id,
                                    'distance_tier_id' => $tier->id
                                ],
                                $priceData
                            );
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Sample data created successfully!',
                'data' => [
                    'distance_tiers' => \App\Models\DriverDistanceTier::count(),
                    'pricing_rules' => \App\Models\DriverPricingRule::count(),
                    'rule_distances' => \App\Models\DriverPricingRuleDistance::count(),
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating sample data: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    })->name('create-sample-data');

    // Clear cache route
    Route::get('/clear-cache', function () {
        try {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');

            return response()->json([
                'success' => true,
                'message' => 'Cache cleared successfully!',
                'commands_run' => [
                    'cache:clear',
                    'view:clear',
                    'config:clear',
                    'route:clear'
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error clearing cache: ' . $e->getMessage()
            ], 500);
        }
    })->name('clear-cache');

    // Check database data route
    Route::get('/check-db-data', function () {
        try {
            $distanceTiers = \App\Models\DriverDistanceTier::all();
            $pricingRules = \App\Models\DriverPricingRule::all();
            $ruleDistances = \App\Models\DriverPricingRuleDistance::all();

            $data = [
                'distance_tiers' => [
                    'count' => $distanceTiers->count(),
                    'data' => $distanceTiers->map(function ($tier) {
                        return [
                            'id' => $tier->id,
                            'name' => $tier->name,
                            'display_text' => $tier->display_text,
                            'is_active' => $tier->is_active
                        ];
                    })
                ],
                'pricing_rules' => [
                    'count' => $pricingRules->count(),
                    'data' => $pricingRules->map(function ($rule) {
                        return [
                            'id' => $rule->id,
                            'time_slot' => $rule->time_slot,
                            'is_active' => $rule->is_active
                        ];
                    })
                ],
                'rule_distances' => [
                    'count' => $ruleDistances->count(),
                    'data' => $ruleDistances->map(function ($rd) {
                        return [
                            'id' => $rd->id,
                            'pricing_rule_id' => $rd->pricing_rule_id,
                            'distance_tier_id' => $rd->distance_tier_id,
                            'price' => $rd->price,
                            'price_text' => $rd->price_text
                        ];
                    })
                ]
            ];

            return response()->json($data, 200, [], JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    })->name('check-db-data');

    // Debug admin controller data
    Route::get('/debug-admin-data', function () {
        try {
            // Simulate what admin controller does
            $pricingRules = \App\Models\DriverPricingRule::with(['pricingDistances.distanceTier'])
                ->orderBy('sort_order')
                ->get();

            $distanceTiers = \App\Models\DriverDistanceTier::active()->ordered()->get();

            $result = [
                'pricing_rules_count' => $pricingRules->count(),
                'distance_tiers_count' => $distanceTiers->count(),
                'pricing_rules' => $pricingRules->map(function ($rule) {
                    return [
                        'id' => $rule->id,
                        'time_slot' => $rule->time_slot,
                        'time_icon' => $rule->time_icon,
                        'pricing_distances_count' => $rule->pricingDistances->count(),
                        'pricing_distances' => $rule->pricingDistances->map(function ($pd) {
                            return [
                                'distance_tier_id' => $pd->distance_tier_id,
                                'tier_name' => $pd->distanceTier->name ?? 'N/A',
                                'tier_display' => $pd->distanceTier->display_text ?? 'N/A',
                                'price' => $pd->price,
                                'price_text' => $pd->price_text,
                                'formatted_price' => $pd->price ? number_format($pd->price / 1000, 0) . 'k' : $pd->price_text
                            ];
                        })
                    ];
                }),
                'distance_tiers' => $distanceTiers->map(function ($tier) {
                    return [
                        'id' => $tier->id,
                        'name' => $tier->name,
                        'display_text' => $tier->display_text,
                        'from_distance' => $tier->from_distance,
                        'to_distance' => $tier->to_distance
                    ];
                })
            ];

            return response()->json($result, 200, [], JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    })->name('debug-admin-data');

    // Test admin view directly
    Route::get('/test-admin-view', function () {
        try {
            $pricingRules = \App\Models\DriverPricingRule::with(['pricingDistances.distanceTier'])
                ->orderBy('sort_order')
                ->get();

            $distanceTiers = \App\Models\DriverDistanceTier::active()->ordered()->get();

            return view('admin.driver.pricing-rules.index', [
                'pricingRules' => $pricingRules,
                'distanceTiers' => $distanceTiers,
                'filters' => [],
                'options' => []
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    })->name('test-admin-view');

    Route::get('/tin-tuc', [HomeController::class, 'news'])->name('news');
    Route::get('/tin-tuc/{slug}', [HomeController::class, 'newsDetail'])->name('news.detail');
    Route::get('/lien-he', [HomeController::class, 'contact'])->name('contact');
    Route::view('/gui-danh-gia', 'driver.review_request')->name('review.request');
    
    // Contact form submission
    Route::post('/lien-he', [ContactController::class, 'submit'])->name('contact.submit');

    // News Routes
    Route::get('/news', [\App\Http\Controllers\Driver\NewsController::class, 'index'])->name('news');
    Route::get('/news/{slug}', [\App\Http\Controllers\Driver\NewsController::class, 'show'])->name('news.detail');
    Route::get('/news/category/{slug}', [\App\Http\Controllers\Driver\NewsController::class, 'category'])->name('news.category');
    Route::get('/news/tag/{slug}', [\App\Http\Controllers\Driver\NewsController::class, 'tag'])->name('news.tag');
});
