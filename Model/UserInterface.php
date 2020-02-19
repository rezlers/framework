<?php


namespace App\Model;


interface UserInterface
{
    public function getEmail(): string;

    /**
     * @return string
     */
    public function getFirstName(): string;

    /**
     * @return string
     */
    public function getLastName(): string;

    /**
     * @return string
     */
    public function getLogin(): string;

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @param string $email
     */
    public function setEmail(string $email): void;

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void;

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void;

    /**
     * @param string $login
     */
    public function setLogin(string $login): void;

    /**
     * @param string $password
     */
    public function setPassword(string $password): void;

    /**
     * @return void
     */
    public function save() : void;

    /**
     * @return self[]
     */
    public static function all() : array;

    /**
     * @param string $key
     * @param mixed $value
     * @return self[]
     */
    public static function getByData(string $key, $value) : array;

    /**
     * @param int $value
     * @return self
     */
    public static function getById(int $value) : self;
}