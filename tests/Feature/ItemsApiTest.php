<?php

namespace Tests\Feature;

use App\Models\Item;
use Database\Factories\ItemFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemsApiTest extends TestCase
{
    use RefreshDatabase;

    function test_can_get_all_items()
    {
        $items = Item::factory(4)->create();

        $response = $this->getJson(route('items.index'));

        $response->assertJsonFragment([
            'title' => $items[0]->title,
        ]);
    } 

    function test_can_get_one_item()
    {
        $item = Item::factory()->create();

        $response = $this->getJson(route('items.show', $item));

        $response->assertJsonFragment([
            'title' => $item->title,
        ]);
    }

    function test_can_create_items()
    {
        $this->postJson(route('items.store'), [])
            ->assertJsonValidationErrorFor('title');

        $this->postJson(route('items.store'), [
            'title' => 'New Item'
        ])->assertJsonFragment([
            'title' => 'New Item'
        ]);

        $this->assertDatabaseHas('items', [
            'title' => 'New Item'
        ]);
    }

    function test_can_update_items()
    {
        $item = Item::factory()->create();

        $this->patchJson(route('items.update', $item), [])->assertJsonValidationErrorFor('title');

        $this->patchJson(route('items.update', $item), [
            'title' => 'Title Modified'
        ])->assertJsonFragment([
            'title' => 'Title Modified'
        ]);

        $this->assertDatabaseHas('items', [
            'title' => 'Title Modified'
        ]);
    }

    function test_can_delete_items()
    {
        $item = Item::factory()->create();

        $this->deleteJson(route('items.destroy', $item))->assertNoContent();

        $this->assertDatabaseCount('items', 0);
    }
}
