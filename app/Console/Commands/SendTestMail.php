<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendTestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {--class=} {--to=butingeorgiy48@gmail.com}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail. Specify mailable class to send it.';

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
     */
    public function handle()
    {
        $mailClass = $this->option('class');
        $sendTo = $this->option('to');

        if ($mailClass === null) {
            $this->error('Specify mail class name by "--class" option!');
            return;
        }

        $className = "App\Mail\\$mailClass";

        if (!class_exists($className)) {
            $this->info('Class not found!');
        }

        if (!method_exists($className, 'getTestingInstance')) {
            $this->error('Specified class not allow tested mode!');
        }

        if ($this->confirm("Mail will be sent to $sendTo. You are sure?")) {
            try {
                Mail::to($sendTo)->send($className::getTestingInstance());
            } catch (Throwable $e) {
                $this->error($e->getMessage());
            }
        } else {
            $this->warn('Sending was aborted!');
        }
    }
}
