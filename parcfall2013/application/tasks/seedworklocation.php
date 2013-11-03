<?php
class SeedWorkLocation_Task {
	public function run($args)
	{
		$workLocation = new WorkLocation;
		$workLocation->work_location_code = '8120';
		$workLocation->primary_work_location_name = 'Pioneer Adult Rehabilitation Center';
		$workLocation->primary_work_location_zip = '84015-1783';
		$workLocation->primary_work_location_type = 'At a NPA facility';
		$workLocation->primary_industry = 'Assembly/Manufacturing';
		$workLocation->save();
		
		$workLocation = new WorkLocation;
		$workLocation->work_location_code = '8122';
		$workLocation->primary_work_location_name = 'Building 891 (DISA)';
		$workLocation->primary_work_location_zip = '84056-5204';
		$workLocation->primary_work_location_type = 'At a government facility';
		$workLocation->primary_industry = 'Janitorial/Custodial';
		$workLocation->save();
		
		$workLocation = new WorkLocation;
		$workLocation->work_location_code = '8123';
		$workLocation->primary_work_location_name = 'URS';
		$workLocation->primary_work_location_zip = '84056-5204';
		$workLocation->primary_work_location_type = 'At a government facility';
		$workLocation->primary_industry = 'Warehousing/Shelf Stocking';
		$workLocation->save();
		
		$workLocation = new WorkLocation;
		$workLocation->work_location_code = '8124';
		$workLocation->primary_work_location_name = 'Tooele Army Depot/Deseret Chemical Depot';
		$workLocation->primary_work_location_zip = '84074-6062';
		$workLocation->primary_work_location_type = 'At a government facility';
		$workLocation->primary_industry = 'Janitorial/Custodial';
		$workLocation->save();
		
		$workLocation = new WorkLocation;
		$workLocation->work_location_code = '8126';
		$workLocation->primary_work_location_name = 'Part Sorting';
		$workLocation->primary_work_location_zip = '81015-1783';
		$workLocation->primary_work_location_type = 'At a NPA facility';
		$workLocation->primary_industry = 'Other';
		$workLocation->save();
		
		$workLocation = new WorkLocation;
		$workLocation->work_location_code = '8127';
		$workLocation->primary_work_location_name = 'Hill Air Force Base';
		$workLocation->primary_work_location_zip = '84056-5204';
		$workLocation->primary_work_location_type = 'At a government facility';
		$workLocation->primary_industry = 'Janitorial/Custodial';
		$workLocation->save();
		
		$workLocation = new WorkLocation;
		$workLocation->work_location_code = '8131';
		$workLocation->primary_work_location_name = 'North Davis Sewer District';
		$workLocation->primary_work_location_zip = '84075-6800';
		$workLocation->primary_work_location_type = 'In the community';
		$workLocation->primary_industry = 'Grounds Maintenance/Landscaping';
		$workLocation->save();
		
		$workLocation = new WorkLocation;
		$workLocation->work_location_code = '8133';
		$workLocation->primary_work_location_name = 'Brigham City Regional';
		$workLocation->primary_work_location_zip = '84302-3114';
		$workLocation->primary_work_location_type = 'At a government facility';
		$workLocation->primary_industry = 'Janitorial/Custodial';
		$workLocation->save();
		
		$workLocation = new WorkLocation;
		$workLocation->work_location_code = '8135';
		$workLocation->primary_work_location_name = 'Utah State Tax Commission';
		$workLocation->primary_work_location_zip = '84116-';
		$workLocation->primary_work_location_type = 'At a government facility';
		$workLocation->primary_industry = 'Janitorial/Custodial';
		$workLocation->save();
		
		$workLocation = new WorkLocation;
		$workLocation->work_location_code = '8136';
		$workLocation->primary_work_location_name = 'Pathways to Careers';
		$workLocation->primary_work_location_zip = '81015-1783';
		$workLocation->primary_work_location_type = 'In the community';
		$workLocation->primary_industry = 'Other';
		$workLocation->save();
		
		$workLocation = new WorkLocation;
		$workLocation->work_location_code = '8137';
		$workLocation->primary_work_location_name = 'Runway Ruby\'s';
		$workLocation->primary_work_location_zip = '84056-5204';
		$workLocation->primary_work_location_type = 'At a government facility';
		$workLocation->primary_industry = 'Food Service/Catering/Restaurant';
		$workLocation->save();
		

	}
}