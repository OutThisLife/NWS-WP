<?php
/**
 * replaceMe
 *
 * Slideshow
 */
?>

<section ng-slideshow class="panel">
	<!-- The slides -->
	<div id="theSlides">
		<figure class="slide">
			<h2>Hello 0</h2>
		</figure>
		
		<figure class="slide">
			<h2>Hello 1</h2>
		</figure>
		
		<figure class="slide">
			<h2>Hello 3</h2>
		</figure>
		
		<figure class="slide">
			<h2>Hello 4</h2>
		</figure>
	</div>

	<!-- Slide pager -->
	<ul class="pager button-group round">
		<li>
			<a href="javascript:;" ng-click="goToSlide(0)" class="tiny button">Slide#0</a>
		</li>

		<li>
			<a href="javascript:;" ng-click="goToSlide(1)" class="tiny button">Slide#1</a>
		</li>

		<li>
			<a href="javascript:;" ng-click="goToSlide(2)" class="tiny button">Slide#2</a>
		</li>

		<li>
			<a href="javascript:;" ng-click="goToSlide(3)" class="tiny button">Slide#3</a>
		</li>

		<li>
			<a href="javascript:;" ng-click="goToSlide(4)" class="tiny button">Slide#4</a>
		</li>
	</ul>
</section>