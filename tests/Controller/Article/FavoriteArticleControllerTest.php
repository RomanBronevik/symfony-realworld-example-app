<?php

declare(strict_types=1);

namespace App\Tests\Controller\Article;

use App\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * ArticlesFavoriteControllerTest.
 */
class FavoriteArticleControllerTest extends WebTestCase
{
    public function testAsAnonymous(): void
    {
        $client = $this->createAnonymousApiClient();
        $client->request('POST', '/api/articles/article-2/favorite');

        $response = $client->getResponse();
        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testAsAuthenticated(): void
    {
        $client = $this->createAuthenticatedApiClient();
        $client->request('POST', '/api/articles/article-2/favorite');

        $response = $client->getResponse();
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $data = \json_decode($response->getContent(), true);
        $this->assertArrayHasKey('article', $data);
    }
}
