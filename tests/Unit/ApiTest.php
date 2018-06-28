<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\BankTransfer;

class ApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $bankTransfer = BankTransfer::with('manager','manager.bank','signatory')->first();
        $this->get($bankTransfer)->getContent();

        echo json_encode($bankTransfer, JSON_PRETTY_PRINT);
    }
}
