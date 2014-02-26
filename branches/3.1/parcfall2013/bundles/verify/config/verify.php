<?php

return array(

	// The db column to authenticate against
	'username'				=> array('email', 'username'),

	// The User mode to use
	'user_model'			=> 'Verify\Models\User',
	
	// The PermissionView model to use
	'permissionview_model'	=> 'Verify\Models\PermissionView',

	// The Super Admin role
	// (returns true for all permissions)
	'super_admin'			=> 'Super Admin',

	// DB prefix for tables
	// NO '_' NECESSARY, e.g. use 'verify' for 'verify_users'
	'prefix'				=> ''

);