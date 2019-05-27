<?php return '
<form
	class="tribe-common tribe-events"
	action=""
	method="get"
	data-rest-url="http://test.tri.be/index.php?rest_route=/tribe/views/v2/html"
	data-js="tribe-events-view"
>
	<input type="hidden" id="tribe-events-views[_wpnonce]" name="tribe-events-views[_wpnonce]" value="e00f246f0e" /><input type="hidden" name="_wp_http_referer" value="/events" />
	<div class="tribe-events-view-loader tribe-common-a11y-hidden">
	<div class="tribe-events-view-loader__spinner">Loading...</div>
</div>

	<script
	data-js="tribe-events-view-link"
	type="application/json"
>{"url":"http:\\/\\/test.tri.be\\/events\\/list\\/page\\/3","title":"Developers title"}</script>

	<div class="tribe-events-c-events-bar">

	<h2 class="tribe-common-a11y-visual-hide">Events Search and Views Navigation</h2>

	<div class="tribe-events-c-events-bar__views">
	<h3 class="tribe-common-a11y-visual-hide">Event Views Navigation</h3>
	<div class="tribe-common-form-control-tabs tribe-events-c-events-bar__views-tabs">
		<button class="tribe-common-form-control-tabs__button tribe-events-c-events-bar__views-tabs-button" id="tribe-views-button" aria-haspopup="listbox" aria-labelledby="tribe-views-button" aria-expanded="true">Views</button>
		<ul class="tribe-common-form-control-tabs__list tribe-events-c-events-bar__views-tabs-list" tabindex="-1" role="listbox" aria-activedescendant="tribe-views-list-label">
			<li class="tribe-common-form-control-tabs__list-item" role="presentation">
				<input class="tribe-common-form-control-tabs__input" id="tribe-views-list" name="tribe-views" type="radio" value="tribe-views-list" checked="checked" />
				<label class="tribe-common-form-control-tabs__label" id="tribe-views-list-label" for="tribe-views-list" role="option" aria-selected="true">List</label>
			</li>
			<li class="tribe-common-form-control-tabs__list-item" role="presentation">
				<input class="tribe-common-form-control-tabs__input" id="tribe-views-month" name="tribe-views" type="radio" value="tribe-views-month" />
				<label class="tribe-common-form-control-tabs__label" id="tribe-views-month-label" for="tribe-views-month" role="option">Month</label>
			</li>
			<li class="tribe-common-form-control-tabs__list-item" role="presentation">
				<input class="tribe-common-form-control-tabs__input" id="tribe-views-week" name="tribe-views" type="radio" value="tribe-views-week" />
				<label class="tribe-common-form-control-tabs__label" id="tribe-views-week-label" for="tribe-views-week" role="option">Week</label>
			</li>
		</ul>
	</div>
</div>

	<div class="tribe-events-c-events-bar__filters">
	<div class="tribe-events-c-events-bar__filters-button-wrapper tribe-events-c-events-bar__filters-button-wrapper--search">
		<button
			class="tribe-common-c-btn-icon tribe-common-c-btn-icon--search tribe-events-c-events-bar__filters-button tribe-events-c-events-bar__filters-button--search"
			aria-label="Search"
			title="Search"
		>
		</button>
	</div>
	<div class="tribe-events-c-events-bar__filters-button-wrapper tribe-events-c-events-bar__filters-button-wrapper--filter">
		<button
			class="tribe-common-c-btn-icon tribe-common-c-btn-icon--filters tribe-events-c-events-bar__filters-button tribe-events-c-events-bar__filters-button--filter"
			aria-label="Filter"
			title="Filter"
		>
		</button>
	</div>
</div>

	<div class="tribe-events-c-events-bar__form">
	<div class="tribe-common-c-search">
		<div class="tribe-common-form-control-text-group tribe-common-c-search__input-group">
			<div class="tribe-common-form-control-text">
	<label class="tribe-common-form-control-text__label" for="keyword">Enter Keyword. Search for Events by Keyword.</label>
	<input
		class="tribe-common-form-control-text__input tribe-common-c-search__input"
		type="text"
		id="keyword"
		name="keyword"
		placeholder="Keyword"
	/>
