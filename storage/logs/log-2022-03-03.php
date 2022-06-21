<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-03-03 12:33:02 --> Query error: Table 'servpro.provider_details' doesn't exist - Invalid query: SELECT `c`.`id`, `c`.`category_name`, `c`.`category_image`, GROUP_CONCAT(p_id) as categories, `p`.`title`, count(p_id) as p_count
FROM `categories` `c`
LEFT JOIN `provider_details` `p` ON `p`.`category` IN(`c`.`id`)
WHERE `c`.`status` = 1
GROUP BY `c`.`id`
ORDER BY `id` DESC
ERROR - 2022-03-03 12:33:02 --> Severity: error --> Exception: Call to a member function result_array() on boolean C:\xampp\htdocs\servpro\application\models\Categories_model.php 57
ERROR - 2022-03-03 12:33:02 --> Query error: Table 'servpro.provider_details' doesn't exist - Invalid query: SELECT `c`.`id`, `c`.`category_name`, `c`.`category_image`, GROUP_CONCAT(p_id) as categories, `p`.`title`, count(p_id) as p_count
FROM `categories` `c`
LEFT JOIN `provider_details` `p` ON `p`.`category` IN(`c`.`id`)
WHERE `c`.`status` = 1
GROUP BY `c`.`id`
ORDER BY `id` DESC
ERROR - 2022-03-03 12:33:02 --> Severity: error --> Exception: Call to a member function result_array() on boolean C:\xampp\htdocs\servpro\application\models\Categories_model.php 57
ERROR - 2022-03-03 12:37:46 --> Query error: Table 'servpro.language' doesn't exist - Invalid query: SELECT language, language_value, tag, flag_img,status FROM `language` WHERE status = 1
ERROR - 2022-03-03 12:37:46 --> Severity: error --> Exception: Call to a member function result_array() on boolean C:\xampp\htdocs\servpro\application\models\Language_model.php 210
ERROR - 2022-03-03 12:37:46 --> Query error: Table 'servpro.language' doesn't exist - Invalid query: SELECT language, language_value, tag, flag_img,status FROM `language` WHERE status = 1
ERROR - 2022-03-03 12:37:46 --> Severity: error --> Exception: Call to a member function result_array() on boolean C:\xampp\htdocs\servpro\application\models\Language_model.php 210
