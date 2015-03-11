<?php

namespace ShineUnited\TagManager\Message\AdWords;

use ShineUnited\TagManager\Message\Message;
use Symfony\Component\OptionsResolver\OptionsResolver;


class DynamicRemarketingMessage extends Message {

	public function __construct(array $data = []) {
		$resolver = new OptionsResolver();
		$resolver->setOptional([
			//Education
			'edu_pid',
			'edu_plocid',
			'edu_pagetype',
			'edu_totalvalue',

			//Flights
			'flight_destid',
			'flight_originid',
			'flight_pagetype',
			'flight_startdate',
			'flight_enddate',
			'flight_totalvalue',

			//Hotels and rentals
			'hrental_id',
			'hrental_pagetypes',
			'hrental_startdate',
			'hrental_enddate',
			'hrental_totalvalue',

			//Jobs
			'job_id',
			'job_locid',
			'job_pagetype',
			'job_totalvalue',

			//Local deals
			'local_dealid',
			'local_pagetype',
			'local_totalvalue',

			//Real estate
			'listing_id',
			'listing_pagetype',
			'listing_totalvalue',

			//Retail
			'ecomm_prodid',
			'ecomm_pagetype',
			'ecomm_totalvalue',

			//Travel
			'travel_destid',
			'travel_originid',
			'travel_pagetype',
			'travel_startdate',
			'travel_enddate',
			'travel_totalvalue'

			//Custom
			'dynx_itemid',
			'dynx_itemid2',
			'dynx_pagetype',
			'dynx_totalvalue'
		]);

		$data = $resolver->resolve($data);

		parent::__construct($data);
	}
}
