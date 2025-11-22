<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DriverDistanceTier;
use App\Models\DriverPricingRule;
use App\Models\DriverPricingRuleDistance;

class PricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo các khoảng cách
        $distanceTiers = [
            [
                'name' => '5km đầu',
                'description' => 'Khoảng cách từ 0 đến 5km',
                'from_distance' => 0,
                'to_distance' => 5,
                'display_text' => '5km đầu',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => '6-10km',
                'description' => 'Khoảng cách từ 6 đến 10km',
                'from_distance' => 6,
                'to_distance' => 10,
                'display_text' => '6-10km',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => '>10km',
                'description' => 'Khoảng cách trên 10km',
                'from_distance' => 11,
                'to_distance' => 30,
                'display_text' => '>10km',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => '>30km',
                'description' => 'Khoảng cách trên 30km',
                'from_distance' => 31,
                'to_distance' => null,
                'display_text' => '>30km',
                'is_active' => true,
                'sort_order' => 4
            ]
        ];

        foreach ($distanceTiers as $tier) {
            DriverDistanceTier::updateOrCreate(
                ['name' => $tier['name']],
                $tier
            );
        }

        // Tạo các quy tắc giá theo thời gian
        $pricingRules = [
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

        foreach ($pricingRules as $rule) {
            $pricingRule = DriverPricingRule::updateOrCreate(
                ['time_slot' => $rule['time_slot']],
                $rule
            );

            // Tạo giá cho từng khoảng cách
            $prices = [];
            switch ($rule['time_slot']) {
                case 'Trước 22h':
                    $prices = [
                        '5km đầu' => ['price' => 245000, 'price_text' => null],
                        '6-10km' => ['price' => 20000, 'price_text' => null],
                        '>10km' => ['price' => 15000, 'price_text' => null],
                        '>30km' => ['price' => null, 'price_text' => 'Thỏa thuận']
                    ];
                    break;
                case '22h-24h':
                    $prices = [
                        '5km đầu' => ['price' => 260000, 'price_text' => null],
                        '6-10km' => ['price' => 25000, 'price_text' => null],
                        '>10km' => ['price' => 20000, 'price_text' => null],
                        '>30km' => ['price' => null, 'price_text' => 'Thỏa thuận']
                    ];
                    break;
                case 'Sau 24h':
                    $prices = [
                        '5km đầu' => ['price' => 299000, 'price_text' => null],
                        '6-10km' => ['price' => 20000, 'price_text' => null],
                        '>10km' => ['price' => 20000, 'price_text' => null],
                        '>30km' => ['price' => null, 'price_text' => 'Thỏa thuận']
                    ];
                    break;
            }

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

        $this->command->info('Pricing data seeded successfully!');
    }
}
