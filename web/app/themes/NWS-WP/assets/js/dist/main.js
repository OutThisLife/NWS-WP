(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

var _AnimateOut = require('./modules/AnimateOut');

var _AnimateOut2 = _interopRequireDefault(_AnimateOut);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

Array.from(document.querySelectorAll('[href]')).forEach(function (el) {
	var href = el.getAttribute('href');

	if (href.match(location.origin) && !/#/.test(href) && !/contact/.test(href)) {
		el.addEventListener('click', function (e) {
			e.preventDefault();
			return (0, _AnimateOut2.default)(href);
		});
	}
});

window.onload = function () {
	return document.body.classList.add('loaded');
};

},{"./modules/AnimateOut":2}],2:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});

exports.default = function (href) {
	var _arguments = arguments;

	document.body.classList.remove('load-in');
	document.body.classList.add('load-out');['animationend', 'webkitAnimationEnd'].map(function (evt) {
		$container.addEventListener(evt, function (e) {
			location.href = href;
			$container.removeEventListener(e.type, _arguments.callee);
		});
	});
};

var $container = document.getElementById('container');

window.onpageshow = function (e) {
	return e.persisted ? window.location.reload() : null;
};

},{}]},{},[1]);
