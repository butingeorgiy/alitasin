<?php

namespace App\Console\Commands;

use App\Facades\Hash;
use App\Models\User;
use Illuminate\Console\Command;

class ChangePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:change {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change password for existing user. ';

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
     * @return void
     */
    public function handle()
    {
        /** @var User|null $user */
        if ($user = User::where('email', $this->argument('email'))->first()) {
            while (true) {
                $password = $this->secret('Enter a new password');

                if (strlen($password) >= 8) {
                    break;
                }

                $this->warn('Password must be more then 8 characters!');
            }

            $passwordConfirmation = $this->secret('Confirm password');

            if ($password !== $passwordConfirmation) {
                $this->error('Password are not matched!');
            } else {
                $user->password = Hash::make($password, $user);
                $user->save();

                $this->info('Passwords was updated successfully!');
            }
        } else {
            $this->error('User not found!');
        }
    }
}
