<?php
/*-----------------------------------------------------------------------------------*/
/*	Add Metaboxes
/*-----------------------------------------------------------------------------------*/

add_action( 'load-post.php', 'vce_meta_boxes_setup' );
add_action( 'load-post-new.php', 'vce_meta_boxes_setup' );

/* Meta box setup function. */
if ( !function_exists( 'vce_meta_boxes_setup' ) ) :
	function vce_meta_boxes_setup() {
		global $typenow;
		if ( $typenow == 'page' ) {
			add_action( 'add_meta_boxes', 'vce_load_page_metaboxes' );
			add_action( 'save_post', 'vce_save_page_metaboxes', 10, 2 );
		}

		if ( $typenow == 'post' ) {
			add_action( 'add_meta_boxes', 'vce_load_post_metaboxes' );
			add_action( 'save_post', 'vce_save_post_metaboxes', 10, 2 );
		}
	}
endif;

/* Add page metaboxes */
if ( !function_exists( 'vce_load_page_metaboxes' ) ) :
	function vce_load_page_metaboxes() {

		/* Sidebar metabox */
		add_meta_box(
			'vce_sidebar',
			__( 'Sidebar', THEME_SLUG ),
			'vce_sidebar_metabox',
			'page',
			'side',
			'default'
		);

		/* Featured area metabox */
		add_meta_box(
			'vce_hp_fa',
			__( 'Featured Area/Slider', THEME_SLUG ),
			'vce_fa_metabox',
			'page',
			'normal',
			'high'
		);

		/* Modules metabox */
		add_meta_box(
			'vce_hp_modules',
			__( 'Modules', THEME_SLUG ),
			'vce_modules_metabox',
			'page',
			'normal',
			'high'
		);

		/* Content metabox */
		add_meta_box(
			'vce_hp_content',
			__( 'Page Content/Editor Options', THEME_SLUG ),
			'vce_page_content_metabox',
			'page',
			'normal',
			'high'
		);


	}
endif;

/* Add post metaboxes */
if ( !function_exists( 'vce_load_post_metaboxes' ) ) :
	function vce_load_post_metaboxes() {

		/* Sidebar metabox */
		add_meta_box(
			'vce_sidebar',
			__( 'Sidebar', THEME_SLUG ),
			'vce_sidebar_metabox',
			'post',
			'side',
			'default'
		);

	}
endif;


/* Create Sidebars Metabox */
if ( !function_exists( 'vce_sidebar_metabox' ) ) :
	function vce_sidebar_metabox( $object, $box ) {
		$vce_meta = vce_get_post_meta( $object->ID );
		$sidebars_lay = vce_get_sidebar_layouts( true );
		$sidebars = vce_get_sidebars_list( true );
?>
	  	<ul class="vce-img-select-wrap">
	  	<?php foreach ( $sidebars_lay as $id => $layout ): ?>
	  		<li>
	  			<?php $selected_class = $id == $vce_meta['use_sidebar'] ? ' selected': ''; ?>
	  			<img src="<?php echo $layout['img']; ?>" title="<?php echo $layout['title']; ?>" class="vce-img-select<?php echo $selected_class; ?>">
	  			<span><?php echo $layout['title']; ?></span>
	  			<input type="radio" class="vce-hidden" name="vce[use_sidebar]" value="<?php echo $id; ?>" <?php checked( $id, $vce_meta['use_sidebar'] );?>/> </label>
	  		</li>
	  	<?php endforeach; ?>
	   </ul>

	   <p class="description"><?php _e( 'Sidebar layout', THEME_SLUG ); ?></p>

	  <?php if ( !empty( $sidebars ) ): ?>

	  	<p><select name="vce[sidebar]" class="widefat">
	  	<?php foreach ( $sidebars as $id => $name ): ?>
	  		<option value="<?php echo $id; ?>" <?php selected( $id, $vce_meta['sidebar'] );?>><?php echo $name; ?></option>
	  	<?php endforeach; ?>
	  </select></p>
	  <p class="description"><?php _e( 'Choose standard sidebar to display', THEME_SLUG ); ?></p>

	  	<p><select name="vce[sticky_sidebar]" class="widefat">
	  	<?php foreach ( $sidebars as $id => $name ): ?>
	  		<option value="<?php echo $id; ?>" <?php selected( $id, $vce_meta['sticky_sidebar'] );?>><?php echo $name; ?></option>
	  	<?php endforeach; ?>
	  </select></p>
	  <p class="description"><?php _e( 'Choose sticky sidebar to display', THEME_SLUG ); ?></p>

	  <?php endif; ?>
	  <?php
	}
endif;

