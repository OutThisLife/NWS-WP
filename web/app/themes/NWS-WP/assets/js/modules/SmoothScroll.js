Math.easeOut = function(t, b, c, d) { 
	t /= d
	return -c * t * (t - 2) + b
}
	
let scroll_int, 
	mult = 0, // scroll speed
	dir = 0, // 1 = down, -1 = up
	steps = 25, // how many steps in animation
	length = 30 // anim duration

export default function(e) {
	e.preventDefault()
	clearInterval(scroll_int)
	++mult

	let delta = -Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail)))

	if (dir !== delta) {
		mult = 1
		dir = delta
	}

	for (var tgt = e.target; tgt !== document.documentElement; tgt = tgt.parentNode) {
		let oldScroll = tgt.scrollTop
		tgt.scrollTop += delta

		if (oldScroll !== tgt.scrollTop) break
	}

	let start = tgt.scrollTop,
		end = start + length * mult * delta,
		change = end - start,
		step = 0

	scroll_int = setInterval(() => {
		let pos = Math.easeOut(step++, start, change, steps)
		tgt.scrollTop = pos

		if (step >= steps) {
			mult = 0
			clearInterval(scroll_int)
		}
	}, 10)
}