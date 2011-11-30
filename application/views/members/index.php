<?php echo heading('Logged in [Member] page', 1, 'class="page_header"'); ?>

<div id="home_view">

	<ul class="nvc_selection">

		<li>

			<?php echo anchor('members/upload',

				'<div class="nvc_item">

					<h2 class="nvc_link">Upload</h2>

					<h3 class="nvc_tagline">Upload your files</h3>

				</div>'); ?>

		</li>

		<li>

			<?php echo anchor('secure/page2',

				'<div class="nvc_item">

					<h2 class="nvc_link">Secure sample page two</h2>

					<h3 class="nvc_tagline">Secure and simple example</h3>

				</div>'); ?>

		</li>

		<li>

			<?php echo anchor('secure/page3',

				'<div class="nvc_item">

					<h2 class="nvc_link">Secure sample page three</h2>

					<h3 class="nvc_tagline">Secure and simple example</h3>

				</div>'); ?>

		</li>

	</ul>

</div>