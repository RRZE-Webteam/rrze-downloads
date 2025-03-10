/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/components/QueryControls.tsx":
/*!******************************************!*\
  !*** ./src/components/QueryControls.tsx ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   CustomQueryControls: function() { return /* binding */ CustomQueryControls; }\n/* harmony export */ });\n/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react/jsx-runtime */ \"react/jsx-runtime\");\n/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/data */ \"@wordpress/data\");\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ \"@wordpress/components\");\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);\n\n\n\nvar CustomQueryControls = function CustomQueryControls(_ref) {\n  var attributes = _ref.attributes,\n    setAttributes = _ref.setAttributes;\n  var _useSelect = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useSelect)(function (select) {\n      var _select = select(\"core\"),\n        getEntityRecords = _select.getEntityRecords;\n      return {\n        categories: getEntityRecords(\"attachement\", \"category\")\n      };\n    }, []),\n    categories = _useSelect.categories;\n  var cat = attributes.cat || \"\";\n  var categorySuggestions = categories ? categories.reduce(function (acc, category) {\n    acc[category.slug] = category;\n    return acc;\n  }, {}) : {};\n  var selectedCategorySlugs = cat.split(\",\");\n  var selectedCategories = categories ? categories.filter(function (category) {\n    return selectedCategorySlugs.includes(category.slug);\n  }).map(function (_ref2) {\n    var id = _ref2.id,\n      name = _ref2.name,\n      parent = _ref2.parent;\n    return {\n      id: id,\n      name: name,\n      parent: parent\n    };\n  }) : [];\n  var onCategoryChange = function onCategoryChange(newValue) {\n    var currentCategorySlugs = cat.toLowerCase().split(\",\").filter(Boolean);\n    var newValueSlugs = (Array.isArray(newValue) ? newValue : [newValue]).map(function (item) {\n      var _a;\n      var slug = typeof item === \"string\" ? item : (_a = categories.find(function (category) {\n        return category.id === item.id;\n      })) === null || _a === void 0 ? void 0 : _a.slug;\n      return categories.find(function (category) {\n        return category.slug === slug;\n      }) ? slug : null;\n    }).filter(function (slug) {\n      return slug;\n    });\n    currentCategorySlugs = currentCategorySlugs.filter(function (slug) {\n      return newValueSlugs.includes(slug);\n    });\n    newValueSlugs.forEach(function (slug) {\n      if (!currentCategorySlugs.includes(slug)) {\n        currentCategorySlugs.push(slug);\n      }\n    });\n    setAttributes({\n      cat: currentCategorySlugs.join(\",\")\n    });\n  };\n  return (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.QueryControls, {\n    categorySuggestions: categorySuggestions,\n    numberOfItems: attributes.num,\n    onCategoryChange: onCategoryChange,\n    onNumberOfItemsChange: function onNumberOfItemsChange(value) {\n      return setAttributes({\n        num: value\n      });\n    },\n    selectedCategories: selectedCategories,\n    minItems: 1,\n    maxItems: 15\n  });\n};\n//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,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STtJQUFBLEVBQUM7SUFFekJhLG9CQUFvQixHQUFHQSxvQkFBb0IsQ0FBQ1QsTUFBTSxDQUFDLFVBQUNKLElBQUk7TUFBQSxPQUN0RGdCLGFBQWEsQ0FBQ1gsUUFBUSxDQUFDTCxJQUFJLENBQUM7SUFBQSxFQUM3QjtJQUNEZ0IsYUFBYSxDQUFDTSxPQUFPLENBQUMsVUFBQ3RCLElBQUksRUFBSTtNQUM3QixJQUFJLENBQUNhLG9CQUFvQixDQUFDUixRQUFRLENBQUNMLElBQUksQ0FBQyxFQUFFO1FBQ3hDYSxvQkFBb0IsQ0FBQ1UsSUFBSSxDQUFDdkIsSUFBSSxDQUFDO01BQ2pDO0lBQ0YsQ0FBQyxDQUFDO0lBRUZYLGFBQWEsQ0FBQztNQUFFTSxHQUFHLEVBQUVrQixvQkFBb0IsQ0FBQ1csSUFBSSxDQUFDLEdBQUc7SUFBQyxDQUFFLENBQUM7RUFDeEQsQ0FBQztFQUVELE9BQ0VDLHNEQUFBLENBQUN4QyxnRUFBYTtJQUNaVyxtQkFBbUIsRUFBRUEsbUJBQW1CO0lBQ3hDOEIsYUFBYSxFQUFFdEMsVUFBVSxDQUFDdUMsR0FBRztJQUM3QmhCLGdCQUFnQixFQUFFQSxnQkFBZ0I7SUFDbENpQixxQkFBcUIsRUFBRSxTQUF2QkEscUJBQXFCQSxDQUFHQyxLQUFLO01BQUEsT0FBS3hDLGFBQWEsQ0FBQztRQUFFc0MsR0FBRyxFQUFFRTtNQUFLLENBQUUsQ0FBQztJQUFBO0lBQy9EMUIsa0JBQWtCLEVBQUVBLGtCQUFrQjtJQUN0QzJCLFFBQVEsRUFBSSxDQUFDO0lBQ2JDLFFBQVEsRUFBSTtFQUFFLEVBQ2Q7QUFFTixDQUFDIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vcnJ6ZS1kb3dubG9hZHMvLi9zcmMvY29tcG9uZW50cy9RdWVyeUNvbnRyb2xzLnRzeD81MTU5Il0sInNvdXJjZXNDb250ZW50IjpbImltcG9ydCB7IHVzZVNlbGVjdCB9IGZyb20gXCJAd29yZHByZXNzL2RhdGFcIjtcbmltcG9ydCB7IFF1ZXJ5Q29udHJvbHMgfSBmcm9tIFwiQHdvcmRwcmVzcy9jb21wb25lbnRzXCI7XG5cbnR5cGUgQ3VzdG9tUXVlcnlDb250cm9sc1Byb3BzID0ge1xuICBhdHRyaWJ1dGVzOiB7XG4gICAgY2F0OiBzdHJpbmc7XG4gICAgbnVtOiBudW1iZXI7XG4gIH07XG4gIHNldEF0dHJpYnV0ZXM6IChhdHRyaWJ1dGVzOiBQYXJ0aWFsPEN1c3RvbVF1ZXJ5Q29udHJvbHNQcm9wc1tcImF0dHJpYnV0ZXNcIl0+KSA9PiB2b2lkO1xufTtcblxuaW50ZXJmYWNlIENhdGVnb3J5IHtcbiAgc2x1Zzogc3RyaW5nO1xuICBuYW1lOiBzdHJpbmc7XG4gIGlkOiBudW1iZXI7XG4gIGNvdW50OiBudW1iZXI7XG4gIGxpbms6IHN0cmluZztcbiAgcGFyZW50OiBudW1iZXI7XG4gIHRheG9ub215OiBzdHJpbmc7XG59XG5cbmNvbnN0IEN1c3RvbVF1ZXJ5Q29udHJvbHMgPSAoe1xuICBhdHRyaWJ1dGVzLFxuICBzZXRBdHRyaWJ1dGVzLFxufTogQ3VzdG9tUXVlcnlDb250cm9sc1Byb3BzKSA9PiB7XG4gIGNvbnN0IHsgY2F0ZWdvcmllcyB9ID0gdXNlU2VsZWN0KChzZWxlY3QpID0+IHtcbiAgICBjb25zdCB7IGdldEVudGl0eVJlY29yZHMgfSA9IHNlbGVjdChcImNvcmVcIikgYXMge1xuICAgICAgZ2V0RW50aXR5UmVjb3JkczogKFxuICAgICAgICBlbnRpdHk/OiBzdHJpbmcsXG4gICAgICAgIHR5cGU/OiBzdHJpbmcsXG4gICAgICAgIHF1ZXJ5PzogeyBwZXJfcGFnZTogbnVtYmVyIH1cbiAgICAgICkgPT4gQ2F0ZWdvcnlbXTtcbiAgICB9O1xuICAgIHJldHVybiB7XG4gICAgICBjYXRlZ29yaWVzOiBnZXRFbnRpdHlSZWNvcmRzKFwiYXR0YWNoZW1lbnRcIiwgXCJjYXRlZ29yeVwiKSxcbiAgICB9O1xuICB9LCBbXSk7XG5cbiAgY29uc3QgY2F0ID0gYXR0cmlidXRlcy5jYXQgfHwgXCJcIjtcblxuICBjb25zdCBjYXRlZ29yeVN1Z2dlc3Rpb25zID0gY2F0ZWdvcmllc1xuICAgID8gY2F0ZWdvcmllcy5yZWR1Y2UoXG4gICAgICAgIChhY2MsIGNhdGVnb3J5KSA9PiB7XG4gICAgICAgICAgYWNjW2NhdGVnb3J5LnNsdWddID0gY2F0ZWdvcnk7XG4gICAgICAgICAgcmV0dXJuIGFjYztcbiAgICAgICAgfSxcbiAgICAgICAge30gYXMgUmVjb3JkPHN0cmluZywgQ2F0ZWdvcnk+XG4gICAgICApXG4gICAgOiB7fTtcblxuICBjb25zdCBzZWxlY3RlZENhdGVnb3J5U2x1Z3MgPSBjYXQuc3BsaXQoXCIsXCIpO1xuXG4gIGNvbnN0IHNlbGVjdGVkQ2F0ZWdvcmllcyA9IGNhdGVnb3JpZXNcbiAgICA/IGNhdGVnb3JpZXNcbiAgICAgICAgLmZpbHRlcigoY2F0ZWdvcnkpID0+IHNlbGVjdGVkQ2F0ZWdvcnlTbHVncy5pbmNsdWRlcyhjYXRlZ29yeS5zbHVnKSlcbiAgICAgICAgLm1hcCgoeyBpZCwgbmFtZSwgcGFyZW50IH0pID0+ICh7IGlkLCBuYW1lLCBwYXJlbnQgfSkpXG4gICAgOiBbXTtcblxuICBjb25zdCBvbkNhdGVnb3J5Q2hhbmdlID0gKFxuICAgIG5ld1ZhbHVlOiBzdHJpbmcgfCBBcnJheTxzdHJpbmcgfCB7IGlkOiBudW1iZXI7IHZhbHVlOiBzdHJpbmcgfT5cbiAgKSA9PiB7XG4gICAgbGV0IGN1cnJlbnRDYXRlZ29yeVNsdWdzID0gY2F0LnRvTG93ZXJDYXNlKCkuc3BsaXQoXCIsXCIpLmZpbHRlcihCb29sZWFuKTtcblxuICAgIGNvbnN0IG5ld1ZhbHVlU2x1Z3MgPSAoQXJyYXkuaXNBcnJheShuZXdWYWx1ZSkgPyBuZXdWYWx1ZSA6IFtuZXdWYWx1ZV0pXG4gICAgICAubWFwKChpdGVtKSA9PiB7XG4gICAgICAgIGNvbnN0IHNsdWcgPVxuICAgICAgICAgIHR5cGVvZiBpdGVtID09PSBcInN0cmluZ1wiXG4gICAgICAgICAgICA/IGl0ZW1cbiAgICAgICAgICAgIDogY2F0ZWdvcmllcy5maW5kKChjYXRlZ29yeSkgPT4gY2F0ZWdvcnkuaWQgPT09IGl0ZW0uaWQpPy5zbHVnO1xuICAgICAgICByZXR1cm4gY2F0ZWdvcmllcy5maW5kKChjYXRlZ29yeSkgPT4gY2F0ZWdvcnkuc2x1ZyA9PT0gc2x1ZylcbiAgICAgICAgICA/IHNsdWdcbiAgICAgICAgICA6IG51bGw7XG4gICAgICB9KVxuICAgICAgLmZpbHRlcigoc2x1ZykgPT4gc2x1Zyk7XG5cbiAgICBjdXJyZW50Q2F0ZWdvcnlTbHVncyA9IGN1cnJlbnRDYXRlZ29yeVNsdWdzLmZpbHRlcigoc2x1ZykgPT5cbiAgICAgIG5ld1ZhbHVlU2x1Z3MuaW5jbHVkZXMoc2x1ZylcbiAgICApO1xuICAgIG5ld1ZhbHVlU2x1Z3MuZm9yRWFjaCgoc2x1ZykgPT4ge1xuICAgICAgaWYgKCFjdXJyZW50Q2F0ZWdvcnlTbHVncy5pbmNsdWRlcyhzbHVnKSkge1xuICAgICAgICBjdXJyZW50Q2F0ZWdvcnlTbHVncy5wdXNoKHNsdWcpO1xuICAgICAgfVxuICAgIH0pO1xuXG4gICAgc2V0QXR0cmlidXRlcyh7IGNhdDogY3VycmVudENhdGVnb3J5U2x1Z3Muam9pbihcIixcIikgfSk7XG4gIH07XG5cbiAgcmV0dXJuIChcbiAgICA8UXVlcnlDb250cm9sc1xuICAgICAgY2F0ZWdvcnlTdWdnZXN0aW9ucz17Y2F0ZWdvcnlTdWdnZXN0aW9uc31cbiAgICAgIG51bWJlck9mSXRlbXM9e2F0dHJpYnV0ZXMubnVtfVxuICAgICAgb25DYXRlZ29yeUNoYW5nZT17b25DYXRlZ29yeUNoYW5nZX1cbiAgICAgIG9uTnVtYmVyT2ZJdGVtc0NoYW5nZT17KHZhbHVlKSA9PiBzZXRBdHRyaWJ1dGVzKHsgbnVtOiB2YWx1ZSB9KX1cbiAgICAgIHNlbGVjdGVkQ2F0ZWdvcmllcz17c2VsZWN0ZWRDYXRlZ29yaWVzfVxuICAgICAgbWluSXRlbXMgPSB7MX1cbiAgICAgIG1heEl0ZW1zID0gezE1fVxuICAgIC8+XG4gICk7XG59O1xuXG5leHBvcnQgeyBDdXN0b21RdWVyeUNvbnRyb2xzIH07XG4iXSwibmFtZXMiOlsidXNlU2VsZWN0IiwiUXVlcnlDb250cm9scyIsIkN1c3RvbVF1ZXJ5Q29udHJvbHMiLCJfcmVmIiwiYXR0cmlidXRlcyIsInNldEF0dHJpYnV0ZXMiLCJfdXNlU2VsZWN0Iiwic2VsZWN0IiwiX3NlbGVjdCIsImdldEVudGl0eVJlY29yZHMiLCJjYXRlZ29yaWVzIiwiY2F0IiwiY2F0ZWdvcnlTdWdnZXN0aW9ucyIsInJlZHVjZSIsImFjYyIsImNhdGVnb3J5Iiwic2x1ZyIsInNlbGVjdGVkQ2F0ZWdvcnlTbHVncyIsInNwbGl0Iiwic2VsZWN0ZWRDYXRlZ29yaWVzIiwiZmlsdGVyIiwiaW5jbHVkZXMiLCJtYXAiLCJfcmVmMiIsImlkIiwibmFtZSIsInBhcmVudCIsIm9uQ2F0ZWdvcnlDaGFuZ2UiLCJuZXdWYWx1ZSIsImN1cnJlbnRDYXRlZ29yeVNsdWdzIiwidG9Mb3dlckNhc2UiLCJCb29sZWFuIiwibmV3VmFsdWVTbHVncyIsIkFycmF5IiwiaXNBcnJheSIsIml0ZW0iLCJfYSIsImZpbmQiLCJmb3JFYWNoIiwicHVzaCIsImpvaW4iLCJfanN4IiwibnVtYmVyT2ZJdGVtcyIsIm51bSIsIm9uTnVtYmVyT2ZJdGVtc0NoYW5nZSIsInZhbHVlIiwibWluSXRlbXMiLCJtYXhJdGVtcyJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./src/components/QueryControls.tsx\n");

