<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('sanitize_redirect')) {
	function sanitize_redirect(?string $target): ?string
	{
		if ($target === null) {
			return null;
		}

		$candidate = rawurldecode($target);
		$candidate = trim($candidate);

		if ($candidate === '') {
			return null;
		}

		if (! str_starts_with($candidate, '/') || str_starts_with($candidate, '//') || strpos($candidate, '://') !== false) {
			return null;
		}

		return $candidate;
	}
}
