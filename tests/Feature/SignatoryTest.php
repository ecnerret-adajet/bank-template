<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SignatoryTest extends TestCase
{
    /**
     * @test
     */
    public function can_return_signatory_from_assigned_company()
    {
        $company_id = 1;
        $response = $this->actingAs($this->defaultUser(), 'api')->json('GET',"api/assigned-signatories/$company_id");

        $response->assertStatus(200)
        ->assertJsonStructure([
            [
                'id','full_name','policy_type'
            ]
        ]);
    }
}
