<?php

use Illuminate\Database\Seeder;

class InitialSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create super user(staff to approve)
        DB::table('users')->insert(
            [
                'id' => 1 ,
                'name' => 'Staff',
                'email' => 'bankstaff@gmail.com',
                'user_type' => 1,
                'password' => bcrypt('admin')
            ]
        );

        // Create frequency data
        DB::table('payment_frequency')->insert([
            ['id' => 1 , 'frequencies' => 'Weekly'],
            ['id' => 2 , 'frequencies' => 'Every 2 Week'],
            ['id' => 3 , 'frequencies' => 'Monthly']
        ]);

        // Create status name data
        DB::table('loan_status')->insert([
            ['id' => 1 , 'status_name' => 'Pending'],
            ['id' => 2 , 'status_name' => 'Approved'],
            ['id' => 3 , 'status_name' => 'Rejected']
        ]);
    }
}
