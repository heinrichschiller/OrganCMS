<?php

declare(strict_types=1);

namespace App\Domain\Post\Service;

use App\Domain\Post\Post;
use App\Domain\Post\Repository\PostCreatorRepository;
use Cake\Validation\Validator;

final class PostCreator
{
    private PostCreatorRepository $repository;
    private Validator $validator;

    public function __construct(PostCreatorRepository $repository, Validator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $formData)
    {
        $this->validate($formData);

        $title = (string) $formData['title'];
        $slug = (string) $this->slug($title);
        $content = (string) $formData['content'];
        $author = (string) $formData['author'];
        $onMainpage = (bool) $formData['on_mainpage'];
        $publish = (bool) $formData['publish'];
        $createdAt = (string) date('Y-m-d H:i:s');

        $post = new Post(
            0,                           // i don't use this id
            $title,
            $slug,
            $content,
            $author,
            $onMainpage,
            '',                        // published date
            $publish,
            $createdAt,
            ''                        // updated at
        );

        $this->repository->create($post);
    }

    private function slug(string $text): string
    {
        $text = str_replace(['\'', '"'], "", $text);
        $text = str_replace(' ', '-', $text);

        return $text;
    }

    private function validate(array $formData)
    {
        $this->validator
            ->requirePresence('title')
            ->notEmptyString('title', 'Der Titel darf nicht leer sein.');
        
        $errors = $this->validator->validate($formData);

        if ($errors) {
            foreach ($errors as $error) {
                dd($error);
            }
        }
    }
}
