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
        $books = $this->bookRepository->findBySearch($search);
        return $this->view(BookListView::class, ['books' => $books]);
    }

    public function show(Request $request) {
        $id = $request->get('id', null);
        $book = $this->bookRepository->find($id);
        return $this->view(BookInfoView::class, ['book' => $book, 'owner' => $book->owner]);
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
			$owner = $this->userRepository->find((int) $_SESSION['logged_user_id']);

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
					$owner,
					null
				);

				$book = $this->bookRepository->upsert($book);

                return $this->redirect('/livres');
            }
        }

        return $this->view(BookFormView::class, ['book' => $book, 'errors' => $errors]);
    }

    public function illustration(Request $request) {
        $this->checkIfUserIsConnected();

        $id = $request->get('id', null);
        $book = $this->bookRepository->find((int) $id);

        if ($book === null) {
            return $this->redirect('/mon-compte?error=book_not_found');
        }

        if ($book->owner->id !== (int) $_SESSION['logged_user_id']) {
            return $this->redirect('/mon-compte?error=forbidden');
        }

        $file = $request->file('illustration_file');

        if (!is_array($file) || !isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return $this->redirect('/mes-livres/' . $book->id . '/modifier?error=illustration_invalide');
        }

        $mime = mime_content_type($file['tmp_name']);
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

        if (!in_array($mime, $allowedMimeTypes, true)) {
            return $this->redirect('/mes-livres/' . $book->id . '/modifier?error=illustration_format');
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            return $this->redirect('/mes-livres/' . $book->id . '/modifier?error=illustration_taille');
        }

        $extensionMap = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
        ];

        $extension = $extensionMap[$mime];
        $safeTitle = preg_replace('/[^A-Za-z0-9_-]+/', '_', $book->title);
        $safeTitle = trim($safeTitle, '_');

        if ($safeTitle === '') {
            $safeTitle = 'book';
        }

        $uploadDirectory = dirname(__DIR__, 2) . '/public/upload/book';

        if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0777, true) && !is_dir($uploadDirectory)) {
            return $this->redirect('/mes-livres/' . $book->id . '/modifier?error=illustration_upload');
        }

        $filename = sprintf('%d_%s_%s.%s', $book->id, $safeTitle, uniqid('', true), $extension);
        $destination = $uploadDirectory . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return $this->redirect('/mes-livres/' . $book->id . '/modifier?error=illustration_upload');
        }

        $this->bookRepository->update($book->updateIllustration('/upload/book/' . $filename));

        return $this->redirect('/mes-livres/' . $book->id . '/modifier');
    }

    public function delete(Request $request) {
        $id = $request->get('id', null);

        $book = $this->bookRepository->find($id ?? 0);

        if(!$book) {
            return $this->redirect('/mon-compte');
        }

        $this->checkIfUserIsConnected($book->owner->id);

        $this->bookRepository->delete($id);

        return $this->redirect('/mon-compte');
    }
}