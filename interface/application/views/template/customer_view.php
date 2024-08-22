<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="DHI CRM">

  <title><?php if(isset($title)){echo $title;}else{ echo "CRM";} ?></title>
  <?php echo $common_css; ?>
  <?php echo $style; ?>
</head>

   <body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
      <!-- Begin page -->
      <div class="wrapper">        

         <!-- ========== Left Sidebar Start ========== -->
         <?php echo $header_menu ?>
         <!-- Left Sidebar End -->

         <!-- Start Page Content here -->
         <div class="content-page">
            <div class="content">
               <!-- Topbar Start -->
               <?php echo $header_main ?>
               <!-- End Topbar -->

               <!-- Start Content-->
               <div class="container-fluid">
                  <?php echo $content_view ?>
               </div>
               <!-- End Content-->
            </div>
            <!-- content -->
            <?php echo $footer ?>
         </div>
         <!-- End Page content -->
      </div>
      <!-- END wrapper -->

      <?php echo $common_js ?>
      <?php echo $script; ?>
   </body>
</html>

