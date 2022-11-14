<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GithubUserRepository;

class ApiController extends Controller
{
    public function getLastPushedRepositories(){

        //return 'test';
        $response = GithubUserRepository::orderBy('repository_pushed_at', 'desc')
            ->limit(10)
            ->get();

        return $response;
    }

    public function index(){

        //return 'test';
        $response = $this->getLastPushedRepositories();

        $data = [];

        foreach ($response as $item){
            $data[] = [
                'repository_fullname' => $item->repository_fullname,
                'repository_pushed_at' => $item->repository_pushed_at
            ];
        }

        return view('index', [
            'data' => $data
        ]);
    }
}