/***/ }),

/***/ "./src/downloads-block/block.json":
/*!****************************************!*\
  !*** ./src/downloads-block/block.json ***!
  \****************************************/
/***/ (function(module) {

module.exports = /*#__PURE__*/JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"name":"rrze-downloads/downloads","version":"2.2.13","title":"Downloads","category":"rrze","description":"Outputs a list of downloads from your WordPress Media Library.","supports":{"html":false},"attributes":{"category":{"type":"string","default":""},"tags":{"type":"string","default":""},"search_audio":{"type":"boolean","default":false},"search_video":{"type":"boolean","default":false},"search_text":{"type":"boolean","default":false},"search_application":{"type":"boolean","default":false},"show_size":{"type":"boolean","default":false},"show_content":{"type":"boolean","default":false},"show_excerpt":{"type":"boolean","default":false},"show_created":{"type":"boolean","default":false},"num":{"type":"number","default":0}},"textdomain":"rrze-elements-blocks","editorScript":"file:./index.ts","editorStyle":"file:./index.css","style":"file:./style-index.css"}');

/***/ }),

/***/ "./src/downloads-block/edit.tsx":
/*!**************************************!*\
  !*** ./src/downloads-block/edit.tsx ***!
  \**************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": function() { return /* binding */ Edit; }\n/* harmony export */ });\n/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react/jsx-runtime */ \"react/jsx-runtime\");\n/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ \"@wordpress/i18n\");\n/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ \"@wordpress/block-editor\");\n/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ \"@wordpress/components\");\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);\n/* harmony import */ var _components_QueryControls__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/QueryControls */ \"./src/components/QueryControls.tsx\");\n\n\n// Imports from WordPress libraries\n\n\n\nfunction Edit(_ref) {\n  var attributes = _ref.attributes,\n    setAttributes = _ref.setAttributes;\n  var props = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps)();\n  return (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(\"div\", Object.assign({}, props, {\n    children: (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Placeholder, {\n      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)(\"Downloads Block\", \"rrze-downloads\"),\n      instructions: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)(\"Let's configure your downloads block..\", \"rrze-downloads\"),\n      isColumnLayout: true,\n      children: (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)(\"div\", {\n        children: [(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(\"hr\", {}), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalHeading, {\n          level: 3,\n          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)(\"Your current configuration\", \"rrze-downloads\")\n        }), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalSpacer, {}), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalGrid, {\n          columns: 6,\n          children: [(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)(\"div\", {\n            style: {\n              gridColumn: \"span 3\"\n            },\n            children: [(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalHeading, {\n              level: 4,\n              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)(\"Filter by File Type\", \"rrze-downloads\")\n            }), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalSpacer, {}), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.CheckboxControl, {\n              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)(\"Text files\", \"rrze-downloads\"),\n              checked: true,\n              help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)(\"Should the Download list contain Text files?\", \"rrze-downloads\"),\n              onChange: function onChange() {}\n            }), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.CheckboxControl, {\n              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)(\"Images\", \"rrze-downloads\"),\n              checked: true,\n              onChange: function onChange() {}\n            }), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.CheckboxControl, {\n              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)(\"Audio files\", \"rrze-downloads\"),\n              checked: true,\n              onChange: function onChange() {}\n            })]\n          }), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)(\"div\", {\n            style: {\n              gridColumn: \"span 3\"\n            },\n            children: [(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalHeading, {\n              level: 4,\n              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)(\"Filter by Category or Tag\", \"rrze-downloads\")\n            }), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalSpacer, {}), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_components_QueryControls__WEBPACK_IMPORTED_MODULE_4__.CustomQueryControls, {\n              attributes: {\n                cat: attributes.category,\n                num: attributes.num\n              },\n              setAttributes: setAttributes\n            })]\n          })]\n        })]\n      })\n    })\n  }));\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QTtJQUNIO0VBQ00sR0FDVjtBQUVWIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vcnJ6ZS1kb3dubG9hZHMvLi9zcmMvZG93bmxvYWRzLWJsb2NrL2VkaXQudHN4PzI4MDQiXSwic291cmNlc0NvbnRlbnQiOlsiaW1wb3J0IHtcbiAgX19cbn0gZnJvbSBcIkB3b3JkcHJlc3MvaTE4blwiO1xuXG4vLyBJbXBvcnRzIGZyb20gV29yZFByZXNzIGxpYnJhcmllc1xuaW1wb3J0IHtcbiAgdXNlQmxvY2tQcm9wc1xufSBmcm9tIFwiQHdvcmRwcmVzcy9ibG9jay1lZGl0b3JcIjtcblxuaW1wb3J0IHtcbiAgSWNvbixcbiAgUGxhY2Vob2xkZXIsXG4gIF9fZXhwZXJpbWVudGFsR3JpZCBhcyBHcmlkLFxuICBfX2V4cGVyaW1lbnRhbEhlYWRpbmcgYXMgSGVhZGluZyxcbiAgX19leHBlcmltZW50YWxTcGFjZXIgYXMgU3BhY2VyLFxuICBfX2V4cGVyaW1lbnRhbEl0ZW0gYXMgSXRlbSxcbiAgQ2hlY2tib3hDb250cm9sLFxuICBCdXR0b25cbn0gZnJvbSBcIkB3b3JkcHJlc3MvY29tcG9uZW50c1wiO1xuXG5pbXBvcnQge1xuICBDdXN0b21RdWVyeUNvbnRyb2xzXG59IGZyb20gXCIuLi9jb21wb25lbnRzL1F1ZXJ5Q29udHJvbHNcIjtcblxuaW50ZXJmYWNlIEVkaXRQcm9wcyB7XG4gIGF0dHJpYnV0ZXM6IHtcbiAgICBjYXRlZ29yeTogc3RyaW5nO1xuICAgIG51bTogbnVtYmVyO1xuICB9LFxuICBzZXRBdHRyaWJ1dGVzOiAoYXR0cmlidXRlczogUGFydGlhbDxFZGl0UHJvcHNbXCJhdHRyaWJ1dGVzXCJdPikgPT4gdm9pZDtcbn1cblxuZXhwb3J0IGRlZmF1bHQgZnVuY3Rpb24gRWRpdCh7YXR0cmlidXRlcywgc2V0QXR0cmlidXRlc306IEVkaXRQcm9wcykge1xuICBjb25zdCBwcm9wcyA9IHVzZUJsb2NrUHJvcHMoKTtcblxuICByZXR1cm4gKFxuICAgIDxkaXYgey4uLnByb3BzfT5cbiAgICAgIDxQbGFjZWhvbGRlclxuICAgICAgICBsYWJlbD17X18oXCJEb3dubG9hZHMgQmxvY2tcIiwgXCJycnplLWRvd25sb2Fkc1wiKX1cbiAgICAgICAgaW5zdHJ1Y3Rpb25zPXtfXyhcIkxldCdzIGNvbmZpZ3VyZSB5b3VyIGRvd25sb2FkcyBibG9jay4uXCIsIFwicnJ6ZS1kb3dubG9hZHNcIil9XG4gICAgICAgIGlzQ29sdW1uTGF5b3V0PXt0cnVlfVxuICAgICAgPlxuICAgICAgICA8ZGl2PlxuICAgICAgICAgIDxociAvPlxuICAgICAgICAgIDxIZWFkaW5nIGxldmVsPXszfT57X18oXCJZb3VyIGN1cnJlbnQgY29uZmlndXJhdGlvblwiLCBcInJyemUtZG93bmxvYWRzXCIpfTwvSGVhZGluZz5cbiAgICAgICAgICA8U3BhY2VyIC8+XG4gICAgICAgICAgPEdyaWQgY29sdW1ucz17Nn0+XG4gICAgICAgICAgICA8ZGl2IHN0eWxlPXt7IGdyaWRDb2x1bW46IFwic3BhbiAzXCIgfX0+XG4gICAgICAgICAgICAgIDxIZWFkaW5nIGxldmVsPXs0fT57X18oXCJGaWx0ZXIgYnkgRmlsZSBUeXBlXCIsIFwicnJ6ZS1kb3dubG9hZHNcIil9PC9IZWFkaW5nPlxuICAgICAgICAgICAgICA8U3BhY2VyIC8+XG4gICAgICAgICAgICAgIDxDaGVja2JveENvbnRyb2xcbiAgICAgICAgICAgICAgICBsYWJlbD17X18oXCJUZXh0IGZpbGVzXCIsIFwicnJ6ZS1kb3dubG9hZHNcIil9XG4gICAgICAgICAgICAgICAgY2hlY2tlZD17dHJ1ZX1cbiAgICAgICAgICAgICAgICBoZWxwPXtfXyhcIlNob3VsZCB0aGUgRG93bmxvYWQgbGlzdCBjb250YWluIFRleHQgZmlsZXM/XCIsIFwicnJ6ZS1kb3dubG9hZHNcIil9XG4gICAgICAgICAgICAgICAgb25DaGFuZ2U9eygpID0+IHtcbiAgICAgICAgICAgICAgICB9fVxuICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICA8Q2hlY2tib3hDb250cm9sXG4gICAgICAgICAgICAgICAgbGFiZWw9e19fKFwiSW1hZ2VzXCIsIFwicnJ6ZS1kb3dubG9hZHNcIil9XG4gICAgICAgICAgICAgICAgY2hlY2tlZD17dHJ1ZX1cbiAgICAgICAgICAgICAgICBvbkNoYW5nZT17KCkgPT4ge1xuICAgICAgICAgICAgICAgIH19XG4gICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICAgIDxDaGVja2JveENvbnRyb2xcbiAgICAgICAgICAgICAgICBsYWJlbD17X18oXCJBdWRpbyBmaWxlc1wiLCBcInJyemUtZG93bmxvYWRzXCIpfVxuICAgICAgICAgICAgICAgIGNoZWNrZWQ9e3RydWV9XG4gICAgICAgICAgICAgICAgb25DaGFuZ2U9eygpID0+IHtcbiAgICAgICAgICAgICAgICB9fVxuICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgICA8ZGl2IHN0eWxlPXt7IGdyaWRDb2x1bW46IFwic3BhbiAzXCIgfX0+XG4gICAgICAgICAgICAgIDxIZWFkaW5nIGxldmVsPXs0fT57X18oXCJGaWx0ZXIgYnkgQ2F0ZWdvcnkgb3IgVGFnXCIsIFwicnJ6ZS1kb3dubG9hZHNcIil9PC9IZWFkaW5nPlxuICAgICAgICAgICAgICA8U3BhY2VyIC8+XG4gICAgICAgICAgICAgIDxDdXN0b21RdWVyeUNvbnRyb2xzXG4gICAgICAgICAgICAgICAgYXR0cmlidXRlcz17e1xuICAgICAgICAgICAgICAgICAgY2F0OiBhdHRyaWJ1dGVzLmNhdGVnb3J5LFxuICAgICAgICAgICAgICAgICAgbnVtOiBhdHRyaWJ1dGVzLm51bSxcbiAgICAgICAgICAgICAgICB9fVxuICAgICAgICAgICAgICAgIHNldEF0dHJpYnV0ZXM9e3NldEF0dHJpYnV0ZXN9XG4gICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgICA8L0dyaWQ+XG4gICAgICAgIDwvZGl2PlxuICAgICAgPC9QbGFjZWhvbGRlcj5cbiAgICA8L2Rpdj5cbiAgKTtcbn0iXSwibmFtZXMiOlsiX18iLCJ1c2VCbG9ja1Byb3BzIiwiUGxhY2Vob2xkZXIiLCJfX2V4cGVyaW1lbnRhbEdyaWQiLCJHcmlkIiwiX19leHBlcmltZW50YWxIZWFkaW5nIiwiSGVhZGluZyIsIl9fZXhwZXJpbWVudGFsU3BhY2VyIiwiU3BhY2VyIiwiQ2hlY2tib3hDb250cm9sIiwiQ3VzdG9tUXVlcnlDb250cm9scyIsIkVkaXQiLCJfcmVmIiwiYXR0cmlidXRlcyIsInNldEF0dHJpYnV0ZXMiLCJwcm9wcyIsIl9qc3giLCJPYmplY3QiLCJhc3NpZ24iLCJjaGlsZHJlbiIsImxhYmVsIiwiaW5zdHJ1Y3Rpb25zIiwiaXNDb2x1bW5MYXlvdXQiLCJfanN4cyIsImxldmVsIiwiY29sdW1ucyIsInN0eWxlIiwiZ3JpZENvbHVtbiIsImNoZWNrZWQiLCJoZWxwIiwib25DaGFuZ2UiLCJjYXQiLCJjYXRlZ29yeSIsIm51bSJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./src/downloads-block/edit.tsx\n");