/* Create Featured area Metabox */
if ( !function_exists( 'vce_fa_metabox' ) ) :
	function vce_fa_metabox( $object, $box ) {
		$vce_meta = vce_get_page_meta( $object->ID );
		$fa_layouts = vce_get_featured_area_layouts( false, true );
		$order = vce_get_post_order_opts();
		$cats = get_categories( array( 'hide_empty' => false, 'number' => 0 ) );
		$time = vce_get_time_diff_opts();
?>		
	   <div class="vce-opt-item">
	   <strong><?php _e( 'Choose layout', THEME_SLUG ); ?>:</strong>
	   <ul class="vce-img-select-wrap">
	  	<?php foreach ( $fa_layouts as $id => $layout ): ?>
	  		<li>
	  			<?php $selected_class = vce_compare( $id, $vce_meta['fa_layout'] ) ? ' selected': ''; ?>
	  			<img src="<?php echo $layout['img']; ?>" title="<?php echo $layout['title']; ?>" class="vce-img-select<?php echo $selected_class; ?>">
	  			<input type="radio" class="vce-hidden" name="vce[fa_layout]" value="<?php echo $id; ?>" <?php checked( $id, $vce_meta['fa_layout'] );?>/> </label>
	  		</li>
	  	<?php endforeach; ?>
	   </ul>
	   <p><strong><?php _e( 'Number of posts', THEME_SLUG ); ?>:</strong> <input type="text" name="vce[fa_limit]" class="small-text" value="<?php echo $vce_meta['fa_limit']; ?>"/></p>
	   <p><strong><?php _e( 'Choose posts (or pages) manually', THEME_SLUG ); ?>:</strong></p>
	   <input type="text" name="vce[fa_manual]" value="<?php echo implode( ",", $vce_meta['fa_manual'] ); ?>" style="width: 100%;" /><br/>
	   <small class="howto"><?php _e( 'Specify post ids separated by comma if you want to select only those posts. i.e. 213,32,12,45', THEME_SLUG ); ?></small>
	  </div>

	   <?php if ( !empty( $cats ) ): ?>
	   <div class="vce-opt-item">
	   		<strong><?php _e( 'Filter by category', THEME_SLUG ); ?>:</strong><br/>
	   		<div class="vce-item-scroll">
	   		<?php foreach ( $cats as $cat ) : ?>
	   			<?php $checked = in_array( $cat->term_id, $vce_meta['fa_cat'] ) ? 'checked="checked"' : ''; ?>
	   			<label><input type="checkbox" name="vce[fa_cat][]" value="<?php echo $cat->term_id ?>" <?php echo $checked; ?> /><?php echo $cat->name;?></label><br/>
	   		<?php endforeach; ?>
	   		</div>
	   		<br/>
	   		<label><input type="checkbox" name="vce[fa_cat_child]" value="1" class="vce-count-me" <?php checked( $vce_meta['fa_cat_child'], 1  );?>/><strong><?php _e( 'Apply child categories', THEME_SLUG ); ?></strong></label><br/>
		    		<small class="howto"><?php _e( 'If parent category is selected, posts from child categories will be included automatically', THEME_SLUG ); ?></small>
	   	</div>
	   	<?php endif; ?>
	   <div class="vce-opt-item">
	   <strong><?php _e( 'Order posts by', THEME_SLUG ); ?>:</strong><br/>
	   <?php foreach ( $order as $id => $title ) : ?>
	   <label><input type="radio" name="vce[fa_order]" value="<?php echo $id; ?>" <?php checked( $vce_meta['fa_order'], $id ); ?> /><?php echo $title;?></label><br/>
	   <?php endforeach; ?>
	   </div>

	   <div class="vce-opt-item">
	   <strong><?php _e( 'Posts are not older than', THEME_SLUG ); ?>:</strong><br/>
	   <?php foreach ( $time as $id => $title ) : ?>
	   <label><input type="radio" name="vce[fa_time]" value="<?php echo $id; ?>" <?php checked( $vce_meta['fa_time'], $id ); ?> /><?php echo $title;?></label><br/>
	   <?php endforeach; ?>
	   </div>

	   
	   <div class="clear"></div>
	   <p><label><input type="checkbox" name="vce[fa_exclude]" value="1" <?php checked( $vce_meta['fa_exclude'], 1 )?>/><strong><?php _e( 'Do not duplicate', THEME_SLUG ); ?></strong></label>
	   <br/>
	   <small class="howto"><?php _e( 'Check this option to always exclude featured area posts from modules below so they don\'t appear twice', THEME_SLUG ); ?></small></p>

	<?php
	}
endif;

/* Create Modules Metabox */
if ( !function_exists( 'vce_modules_metabox' ) ) :
	function vce_modules_metabox( $object, $box ) {

		$vce_meta = vce_get_page_meta( $object->ID );

		$data = array(
			'layouts' => vce_get_main_layouts(),
			'starter_layouts' => vce_get_main_layouts( false, true ),
			'cats' => get_categories( array( 'hide_empty' => false, 'number' => 0 ) ),
			'order' => vce_get_post_order_opts(),
			'time' => vce_get_time_diff_opts(),
			'actions' => vce_get_module_actions(),
			'paginations' => vce_get_pagination_layouts()
		);

		$module_def = array(
			'layout' => 'c',
			'title' => '',
			'limit' => 4,
			'manual' => array(),
			'cat' => array(),
			'time' => 0,
			'order' => 'date',
			'top_layout' => 0,
			'top_limit' => 2,
			'one_column' => 0,
			'action' => 0,
			'pagination' => 'load-more',
			'action_link_text' => 'View all',
			'action_link_url' => 'http://',
			'cat_child' => 0

		);

		//print_r($vce_meta['modules']);
?>

		<ul id="vce-modules-wrap">
			<?php if ( !empty( $vce_meta['modules'] ) ) : ?>
			<?php foreach ( $vce_meta['modules'] as $i => $module ) : $module = wp_parse_args( (array) $module, $module_def ); ?>
			<li data-module="<?php echo $i; ?>">
				<span class="module-title"><?php echo $module['title']; ?></span> <span class="actions"> <a href="#" class="vce-edit-module">Edit</a> | <a href="#" class="vce-remove-module">Remove</a></span>
				<?php vce_generate_module_field( $module, $i, $data ); ?>
			</li>
			<?php endforeach; ?>
			<?php endif; ?>
		</ul>

		<p><a id="vce-add-module" href="javascript:void(0);" class="button-secondary"><?php _e( 'Add new module', THEME_SLUG ); ?></a></p>

		<div id="vce-modules-count" data-count="<?php echo count( $vce_meta['modules'] ); ?>"></div>

		<?php vce_generate_module_field( $module_def, false, $data ); ?>

	<?php
	}
endif;

