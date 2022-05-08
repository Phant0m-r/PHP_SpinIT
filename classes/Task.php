<?php

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

    private function getConnection(): ?mysqli
    {
        return mysqli_connect(
            "localhost",
            "adil",
            "password",
            "todolist"
        );
    }

    private function getID(): int
    {
        $id = $this->attributes["id"] ?? null;

        if (!$id) {
            throw new Exception("Отсутствует ID задачи");
        }

        return $id;
    }

    public function create(): self
    {
        $attributes = $this->attributes;

        if (!$attributes) {
            throw new Exception("Нет данных задачи");
        }

        $sets = [];
        $placeholders = [];
        $bindings = [];
        $types = null;

        foreach ($attributes as $key => $value) {
            if ($key != "id") {
                $sets[] = $key;
                $placeholders[] = "?";

                switch (gettype($value)) {
                    case "string":
                        $types .= "s";
                        break;

                    case "boolean":
                        $types .="b";
                        break;

                    case "integer":
                        $types .= "i";
                        break;
                }

                $bindings[] = $value;
            }
        }

        $querySets = implode(", ", $sets);
        $queryBindings = implode(", ", $placeholders);

        $connection = $this->getConnection();

        $statement = mysqli_prepare(
            $connection,
            "INSERT INTO tasks ( $querySets ) VALUES ( $queryBindings )"
        );

        mysqli_stmt_bind_param($statement, $types, ...$bindings);

        mysqli_stmt_execute($statement);

        mysqli_close($connection);

        return $this;
    }

    public function update(array $attributes): self
    {
        $id = $this->getID();
        $this->attributes = $attributes;

        $bindings = [];
        $types = "";

        $query = "UPDATE tasks SET ";

        $sets = [];

        foreach ($attributes as $key => $value) {
            if ($key != "id") {
                $sets[] = "$key = ?";

                switch (gettype($value)) {
                    case "string":
                        $types .= "s";
                        break;

                    case "integer":
                        $types .= "i";
                        break;
                }

                $bindings[] = $value;
            }
        }
        $query .= implode(", ", $sets);

        $query .= " WHERE id = ?";

        $types .= "i";
        $bindings[] = $id;

        $connection = $this->getConnection();

        $statement = mysqli_prepare(
            $connection,
            $query
        );
        mysqli_stmt_bind_param($statement, $types, ...$bindings);

        mysqli_stmt_execute($statement);

        mysqli_close($connection);

        return $this;
    }

    public function delete(): bool
    {
        $id = $this->getID();

        $connection = $this->getConnection();


        $statement = mysqli_prepare(
            $connection,
            "DELETE FROM tasks WHERE id = ?"
        );

        mysqli_stmt_bind_param($statement, "i", $id);

        mysqli_stmt_execute($statement);

        mysqli_close($connection);

        return true;
    }

    public function find(): self
    {
        $id = $this->getID();

        $connection = $this->getConnection();

        $statement = mysqli_prepare(
            $connection,
            "SELECT * FROM tasks WHERE id = ?"
        );
        mysqli_stmt_bind_param($statement, "i", $id);

        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);

        $attributes = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_close($connection);

        $this->attributes = $attributes;

        return $this;
    }

    public function get(array $parameters = null): array
    {
        $bindings = null;
        $query = "SELECT * FROM tasks ";

        $types = "";

        if ($parameters) {
            foreach ($parameters as $group =>$fields) {
                switch ($group) {
                    case "filter":
                        if (count($fields) > 0) {
                            $query .= "WHERE ";

                            $clauses = [];

                            foreach ($fields as $key => $value) {
                                $clauses[] = "$key = ?";
                                $types .= "s";
                                $bindings[] = $value;
                            }

                            $query .= implode(" AND ", $clauses);
                        }
                        break;

                    case "sort":
                        foreach ($fields as $key => $value) {
                            switch ($key) {

                                case "column":
                                    if ($value == "none") {
                                        $query .= " ORDER BY id";
                                    } else {
                                        $query .= " ORDER BY $value";
                                    }
                                    break;

                                case "direction":
                                    $query .= " DESC";
                                    break;
                            }
                        }
                        break;
                }
            }
        }

        $connection = $this->getConnection();

        $statement = mysqli_prepare($connection, $query);

        if ($bindings) {
            mysqli_stmt_bind_param($statement, $types, ...$bindings);
        }

        mysqli_stmt_execute($statement);

        $rows = mysqli_stmt_get_result($statement);

       $tasks = [];

        while ($row = mysqli_fetch_array($rows, MYSQLI_ASSOC)) {
            $tasks[] = new Task($row);
        }

        mysqli_close($connection);

        return $tasks;
    }

    public function array(): ?array
    {
        return $this->attributes;
    }

}