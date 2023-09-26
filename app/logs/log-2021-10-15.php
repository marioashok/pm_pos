<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-10-15 15:59:09 --> 404 Page Not Found: Uploads/logo1.png
ERROR - 2021-10-15 15:59:38 --> Query error: Unknown column 'tec_product.id' in 'field list' - Invalid query: SELECT tec_product.id as id, tec_products.name, tec_products.code, COALESCE(sum(tec_sale_items.quantity), 0) as sold, ROUND(COALESCE(((sum(tec_sale_items.subtotal)*tec_products.tax)/100), 0), 2) as tax, COALESCE(sum(tec_sale_items.quantity)*tec_sale_items.cost, 0) as cost, COALESCE(sum(tec_sale_items.subtotal), 0) as income, ROUND((COALESCE(sum(tec_sale_items.subtotal), 0)) - COALESCE(sum(tec_sale_items.quantity)*tec_sale_items.cost, 0) -COALESCE(((sum(tec_sale_items.subtotal)*tec_products.tax)/100), 0), 2)
            as profit
FROM `tec_sale_items`
LEFT JOIN `tec_products` ON `tec_sale_items`.`product_id`=`tec_products`.`id`
LEFT JOIN `tec_sales` ON `tec_sale_items`.`sale_id`=`tec_sales`.`id`
WHERE `tec_sales`.`store_id` = '1'
GROUP BY `tec_products`.`id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2021-10-15 15:59:46 --> Query error: Unknown column 'tec_product.id' in 'field list' - Invalid query: SELECT tec_product.id as id, tec_products.name, tec_products.code, COALESCE(sum(tec_sale_items.quantity), 0) as sold, ROUND(COALESCE(((sum(tec_sale_items.subtotal)*tec_products.tax)/100), 0), 2) as tax, COALESCE(sum(tec_sale_items.quantity)*tec_sale_items.cost, 0) as cost, COALESCE(sum(tec_sale_items.subtotal), 0) as income, ROUND((COALESCE(sum(tec_sale_items.subtotal), 0)) - COALESCE(sum(tec_sale_items.quantity)*tec_sale_items.cost, 0) -COALESCE(((sum(tec_sale_items.subtotal)*tec_products.tax)/100), 0), 2)
            as profit
FROM `tec_sale_items`
LEFT JOIN `tec_products` ON `tec_sale_items`.`product_id`=`tec_products`.`id`
LEFT JOIN `tec_sales` ON `tec_sale_items`.`sale_id`=`tec_sales`.`id`
WHERE `tec_sales`.`store_id` = '1'
GROUP BY `tec_products`.`id`
ORDER BY `id` DESC
 LIMIT 10
