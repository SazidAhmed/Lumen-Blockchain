<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

//Models
use App\Models\User;
use App\Models\Role;

//Utilities
use App\Utilities\HttpUtilities;
class BlockController extends Controller
{
    public function welcome(Request $request){
        // $users =  DB::select("SELECT * FROM users");
        // $roles = app('db')->select("SELECT * FROM roles");

        $user = User::find(1);
        $role = Role::find(2);
        // $roles = Role::all();
        // $user->roles()->attach($roles);
        // $user->roles()->attach([1]);
        // $user->roles()->sync([1,2]);
        // $user->roles()->syncWithoutDetaching([2]);
        // $role->users()->sync([2]);
        return $role->users;
        return $user->roles;

        // return [
        //     'user' => $user,
        //     'roles' => $roles
        // ];
    }

    public function storeDeposits(){
        
        $app_pk = '9c22ee4f664e7167f9a67f2a882240de6e34ee61a01af7ce8995ad74958b81e8';
        $protocol = 'http';
        $bank = '20.98.98.0';
        $next_url = $protocol.'://'.$bank.'/bank_transactions?recipient='.$app_pk.'&ordering=-block__created_date';
        
        while($next_url) {
            $data = HttpUtilities::fetchUrl($next_url);
            $bankTransactions = $data->results;
            $next_url = $data->next;
            return $bankTransactions;

        }
    }
}
