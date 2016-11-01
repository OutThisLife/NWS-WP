import idx from '../modules/idx'

export default class Tabs {
	constructor($tabs) {
		this.$parent = $tabs
		this.$tabs = $tabs.querySelectorAll('li')
		this.$contents = $tabs.nextElementSibling.querySelectorAll('div')
		this.current = 0

		this.setBinds()
	}

	setBinds() {
		this.$parent.addEventListener('click', e => {
			return this.goToTab(idx($li, this.$tabs))
		}, true)

		;['load', 'resize', 'orientationchange'].forEach(e => {
			window.addEventListener(e, this.resizeContainer.bind(this), false)
		})
	}

	setClasses() {
		let rmf = (elements) => {
			Array.from(elements).forEach(el => {
				el.classList.remove('active')
			})

			elements[this.current].classList.add('active')
		}

		rmf(this.$tabs)
		rmf(this.$contents)
	}

	goToTab(i) {
		this.current = i
		this.setClasses()
	}

	resizeContainer() {
		this.$parent.nextElementSibling.style.height = ''
		this.$parent.nextElementSibling.style.height = this.$contents[0].scrollHeight + 'px'
	}
}

Array.from(document.getElementsByClassName('tabs')).forEach(e => new Tabs(e))