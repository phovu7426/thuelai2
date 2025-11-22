<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactInfo;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ nếu có
        ContactInfo::truncate();

        // Tạo dữ liệu mẫu
        ContactInfo::create([
            'address' => 'Hà Nội, Việt Nam',
            'phone' => '1900 xxxx',
            'email' => 'info@thuelai.vn',
            'working_time' => '24/7',
            'facebook' => 'https://facebook.com/thuelai',
            'instagram' => 'https://instagram.com/thuelai',
            'youtube' => 'https://youtube.com/thuelai',
            'linkedin' => 'https://linkedin.com/company/thuelai',
            'map_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.096756120564!2d105.78468841533216!3d21.028801593312896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab9bd9861ca1%3A0xe7887f7b72ca17a9!2zSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1635123456789!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'
        ]);
    }
}
