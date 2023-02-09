<?php

namespace App\GraphQL\Query;

use App\Interfaces\Services\IAuthService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class MeQuery extends Query
{
    protected $attributes = [
        'name'=>'me'
    ];

    protected IAuthService $authSvc;

    public function __construct(IAuthService $authSvc) {
        $this->authSvc = $authSvc;
    }

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        /*
        $loggedInMemeber = auth()->guard('api')->user();
        if(!isset($loggedInMemeber)) {
            return false;
        }
        return true;
        */
        return $this->authSvc->hasAuthedMember();
    }

    public function type(): Type {
        return Type::nonNull(GraphQL::type('Member'));
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, \Closure $getSelectFields) {
        //dd('woah', auth()->guard('api')->user());
        return $this->authSvc->getAuthedMember();
    }
}
