<?php
  if( empty( $apply_label ) ){
    $apply_label = __('Apply');
  }else{
    $apply_label = wcpt_parse_2( $apply_label );
  }

  if( ! empty( $reset_label ) ){
    $reset_label = wcpt_parse_2( $reset_label );
  }

?>
<div class="wcpt-apply-reset-wrapper <?php echo $html_class; ?>">
  <?php if( $apply_label ): ?>
    <span class="wcpt-apply">
      <?php echo $apply_label; ?>
    </span>
  <?php endif; ?>
  <?php if( $reset_label ): ?>
    <span class="wcpt-reset"><?php echo $reset_label; ?></span>
  <?php endif; ?>
</div>