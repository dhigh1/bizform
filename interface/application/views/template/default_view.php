<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
   <head>
      <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title><?php if(isset($title)){echo $title;}else{ echo "CRM";} ?></title>
      <?php echo $common_css ?>
   </head>
   <body class="loading default-home-page" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <!-- start page content -->
        <?php echo $content_view ?>        
        <!-- end page content -->

        <?php echo $footer ?>

       <?php echo $common_js ?>
        
    </body>

</html>