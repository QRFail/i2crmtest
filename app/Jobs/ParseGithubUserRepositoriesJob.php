<?php

namespace App\Jobs;

use App\Models\GithubUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseGithubUserRepositoriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $githubUser;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(GithubUser $githubUser)
    {
        $this->githubUser = $githubUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logs()->info("Запущен парсер для {$this->githubUser->name}");
        $ghApi = new GithubApi(null, null);
        $res = $ghApi->getReposInfo($this->githubUser->name);

        if(isset($res)){
            foreach ($res as $item){
                //print_r( 'pushed_at=>' . $item['pushed_at'] . '   name=>' . $item['name']);
                print_r( 'pushed_at=>' . $item['pushed_at'] . '   name=>' . $item['name']);
                echo "\r\n";

                $ghUserRepository = GithubUserRepository::firstOrNew([
                    'github_user_id' => $this->githubUser->id,
                    'repository_id' => $item['id']
                ]);

                $ghUserRepository->repository_name = $item['name'];
                $ghUserRepository->repository_fullname = $item['full_name'];
                $ghUserRepository->repository_pushed_at  = isset($item['pushed_at']) ? date("Y-m-d H:i:s", strtotime($item['pushed_at'])) : null;
                $ghUserRepository->save();
            }
        }

        logs()->info("Обработка для {$this->githubUser->name} завершена");

    }
}
