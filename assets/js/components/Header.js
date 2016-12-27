import HoverIntent from '../modules/HoverIntent'

// ---------------------------------------------

HoverIntent.bind(
	window.innerWidth > 770
		? document.querySelectorAll('li[class*="children"]')
		: document.querySelectorAll('.main-mobile-nav > li[class*="children"] > a')
)

// ---------------------------------------------

export class Header {
	constructor($header) {
		this.$header = $header

		this.lastScrollTop = 0
		this._onScroll = this.handleScroll.bind(this)

		this._onScroll()
		window.addEventListener('scroll', this._onScroll, false)

		//

		let $mobileLink

		if ($mobileLink = this.$header.querySelector('.mobile-link > a')) {
			$mobileLink.addEventListener('click', this.handleMobileClick.bind(this), true)
		}
	}

	toggleIf(c, cond) {
		let classList = this.$header.classList

		if (cond) classList.add(c)
		else classList.remove(c)
	}

	handleScroll(e) {
		let scrollTop = window.pageYOffset,
			threshold = 30

		if (document.querySelector('.masthead'))
			threshold = 300

		this.toggleIf('out', this.lastScrollTop < scrollTop && scrollTop >= threshold)
		this.toggleIf('min', scrollTop >= threshold)

		this.lastScrollTop = scrollTop
	}

	handleMobileClick(e) {
		this.toggleIf('mobile-menu-open', !this.$header.classList.contains('mobile-menu-open'))

		if (this.$header.classList.contains('mobile-menu-open'))
			document.body.classList.add('lock')

		else document.body.classList.remove('lock')
	}
}

new Header(document.getElementById('header'))