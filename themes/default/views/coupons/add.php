<?php defined("BASEPATH") or exit("No direct script access allowed"); ?>
<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include jQuery UI library -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?= lang("enter_info") ?></h3>
                </div>
                <div class="box-body">
                    <div class="col-lg-12">
                        <?php echo form_open_multipart(
                            "coupons/add",
                            'class="validation"'
                        ); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?= lang("COUPON EMAIL", "COUPON EMAIL") ?>
                                    <?= form_input(
                                        "coupon_email",
                                        set_value("coupon_email"),
                                        'class="form-control tip" id="coupon_email"  required="required"'
                                    ) ?>
                                </div>
                                <div class="form-group">
                                    <?= lang("COUPON CODE", "COUPON CODE") ?>
                                    <?= form_input(
                                        "coupon_code",
                                        set_value("coupon_code"),
                                        'class="form-control tip" id="coupon_code"  required="required"'
                                    ) ?>
                                </div>
                                <div class="form-group">
                                    <?= lang(
                                        "COUPON QUANTITY",
                                        "COUPON QUANTITY"
                                    ) ?>
                                    <?= form_input(
                                        "coupon_quantity",
                                        set_value("coupon_quantity"),
                                        'class="form-control tip" id="coupon_quantity"  required="required"'
                                    ) ?>
                                </div>
                                 <div class="form-group">
                                    <?= lang(
                                        "COUPON RANGE FROM",
                                        "COUPON RANGE FROM"
                                    ) ?>
                                    <?= form_input(
                                        "coupon_range_from",
                                        set_value("coupon_range_from"),
                                        'class="form-control tip" id="coupon_range_from"  required="required"'
                                    ) ?>
                                </div>
                                 <div class="form-group">
                                    <?= lang(
                                        "COUPON RANGE TO",
                                        "COUPON RANGE TO"
                                    ) ?>
                                    <?= form_input(
                                        "coupon_range_to",
                                        set_value("coupon_range_to"),
                                        'class="form-control tip" id="coupon_range_to"  required="required"'
                                    ) ?>
                                </div>
                                <div class="form-group">
                                    <?= lang(
                                        "COUPON DISCOUNT",
                                        "COUPON DISCOUNT"
                                    ) ?>
                                    <?= form_input(
                                        "coupon_discount",
                                        set_value("coupon_discount"),
                                        'class="form-control tip" id="coupon_discount"  required="required"'
                                    ) ?>
                                </div>
                                <div class="form-group">
                                    <?= lang(
                                        "COUPON DISCOUNT AMT",
                                        "COUPON DISCOUNT AMT"
                                    ) ?>
                                    <?= form_input(
                                        "coupon_discount_amt",
                                        set_value("coupon_discount_amt"),
                                        'class="form-control tip" id="coupon_discount_amt"  required="required"'
                                    ) ?>
                                </div>
                                <div class="form-group">
                                    <?= lang(
                                        "COUPON FREE SHIPPING",
                                        "COUPON FREE SHIPPING"
                                    ) ?>
                                    <?= form_input(
                                        "coupon_free_shipping",
                                        set_value("coupon_free_shipping"),
                                        'class="form-control tip" id="coupon_free_shipping"  required="required"'
                                    ) ?>
                                </div>
                             <div class="form-group">
    <?= lang("START DATE", "START DATE") ?>
    <?= form_input(
        "coupon_start_date",
        set_value("coupon_start_date"),
        'class="form-control tip datepicker" id="coupon_start_date"  required="required"'
    ) ?>
</div>
<div class="form-group">
    <?= lang("EXPIRY DATE", "EXPIRY DATE") ?>
    <?= form_input(
        "coupon_expiry_date",
        set_value("coupon_expiry_date"),
        'class="form-control tip datepicker" id="coupon_expiry_date"  required="required"'
    ) ?>
</div>



                            </div>

                        </div>

                        <div class="form-group">

                            <?= form_submit(
                                "add_coupon",
                                lang("add_coupon"),
                                'class="btn btn-primary"'
                            ) ?>

                        </div>

                        <?php echo form_close(); ?>

                    </div>

                    <div class="clearfix"></div>

                </div>

            </div>

        </div>

    </div>

    <script>
    $(function() {
        // Target input fields with the "datepicker" class and apply the datepicker widget
        $(".datepicker").datepicker();
    });
</script>


</section>