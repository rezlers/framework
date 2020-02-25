<?php


namespace App\Model\Implementations;


use App\Model\LinkInterface;
use App\Model\UserInterface;
use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\Implementations\MyDatabase;
use Kernel\Container\Services\PagerInterface;
use Kernel\Exceptions\ModelException;
use Kernel\Container\Services\Implementations\MyPager as Pager;

class Link implements LinkInterface
{
    /**
     * @var int
     */
    private $id;
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
    public function __construct(string $link, string $header, string $description, string $privacyTag, int $userId)
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

    public function getId(): int
    {
        return $this->id;
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

    public function setId(int $id): void
    {
        if ($this->id == -1)
            $this->id = $id;
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
        if (!in_array($privacyTag, ['private', 'public']))
            throw new ModelException("Not valid link's tag $privacyTag");
        $this->privacyTag = $privacyTag;
    }

    /**
     * @throws ModelException
     */
    public function save(): void
    {
        if ($this->id == -1) {
            $container = new ServiceContainer();
            /** @var MyDatabase $connection */
            $connection = $container->getService('Database')->connection();
            $linkDataToInsert = [$this->link, $this->header, $this->description, $this->privacyTag, $this->userId];
            $result = $connection->statement('INSERT INTO links (link, header, description, tag, user_id) VALUES (?,?,?,?,?)',
                $linkDataToInsert);
            if ($result === false) {
                throw new ModelException('User: Error with executing INSERT INTO users (first_name, last_name, login, email, password, confirmation) VALUES (?,?,?,?,?,1), params: ' . implode('|', $linkDataToInsert));
            }
        } elseif ($this->id > 0) {
            $container = new ServiceContainer();
            /** @var MyDatabase $connection */
            $connection = $container->getService('Database')->connection();
            $linkDataToInsert = [$this->link, $this->header, $this->description, $this->privacyTag, $this->userId, $this->id];
            $result = $connection->statement('UPDATE links SET link = ?, header = ?, description = ?, tag = ?, user_id = ? WHERE id = ?',
                $linkDataToInsert);
            if ($result === false) {
                throw new ModelException('User: Error with executing INSERT INTO users (first_name, last_name, login, email, password, confirmation) VALUES (?,?,?,?,?,1), params: ' . implode('|', $linkDataToInsert));
            }
        } else
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
        $result = $connection->statement('SELECT * FROM links WHERE user_id = ?', [$user->getId()]);
        if ($result === false) {
            throw new ModelException('User: Error while executing SELECT * FROM links');
        }
        $result = $result->fetchAll();
        return self::configureLinksArray($result);
    }

    /**
     * @param int $id
     * @return LinkInterface
     * @throws ModelException
     */
    public static function byId(int $id)
    {
        $container = new ServiceContainer();
        /** @var MyDatabase $connection */
        $connection = $container->getService('Database')->connection();
        $result = $connection->statement('SELECT * FROM links WHERE id = ?', [$id]);
        if ($result === false) {
            throw new ModelException('User: Error while executing SELECT * FROM links WHERE id = ?');
        }
        return self::linkInstance($result);
    }

    /**
     * @param string $link
     * @return Link|string
     * @throws ModelException
     */
    public static function byLink(string $link)
    {
        $container = new ServiceContainer();
        /** @var MyDatabase $connection */
        $connection = $container->getService('Database')->connection();
        $result = $connection->statement('SELECT * FROM links WHERE link = ?', [$link]);
        if ($result === false) {
            throw new ModelException('User: Error while executing SELECT * FROM links WHERE link = ?');
        }
        return self::linkInstance($result);
    }

    /**
     * @param int $page
     * @param int $userId
     * @return array
     * @throws ModelException
     */
    public static function byPage(int $page, int $userId = -1): array
    {
        $container = new ServiceContainer();
        /** @var MyDatabase $connection */
        $connection = $container->getService('Database')->connection();
        $limit = Pager::getNumberOfBlocks();
        $offset = ($page - 1) * $limit;
        if ($userId != -1)
            $result = $connection->statement('SELECT * FROM links WHERE user_id = ? LIMIT :limit OFFSET :offset', [$userId, ':limit' => $limit, ':offset' => $offset]);
        $result = $connection->statement('SELECT * FROM links LIMIT :limit OFFSET :offset', [':limit' => $limit, ':offset' => $offset]);
        if ($result === false) {
            throw new ModelException('Can not execute byPage static method of class Link, check logs');
        }
        return $result->fetchAll();
    }

    /**
     * @param \PDOStatement $result
     * @return Link|null
     * @throws ModelException
     */
    private static function linkInstance (\PDOStatement $result)
    {
        $result = $result->fetchAll();
        if ($result[0]) {
            $linkData = $result[0];
            $link = new Link($linkData['link'], $linkData['header'], $linkData['description'], $linkData['tag'], $linkData['user_id']);
            $link->setId($linkData['id']);
            return $link;
        } else {
            return null;
        }
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
            $link = new Link($linkData['link'], $linkData['header'], $linkData['description'], $linkData['tag'], $linkData['user_id']);
            $link->setId($linkData['id']);
            $links[] = $link;
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
    private function configureInstance(string $link, string $header, string $description, string $privacyTag, int $userId)
    {
        $this->setLink($link);
        $this->setHeader($header);
        $this->setDescription($description);
        $this->setPrivacyTag($privacyTag);
        $this->setUserId($userId);
        $this->id = -1;
    }
}