<?php

namespace App\Console\Commands\V1;

use App\Services\V1\PostService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;

class PopulatePosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:posts {--userid=}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and save a user\'s external posts';

    public function __construct(private readonly PostService $postService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @throws RequestException
     */
    public function handle()
    {
        $this->info('Free API post service starting...');

        $userId = $this->option('userid');

        try {
            $this->postService->processAndStoreData($userId);

            $this->info('Free API post service ran successfully.');
        } catch (Exception $exception) {
            $this->error('An error occurred: ' . $exception->getMessage());
        }
    }
}
