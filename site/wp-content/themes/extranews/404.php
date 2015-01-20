<?php get_header(); ?>

<div class="container clearfix titlecontainer">
  
    <!-- Page Title
    ================================================== -->
    <div class="pagetitlewrap">
        <h3 class="pagetitle"><?php _e('Pagina no encontrada. Error 404', 'framework'); ?></h3>
        <span class="description">
          <p>
            <?php _e("No hemos encontrado lo que buscabas", 'framework'); ?>
          </p>
        </span>
    </div>


    <!-- Page Content
      ================================================== -->
    <div class="maincontent page">
        <!-- Nothing found -->
        <h4><?php _e('PoderPDA sufrió un ataque informático, estamos trabajando en devolver todo a la normalidad, por mientras, te invitamos a visitar nuestro home-page para estar al tanto del avance y las noticias relacionadas a este despreciable ataque, agradecemos tu comprehensión. PoderPDA RENACE, :', 'framework'); ?></h4>
        <p><?php get_search_form(true); ?></p>

        <div class="clear"></div>
    </div>

    <!-- Sidebar
      ================================================== -->      
    <div class="sidebar">
        <?php  /* Widget Area */ if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Page Sidebar') ) ?>
    </div>

    <div class="clear"></div>

</div>
<?php get_footer(); ?>