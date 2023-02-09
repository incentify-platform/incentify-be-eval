<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class TenantType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Tenant',
        'description'=> 'Information about a tenant',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type'=> Type::nonNull(Type::int()),
                'description' => 'Id of the tenant',
                'resolve'=>function($root, array $args) {
                    return $root->getId();
                }
            ],
            'children'=>[
                'type'=> Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type('Tenant')))),
                'description' => 'The parent tenant (if one exists)',
                'resolve'=>function($root, array $args) {
                    return $root->getChildren();
                }
            ],
            'primaryUser'=>[
                'type'=> Type::nonNull(GraphQL::type('User')),
                'description' => 'The primary user for this tenant',
                'resolve'=>function($root, array $args) {
                    return $root->getPrimaryUser();
                }
            ],
            'title'=>[
                'type'=> Type::nonNull(Type::string()),
                'description' => 'Title of the tenant',
                'resolve'=>function($root, array $args) {
                    return $root->getTitle();
                }
            ],
            'parent'=>[
                'type'=> GraphQL::type('Tenant'),
                'description' => 'The parent tenant (if one exists)',
                'resolve'=>function($root, array $args) {
                    return $root->getParent();
                }
            ],
            //'members'=>[],
            'type'=>[
                'type'=> Type::nonNull(GraphQL::type('TenantType')),
                'description' => 'The type of the tenant',
                'resolve'=>function($root, array $args) {
                    return $root->getType();
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
