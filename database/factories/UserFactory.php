<?php

namespace Database\Factories;

use App\Entities\EntityAccess\LegalEntityAccess;
use App\Entities\EntityAccess\SiteEntityAccess;
use App\Entities\LegalEntity;
use App\Entities\Member;
use App\Entities\Site;
use App\Entities\Tenant;
use App\Entities\User;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/* @var $factory \Illuminate\Database\Eloquent\Factories\Factory */
$factory->define(User::class, function(\Faker\Generator $faker, array $attrs) {
    $password = Hash::make($attrs['pwd'] ?? $faker->password());
    return [
        'email'=>$attrs['email'] ?? $faker->email(),
        'name'=>$attrs['name'] ?? $faker->name(),
        'password'=>$password,
        'createdAt'=>new \DateTime('now'),
        'updatedAt'=>new \DateTime('now'),
    ];
});

$factory->define(Tenant::class, function(\Faker\Generator $faker, array $attrs) {
    $title = $attrs['title'] ?? $faker->company();
    $primaryUser = null;
    if(isset($attrs['primaryUser'])) {
        $primaryUser = $attrs['primaryUser'];
    }
    if(!isset($primaryUser)) {
        $primaryUser = entity(User::class)->create(['email'=>'primary-'.Str::of($title)->slug('').'@incentify.com', 'pwd'=>'123Ez']);
    }
    $parent = null;
    if(isset($attrs['parent'])) {
        $parent = $attrs['parent'];
    }
    return [
        'primaryUser'=>$primaryUser,
        'title'=>$title,
        'type'=>$attrs['type'] ?? $faker->randomElement(Tenant::ALLOWED_TYPES),
        'parent'=>$parent,
        'createdAt'=>new \DateTime('now'),
        'updatedAt'=>new \DateTime('now'),
    ];
});

$factory->defineAs(Tenant::class, 'parent', function(\Faker\Generator $faker, array $attrs) {
    $title = $attrs['title'] ?? $faker->company();
    $primaryUser = null;
    if(isset($attrs['primaryUser'])) {
        $primaryUser = $attrs['primaryUser'];
    }
    if(!isset($primaryUser)) {
        $primaryUser = entity(User::class)->create(['email'=>'primary-'.Str::of($title)->slug('').'@incentify.com', 'password'=>'123Ez']);
    }

    $parentTenant = entity(Tenant::class)->create([
        'primaryUser'=>$primaryUser,
        'title'=>$title,
        'type'=>$attrs['type'] ?? $faker->randomElement(Tenant::ALLOWED_TYPES),
        'parent'=>null,
        'createdAt'=>new \DateTime('now'),
        'updatedAt'=>new \DateTime('now'),
    ]);

    $parentUsers = entity(User::class, $faker->numberBetween(10,100))->create(['password'=>'123Ez']);
    entity(Member::class)->create(['user'=>$primaryUser, 'tenant'=>$parentTenant, 'isActive'=>true]);
    foreach($parentUsers as $parentUser) {
        entity(Member::class)->create(['user'=>$parentUser, 'tenant'=>$parentTenant, 'isActive'=>true]);
    }
    $childUsers = entity(User::class, $faker->numberBetween(50,200))->create(['password'=>'123Ez']);
    $childTenants = [];
    for($foo=0; $foo < $faker->numberBetween(5,15); $foo++) {
        $users = [];
        foreach($childUsers as $childUser) {
            if($faker->boolean(66)) {
                $users[] = $childUser;
            }
        }
        $childTenant = entity(Tenant::class)->create(['users'=>$childUsers, 'primaryUser'=>$primaryUser, 'parent'=>$parentTenant]);
        $members = [];
        foreach($users as $user) {
            $member = entity(Member::class)->create(['user'=>$user, 'tenant'=>$childTenant]);
            $members[] = $member;
        }
        $childTenant->setMembers(new ArrayCollection($members));
        $childTenants[] = $childTenant;
    }

    $parentTenant->setChildren(new ArrayCollection($childTenants));
    return $parentTenant;
});

$factory->defineAs(Tenant::class, 'standard', function(\Faker\Generator $faker, array $attrs) {
    $title = $faker->company();
    if(isset($attrs['title'])) {
        $title = $attrs['title'];
    }
    $primaryUser = entity(User::class)->create(['email'=>'primary-'.Str::of($title)->slug('').'@incentify.com', 'password'=>'123Ez']);
    $users = entity(User::class, $faker->numberBetween(25,100))->create(['password'=>'123Ez']);
    $users[] = $primaryUser;
    $tenant = entity(Tenant::class)->create(['users'=>$users, 'primaryUser'=>$primaryUser, 'title'=>$title]);

    $members = [];
    foreach($users as $user) {
        $member = entity(Member::class)->create(['user'=>$user, 'tenant'=>$tenant]);
        $members[] = $member;
    }
    $tenant->setMembers(new ArrayCollection($members));
    $legalEntities = entity(LegalEntity::class, 'load', $faker->numberBetween(10,50))->create(['members'=>$members, 'tenant'=>$tenant]);

    return $tenant;
});

