<?php
/**
 * Handler
 * @package lib-user
 * @version 0.0.1
 */

namespace LibUser\Iface;

interface Handler
{

    static function getByCredentials(string $identity, string $password): ?object;

    static function getById(string $identity): ?object;

    static function hashPassword(string $password): ?string;

    static function verifyPassword(string $password, object $user): bool;
}