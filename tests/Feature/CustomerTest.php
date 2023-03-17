<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

use App\Models\Customer;
use App\Models\User;
use App\Models\Role;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {        
        parent::setUp();

        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');

        $admin = Role::where('name', "administrator")->first();
        $commonUser = Role::where('name', "user")->first();

        $user = User::find(1);

        $user->attachRole($admin);
    }
    
    public function test_index_for_common_users()
    {

        $user = User::find(2);


        $response = $this->actingAs($user)->get('/api/customers');

        foreach(Customer::all() as $customer)
        {
            if ($user->id==$customer->user->id) $response->assertSeeText("Przypisany użytkownik: ".$user->id);
            else $response->assertDontSeeText("Przypisany użytkownik: ".$customer->user->id);
        }
    }

    public function test_index_for_admins()
    {

        $user = User::find(1);


        $response = $this->actingAs($user)->get('/api/customers');

        foreach(Customer::all() as $customer)
        {
            $response->assertSeeText("Przypisany użytkownik: ".$customer->user->id);
            $response->assertSeeText("Id klienta: ".$customer->id);
        }
    }

    public function test_index_for_guests()
    {
        $response = $this->get('/api/customers');

        $response->assertRedirect('/login');
    }

    public function test_show_for_common_users()
    {

        $user = User::find(2);
        $customers = Customer::all();


        foreach($customers as $customer)
        {
            $response = $this->actingAs($user)->get('/api/customers/'.$customer->id);

            if ($customer->user->id==$user->id) $response->assertSeeText("Przypisany użytkownik: ".$customer->user->id);
            else $response->assertStatus(403);
        }
    }

    public function test_show_for_admins()
    {

        $user = User::find(1);
        $customers = Customer::all();


        foreach($customers as $customer)
        {
            $response = $this->actingAs($user)->get('/api/customers/'.$customer->id);

            $response->assertSeeText("Przypisany użytkownik: ".$customer->user->id);
        }
    }

    public function test_show_for_guests()
    {
        $response = $this->get('/api/customers/1');

        $response->assertRedirect('/login');
    }

    public function test_create_for_all_users()
    {
        $user = User::find(1);

        $response = $this->actingAs($user)->get('/api/customers/create');

        $response->assertSeeText("Dodaj klienta");
    }

    public function test_create_for_guests()
    {
        $response = $this->get('/api/customers/create');

        $response->assertRedirect('/login');
    }

    public function test_store_for_all_users()
    {
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

    public function test_edit_for_common_users()
    {
        $user = User::find(2);
        
        $customers = Customer::all();

        foreach($customers as $customer)
        {
            $response = $this->actingAs($user)->get('/api/customers/'.$customer->id.'/edit');
            if($customer->user->id == $user->id) $response->assertSeeText("Edytuj klienta");
            else $response->assertStatus(403);
        }
    }

    public function test_edit_for_admins()
    {
        $user = User::find(1);
        
        $customers = Customer::all();

        foreach($customers as $customer)
        {
            $response = $this->actingAs($user)->get('/api/customers/'.$customer->id.'/edit');
            $response->assertSeeText("Edytuj klienta");
        }
    }

    public function test_edit_for_guests()
    {
        $response = $this->get('/api/customers/1/edit');

        $response->assertRedirect('/login');
    }
    
    public function test_update_for_common_users()
    {
        $user = User::find(2);

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

    public function test_update_for_admins()
    {
        $user = User::find(1);

        $customers = Customer::all();

        foreach($customers as $customer)
        {
            $response = $this->actingAs($user)->put('/api/customers/'.$customer->id, ["user_id"=>2]);


            $this->assertDatabaseHas('customers', [
                'user_id'=>2
            ]);
        }
    }

    public function test_update_for_guests()
    {
        $response = $this->put('/api/customers/1');

        $response->assertRedirect('/login');
    }

    public function test_destroy_for_common_users()
    {
        $user = User::find(2);
        
        $customers = Customer::all();


        foreach($customers as $customer)
        {
            $response = $this->actingAs($user)->delete('/api/customers/'.$customer->id);

            if ($user->id==$customer->user->id) $this->assertDatabaseMissing('customers', [
                'id'=>$customer->id
            ]);
            else
            $response->assertStatus(403);
        }
        
    }

    public function test_destroy_for_admins()
    {
        $user = User::find(1);
        
        $customers = Customer::all();


        foreach($customers as $customer)
        {
            $response = $this->actingAs($user)->delete('/api/customers/'.$customer->id);

            $this->assertDatabaseMissing('customers', [
                'id'=>$customer->id
            ]);
        }
        
    }

    public function test_destroy_for_guests()
    {
        $response = $this->delete('/api/customers/1');

        $response->assertRedirect('/login');
    }
}