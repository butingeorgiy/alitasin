<?php

namespace App\Console\Commands;

use App\Models\TelegramChat;
use App\Models\TelegramPrivilege;
use Illuminate\Console\Command;

class AddTelegramBotUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:add-user {phones* : Specify phones which want to add}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add user for telegram notification bot.';

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
        $phones = $this->argument('phones');

        foreach ($phones as $phone) {
            if (!preg_match('/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/', $phone)) {
                $this->error("Invalid phone format for $phone!");
                return;
            }
        }

        foreach (TelegramPrivilege::all() as $privilege) {
            $privileges[] = $privilege->alias;
        }

        if (!isset($privileges)) {
            $this->error('Privileges list is empty now! Please add as least one...');
            return;
        }

        $chosenPrivileges = $this->choice(
            'Choose needle privileges for specified phones:',
            $privileges, null, null, true
        );

        /** @var TelegramPrivilege $privilege */
        foreach (TelegramPrivilege::whereIn('alias', $chosenPrivileges)->get() as $privilege) {
            $privilegeIds[] = $privilege['id'];
        }

        foreach ($phones as $phone) {
            // If phone has been already attached, we'll update privileges.
            if (!$chat = TelegramChat::where('phone_number', $phone)->first()) {
                $chat = new TelegramChat([
                    'phone_number' => $phone
                ]);
            }

            if (!$chat->save()) {
                $this->error('Failed to create new user!');
            }

            $chat->privileges()->sync($privilegeIds ?? []);
        }

        $this->info('Users were added successfully into telegram bot :)');
    }
}
