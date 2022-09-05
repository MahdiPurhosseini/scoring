<?php

    namespace Tests\Feature;

    use App\Models\Role;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Foundation\Testing\WithFaker;
    use Tests\TestCase;

    class RoleTest extends TestCase
    {
        use RefreshDatabase , WithFaker;

        /**
         * A basic test example.
         *
         * @return void
         */
        public function test_the_api_index_role()
        {
            $response = $this->get( '/api/role');
            $response->assertStatus( 200 );
        }

        /**
         * A basic test example.
         *
         * @return void
         */
        public function test_the_api_show_role()
        {
            $role = Role::create( [
                "name"  => $this->faker->name,
                "from_rate"  => rand(0,1000),
                "to_rate"  => rand(1000,2000),
            ] );
            $this->assertNotNull( $role );

            $response = $this->get( '/api/role/show/'.$role->id);
            $response->assertStatus( 200 );
        }

        /**
         * A basic test example.
         *
         * @return void
         */
        public function test_the_api_create_role()
        {
            $data = [
                "name"  => $this->faker->name,
                "from_rate"  => rand(0,1000),
                "to_rate"  => rand(1000,2000),
            ] ;
            $response = $this->post( '/api/role/store' , $data );
            $response->assertStatus( 200 );
        }

        /**
         * A basic test example.
         *
         * @return void
         */
        public function test_the_api_delete_role()
        {
            $role = Role::create( [
                "name"  => $this->faker->name,
                "from_rate"  => rand(0,1000),
                "to_rate"  => rand(1000,2000),
            ] );
            $this->assertNotNull( $role );

            $response = $this->get( '/api/role/delete/'.$role->id);
            $response->assertStatus( 200 );
        }
    }
