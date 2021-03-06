<div class="row">
	<div class="col-lg-10">
		<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					<?php echo get_phrase('category_add_form'); ?>
				</div>
			</div>
			<div class="panel-body">

				<form action="<?php echo site_url('admin/categories/add'); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal form-groups-bordered">

					<div class="form-group">
						<label for="name" class="col-sm-3 control-label"><?php echo get_phrase('category_title'); ?></label>

						<div class="col-sm-7">
							<input type="text" class="form-control" name="name" id="name" placeholder="<?php echo get_phrase('provide_category_name'); ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="parent" class="col-sm-3 control-label"><?php echo get_phrase('parent_category'); ?></label>

						<div class="col-sm-7">
							<select name="parent" id = "parent" class="select2" data-allow-clear="true" data-placeholder="<?php echo get_phrase('select_parent_category'); ?>" onchange="checkCategoryType(this.value)">
								<option value="0"><?php echo get_phrase('none'); ?></option>
								<?php foreach ($categories as $category): ?>
									<?php if ($category['parent'] == 0): ?>
										<option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="form-group" id = "icon-picker-area">
						<label for="font_awesome_class" class="col-sm-3 control-label"><?php echo get_phrase('icon_picker'); ?></label>

						<div class="col-sm-7">
							<input type="text" name="icon_class" class="form-control icon-picker" autocomplete="off" required>
						</div>
					</div>

					<div class="form-group" id = "thumbnail-picker-area">
						<label class="col-sm-3 control-label"><?php echo get_phrase('category_thumbnail'); ?> <small>(400 X 255)</small> </label>

						<div class="col-sm-7">

							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
									<img src="<?php echo base_url('mobile/uploads/category_thumbnails/thumbnail.png'); ?>" alt="...">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
								<div>
									<span class="btn btn-white btn-file">
										<span class="fileinput-new"><?php echo get_phrase('select_image'); ?></span>
										<span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
										<input type="file" name="category_thumbnail" accept="image/*">
									</span>
									<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-offset-3 col-sm-5" style="padding-top: 10px;">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('add_category'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- end col-->
</div>

<script type="text/javascript">
function checkCategoryType(category_type) {
	if (category_type > 0) {
		$('#thumbnail-picker-area').hide();
	}else {
		$('#thumbnail-picker-area').show();
	}
}
</script>
