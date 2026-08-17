<?php

namespace TomTroc\Controller;

use TomTroc\Core\Framework\AbstractController;
use TomTroc\Core\Http\Response;
use TomTroc\View\HomeView;

class HomeController extends AbstractController{
    public function index(): Response
    {
        return $this->view(HomeView::class);
    }
}