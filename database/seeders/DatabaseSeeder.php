<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Entities\LegalEntity;
use App\Entities\Tenant;
use App\Entities\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $uberUser = entity(User::class)->create(['email'=>'admin@incentify.com', 'pwd'=>'123Ez']);

        $users = entity(User::class, 100)->create();//100
        $users[] = $uberUser;
        $tenant = entity(Tenant::class, 'parent')->create(['primaryUser'=>$uberUser]);
        $tenant->getChildren()->initialize();
        foreach($tenant->getChildren() as $childTenant) {
            $childTenant->getMembers()->initialize();
            entity(LegalEntity::class, 'load', 500)->create(['members'=>$childTenant->getMembers(), 'tenant'=>$childTenant]);
        }



        $users = entity(User::class, 100)->create();
        $users[] = $uberUser;
        $tenant = entity(Tenant::class)->create(['users'=>$users, 'primaryUser'=>$uberUser]);
        entity(LegalEntity::class, 'load', 500)->create(['members'=>$tenant->getMembers()->initialize(), 'tenant'=>$tenant]);


        //$tenants = entity(Tenant::class, 50)->create();

        //TODO: create sites, legal entities, and entity access


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
