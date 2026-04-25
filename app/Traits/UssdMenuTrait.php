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

    // Menu for NEW users
    public function newUserMenu()
    {
        $start  = __("Karibu SampleUSSD!\n");
        $start .= __("1. Sajili\n");
        $start .= __("2. Taarifa\n");
        $start .= __("3. Toka");

        return $this->cont($start);
    }

    // Menu for RETURNING users
    public function returnUserMenu()
    {
        $con  = __("Karibu tena SampleUSSD!\n");
        $con .= __("1. Ingia\n");
        $con .= __("2. Toka");

        return $this->cont($con);
    }

    // Main services menu
    public function servicesMenu()
    {
        $serve  = __("Unatafuta huduma gani?\n");
        $serve .= __("1. Jisajili kupokea taarifa\n");
        $serve .= __("2. Pata taarifa\n");
        $serve .= __("3. Tuma maoni\n");
        $serve .= __("4. Toka");

        return $this->cont($serve);
    }
}
