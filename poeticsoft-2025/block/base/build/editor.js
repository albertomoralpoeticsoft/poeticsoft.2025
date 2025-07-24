/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./poeticsoft-2025/block/base/block.json":
/*!***********************************************!*\
  !*** ./poeticsoft-2025/block/base/block.json ***!
  \***********************************************/
/***/ ((module) => {

module.exports = /*#__PURE__*/JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"poeticsoft/base","title":"Base","category":"poeticsoft","icon":"share-alt","description":"Este bloque incluye scripts y estilos para frontend y editor.","keywords":[],"textdomain":"poeticsoft","version":"1.0.0","supports":{"align":["wide","full","left","center","right"],"anchor":true,"ariaLabel":true,"color":{"text":true,"background":true,"gradients":true,"link":true,"__experimentalDefaultControls":true},"customClassName":true,"dimensions":{"minHeight":true,"maxHeight":true,"minWidth":true,"maxWidth":true,"aspectRatio":true,"__experimentalDefaultControls":true},"html":false,"interactivity":{"interactive":true,"clientNavigation":true},"__experimentalBorder":{"radius":true,"width":true,"color":true,"style":true,"__experimentalDefaultControls":true},"__experimentalLayout":{"type":"constrained","contentSize":"720px","wideSize":"1100px","allowInheriting":true,"allowSizing":true,"__experimentalDefaultControls":true},"lock":true,"multiple":true,"reusable":true,"shadow":true,"spacing":{"margin":true,"padding":["top","bottom","left","right"],"blockGap":true,"__experimentalDefaultControls":true},"typography":{"fontSize":true,"lineHeight":true,"fontFamily":true,"fontStyle":true,"fontWeight":true,"textDecoration":true,"textTransform":true,"letterSpacing":true,"__experimentalDefaultControls":true}},"editorScript":"file:./build/editor.js","editorStyle":"file:./build/editor.css","viewScript":"file:./build/view.js","viewStyle":"file:./build/view.css"}');

/***/ }),

/***/ "./src/block/base/editor.scss":
/*!************************************!*\
  !*** ./src/block/base/editor.scss ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!**********************************!*\
  !*** ./src/block/base/editor.js ***!
  \**********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var blocks_base_block_json__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! blocks/base/block.json */ "./poeticsoft-2025/block/base/block.json");
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./editor.scss */ "./src/block/base/editor.scss");
var __ = wp.i18n.__;
var registerBlockType = wp.blocks.registerBlockType;
var useBlockProps = wp.blockEditor.useBlockProps;


var Edit = function Edit(props) {
  var blockProps = useBlockProps();
  return /*#__PURE__*/React.createElement("div", blockProps, "EDIT");
};
var Save = function Save(props) {
  var blockProps = useBlockProps.save();
  return /*#__PURE__*/React.createElement("div", blockProps, "SAVE");
};
registerBlockType(blocks_base_block_json__WEBPACK_IMPORTED_MODULE_0__.name, {
  edit: Edit,
  save: Save
});
})();

/******/ })()
;
//# sourceMappingURL=editor.js.map