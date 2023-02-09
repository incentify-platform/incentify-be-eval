<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class UserType extends GraphQLType
{

    protected $attributes = [
        'name' => 'User',
        'description'=> 'Information about a user',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type'=> Type::nonNull(Type::int()),
                'description' => 'Id of the user',
                'resolve'=>function($root, array $args) {
                    return $root->getId();
                }
            ],
            'name' => [
                'type'=> Type::nonNull(Type::string()),
                'description' => 'Display name of the user',
                'resolve'=>function($root, array $args) {
                    return $root->getName();
                }
            ],
            'email' => [
                'type'=> Type::nonNull(Type::string()),
                'description' => 'Email address of the user',
                'resolve'=>function($root, array $args) {
                    return $root->getEmail();
                }
            ],
            'memberships' => [
                'type'=> Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type('Member')))),
                'description' => 'User\'s tenant memberships',
                'resolve'=>function($root, array $args) {
                    return $root->getMemberships();
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
