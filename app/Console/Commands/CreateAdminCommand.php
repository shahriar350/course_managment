<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use phpDocumentor\Reflection\Types\True_;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'You can create a admin panel';

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
        $usercheck = true;
        while ($usercheck){
            $username = $this->ask('Username');
            if (User::where('username',$username)->count() > 0){
                $this->info('Your username is already exist');
                $usercheck = true;
            } else {
                $usercheck = false;
            }
        }
        $password = $this->ask('Password');

        $name = $this->ask('What is your name');

        $gender = $this->choice('Gender',['man','woman']);
        $age = $this->ask('Age');
        $this->info('Creating your admin information');
        $user = new User();
        $user->name = $name;
        $user->username = $username;
        $user->password = bcrypt($password);
        $user->gender = $gender;
        $user->age = (int)$age;
        if ($user->save()){
            if($AdminRole = Role::where('name','admin')->first()){
                $user->attachRole($AdminRole);
                $this->info('Created Successfully');
            }
        }
        return 0;
    }
}
