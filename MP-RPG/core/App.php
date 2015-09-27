<?php

namespace Core;

class App
{
    /**
     * @var Database
     */
    private $db;

    /**
     * @var User
     */
    private $user = null;

    /**
     * @var BuildingsRepository
     */
    private $buildingRepository;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    /**
     * @return bool
     */
    public function isLogged() {
        return isset($_SESSION['id']);
    }

    /**
     * @param $username
     * @return bool
     */
    public function userExist($username) {
        $result = $this->db->prepare("SELECT id FROM users WHERE username = ?");
        $result->execute([$username]);

        return $result->rowCount() > 0;
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     * @throws \Exception
     */
    public function register($username, $password) {
        if ($this->userExist($username)) {
            throw new \Exception('User already registered');
        }

        $result = $this->db->prepare(
            "INSERT INTO users(username, password, gold, food)
             VALUES(?, ?, ?, ?)"
        );

        $result->execute([
            $username,
            password_hash($password, PASSWORD_DEFAULT),
            USER::GOLD_DEFAULT,
            USER::FOOD_DEFAULT
        ]);

        if ($result->rowCount() > 0) {
            $userId = $this->db->lastId();

            $this->db->query(
                "INSERT INTO user_buildings(user_id, building_id, level_id),
                 SELECT $userId, id, 0 FROM buildings"
            );

            return true;
        }

        throw new \Exception('Cannot register user');
    }

    /**
     * @param $username
     * @param $password
     * @return User
     * @throws \Exception
     */
    public function login($username, $password) {

        $result = $this->db->prepare(
          "SELECT id, username, password, gold, food
           FROM users WHERE username=?"
        );
        $result->execute([$username]);

        if ($result->rowCount() === 0) {
            throw new \Exception('User does not exist');
        }

        $userRow = $result->fetch();

        if (password_verify($password, $userRow['password'])) {
            $_SESSION['id'] = $userRow['id'];

            $this->user = new User(
                $userRow['username'],
                $userRow['password'],
                $userRow['id'],
                $userRow['gold'],
                $userRow['food']
            );

            return $this->user;
        } else {
            throw new \Exception('Invalid password');
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserInfo($id) {
        $result = $this->db->prepare(
          'SELECT id, username, password, gold, food
           FROM users
           WHERE id=?'
        );

        $result->execute([$id]);

        return $result->fetch();
    }

    /**
     * @return User
     */
    public function getUser() {
            if ($this->user != null) {
            return $this->user;
        }

        if ($this->isLogged()) {
            $userRow = $this->getUserInfo($_SESSION['id']);
            $this->user = $user = new User(
                $userRow['username'],
                $userRow['password'],
                $userRow['id'],
                $userRow['gold'],
                $userRow['food']
            );

            return $user;
        }

        return null;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function editUser(User $user) {
        $result = $this->db->prepare(
          'UPDATE users SET password=?, username=? WHERE id=?'
        );

        $result->execute([
            $user->getPass(),
            $user->getUsername(),
            $user->getId()
        ]);

        return $result->rowCount() > 0;
    }

    /**
     * @return BuildingsRepository
     */
    public function createBuildings() {
        if ($this->buildingRepository == null) {
            $this->buildingRepository = new BuildingsRepository($this->db, $this->getUser());
        }

        return $this->buildingRepository;
    }

    public function  generateToken() {
        $_SESSION['token'] = md5(uniqid(mt_rand()));

        if (isset($_POST['token'])) {
            $_POST['token'] = $_SESSION['token'];
        }
    }

    public function verifyToken(){
        if ($_SESSION['token'] != $_POST['token']) {
            header('Location: login.php?error=csrf');
            exit;
        }
    }
}