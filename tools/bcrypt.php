<?php

	$password = $argv[1];
	 
	// salt for bcrypt needs to be 22 base64 characters (but just [./0-9A-Za-z]), see http://php.net/crypt
	// just an example; please use something more secure/random than sha1(microtime) :)
	$salt = substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22);
	 
	// 2a is the bcrypt algorithm selector, see http://php.net/crypt
	// 12 is the workload factor (around 300ms on my Core i7 machine), see http://php.net/crypt
	$newhash = crypt($password, '$2a$12$' . $salt);

	echo $newhash."\n";