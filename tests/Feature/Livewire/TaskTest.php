<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Task::class)
            ->assertStatus(200);
    }
}
