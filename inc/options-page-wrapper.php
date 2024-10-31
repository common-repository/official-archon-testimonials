<?php
	global $wpdb;
	$plugin_table = 'testimonials_by_archon';
	$table_name = $wpdb->prefix . $plugin_table;
	$row_id = $wpdb->get_results( 'SELECT id, author, content FROM ' . $table_name, ARRAY_N);
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<h2>Testimonials by Archon options</h2>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<!-- main content -->
			<div id="post-body-content">
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox">
						<h3><span>Add a new testimonial</span></h3>
						<div class="inside">
							<form method="post" action="">
								<table class="form-table">
									<tr>
										<td>
											<label for="testimonial_content">Testimonial Content</label>
										</td>
										<td>
											<textarea name="testimonial_content" id="testimonial_content" type="text" value="" class="regular-text" cols="37"></textarea>
										</td>
									</tr>
									<tr>
										<td>
											<label for="testimonial_author">Testimonial Author</label>
										</td>
										<td>
											<input name="testimonial_author" id="testimonial_author" type="text" value="" class="regular-text" cols="37" />
										</td>
									</tr>
								</table>
								<p>
									<input class="button-primary" type="submit" name="testimonial_submit" value="Save" /> 
								</p>
							</form>
						</div> <!-- .inside -->
					</div> <!-- .postbox -->
					<div class="postbox">
						<h3><span>Edit testimonials</span></h3>
						<div class="inside">
							<select name="" id="testimonial_dropdown">
								<option value="">Testimonial to edit</option>
								<?php foreach ($row_id as $val) { ?>
									<option value="<?php echo $val[0]; ?>"><?php echo $val[1] . ' id=' . $val[0]; ?></option>
								<?php } ?>
							</select>
							<?php foreach ($row_id as $val) { ?>
								<div data-id="<?php echo $val[0]; ?>" style="display: none;">
									<span data-type="author"><?php echo $val[1]; ?></span>
									<span data-type="content"><?php echo $val[2]; ?></span>
								</div>
							<?php } ?>
							<form action="" method="post">
								<input type="hidden" name="testimonial_id" value="1">
								<table class="form-table">
									<tbody>
										<tr>
											<td>
												<label for="testimonial_content_edit">Testimonial Content</label>
											</td>
											<td>
												<textarea cols="37" class="regular-text" value="" type="text" id="testimonial_content_edit" name="testimonial_content_edit"></textarea>
											</td>
										</tr>
										<tr>
											<td>
												<label for="testimonial_author">Edit Testimonial Author</label>
											</td>
											<td>
												<input type="text" cols="37" class="regular-text" value="" id="testimonial_author_edit" name="testimonial_author_edit">
											</td>
										</tr>
									</tbody>
								</table>
								<p>
									<input type="submit" value="Update" name="testimonial_submit_edit" class="button-primary"> 
								</p>
							</form>
						</div> <!-- .inside -->
					
					</div> <!-- .postbox -->
					
				</div> <!-- .meta-box-sortables .ui-sortable -->

			</div> <!-- post-body-content -->
			<!-- sidebar start -->
			<div class="postbox-container" id="postbox-container-1">
				<div class="meta-box-sortables">
					<div class="postbox">
						<h3><span>Shortcode Examples</span></h3>
						<div class="inside">
							<p>[testimonial]</p>
							<blockquote class="testimonial"><p>It was excellent! Please keep creating!</p></blockquote>
							<p class="testimonial-author">Jane Doe</p>
							<p>[testimonial id=1]</p>
							<blockquote class="testimonial"><p>As always, a pleasure to work with the Archon team</p></blockquote>
							<p class="testimonial-author">Grey inc</p>
							<p>[testimonial id=random]</p>
							<blockquote class="testimonial"><p>Archon did a great job on our project</p></blockquote>
							<p class="testimonial-author">John Doe</p>
						</div> <!-- .inside -->
					</div> <!-- .postbox -->
				</div> <!-- .meta-box-sortables -->
			</div><!-- #postbox-container-1 .postbox-container -->
			<!-- sidebar end -->
		</div> <!-- #post-body .metabox-holder .columns-2 -->
		<br class="clear">
	</div> <!-- #poststuff -->
</div> <!-- .wrap -->