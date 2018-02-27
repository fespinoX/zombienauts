<?php
/*
Plugin Name: WP Testimonial Widget
Plugin URI: http://www.starkdigital.net
Description: This plugin is for creating testimonials and display using Widget & Shortcodes on front end.
Author: Stark Digital
Version: 3.0
Company: Stark Digital
Author URI: http://www.starkdigital.net
*/

require_once( dirname(__FILE__)."/swpt_ajax_functions.php" );
add_action('wp_ajax_show_testimonial_diaglogbox', '_fnShowDiaglogContent'); //dialog box contnt

/**
 * @return string show notice on plugin activation
 */
add_action( 'admin_notices', 'swpt_admin_notice' );
function swpt_admin_notice() {
    $user_id = get_current_user_id();
    if ( !get_user_meta( $user_id, 'swp_testimonial_update_notice' ) ) {
        $class = 'notice notice-warning is-dismissible';
        $message = __( 'This is the major release for "WP Testimonial Widget". Please configure it manually to avoid unexpected behavior of a plugin.', 'tmp' );
        //echo '<div class="notice"><p>' . $message . '</p><a href="?swp-testimonial-dismissed">Dismiss</a></div>';
        printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
    }
}


function swp_testimonial_notice_dismissed() {
    $user_id = get_current_user_id();
    if ( isset( $_GET['swp-testimonial-dismissed'] ) )
        add_user_meta( $user_id, 'swp_testimonial_update_notice', 'true', true );
}
add_action( 'admin_init', 'swp_testimonial_notice_dismissed' );

/**
 * Function swpt_scripts_required() includes required jquery files
*/
function swpt_scripts_required(){
    wp_enqueue_script( 'jquery' );
    if ( ! wp_script_is( 'swp_testi_slick_js', 'enqueued' ) ) {
        wp_enqueue_script('swp_testi_slick_js',plugins_url('/js/slick.min.js', __FILE__));   
    }
    if( ! wp_style_is( 'swp_jquery_slick', 'enqueued' ) ){
        wp_register_style('swp_jquery_slick',plugins_url('/css/slick.css',__FILE__) );
        wp_enqueue_style( 'swp_jquery_slick' );
    }
    if( ! wp_style_is( 'swp_jquery_slick_theme', 'enqueued' ) ){
        wp_register_style('swp_jquery_slick_theme',plugins_url('/css/slick-theme.css',__FILE__) );
        wp_enqueue_style( 'swp_jquery_slick_theme' ); 
    }
    /* Testimonial CSS */
    wp_register_style('swp_testimonial_css',plugins_url('/css/testimonial.css',__FILE__) );
    wp_enqueue_style( 'swp_testimonial_css' );
} 
add_action('wp_enqueue_scripts', 'swpt_scripts_required');

/**
 * Function swpt_required_css() includes required css files
*/
add_action( 'admin_head', 'swpt_required_css' );
function swpt_required_css() {
    wp_register_style( 'swpt_css', plugins_url('/css/basic.css', __FILE__) );
    wp_enqueue_style( 'swpt_css' );
    wp_register_style( 'swpt_jquery_ui_css', plugins_url('/css/jquery-ui.css', __FILE__) );
    wp_enqueue_style( 'swpt_jquery_ui_css' );
   
    wp_enqueue_script('swp_jquery_ui',plugins_url('/js/jquery-ui.min.js',__FILE__) );
}

/* Add the media uploader script */
function my_media_lib_uploader_enqueue() {
    wp_enqueue_media();
    wp_enqueue_script('media-lib-uploader-js',plugins_url('/js/media-lib-uploader.js',__FILE__) );
}
add_action('admin_enqueue_scripts', 'my_media_lib_uploader_enqueue');

