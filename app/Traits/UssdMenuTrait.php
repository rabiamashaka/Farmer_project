<?php

namespace App\Traits;

use Illuminate\Support\Facades\Response;

trait UssdMenuTrait
{
    // Helper method to send a USSD CON response
    public function cont(string $text)
    {
        return Response::make("CON $text", 200, ['Content-Type' => 'text/plain']);
    }

    // Helper method to send a USSD END response
    public function end(string $text)
    {
        return Response::make("END $text", 200, ['Content-Type' => 'text/plain']);
    }

    public function newUserMenu()
    {
        $start  = __("Welcome to SampleUSSD\n");
        $start .= __("1. Register\n");
        $start .= __("2. Get Information\n");
        $start .= __("3. Exit");

        return $this->cont($start);
    }

    public function returnUserMenu()
    {
        $con  = __("Welcome back to SampleUSSD\n");
        $con .= __("1. Login\n");
        $con .= __("2. Exit");

        return $this->cont($con);
    }

    public function servicesMenu()
    {
        $serve = __("What service are you looking for?\n");
        $serve .= __("1. Subscribe to updates\n");
        $serve .= __("2. Information on the service\n");       
        $serve .= __("3. Logout");

        return $this->cont($serve);
    }
}
