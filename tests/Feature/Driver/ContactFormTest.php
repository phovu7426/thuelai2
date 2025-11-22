<?php

namespace Tests\Feature\Driver;

use App\Models\DriverContact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test contact form submission with valid data
     */
    public function test_contact_form_submission_with_valid_data()
    {
        $contactData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => '0123456789',
            'subject' => 'Test Subject',
            'message' => 'This is a test message with more than 10 characters.'
        ];

        $response = $this->postJson('/lien-he', $contactData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất.'
            ]);

        // Check if contact was saved to database
        $this->assertDatabaseHas('driver_contacts', [
            'name' => $contactData['name'],
            'email' => $contactData['email'],
            'phone' => $contactData['phone'],
            'subject' => $contactData['subject'],
            'message' => $contactData['message'],
            'status' => 'unread'
        ]);
    }

    /**
     * Test contact form submission without subject (should use default)
     */
    public function test_contact_form_submission_without_subject()
    {
        $contactData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => '0123456789',
            'message' => 'This is a test message with more than 10 characters.'
        ];

        $response = $this->postJson(route('driver.contact.submit'), $contactData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        // Check if contact was saved with default subject
        $this->assertDatabaseHas('driver_contacts', [
            'name' => $contactData['name'],
            'email' => $contactData['email'],
            'phone' => $contactData['phone'],
            'subject' => 'Liên hệ từ website',
            'message' => $contactData['message'],
            'status' => 'unread'
        ]);
    }

    /**
     * Test contact form validation errors
     */
    public function test_contact_form_validation_errors()
    {
        $response = $this->postJson(route('driver.contact.submit'), []);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ'
            ])
            ->assertJsonValidationErrors(['name', 'email', 'phone', 'message']);
    }

    /**
     * Test contact form with invalid email
     */
    public function test_contact_form_with_invalid_email()
    {
        $contactData = [
            'name' => $this->faker->name,
            'email' => 'invalid-email',
            'phone' => '0123456789',
            'message' => 'This is a test message with more than 10 characters.'
        ];

        $response = $this->postJson(route('driver.contact.submit'), $contactData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /**
     * Test contact form with short message
     */
    public function test_contact_form_with_short_message()
    {
        $contactData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => '0123456789',
            'message' => 'Short'
        ];

        $response = $this->postJson(route('driver.contact.submit'), $contactData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['message']);
    }

    /**
     * Test contact form with short phone number
     */
    public function test_contact_form_with_short_phone()
    {
        $contactData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => '123',
            'message' => 'This is a test message with more than 10 characters.'
        ];

        $response = $this->postJson(route('driver.contact.submit'), $contactData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
    }
}
