<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body">
                    <?php
                    $i = 0;
                    $total_sales_count = 0;
                    $total_shipping_count = 0;

                    // Calculate the total sales count before the loop
                    while ($i < 30) :
                        $get_current_date = $this->reports_model->get_current_date($i);
                        $get_sales_count = $this->reports_model->get_sales_count($get_current_date);
                        $get_shipping_count = $this->reports_model->get_shipping_count($get_current_date);
                        $total_sales_count += $get_sales_count; // Add to total sales count
                        $total_shipping_count += $get_shipping_count; // Add to total shipping count
                        $i++;
                    endwhile;

                    // Display total sales count at the top
                    ?>
                    <span>Total Sales Count: <strong><?php echo $total_sales_count; ?></strong></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span>Total Shipping Count: <strong><?php echo $total_shipping_count; ?></strong></span>

                    <!-- Display the table after the total sales count -->
                    <table id="UTable" class="table table-bordered table-striped table-hover">
                        <thead class="cf">
                            <tr>
                                <th><?= lang("Date"); ?></th>
                                <th><?= lang("Orders received"); ?></th>
                                <th><?= lang("Orders Shipped"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;

                            while ($i < 30) :
                                $get_current_date = $this->reports_model->get_current_date($i);
                                $get_sales_count = $this->reports_model->get_sales_count($get_current_date);
                                $get_shipping_count = $this->reports_model->get_shipping_count($get_current_date);
                                ?>
                                <tr>
                                    <td><?php echo $get_current_date; ?></td>
                                    <td><?php echo $get_sales_count; ?></td>
                                    <td><?php echo $get_shipping_count; ?></td>
                                </tr>
                            <?php
                                $i++;
                            endwhile;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
