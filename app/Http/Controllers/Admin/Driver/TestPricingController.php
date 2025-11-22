<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\Controller;
use App\Models\DriverDistanceTier;
use App\Models\DriverPricingRule;
use App\Models\DriverPricingTier;
use Illuminate\Http\Request;

class TestPricingController extends Controller
{
    /**
     * Test basic functionality
     */
    public function test()
    {
        $results = [];
        
        // Test 1: Database connection
        try {
            \DB::connection()->getPdo();
            $results['database'] = '✓ Connected';
        } catch (\Exception $e) {
            $results['database'] = '✗ Error: ' . $e->getMessage();
        }
        
        // Test 2: Models
        try {
            $distanceTiers = DriverDistanceTier::count();
            $results['distance_tiers'] = "✓ {$distanceTiers} records";
        } catch (\Exception $e) {
            $results['distance_tiers'] = '✗ Error: ' . $e->getMessage();
        }
        
        try {
            $pricingRules = DriverPricingRule::count();
            $results['pricing_rules'] = "✓ {$pricingRules} records";
        } catch (\Exception $e) {
            $results['pricing_rules'] = '✗ Error: ' . $e->getMessage();
        }
        
        try {
            $pricingTiers = DriverPricingTier::count();
            $results['pricing_tiers'] = "✓ {$pricingTiers} records";
        } catch (\Exception $e) {
            $results['pricing_tiers'] = '✗ Error: ' . $e->getMessage();
        }
        
        // Test 3: Routes
        try {
            $routes = [
                'admin.driver.distance-tiers.index',
                'admin.driver.pricing-rules.index',
                'admin.driver.pricing-tiers.index'
            ];
            
            $routeResults = [];
            foreach ($routes as $route) {
                try {
                    $url = route($route);
                    $routeResults[$route] = "✓ {$url}";
                } catch (\Exception $e) {
                    $routeResults[$route] = "✗ Error: " . $e->getMessage();
                }
            }
            $results['routes'] = $routeResults;
        } catch (\Exception $e) {
            $results['routes'] = '✗ Error: ' . $e->getMessage();
        }
        
        // Test 4: Views
        $views = [
            'admin.driver.distance-tiers.index',
            'admin.driver.pricing-rules.index',
            'admin.driver.pricing-tiers.index'
        ];
        
        $viewResults = [];
        foreach ($views as $view) {
            try {
                if (view()->exists($view)) {
                    $viewResults[$view] = '✓ Exists';
                } else {
                    $viewResults[$view] = '✗ Missing';
                }
            } catch (\Exception $e) {
                $viewResults[$view] = '✗ Error: ' . $e->getMessage();
            }
        }
        $results['views'] = $viewResults;
        
        return response()->json($results, 200, [], JSON_PRETTY_PRINT);
    }
    
    /**
     * Test distance tiers page
     */
    public function testDistanceTiers()
    {
        try {
            $distanceTiers = DriverDistanceTier::orderBy('sort_order')->get();
            
            return view('admin.driver.distance-tiers.index', [
                'distanceTiers' => $distanceTiers,
                'filters' => [],
                'options' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
    
    /**
     * Test pricing rules page
     */
    public function testPricingRules()
    {
        try {
            $pricingRules = DriverPricingRule::with('pricingDistances.distanceTier')
                ->orderBy('sort_order')
                ->get();
            
            $distanceTiers = DriverDistanceTier::active()->ordered()->get();
            
            return view('admin.driver.pricing-rules.index', [
                'pricingRules' => $pricingRules,
                'distanceTiers' => $distanceTiers,
                'filters' => [],
                'options' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
    
    /**
     * Test pricing tiers page
     */
    public function testPricingTiers()
    {
        try {
            $pricingTiers = DriverPricingTier::orderBy('created_at', 'desc')->get();
            
            return view('admin.driver.pricing-tiers.index', [
                'pricingTiers' => $pricingTiers,
                'filters' => [],
                'options' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
