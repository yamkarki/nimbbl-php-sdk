<?php

declare(strict_types=1);

// require_once __DIR__ . '/../vendor/autoload.php';

use Nimbbl\Api\NimbblApi;
use PHPUnit\Framework\TestCase;
use Nimbbl\Api\NimbblToken;

final class TokenTest extends TestCase
{
    public function testGenerateToken(): void
    {

        $api = new NimbblApi('access_key_1MwvMkKkweorz0ry', 'access_secret_81x7ByYkRpB4g05N');
        $token = $api->token->generateToken();
        $this->assertEmpty($token->error);
    }

}
