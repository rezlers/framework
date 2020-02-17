<?php


namespace App\Model\Implementations;


use App\Model\UserInterface;
use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\Implementations\MyDatabase;
use Kernel\Container\Services\LoggerInterface;
use Kernel\Exceptions\ModelException;

class User implements UserInterface
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $login;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $firstName;
    /**
     * @var string
     */
    private $lastName;
    /**
     * @var MyDatabase
     */
    private $connection;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct($firstName, $lastName, $login, $email, $password)
    {
        $this->password = $password;
        $this->email = $email;
        $this->login = $login;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->id = null;
        $this->configureThings();
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return void
     * @throws ModelException
     */
    public function save(): void
    {
        if (is_null($this->id)) {
            $userDataToInsert = [$this->firstName, $this->lastName, $this->login, $this->email, $this->password];
            $result = $this->connection->statement('INSERT INTO users (first_name, last_name, login, email, password, confirmation) VALUES (?,?,?,?,?,1)',
                $userDataToInsert);
            if ($result === false) {
                throw new ModelException('User: Error with executing INSERT INTO users (first_name, last_name, login, email, password, confirmation) VALUES (?,?,?,?,?,1), params: ' . implode('|', $userDataToInsert));
            }
        }
        $userDataToUpdate = [$this->firstName, $this->lastName, $this->login, $this->email, $this->password, $this->id];
        $result = $this->connection->statement('UPDATE users SET first_name = ?, last_name = ?, login = ?, email = ?, password = ? WHERE id = ?',
            $userDataToUpdate);
        if ($result === false) {
            throw new ModelException('User: Error with executing UPDATE users SET first_name = ?, last_name = ?, login = ?, email = ?, password = ? WHERE id = ?, params: ' . implode('|', $userDataToUpdate));
        }
    }

    /**
     * @return self[]|bool
     * @throws ModelException
     */
    public static function all(): array
    {
        $container = new ServiceContainer();
        /** @var MyDatabase $connection */
        $connection = $container->getService('Database')->connection();
        $result = $connection->statement('SELECT * FROM users')->fetchAll();
        if ($result === false) {
            throw new ModelException('User: Error when executing SELECT * FROM users');
        }
        return self::configureUsersArray($result);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return array
     * @throws ModelException
     */
    public static function getByData(string $key, $value): array
    {
        $container = new ServiceContainer();
        /** @var MyDatabase $connection */
        $connection = $container->getService('Database')->connection();
        $result = $connection->statement('SELECT * FROM users WHERE ' . $key . ' = ?', [$value])->fetchAll();
        if ($result === false) {
            throw new ModelException('User: SELECT * FROM users WHERE ' . $key . ' = ?, params: ' . $value);
        }
        return self::configureUsersArray($result);
    }

    private static function configureUsersArray($result)
    {
        $users = [];
        foreach ($result as $userData) {
            $user = new User($userData['first_name'], $userData['last_name'], $userData['login'], $userData['email'], $userData['password']);
            $user->setId($userData['id']);
            $users[] = $user;
        }
        return $users;
    }

    private function configureThings()
    {
        $container = new ServiceContainer();
        $this->connection = $container->getService('Database')->connection();
        $this->logger = $container->getService('Logger');
    }
}