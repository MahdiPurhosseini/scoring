<?php

    namespace Tests\Unit;

    use App\Models\Role;
    use App\Models\User;
    use Illuminate\Support\Facades\Hash;
    use Tests\TestCase;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Foundation\Testing\WithFaker;

    class ScoreTest extends TestCase
    {
        use RefreshDatabase , WithFaker;

        /**
         * A basic test example.
         *
         * @return void
         */
        public function test_that_user_gets_the_role_when_he_gets_the_score()
        {
            $user = User::create( [
                "first_name" => $this->faker->firstName ,
                "last_name" => $this->faker->lastName ,
                "mobile" => "09120000000" ,
                "email" => $this->faker->email ,
                "password" => Hash::make( $this->faker->password(8) )
            ] );
            $this->assertNotNull( $user );

            $score = rand( 0 , 2000 );
            $user->score += $score;
            $user->save();
            $this->assertEquals( $user->score , $score );

            $roleName = $this->faker->name;
            $role = Role::create( [
                "name" => $roleName ,
                "from_rate" => 0 ,
                "to_rate" => 2000 ,
            ] );
            $this->assertNotNull( $role );

            $this->assertEquals( $user->role , $roleName );
        }
    }
