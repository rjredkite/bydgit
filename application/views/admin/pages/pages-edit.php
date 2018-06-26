<div class="body-container">
	<div class="pages-admin-container">
		<h1>Edit Page</h1>
		<hr>
		<?php foreach($pagesedits as $edit) : ?>
			<?php echo form_open(''); ?>			
				<div class="row">
					<div class="col-md-2">
						<label for="page-title">* Title</label>
					</div>
					<div class="col-md-10">
						<input id="page-title" class="textbox-nomargin" type="text" name="page_title" value="<?php echo $edit['title']; ?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="page-url">* Url</label>
					</div>
					<div class="col-md-10">
						<input id="page-url" class="textbox-nomargin" type="text" name="page_url" value="<?php echo $edit['url']; ?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="page-description">Description</label>
					</div>
					<div class="col-md-10">
						<textarea id="page-description" name="page_description" rows="4" cols="50"><?php echo $edit['description']; ?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="page-content">* Content</label>
					</div>
					<div class="col-md-10">
						<textarea id="page-content" name="page_content"><?php echo $edit['content']; ?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="page-published">Published</label>
					</div>
					<div class="col-md-10">
						<input id="page-published" class="checkbox" type="checkbox" name="page_published" 
							<?php
								if($edit['published'] == 1){
									echo 'checked';
								}
							?>
						>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="page-template">* Template</label>
					</div>
					<div class="col-md-10">
						<select id="page-template" name="page_template" required>
							<option></option>
							<option value="show" 
								<?php 
									if($edit['template'] == 'show'){
										echo 'selected';
									}
								?>
							>Standard Page</option>
							<option value="home"
								<?php 
									if($edit['template'] == 'home'){
										echo 'selected';
									}
								?>
							>Home Page</option>
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
							<option value="en" selected
								<?php 
									if($edit['language'] == 'en'){
										echo 'selected';
									}
								?>
							>English</option>
							<option value="us"
								<?php 
									if($edit['language'] == 'us'){
										echo 'selected';
									}
								?>
							>American</option>
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
						<input id="page-seo-title" class="textbox-nomargin" type="text" name="page_seo_title" value="<?php echo $edit['meta_title']; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="page_keyword">Meta Keyword</label>
					</div>
					<div class="col-md-10">
						<input id="page_keyword" class="textbox-nomargin" type="text" name="page_meta_keyword" maxlength="160" value="<?php echo $edit['meta_keyword']; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="page-meta-description">Meta Description</label>
					</div>
					<div class="col-md-10">
						<input id="page-meta-description" class="textbox-nomargin" type="text" name="page_meta_description" maxlength="160" value="<?php echo $edit['meta_description']; ?>">
						<p style="margin-top: 5px;">The meta description will be limited to <b>160</b> chars.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label>Meta Robots Index</label>
					</div>
					<div class="col-md-10">
						<label for="page-index" class="radio-inline"><input id="page-index" type="radio" name="page_index" value="1"	<?php 
								if($edit['meta_robots'] == 'INDEX,FOLLOW' || $edit['meta_robots'] == 'INDEX,NOFOLLOW'){
										echo 'checked';
								}
							?> 
						>Index</label>
						<label for="page-noindex" class="radio-inline"><input id="page-noindex" type="radio" name="page_index" value="0"
							<?php 
								if($edit['meta_robots'] == 'NOINDEX,FOLLOW' || $edit['meta_robots'] == 'NOINDEX,NOFOLLOW'){
										echo 'checked';
								}
							?>
						>No Index</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label>Meta Robots Follow</label>
					</div>
					<div class="col-md-10">
						<label for="page-follow" class="radio-inline"><input id="page-follow" type="radio" name="page_follow" value="1" 
							<?php 
								if($edit['meta_robots'] == 'INDEX,FOLLOW' || $edit['meta_robots'] == 'NOINDEX,FOLLOW'){
										echo 'checked';
								}
							?>
						>Follow</label>
						<label for="page-nofollow" class="radio-inline"><input id="page-nofollow" type="radio" name="page_follow" value="0"
							<?php 
								if($edit['meta_robots'] == 'INDEX,NOFOLLOW' || $edit['meta_robots'] == 'NOINDEX,NOFOLLOW'){
										echo 'checked';
								}
							?>
						>No Follow</label>
					</div>
				</div>
				<hr>
				<button type="submit" class="btn button-primary">Save Changes</button>
				<a href="<?php echo base_url(); ?>admin/pages" class="btn button-cancel">Cancel</a>
			<?php echo form_close(); ?>
		<?php endforeach; ?>
	</div>
</div>

<div id="checkbox-admin" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Unpublished</h4>
      </div>
      <div class="modal-body">
        <p style="text-align: center;color:#6b6b6b;font-style: italic;">Are you sure you want to Unpublished this page ?</p>
      </div>
      <div class="modal-footer">
      	<button id="page-edit-yes" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-check" aria-hidden="true"></i> YES</button>
        <button id="page-edit-no" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> NO</button>
      </div>
    </div>
  </div>
</div>

<script>
    CKEDITOR.replace( 'page-content' );
</script>