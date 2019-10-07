
<div class="wintips">
      <a href="<?php echo _hui("wintip_url") ?>" <?php if (_hui("wintip_blank")){echo 'target="_blank"';} ?> class="wintips-thumb">
        <img src="<?php echo _hui("wintip_img") ?>"> </a>
      <div class="pp-intro-bar"><?php echo _hui("wintip_h2") ?>
        <span class="wintips-close">
          <i class="fa fa-times-circle-o"></i>
        </span>
      </div>
      <div class="wintips-content">
        <h2><?php echo _hui("wintip_title") ?></h2>
        <p><?php echo _hui("wintip_asb") ?></p>
        <a href="<?php echo _hui("wintip_url") ?>" <?php if (_hui("wintip_blank")){echo 'target="_blank"';} ?> class="btn btn-primary btn-wintips">
	<?php echo _hui("wintip_button") ?></a>
      </div>
    </div>