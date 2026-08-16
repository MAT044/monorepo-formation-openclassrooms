<?php

namespace TomTroc\Controller;

use TomTroc\Core\Http\Response;

class HomeController {
    public function index()
    {
        return new Response(200, 'Ok');
    }
}