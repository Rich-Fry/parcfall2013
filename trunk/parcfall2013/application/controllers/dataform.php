<?php

class DataForm_Controller extends Base_Controller 
{
	// Still needs to be implemented. At the moment we are creating forms by using tasks (see the application/tasks/seedform.php file to see what I mean)
	// This means that PARC cant create their own forms on the fly, but will need to contact us to do so.  The DB allows it to work without an issue, however
	// we weren't able to implement the UI in time, and it was lower on the priority list.  See the trackedtemplate controller for ideas on how this would be implemented
	// And the application/views/trackedCategory/manage.blade.php file for how the UI might be done (when creating a tracked category, you'd also be creating the template
	// for it, so that is why it is in that page instead of its own)
}