<?php


namespace App\Model;


interface LinkInterface
{
    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return string
     */
    public function getHeader(): string;

    /**
     * @return string
     */
    public function getLink(): string;

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface;

    /**
     * @param string $description
     */
    public function setDescription(string $description): void;

    /**
     * @param string $header
     */
    public function setHeader(string $header): void;

    /**
     * @param string $link
     */
    public function setLink(string $link): void;

    public function setUser(): void;

    /**
     * @return mixed
     */
    public function getPrivacyTag();

    /**
     * @param mixed $privacyTag
     */
    public function setPrivacyTag($privacyTag): void;

    /**
     * @return void
     */
    public function save() : void;

    /**
     * @return self[]
     */
    public static function all() : array;
}