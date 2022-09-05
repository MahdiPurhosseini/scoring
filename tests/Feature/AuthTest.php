<?php

    namespace Tests\Feature;

    use App\Models\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Foundation\Testing\WithFaker;
    use Illuminate\Support\Facades\Hash;
    use Tests\TestCase;

    class AuthTest extends TestCase
    {
        use RefreshDatabase , WithFaker;

        /**
         * A basic test example.
         *
         * @return void
         */
        public function test_the_api_login()
        {
            $user = User::create( [
                "first_name" => $this->faker->firstName ,
                "last_name" => $this->faker->lastName ,
                "mobile" => "09120000000" ,
                "email" => $this->faker->email ,
                "password" => Hash::make( $this->faker->password(8) )
            ] );
            $this->assertNotNull( $user );

            $response = $this->post( '/api/login' , [
                "mobile" => $user->mobile ,
                "password" => $user->password
            ] );
            $response->assertStatus( 200 );
        }

        /**
         * A basic test example.
         *
         * @return void
         */
        public function test_the_api_register()
        {
            $password = $this->faker->password(8);
            $data = [
                "first_name" => $this->faker->firstName ,
                "last_name" => $this->faker->lastName ,
                "mobile" => "09120000000" ,
                "email" => $this->faker->email ,
                "password" =>  $password ,
                "password_confirmation" => $password
            ] ;
            $response = $this->post( '/api/register' , $data );
            $response->assertStatus( 200 );
        }

        /**
         * A basic test example.
         *
         * @return void
         */
        public function test_the_api_check_code()
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
                "mobile" => $user->mobile ,
                "active_code" => "111111" ,
            ] ;
            $response = $this->post( '/api/check/code' , $data );
            $response->assertStatus( 200 );
        }
    }
