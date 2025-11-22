<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DriverDistanceTier;
use App\Models\DriverPricingRule;
use App\Models\DriverPricingRuleDistance;

class QuickPricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tạo Distance Tiers
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
            DriverDistanceTier::updateOrCreate(
                ['name' => $tierData['name']],
                $tierData
            );
        }

        // 2. Tạo Pricing Rules
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
            $pricingRule = DriverPricingRule::updateOrCreate(
                ['time_slot' => $ruleData['time_slot']],
                $ruleData
            );

            // 3. Tạo giá cho từng khoảng cách
            $prices = $this->getPricesForTimeSlot($ruleData['time_slot']);
            
            foreach ($prices as $tierName => $priceData) {
                $tier = DriverDistanceTier::where('name', $tierName)->first();
                if ($tier) {
                    DriverPricingRuleDistance::updateOrCreate(
                        [
                            'pricing_rule_id' => $pricingRule->id,
                            'distance_tier_id' => $tier->id
                        ],
                        $priceData
                    );
                }
            }
        }
    }

    /**
     * Lấy giá cho từng khung thời gian
     */
    private function getPricesForTimeSlot(string $timeSlot): array
    {
        switch ($timeSlot) {
            case 'Trước 22h':
                return [
                    '5km đầu' => ['price' => 245000.00, 'price_text' => null],
                    '6-10km' => ['price' => 20000.00, 'price_text' => null],
                    '>10km' => ['price' => 15000.00, 'price_text' => null],
                    '>30km' => ['price' => null, 'price_text' => 'Thỏa thuận']
                ];
            
            case '22h-24h':
                return [
                    '5km đầu' => ['price' => 260000.00, 'price_text' => null],
                    '6-10km' => ['price' => 25000.00, 'price_text' => null],
                    '>10km' => ['price' => 20000.00, 'price_text' => null],
                    '>30km' => ['price' => null, 'price_text' => 'Thỏa thuận']
                ];
            
            case 'Sau 24h':
                return [
                    '5km đầu' => ['price' => 299000.00, 'price_text' => null],
                    '6-10km' => ['price' => 20000.00, 'price_text' => null],
                    '>10km' => ['price' => 20000.00, 'price_text' => null],
                    '>30km' => ['price' => null, 'price_text' => 'Thỏa thuận']
                ];
            
            default:
                return [];
        }
    }
}
