@extends('layouts.master', ['masthead' => true])

@push('head')
	<link href="{{asset('css/Homepage.css')}}" rel="stylesheet" type="text/css">
@endpush

@section('masthead')
	<div class="ui container full-height">
	    <div class="ui grid full-height">
	        <div class="sixteen wide mobile eight wide computer stretched column full-height">
	            <div class="text">
	                <h1 class="ui primary header">
	                	Create Your Custom Star Map
	                </h1>
	                
	                <p>
	                	Create a personalised print of the night sky for any moment:<br/>
	                	anniversary, birthday, engagement, or when you fell in love.
	                </p>

	                <div class="ui huge primary button">
	                	Get Started <i class="right arrow icon"></i>
	                </div>
	            </div>
	        </div>
	        <div class="sixteen wide mobile eight wide computer column">
	        </div>
	    </div>
	</div>
@endsection

@section('content')
	<div class="ui vertical stripe segment">
	    <div class="ui text container">
			<section class="first section">       
		        <div class="ui grid">
		        	<div class="eight wide column">
		        	</div>
		        	<div class="eight wide column justify-content">
		        		<h1 class="ui primary header">Shine like a star</h1>

		        		Celebrate in the most important date in your life and see how the cosmos looked during that special moment: anniversary, birthday, engagement, or when you fell in love.

		        		<br/><br/>

		        		We use the highest quality premium 260gsm satin (better than museum quality) paper which makes the colours sharp and vivid. Need it ASAP? No problem, you can instantly download a digital copy for only $24.99 (any size).

		        		<br/><br/>

		        		No need to worry about converting different paper sizes or trimming the poster because you can choose from 3 different paper standards (US, metric or ISO) and 15 different paper sizes.

		        		<br/><br/>

		        		<a class="ui normal primary button">
		        			CREATE YOUR PERFECT GIFT
		        		</a>
		        	</div>
		        </div>
		    </section>

	        <div class="ui horizontal divider"></div>

			<section class="second section">
		        <h2 class="ui center aligned primary header">
		        	DESIGNED BY YOU, ASSEMBLED BY US
		        </h2>

		        <div class="ui equal width grid">
		        	<div class="column">
		        		<h4 class="ui primary header">Unlimited design options</h4>

		        		<small>
		        			Start by entering a location name and our easy to use map editor will do the rest.
		        		</small>
		        	</div>
		        	<div class="column">
		        		<h4 class="ui primary header">Happiness guaranteed</h4>

		        		<small>
		        			Pick different map style, change map elements and apply any colour you desire.
		        		</small>
		        	</div>
		        	<div class="column">
		        		<h4 class="ui primary header">Fast and free delivery</h4>

		        		<small>
		        			Instant preview and download option. 1 day processing time for prints. Fastest service guaranteed.
		        		</small>
		        	</div>
		        </div>
		    </section>

			<div class="ui horizontal divider"></div>
	
		    <section class="third section">
		    	<h2 class="ui center aligned primary header">
		        	QUALITY WITHOUT COMPROMISE
		        </h2>

		        <div class="ui grid">
		        	<div class="nine wide column">
		        		<div class="ui inverted segment">
			        		Exceptional print quality, we use the latest HP large format printers, genuine HP inks and high quality 260gsm satin paper.

			        		<br/><br/>

							<div class="ui list">
								<div class="item">
									<i class="right triangle icon"></i>
									<div class="content">
			        					Fast processing, usually dispatched within ONE working day (same day if ordered before 2pm BST i.e. UK time).
			        				</div>
			        			</div>
								<div class="item">
									<i class="right triangle icon"></i>
									<div class="content">
			        					Fast & FREE shipping from the UK to the world.
			        				</div>
			        			</div>
								<div class="item">
									<i class="right triangle icon"></i>
									<div class="content">
			        					FREE returns.
			        				</div>
			        			</div>
								<div class="item">
									<i class="right triangle icon"></i>
									<div class="content">
			        					Unlimited colour and design combination.
			        				</div>
			        			</div>
								<div class="item">
									<i class="right triangle icon"></i>
									<div class="content">
			        					15 different paper sizes, 3 different standards.
			        				</div>
			        			</div>
								<div class="item">
									<i class="right triangle icon"></i>
									<div class="content">
			        					Exceptional value for money. From $24.99.
			        				</div>
			        			</div>
			        		</div>
			        	</div>
			        </div>
		        	<div class="column">
		        	</div>
		        </div>
		    </section>

		    <div class="ui horizontal divider"></div>

		    <section class="fourth section">
		    	<h2 class="ui center aligned primary header">
		        	PRECISE TO THE SECOND
		        </h2>

		        <div class="ui grid">
		        	<div class="column">
		        	</div>
		        	<div class="nine wide column">
		        		<div class="ui inverted segment">
			        		ESA launched Hipparcos satellite in 1989. Hipparcos was the first experiment that was dedicated to precision astrometry. When the collected data was combined with radial velocity measurements from spectroscopy, it produced the high-precision Hipparcos Catalogue.

			        		<br/><br/>

			        		Using algorithm and Hipparcos Catalogue we can accurately show the position of the stars from any locaton for any date and time.
			        	</div>
			        </div>		   
		        </div>
		    </section>

		    <div class="ui horizontal divider"></div>

		    <section class="fifth section">
		        <h2 class="ui center aligned primary header">
		        	WHY CHOOSE US
		        </h2>

		        <div class="ui equal width grid">
		        	<div class="column">
		        		<h4 class="ui primary header">Unlimited design options</h4>

		        		<small>
		        			Start by entering a location name and our easy to use map editor will do the rest.
		        		</small>
		        	</div>
		        	<div class="column">
		        		<h4 class="ui primary header">Happiness guaranteed</h4>

		        		<small>
		        			Pick different map style, change map elements and apply any colour you desire.
		        		</small>
		        	</div>
		        	<div class="column">
		        		<h4 class="ui primary header">Fast and free delivery</h4>

		        		<small>
		        			Instant preview and download option. 1 day processing time for prints. Fastest service guaranteed.
		        		</small>
		        	</div>
		        </div>
		    </section>

		    <div class="ui horizontal divider"></div>

		    <section class="sixth section">
		        <h2 class="ui center aligned primary header">
		        	BE INSPIRED
		        </h2>

		        <div class="ui equal width grid">
		        	@for($i = 0; $i != 4; $i ++)
		        	<div class="row">
		        		<div class="column">
		        			<img class="ui image" src="https://via.placeholder.com/200x200">
		        		</div>
		        		<div class="column">
		        			<img class="ui image" src="https://via.placeholder.com/200x200">
		        		</div>
		        		<div class="column">
		        			<img class="ui image" src="https://via.placeholder.com/200x200">
		        		</div>
		        		<div class="column">
		        			<img class="ui image" src="https://via.placeholder.com/200x200">
		        		</div>
		        	</div>
		        	@endfor
		        </div>
		    </section>
	    </div>
	</div>
@endsection