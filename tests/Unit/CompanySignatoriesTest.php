<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory;
use Carbon\Carbon;

class CompanySignatoriesTest extends TestCase
{

    // use RefreshDatabase;

    /**
     * @test
     */
    public function can_create_company_signatory()
    {
        $user = $this->defaultUser();
         $response = $this->actingAs($user, 'api')->json('POST', 'api/company-signatories', [
            'user_id' => $user->id,
            'company_id' => $company_id = 1,
            'signatory_id' => $signatory_id = 1,
            'policy_type' => $policy_type = 1,
        ]);

        $response->assertJsonStructure([
            'id','company','signatory','policy_type','created_at'
        ])
        ->assertJson([
            'company' => $company_id,
            'signatory' => $signatory_id,
            'policy_type' => $policy_type
        ])
        ->assertStatus(200);

        $this->assertDatabaseHas('company_signatory',[
            'company_id' => $company_id,
            'signatory_id' => $signatory_id,
            'policy_type' => $policy_type
        ]);
    }

    /**
     * @test
     */
    public function can_update_company_signatory()
    {
        $companySignatory = \App\CompanySignatory::first();
        $user = $this->defaultUser();

        $response = $this->actingAs($user, 'api')->json('PUT', "api/company-signatories/$companySignatory->id", [
            'company_id' => $company_id = 2,
            'signatory_id' => $signatory_id = 2,
            'policy_type' => $policy_type = 2,
        ]);

        //  \Log::info($response->getContent());

        $response->assertJsonStructure([
            'id','company','signatory','policy_type','created_at'
        ])
        ->assertJson([
            'company' => $company_id,
            'signatory' => $signatory_id,
            'policy_type' => $policy_type
        ])
        ->assertStatus(200);

        $this->assertDatabaseHas('company_signatory',[
            'company_id' => $company_id,
            'signatory_id' => $signatory_id,
            'policy_type' => $policy_type
        ]);
    }

    /**
     * @test
     */
    public function can_return_signatories_based_from_company_id()
    {
        $company_id = 1;
        $response = $this->actingAs($this->defaultUser(), 'api')->json('GET',"api/company-signatories/$company_id");

        $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                     'id','company','signatory','policy_type','created_at'
                ]
            ]
        ]);
    }

}
