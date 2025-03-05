<?php

namespace Database\Seeders;

use App\Models\Timesheet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimesheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Timesheet::create([
            'task_name' => 'Task 1',
            'date' => '2023-10-01',
            'hours' => 5,
            'user_id' => 1,
            'project_id' => 1,
        ]);
    }
}
