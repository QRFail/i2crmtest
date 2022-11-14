<?php

namespace App\Console\Commands;

use App\lib\GithubApi;
use Illuminate\Console\Command;
use App\Models\GithubUser;
use App\Models\GithubUserRepository;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test command';

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

        $ghApi = new GithubApi(null, null);

        foreach (GithubUser::all() as $user) {
            $res = $ghApi->getReposInfo($user->name);

            if(isset($res)){
                foreach ($res as $item){
                    //print_r( 'pushed_at=>' . $item['pushed_at'] . '   name=>' . $item['name']);
                    print_r( 'pushed_at=>' . $item['pushed_at'] . '   name=>' . $item['name']);
                    echo "\r\n";

                    //$ghUserRepository = new GithubUserRepository();
                    $ghUserRepository = GithubUserRepository::firstOrNew([
                            'github_user_id' => $user->id,
                            'repository_id' => $item['id']
                        ]);

                    $ghUserRepository->repository_name = $item['name'];
                    $ghUserRepository->repository_fullname = $item['full_name'];
                    $ghUserRepository->repository_pushed_at  = isset($item['pushed_at']) ? date("Y-m-d H:i:s", strtotime($item['pushed_at'])) : null;
                    $ghUserRepository->save();
                }
            }
        }

        return 0;
    }
}
