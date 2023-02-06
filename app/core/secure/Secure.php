<?php

namespace app\core\secure;

/**
 * Class Secure
 */
class Secure
{
    /**
     * Generate password
     */
    public function generatePasswordHash($password, $algo = PASSWORD_DEFAULT, array $options = []): string
    {
        return password_hash($password, $algo);
    }

    /**
     * Validate password
     */
    public function validatePassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}