/**
 * Function swpt_install_testimonial() is to create table if it is not exists
*/
function swpt_install_testimonial()
{
    global $wpdb;
    $strTbl = $wpdb->prefix."swp_testimonial";
    $createTbl =  "CREATE TABLE $strTbl  (
                    `id` int(10) NOT NULL AUTO_INCREMENT,
                    `description` text NOT NULL,
                    `company` varchar(255) NOT NULL,
                    `website` text NOT NULL,
                    `client_name` varchar(255) NOT NULL,
                    `client_desg` varchar(255) NOT NULL,
                    `category` varchar(255) NOT NULL,
                    `client_avtar` varchar(255) NOT NULL,
                    `orders` int(10),
                    PRIMARY KEY (`id`)
                )";
    $strCatTbl = $wpdb->prefix."swp_category";
    $createCatTbl = "CREATE TABLE $strCatTbl (
                     `id` int(10) NOT NULL AUTO_INCREMENT,
                     `category_name` varchar(255) NOT NULL,
                     PRIMARY KEY (`id`)
                    )";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($createTbl);
    dbDelta($createCatTbl);
}

register_activation_hook(__FILE__,'swpt_install_testimonial');

include_once("testimonial_widget.php");
include_once("shortcode.php"); 
include_once("functions.php"); 

//step1 Load basic Class
if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Testimonial_List_Table extends WP_List_Table {
    var $strQuery;
    function __construct(){
        global $status, $page;
                
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'testimonial',     //singular name of the listed records
            'plural'    => 'testimonials',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
    }
    
    /**
     * Function column_default() is called when the parent class can't find a method specifically build for a given column.
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
    */
    function column_default($item, $column_name){
        switch($column_name){
            case 'Rank':
            case 'description':
            case 'company':
            case 'website':
                return stripslashes($item[$column_name]);
            case 'client_name':
            case 'client_desg':
            case 'category':
            case 'client_avtar':
            default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }

    function column_client_avtar($item){
        if(empty($item['client_avtar'])){
            return 'Not Available';
        }else{    
            //return "<img height='50px' width='50px' src='".site_url().'/wp-content/uploads/testimonails/'.$item['client_avtar']."'>";
            return "<img height='50px' width='50px' src='".$item['client_avtar']."'>";
        }
    }


    /**
     * Function column_description() is a custom column method and is responsible for what is rendered in any column with a name/slug of 'description'.
     * @param array $item a singular item.
    */
    function column_description($item){
        return sprintf('%s',substr(stripslashes($item['description']),0,50));
    }

    /**
     * Function column_description() is a custom column method and is responsible for what is rendered in any column with a name/slug of 'description'.
     * @param array $item a singular item.
    */
    function column_client_name($item){
         $actions = array(
            'edit'      => sprintf('<a href="?page=%s&mode=%s&testimonial=%s">Edit</a>',$_REQUEST['page'],'edit',$item['id']),
            'delete'    => sprintf("<a href=\"?page=%s&action=%s&testimonial_id=%s\" onclick=\"if ( confirm( '" . esc_js( sprintf( __( "You are about to delete this List '%s'\n  'Cancel' to stop, 'OK' to delete." ),  $item['client_name'] ) ) . "' ) ) { return true;}return false;\">Delete</a>",$_REQUEST['page'],'delete',$item['id']),
        );
        return sprintf('%s %s',$item['client_name'],$this->row_actions($actions));
    }

    /**
     * Function column_description() is a custom column method and is responsible for what is rendered in any column with a name/slug of 'description'.
     * @param array $item a singular item.
    */
    function column_client_desg($item){
        return sprintf('%s',$item['client_desg']);
    }
    /**
     * Function column_description() is a custom column method and is responsible for what is rendered in any column with a name/slug of 'description'.
     * @param array $item a singular item.
    */

    /**
     * Function column_description() is a custom column method and is responsible for what is rendered in any column with a name/slug of 'description'.
     * @param array $item a singular item.
    */
    function column_category($item){
        global $wpdb;
        $strTblName = $wpdb->prefix."swp_category";
        $Cat_Name = $wpdb->get_var( 'SELECT category_name FROM '.$strTblName.' WHERE id = '.$item['category'] );
        return sprintf('%s',$Cat_Name);
    }
    /**
     * Function column_cb() is to display checkboxes.
     * @param array $item a singular item.
    */
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("testimonial")
            /*$2%s*/ $item['id']                //The value of the checkbox should be the record's id
        );
    }
     
    /**
     * Function get_columns() is to set table's columns and titles.
    */  
    function get_columns(){
        $columns = array(
            'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
            'client_name' => "Author",
            'company'    => 'Company',
            'description'     => 'Description',
            'client_avtar' => "Avatar",
            'category' => "Category",
        );
        return $columns;
    }
    
    /**
     * Function get_sortable_columns() is to sort one/more columns.
    */ 
    function get_sortable_columns() {
        $sortable_columns = array(
            'client_name' => array("client_name",false),
            'client_desg' => array("client_desg",false),            
            'company'    => array('company',false)            
        );
        return $sortable_columns;
    }

    /**
     * Function get_bulk_actions() is to set bulk actions for table.
    */ 
    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }
    
    /**
     * Function process_bulk_action() is to set bulk actions for table.
    */
    function process_bulk_action() {
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
        
    }
 
    /**
     * Function prepare_items() is to list testimonial and set order.
    */
    function prepare_items($searchvar= NULL) {
        global $wpdb; //This is used only if making any database queries

        $per_page = 5;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
      
        $strTbl = $wpdb->prefix."swp_testimonial";
        $this->_column_headers = array($columns, $hidden, $sortable);
        $wpdb->query("SET @a=0");
        if(!empty($searchvar)){
            $this->strQuery = "SELECT id, description, company, website,client_name,client_desg,client_avtar,category  FROM $strTbl WHERE client_name LIKE '%".$searchvar."%' ORDER BY id DESC";
        }else{
        $this->strQuery = "SELECT (@a:=@a+1) AS Rank, id, description, company, website,client_name,client_desg,client_avtar,category FROM ".$strTbl ." ORDER BY id DESC";
        }
        $data = $wpdb->get_results($this->strQuery,ARRAY_A );

        if(isset($_GET['filter_cat']) && !empty($_GET['cat_name'])):
            $strReviewStatus = $_GET['cat_name'];
            if($strReviewStatus != "All"):              
                $data = $wpdb->get_results( "SELECT id, description, company, website,client_name,client_desg,client_avtar,category FROM $strTbl WHERE category = '".$strReviewStatus."' ORDER BY id DESC", ARRAY_A );
            else:
                $data = $wpdb->get_results( "SELECT id, description, company, website,client_name,client_desg,client_avtar,category FROM $strTbl ORDER BY id DESC", ARRAY_A );
            endif;
        endif;
                               
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'id'; //If no sort, default to rank
                       $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to desc
            if(is_numeric($a[$orderby]))
            {
                 $result = ($a[$orderby] > $b[$orderby]?-1:1); //Determine sort order
            }
            else
            {
                $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            }
            
            return ($order==='desc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');
        $current_page = $this->get_pagenum();
        $total_items = count($data);
        
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
              
        $this->items = $data;
      
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
    
}

