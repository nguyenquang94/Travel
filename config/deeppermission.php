<?php

return array(
	"CNF_REQUIRE_ANUM" => array("required" => TRUE, "pattern" => "[a-zA-Z][a-zA-Z0-9\s]*", "title" => "Only alphanumeric character allowed"),
	"CNF_REQUIRE_ANUM_AND_POINT" => array("required" => TRUE, "pattern" => "[a-zA-Z][a-zA-Z0-9\s._]*", "title" => "Only alphanumeric character allowed"),

	// Allow auto add the new permission / permission group to databse.

	"autofill" => true,
);
