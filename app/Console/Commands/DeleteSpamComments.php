<?php

namespace App\Console\Commands;

use App\Http\Controllers\Backend\AdminCommentsController;
use Illuminate\Console\Command;
use Log;

class DeleteSpamComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:delete-spam-comments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all Spam Comments that contains one or more keywords matching spam keywords List setted by admin.';

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

        $this->line("Start deleting old & unapproved spam Comments...");
        Log::info("Start deleting old & unapproved spam Comments...");
        // dd('ok');
        try {

            $comments = new AdminCommentsController;
            $deleted = $comments->deleteSpamComments();

        } catch (Exception $e) {
            $error_msg = 'Error during Spam Comments deleting: '.$e->getMessage();
            $this->error($error_msg);
            Log::error($error_msg);
        }
        $this->line($deleted." spam comments deleted from db!");
        Log::info($deleted." spam comments deleted from db!");

    }
}
