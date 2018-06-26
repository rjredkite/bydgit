<div class="body-container">
	<div class="pages-admin-container">
		<h1>New Page</h1>
		<hr>
		<?php echo form_open_multipart('admin/pages/new'); ?>
			<div class="row">
				<div class="col-md-2">
					<label for="page-title">* Title</label>
				</div>
				<div class="col-md-10">
					<input id="page-title" class="textbox-nomargin" type="text" name="page_title" required>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="page-url">* Url</label>
				</div>
				<div class="col-md-10">
					<input id="page-url" class="textbox-nomargin" type="text" name="page_url" required>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="page-description">Description</label>
				</div>
				<div class="col-md-10">
					<textarea id="page-description" name="page_description" rows="4" cols="50"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="page-content">* Content</label>
				</div>
				<div class="col-md-10">
					<textarea id="page-content" name="page_content" required></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="page-published-new">Published</label>
				</div>
				<div class="col-md-10">
					<input id="page-published-new" class="checkbox" type="checkbox" name="page_published">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="page-template">* Template</label>
				</div>
				<div class="col-md-10">
					<select id="page-template" name="page_template" required>
						<option></option>
						<option value="show">Standard Page</option>
						<option value="home">Home Page</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="page-language">* Language</label>
				</div>
				<div class="col-md-10">
					<select id="page-language" name="page_language" required>
						<option></option>
						<option value="en" selected>English</option>
						<option value="us">American</option>
					</select>
				</div>
			</div>
			
			<hr class="page-seperator">

			<h2>SEO Settings</h2>

			<div class="row">
				<div class="col-md-2">
					<label for="page-seo-title">SEO Title</label>
				</div>
				<div class="col-md-10">
					<input id="page-seo-title" class="textbox-nomargin" type="text" name="page_seo_title">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="page_keyword">Meta Keyword</label>
				</div>
				<div class="col-md-10">
					<input id="page_keyword" class="textbox-nomargin" type="text" name="page_meta_keyword" maxlength="160">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="page-meta-description">Meta Description</label>
				</div>
				<div class="col-md-10">
					<input id="page-meta-description" class="textbox-nomargin" type="text" name="page_meta_description" maxlength="160">
					<p style="margin-top: 5px;">The meta description will be limited to <b>160</b> chars.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label>Meta Robots Index</label>
				</div>
				<div class="col-md-10">
					<label for="page-index" class="radio-inline"><input id="page-index" type="radio" name="page_index" value="1" checked>Index</label>
					<label for="page-noindex" class="radio-inline"><input id="page-noindex" type="radio" name="page_index" value="0">No Index</label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label>Meta Robots Follow</label>
				</div>
				<div class="col-md-10">
					<label for="page-follow" class="radio-inline"><input id="page-follow" type="radio" name="page_follow" value="1" checked>Follow</label>
					<label for="page-nofollow" class="radio-inline"><input id="page-nofollow" type="radio" name="page_follow" value="0">No Follow</label>
				</div>
			</div>
			<hr>
			<button type="submit" class="btn button-primary">Save Changes</button>
			<a href="<?php echo base_url(); ?>admin/pages" class="btn button-cancel">Cancel</a>
		<?php echo form_close(); ?>
	</div>
</div>
<script>
    CKEDITOR.replace( 'page-content' );
</script>