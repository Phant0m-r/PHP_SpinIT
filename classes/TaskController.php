<?php

class TaskController
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    private function validate(array $parameters = null): ?array
    {
        $errors = null;

        if (!$parameters) {
            return $errors;
        }


        foreach ($parameters as $key => $value) {
            if ($key != "id" && $value == "") {
                $errors[$key] = "Должно быть заполнено";
            }
        }
        return $errors;
    }

    public function create()
    {
        $request = $this->request;

        $errors = $this->validate($request->parameters);

        if ($errors) {
            $message = "Не все поля заполнены";

            return [
                "message" => $message,
                "errors" => $errors
            ];
        }

        (new Task($request->parameters))->create();

        $message = "Данные формы сохранены";

        return [
            "message => $message",
            "errors" => $errors
        ];
    }

    public function delete(): string
    {
        $id = $this->request->id;

        $task = new Task();
        $task->id = $id;

        $task->delete();

        return "Запись удалена";
    }

    public function show(): Task
    {
        $id = $this->request->id;

        $task = (new Task(["id" => $id]))->find();

        return $task;
    }

    public function update(): array
    {
        $request = $this->request;
        $id = $this->request->id;

        $errors = $this->validate($request->parameters);

        if ($errors) {
            $message = "Не все поля заполнены";

            return [
                "message" => $message,
                "errors" => $errors
            ];
        }

        try {
            (new Task(["id" => $id]))->update($request->parameters);
        } catch (NotFoundIDException $e) {
            return [
                "message" => $e->getMessage(),
                "errors" => null
            ];
        } catch (Exception $e) {
            return [
                "message" => "Произошла ошибка",
                "errors" => null
            ];
        }

        $message = "Данные обновлены";

        return [
            "message" => $message,
            "errors" => $errors
        ];
    }

    public function index(): ?array
    {
        $request = $this->request;
        return (new Task())->get(
            $request->parameters
        );
    }
}