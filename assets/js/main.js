require('classlist-polyfill')

import './components/Header'

// ----------------------------------------------------

import ArrayFrom from 'array.from'
import AnimateOut from './modules/AnimateOut'
import imagesLoaded from 'imagesloaded'

ArrayFrom(document.querySelectorAll('[href]')).forEach(el => {
	const href = el.getAttribute('href')

	if (
		href.match(location.origin)
		&& !/#/.test(href)
		&& !/contact/.test(href)
	) {
		el.addEventListener('click', (e) => {
			e.preventDefault()
			return AnimateOut(href)
		})
	}
})

imagesLoaded('#container', () => document.body.classList.add('loaded'))