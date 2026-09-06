<?php

namespace TomTroc\View\Book;

use TomTroc\View\Layout;

class BookListView extends Layout {
    public function __construct() 
    {
        parent::__construct(title: 'Liste des livres', contentTemplate: 'book/list');
    }
}