<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function notify(string $message, string $type = 'success'): void
    {
        session()->flash('notify', ['message' => $message, 'type' => $type]);
    }
}
