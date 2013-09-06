<nav id = 'navbar' class="navbar navbar-default navbar-fixed-top navbar-inverse"
	role="navigation">

	<div class='container'>
		<a class="navbar-brand" href="/">GG Framework</a>
		<ul class="nav navbar-nav">
			<li class="active"><a href="#compatibility">Compatibility</a></li>
			<li ><a href="#dbSupport">Database Support</a></li>
			<li ><a href="#cssJs">CSS &amp; JS</a></li>
			<li ><a href="#next">What to do next?</a></li>
		</ul>
	</div>


</nav>
<div id="welcome">

	<div class='jumbotron'>
		<h1><?php echo FRAMEWORK ?> version <?php echo frameworkVersion() ?></h1>
		<p>Welcome to my own php web framework!</p>
	</div>

	<p>
		This view is found under
		<code>views/index.php</code>
		. I invite you to remove it and replace it by your own!
	</p>

	<hr />
	
	<section id = "compatibility" class='clear-navbar'>
		<h3 >Compatibility</h3>
	
		<p class="well">
			This framework is compatible with all versions &gt; <strong>PHP 5.3 </strong>
			.
		</p>
		<p>This should not be an issue for you at this point or you would
			probably not be seeing this page otherwise!</p>
	</section>
	

	<hr />
	
	<section id = "dbSupport">
		<h3>Database Support</h3>
		<p class="well">
			This framework support at this time only: <strong>MySQL </strong>.
		</p>
		<p>Support for other databases will be added when needed.</p>
	</section>
	
	<hr />
	
	<section id = 'cssJs'>
		<h3>Twitter Bootstrap v 3 -  FontAwsome - jQuery</h3>
		<p class="well">Twitter Bootstrap v3, FontAwsome and jQuery are included per
			default.
		
		
		<p>If you are not seeing any styling, check your internet connection!</p>
	
		<p>If you'd rather not use them, just remove the relevant links to the
			CDNs in:
		
		
		<ul>
			<li><code>views/components/page_head.php</code></li>
			<li><code>views/components/page_tail.php</code></li>
		</ul>
	
	</section>
	
	<hr />
	
	<section id = "next">
		<h3>What to do next?</h3>

		<ul>
			<li>Read the <code>README</code> file to learn more on how to use the
				framework.
			</li>
			<li>Review the skeleton app <?php echo link_to('#blog', "Mini Blog"); ?>.</li>
			<li>Review the <code>config.php</code> file.
			</li>
			<li>Create controllers inside the <code>controllers/</code> directory.
			</li>
			<li>Create models inside the <code>models/</code> directory.
			</li>
			<li>Create views inside the <code>views/</code> directory.
			</li>
			<li>Create view helpers inside the <code>helpers/</code> directory.
			</li>
		</ul>
	</section>

	<hr />

	<section id="blog">
		<h3 >The Mini Blog skeleton app</h3>
	
		<p>To set up the example application:</p>
		<ul>
			<li>Add database connection information to the <code>config.php</code>
				file.
			</li>
			<li>Create the <code>posts</code> table in your database of choice: <br />
				<pre>
				CREATE TABLE test (
					id INT AUTO_INCREMENT,
					title VARCHAR(45) NOT NULL,
					body TEXT NOT NULL,
					PRIMARY KEY(id)
				) DEFAULT CHARACTER SET utf8;
				</pre>
	
			</li>
			<li>Explore <?php echo link_to('/posts', "Mini Blog"); ?> - It should not take too long.</li>
		</ul>
	</section>
	

</div>



