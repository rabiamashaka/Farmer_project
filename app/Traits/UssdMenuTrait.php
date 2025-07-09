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
        $start  = "Welcome to SampleUSSD\n";
        $start .= "1. Register\n";
        $start .= "2. Get Information\n";
        $start .= "3. Exit";

        return $this->cont($start);
    }

    public function returnUserMenu()
    {
        $con  = "Welcome back to SampleUSSD\n";
        $con .= "1. Login\n";
        $con .= "2. Exit";

        return $this->cont($con);
    }

    public function servicesMenu()
    {
        $serve = "What service are you looking for?\n";
        $serve .= "1. Subscribe to updates\n";
        $serve .= "2. Information on the service\n";       
        $serve .= "3. Logout";

        return $this->cont($serve);
    }
}
