<?php

    namespace Tests\Feature;

    use App\Models\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Foundation\Testing\WithFaker;
    use Illuminate\Support\Facades\Hash;
    use Tests\TestCase;

    class UserTest extends TestCase
    {
        use RefreshDatabase , WithFaker;

        /**
         * A basic test example.
         *
         * @return void
         */
        public function test_the_api_index_user()
        {
            $response = $this->get( '/api/user');
            $response->assertStatus( 200 );
        }

        /**
         * A basic test example.
         *
         * @return void
         */
        public function test_the_api_show_user()
        {
            $user = User::create( [
                "first_name" => $this->faker->firstName ,
                "last_name" => $this->faker->lastName ,
                "mobile" => "09120000000" ,
                "email" => $this->faker->email ,
                "password" => Hash::make( $this->faker->password(8) )
            ] );
            $this->assertNotNull( $user );

            $response = $this->get( '/api/user/show/'.$user->id);
            $response->assertStatus( 200 );
        }

        /**
         * A basic test example.
         *
         * @return void
         */
        public function test_the_api_set_score_for_user()
        {
            $user = User::create( [
                "first_name" => $this->faker->firstName ,
                "last_name" => $this->faker->lastName ,
                "mobile" => "09120000000" ,
                "email" => $this->faker->email ,
                "password" => Hash::make( $this->faker->password(8) )
            ] );
            $this->assertNotNull( $user );

            $data = [
                "id"  => $user->id,
                "score"  => rand(0,3000),
            ] ;
            $response = $this->post( '/api/user/score' , $data );
            $response->assertStatus( 200 );
        }

        /**
         * A basic test example.
         *
         * @return void
         */
        public function test_the_api_delete_user()
        {
            $user = User::create( [
                "first_name" => $this->faker->firstName ,
                "last_name" => $this->faker->lastName ,
                "mobile" => "09120000000" ,
                "email" => $this->faker->email ,
                "password" => Hash::make( $this->faker->password(8) )
            ] );
            $this->assertNotNull( $user );

            $response = $this->get( '/api/user/delete/'.$user->id);
            $response->assertStatus( 200 );
        }
    }
