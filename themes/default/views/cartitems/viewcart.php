<?php
$uid =  $cartitem->uid;
$proID= ($cartitem->proId);
$results = $this->cartitems_model->getAllCartProductItems($uid);
$get_page_id_results= $this->cartitems_model->getCartTempByID($uid);
$ws_page_id=$get_page_id_results->page_id;
?>


<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('list_results'); ?></h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="catData" class="table table-striped table-bordered table-condensed table-hover" style="margin-bottom:5px;">
                            <thead>
                                <tr class="active">
                                    <th><?= lang("Image") ?></th>
                                    <th><?= lang("Product Code") ?></th>
                                    <th><?= lang("Product Name") ?></th>
                                    <th><?= lang("Price") ?></th>
                                    <th><?= lang("Quantity") ?></th>
                                    <th><?= lang("Total") ?></th>
                                    <th><?= lang("Actions") ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($results as $result): ?>
                <tr>
                    <td>
                        <div class="col-md-4" style="padding-left: 0px;  padding-right: 0px;">
                            <img src="../uploads/thumbs/<?php echo $result->thumb_image_path; ?>" alt="Image" class="img-responsive">
                        </div>
                    </td>
                    <td><?php echo $result->product_code; ?></td>
                    <td><?php echo $result->prod_name; ?></td>
                    <td><?php echo $result->Price; ?></td>
                    <td><?php echo $result->proCount; ?></td>
                    <td><?php echo $result->Price*$result->proCount; ?></td>
                    <td>
                        <a href="<?php echo site_url('cartitems/delete_cart_product_item/' . $result->cartId); ?>" 
                        onclick="return confirm('<?php echo lang('DELETE?'); ?>')" 
                        title="<?php echo lang('DELETE'); ?>" 
                        class="tip btn btn-danger btn-xs">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div>
                        <?php
                          
                        // function to get temp_cart details based on uid --> page_id, Payment_mode
                        // join register table based on uid --> $usename, email, userid
                            if($ws_page_id == '1')
                            {
                                $pageurl = 'cart.htm';
                            }
                            if($ws_page_id == '2')
                            {
                                $pageurl = 'shipaddress.htm';
                            }
                            if($ws_page_id == '3')
                            {
                                $pageurl = 'shipmode.htm';	
                            }
                            if($ws_page_id == '4' && $payment_mode == '')
                            {
                                $pageurl = 'payment.htm';	
                            }
                            if($ws_page_id == '4' && $payment_mode != '')
                            {
                                $pageurl = 'ordersummary.htm';	
                            }


                            $_SESSION['username'] = $userName;
                            $_SESSION['useremail'] = $fetch['email'];
                            $_SESSION['userid'] = $fetch['user_id'];

                            $url = "../index.php?URL=".$pageurl; 

                            echo "<a style='float:right;cursor:pointer' href='".$url."' target='_blank'> Proceed to Checkout </a> ";
                            ?>


                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>


</section>