</div>
			<div class="tribe-common-form-control-text">
	<label class="tribe-common-form-control-text__label" for="location">Enter Location. Search for Events by Location.</label>
	<input
		class="tribe-common-form-control-text__input tribe-common-c-search__input"
		type="text"
		id="location"
		name="location"
		placeholder="Location"
	/>
</div>
			<div class="tribe-common-form-control-text">
	<label class="tribe-common-form-control-text__label" for="tribe-bar-date">Enter date. Please use the format 4 digit year hyphen 2 digit month hyphen 2 digit day.</label>
	<input
		class="tribe-common-form-control-text__input tribe-common-c-search__input"
		type="text"
		id="tribe-bar-date"
		name="tribe-bar-date"
		placeholder="Enter date"
	/>
</div>
		</div>
		<button
	class="tribe-common-c-btn tribe-common-c-search__button"
	type="submit"
	name="submit-bar"
>Find Events</button>
	</div>
</div>

</div>

	<div class="tribe-events-c-top-bar">

	<div class="tribe-events-c-top-bar__nav-wrapper">
	<nav class="tribe-events-c-top-bar__nav">
		<ul class="tribe-events-c-top-bar__nav-list">
			<li class="tribe-events-c-top-bar__nav-list-item">
				<a
					href="#"
					class="tribe-common-c-btn-icon tribe-common-c-btn-icon--caret-left tribe-common-b3 tribe-events-c-top-bar__nav-link tribe-events-c-top-bar__nav-link--prev"
					aria-label="Previous"
					title="Previous"
					data-js="tribe-events-view-link"
				>
				</a>
			</li>
			<li class="tribe-events-c-top-bar__nav-list-item">
				<a
					href="http://test.tri.be/events/list/page/2?view=list"
					class="tribe-common-c-btn-icon tribe-common-c-btn-icon--caret-right tribe-common-b3 tribe-events-c-top-bar__nav-link tribe-events-c-top-bar__nav-link--next"
					aria-label="Next"
					title="Next"
					data-js="tribe-events-view-link"
				>
				</a>
			</li>
		</ul>
	</nav>
</div>

	<div class="tribe-events-c-top-bar__today">
	<a href="#" class="tribe-common-c-btn-border tribe-events-c-top-bar__today-button">
		Today	</a>

	<span class="tribe-common-h3 tribe-common-h3--alt tribe-events-c-top-bar__today-title">
		Now &mdash; <time datetime="2019-01-01">January 1st, 2019</time>
	</span>
</div>

	<div class="tribe-events-c-top-bar__actions">
	<div class="tribe-common-form-control-toggle">
		<input class="tribe-common-form-control-toggle__input" id="hide-recurring" name="hide-recurring" type="checkbox" value="false" />
		<label class="tribe-common-form-control-toggle__label" for="hide-recurring">Hide Recurring Events</label>
	</div>
</div>

</div>

	<div class="tribe-events-calendar-list">

		<div class="tribe-events-calendar-list__separator-month">
	<time class="tribe-events-calendar-list__separator-month-text tribe-common-b1 tribe-common-b1--bold" datetime="1970-01-01T00:00:00+00:00">Jan</time>
</div>

		
			<div class="tribe-events-calendar-list__event">

	
	<div class="tribe-events-calendar-list__event-details">

		<header>
			<div class="tribe-events-calendar-list__event-datetime-wrapper">
	<time class="tribe-events-calendar-list__event-datetime tribe-common-b2" datetime="1970-01-01T00:00:00+00:00">
		<span class="tribe-event-date-start">January 1, 2018 @ 10:00 am</span> - <span class="tribe-event-time">1:00 pm</span>	</time>
	</div>
			<h3 class="tribe-events-calendar-list__event-title tribe-common-h2">
	<a
		href="http://test.tri.be/?tribe_events=test-event-fa95745058001b098f83649aca569bf6%2F"
		title=""
		rel="bookmark"
		class="tribe-events-calendar-list__event-title-link"
	>
		Test Event fa95745058001b098f83649aca569bf6	</a>
