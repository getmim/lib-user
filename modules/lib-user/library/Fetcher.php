<?php 
/**
 * Fetcher
 * @package lib-user
 * @version 0.0.2
 */

namespace LibUser\Library;

class Fetcher
{
    static function count(array $where=[]): ?int{
        $handler = \Mim::$app->user->getHandler();
        if(!$handler)
            return null;
        return $handler::count($where);
    }

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

    static function set(array $fields, array $where=[]): bool{
        $handler = \Mim::$app->user->getHandler();
        if(!$handler)
            return false;
        return $handler::set($fields, $where);
    }

    static function lastError(){
        $handler = \Mim::$app->user->getHandler();
        if(!$handler)
            return false;
        return $handler::lastError();
    }
}