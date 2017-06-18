import AnimateOut from './modules/AnimateOut'

Array.from(document.querySelectorAll('[href]')).forEach(el => {
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

window.onload = () => document.body.classList.add('loaded')
