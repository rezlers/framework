<?php


namespace App\Model\Implementations;


use App\Model\LinkInterface;
use App\Model\UserInterface;
use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\Implementations\MyDatabase;
use Kernel\Exceptions\ModelException;

class Link implements LinkInterface
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

    /**
     * @var string
     */
    private $privacyTag;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * Link constructor.
     * @param string $link
     * @param string $header
     * @param string $description
     * @param string $privacyTag
     * @param int $userId
     * @throws ModelException
     */
    public function __construct(string $link, string $header, string $description, string $privacyTag, int $userId = -1)
    {
        $this->configureInstance($link, $header, $description, $privacyTag, $userId);
    }

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
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
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
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @throws ModelException
     */
    public function setUser(): void
    {
        $this->user = User::getById($this->userId);
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
     * @throws ModelException
     */
    public function setPrivacyTag($privacyTag): void
    {
        if (!in_array($privacyTag, ['privacy', 'public']))
            throw new ModelException("Not valid link's tag $privacyTag");
        $this->privacyTag = $privacyTag;
    }

    /**
     * @throws ModelException
     */
    public function save(): void
    {
        if ($this->userId != -1) {
            $container = new ServiceContainer();
            /** @var MyDatabase $connection */
            $connection = $container->getService('Database')->connection();
            $linkDataToInsert = [$this->link, $this->header, $this->description, $this->privacyTag, $this->userId];
            $result = $connection->statement('INSERT INTO links (link, header, description, tag, user_id) VALUES (?,?,?,?,?)',
                $linkDataToInsert);
            if ($result === false) {
                throw new ModelException('User: Error with executing INSERT INTO users (first_name, last_name, login, email, password, confirmation) VALUES (?,?,?,?,?,1), params: ' . implode('|', $linkDataToInsert));
            }
        }
        else
            throw new ModelException("Can't insert link into 'links' table because userId is not set");
    }

    /**
     * @return self[]
     * @throws ModelException
     */
    public static function all(): array
    {
        $container = new ServiceContainer();
        /** @var MyDatabase $connection */
        $connection = $container->getService('Database')->connection();
        $result = $connection->statement('SELECT * FROM links')->fetchAll();
        if ($result === false) {
            throw new ModelException('User: Error while executing SELECT * FROM links');
        }
        return self::configureLinksArray($result);
    }

    /**
     * @param UserInterface $user
     * @return self[]
     * @throws ModelException
     */
    public static function byUser(UserInterface $user): array
    {
        $container = new ServiceContainer();
        /** @var MyDatabase $connection */
        $connection = $container->getService('Database')->connection();
        $result = $connection->statement('SELECT * FROM links WHERE user_id = ?', [$user->getId()])->fetchAll();
        if ($result === false) {
            throw new ModelException('User: Error while executing SELECT * FROM links');
        }
        return self::configureLinksArray($result);
    }

    /**
     * @param $result
     * @return array
     * @throws ModelException
     */
    private static function configureLinksArray($result)
    {
        $links = [];
        foreach ($result as $linkData) {
            $link = new Link($linkData['link'], $linkData['header'], $linkData['description'], $linkData['tag'], $linkData['userId']);
        }
        return $links;
    }

    /**
     * @param string $link
     * @param string $header
     * @param string $description
     * @param string $privacyTag
     * @param int $userId
     * @throws ModelException
     */
    private function configureInstance(string $link, string $header,string $description,string $privacyTag, int $userId)
    {
        $this->setLink($link);
        $this->setHeader($header);
        $this->setDescription($description);
        $this->setPrivacyTag($privacyTag);
        $this->setUserId($userId);
    }
}