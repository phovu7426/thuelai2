<?php

namespace App\Providers;

use App\Helpers\ContactInfoHelper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ContactInfoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Chia sẻ thông tin liên hệ cho tất cả các view
        View::composer('*', function ($view) {
            // Thông tin liên hệ cơ bản
            $contactInfo = ContactInfoHelper::getContactInfoArray();
            $view->with('globalContactInfo', $contactInfo);

            // Social media links
            $socialLinks = ContactInfoHelper::getSocialLinks();
            $view->with('globalSocialLinks', $socialLinks);

            // Các biến tiện ích
            $view->with('contactPhone', ContactInfoHelper::get('phone'));
            $view->with('contactEmail', ContactInfoHelper::get('email'));
            $view->with('contactAddress', ContactInfoHelper::get('address'));
            $view->with('contactWorkingTime', ContactInfoHelper::get('working_time'));
            $view->with('contactMapEmbed', ContactInfoHelper::get('map_embed'));
        });
    }
}
