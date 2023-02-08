<?php

namespace App\Http\Controllers;

use App\Entities\Member;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index() {
        $authed = auth('web');
        $member = $authed->user();
        $children = $member->getTenant()->getChildren();
        $children->initialize();
        $members = $member->getTenant()->getMembers();
        $members->initialize();
        //dd($member->getUser(), $member->getTenant(), $member->getId(), $children, $members);

        $token = Auth::user()->createToken('jwt');
        dd($token);

        return view('dashboard');
    }
}
