/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/settingspanel/telegram/admin.scss":
/*!***********************************************!*\
  !*** ./src/settingspanel/telegram/admin.scss ***!
  \***********************************************/
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
/*!*********************************************!*\
  !*** ./src/settingspanel/telegram/admin.js ***!
  \*********************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _admin_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./admin.scss */ "./src/settingspanel/telegram/admin.scss");

var poeticsoftMediaPublishTelegram = function poeticsoftMediaPublishTelegram($, postid) {
  var $MediaPublishTelegram = $('.poeticsoft-media-publish-telegram');
  if ($MediaPublishTelegram.length) {
    $MediaPublishTelegram.each(function () {
      var $this = $(this);
      var $selectchannel = $this.find('.selectchannel');
      var $publish = $this.find('.publish');
      fetch('/wp-json/poeticsoft/telegram/destinationlist').then(function (result) {
        return result.json().then(function (list) {
          var options = list.map(function (o) {
            return "<option value=\"".concat(o.value, "\" ").concat(o["default"] ? 'selected' : '', ">").concat(o.label, "</option>");
          }).join('');
          $selectchannel.html(options);
        });
      });
      $publish.on('click', function () {
        var $this = $(this);
        var destination = $selectchannel.val();
        $this.prop("disabled", true);
        $publish.html('Publicando...');
        fetch("/wp-json/poeticsoft/telegram/publishwp?type=media&destination=".concat(destination, "&postid=").concat(postid)).then(function (result) {
          return result.json().then(function (published) {
            console.log(published);
            $this.prop("disabled", false);
            $publish.html('Publicar');
          });
        });
      });
    });
  }
};
window.poeticsoftMediaPublishTelegram = function (postid) {
  poeticsoftMediaPublishTelegram(jQuery, postid);
};
})();

/******/ })()
;
//# sourceMappingURL=admin.js.map