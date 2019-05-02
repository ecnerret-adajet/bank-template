<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    /**
     * @test
     */
    public function can_update_company()
    {
        $company = \App\Company::first();
        $user = $this->defaultUser();

        $response = $this->actingAs($user, 'api')->json('PUT', "companies/$company->id", [
            'name' => $company->name."_update",
            'department' =>  $company->department."_update",
            'abbrv' =>  $company->abbrv."_update",
        ]);

        //  \Log::info($response->getContent());

        $response->assertJsonStructure([
            'id','name','department','abbrv','created_at'
        ])
        ->assertJson([
            'name' => $company->name."_update",
            'department' =>  $company->department."_update",
            'abbrv' =>  $company->abbrv."_update",
        ])
        ->assertStatus(200);

        $this->assertDatabaseHas('companies',[
            'name' => $company->name."_update",
            'department' =>  $company->department."_update",
            'abbrv' =>  $company->abbrv."_update",
        ]);
    }
}
