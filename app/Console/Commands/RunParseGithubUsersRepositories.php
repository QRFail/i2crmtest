<?php

namespace App\Console\Commands;

use App\Jobs\ParseGithubUserRepositoriesJob;
use Illuminate\Cache\RateLimiter;
use Illuminate\Console\Command;
use App\Models\GithubUser;

class RunParseGithubUsersRepositories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:parse_github_users_repositories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run:parse_github_users_repositories';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        foreach (GithubUser::all() as $user) {
            //echo $user->name . "\r\n";
            $job = new ParseGithubUserRepositoriesJob($user);
            dispatch($job);
        }

        return 0;
    }
}
