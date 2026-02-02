<?php

namespace Tests\Feature;

use App\Services\TodoListService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodoListServiceTest extends TestCase
{
    private TodoListService $todoListService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->todoListService = $this->app->make(TodoListService::class);
    }

    public function testTodoListService()
    {
        self::assertNotNull($this->todoListService);
    }
    
    public function testSaveTodoListService()
    {
        $this->todoListService->saveTodo("1", "andika");
        $todolist = Session::get("todolist");
        foreach($todolist as $value){
            self::assertEquals("1", $value["id"]);
            self::assertEquals("andika", $value["todo"]);
        }
    }

    public function testGetTodoListEmpty()
    {
        self::assertEquals([], $this->todoListService->getTodoList());
    }

    public function testGetTodoListNotEmpty()
    {
        $expected = [
            [
                "id" => "1",
                "todo" => "andika"
            ],
            [
                "id" => "2",
                "todo" => "eko"
            ]
        ];

        $this->todoListService->saveTodo("1", "andika");
        $this->todoListService->saveTodo("2", "eko");

        self::assertEquals($expected, $this->todoListService->getTodoList());
    }

    public function testRemoveTodo()
    {
        $this->todoListService->saveTodo("1", "andika");
        $this->todoListService->saveTodo("2", "eko");

        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));
        
        $this->todoListService->removeTodo("3");
        
        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));
        
        $this->todoListService->removeTodo("1");
        self::assertEquals(1, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo("2");
        self::assertEquals(0, sizeof($this->todoListService->getTodoList()));

    }
    

}
