(function($) {
    $(document).ready(function (){
            
    		/* Image opts selection */
            $('body').on('click', 'img.vce-img-select', function(e){
                e.preventDefault();
                $(this).closest('ul').find('img.vce-img-select').removeClass('selected');
                $(this).addClass('selected');
                $(this).closest('ul').find('input').removeAttr('checked');
                $(this).closest('li').find('input').attr('checked','checked');

                if($(this).closest('ul').hasClass('next-hide')){
                    var v = $(this).closest('li').find('input:checked').val();
                    if(v == 'inherit' || v == 0){
                         $(this).closest('ul').next().fadeOut(400);
                    } else {
                        $(this).closest('ul').next().fadeIn(400);
                    }
                }
            });


            /* Add new module */
            $('body').on('click', '#vce-add-module', function(e){
            	e.preventDefault();
	            tb_show( 'Add Module', '#TB_inline?width=600&height=600&inlineId=vce-hidden-module' );
        	});

            var vce_current_mod;

            /* Edit module */
            $('body').on('click', '.vce-edit-module', function(e){
                e.preventDefault();
                var div_id = $(this).closest('li').attr('data-module');
                var module_name = $(this).closest('li').find('.module-title').text();
                vce_current_mod = div_id;
                tb_show( 'Edit Module - '+ module_name, '#TB_inline?width=600&height=600&inlineId=vce-hidden-module-'+div_id );
            });

            /* Remove module */
            $('body').on('click', '.vce-remove-module', function(e){
                e.preventDefault();
                $(this).closest('li').fadeOut(300, function(){
                    $(this).remove();
                });
            });

            /* Save module */
        	$('body').on('click', 'a.vce-save-module', function(e){
        		e.preventDefault();
        		
        		var $clean_form = $(this).closest('.vce-module-form').clone();

                if($clean_form.hasClass('edit')){
                    
                    var $li = $('#vce-hidden-module-'+vce_current_mod).closest('li');   
                    
                    $clean_form.find('.vce-count-me').each(function( index ) {
                        $(this).attr('value',$(this).val());
                        if($(this).is(":checked")){
                             $(this).attr('checked','checked');
                        }
                    });
                    
                    var mod_title = $clean_form.find('input:first').val();
                    $li.find('.module-title').text(mod_title);
                
                } else {
                    var count = $('#vce-modules-count').attr('data-count');
            		$clean_form.find('.vce-count-me').each(function( index ) {
      					$(this).attr('name', 'vce[modules]['+ count +']'+ $(this).attr('name'));
                        $(this).attr('value',$(this).val());
                        if($(this).is(":checked")){
                             $(this).attr('checked','checked');
                        }
    				});

                    var mod_title = $clean_form.find('input:first').val();

    	            $('#vce-modules-wrap').append('<li data-module="'+count+'"><span class="module-title">'+mod_title+'</span> <span class="actions"> <a href="#" class="vce-edit-module">Edit</a> | <a href="#" class="vce-remove-module">Remove</a></span><div id="vce-hidden-module-'+count+'" class="vce-hidden-module"><div class="vce-module-form edit">'+$clean_form.html()+'</div></div></li>');
                    $('#vce-modules-count').attr('data-count', (parseInt(count)+1));
                }

	            tb_remove();
        	});

            /* Make modules sortable */
            $( "#vce-modules-wrap" ).sortable({
              revert: false,
              cursor: "move",
              placeholder: "module-placeholder"
            });


            vce_template_metaboxes();

            $('#page_template').change(function(e){
                    vce_template_metaboxes(true);
            });
            
            
            /* Metabox switch - do not show every metabox for every template */
            function vce_template_metaboxes(scroll_to){

                if(scroll_to === undefined){
                    scroll_to = false;
                }
                var template = $('select#page_template').val();
                
                if(template == 'template-modules.php'){
                    $('#vce_hp_fa').fadeIn(300);
                    $('#vce_hp_modules').fadeIn(300);
                    $('#vce_hp_content').fadeIn(300);
                    if(scroll_to){
                        var target = $('#vce_hp_modules').attr('id');
                        $('html, body').stop().animate({
                            'scrollTop': $('#'+target).offset().top
                        }, 900, 'swing', function () {
                            window.location.hash = target;
                        });
                    }
                } else {
                    $('#vce_hp_fa').fadeOut(300);
                    $('#vce_hp_modules').fadeOut(300);
                    $('#vce_hp_content').fadeOut(300);
                }
            
            }

            /* Tabs */
            $('.vce-module-form').each(function() {
        
                var $tabs_nav = $(this).find('.vce-tabs-nav');
                $tabs_nav.find('li:first').addClass('active');
                $tabs_nav.parent().find('.vce-tab').hide();
                $tabs_nav.parent().find('.vce-tab:first').show();
            
            });

            $("body").on("click", ".vce-tabs-nav a", function(e){
                  e.preventDefault();
                  if($(this).parent().hasClass('active') == false && $(this).parent().hasClass('save') == false){
                  tab_to_show = $(this).parent().parent().find('li').index($(this).parent());
                  $(this).closest('.vce-module-form').find('.vce-tab').hide();
                  $(this).closest('.vce-module-form').find('.vce-tab').eq(tab_to_show).show();
                  $(this).closest('.vce-tabs-nav').find('li').removeClass('active');
                  $(this).parent().addClass('active');
                }
            }); 

            /* Show hide actions */

            $("body").on("click", ".vce-action-pick", function(e){
                var class_prefix = $(this).val();
                $(this).closest('.vce-tab').find('.hideable').hide();
                $(this).closest('.vce-tab').find('.vce-'+class_prefix+'-wrap').fadeIn(300);
            }); 

            
            
    });


    
})(jQuery);