/******/ (() => { // webpackBootstrap
/*!************************************!*\
  !*** ./src/sync-alt-text/index.js ***!
  \************************************/
console.log('Sync Alt Text');

/**
 * Sync Alt Text – Gutenberg Editor Notes & Edge Cases
 *
 * 1. On Editor Load:
 *    - Query all blocks (`core/image`, `core/media-text`, `core/cover`, `core/gallery`) recursively.
 *    - For each image block, fetch the image metadata via REST API (or via `wp.data.select('core')`).
 *    - If alt text in `innerHTML` differs from the image's stored alt, update it accordingly.
 
 * 2. On Post Save:
 *    - Iterate over all blocks again and build a map of image ID => alt text from the editor content.
 *    - If the same image is used with different alt texts, use the last one found.
 
 * 3. General Edge Cases:
 *    - Media blocks with missing image IDs (e.g., copied raw HTML or malformed).
 *    - Temporary image placeholders (e.g., when uploading, the ID is not yet available).
 *    - Avoid causing infinite update loops or triggering multiple REST updates per image.
 
 * 4. Performance Considerations:
 *    - Batch metadata fetches where possible.
 *    - Debounce updates if syncing live during editing.
 *    - Use selectors efficiently to avoid scanning the full DOM multiple times.
 
 * Next step:
 * - Scaffold a `@wordpress/plugins` plugin that hooks into `editor.PostEditor` or `@wordpress/data` selectors.
 * - Implement syncing logic on editor load and on `core/editor` save.
 */
/******/ })()
;
//# sourceMappingURL=index.js.map