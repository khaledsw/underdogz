<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
if (isset($_SESSION['bt_message'])) {
    echo $_SESSION['bt_message'];
    unset($_SESSION['bt_message']);
}
?>
<div class="wrap">
<h2 class="bt-title"><?php echo __('Extrafields');?>
<a class="bt-button add-new-h2" href ="<?php echo admin_url('edit.php?post_type=iw_courses&page=add-extra-field'); ?>"><?php echo __("Add New");?></a>
<a class="bt-button add-new-h2" href ="javascript:void(0);" onclick="javascript:document.getElementById('extrafields-form').submit();return false;"><?php echo __("Delete");?></a>
</h2>
<form id="extrafields-form" action="<?php echo admin_url(); ?>admin-post.php" method="post">
    <input type="hidden" name="action" value="iw_courses_extrafields_delete"/>
    <?php
    global $wpdb;
    $results = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'iw_courses_extrafields');
    ?>
    <table class="wp-list-table widefat fixed posts">
        <thead>
            <tr>
                <th scope="col" id="cb" class="manage-column column-cb check-column" style="">
                    <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                    <input id="cb-select-all-1" type="checkbox">
                </th>
                <th scope="col" id="author" class="manage-column column-author" style="">Name</th>
                <th scope="col" id="categories" class="manage-column column-categories" style="">Type</th>
                <th scope="col" id="tags" class="manage-column column-tags" style=""><?php echo __('Assign to Category'); ?></th>
                <th scope="col" id="comments" class="manage-column column-description num sortable desc" style="">
                    <span>Description</span>
                </th>
                <th scope="col" id="date" class="manage-column column-date sortable asc" style="">
                    <span>Published</span>
                </th>	
                <th scope="col" id="title" class="manage-column column-title sortable desc" style="">
                    <span>ID</span>
                </th>
            </tr>
        </thead>

        <tbody id="the-list">
            <?php
            foreach ($results as $value) {
                $cates = $wpdb->get_results($wpdb->prepare('SELECT a.name from ' . $wpdb->prefix . 'terms as a inner join ' . $wpdb->prefix . 'term_taxonomy as b on a.term_id = b.term_id inner join ' . $wpdb->prefix . 'iw_courses_extrafields_category as c on b.term_id = c.category_id where b.taxonomy = \'iw_courses_class\' and c.extrafields_id=%d', $value->id));
                ?>
                <tr>
                    <th scope="row" class="check-column">
                        <input id="cb-select-1" type="checkbox" name="fields[]" value="<?php echo $value->id; ?>"/>
            <div class="locked-indicator"></div>
            </th>
            <td>
                <strong><?php echo stripslashes($value->name) ; ?></strong>
                <div class="row-actions">
                    <a href="<?php echo admin_url('edit.php?post_type=iw_courses&page=add-extra-field&id=' . $value->id); ?>" title="Edit this item">Edit</a> | 
                    <a class="submitdelete" title="Move this item to the Trash" href="<?php echo admin_url("admin-post.php?action=delete_extrafield&id=" . $value->id); ?>">Delete</a>
                </div>
            </td>
            <td><?php echo $value->type; ?></td>
            <td><?php
                if (!empty($cates)) {
                    foreach ($cates as $cat) {
                        echo $cat->name;
                    }
                } else {
                    echo __('All');
                }
                ?></td>
            <td><?php echo $value->description; ?></td>
            <td><?php echo ($value->published == 1) ? __('Yes') : __('No'); ?></td>
            <td><?php echo $value->id; ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</form>
</div>