Usage:

	$cg = new \GoToHr\SimpleCodeGen\CodeGenerator(array(
		'ns' => 'simple\\testns',
		'classes' => array (
			'Hello' => array(
				'properties' => array(
					'first' => array('type' => 'string'),
					'second' => array('type' => 'int'),
				),
				'methods' => array(
					'call_me' => array(),
					'sometimes' => array(
						'params' => array(
							'there' => array(),
							'here' => array('default' => 'null')
						)
					)
				)
			),
			'World' => array(
				'extends' => '\\simple\\testns\\Hello',
				'properties' => array(
					'fun' => array('type' => 'string'),
					'stuff' => array('type' => 'int'),
				)
			)
		)
	));

	$cg->generate();

	// or this way...

	$ct = new \GoToHr\SimpleCodeGen\ClassTemplate('test', 'testns');
	$ct->addProperty('first', 'string');
	//$ct->write();
	echo $ct;
