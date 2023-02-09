<?php

namespace App\Http\Controllers;

use App\Entities\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DashboardController extends Controller
{

    public function index() {
        /*
        $authed = auth('web');
        $member = $authed->user();
        $children = $member->getTenant()->getChildren();
        $children->initialize();
        $members = $member->getTenant()->getMembers();
        $members->initialize();
        */

        $token = Auth::user()->createToken('jwt');
        //ugly hack here because tokenable_id is null, let it ride then update.
        $token->accessToken->tokenable_id = Auth::user()->getAuthIdentifier();
        $token->accessToken->save();


        return view('dashboard', ['token'=>$token->plainTextToken]);
    }

    public function getJwt(Request $req) {
        $req->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
            'client_id'=>'1',
            'redirect_uri'=> 'http://localhost/dashboard/callback',
            'response_type'=>'code',
            'scope'=>'*',
            'state'=>'5',
            'prompt'=>'none',
        ]);

        return redirect('http://localhost/oauth/authorize?'.$query);
    }
    public function callback(Request $req) {
        $state = $req->session()->pull('state');

        /*
        throw_unless(
            strlen($state) > 0 && $state === $req->state,
            \InvalidArgumentException::class
        );
        */

        $postParams = [
            'grant_type' => 'authorization_code',
            'client_id' => '1',
            'client_secret' => 'Ix6BQ7BK54XR2gaYG5ygCJrGLzsvfTvYlu2q2H4f',
            'redirect_uri' => 'http://localhost/dashboard/callback',
            'code' => $req->code,
        ];

        dd($postParams);

        $response = Http::asForm()->post('http://localhost/oauth/token', $postParams);

        return $response->json();
    }
}
