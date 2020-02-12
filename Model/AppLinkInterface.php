<?php


namespace App\Model;


interface AppLinkInterface
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

    /**
     * @return mixed
     */
    public function getPrivacyTag();

    /**
     * @param mixed $privacyTag
     */
    public function setPrivacyTag($privacyTag): void;
}