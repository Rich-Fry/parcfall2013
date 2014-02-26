<?php

class SeedDB_Task {
	
	public function run($args)
	{
		Bundle::start('verify');
		Verify\Models\User::create(array(
				'username'=>'Employee',
				'password'=>'password',
				'role_id'=>1,
				'email'=>'Example@gmail.com',
				'verified'=>1
			));
		Verify\Models\Role::create(array(
				'name' => 'admin',
				'level' => 9,
				'description' => 'Administrators of PARC that approve new users to the system'
			));
		Verify\Models\Role::create(array(
				'name' => 'reportTemplateCreator',
				'level' => 8,
				'description' => 'generate report templates that are used later to generate reports'
			));
		Verify\Models\Role::create(array(
				'name' => 'reportGenerator',
				'level' => 7,
				'description' => 'generate reports from report templates'
			));
		Verify\Models\Role::create(array(
				'name' => 'employeeCreator',
				'level' => 6,
				'description' => 'create employees and clients'
			));
		Verify\Models\Role::create(array(
				'name' => 'unverified',
				'level' => 0,
				'description' => 'unverified users'
			));

						
			Verify\Models\Permission::create(array(
				'name' => 'userCreation',
				'description' => 'Create edit and verify new users'
			));
		// can be added in when reporting is finished
		// Verify\Models\Permission::create(array(
		// 		'name' => 'reportTemplateCreation',
		// 		'description' => 'creates report templates'
		// 	));
		// Verify\Models\Permission::create(array(
		// 		'name' => 'reportGeneration',
		// 		'description' => 'generates reports from templates'
		// 	));
		Verify\Models\Permission::create(array(
				'name' => 'employeeCreation',
				'description' => 'creates new employees and clients'
			));
		Verify\Models\Permission::create(array(
				'name' => 'categoryCreation',
				'description' => 'can create and edit tracked item categories and templates'
			));
		Verify\Models\Permission::create(array(
				'name' => 'trackedItemCreation',
				'description' => 'can create and edit tracked items'
			));
		Verify\Models\Permission::create(array(
				'name' => 'programCreation',
				'description' => 'can create and edit programs'
			));
		Verify\Models\Permission::create(array(
				'name' => 'roleCreation',
				'description' => 'can create and edit roles'
			));
		Verify\Models\Permission::create(array(
				'name' => 'employeeDeletion',
				'description' => 'can delete employees and clients'
			));
		Verify\Models\Permission::create(array(
				'name' => 'categoryDeletion',
				'description' => 'can delete tracked item categories and templates'
			));
		Verify\Models\Permission::create(array(
				'name' => 'trackedItemDeletion',
				'description' => 'can delete tracked items'
			));
		Verify\Models\Permission::create(array(
				'name' => 'programDeletion',
				'description' => 'can delete programs'
			));
		Verify\Models\Permission::create(array(
				'name' => 'userDeletion',
				'description' => 'delete/disable users'
			));
		Verify\Models\Permission::create(array(
				'name' => 'roleDeletion',
				'description' => 'can delete roles'
			));
		$r = Verify\Models\Role::where('name', '=', 'admin')->get();
		$p = Verify\Models\Permission::all();
		foreach ($p as $perm) {
			$r[0]->permissions()->attach($perm->id);
		}
		$r = Verify\Models\Role::where('name', '=', 'Super Admin')->get();
		$p = Verify\Models\Permission::all();
		foreach ($p as $perm) {
			$r[0]->permissions()->attach($perm->id);
		}
		// can be added in when reporting is finished
		// $r = Verify\Models\Role::where('name', '=', 'reportTemplateCreator')->get();
		// $p = Verify\Models\Permission::where('name', '!=', 'userCreation')->get();
		// foreach ($p as $perm) {
		// 	$r[0]->permissions()->attach($perm->id);	
		// }
		// $r = Verify\Models\Role::where('name', '=', 'reportGenerator')->get();
		// $p = Verify\Models\Permission::where('name', '!=', 'userCreation')->where('name', '!=', 'reportTemplateCreation')->get();
		// foreach ($p as $perm) {
		// 	$r[0]->permissions()->attach($perm->id);	
		// }
		$r = Verify\Models\Role::where('name', '=', 'employeeCreator')->get();
		$p = Verify\Models\Permission::where('name', '=', 'employeeCreation')->get();
		foreach ($p as $perm) {
			$r[0]->permissions()->attach($perm->id);	
		}
		Employee::create(array(
				'firstName' => 'John',
				'lastName' => 'Doe',
				'client' => 0,
			)
		);
		Employee::create(array(
				'firstName' => 'Jane',
				'lastName' => 'Doe',
				'client' => 1,
			)
		);
		Program::create(array(
				'programName' => 'General',
				'programDescription' => 'Used for any forms that all clients and employees will need to fill out'
			));
		Program::create(array(
				'programName' => 'General Employee',
				'programDescription' => 'Used for any forms that all employees will need to fill out'
			));
		Program::create(array(
				'programName' => 'General Client',
				'programDescription' => 'Used for any forms that all clients will need to fill out'
			));
		Program::create(array(
				'programName' => 'Community Employed',
				'programDescription' => 'Clients employeed by different companies in the community.  These clients have job coaches to help them retain their job in a competitive work environment.'
			));
		Program::create(array(
				'programName' => 'Human Resources',
				'programDescription' => 'Program for people who work in HR.'
			));
	}	
}
