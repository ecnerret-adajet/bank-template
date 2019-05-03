<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagerTest extends TestCase
{
   /**
    * @test
    */
    public function can_create_manager()
    {
        $user = $this->defaultUser();
         $response = $this->actingAs($user, 'api')->json('POST', 'managers', [
            'first_name' => $first_name = "First Name Test",
            'middle_name' => $middle_name = "Middle Name Test",
            'last_name' => $last_name = "Last Name Test",
            'title' => $title = "Mr.",
            'bank_list' => $bank_list = 1,
        ]);

        $response->assertJsonStructure([
            'id','title','full_name','first_name','middle_name','last_name','bank'
        ])
        ->assertJson([
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name
        ])
        ->assertStatus(201);

        $this->assertDatabaseHas('managers',[
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name
        ]);
    }
}
