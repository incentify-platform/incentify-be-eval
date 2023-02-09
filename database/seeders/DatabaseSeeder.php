<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Entities\LegalEntity;
use App\Entities\Member;
use App\Entities\Tenant;
use App\Entities\User;
use Doctrine\Common\Collections\ArrayCollection;
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

        $users = entity(User::class, 100)->create();
        $users[] = $uberUser;
        $tenant = entity(Tenant::class, 'parent')->create(['primaryUser'=>$uberUser]);
        $tenant->getChildren()->initialize();
        foreach($tenant->getChildren() as $childTenant) {
            $childTenant->getMembers()->initialize();
            entity(LegalEntity::class, 'load', 50)->create(['members'=>$childTenant->getMembers(), 'tenant'=>$childTenant]);
        }


        $users = entity(User::class, 100)->create();
        $users[] = $uberUser;
        $tenant = entity(Tenant::class)->create(['users'=>$users, 'primaryUser'=>$uberUser]);
        $members = [];
        foreach($users as $user) {
            $member = entity(Member::class)->create(['user'=>$user, 'tenant'=>$tenant]);
            $members[] = $member;
        }
        $tenant->setMembers(new ArrayCollection($members));
        entity(LegalEntity::class, 'load', 100)->create(['members'=>$tenant->getMembers(), 'tenant'=>$tenant]);

        $tenants = entity(Tenant::class, 'standard', 50)->create();
    }
}
