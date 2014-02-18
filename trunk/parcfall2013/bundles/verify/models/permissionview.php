<?php

namespace Verify\Models;

class PermissionView extends EloquentVerifyBase
{
	public static $table = 'permissionview';
	public static $to_check_cache;

	public function rolesRequired($objectid)
	{
		if(is_null($objectid))
		{
			$this->to_check_cache = NULL;
		}
		else if(empty($this->to_check_cache))
		{
			$to_check = array();
			$permissionids = array();
			$permissionViewObject = PermissionView::select('permissionview.permission_id as permission_id')->where('permissionview.objectid','=', $objectid)->get();
			foreach ($permissionViewObject as $key => $value) {
				$permissionids[] = $value->permission_id;
			}
			
			if(array_count_values($permissionids) > 0)
			{
				foreach ($permissionids as $key => $value) {
					$permissionobject = Permission::select('permissions.name as name')->where('permissions.id','=', $value)->get();
					$to_check[] = $permissionobject[0]->name;
				}
			}

			$this->to_check_cache = $to_check;
		}

		return $this->to_check_cache;
	}

}