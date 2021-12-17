<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php wp_head(); ?>
</head>
<body class="body-404">
  <!-- 404 Page -->
  <section id="page-404">
    <div id="wrapper">
      <strong>404</strong>
      <b>صفحه مورد نظر پیدا نشد</b>
      <a href="<?php echo esc_url( site_url( '/' ) ); ?>" class="button-back">بازگشت به سایت<i class="lni lni-arrow-left"></i></a>
    </div>
  </section>
</body>
</html>