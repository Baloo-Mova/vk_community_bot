<?php

namespace App\Listeners;

use App\Providers\VK\SocialiteProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class VkRegisterSocialite
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SocialiteWasCalled  $event
     * @return void
     */
    public function handle(SocialiteWasCalled $event)
    {
        $event->extendSocialite('vk', SocialiteProvider::class);
    }
}
