<?php 
/**
 * Fetcher
 * @package lib-user
 * @version 0.0.2
 */

namespace LibUser\Library;

class Fetcher
{
    static function get($where): ?array{
        $handler = \Mim::$app->user->getHandler();
        if(!$handler)
            return null;
        return $handler::getMany($where);
    }

    static function getOne($where): ?object{
        $handler = \Mim::$app->user->getHandler();
        if(!$handler)
            return null;
        return $handler::getOne($where);
    }
}