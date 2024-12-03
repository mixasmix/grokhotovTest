<?php

namespace App\Command;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Repository\Book\BookRepositoryInterface;
use App\Service\AuthorService;
use App\Service\BookService;
use App\Service\CategoryService;
use Doctrine\Common\Collections\ArrayCollection;
use JsonException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'books:load-from-file',
    description: 'Добавляет книги из указанного источника в БД',
)]
class BooksLoadFromFileCommand extends Command
{
    public function __construct(
        private readonly AuthorService $authorService,
        private readonly CategoryService $categoryService,
        private readonly BookService $bookService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            'source',
            InputArgument::REQUIRED,
            'Ссылка на json файл'
        );
    }

    /**
     * @throws JsonException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $source = $input->getArgument('source');

        try {
            array_map(
                function (array $bookData): Book {
                    $authors =  new ArrayCollection(
                        array_map(
                            fn (string $authorName): Author => $this->authorService->create(name: $authorName),
                            $bookData['authors'],
                        ),
                    );

                    $categories = new ArrayCollection(
                        array_map(
                            fn (string $categoryName): Category => $this->categoryService->create(name: $categoryName),
                            $bookData['categories'],
                        ),
                    );

                    unset($bookData['categories']);
                    unset($bookData['authors']);

                    try {
                        $book = $this->bookService->createFromArray(bookData: $bookData);
                    } catch (\Exception $exception) {
                        dd($bookData, $exception->getMessage());
                    }

                    $book->setAuthors($authors);
                    $book->setCategories($categories);

                    return $book;
                },
                json_decode(
                    json: file_get_contents($source),
                    associative: true,
                    flags: JSON_THROW_ON_ERROR,
                ),
            );
        } catch (JsonException $exception) {
            $io->error('Ошибка разбора json');

            throw $exception;
        }

        $io->success('Добавление данных завершено');

        return Command::SUCCESS;
    }
}
