<?php
/**
 * Plugin Name
 *
 * @package           PluginPackage
 * @author            Change Marketing
 * @copyright         2020 Tutorial Form With Ajax
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Tutorial Form With Ajax
 * Plugin URI:        https://changemarketing.no/plugin-name
 * Description:       2019 Tutorial Form With Ajax.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Change Marketing
 * Author URI:        https://changemarketing.no
 * Text Domain:       cmlp_
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */
register_activation_hook( __FILE__, 'createPluginActivation' );

function createPluginActivation(){
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $table_name = $wpdb->prefix.'members_registration';
    $table_name_2 = $wpdb->prefix.'service_setup';

    $sql = "CREATE TABLE `$table_name` (
            `user_id` int(11) NOT NULL AUTO_INCREMENT,
            `form_id` int(11) DEFAULT NULL, 
            `first_name` varchar(220) DEFAULT NULL,
            `last_name` varchar(220) DEFAULT NULL,
            `email` varchar(220) DEFAULT NULL,
            `phone` varchar(220) DEFAULT NULL,
            `classification` varchar(220) DEFAULT NULL,
            `comment` text,
            `attendant` int(11) DEFAULT NULL,
            `creation_time` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY(user_id)
        ) ENGINE = MyISAM DEFAULT CHARSET=latin1;    
    ";

    // Creating the SEtup TABLE and ADmin Menu to the Plugin Page
    
    $sql_two = "CREATE TABLE `$table_name_2` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(225) DEFAULT NULL,
        `body`  text,
        `auditorium` int(11) NOT NULL DEFAULT '155',
        `conference` int(11) NOT NULL DEFAULT '30',
        `banquet` int(11) NOT NULL DEFAULT '150',
        `service_day` DATE DEFAULT NULL,
        `activation_on` enum('0','1','2') default '0',
        `creation_time`  DATETIME DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY(id)
    ) ENGINE = MyISAM DEFAULT CHARSET=latin1;    
";


    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name){
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        dbDelta($sql_two);
    }
}    
    add_action( 'admin_menu', 'AddAdminMenu' );

    function AddAdminMenu(){
        add_menu_page('Tutorial Plugin Page','Tutorial Plugin Menu', 'manage_options', __FILE__, 'AdminPage','dashicons-admin-home');
    }

    function AdminPage(){
    ?>
    <form action="" method="post">
        <div class="wrap" >
            <h2>Client Service Registration</h2>
                <div id="post-body-content" class="edit-form-section edit-comment-section" style="max-width: 50%; padding: 10px;">
                    <div class="inside">
                        <div id="comment-link-box">

                        </div>
                    </div>
                    <div id="namediv" class="stuffbox">
                        <div class="inside">
                            <h2 style=" padding: 10px;" class="edit-comment-author">Client Service Registration</h2>
                            <fieldset>
                                <legend class="screen-reader-text">Client Service Registration</legend>
                                <table class="form-table editcomment" role="presentation">
                                    <tbody>
                                    <tr>
                                        <td class="first"><label for="name">Website URL</label></td>
                                        <td><input type="text" required name="title" size="30" value="" id="title"></td>
                                    </tr>
                                    <tr>
                                        <td class="first"><label for="email">Category</label></td>
                                        <td>
                                            <input type="name" required name="category" size="30" value="150" id="auditorium">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="first"><label for="name">Sub Category</label></td>
                                        <td><input type="number" required name="subcat" size="30" value="30" id="subcat"></td>
                                    </tr>
                                    <tr>
                                        <td class="first"><label for="email">Site Owner's Name</label></td>
                                        <td>
                                            <input type="number" required name="name" size="30" value="155" id="owner_name">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first"><label for="email">Phone Number</label></td>
                                        <td>
                                            <input type="number" required name="phone" size="30" value="155" id="phone">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first"><label for="email">Email</label></td>
                                        <td>
                                            <input type="email" required name="email" size="30" value="155" id="email">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first"><label for="email">Module</label></td>
                                        <td>
                                            <input type="number" required name="module" size="30" value="155" id="module">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first"><label for="email">Social</label></td>
                                        <input type="checkbox" id="facebook" name="facebook" value="Facebook">
                                            <label for="facebook"> Facebook</label><br>
                                            <input type="checkbox" id="twitter" name="twitter" value="Twitter">
                                            <label for="twitter"> Twitter</label><br>
                                            <input type="checkbox" id="instagram" name="instagram" value="Instagram">
                                            <label for="instagram"> Instagram</label><br><br>
                                    </tr>                                                                                                                                                 
                                    <tr>
                                        <?php $nextSunday = date('Y-m-d', strtotime('next sunday')); ?>
                                        <td class="first"><label for="name">Service Date</label></td>
                                        <td><input type="date" required name="service_day" value="<?php echo "$nextSunday" ?>" id="service_day"></td>
                                    </tr>
                                    <tr>
                                        <td class="first"><label for="body">Notes</label></td>
                                        <td>

                                        <?php 
                                        $settings = array('teeny' => true, 'textarea_rows' =>10, 'tabindex'=>1); 
                                        wp_editor(esc_html((get_option('text',''))),'body', $settings);
                                         ?>

                                                 <!-- <textarea style="width: 100%" name="body" id="body">  </textarea> -->
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="first"><label for="email">Status</label></td>
                                        <td>
                                            <select name="active_on" required id="active_on">
                                                <option value="0">Disabled</option>
                                                <option value="1">Active</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td> <button id="newsubmit" name="newsubmit" class="button button-success"  type="submit">Create</button> </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </fieldset>
                        </div>
                    </div>
                </div>
    </form>
    <?php    
    }
