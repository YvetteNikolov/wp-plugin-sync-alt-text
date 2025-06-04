<?php
/**
 * Plugin Name:       Sync Alt Text
 * Description:       Syncs alt text from image blocks to image attachment metadata.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            Yvette Nikolov
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sync-alt-text
 *
 * @package SyncAltText
 */

defined( 'ABSPATH' ) || exit;

add_action( 'save_post', 'sync_alt_text_on_save_post', 10, 3 );

/**
 * Sync alt text from media blocks to the image's attachment metadata on post save.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 * @param bool    $update  Whether this is an existing post being updated.
 *
 * @return void
 */
function sync_alt_text_on_save_post( $post_id, $post, $update ) {
	$blocks = parse_blocks( $post->post_content );

	process_image_blocks_recursively( $blocks );
}

/**
 * Recursively process Gutenberg blocks to update image attachment alt text metadata.
 *
 * @param array $blocks Array of parsed blocks.
 *
 * @return void
 */
function process_image_blocks_recursively( array $blocks ) {
	foreach ( $blocks as $block ) {
		$attrs      = $block['attrs'] ?? array();
		$block_name = $block['blockName'] ?? '';

		$image_id = null;

		// Determine the correct attribute for the image ID based on block type.
		if ( in_array( $block_name, array( 'core/image', 'core/cover' ), true ) && isset( $attrs['id'] ) ) {
			$image_id = (int) $attrs['id'];
		} elseif ( 'core/media-text' === $block_name && isset( $attrs['mediaId'] ) ) {
			$image_id = (int) $attrs['mediaId'];
		}

		// Extract and update alt text if an image ID and inner HTML exist.
		if ( $image_id && ! empty( $block['innerHTML'] ) ) {
			$alt_text = extract_alt_from_block( $block );

			if ( ! empty( $alt_text ) ) {
				update_post_meta( $image_id, '_wp_attachment_image_alt', sanitize_text_field( $alt_text ) );
			}
		}

		// Recursively process nested blocks.
		if ( ! empty( $block['innerBlocks'] ) ) {
			process_image_blocks_recursively( $block['innerBlocks'] );
		}
	}
}

/**
 * Extract the alt text from the first <img> tag found in a block's innerHTML.
 *
 * @param array $block A parsed Gutenberg block.
 *
 * @return string The alt text, or an empty string if not found.
 */
function extract_alt_from_block( array $block ) {
	$html = $block['innerHTML'] ?? '';

	if ( empty( $html ) ) {
		return '';
	}

	libxml_use_internal_errors( true );

	$dom = new DOMDocument();
	$dom->loadHTML( mb_convert_encoding( $html, 'HTML-ENTITIES', 'UTF-8' ) );
	libxml_clear_errors();

	$xpath = new DOMXPath( $dom );
	$img   = $xpath->query( '//img' )->item( 0 );

	if ( $img && $img->hasAttribute( 'alt' ) ) {
		return $img->getAttribute( 'alt' );
	}

	return '';
}
