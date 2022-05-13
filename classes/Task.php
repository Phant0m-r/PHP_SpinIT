<?php

require_once __DIR__ . "/../classes/NotFoundIDException.php";

class Task
{
    public ?array $attributes;

    public function __construct(array $attributes = null)
    {
        $this->attributes = $attributes;
    }

    public function __get(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set( string $key, $value)
    {
        $this->attributes[$key] = $value;
    }

    private function getConnection(): DatabasePDO
    {
        return new DatabasePDO(__DIR__ . "/../database.ini");
    }

    private function getID(): int
    {
        $id = $this->attributes["id"] ?? null;

        if (!$id) {
            throw new NotFoundIDException("Отсутствует ID задачи");
        }

        return $id;
    }

    public function create(): self
    {
        $attributes = $this->attributes;

        if (!$attributes) {
            throw new Exception("Нет данных задачи");
        }

        $bindings = [];

        foreach ($attributes as $key => $value) {
            $bindings[":$key"] = $value;
        }

        $querySets = implode(", ", array_keys($attributes));
        $queryBindings = implode(", ", array_keys($bindings));

        $connection = $this->getConnection();

        $statement = $connection->prepare("INSERT INTO tasks ($querySets) VALUES ($queryBindings)");

        $statement->execute($bindings);

        return $this;
    }

    public function update(array $attributes): self
    {
        $this->attributes = $attributes;

        $bindings = [];

        $query = "UPDATE tasks SET ";

        foreach ($attributes as $key => $value) {
            $sets[] = "$key = :$key";
            $bindings[":$key"] = $value;
        }
        $query .= implode(", ", $sets);

        $query .= " WHERE id = :id";

        $connection = $this->getConnection();

        $statement = $connection->prepare($query);

        $statement->execute($bindings);
        return $this;
    }

    public function delete(): bool
    {
        $connection = $this->getConnection();

        $statement = $connection->prepare("DELETE FROM tasks WHERE id = :id");

        $statement->execute([
            ":id" => $this->getID()
        ]);

        return true;
    }

    public function find(): self
    {
        $connection = $this->getConnection();

        $statement = $connection->prepare("SELECT * FROM tasks WHERE id = :id");

        $statement->execute([
            ":id" => $this->getID()
        ]);

        $attributes = $statement->fetch(PDO::FETCH_ASSOC);

        $this->attributes = $attributes;

        return $this;
    }

    public function get(array $parameters = null): array
    {
        $bindings = null;
        $query = "SELECT * FROM tasks ";

        $tasks = null;

        if ($parameters) {
            foreach ($parameters as $group =>$fields) {
                switch ($group) {
                    case "filter":
                        if (count($fields) > 0) {
                            $query .= "WHERE ";

                            $clauses = [];

                            foreach ($fields as $key => $value) {
                                $clauses[] = "$key = :$key";
                                $bindings[":$key"] = $value;
                            }

                            $query .= implode(" AND ", $clauses);
                        }
                        break;

                    case "sort":
                        if (count($fields) > 0) {
                            $query .= "ORDER BY ";

                            foreach ($fields as $value) {
                                $query .= "$value ";
                            }
                        }
                        break;
                }
            }
        }

        $connection = $this->getConnection();

        $statement = $connection->prepare($query);
        $statement->execute($bindings);

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $tasks[] = new Task($row);
        }

        return $tasks;
    }

    public function array(): ?array
    {
        return $this->attributes;
    }

}