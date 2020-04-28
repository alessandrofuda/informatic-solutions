<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\UsersController;

class DeleteOldNotVerifiedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:delete-unverified-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all old and not verified spam-users';

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
     * @return mixed
     */
    public function handle() {

        $this->line("Start deleting old & unverified spam Users...");
        Log::info("Start deleting old & unverified spam Users...");
        // dd('ok');
        try {

            $users = new UsersController;
            $deleted = $users->deleteOldUnverifiedUsers();

        } catch (Exception $e) {
            $error_msg = 'Error during deleting: '.$e->getMessage();
            $this->error($error_msg);
            Log::error($error_msg);
        }
        $this->line($deleted." unverified users deleted from db!");
        Log::info($deleted." unverified users deleted from db!");
    }
}
