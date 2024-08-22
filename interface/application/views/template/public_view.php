<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="DHI CRM">
   <title><?php if (isset($title)) {
               echo $title;
            } else {
               echo "CRM";
            } ?></title>
   <?php echo $common_css; ?>
   <?php echo $style; ?>
</head>

<body class="loading">
   <?php echo $header_main ?>
   <div class="wrapper">
      <div class="container-fluid">
         <?php echo $content_view ?>
      </div>
      <?php echo $footer ?>
   </div>
   <?php echo $common_js ?>
   <?php echo $script; ?>
</body>

</html>