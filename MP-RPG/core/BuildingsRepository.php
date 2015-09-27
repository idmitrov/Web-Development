<?php

namespace Core;

class BuildingsRepository
{
    /**
     * @var Database
     */
    private $db;

    /**
     * @var User
     */
    private $user;

    public function __construct(Database $db, User $user) {
        $this->db = $db;
        $this->user = $user;
    }

    public function getUser() {
        return $this->user;
    }

    public function getBuildings() {
        $result = $this->db->prepare(
            'SELECT
                id,
                building_id,
                (level_id + 1) AS level,
                (
                  SELECT gold
                  FROM building_levels
                  WHERE level = user_buildings.level_id + 1 AND building_id = user_buildings.building_id
                 ) AS gold,
                 (
                  SELECT food
                  FROM  building_levels
                  WHERE level = user_buildings.level_id + 1 AND building_id = user_buildings.building_id
                 ) AS food,
                 (
                  SELECT name
                  FROM buildings
                  WHERE id = user_buildings.building_id
                 ) AS name
             FROM user_buildings
             WHERE user_id = ?'
        );

        $result->execute([$this->user->getId()]);

        return $result->fetchAll();
    }

    public function evolve($buildingId) {
        $result = $this->db->prepare(
             'SELECT
                id,
                building_id,
                (level_id + 1) as level,
                (SELECT gold FROM building_levels WHERE level = user_buildings.level_id + 1 AND building_id = user_buildings.building_id) as gold,
                (SELECT food FROM building_levels WHERE level = user_buildings.level_id + 1 AND building_id = user_buildings.building_id) as food,
                (SELECT name FROM buildings WHERE id = user_buildings.building_id) as name
              FROM user_buildings
              WHERE user_id = ? AND building_id = ?'
        );

        $result->execute([$this->getUser()->getId(), $buildingId]);
        $buildingData = $result->fetch();

        if ($this->getUser()->getGold() < $buildingData['gold']
            || $this->getUser()->getFood() < $buildingData['food']) {
            throw new \Exception('Insufficient resources');
        }

        if (!$buildingData['gold'] && !$buildingData['food']) {
            throw new \Exception('Max level reached');
        }

        $resourcesUpdate = $this->db->prepare('UPDATE users SET gold = ?, food = ? WHERE id = ?');
        $resourcesUpdate->execute([
            $this->getUser()->getGold() - $buildingData['gold'],
            $this->getUser()->getFood() - $buildingData['food'],
            $this->getUser()->getId()
        ]);

        var_dump($resourcesUpdate->rowCount());

        if ($resourcesUpdate->rowCount() > 0) {
            $levelUpgrade = $this->db->prepare(
                'UPDATE user_buildings
                 SET level_id = ?
                 WHERE user_id = ? AND building_id = ?'
            );

            $levelUpgrade->execute([
                $buildingData['level'],
                $this->getUser()->getId(),
                $buildingId
            ]);

            if ($levelUpgrade->rowCount() > 0) {
                return true;
            }

            throw new \Exception('Something went wrong');
        }

        throw new \Exception('Something went wrong TEST');
    }
}