/* Generate module form */
if ( !function_exists( 'vce_generate_module_field' ) ) :
	function vce_generate_module_field( $module, $i = false, $data ) {
		extract( $data );
		$mod_id = ( $i === false ) ?  'vce-hidden-module' : 'vce-hidden-module-'.$i;
		$name_prefix = ( $i === false ) ? '' :  'vce[modules]['.$i.']';
		$edit = ( $i === false ) ? '' :  'edit';
?>
		<div id="<?php echo $mod_id; ?>" class="vce-hidden-module">
		<div class="vce-module-form <?php echo $edit; ?>">
			<ul class="vce-tabs-nav">
				<li class="active"><a href="#"><?php _e( 'Appearance', THEME_SLUG ); ?></a></li>
				<li><a href="#"><?php _e( 'Combine layouts', THEME_SLUG ); ?></a></li>
				<li><a href="#"><?php _e( 'Post selection', THEME_SLUG ); ?></a></li>
				<li><a href="#"><?php _e( 'Action', THEME_SLUG ); ?></a></li>
				<li class="save"><a class="vce-save-module button-primary" href="javascript:void(0);"><?php _e( 'Save Module', THEME_SLUG ); ?></a></li>
			</ul>
			<div class="vce-tabs-wrap">
		    <div class="vce-tab">
			<p>
				<strong><?php _e( 'Title', THEME_SLUG ); ?>:</strong><br/>
				<input class="vce-count-me" type="text" name="<?php echo $name_prefix; ?>[title]" value="<?php echo $module['title'];?>"/><br/>
				<small class="howto"><?php _e( 'Enter your module title', THEME_SLUG ); ?></small>
			</p>
			<p><strong><?php _e( 'Choose layout', THEME_SLUG ); ?>:</strong></p>
		    <ul class="vce-img-select-wrap">
		  	<?php foreach ( $layouts as $id => $layout ): ?>
		  		<li>
		  			<?php $selected_class = vce_compare( $id, $module['layout'] ) ? ' selected': ''; ?>
		  			<img src="<?php echo $layout['img']; ?>" title="<?php echo $layout['title']; ?>" class="vce-img-select<?php echo $selected_class; ?>">
		  			<br/><span><?php echo $layout['title']; ?></span>
		  			<input type="radio" class="vce-hidden vce-count-me" name="<?php echo $name_prefix; ?>[layout]" value="<?php echo $id; ?>" <?php checked( $id, $module['layout'] );?>/> </label>

		  		</li>
		  	<?php endforeach; ?>
		    </ul>
		    <small class="howto"><?php _e( 'Choose your main posts layout', THEME_SLUG ); ?></small>
		    <p>
		    	<strong><?php _e( 'Max number of posts', THEME_SLUG ); ?>:</strong><br/>
		    	<input class="vce-count-me" type="text" name="<?php echo $name_prefix; ?>[limit]" value="<?php echo $module['limit'];?>"/><br/>
		    	<small class="howto"><?php _e( 'Specify maximum number of posts for this module', THEME_SLUG ); ?></small>
		    </p>

		    <p>
		    	<label><input type="checkbox" name="<?php echo $name_prefix; ?>[one_column]" value="1" class="vce-count-me" <?php checked( $module['one_column'], 1 );?>/><strong><?php _e( 'Make this module one-column', THEME_SLUG ); ?></strong></label><br/>
		    	<small class="howto"><?php _e( 'This option may apply to layouts C, D and F which are naturally listed in two columns', THEME_SLUG ); ?></small>
		  	</p>
			</div>

			<div class="vce-tab">
		    <p><strong><?php _e( 'Choose starter posts layout', THEME_SLUG ); ?>:</strong></p>

		  	<ul class="vce-img-select-wrap next-hide">
	  		<?php foreach ( $starter_layouts as $id => $layout ): ?>
	  		<li>
	  			<?php $selected_class = vce_compare( $module['top_layout'], $id ) ? ' selected': ''; ?>
	  			<img src="<?php echo $layout['img']; ?>" title="<?php echo $layout['title']; ?>" class="vce-img-select<?php echo $selected_class; ?>">
	  			<br/><span><?php echo $layout['title']; ?></span>
	  			<input type="radio" class="vce-hidden vce-count-me" name="<?php echo $name_prefix; ?>[top_layout]" value="<?php echo $id; ?>" <?php checked( $id, $module['top_layout'] );?>/> </label>
	  		</li>
	  		<?php endforeach; ?>
	       </ul>

	  		<?php $style = !$module['top_layout'] ? 'style="display:none"' : ''; ?>

	  		<p class="form-field" <?php echo $style; ?>><strong><?php _e( 'Number of starter posts', THEME_SLUG ); ?>:</strong>
		  	<input type="text" name="<?php echo $name_prefix; ?>[top_limit]" value="<?php echo $module['top_limit']; ?>" class="vce-count-me" style="width: 30px;"/>
		  	</p>
		  	<p class="howto"><?php _e( 'Choose additional layout if you want to combine two layouts in same module so the first posts will be displayed in different layout', THEME_SLUG ); ?></p>
		  	</div>


		  	<div class="vce-tab">

		    <?php if ( !empty( $cats ) ): ?>
	   		<div class="vce-opt-item">
			   		<strong><?php _e( 'Filter by category', THEME_SLUG ); ?>:</strong><br/>
			   		<div class="vce-item-scroll">
			   		<?php foreach ( $cats as $cat ) : ?>
			   			<?php $checked = in_array( $cat->term_id, $module['cat'] ) ? 'checked="checked"' : ''; ?>
			   			<label><input class="vce-count-me" type="checkbox" name="<?php echo $name_prefix; ?>[cat][]" value="<?php echo $cat->term_id ?>" <?php echo $checked; ?> /><?php echo $cat->name;?></label><br/>
			   		<?php endforeach; ?>
			   		</div>
			   		<small class="howto"><?php _e( 'Check whether you want to display posts from specific categories only. Or leave empty for all categories.', THEME_SLUG ); ?></small><br/>
		    		<label><input type="checkbox" name="<?php echo $name_prefix; ?>[cat_child]" value="1" class="vce-count-me" <?php checked( $module['cat_child'], 1 );?>/><strong><?php _e( 'Apply child categories', THEME_SLUG ); ?></strong></label><br/>
		    		<small class="howto"><?php _e( 'If parent category is selected, posts from child categories will be included automatically', THEME_SLUG ); ?></small>
		   	</div>
		   	<?php endif; ?>

		   	<div class="vce-opt-item">
		   		<strong><?php _e( 'Posts are not older than', THEME_SLUG ); ?>:</strong><br/>
		   		<?php foreach ( $time as $id => $title ) : ?>
		   		<label><input type="radio" name="<?php echo $name_prefix; ?>[time]" value="<?php echo $id; ?>" <?php checked( $module['time'], $id ); ?> class="vce-count-me" /><?php echo $title;?></label><br/>
		   		<?php endforeach; ?>
		   		<small class="howto"><?php _e( 'Check if you want to display post that are not older than some specific time', THEME_SLUG ); ?></small>
	   		</div>

			<div class="vce-opt-item">
		   		<strong><?php _e( 'Order posts by', THEME_SLUG ); ?>:</strong><br/>
		   		<?php foreach ( $order as $id => $title ) : ?>
		   		<label><input type="radio" name="<?php echo $name_prefix; ?>[order]" value="<?php echo $id; ?>" <?php checked( $module['order'], $id ); ?> class="vce-count-me" /><?php echo $title;?></label><br/>
		   		<?php endforeach; ?>
		   		<small class="howto"><?php _e( 'Specify posts ordering', THEME_SLUG ); ?></small>
	   		</div>

	   		<div class="vce-opt-item">
		   		<strong><?php _e( 'Choose posts (or pages) manually', THEME_SLUG ); ?>:</strong><br/>
		   		<?php $manual = !empty($module['manual']) ? implode( ",", $module['manual'] ) : ''; ?>
		   		<input type="text" name="<?php echo $name_prefix; ?>[manual]" value="<?php echo $manual; ?>" class="vce-count-me" style="width: 100%;"/><br/>
		   		<small class="howto"><?php _e( 'Specify post ids separated by comma if you want to select only those posts. i.e. 213,32,12,45', THEME_SLUG ); ?></small>
	   		</div>

	   		</div>

	   		<div class="vce-tab">
	   			<p><strong><?php _e( 'Choose additional options', THEME_SLUG ); ?>:</strong><br/>
		   		<?php foreach ( $actions as $id => $title ) : ?>
		   		<label><input type="radio" name="<?php echo $name_prefix; ?>[action]" value="<?php echo $id; ?>" <?php checked( $module['action'], $id ); ?> class="vce-count-me vce-action-pick" /><?php echo $title;?></label><br/>
		   		<?php endforeach; ?>
		   		</p>

		   		<?php $style = vce_compare($module['action'], 'pagination' ) ?  '' : 'style="display:none"';  ?>
		   		<div class="vce-pagination-wrap hideable" <?php echo $style; ?>>
			   		<p><strong><?php _e( 'Choose pagination type', THEME_SLUG ); ?>:</strong></p>
			   		<ul class="vce-img-select-wrap">
			  		<?php foreach ( $paginations as $id => $pagination ): ?>
			  		<li>
			  			<?php $selected_class = vce_compare( $module['pagination'], $id ) ? ' selected': ''; ?>
			  			<img src="<?php echo $pagination['img']; ?>" title="<?php echo $pagination['title']; ?>" class="vce-img-select<?php echo $selected_class; ?>">
			  			<br/><span><?php echo $pagination['title']; ?></span>
			  			<input type="radio" class="vce-hidden vce-count-me" name="<?php echo $name_prefix; ?>[pagination]" value="<?php echo $id; ?>" <?php checked( $id, $module['pagination'] );?>/> </label>
			  		</li>
			  		<?php endforeach; ?>
			       </ul>
			       <small class="howto"><?php _e( 'Note: Pagination may be added only for the last module on the page', THEME_SLUG ); ?></small>
		   		</div>

		   		<?php $style = vce_compare($module['action'], 'link' ) ?  '' : 'style="display:none"'; ?>
		   		<div class="vce-link-wrap hideable" <?php echo $style; ?>>
		   			<p><strong><?php _e( 'Link/Button Text', THEME_SLUG ); ?>:</strong><br/>
		   			<input type="text" name="<?php echo $name_prefix; ?>[action_link_text]" value="<?php echo esc_attr($module['action_link_text']); ?>" class="vce-count-me"/></p>
		   			<p><strong><?php _e( 'Link/Button URL', THEME_SLUG ); ?>:</strong><br/>
		   			<input type="text" name="<?php echo $name_prefix; ?>[action_link_url]" value="<?php echo esc_url($module['action_link_url']); ?>" class="vce-count-me"/></p>
		   		</div>

	  		
	   		</div>

	   		</div>

		</div>
	</div>
	<?php
	}
