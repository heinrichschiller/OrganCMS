<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Domain\Post\Service\PostFinder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class ReadSinglePublicPostAction
{
    private PostFinder $finder;
    private ViewInterface $view;

    public function __construct(PostFinder $finder, ViewInterface $view)
    {
        $this->finder = $finder;
        $this->view = $view;
    }

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $id = (int) $args['id'];
        $post = $this->finder->whereId($id);

        $data = [
            'post' => $post
        ];

        $response = $this->view->render($response, 'post/single-public-post', $data);
        
        return $response;
    }
}
