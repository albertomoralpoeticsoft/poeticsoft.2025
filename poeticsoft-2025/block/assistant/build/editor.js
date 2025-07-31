/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./poeticsoft-2025/block/assistant/block.json":
/*!****************************************************!*\
  !*** ./poeticsoft-2025/block/assistant/block.json ***!
  \****************************************************/
/***/ ((module) => {

module.exports = /*#__PURE__*/JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"poeticsoft/assistant","title":"Assistant","category":"poeticsoft","icon":"id-alt","description":"Parametrización de diálogo con AI Api","keywords":[],"textdomain":"poeticsoft","version":"1.0.0","attributes":{"preprompt":{"type":"string"},"prompt":{"type":"string"}},"supports":{"align":["wide","full","left","center","right"],"anchor":true,"ariaLabel":true,"color":{"text":true,"background":true,"gradients":true,"link":true,"__experimentalDefaultControls":true},"customClassName":true,"dimensions":{"minHeight":true,"maxHeight":true,"minWidth":true,"maxWidth":true,"aspectRatio":true,"__experimentalDefaultControls":true},"html":false,"interactivity":{"interactive":true,"clientNavigation":true},"__experimentalBorder":{"radius":true,"width":true,"color":true,"style":true,"__experimentalDefaultControls":true},"__experimentalLayout":{"type":"constrained","contentSize":"720px","wideSize":"1100px","allowInheriting":true,"allowSizing":true,"__experimentalDefaultControls":true},"lock":true,"multiple":true,"reusable":true,"shadow":true,"spacing":{"margin":true,"padding":["top","bottom","left","right"],"blockGap":true,"__experimentalDefaultControls":true},"typography":{"fontSize":true,"lineHeight":true,"fontFamily":true,"fontStyle":true,"fontWeight":true,"textDecoration":true,"textTransform":true,"letterSpacing":true,"__experimentalDefaultControls":true}},"editorScript":"file:./build/editor.js","editorStyle":"file:./build/editor.css","viewScript":"file:./build/view.js","viewStyle":"file:./build/view.css","render":"file:./render.php"}');

/***/ }),

/***/ "./src/block/assistant/editor.scss":
/*!*****************************************!*\
  !*** ./src/block/assistant/editor.scss ***!
  \*****************************************/
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
/*!***************************************!*\
  !*** ./src/block/assistant/editor.js ***!
  \***************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var blocks_assistant_block_json__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! blocks/assistant/block.json */ "./poeticsoft-2025/block/assistant/block.json");
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./editor.scss */ "./src/block/assistant/editor.scss");
var __ = wp.i18n.__;
var registerBlockType = wp.blocks.registerBlockType;
var _wp$blockEditor = wp.blockEditor,
  useBlockProps = _wp$blockEditor.useBlockProps,
  RichText = _wp$blockEditor.RichText,
  InnerBlocks = _wp$blockEditor.InnerBlocks;
var _wp$components = wp.components,
  TextControl = _wp$components.TextControl,
  TextareaControl = _wp$components.TextareaControl,
  Button = _wp$components.Button;


var Edit = function Edit(props) {
  var blockProps = useBlockProps();
  var allowedblocks = ['core/heading', 'core/paragraph', 'core/list', 'core/list-item'];
  return /*#__PURE__*/React.createElement("div", blockProps, /*#__PURE__*/React.createElement("div", {
    className: "PrePrompt"
  }, /*#__PURE__*/React.createElement(TextareaControl, {
    label: "Pre Prompt",
    value: props.attributes.preprompt,
    onChange: function onChange(newValue) {
      return props.setAttributes({
        preprompt: newValue
      });
    },
    help: "Texto de ayuda para el usuario.",
    rows: "5",
    placeholder: "Informaci\xF3n sobre la doc que vamos a proporcionar..."
  })), /*#__PURE__*/React.createElement("div", {
    className: "Context"
  }, /*#__PURE__*/React.createElement("div", {
    className: "Label"
  }, "Documentaci\xF3n total sobre el tema"), /*#__PURE__*/React.createElement("div", {
    className: "Content"
  }, /*#__PURE__*/React.createElement(InnerBlocks, {
    allowedBlocks: allowedblocks
  }))), /*#__PURE__*/React.createElement("div", {
    className: "Prompt"
  }, /*#__PURE__*/React.createElement(TextareaControl, {
    label: "Prompt",
    value: props.attributes.prompt,
    onChange: function onChange(newValue) {
      return props.setAttributes({
        prompt: newValue
      });
    },
    help: "Texto de ayuda para el usuario.",
    rows: "5",
    placeholder: "Informaci\xF3n sobre lo que esperamos que haga el asistente..."
  })));
};
registerBlockType(blocks_assistant_block_json__WEBPACK_IMPORTED_MODULE_0__.name, {
  edit: Edit,
  save: function save() {
    return null;
  }
});
})();

/******/ })()
;
//# sourceMappingURL=editor.js.map