<?php

namespace app\core\db;
use app\core\Application;
use app\core\Model;

abstract class DbModel extends Model
{

    abstract public static function tableName(): string;
    abstract public static function primaryKey(): string;
    abstract public function attributes(): array;


    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes) .") VALUES (".implode(',', $params).")");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        
        $statement->execute();

        return true;
    }

    public static function findOne($where) // [email => sarmashani933@gmail.com, firstname => shani]
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public function findAll()
    {
        $tableName = $this->tableName();

        $statement = self::prepare("SELECT * FROM $tableName");
        
        $statement->execute();

        return $statement->fetchAll();
    }

    public function delete($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("DELETE FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        // return $statement->fetchObject(static::class);
    }

    public function update($where)
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        // $attributes = ['title', 'name', 'age'];
        $params = array_map(fn($attr) => "$attr = :$attr", $attributes);

        $id = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $id));
        $statement = self::prepare("UPDATE $tableName SET " . implode(', ', $params) . " WHERE $sql");

        $statement->execute();
    }
}