</h3>
			<address class="tribe-events-calendar-list__event-venue">
	<span class="tribe-events-calendar-list__event-venue-title tribe-common-b2 tribe-common-b2--bold">
		Venue Name	</span>
	<span class="tribe-events-calendar-list__event-venue-address tribe-common-b2">
		<span class="tribe-address">






</span>
	</span>
</address>
		</header>

		<div class="tribe-events-calendar-list__event-description tribe-common-b1">
	</div>

	</div>

</div>

		
			<div class="tribe-events-calendar-list__event">

	
	<div class="tribe-events-calendar-list__event-details">

		<header>
			<div class="tribe-events-calendar-list__event-datetime-wrapper">
	<time class="tribe-events-calendar-list__event-datetime tribe-common-b2" datetime="1970-01-01T00:00:00+00:00">
		<span class="tribe-event-date-start">January 2, 2018 @ 8:00 am</span> - <span class="tribe-event-time">11:00 am</span>	</time>
	</div>
			<h3 class="tribe-events-calendar-list__event-title tribe-common-h2">
	<a
		href="http://test.tri.be/?tribe_events=test-event-518de7f46caf4882f39a2fc6e3f8dca1%2F"
		title=""
		rel="bookmark"
		class="tribe-events-calendar-list__event-title-link"
	>
		Test Event 518de7f46caf4882f39a2fc6e3f8dca1	</a>
</h3>
			<address class="tribe-events-calendar-list__event-venue">
	<span class="tribe-events-calendar-list__event-venue-title tribe-common-b2 tribe-common-b2--bold">
		Venue Name	</span>
	<span class="tribe-events-calendar-list__event-venue-address tribe-common-b2">
		<span class="tribe-address">






</span>
	</span>
</address>
		</header>

		<div class="tribe-events-calendar-list__event-description tribe-common-b1">
	</div>

	</div>

</div>

		
			<div class="tribe-events-calendar-list__event">

	
	<div class="tribe-events-calendar-list__event-details">

		<header>
			<div class="tribe-events-calendar-list__event-datetime-wrapper">
	<time class="tribe-events-calendar-list__event-datetime tribe-common-b2" datetime="1970-01-01T00:00:00+00:00">
		<span class="tribe-event-date-start">February 2, 2018 @ 11:00 am</span> - <span class="tribe-event-time">2:00 pm</span>	</time>
	</div>
			<h3 class="tribe-events-calendar-list__event-title tribe-common-h2">
	<a
		href="http://test.tri.be/?tribe_events=test-event-4cd179b5da9deb2d6f07e60842a35326%2F"
		title=""
		rel="bookmark"
		class="tribe-events-calendar-list__event-title-link"
	>
		Test Event 4cd179b5da9deb2d6f07e60842a35326	</a>
</h3>
			<address class="tribe-events-calendar-list__event-venue">
	<span class="tribe-events-calendar-list__event-venue-title tribe-common-b2 tribe-common-b2--bold">
		Venue Name	</span>
	<span class="tribe-events-calendar-list__event-venue-address tribe-common-b2">
		<span class="tribe-address">






</span>
	</span>
</address>
		</header>

		<div class="tribe-events-calendar-list__event-description tribe-common-b1">
	</div>

	</div>

</div>

		
	</div>

	<nav class="tribe-common-c-nav">
	<ul class="tribe-common-c-nav__list">
		<li class="tribe-common-c-nav__list-item">
	<a
		href="http://test.tri.be/events/list/?tribe_event_display=past&#038;tribe_paged=1"
		rel="prev"
		class="tribe-common-c-nav__prev"
		data-js="tribe-events-view-link"
	>
		Previous Events	</a>
</li>			</ul>
</nav></form>
';
