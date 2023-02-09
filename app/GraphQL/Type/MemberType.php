<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class MemberType extends GraphQLType
{

    protected $attributes = [
        'name' => 'Member',
        'description'=> 'Information about a member of a tenant',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type'=> Type::nonNull(Type::int()),
                'description' => 'Id of the member',
                'resolve'=>function($root, array $args) {
                    return $root->getId();
                }
            ],
            'isActive' => [
                'type'=> Type::nonNull(Type::boolean()),
                'description' => 'True if member is active, false otherwise',
                'resolve'=>function($root, array $args) {
                    return $root->isActive();
                }
            ],
            'user' => [
                'type'=> Type::nonNull(GraphQL::type('User')),
                'description' => 'The user of this member',
                'resolve'=>function($root, array $args) {
                    return $root->getUser();
                }
            ],
            'tenant'=> [
                'type'=> Type::nonNull(GraphQL::type('Tenant')),
                'description' => 'The tenant this member belongs to',
                'resolve'=>function($root, array $args) {
                    return $root->getTenant();
                }
            ],
            'createdAt' => [
                'type'=> Type::nonNull(Type::string()),
                'description' => 'Datetime created',
                'resolve'=>function($root, array $args) {
                    return $root->getCreatedAt()->format('Y-m-d H:i:s');
                }
            ],
            'updatedAt' => [
                'type'=> Type::nonNull(Type::string()),
                'description' => 'Datetime updated',
                'resolve'=>function($root, array $args) {
                    return $root->getUpdatedAt()->format('Y-m-d H:i:s');
                }
            ],
        ];
    }
}