endif;

/* Create Content metabox */
if ( !function_exists( 'vce_page_content_metabox' ) ) :
	function vce_page_content_metabox( $object, $box ) {
		$vce_meta = vce_get_page_meta( $object->ID );
?>	  
		<p><strong><?php _e( 'Display page content:', THEME_SLUG ); ?></strong></p>

	  	<label><input type="radio" name="vce[display_content][position]" value="up" <?php checked( 'up', $vce_meta['display_content']['position'] );?>/> <?php _e( 'Above modules', THEME_SLUG ); ?></label><br/>
	  	<label><input type="radio" name="vce[display_content][position]" value="down" <?php checked( 'down', $vce_meta['display_content']['position'] );?>/> <?php _e( 'Below modules', THEME_SLUG ); ?></label><br/>
	  	<label><input type="radio" name="vce[display_content][position]" value="0" <?php checked( '0', $vce_meta['display_content']['position'] );?>/> <?php _e( 'Do not display', THEME_SLUG ); ?></label><br/><br/>

	  	<p><strong><?php _e( 'Style:', THEME_SLUG ); ?></strong></p>

	  	<label><input type="radio" name="vce[display_content][style]" value="wrap" <?php checked( 'wrap', $vce_meta['display_content']['style'] );?>/> <?php _e( 'Wrapped in box', THEME_SLUG ); ?></label><br/>
	  	<label><input type="radio" name="vce[display_content][style]" value="unwrap" <?php checked( 'unwrap', $vce_meta['display_content']['style'] );?>/> <?php _e( 'Unwrapped (transparent background)', THEME_SLUG ); ?></label><br/>

	  	<p><strong><?php _e( 'Width:', THEME_SLUG ); ?></strong></p>

	  	<label><input type="radio" name="vce[display_content][width]" value="container" <?php checked( 'container', $vce_meta['display_content']['width'] );?>/> <?php _e( 'Container/page width', THEME_SLUG ); ?></label><br/>
	  	<label><input type="radio" name="vce[display_content][width]" value="full" <?php checked( 'full', $vce_meta['display_content']['width'] );?>/> <?php _e( 'Full/browser width', THEME_SLUG ); ?></label><br/><br/>

	   	<p class="description"><?php _e( 'Manage display options for content/editor on this page', THEME_SLUG ); ?></p>

	  <?php
	}
endif;

