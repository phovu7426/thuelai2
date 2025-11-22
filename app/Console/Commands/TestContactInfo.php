<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContactInfo;
use App\Services\Admin\ContactInfoService;
use App\Helpers\ContactInfoHelper;

class TestContactInfo extends Command
{
    protected $signature = 'test:contact-info';
    protected $description = 'Test ContactInfo system';

    public function handle()
    {
        $this->info('=== Testing ContactInfo System ===');

        try {
            // Test Model
            $this->info('1. Testing Model...');
            $contact = ContactInfo::first();
            if ($contact) {
                $this->info("   Found contact ID: {$contact->id}");
                $this->info("   Address: " . ($contact->address ?: 'Empty'));
                $this->info("   Phone: " . ($contact->phone ?: 'Empty'));
                $this->info("   Email: " . ($contact->email ?: 'Empty'));
            } else {
                $this->warn('   No contact found in database');
            }

            // Test Service
            $this->info('2. Testing Service...');
            $service = app(ContactInfoService::class);
            $serviceContact = $service->getFirstOrCreate();
            $this->info("   Service contact ID: {$serviceContact->id}");

            // Test Helper
            $this->info('3. Testing Helper...');
            $contactInfo = ContactInfoHelper::getContactInfoArray();
            $this->info('   Helper contact info: ' . json_encode($contactInfo, JSON_UNESCAPED_UNICODE));

            $hasContact = ContactInfoHelper::hasContactInfo();
            $this->info('   Has contact: ' . ($hasContact ? 'Yes' : 'No'));

            $phone = ContactInfoHelper::get('phone');
            $this->info('   Helper phone: ' . ($phone ?: 'Empty'));

            // Test updateContactInfo method
            $this->info('4. Testing updateContactInfo method...');
            $updateResult = $service->updateContactInfo([
                'address' => 'Test Address Updated - ' . now()->format('H:i:s'),
                'phone' => '1900 TEST',
                'email' => 'test@example.com'
            ]);
            $this->info('   Update result: ' . json_encode($updateResult, JSON_UNESCAPED_UNICODE));

            $this->info('=== All tests completed successfully! ===');
        } catch (\Exception $e) {
            $this->error('ERROR: ' . $e->getMessage());
            $this->error('File: ' . $e->getFile() . ':' . $e->getLine());
        }
    }
}
