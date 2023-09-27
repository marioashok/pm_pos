<br><br>


<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <section class="content">
    <div class="form-group" style="margin-top: 10px;">
    <input type="text" id="searchBox" placeholder="Search..." class="form-control">
</div>
        <!-- Display results here based on $currentResults -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <table id="UTable" class="table table-bordered table-striped table-hover">
                            <thead class="cf">
                                <tr>
                                    <th>Product ID</th>
                                    <th>Product Code</th>
                                    <th>Design Code</th>
                                    <th>Variation</th>
                                    <th>Quantity</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $result) : ?>
                                    <tr>
                                        <td><?php echo $result->product_id; ?></td>
                                        <td><?php echo $result->gen_product_code; ?></td>
                                        <td><?php echo $result->design_code; ?></td>
                                        <td><?php echo $result->is_variation_available;?></td>
                                        <td><?php echo $result->Quantity; ?></td>
                                        <td class="text-center">
                                             <a href="<?php echo site_url("subcategories/edit/$result->id"); ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                             <a href="<?php echo site_url("subcategories/delete/$result->id"); ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

      

    </section>

   

</body>
</html>
