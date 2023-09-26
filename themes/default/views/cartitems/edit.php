<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title"><?= lang('update_info'); ?></h3>
        </div>
        <div class="box-body">
          <?php echo form_open("pcolors/edit/".$pcolor->id);?>

          <div class="col-md-6">

          
            <div class="form-group">
              <label class="control-label" for="color_code"><?= $this->lang->line("color_code"); ?></label>
              <?= form_input('color_code', set_value('color_code', $pcolor->color_code), 'class="form-control input-sm" id="pcolor_code"'); ?>
            </div>

            <div class="form-group">
              <label class="control-label" for="color_name"><?= $this->lang->line("color_name"); ?></label>
              <?= form_input('color_name', set_value('color_name', $pcolor->color_name), 'class="form-control input-sm" id="color_name"'); ?>
            </div>
            
          <div class="form-group">
              <?php echo form_submit('save_pcolor', $this->lang->line("save_pcolor"), 'class="btn btn-primary"');?>
            </div>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
  </div>
</section>