/***/ }),

/***/ "./src/downloads-block/editor.scss":
/*!*****************************************!*\
  !*** ./src/downloads-block/editor.scss ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9zcmMvZG93bmxvYWRzLWJsb2NrL2VkaXRvci5zY3NzIiwibWFwcGluZ3MiOiI7QUFBQSIsInNvdXJjZXMiOlsid2VicGFjazovL3JyemUtZG93bmxvYWRzLy4vc3JjL2Rvd25sb2Fkcy1ibG9jay9lZGl0b3Iuc2Nzcz84NzBhIl0sInNvdXJjZXNDb250ZW50IjpbIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyJdLCJuYW1lcyI6W10sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./src/downloads-block/editor.scss\n");

/***/ }),

/***/ "./src/downloads-block/index.tsx":
/*!***************************************!*\
  !*** ./src/downloads-block/index.tsx ***!
  \***************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react/jsx-runtime */ \"react/jsx-runtime\");\n/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/blocks */ \"@wordpress/blocks\");\n/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ \"./src/downloads-block/edit.tsx\");\n/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./save */ \"./src/downloads-block/save.tsx\");\n/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./block.json */ \"./src/downloads-block/block.json\");\n/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./editor.scss */ \"./src/downloads-block/editor.scss\");\n\n\n\n\n\n\n(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_4__.name, {\n  icon: {\n    src: (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(\"svg\", {\n      xmlns: \"http://www.w3.org/2000/svg\",\n      height: \"24px\",\n      viewBox: \"0 -960 960 960\",\n      width: \"24px\",\n      fill: \"evenodd\",\n      children: (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(\"path\", {\n        d: \"M480-320 280-520l56-58 104 104v-326h80v326l104-104 56 58-200 200ZM240-160q-33 0-56.5-23.5T160-240v-120h80v120h480v-120h80v120q0 33-23.5 56.5T720-160H240Z\"\n      })\n    })\n  },\n  __experimentalLabel: function __experimentalLabel(attributes, _ref) {\n    var context = _ref.context;\n    var title = attributes.title;\n    if (context === \"list-view\" && title) {\n      return title;\n    }\n  },\n  // @see ./edit.js\n  edit: _edit__WEBPACK_IMPORTED_MODULE_2__[\"default\"],\n  // @see ./save.js\n  save: _save__WEBPACK_IMPORTED_MODULE_3__[\"default\"]\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9zcmMvZG93bmxvYWRzLWJsb2NrL2luZGV4LnRzeCIsIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7O0FBQXNEO0FBRTVCO0FBQ0E7QUFDVTtBQUNiO0FBRXZCQSxvRUFBaUIsQ0FBQ0csNkNBQW9CLEVBQUU7RUFDdENFLElBQUksRUFBRTtJQUNKQyxHQUFHLEVBQ0RDLHNEQUFBO01BQUtDLEtBQUssRUFBQyw0QkFBNEI7TUFBQ0MsTUFBTSxFQUFDLE1BQU07TUFBQ0MsT0FBTyxFQUFDLGdCQUFnQjtNQUFDQyxLQUFLLEVBQUMsTUFBTTtNQUFDQyxJQUFJLEVBQUMsU0FBUztNQUFBQyxRQUFBLEVBQ3hHTixzREFBQTtRQUNFTyxDQUFDLEVBQUM7TUFBMko7SUFBRztHQUV2SztFQUNEQyxtQkFBbUIsRUFBRSxTQUFyQkEsbUJBQW1CQSxDQUFHQyxVQUFlLEVBQUFDLElBQUEsRUFBc0I7SUFBQSxJQUFsQkMsT0FBTyxHQUFBRCxJQUFBLENBQVBDLE9BQU87SUFDOUMsSUFBUUMsS0FBSyxHQUFLSCxVQUFVLENBQXBCRyxLQUFLO0lBRWIsSUFBSUQsT0FBTyxLQUFLLFdBQVcsSUFBSUMsS0FBSyxFQUFFO01BQ3BDLE9BQU9BLEtBQUs7SUFDZDtFQUNGLENBQUM7RUFDRDtFQUNBQyxJQUFJLEVBQUVuQiw2Q0FBSTtFQUVWO0VBQ0FDLElBQUksRUFBSkEsNkNBQUlBO0NBQ0UsQ0FBQyIsInNvdXJjZXMiOlsid2VicGFjazovL3JyemUtZG93bmxvYWRzLy4vc3JjL2Rvd25sb2Fkcy1ibG9jay9pbmRleC50c3g/MTdlOSJdLCJzb3VyY2VzQ29udGVudCI6WyJpbXBvcnQgeyByZWdpc3RlckJsb2NrVHlwZSB9IGZyb20gXCJAd29yZHByZXNzL2Jsb2Nrc1wiO1xuXG5pbXBvcnQgRWRpdCBmcm9tIFwiLi9lZGl0XCI7XG5pbXBvcnQgc2F2ZSBmcm9tIFwiLi9zYXZlXCI7XG5pbXBvcnQgbWV0YWRhdGEgZnJvbSBcIi4vYmxvY2suanNvblwiO1xuaW1wb3J0IFwiLi9lZGl0b3Iuc2Nzc1wiO1xuXG5yZWdpc3RlckJsb2NrVHlwZShtZXRhZGF0YS5uYW1lIGFzIGFueSwge1xuICBpY29uOiB7XG4gICAgc3JjOlxuICAgICAgPHN2ZyB4bWxucz1cImh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnXCIgaGVpZ2h0PVwiMjRweFwiIHZpZXdCb3g9XCIwIC05NjAgOTYwIDk2MFwiIHdpZHRoPVwiMjRweFwiIGZpbGw9XCJldmVub2RkXCI+XG4gICAgICAgIDxwYXRoXG4gICAgICAgICAgZD1cIk00ODAtMzIwIDI4MC01MjBsNTYtNTggMTA0IDEwNHYtMzI2aDgwdjMyNmwxMDQtMTA0IDU2IDU4LTIwMCAyMDBaTTI0MC0xNjBxLTMzIDAtNTYuNS0yMy41VDE2MC0yNDB2LTEyMGg4MHYxMjBoNDgwdi0xMjBoODB2MTIwcTAgMzMtMjMuNSA1Ni41VDcyMC0xNjBIMjQwWlwiIC8+XG4gICAgICA8L3N2Zz5cbiAgfSxcbiAgX19leHBlcmltZW50YWxMYWJlbDogKGF0dHJpYnV0ZXM6IGFueSwgeyBjb250ZXh0IH06IGFueSkgPT4ge1xuICAgIGNvbnN0IHsgdGl0bGUgfSA9IGF0dHJpYnV0ZXM7XG5cbiAgICBpZiAoY29udGV4dCA9PT0gXCJsaXN0LXZpZXdcIiAmJiB0aXRsZSkge1xuICAgICAgcmV0dXJuIHRpdGxlO1xuICAgIH1cbiAgfSxcbiAgLy8gQHNlZSAuL2VkaXQuanNcbiAgZWRpdDogRWRpdCxcblxuICAvLyBAc2VlIC4vc2F2ZS5qc1xuICBzYXZlXG59IGFzIGFueSk7Il0sIm5hbWVzIjpbInJlZ2lzdGVyQmxvY2tUeXBlIiwiRWRpdCIsInNhdmUiLCJtZXRhZGF0YSIsIm5hbWUiLCJpY29uIiwic3JjIiwiX2pzeCIsInhtbG5zIiwiaGVpZ2h0Iiwidmlld0JveCIsIndpZHRoIiwiZmlsbCIsImNoaWxkcmVuIiwiZCIsIl9fZXhwZXJpbWVudGFsTGFiZWwiLCJhdHRyaWJ1dGVzIiwiX3JlZiIsImNvbnRleHQiLCJ0aXRsZSIsImVkaXQiXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./src/downloads-block/index.tsx\n");