/* Save Page Meta */
if ( !function_exists( 'vce_save_page_metaboxes' ) ) :
	function vce_save_page_metaboxes( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( isset( $_POST['vce_page_nonce'] ) ) {
			if ( !wp_verify_nonce( $_POST['vce_page_nonce'], __FILE__  ) )
				return;
		}

		if ( $post->post_type == 'page' && isset( $_POST['vce'] ) ) {
			$post_type = get_post_type_object( $post->post_type );
			if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
				return $post_id;

			$vce_meta = array();

			$vce_meta['use_sidebar'] = isset( $_POST['vce']['use_sidebar'] ) ? $_POST['vce']['use_sidebar'] : 0;
			$vce_meta['sidebar'] = isset( $_POST['vce']['sidebar'] ) ? $_POST['vce']['sidebar'] : 0;
			$vce_meta['sticky_sidebar'] = isset( $_POST['vce']['sticky_sidebar'] ) ? $_POST['vce']['sticky_sidebar'] : 0;

			$vce_meta['fa_layout'] = isset( $_POST['vce']['fa_layout'] ) ? $_POST['vce']['fa_layout'] : 0;

			if ( $vce_meta['fa_layout'] ) {
				$vce_meta['fa_limit'] = isset( $_POST['vce']['fa_limit'] ) ? absint( $_POST['vce']['fa_limit'] ) : 0;
				$vce_meta['fa_time'] = isset( $_POST['vce']['fa_time'] ) ? $_POST['vce']['fa_time'] : 0;
				$vce_meta['fa_order'] = isset( $_POST['vce']['fa_order'] ) ? $_POST['vce']['fa_order'] : 0;
				$vce_meta['fa_exclude'] = isset( $_POST['vce']['fa_exclude'] ) ? $_POST['vce']['fa_exclude'] : 0;
				$vce_meta['fa_cat'] = isset( $_POST['vce']['fa_cat'] ) ? $_POST['vce']['fa_cat'] : array();
				$vce_meta['fa_cat_child'] = isset( $_POST['vce']['fa_cat_child'] ) ? $_POST['vce']['fa_cat_child'] : 0;
				if ( isset( $_POST['vce']['fa_manual'] ) && !empty( $_POST['vce']['fa_manual'] ) ) {
					$vce_meta['fa_manual'] = array_map( 'absint', explode( ",", $_POST['vce']['fa_manual'] ) );
				}

			}

			if ( isset( $_POST['vce']['modules'] ) ) {
				$vce_meta['modules'] = array_values( $_POST['vce']['modules'] );
				foreach ( $vce_meta['modules'] as $i => $module ) {
					if ( isset( $module['manual'] ) && !empty( $module['manual'] ) ) {
						$vce_meta['modules'][$i]['manual'] = array_map( 'absint', explode( ",", $module['manual'] ) );
					}
				}

			}

			$vce_meta['display_content'] = isset( $_POST['vce']['display_content'] ) ? $_POST['vce']['display_content'] : array();

			update_post_meta( $post_id, '_vce_meta', $vce_meta );

		}
	}
endif;

/* Save Post Meta */
if ( !function_exists( 'vce_save_post_metaboxes' ) ) :
	function vce_save_post_metaboxes( $post_id, $post ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( isset( $_POST['vce_post_nonce'] ) ) {
			if ( !wp_verify_nonce( $_POST['vce_post_nonce'], __FILE__  ) )
				return;
		}


		if ( $post->post_type == 'post' && isset( $_POST['vce'] ) ) {
			$post_type = get_post_type_object( $post->post_type );
			if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
				return $post_id;

			$vce_meta = array();

			$vce_meta['use_sidebar'] = isset( $_POST['vce']['use_sidebar'] ) ? $_POST['vce']['use_sidebar'] : 0;
			$vce_meta['sidebar'] = isset( $_POST['vce']['sidebar'] ) ? $_POST['vce']['sidebar'] : 0;
			$vce_meta['sticky_sidebar'] = isset( $_POST['vce']['sticky_sidebar'] ) ? $_POST['vce']['sticky_sidebar'] : 0;

			update_post_meta( $post_id, '_vce_meta', $vce_meta );

		}
	}
endif;


/* Add metaboxes to category */