/**
* Function _fnAddMenuItems() is called to add menu in admin side
*/     
add_action('admin_menu', '_fnAddMenuItems');
function _fnAddMenuItems(){
    add_menu_page('Testimonials', 'Testimonials', 'activate_plugins', 'testimonial', '_fnDemoRenderListPage', plugins_url('images/icon.png', __FILE__),6);
    add_submenu_page( 'testimonial', 'Categories', 'Categories', 'manage_options', 'testimonail_category', 'swpt_add_category_menu' );
    add_submenu_page( 'testimonial', 'Settings', 'Settings', 'manage_options', 'setting', 'swpt_add_settings_menu1' );
    add_submenu_page( 'testimonial', 'Re Order', 'Re Order', 'manage_options', 're-order', 'swpt_re_order' );
    add_submenu_page( 'testimonial', 'Help', 'Help', 'manage_options', 'help', 'swpt_add_settings_menu' );
} 

/**
* Function _fnDemoRenderListPage is called to display list of table.
*/
function _fnDemoRenderListPage(){
                
    //Create an instance of our package class...
    $testListTable = new Testimonial_List_Table();

    //for message display
    $messages = array();
    if ( isset($_GET['update']) ) :
        switch($_GET['update']) {
            case 'del':
            case 'del_many':
                $delete_count = isset($_GET['delete_count']) ? (int) $_GET['delete_count'] : 0;
                $messages[] = '<div id="message" class="updated"><p>' . sprintf( _n( 'testimonial deleted.', '%s testimonials deleted.', $delete_count ), number_format_i18n( $delete_count ) ) . '</p></div>';
                break;
            case 'add':
                $strmsg = isset($_GET['id']) ? "updated" : "Added";
                $messages[] = '<div id="message" class="updated"><p>' . __( 'New record $strmsg.' ) . '</p></div>';
                break;
        }
    endif; 

    $this_file = "?page=".$_REQUEST['page'];

    switch($testListTable->current_action())
    {
        case "add":
        case "edit":
        case "delete":
            global $wpdb;
                       
            if(isset($_GET['action2']) && ($_GET['action2']=="-1"))
            {
                $del_id = $_GET['testimonial'];
                if(is_array($del_id)){
                    foreach ($del_id as $value) {
                        $del_data = swpt_delete_data($value);
                    }
                }else{
                    $del_data = swpt_delete_data($del_id);    
                }
                
            }
            
            if(isset($_GET['testimonial_id']) && $_GET['testimonial_id'])
            {
                $del_id = $_GET['testimonial_id'];
                $del_data = swpt_delete_data($del_id);
            }
            if(isset($del_data)){ ?>
                <div class='<?php if(!empty($del_data['msg'])): echo $del_data['msgClass']; endif; ?>'>
                    <p><?php if(!empty($del_data['msg'])): echo $del_data['msg']; endif; ?></p>
                </div>
            <?php } 
                     
            $this_file = $this_file."&update=delete";
        default:
        ?>
            <script type='text/javascript' src="<?php echo plugins_url('js/jquery.validate.js',__FILE__); ?>"></script>
            <script type="text/javascript">
            jQuery(document).ready(function() {
                jQuery("#add_testi").validate();
            });
            </script>

            <?php
            global $wpdb;
                
            $strTbl = $wpdb->prefix."swp_testimonial";
            $strPageListingParam ="testimonial";
            $arrWhere = array();
            if(!empty($_POST['description']))
            {
                substr($_POST['description'],0,500);
            }
            
            //check blank data & add record
            if (!empty($_POST['addTesti']))
            {
                //call function add_update_testi to add / edit record
                if($_POST['id'] != "")
                {
                    $arrWhere = array("id" => $_POST['id'] );
                    unset($_POST['id']);
                }
                //remove submit button & remove blank field
                unset($_POST['addTesti']);                
                $arrData = array();
                foreach ($_POST as $key => $value) {
                    $arrData[$key] = stripslashes($value);
                }
                $arrMsg = array();
                
                if(count($arrData ) > 0)
                {
                    //echo('PRASAD');
                    //print_r($_POST['client_avtar']);
                    /*$aAllowedTypes = array('image/jpeg','image/pjpeg','image/png','image/gif');
                    if( $_FILES['client_avtar']['name'] != "" ) {
                        $aSavedFiles = upload_file_on_server('client_avtar', testi_FILE_DIR , $_FILES, $aAllowedTypes);
                    }*/
                    //print_r($arrData['client_avtar']);echo('<br>');
                    if( isset($_POST['client_avtar']) ) {
                        $arrData['client_avtar'] = $_POST['client_avtar'];//$aSavedFiles[0];
                    }
                    $boolAdded = swpt_add_update_testi($strTbl,$arrData,$arrWhere); 
                    if(!empty($arrWhere) && $boolAdded )
                    {
                        $arrMsg = array('msg' => 'Testimonial Updated.','msgClass' =>'updated');
                        
                    }
                    elseif (empty($arrWhere) && $boolAdded) {
                        $arrMsg = array('msg' => 'Testimonial Added.','msgClass' =>'updated');
                        
                    }
                    else
                    {
                        $arrMsg = array('msg' => 'Error occured while saving your testimonial.','msgClass' =>'error');
                    }
                }
            }
            
            if( isset($_GET['mode']) && ($_GET['mode'] == 'edit') ){
                if(isset($_GET['testimonial']))
                {
                    $intEditId = $_GET['testimonial'];
                    if($intEditId > 0)
                    {
                        $arrWhere = array("id=$intEditId");   
                        $arrTestiData = swpt_edit_data($strTbl,$arrWhere);
                        
                    }
                }
            }
            
            //Fetch, prepare, sort, and filter our data...
            if(isset($_GET['s'])):
                $testListTable->prepare_items($_GET['s']);
            else:
                $testListTable->prepare_items();
            endif;
            if ( ! empty($messages) ) {
                foreach ( $messages as $msg )
                echo $msg;
            }
            ?>
            
            <div class="wrap">
                <div class="icon32 icon32-posts-post" id="icon-edit">
                    <br>
                </div>
                <h2>Testimonials</h2>
                <?php if(isset($arrMsg) && !empty($arrMsg)){ ?>
                    <div class="<?php echo $arrMsg['msgClass']; ?>">
                    <p><?php echo $arrMsg['msg']; ?></p>
                </div>
                <?php } 
                ?>
                <div id="col-container">
                    <div id="col-right">
                        <div class="col-wrap">
                            <div class="form-wrap">
                                <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
                                <form id="testimonials-filter" method="get">
                                    <!-- For plugins, we also need to ensure that the form posts back to our current page -->
                                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                                    <select class="postform" id="cat_name" name="cat_name">
                                        <option>All Category</option>
                                        <?php
                                        $allCat = getCategory();
                                        if( (isset($_GET['cat_name'])) && (!empty($_GET['cat_name']) ) ){
                                            $drop_cat_name = $_GET['cat_name'];
                                            foreach ($allCat as $value) {
                                            ?>
                                            <option <?php if($drop_cat_name == $value['id']): ?> selected="" <?php endif; ?> value="<?php echo $value['id']; ?>"><?php echo $value['category_name']; ?></option>
                                            <?php
                                        }
                                        }else{
                                        foreach ($allCat as $value) {
                                        ?>

                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['category_name']; ?></option>
                                        <?php
                                        }}
                                        ?>
                                    </select>
                                    <input type="submit" value="Filter" class="button" name="filter_cat">
                                    <p class="search-box">
                                        <label class="screen-reader-text" for="post-search-input">Search Testimonails:</label>
                                        <input id="post-search-input" type="search" value="<?php if(isset($_GET['s'])): echo $_GET['s']; endif; ?>" name="s">
                                        <input id="search-submit" class="button" type="submit" value="Search Testimonails" name="">
                                        <?php 
                                        if(isset($_GET['s']) && !empty($_GET['s']))
                                            { 
                                                ?><a href="?page=testimonial">Reset</a><?php
                                            } 
                                        ?>                                        
                                    </p>
                                    <!-- Now we can render the completed list table -->
                                    <?php $testListTable->display() ?>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="col-left">
                        <div class="col-wrap">
                            <div class="form-wrap">
                                <?php
                                    if(isset($intEditId)) {
                                        $strLabel = "Edit";
                                    } else {
                                        $strLabel = "Add";
                                    }
                                ?>
                                <h3>
                                    <?php echo $strLabel; ?> Testimonial
                                    <?php if(isset($intEditId)) { ?>
                                    <a href="?page=testimonial" class="add-new-h2">Add New</a>
                                    <?php } ?>
                                </h3>
                                <form id="add_testi" name="add_testi" enctype="multipart/form-data" method="post" action="" class="frm_testi">
                                    <div class="form-field">
                                        <label for="Company">Company Name<span class="chkRequired">*</span></label>
                                        <input type="text" size="40" class="required" value="<?php if(isset($arrTestiData->company)) {  echo stripslashes($arrTestiData->company);} ?>" id="company" name="company">
                                        <p>Name of company who gave you the feedback.</p>
                                    </div>
                                    <div class="form-field">
                                        <label for="Company">Author Name<span class="chkRequired">*</span></label>
                                        <input type="text" size="40" class="required" value="<?php if(isset($arrTestiData->client_name)) {  echo stripslashes($arrTestiData->client_name);} ?>" id="client_name" name="client_name">
                                        <p>Name of author who gave you the feedback.</p>
                                    </div>
                                    <div class="form-field">
                                        <label for="Company">Designation</label>
                                        <input type="text" size="40" class="" value="<?php if(isset($arrTestiData->client_desg)) {  echo stripslashes($arrTestiData->client_desg);} ?>" id="client_desg" name="client_desg">
                                        <p>Designation of author who gave you the feedback.</p>
                                    </div>
                                    <div class="form-field">
                                        <label for="Company">Author Avatar</label>
                                        <input type="text" name="client_avtar" id="client_avtar_uploader" value="<?php if( isset($arrTestiData->client_avtar) ) echo $arrTestiData->client_avtar; ?>" />
                                        <input id="upload-button" type="button" class="button" value="Upload Image" />
                                        <!-- <input type="file" name="client_avtar" id="client_avtar"> -->
                                        <?php if( isset($arrTestiData->client_avtar) ): ?>
                                        <img src="<?php echo $arrTestiData->client_avtar; ?>" width="50" height="50"/>
                                    <?php endif; ?>
                                    <small class="recommended_text">Recommended size 100 X 120</small>
                                    </div>
                                    <div class="form-field swp-image">
                                        <label for="Company">Testimonial Category</label>
                                        <?php $arrCategory = getCategory(); ?>
                                        <select name="category" id="category">
                                            <?php foreach ($arrCategory as $value) {
                                            ?>
                                            <option <?php if( (isset($arrTestiData->category)) && ($arrTestiData->category == $value['category_name']) ): ?> selected="" <?php endif; ?> value="<?php echo $value['id']; ?>"><?php echo $value['category_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-field">
                                        <label for="Website">Company Website</label>              
                                        <input type="text" size="40" value="<?php if(isset($arrTestiData->website)) {echo $arrTestiData->website;} ?>" id="website" name="website">
                                    </div>
                                    <div class="form-field">
                                        <label for="Description">Testimonial<span class="chkRequired">*</span></label>
                                        <textarea name ='description' class="required test_description" cols="51" rows="7" ><?php if(isset($arrTestiData->description)) {echo stripslashes($arrTestiData->description);} ?></textarea>                          
                                        <p>Few words said by the person.</p>            
                                    </div>
                                    <p class="submit">
                                        <?php 
                                            $strBtn = 'Add';
                                            if(isset($_GET['testimonial']))
                                            {
                                                $strBtn = 'Update';
                                            }
                                        ?>
                                        <input type="hidden" value="<?php if(isset($_GET['testimonial'])){ echo $arrTestiData->id;} ?>" name="id">
                                        <input type="submit" value="<?php echo $strBtn; ?>" class="button button-primary" id="addTestis" name="addTesti">
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div><!-- /col-left -->
                </div><!-- /col-container -->
            </div>
            <?php
            break;
    }
} 

/**
 * Function swpt_sub_menu() and swpt_add_settings_menu() are written to create sub menu Help.
*/ 
function swpt_add_settings_menu(){
    global $wpdb;
    include 'help.php';
}

function swpt_add_settings_menu1(){
    include 'setting.php';
}
function swpt_re_order(){
    include 're-order.php';
}
function swpt_add_category_menu(){
    include 'category.php';
    fncategory();
}
// Below code is to display tinymce button on page.

add_action( 'admin_init', 'swpt_addbuttons' );
function swpt_addbuttons() {
    add_filter("mce_external_plugins", "swpt_add_button");
    add_filter('mce_buttons', 'swpt_register_button');
} 

function swpt_register_button($buttons) {
    array_push( $buttons, "separator", 'testimonial' ); 
    return $buttons;
}  
function swpt_add_button($plugin_array) {
    $plugin_array['swptesti'] = plugin_dir_url(__FILE__). '/js/tinymce_button.js';
    return $plugin_array;
}
?>