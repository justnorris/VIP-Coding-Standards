<?php
/**
 * WordPressVIPMinimum Coding Standard.
 *
 * @package VIPCS\WordPressVIPMinimum
 */

namespace WordPressVIPMinimum\Sniffs\VIP;

/**
 * Flag REGEXP and NOT REGEXP in meta compare
 *
 * @package VIPCS\WordPressVIPMinimum
 */
class RemoteRequestTimeoutSniff extends \WordPress\AbstractArrayAssignmentRestrictionsSniff {

	/**
	 * Groups of variables to restrict.
	 * This should be overridden in extending classes.
	 *
	 * Example: groups => array(
	 *     'wpdb' => array(
	 *         'type'          => 'error' | 'warning',
	 *         'message'       => 'Dont use this one please!',
	 *         'variables'     => array( '$val', '$var' ),
	 *         'object_vars'   => array( '$foo->bar', .. ),
	 *         'array_members' => array( '$foo['bar']', .. ),
	 *     )
	 * )
	 *
	 * @return array
	 */
	public function getGroups() {
		return array(
			'timeout' => array(
				'type' => 'error',
				'keys' => array(
					'timeout',
				),
			),
		);
	}

	/**
	 * Callback to process each confirmed key, to check value.
	 * This must be extended to add the logic to check assignment value.
	 *
	 * @param  string $key   Array index / key.
	 * @param  mixed  $val   Assigned value.
	 * @param  int    $line  Token line.
	 * @param  array  $group Group definition.
	 * @return mixed         FALSE if no match, TRUE if matches, STRING if matches
	 *                       with custom error message passed to ->process().
	 */
	public function callback( $key, $val, $line, $group ) {
		if ( intval( $val ) > 3 ) {
			return 'Detected high remote request timeout. `%s` is set to `%d`.';
		}
	}

} // End class.