if ( !function_exists( 'vce_category_add_meta_fields' ) ) :
	function vce_category_add_meta_fields() {
		$vce_meta = vce_get_category_meta();
		$sidebars_lay = vce_get_sidebar_layouts( true );
		$sidebars = vce_get_sidebars_list( true );
		$post_layouts = vce_get_main_layouts( true, false );
		$starter_layouts = vce_get_main_layouts( true, true );
		$fa_layouts = vce_get_featured_area_layouts( true, true );
?>
	 <div class="form-field">
	  	<label><?php _e( 'Featured area layout', THEME_SLUG ); ?></label>
	  	<ul class="vce-img-select-wrap next-hide">
	  	<?php foreach ( $fa_layouts as $id => $layout ): ?>
	  		<li>
	  			<?php $selected_class = vce_compare( $vce_meta['fa_layout'], $id ) ? ' selected': ''; ?>
	  			<img src="<?php echo $layout['img']; ?>" title="<?php echo $layout['title']; ?>" class="vce-img-select<?php echo $selected_class; ?>">
	  			<input type="radio" class="vce-hidden" name="vce[fa_layout]" value="<?php echo $id; ?>" <?php checked( $id, $vce_meta['fa_layout'] );?>/> </label>
	  		</li>
	  	<?php endforeach; ?>
	   </ul>
	   <p class="description"><?php _e( 'Choose featured area layout', THEME_SLUG ); ?></p>
	 </div>

	 <?php $style = $vce_meta['fa_layout'] == 'inherit' || !$vce_meta['fa_layout'] ? 'style="display:none"' : ''; ?>
	 <div class="form-field"  <?php echo $style; ?>>
	  	<label><?php _e( 'Featured posts limit', THEME_SLUG ); ?></label>
	  	<input type="text" name="vce[fa_limit]" value="<?php echo $vce_meta['fa_limit']; ?>" style="width: 30px;"/> <?php _e( 'post(s)', THEME_SLUG ); ?>
	 </div>

	 <div class="form-field">
	  	<label><?php _e( 'Posts main layout', THEME_SLUG ); ?></label>
	  	<ul class="vce-img-select-wrap next-hide">
	  	<?php foreach ( $post_layouts as $id => $layout ): ?>
	  		<li>
	  			<?php $selected_class = vce_compare( $vce_meta['layout'], $id ) ? ' selected': ''; ?>
	  			<img src="<?php echo $layout['img']; ?>" title="<?php echo $layout['title']; ?>" class="vce-img-select<?php echo $selected_class; ?>">
	  			<input type="radio" class="vce-hidden" name="vce[layout]" value="<?php echo $id; ?>" <?php checked( $id, $vce_meta['layout'] );?>/> </label>
	  		</li>
	  	<?php endforeach; ?>
	   </ul>
	   <p class="description"><?php _e( 'Choose posts layout for this category', THEME_SLUG ); ?></p>
	 </div>

	 <?php $style = $vce_meta['layout'] == 'inherit' ? 'style="display:none"' : ''; ?>
	  <div class="form-field" <?php echo $style; ?>>
	  		<label><?php _e( 'Number of posts per page', THEME_SLUG ); ?></label>
		  	<input type="text" name="vce[ppp]" value="<?php echo $vce_meta['ppp']; ?>" style="width: 30px;"/> <?php _e( 'post(s)', THEME_SLUG ); ?><br/>
		  	<small  class="description"><?php _e( 'Note: leave empty if you want to inherit from global category option', THEME_SLUG ); ?></small>
	  </div>

	 <div class="form-field">
	  	<label><?php _e( 'Starter posts', THEME_SLUG ); ?></label>
	  	<ul class="vce-img-select-wrap next-hide">
	  	<?php foreach ( $starter_layouts as $id => $layout ): ?>
	  		<li>
	  			<?php $selected_class = vce_compare( $vce_meta['top_layout'], $id ) ? ' selected': ''; ?>
	  			<img src="<?php echo $layout['img']; ?>" title="<?php echo $layout['title']; ?>" class="vce-img-select<?php echo $selected_class; ?>">
	  			<input type="radio" class="vce-hidden" name="vce[top_layout]" value="<?php echo $id; ?>" <?php checked( $id, $vce_meta['top_layout'] );?>/> </label>
	  		</li>
	  	<?php endforeach; ?>
	   </ul>
	   <p class="description"><?php _e( 'Check if you want to use starter posts', THEME_SLUG ); ?></p>
	 </div>

	 <?php $style = $vce_meta['top_layout'] == 'inherit' || !$vce_meta['top_layout'] ? 'style="display:none"' : ''; ?>
	 <div class="form-field"  <?php echo $style; ?>>
	  	<label><?php _e( 'Starter posts limit', THEME_SLUG ); ?></label>
	  	<input type="text" name="vce[top_limit]" value="<?php echo $vce_meta['top_limit']; ?>" style="width: 30px;"/> <?php _e( 'post(s)', THEME_SLUG ); ?>
	 </div>

	 <div class="form-field">
	  	<label><?php _e( 'Sidebar layout', THEME_SLUG ); ?></label>
	  	<ul class="vce-img-select-wrap">
	  	<?php foreach ( $sidebars_lay as $id => $layout ): ?>
	  		<li>
	  			<?php $selected_class = vce_compare( $vce_meta['use_sidebar'], $id ) ? ' selected': ''; ?>
	  			<img src="<?php echo $layout['img']; ?>" title="<?php echo $layout['title']; ?>" class="vce-img-select<?php echo $selected_class; ?>">
	  			<input type="radio" class="vce-hidden" name="vce[use_sidebar]" value="<?php echo $id; ?>" <?php checked( $id, $vce_meta['use_sidebar'] );?>/> </label>
	  		</li>
	  	<?php endforeach; ?>
	   </ul>
	   <p class="description"><?php _e( 'Choose sidebar layout', THEME_SLUG ); ?></p>
	 </div>

	  <?php if ( !empty( $sidebars ) ): ?>
	  <div class="form-field">
	  <label><?php _e( 'Standard sidebar', THEME_SLUG ); ?></label>
	  	<select name="vce[sidebar]" class="widefat">
	  	<?php foreach ( $sidebars as $id => $name ): ?>
	  		<option value="<?php echo $id; ?>" <?php selected( $id, $vce_meta['sidebar'] );?>><?php echo $name; ?></option>
	  	<?php endforeach; ?>
	  </select>
	  <p class="description"><?php _e( 'Choose standard sidebar to display', THEME_SLUG ); ?></p>
	  </div>
	  <div class="form-field">
	  <label><?php _e( 'Sticky sidebar', THEME_SLUG ); ?></label>
	  <select name="vce[sticky_sidebar]" class="widefat">
	  	<?php foreach ( $sidebars as $id => $name ): ?>
	  		<option value="<?php echo $id; ?>" <?php selected( $id, $vce_meta['sticky_sidebar'] );?>><?php echo $name; ?></option>
	  	<?php endforeach; ?>
	  </select>
	   <p class="description"><?php _e( 'Choose sticky sidebar to display', THEME_SLUG ); ?></p>
	   </div>
	  <?php endif; ?>

	  <?php

		$most_used = get_option( 'vce_recent_cat_colors' );

		$colors = '';

		if ( !empty( $most_used ) ) {
			$colors .= '<p>'.__( 'Recently used', THEME_SLUG ).': <br/>';
			foreach ( $most_used as $color ) {
				$colors .= '<a href="#" style="width: 20px; height: 20px; background: '.$color.'; float: left; margin-right:3px; border: 1px solid #aaa;" class="vce_colorpick" data-color="'.$color.'"></a>';
			}
			$colors .= '</p>';
		}

?>

	 <div class="form-field">
		 <label><?php _e( 'Color', THEME_SLUG ); ?></label><br/>
		 <label><input type="radio" name="vce[color_type]" value="inherit" class="vce-radio color-type" <?php checked( $vce_meta['color_type'], 'inherit' );?>> <?php _e( 'Inherit from default accent color', THEME_SLUG ); ?></label>
		 <label><input type="radio" name="vce[color_type]" value="custom" class="vce-radio color-type" <?php checked( $vce_meta['color_type'], 'custom' );?>> <?php _e( 'Custom', THEME_SLUG ); ?></label>
		 <div id="vce_color_wrap">
		 <p>
		   	<input name="vce[color]" type="text" class="vce_colorpicker" value="<?php echo $vce_meta['color']; ?>" data-default-color="<?php echo $vce_meta['color']; ?>"/>
		 </p>
		 <?php if ( !empty( $colors ) ) { echo $colors; } ?>
		 </div>
		 <div class="clear"></div>
		 <p class="howto"><?php _e( 'Choose color', THEME_SLUG ); ?></p>
	 </div>

	<?php
	}
