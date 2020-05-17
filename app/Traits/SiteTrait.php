<?php

namespace App\Traits;

use App\User;
use App\Site;

trait SiteTrait {
    public function getSites(User $user)
    {
        //Show form to add new Sites
        if($user->isSuperAdmin()){
        	$sites = \App\Site::pluck('name', 'id')->toArray();
	    }
	    else{
			$sites = \App\Site::where('id', $user->site->id)->pluck('name', 'id')->toArray();
	    }

	    return $sites;

    }

    public function getDepartments(User $user)
    {
        //Show form to add new Sites
        if($user->isSuperAdmin()){
            $departments = \App\Department::pluck('name', 'id')->toArray();
        }
        else{
            $departments = \App\Department::where('id', $user->site->id)->pluck('name', 'id')->toArray();
        }

        return $departments;

    }

}