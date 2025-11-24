<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Stack;
use App\Models\Priority;
use App\Models\Category;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $stack = Stack::first();
        $priority = Priority::first();
        $category = Category::first();

        if ($user && $stack && $priority && $category) {
            Ticket::create([
                'user_id' => $user->id,
                'stack_id' => $stack->id,
                'priority_id' => $priority->id,
                'category_id' => $category->id,
                'subject' => 'Sensor Oksigen Error',
                'description' => 'Pembacaan sensor oksigen tidak stabil sejak pagi ini.',
                'status' => 'Open',
            ]);
        }
    }
}