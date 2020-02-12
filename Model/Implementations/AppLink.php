<?php


namespace App\Model\Implementations;


use App\Model\AppLinkInterface;

class AppLink implements AppLinkInterface
{
    /**
     * @var string
     */
    private $link;
    /**
     * @var string
     */
    private $header;
    /**
     * @var string
     */
    private $description;

    private $privacyTag;

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string $header
     */
    public function setHeader(string $header): void
    {
        $this->header = $header;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getPrivacyTag()
    {
        return $this->privacyTag;
    }

    /**
     * @param mixed $privacyTag
     */
    public function setPrivacyTag($privacyTag): void
    {
        $this->privacyTag = $privacyTag;
    }
}