endif;

add_action( 'category_add_form_fields', 'vce_category_add_meta_fields', 10, 2 );

if ( !function_exists( 'vce_category_edit_meta_fields' ) ) :
	function vce_category_edit_meta_fields( $term ) {
		$vce_meta = vce_get_category_meta( $term->term_id );
		$sidebars_lay = vce_get_sidebar_layouts( true );
		$sidebars = vce_get_sidebars_list( true );
		$post_layouts = vce_get_main_layouts( true );
		$starter_layouts = vce_get_main_layouts( true, true );
		$fa_layouts = vce_get_featured_area_layouts( true, true );
?>
	  <tr class="form-field">
		<th scope="row" valign="top">
	  		<label><?php _e( 'Featured area layout', THEME_SLUG ); ?></label>
	  	</th>
	  	<td>
		  	<ul class="vce-img-select-wrap next-hide">
	  		<?php foreach ( $fa_layouts as $id => $layout ): ?>
	  		<li>
	  			<?php $selected_class = vce_compare( $vce_meta['fa_layout'], $id ) ? ' selected': ''; ?>
	  			<img src="<?php echo $layout['img']; ?>" title="<?php echo $layout['title']; ?>" class="vce-img-select<?php echo $selected_class; ?>">
	  			<input type="radio" class="vce-hidden" name="vce[fa_layout]" value="<?php echo $id; ?>" <?php checked( $id, $vce_meta['fa_layout'] );?>/> </label>
	  		</li>
	  		<?php endforeach; ?>
	   		</ul>
		   	<p class="description"><?php _e( 'Choose featured area layout', THEME_SLUG ); ?></p>
	 	</td>
	  </tr>

	  <?php $style = $vce_meta['fa_layout'] == 'inherit' || !$vce_meta['fa_layout'] ? 'style="display:none"' : ''; ?>
	  <tr class="form-field" <?php echo $style; ?>>
		<th scope="row" valign="top">
	  		<label><?php _e( 'Featured area posts limit', THEME_SLUG ); ?></label>
	  	</th>
	  	<td>
		  	<input type="text" name="vce[fa_limit]" value="<?php echo $vce_meta['fa_limit']; ?>" style="width: 30px;"/> <?php _e( 'post(s)', THEME_SLUG ); ?>
	 	</td>
	  </tr>

	  <tr class="form-field">
		<th scope="row" valign="top">
	  		<label><?php _e( 'Posts main layout', THEME_SLUG ); ?></label>
	  	</th>
	  	<td>
		  	<ul class="vce-img-select-wrap next-hide">
	  		<?php foreach ( $post_layouts as $id => $layout ): ?>
	  		<li>
	  			<?php $selected_class = vce_compare( $vce_meta['layout'], $id ) ? ' selected': ''; ?>
	  			<img src="<?php echo $layout['img']; ?>" title="<?php echo $layout['title']; ?>" class="vce-img-select<?php echo $selected_class; ?>">
	  			<input type="radio" class="vce-hidden" name="vce[layout]" value="<?php echo $id; ?>" <?php checked( $id, $vce_meta['layout'] );?>/> </label>
	  		</li>
	  		<?php endforeach; ?>
	   		</ul>
		   	<p class="description"><?php _e( 'Choose posts layout for this category', THEME_SLUG ); ?></p>
	 	</td>
	  </tr>

	  <?php $style = $vce_meta['layout'] == 'inherit' ? 'style="display:none"' : ''; ?>
	  <tr class="form-field" <?php echo $style; ?>>
		<th scope="row" valign="top">
	  		<label><?php _e( 'Number of posts per page', THEME_SLUG ); ?></label>
	  	</th>
	  	<td>
		  	<input type="text" name="vce[ppp]" value="<?php echo $vce_meta['ppp']; ?>" style="width: 30px;"/> <?php _e( 'post(s)', THEME_SLUG ); ?><br/>
		  	<small  class="description"><?php _e( 'Note: leave empty if you want to inherit from global category option', THEME_SLUG ); ?></small>
	 	</td>
	  </tr>

	  <tr class="form-field">
		<th scope="row" valign="top">
	  		<label><?php _e( 'Starter posts layout', THEME_SLUG ); ?></label>
	  	</th>
	  	<td>
		  	<ul class="vce-img-select-wrap next-hide">
	  		<?php foreach ( $starter_layouts as $id => $layout ): ?>
	  		<li>
	  			<?php $selected_class = vce_compare( $vce_meta['top_layout'], $id ) ? ' selected': ''; ?>
	  			<img src="<?php echo $layout['img']; ?>" title="<?php echo $layout['title']; ?>" class="vce-img-select<?php echo $selected_class; ?>">
	  			<input type="radio" class="vce-hidden" name="vce[top_layout]" value="<?php echo $id; ?>" <?php checked( $id, $vce_meta['top_layout'] );?>/> </label>
	  		</li>
	  		<?php endforeach; ?>
	       </ul>

		   	<p class="description"><?php _e( 'Check if you want to use starter posts', THEME_SLUG ); ?></p>
	 	</td>
	  </tr>

	  <?php $style = $vce_meta['top_layout'] == 'inherit' || !$vce_meta['top_layout'] ? 'style="display:none"' : ''; ?>
	  <tr class="form-field" <?php echo $style; ?>>
		<th scope="row" valign="top">
	  		<label><?php _e( 'Starter posts limit', THEME_SLUG ); ?></label>
	  	</th>
	  	<td>
		  	<input type="text" name="vce[top_limit]" value="<?php echo $vce_meta['top_limit']; ?>" style="width: 30px;"/> <?php _e( 'post(s)', THEME_SLUG ); ?>
	 	</td>
	  </tr>


	  <tr class="form-field">
		<th scope="row" valign="top">
	  		<label><?php _e( 'Sidebar layout', THEME_SLUG ); ?></label>
	  	</th>
	  	<td>
		  	<ul class="vce-img-select-wrap">
	  		<?php foreach ( $sidebars_lay as $id => $layout ): ?>
	  		<li>
	  			<?php $selected_class = vce_compare( $vce_meta['use_sidebar'], $id ) ? ' selected': ''; ?>
	  			<img src="<?php echo $layout['img']; ?>" title="<?php echo $layout['title']; ?>" class="vce-img-select<?php echo $selected_class; ?>">
	  			<input type="radio" class="vce-hidden" name="vce[use_sidebar]" value="<?php echo $id; ?>" <?php checked( $id, $vce_meta['use_sidebar'] );?>/> </label>
	  		</li>
	  		<?php endforeach; ?>
	   </ul>
		   	<p class="description"><?php _e( 'Choose sidebar layout', THEME_SLUG ); ?></p>
	 	</td>
	  </tr>

	  <tr class="form-field">
		<th scope="row" valign="top">
	  		<label><?php _e( 'Standard sidebar', THEME_SLUG ); ?></label>
	  	</th>
	  	<td>
			<select name="vce[sidebar]" class="widefat">
			<?php foreach ( $sidebars as $id => $name ): ?>
				<option value="<?php echo $id; ?>" <?php selected( $id, $vce_meta['sidebar'] );?>><?php echo $name; ?></option>
			<?php endforeach; ?>
			</select>
			<p class="description"><?php _e( 'Choose standard sidebar to display', THEME_SLUG ); ?></p>
	  	</td>
	  </tr>
	  <tr class="form-field">
		<th scope="row" valign="top">
	  		<label><?php _e( 'Sticky sidebar', THEME_SLUG ); ?></label>
	  	</th>
	  	<td>
		  	<select name="vce[sticky_sidebar]" class="widefat">
		  	<?php foreach ( $sidebars as $id => $name ): ?>
		  		<option value="<?php echo $id; ?>" <?php selected( $id, $vce_meta['sticky_sidebar'] );?>><?php echo $name; ?></option>
		  	<?php endforeach; ?>
		  	</select>
		    <p class="description"><?php _e( 'Choose sticky sidebar to display', THEME_SLUG ); ?></p>
	   </td>
	 </tr>

	 <?php

		$most_used = get_option( 'vce_recent_cat_colors' );

		$colors = '';

		if ( !empty( $most_used ) ) {
			$colors .= '<p>'.__( 'Recently used', THEME_SLUG ).': <br/>';
			foreach ( $most_used as $color ) {
				$colors .= '<a href="#" style="width: 20px; height: 20px; background: '.$color.'; float: left; margin-right:3px; border: 1px solid #aaa;" class="vce_colorpick" data-color="'.$color.'"></a>';
			}
			$colors .= '</p>';
		}

?>

	 <tr class="form-field">
		<th scope="row" valign="top"><label><?php _e( 'Color', THEME_SLUG ); ?></label></th>
			<td>
				<label><input type="radio" name="vce[color_type]" value="inherit" class="vce-radio color-type" <?php checked( $vce_meta['color_type'], 'inherit' );?>> <?php _e( 'Inherit from default accent color', THEME_SLUG ); ?></label> <br/>
				<label><input type="radio" name="vce[color_type]" value="custom" class="vce-radio color-type" <?php checked( $vce_meta['color_type'], 'custom' );?>> <?php _e( 'Custom', THEME_SLUG ); ?></label>
			  <div id="vce_color_wrap">
			  <p>
			    	<input name="vce[color]" type="text" class="vce_colorpicker" value="<?php echo $vce_meta['color']; ?>" data-default-color="<?php echo $vce_meta['color']; ?>"/>
			  </p>
			  <?php if ( !empty( $colors ) ) { echo $colors; } ?>
				</div>
				<div class="clear"></div>
				<p class="howto"><?php _e( 'Choose color', THEME_SLUG ); ?></p>
			</td>
		</tr>

	<?php
	}
