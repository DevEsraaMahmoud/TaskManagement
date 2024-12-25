<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\TaskResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\storeTaskRequest;
use App\Http\Requests\updateTaskRequest;

class TaskController extends Controller
{
    /**
     * Fetch all tasks
     *
     * @queryParam name string Filter tasks by name
     * @queryParam status string Filter tasks by status
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = QueryBuilder::for(Task::class)
        ->allowedFilters([
            'name',
            'status',
        ])
        ->paginate(10);

        return response()->json(TaskResource::collection($tasks));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\storeTaskRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(storeTaskRequest $request) {
        $task = Task::create($request->validated());
        return TaskResource::make($task)->additional([
            "message"=>__('Task created with success'),
            "status" => Response::HTTP_CREATED]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return TaskResource::make($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\updateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(updateTaskRequest $request, Task $task) {
        if ( $task->update($request->validated()) ){
            return TaskResource::make($task)->additional([
                "message"=>__('Task updated with success'),
                "status" => Response::HTTP_CREATED]);
        }
        return response()->json(["message"=>__('check again later'),"status"=>Response::HTTP_BAD_REQUEST]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task) {
        $task->delete();
        return response()->json(["message"=>__('Task deleted with success'),"status"=>Response::HTTP_OK]);
    }

}
