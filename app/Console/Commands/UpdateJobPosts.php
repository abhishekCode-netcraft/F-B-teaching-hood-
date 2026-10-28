<?php

namespace App\Console\Commands;

use App\Models\JobPost;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateJobPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-job-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $planDays = [
            1 => 30,
            2 => 45,
            3 => 60,
        ];

        foreach ($planDays as $planId => $days) {

            JobPost::where('is_closed', 0)
                ->whereHas('user', function ($query) use ($planId) {
                    $query->where('plan_id', $planId);
                })
                ->where('created_at', '<', Carbon::now()->subDays($days))
                ->update([
                    'is_closed' => 1
                ]);
        }

        $this->info('Expired job posts closed successfully.');
    }
}
