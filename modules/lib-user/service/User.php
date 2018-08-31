<?php
/**
 * User
 * @package lib-user
 * @version 0.0.1
 */

namespace LibUser\Service;

class User extends \Mim\Service
{

    private $authorizer;
    private $handler;
    private $_user;

    public function __construct(){
        // find the handler
        $config = \Mim::$app->config->libUser;
        $handler = $config->handler;
        if(!$handler)
            trigger_error('No user handler registered');
        $this->handler = $handler;

        $authorizers = $config->authorizers;
        if(!$authorizers)
            trigger_error('No user authorizer registered');
        
        foreach($authorizers as $name => $class){
            $identity = $class::identify();
            if(!$identity)
                continue;
            $this->authorizer = $class;
            $user = $this->handler::getById($identity);
            if($user)
                $this->_user = $user;
            break;
        }

        return true;
    }

    public function __get($name) {
        if(!$this->_user)
            return null;
        return $this->_user->$name ?? null;
    }

    public function getByCredentials(string $identity, string $password): ?object {
        if($this->handler)
            return $this->handler::getByCredentials($identity, $password);
        return null;
    }

    public function getById(string $identity): ?object {
        if($this->handler)
            return $this->handler::getById($identity);
        return null;
    }

    public function hashPassword(string $password): ?string {
        if($this->handler)
            return $this->handler::hashPassword($password);
        return null;
    }

    public function isLogin(): bool{
        return !!$this->_user;
    }

    public function logout(): void{
        if($this->authorizer)
            $this->authorizer::logout();
    }

    public function setAuthorizer(string $name){
        $authorizers = \Mim::$app->config->libUser->authorizers;
        if(!isset($authorizers->$name))
            trigger_error('Authorizer with name `' . $name . '` not found');
        $this->authorizer = $authorizers->$name;
    }

    public function setUser(object $user): void{
        $this->user = $user;
    }

    public function verifyPassword(string $password, object $user): bool{
        if($this->handler)
            return $this->handler::verifyPassword($password, $user);
        return false;
    }
}