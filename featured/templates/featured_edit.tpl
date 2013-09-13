{config_load file=featured_lang_conf}
<div id="featured">

	<legend><a href="./module.php?module=featured"><i class="icon-circle-arrow-left"></i></a> {#PLIGG_featured#}</legend>
	
	{if $msg ne ''}
		<div class="alert alert-success">
			{$msg}
		</div>
	{/if}
	{if $err ne ''}
		<div class="alert alert-danger">
			{$err}
		</div>
	{/if}
	
	<form action="{$featured_URL}&amp;action=editfeatured" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
		<input type="hidden" value="{$news[0].featured_id}" id="id" name="id">
		
		<div class="form-group">
			<label for="featured_link_id" class="col-lg-2 control-label">{#PLIGG_featured_ID#}</label>
			<div class="col-lg-10">
				<input type="text" class="form-control" id="featured_link_id" value="{$news[0].featured_link_id}" name="featured_link_id" />
				<span class="help-block">The story ID is used to retrieve the URL, vote count, and comment count.</span>
			</div>
		</div>
		
		<div class="form-group">
			<label for="featured_link_title" class="col-lg-2 control-label">{#PLIGG_featured_Title2#}</label>
			<div class="col-lg-10">
				<input type="text" class="form-control" id="featured_link_title" value="{$news[0].featured_link_title}" name="featured_link_title" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="featured_description" class="col-lg-2 control-label">{#PLIGG_featured_Description#}</label>
			<div class="col-lg-10">
				<textarea class="form-control" rows="8" id="featured_description" name="featured_description">{$news[0].featured_description}</textarea>
			</div>
		</div>
		
		{*
		<div class="form-group">
			<label for="status" class="col-lg-2 control-label">{#PLIGG_featured_Status#}</label>
			<div class="col-lg-10">
				<input type="radio" id="status" name="status" value="Yes" {if $news[0].featured_enabled eq 'Yes'}checked="checked"{/if} />{#PLIGG_featured_Yes#}
				&nbsp; &nbsp;
				<input type="radio" name="status" value="No" {if $news[0].featured_enabled eq 'No'}checked="checked"{/if} />{#PLIGG_featured_No#}
				<span class="help-block">Disabling a featured news item will temporarily remove it from public view.</span>
			</div>
		</div>
		*}
		
		<div class="form-group">
			<label for="status" class="col-lg-2 control-label">{#PLIGG_featured_CurrentImage#}</label>
			<div class="col-lg-10">
				<div class="tabbable">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#preview" data-toggle="tab">Preview Image</a></li>
						<li><a href="#edit" data-toggle="tab">Edit Image</a></li>
					</ul>

					<div class="tab-content">
						<div id="preview" class="tab-pane active">
							<div class="col-lg-10">
								<img src="{$featured_URL}&amp;action=view_image&amp;id={$news[0].featured_id}" alt="{$news[0].featured_link_title}" />
							</div>
						</div>
						<div id="edit" class="tab-pane">
							<div class="col-lg-10">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" /></div>
									<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
									<div>
										<span class="btn btn-success btn-file"><span class="fileupload-new">{#PLIGG_featured_Select#}</span>
										<span class="fileupload-exists">{#PLIGG_featured_Change#}</span><input type="file" name="image" /></span>
										<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">{#PLIGG_featured_Remove#}</a>
									</div>
								</div>
							</div>
						</div>
					</div><!-- /.tab-content -->
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="submit" class="col-lg-2 control-label">{#PLIGG_Featured_Submit#}</label>
			<div class="col-lg-10">
				<a href="{$featured_URL}" class="btn btn-default">{#PLIGG_featured_Back#}</a>
				<input type="submit" name="submit" class="btn btn-primary" value="{#PLIGG_featured_Edit2#}" />
			</div>
		</div>
		
	</form>		
</div>
{config_load file=featured_pligg_lang_conf}