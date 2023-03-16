<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Customer;
use App\Models\User;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_for_logged_users()
    {
        for($i=1; $i<=5; $i++)
        {   
            User::factory()->create();
        }
        $user = User::find(2);

        for($i=1; $i<=5; $i++)
        {   
            Customer::factory()->create(["user_id" => $i]);
            Customer::factory()->create(["user_id" => $i]);
        }

        $response = $this->actingAs($user)->get('/api/customers');

        foreach(Customer::all() as $customer)
        {
            if ($user->id==$customer->user->id) $response->assertSeeText("Przypisany użytkownik: ".$user->id);
            else $response->assertDontSeeText("Przypisany użytkownik: ".$customer->user->id);
        }
    }

    public function test_index_for_guests()
    {
        $response = $this->get('/api/customers');

        $response->assertRedirect('/login');
    }

    public function test_show_for_logged_users()
    {
        User::factory()->create(["id"=>1]);
        User::factory()->create(["id"=>2]);

        Customer::factory()->create(["id"=>1, "user_id"=>1]);
        Customer::factory()->create(["id"=>2, "user_id"=>1]);
        Customer::factory()->create(["id"=>3, "user_id"=>2]);
        Customer::factory()->create(["id"=>4, "user_id"=>2]);

        $user = User::find(1);
        $customers = Customer::all();


        foreach($customers as $customer)
        {
            $response = $this->actingAs($user)->get('/api/customers/'.$customer->id);

            if ($customer->user->id==$user->id) $response->assertSeeText("Przypisany użytkownik: ".$customer->user->id);
            else $response->assertStatus(403);
        }
    }

    public function test_show_for_guests()
    {
        $response = $this->get('/api/customers/1');

        $response->assertRedirect('/login');
    }

    public function test_create()
    {
        User::factory()->create(["id"=>1]);
        $user = User::find(1);

        $response = $this->actingAs($user)->get('/api/customers/create');

        $response->assertSeeText("Dodaj klienta");
    }

    public function test_create_for_guests()
    {
        $response = $this->get('/api/customers/create');

        $response->assertRedirect('/login');
    }

    public function test_store()
    {
        User::factory()->create(["id"=>1]);
        $user = User::find(1);

        $this->actingAs($user)->post('/api/customers', ["user_id"=>$user->id]);


        $this->assertDatabaseHas('customers', [
            'user_id'=>$user->id
        ]);
    }

    
    public function test_store_for_guests()
    {
        $response = $this->post('/api/customers');

        $response->assertRedirect('/login');
    }

    public function test_edit()
    {
        User::factory()->create(["id"=>1]);
        User::factory()->create(["id"=>2]);
        $user = User::find(1);
        

        Customer::factory()->create(["user_id"=>1]);
        Customer::factory()->create(["user_id"=>2]);
        $customers = Customer::all();

        foreach($customers as $customer)
        {
            $response = $this->actingAs($user)->get('/api/customers/'.$customer->id.'/edit');
            if($customer->user->id == $user->id) $response->assertSeeText("Edytuj klienta");
            else $response->assertStatus(403);
        }
    }

    public function test_edit_for_guests()
    {
        $response = $this->get('/api/customers/1/edit');

        $response->assertRedirect('/login');
    }
    
    public function test_update()
    {
        User::factory()->create(["id"=>1]);
        User::factory()->create(["id"=>2]);
        $user = User::find(1);

        Customer::factory()->create(["id"=>1, "user_id"=>1]);
        Customer::factory()->create(["id"=>2, "user_id"=>2]);
        $customers = Customer::all();

        foreach($customers as $customer)
        {
            $response = $this->actingAs($user)->put('/api/customers/'.$customer->id, ["user_id"=>2]);


            if ($user->id==$customer->user->id)
            $this->assertDatabaseHas('customers', [
                'user_id'=>2
            ]);
            else
            $response->assertStatus(403);
        }
    }

    public function test_update_for_guests()
    {
        $response = $this->put('/api/customers/1');

        $response->assertRedirect('/login');
    }

    public function test_destroy()
    {
        User::factory()->create(["id"=>1]);
        User::factory()->create(["id"=>2]);
        $user = User::find(1);
        
        Customer::factory()->create(["id"=>1, "user_id"=>1]);
        Customer::factory()->create(["id"=>2, "user_id"=>2]);
        $customers = Customer::all();


        foreach($customers as $customer)
        {
            $response = $this->actingAs($user)->delete('/api/customers/'.$customer->id);

            if ($user->id==$customer->user->id) $this->assertDatabaseMissing('customers', [
                'user_id'=>$customer->user->id
            ]);
            else
            $response->assertStatus(403);
        }
        
    }

    public function test_destroy_for_guests()
    {
        $response = $this->delete('/api/customers/1');

        $response->assertRedirect('/login');
    }
}