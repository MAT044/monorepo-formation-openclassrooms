<?php

namespace TomTroc\Controller;

use TomTroc\Core\Framework\AbstractController;
use TomTroc\Core\Http\Response;
use TomTroc\Model\Repository\BookRepository;
use TomTroc\View\HomeView;

class HomeController extends AbstractController{
    public function __construct(
        private readonly BookRepository $bookRepository
    ){}
    public function index(): Response
    {
        $books = $this->bookRepository->findLastest(4);
        return $this->view(HomeView::class, ['books' => $books]);
    }
}