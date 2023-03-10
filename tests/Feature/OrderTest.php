<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use App\Models\User;
use App\Models\Merchant;
use App\Models\Ingredient;

class OrderTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testErrorValidationForOrder()
    {
        $postData = [
            'products' => [
                'product_id' => 0,
                'quantity' => 0,
            ]
        ];

        $user = User::find(1);

        $this->actingAs($user);

        $response = $this->post('/api/order/product', $postData, ['Accept' => 'application/json']);
        $responseArray = json_decode($response->getContent(), true);

        $this->assertTrue(isset($responseArray['errors']));
        $this->assertTrue(isset($responseArray['message']));
    }

    public function testOrder()
    {
        $postData = [
            'products' => [
                'product_id' => 1,
                'quantity' => 2,
            ]
        ];

        $user = User::find(1);
        $merchant = Merchant::find(2);

        $this->actingAs($user);

        $oldIngredients = $merchant->ingredients()->get();

        $response = $this->post('/api/order/product', $postData, ['Accept' => 'application/json']);
        $responseArray = json_decode($response->getContent(), true);

        $this->assertEquals(200, $responseArray['status_code']);
        $this->assertEquals( 'success', $responseArray['status']);

        foreach ($responseArray['data'] as $value) {
            $this->assertTrue($value['is_successful']);
        }

        foreach ($oldIngredients as $old) {
            $ingredient = $merchant->ingredients()
                            ->where('id', $old->id)->first();
            $this->assertTrue($old->quantity_available !== $ingredient->quantity_available);
        }

    }
}
