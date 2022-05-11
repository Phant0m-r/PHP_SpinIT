<?php

class Request
{
    public string $request_type;
    public ?array $parameters;

    public function __construct() {
        $this->parameters = $this->process($_REQUEST);
        $this->request_type = $_SERVER["REQUEST_METHOD"];
    }

    public function __get(string $key)
    {
        return $this->parameters[$key] ?? null;
    }

    public function __set(string $key, $value)
    {
        $this->parameters[$key] = $value;
    }

    private function cleanInput(string $value)
    {
        if ($value == "all" /*|| $value == "none" */|| $value == "") {
            return null;
        }

        if (is_bool($value)) {
            return $value;
        }

        return $value;
    }

    public function process(array $request)
    {
        $parameters = null;

        foreach ($request as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $input => $item) {
                    $item = $this->cleanInput($item);

                    if ($item != null) {
                        $parameters[$key][$input] = $item;
                    }
                }
            } else {
                $value = $this->cleanInput($value);
                $parameters[$key] = $value;
            }
        }
        return $parameters;
    }
}