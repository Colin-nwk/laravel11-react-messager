<?php

namespace Database\Seeders;

use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Group;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password'=> bcrypt('password'),
            'is_admin' =>true
        ]);

        User::factory()->create([
            'name' => 'Mary Doe',
            'email' => 'mary@example.com',
            'password'=> bcrypt('password'),
            'is_admin' =>false
        ]);


        User::factory(10)->create();


        for ($i = 0; $i < 5; $i++){
            $group = Group::factory()->create(['owner_id'=>1]);

            $users = User::inRandomOrder()->limit(rand(2,5))->pluck('id');
            $group->users()->attach(array_unique([1, ...$users]));
        } 

        Message::factory(1000)->create();

        $messages = Message::whereNull('group_id')->orderBy('created_at')->get();

        $conversations = $messages->groupBy(function($message){
            return collect([$message->sender_id, $message->receiver_id])->sort()->implode('_');
        })->map(function($groupedMessage){

            return [
                'user_id1' => $groupedMessage->first()->sender_id,
                'user_id2' => $groupedMessage->first()->receiver_id,
                'last_message_id'=>$groupedMessage->last()->id,
                'created_at' =>new Carbon(),
                'updated_at' =>new Carbon(),

            ];

        })->values();

        Conversation::insertOrIgnore($conversations->toArray());
    }
}
