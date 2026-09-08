<?php

namespace TomTroc\Controller;

use DateTimeImmutable;
use Exception;
use TomTroc\Core\Framework\AbstractController;
use TomTroc\Core\Http\Method;
use TomTroc\Core\Http\Request;
use TomTroc\Model\Entity\Book;
use TomTroc\Model\Repository\BookRepository;
use TomTroc\Model\Repository\UserRepository;
use TomTroc\View\Book\BookFormView;
use TomTroc\View\Book\BookInfoView;
use TomTroc\View\Book\BookListView;

class BookController extends AbstractController {

    public function __construct(
        private readonly BookRepository $bookRepository,
		private readonly UserRepository $userRepository
    )
    {
    }

    public function list(Request $request) {
        $search = $request->get('search', '');
        $books = $this->bookRepository->findBySearch($search, true);
        return $this->view(BookListView::class, ['books' => $books]);
    }

    public function show(Request $request) {
        $id = $request->get('id', null);
        $book = $this->bookRepository->find($id);
		$owner = $this->userRepository->find($book->ownerId);
        return $this->view(BookInfoView::class, ['book' => $book, 'owner' => $owner]);
    }

    public function form(Request $request) {
        $this->checkIfUserIsConnected();
        
        $id = $request->get('id', null);

        $book = isset($id) ? $this->bookRepository->find($id) : null;

		if($id !== null && $book === null) {
			throw new Exception('Not found');
		}

        $isSend = ($request->method === Method::POST);

        $errors = [];

        if($isSend) {
			$title = trim($request->get('title', null));
            $author = trim($request->get('author', null));
            $description = $request->get('description', null);
			$available = $request->get('available', null);
			$ownerId = $_SESSION['logged_user_id'];

            if(count($errors) === 0) {

				$book = $book?->update(
					$title,
					$author,
					$description,
					$available
				) ?? new Book(
					null,
					$title,
					$author,
					$description,
					$available,
					new DateTimeImmutable('now'),
					$ownerId,
					null
				);

				$book = $this->bookRepository->upsert($book);

                return $this->redirect('/livres');
            }
        }

        return $this->view(BookFormView::class, ['book' => $book, 'errors' => $errors]);
    }
}