$factory->define(Member::class, function(\Faker\Generator $faker, array $attrs) {
    return [
        'user'=>$attrs['user'],
        'tenant'=>$attrs['tenant'],
        'isActive'=>$attrs['isActive'] ?? $faker->boolean(80),
        'createdAt'=>new \DateTime('now'),
        'updatedAt'=>new \DateTime('now'),
    ];
});

$factory->define(LegalEntity::class, function(\Faker\Generator $faker, array $attrs) {
    return [
        'tenant'=>$attrs['tenant'],
        'createdByMember'=>$attrs['createdByMember'],
        'title'=>$faker->company(),
        'type'=>$faker->randomElement(['llc','corp','501c']),
        'createdAt'=>new \DateTime('now'),
        'updatedAt'=>new \DateTime('now'),
    ];
});

$factory->define(Site::class, function(\Faker\Generator $faker, array $attrs) {
    //USA bounding box: (-124.848974, 24.396308) - (-66.885444, 49.384358)
    $legalEntity = null;
    if(isset($attrs['legalEntity'])) {
        $legalEntity = $attrs['legalEntity'];
    }
    $address = null;
    $lat = null;
    $lng = null;
    if(isset($attrs['address'])) {
        $address = $attrs['address'];
        $lat = $faker->latitude(-124.848974, 24.396308);
        $lng = $faker->longitude(-66.885444, 49.384358);
        if(isset($attrs['lat'])) {
            $lat = $attrs['lat'];
        }
        if(isset($attrs['lng'])) {
            $lng = $attrs['lng'];
        }
    }

    if(!isset($address) && isset($attrs['withAddress'])) {
        $address = $faker->address();
        $lat = $faker->latitude(-124.848974, 24.396308);
        $lng = $faker->longitude(-66.885444, 49.384358);
    }

    return [
        'tenant'=>$attrs['tenant'],
        'createdByMember'=>$attrs['createdByMember'],
        'title'=>$attrs['title'] ?? $faker->streetName().' '.$faker->city(),
        'addressFull'=>$address,
        'lat'=>$lat,
        'lng'=>$lng,
        'legalEntity'=>$legalEntity,
        'createdAt'=>new \DateTime('now'),
        'updatedAt'=>new \DateTime('now'),
    ];
});

$factory->define(SiteEntityAccess::class, function(\Faker\Generator $faker, array $attrs) {
    return [
        'member'=>$attrs['member'],
        'site'=>$attrs['site'],
        'createdByMember'=>$attrs['createdByMember'],
        'entityType'=>'site',
        'createdAt'=>new \DateTime('now'),
        'updatedAt'=>new \DateTime('now'),
    ];
});

$factory->define(LegalEntityAccess::class, function(\Faker\Generator $faker, array $attrs) {
    return [
        'member'=>$attrs['member'],
        'legalEntity'=>$attrs['legalEntity'],
        'createdByMember'=>$attrs['createdByMember'],
        'entityType'=>'legal_entity',
        'createdAt'=>new \DateTime('now'),
        'updatedAt'=>new \DateTime('now'),
    ];
});

$factory->defineAs(LegalEntity::class, 'load', function(\Faker\Generator $faker, array $attrs) {
    $members = $attrs['members'];
    $creatorMember = $faker->randomElement($members);
    $legalEntity = entity(LegalEntity::class)->create(['createdByMember'=>$creatorMember, 'tenant'=>$attrs['tenant']]);
    foreach($members as $member) {
        if($faker->boolean(66)) {
            entity(LegalEntityAccess::class)->create(['member'=>$member, 'legalEntity'=>$legalEntity, 'createdByMember'=>$creatorMember]);
        }
    }

    //has sites?
    if($faker->boolean(75)) {

        //create 2->20 sites
        for($foo=0; $foo<=$faker->numberBetween(2,20); $foo++) {
            $siteParams = ['legalEntity'=>$legalEntity, 'createdByMember'=>$creatorMember, 'tenant'=>$attrs['tenant']];
            if($faker->boolean(60)) {
                $siteParams['withAddress'] = true;
            }
            $site = entity(Site::class)->create($siteParams);
            foreach($members as $member) {
                if($faker->boolean(25)) {
                    entity(SiteEntityAccess::class)->create(['member'=>$member, 'site'=>$site, 'createdByMember'=>$creatorMember]);
                }
            }
        }
    }
    return $legalEntity;
});

