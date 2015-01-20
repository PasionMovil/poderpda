<!--Searchbox-->
<form method="get" id="searchbox" action="<?php echo home_url(); ?>/">
    <fieldset>
        <input type="text" name="s" id="s" value="<?php _e("Escribe tu búsqueda y dá Enter", 'framework'); ?>..." onfocus="if(this.value=='<?php _e("Escribe tu búsqueda y dá Enter", 'framework'); ?>...')this.value='';" onblur="if(this.value=='')this.value='<?php _e("Escribe tu búsqueda y dá Enter", 'framework'); ?>...';"/>
    </fieldset>
</form>
<!--Searchbox-->