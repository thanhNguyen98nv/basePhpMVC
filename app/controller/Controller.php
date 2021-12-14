<?php

namespace App\Controller;

class Controller
{
    public function getCurrentUser()
    {
        return $_SESSION[config('app.sections.current_user')];
    }
}