<?php

namespace Verify\Models;

class Comboboxfield extends EloquentVerifyBase
{	
	public static $accessible = array('formQuestion_id', 'roles_id', 'comboValue');

}