endif;

add_action( 'category_edit_form_fields', 'vce_category_edit_meta_fields', 10, 2 );


if ( !function_exists( 'vce_save_category_meta_fields' ) ) :
	function vce_save_category_meta_fields( $term_id ) {

		if ( isset( $_POST['vce'] ) ) {

			$vce_meta = array();

			$vce_meta['layout'] = isset( $_POST['vce']['layout'] ) ? $_POST['vce']['layout'] : 0;
			$vce_meta['ppp'] = isset( $_POST['vce']['ppp'] ) && !empty( $_POST['vce']['ppp'] ) ? absint($_POST['vce']['ppp']) : '';
			$vce_meta['top_layout'] = isset( $_POST['vce']['top_layout'] ) ? $_POST['vce']['top_layout'] : 0;
			$vce_meta['top_limit'] = isset( $_POST['vce']['top_limit'] ) ? $_POST['vce']['top_limit'] : 0;
			$vce_meta['fa_layout'] = isset( $_POST['vce']['fa_layout'] ) ? $_POST['vce']['fa_layout'] : 0;
			$vce_meta['fa_limit'] = isset( $_POST['vce']['fa_limit'] ) ? $_POST['vce']['fa_limit'] : 0;
			$vce_meta['use_sidebar'] = isset( $_POST['vce']['use_sidebar'] ) ? $_POST['vce']['use_sidebar'] : 0;
			$vce_meta['sidebar'] = isset( $_POST['vce']['sidebar'] ) ? $_POST['vce']['sidebar'] : 0;
			$vce_meta['sticky_sidebar'] = isset( $_POST['vce']['sticky_sidebar'] ) ? $_POST['vce']['sticky_sidebar'] : 0;
			$vce_meta['color_type'] = isset( $_POST['vce']['color_type'] ) ? $_POST['vce']['color_type'] : 0;
			$vce_meta['color'] = isset( $_POST['vce']['color'] ) ? $_POST['vce']['color'] : 0;

			update_option( '_vce_category_'.$term_id, $vce_meta );

			if ( $vce_meta['color_type'] == 'custom' ) {
				vce_update_recent_cat_colors( $vce_meta['color'] );
			}

			vce_update_cat_colors( $term_id, $vce_meta['color'], $vce_meta['color_type'] );
		}

	}
endif;

add_action( 'edited_category', 'vce_save_category_meta_fields', 10, 2 );
add_action( 'create_category', 'vce_save_category_meta_fields', 10, 2 );




?>
