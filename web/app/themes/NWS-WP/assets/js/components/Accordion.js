import ArrayFrom from 'array.from'

export default class Accordion {
	constructor($item) {
		this.$item = $item
		this._onResize = this.handleResize.bind(this)

		this.$content = this.$item.getElementsByClassName('ac-content')[0]

		window.addEventListener('resize', this._onResize)
		this._onResize()

		this.$item.getElementsByClassName('ac-title')[0].addEventListener('click', this.handleClick.bind(this))
	}

	handleResize() {
		this.$content.style.maxHeight = (this.$content.scrollHeight + 100) + 'px'
	}

	handleClick() {
		let classList = this.$item.classList,
			wasActive = classList.contains('active'),
			$items = document.getElementsByClassName('accordion-item')

		for (let i = 0; i < $items.length; i++)
			$items[i].classList.remove('active')

		if (wasActive) classList.remove('active')
		else classList.add('active')
	}
}

ArrayFrom(document.getElementsByClassName('accordion-item')).forEach(e => new Accordion(e))