/***/ }),

/***/ "./src/downloads-block/save.tsx":
/*!**************************************!*\
  !*** ./src/downloads-block/save.tsx ***!
  \**************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": function() { return /* binding */ save; }\n/* harmony export */ });\n/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react/jsx-runtime */ \"react/jsx-runtime\");\n/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ \"@wordpress/block-editor\");\n/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);\n\n\nfunction save(_ref) {\n  var attributes = _ref.attributes;\n  var blockProps = _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps.save();\n  return (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.Fragment, {\n    children: (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(\"div\", Object.assign({}, blockProps, {\n      children: (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)(\"h2\", {\n        children: [\"Hello World! \", attributes.title]\n      })\n    }))\n  });\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9zcmMvZG93bmxvYWRzLWJsb2NrL3NhdmUudHN4IiwibWFwcGluZ3MiOiI7Ozs7Ozs7OztBQUF3RDtBQVcxQyxTQUFVQyxJQUFJQSxDQUFBQyxJQUFBLEVBQTBCO0VBQUEsSUFBdkJDLFVBQVUsR0FBQUQsSUFBQSxDQUFWQyxVQUFVO0VBQ3ZDLElBQU1DLFVBQVUsR0FBR0osa0VBQWEsQ0FBQ0MsSUFBSSxFQUFFO0VBQ3ZDLE9BQ0VJLHNEQUFBLENBQUFDLHVEQUFBO0lBQUFDLFFBQUEsRUFDRUYsc0RBQUEsUUFBQUcsTUFBQSxDQUFBQyxNQUFBLEtBQVNMLFVBQVU7TUFBQUcsUUFBQSxFQUVqQkcsdURBQUE7UUFBQUgsUUFBQSxvQkFBa0JKLFVBQVUsQ0FBQ1EsS0FBSztNQUFBO0lBQU07RUFDcEMsRUFDTDtBQUVQIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vcnJ6ZS1kb3dubG9hZHMvLi9zcmMvZG93bmxvYWRzLWJsb2NrL3NhdmUudHN4PzE0ZGUiXSwic291cmNlc0NvbnRlbnQiOlsiaW1wb3J0IHsgdXNlQmxvY2tQcm9wcyB9IGZyb20gXCJAd29yZHByZXNzL2Jsb2NrLWVkaXRvclwiO1xuXG5pbnRlcmZhY2UgU2F2ZVByb3BzIHtcbiAgYXR0cmlidXRlczoge1xuICAgIGNvbG9yOiBzdHJpbmc7XG4gICAgdGFic1VpZDogc3RyaW5nO1xuICAgIGJsb2NrSWQ6IHN0cmluZztcbiAgICB0aXRsZTogc3RyaW5nO1xuICB9O1xufVxuXG5leHBvcnQgZGVmYXVsdCBmdW5jdGlvbiBzYXZlKHsgYXR0cmlidXRlcyB9OiBTYXZlUHJvcHMpIHtcbiAgY29uc3QgYmxvY2tQcm9wcyA9IHVzZUJsb2NrUHJvcHMuc2F2ZSgpO1xuICByZXR1cm4gKFxuICAgIDw+XG4gICAgICA8ZGl2IHsuLi5ibG9ja1Byb3BzfVxuICAgICAgPlxuICAgICAgICA8aDI+SGVsbG8gV29ybGQhIHthdHRyaWJ1dGVzLnRpdGxlfTwvaDI+XG4gICAgICA8L2Rpdj5cbiAgICA8Lz5cbiAgKTtcbn1cbiJdLCJuYW1lcyI6WyJ1c2VCbG9ja1Byb3BzIiwic2F2ZSIsIl9yZWYiLCJhdHRyaWJ1dGVzIiwiYmxvY2tQcm9wcyIsIl9qc3giLCJfRnJhZ21lbnQiLCJjaGlsZHJlbiIsIk9iamVjdCIsImFzc2lnbiIsIl9qc3hzIiwidGl0bGUiXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./src/downloads-block/save.tsx\n");

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ (function(module) {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ (function(module) {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "react/jsx-runtime":
/*!**********************************!*\
  !*** external "ReactJSXRuntime" ***!
  \**********************************/
/***/ (function(module) {

module.exports = window["ReactJSXRuntime"];

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
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./src/downloads-block/index.tsx");
/******/ 	
/******/ })()
;