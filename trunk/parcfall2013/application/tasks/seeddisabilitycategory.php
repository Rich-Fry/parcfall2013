<?php
class SeedDisabilityCategory_Task {
	public function run($args) {
		
		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'ID - Mild';
		$disabilityCategory -> ers_disability_category = 'ID - Mild';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'ID - Moderate';
		$disabilityCategory -> ers_disability_category = 'ID - Moderate';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'ID - Severe';
		$disabilityCategory -> ers_disability_category = 'ID - Severe';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Borderline intellectual functioning';
		$disabilityCategory -> ers_disability_category = 'Borderline intellectual functioning';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Learning Disability';
		$disabilityCategory -> ers_disability_category = 'Learning Disability';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Autism spectrum disorders';
		$disabilityCategory -> ers_disability_category = 'Autism spectrum disorders';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Other neurological impairments';
		$disabilityCategory -> ers_disability_category = 'Other neurological impairments';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Other developmental disabilities';
		$disabilityCategory -> ers_disability_category = 'Other developmental disabilities';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Traumatic brain injury';
		$disabilityCategory -> ers_disability_category = 'Traumatic brain injury';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Mental illness - mood and affective disorders, schizophrenia';
		$disabilityCategory -> ers_disability_category = 'Mental illness - mood and affective disorders, schizophrenia';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Mental illness - other';
		$disabilityCategory -> ers_disability_category = 'Mental illness - other';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Legal blindness';
		$disabilityCategory -> ers_disability_category = 'Legal blindness';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Visual impairment, other than legal blindness';
		$disabilityCategory -> ers_disability_category = 'Visual impairment, other than legal blindness';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Hearing impairment';
		$disabilityCategory -> ers_disability_category = 'Hearing impairment';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Cerebral plasy';
		$disabilityCategory -> ers_disability_category = 'Cerebral plasy';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Diseases of the musculoskeletal system and connective tissue; includes arthritis';
		$disabilityCategory -> ers_disability_category = 'Diseases of the musculoskeletal system and connective tissue; includes arthritis';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Endrocrine, nutritional, and metabolic diseases; includes diabetes and immune system diseases';
		$disabilityCategory -> ers_disability_category = 'Endrocrine, nutritional, and metabolic diseases; includes diabetes and immune system diseases';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Other physical disorders; includes injuries and congenital abnormalities';
		$disabilityCategory -> ers_disability_category = 'Other physical disorders; includes injuries and congenital abnormalities';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Substance abuse/alcoholism';
		$disabilityCategory -> ers_disability_category = 'Substance abuse/alcoholism';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Other severe disabilities';
		$disabilityCategory -> ers_disability_category = 'Other severe disabilities';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Other disabilities, not meeting the standard for severe';
		$disabilityCategory -> ers_disability_category = 'Other disabilities, not meeting the standard for severe';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'No disability';
		$disabilityCategory -> ers_disability_category = 'No disability';
		$disabilityCategory -> save();

		$disabilityCategory = new DisabilityCategory;
		$disabilityCategory -> npa_disability_category = 'Not known';
		$disabilityCategory -> ers_disability_category = 'Not known';
		$disabilityCategory -> save();

	}

}
