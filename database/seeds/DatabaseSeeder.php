<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);		
		//users
		for ($i=0; $i < 3; $i++) { 
	    	DB::table('users')->insert([
	            'full_name' => str_random(10),
	            'email' => str_random(8).'@mail.com',
	            'password' => bcrypt('password')

	        ]);

    	}
		//Film Genres
		$genres = ["0"=>"DRAMA","1"=>"ACTION", "2" =>"SCIENCE FICTION"];
		for ($i=0; $i < 3; $i++) { 	    	
			DB::table('genres')->insert([
	            'name' => $genres[$i],	            
	        ]);
    	}
		//films
		for ($i=0; $i < 3; $i++) { 
	    	DB::table('films')->insert([
	            'name' => str_random(8),
	            'slug_name' => Str::slug(str_random(8)),
	            'rating' => $i+1,
				'description' => str_random(100),
				'ticket_price' => 12.99,
				'photo' => str_random(12).'.jpg',
				'country' => str_random(10),
				'release_date' => date("Y-m-d"),
	        ]);
    	}
		
		$film_ids = DB::table('films')->pluck('id');
		$genre_ids = DB::table('genres')->pluck('id');
		foreach($film_ids as $id){
			DB::table('film_genres')->insert([
	            'film' => $id,
				'genre' => $genre_ids[0],
	        ]);
		}
		
		//comments		
		//$film_ids = DB::table('films')->list('id');
		$user_ids = DB::table('users')->pluck('id');
		foreach($film_ids as $id){
			DB::table('comments')->insert([
				'content' => str_random(20),
				'user' => $user_ids[0],
				'film' => $id
			]);				
		}		
    }
}
