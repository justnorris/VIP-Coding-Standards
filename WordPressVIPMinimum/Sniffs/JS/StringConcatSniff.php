<?php
/**
 * WordPressVIPMinimum_Sniffs_Files_IncludingFileSniff.
 *
 * @package VIPCS\WordPressVIPMinimum
 */

namespace WordPressVIPMinimum\Sniffs\JS;

use PHP_CodeSniffer_File as File;
use PHP_CodeSniffer_Tokens as Tokens;

/**
 * WordPressVIPMinimum_Sniffs_JS_StringConcatSniff.
 *
 * Looks for HTML string concatenation.
 *
 * @package VIPCS\WordPressVIPMinimum
 */
class StringConcatSniff implements \PHP_CodeSniffer_Sniff {

	/**
	 * A list of tokenizers this sniff supports.
	 *
	 * @var array
	 */
	public $supportedTokenizers = array(
		'JS',
	);

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			T_PLUS,
		);

	}//end register()


	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
	 * @param int                         $stackPtr  The position of the current token in the
	 *                                               stack passed in $tokens.
	 *
	 * @return void
	 */
	public function process( File $phpcsFile, $stackPtr ) {
		$tokens = $phpcsFile->getTokens();

		$nextToken = $phpcsFile->findNext( Tokens::$emptyTokens, ( $stackPtr + 1 ), null, true, null, true );

		if ( T_CONSTANT_ENCAPSED_STRING === $tokens[ $nextToken ]['code'] ) {
			if ( false !== strpos( $tokens[ $nextToken ]['content'], '<' ) && 1 === preg_match( '/\<\/[a-zA-Z]+/', $tokens[ $nextToken ]['content'] ) ) {
				$phpcsFile->addError( sprintf( 'HTML string concatenation detected %s', '+' . $tokens[ $nextToken ]['content'] ), $stackPtr, 'StringConcatNext' );
			}
		}

		$prevToken = $phpcsFile->findPrevious( Tokens::$emptyTokens, ( $stackPtr - 1 ), null, true, null, true );

		if ( T_CONSTANT_ENCAPSED_STRING === $tokens[ $prevToken ]['code'] ) {
			if ( false !== strpos( $tokens[ $prevToken ]['content'], '<' ) && 1 === preg_match( '/\<[a-zA-Z]+/', $tokens[ $prevToken ]['content'] ) ) {
				$phpcsFile->addError( sprintf( 'HTML string concatenation detected: %s', $tokens[ $prevToken ]['content'] . '+' ), $stackPtr, 'StringConcatNext' );
			}
		}
	}//end process()

}//end class
