<?php

function to_bool($variable) {
	if (is_bool($variable)) {
		return $variable;
	}
	if (is_numeric($variable)) {
		return (bool) $variable;
	}
	if (is_string($variable)) {
		$lower_var = strtolower(trim($variable));
		if (in_array($lower_var, ['true', 'yes', 'on', '1'])) {
			return true;
		}
		if (in_array($lower_var, ['false', 'no', 'off', '0', 'null', ''])) {
			return false;
		}
	}
	// Для всех остальных случаев (массивы, объекты и т.д.)
	return (bool) $variable;
}

?>