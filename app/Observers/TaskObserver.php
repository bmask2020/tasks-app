<?php

namespace App\Observers;

use App\Models\tasks;
use Illuminate\Support\Facades\Log;

class TaskObserver
{
    /**
     * Handle the tasks "created" event.
     */
    public function created(tasks $tasks): void
    {

        $logMessage = "Task Created Successfully | ID: {$tasks->id} | Title: {$tasks->title} | Assigned to User ID: {$tasks->user_id}";
        Log::info($logMessage);
    }

    /**
     * Handle the tasks "updated" event.
     */
    public function updated(tasks $tasks): void
    {
        //
    }

    /**
     * Handle the tasks "deleted" event.
     */
    public function deleted(tasks $tasks): void
    {
        //
    }

    /**
     * Handle the tasks "restored" event.
     */
    public function restored(tasks $tasks): void
    {
        //
    }

    /**
     * Handle the tasks "force deleted" event.
     */
    public function forceDeleted(tasks $tasks): void
    {
        //
    }
}
