<?php
define('testi_FILE_DIR', WP_CONTENT_DIR.'/uploads/testimonails/');
define('testi_FILE_URL', WP_CONTENT_URL.'/uploads/testimonails/');
/**
 * Function swpt_widget_shortcode_output() is called in file shortcode.php and testi_widget.php to display data.
 * @param $testimonials is used to show number of testimonials to show on frontend.
 * @param $order is to set order of testimonials
 * @param $testimonials is to set effect.
*/ 
function swpt_widget_shortcode_output( $testimonials, $order, $order_by,$category,$fields,$num_words = 30 ){ 
    global $post; 
    global $wpdb;
    ob_start();

    $order_by = 'orders';
    if(!empty($testimonials)):
        $testimonials = " LIMIT ".$testimonials;
    endif;

    if(!empty($category) && ($category != 'all') ):
        $category = " WHERE category = ".$category;
    else:
        $category = " ";
    endif;
    
    if(!empty($fields)):
        $select = "SELECT id,description,".$fields;
    else:
        $select = "SELECT id,description ";
    endif;
    $strTbl = $wpdb->prefix."swp_testimonial";
    $strTestimonial = $select." FROM $strTbl ".$category." ORDER BY ". $order_by ." ". $order.$testimonials;

    $arrTestimonial =  $wpdb->get_results($strTestimonial,ARRAY_A);  

    $defaultImage = plugins_url('/images/profile.png',__FILE__);
    ?><?php
        foreach($arrTestimonial as $testi) {
            if(array_key_exists('company',$testi)){
                $strComp = $testi['company'];
            }
            $strWebsite = (array_key_exists('website',$testi)) ? $testi['website'] :'javascript:void(0);'; ?>
            <div class="front_end_data"> <?php
                if(array_key_exists('description',$testi)){
                    if(!empty($testi['description'])) { ?>
                        <p class="testimonial_content"> <?php  
                            $shortexcerpt = wp_trim_words( stripslashes($testi['description']), $num_words, $more = '… ' ); 
                            if ( $num_words == 0 )
                                $shortexcerpt = stripslashes($testi['description']);  
                            echo $shortexcerpt;
                            ?>
                        </p> <?php 
                    }
                } ?>
                <div class="bottom-testimonail"> <?php 
                    if(array_key_exists('client_avtar',$testi)) {
                        $authAvtar = $testi['client_avtar']; ?>  
                        <div class="left swp_author_img"> <?php 
                            if( !empty($authAvtar) ): ?>
                                <img src="<?php echo $authAvtar ?>" alt="Author Image" onerror="this.src='<?php echo $defaultImage; ?>'"><?php 
                            else :?>
                                <img src="<?php echo $defaultImage; ?>" alt="No image" /><?php 
                            endif; ?>
                        </div><?php
                    } ?>
                    <div class="auth_info"><?php 
                        if(array_key_exists('client_name',$testi)) {
                            if(!empty($testi['client_name'])): ?>
                                <p class="authName"><?php echo $testi['client_name']; ?></p><?php 
                            endif;  
                        } ?>
                        <div class="designation">
                            <?php 
                            if(array_key_exists('client_desg',$testi)){  
                                if(!empty($testi['client_desg'])): ?>
                                    <p><?php echo $testi['client_desg'];?></p><?php 
                                endif; 
                            } 
                            if(!empty($strComp)): ?>
                                <a href="<?php echo $strWebsite; ?>"><?php echo $strComp;  ?></a><?php 
                            endif; ?>
                        </div>
                    </div>
                </div>
            </div> <?php
        }
    $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;
}

//Enable the widget of the plugin.
add_action('widgets_init', create_function('', 'return register_widget("SWP_Testimonial_Widget");'));

/**
 * Function swpt_add_update_testi() is used to add or update testimonial.
 * @param $strTbl is to set table name.
 * @param $arrData is to set data.
 * @param $arrWhere is to set WHERE condition.
*/
function swpt_add_update_testi($strTbl,$arrData,$arrWhere= array())
{
    global $wpdb;

    if(count($arrWhere)==0)
    {
        $orderid = $wpdb->get_col("SELECT max(orders) FROM $strTbl");

        $orderid = $orderid[0]+1;
        $arrData['orders'] = $orderid;
        $wpdb->insert($strTbl,$arrData);
        return $wpdb->insert_id;
    }
    else
    {
        $wpdb->update($strTbl,$arrData,$arrWhere);

        return true;
    }
    return false;
}

/**
 * Function swpt_add_update_testi() is used to add or update testimonial.
 * @param $strTbl is to set table name.
 * @param $boolLimit is to set limit.
 * @param $arrWhere is to set WHERE condition.
*/
function swpt_edit_data($strTbl,$arrWhere="",$boolLimit=true)
{
    global $wpdb;
    $strWhere = "";

    if(count($arrWhere) > 0 )
    {

        $strSep =  (count($arrWhere) > 1?" AND ":"");
        
        $strWhere = " WHERE ".implode($strSep, $arrWhere);

    }
    if($boolLimit)
    {
        $strLimit = "LIMIT 1";
    }
    $strSql = "Select id,description,company, website,client_name,client_desg,client_avtar from $strTbl $strWhere $strLimit";
    
    if($boolLimit)
    {
        $arrResult =  $wpdb->get_row($strSql);  
    }
    else
    {
        $arrResult =  $wpdb->get_results($strSql);      
    }
    return $arrResult;
}

/**
 * Function swpt_add_update_testi() is used to add or update testimonial.
 * @param $intId is the id.
 */
function swpt_delete_data($intId)
{
    global $wpdb;
    $strTbl = $wpdb->prefix."swp_testimonial";

    $chkArray = is_array($intId);
    if($chkArray)
    {
        foreach($intId as $del_id)
        {
            $old_file_name = $wpdb->get_var( $wpdb->prepare( 'SELECT client_avtar FROM '.$strTbl.' WHERE id = %d', $del_id ) );
            delete_file(testi_FILE_DIR, $old_file_name);
            $deleteTesti = $wpdb->query("DELETE FROM ".$strTbl." WHERE id = ".$del_id);
        }
    }
    else
    {
        $old_file_name = $wpdb->get_var( $wpdb->prepare( 'SELECT client_avtar FROM '.$strTbl.' WHERE id = %d', $intId ) );
        delete_file(testi_FILE_DIR, $old_file_name);

        $deleteTesti = $wpdb->query("DELETE FROM $strTbl WHERE id =".$intId);        
    }

    if($deleteTesti)
    {
        $arrMsg = array('msg' => 'Testimonial(s) Deleted.','msgClass' =>'updated');
    }
    if(!empty($arrMsg)){
        return $arrMsg;    
    }
    else{
        return "";
    }
}


/**
* This function is used to upload file to server.
*
* @param string $sInputName  
* @param string $sStorePath         File desintaion to store file with Trailing slash at end
* @param array  $aFiles             $_FILES
* @param array  $aAllowedTypes      Allowed file types to upload
* @param int    $iAllowedMaxSize    Allowed max upload size for individual file
* @param array  $aResize {
    *     Optional. Array of Array of parameters.
    *
    *     @type int     $w Width for resize image
    *     @type int     $h Height for resize image
    *     @type bool    $bCrop True if need to crop to exact size
    *     @type string  $store_at Absolute path to store image afre resizing with Trailing slash at end
    * }
* @param bool   $bIsAmazon          If true then file need to upload on Amazon
* @param bool   $bUploadFrmMob      If file upload from mobile webservice
*
* @return bool|array                This will return false in case on singular file upload fail Orelse array of uploaded file names
*/
function upload_file_on_server($sInputName, $sStorePath , $aFiles, $aAllowedTypes, $iAllowedMaxSize = 100)
{
    if(file_exists($sStorePath) == FALSE) {
        mkdir($sStorePath, 0755, true);

        // Create empty index file to prevent directory index
        file_put_contents($sStorePath."index.html", "<!-- Silence is golden -->");
    }
   
    $max_size = get_max_upload_file_size( $iAllowedMaxSize );
    $aFiles = $aFiles[$sInputName];
    $aValidFiles = array();
    $aSavedFiles = array();

    // Validate for allowed file types & max upload size for individual file or any other upload errors
    // This will return false in case on singular file upload
    if(is_array($aFiles['name'])) {
        $iTotalFiles = count($aFiles['name']);
        for($i = 0; $i < $iTotalFiles; $i++){
            $file_size_in_mb = bytes_to_mb($aFiles['size'][$i]);

            if( !in_array($aFiles['type'][$i], $aAllowedTypes ) || $file_size_in_mb > $max_size || $aFiles['error'][$i] > 0)
                continue;

            $aFile              = array();
            $aFile['name']      = $aFiles['name'][$i];
            $aFile['type']      = $aFiles['type'][$i];
            $aFile['tmp_name']  = $aFiles['tmp_name'][$i];
            $aFile['error']     = $aFiles['error'][$i];
            $aFile['size']      = $aFiles['size'][$i];
            $aValidFiles[]      = $aFile;
        }
    } else {
        $file_size_in_mb = bytes_to_mb( $aFiles['size'] );
        $aFile              = array();
        $aFile['name']      = $aFiles['name'];
        $aFile['type']      = $aFiles['type'];
        $aFile['tmp_name']  = $aFiles['tmp_name'];
        $aFile['error']     = $aFiles['error'];
        $aFile['size']      = $aFiles['size'];
        $aValidFiles[]      = $aFile;
    }

    if(!empty($aValidFiles)) {
        foreach ($aValidFiles as $aValidFile) {
            // Clean the file name to make it safe to save by removing any special characters & whitespaces
            $sFileName = preg_replace('/[^A-Za-z0-9\-._]/', '', $aValidFile['name']);

            // Append timestamp to each file name to make it unique
            $path_parts = pathinfo($sFileName);

            // Shorten file name to 200 character length max
            $path_parts['filename'] = (strlen($path_parts['filename']) > 200) ? substr($path_parts['filename'], 0,200): $path_parts['filename'];

            // Append timestamp
            ##$sFileName = $path_parts['filename'].'_'.time().'.'.$path_parts['extension'];
            $number = mt_rand(10000,999999);
            $sFileName = $path_parts['filename'].$number.'.'.$path_parts['extension'];

            $org_file_path = $sStorePath.$sFileName;
            $bSuccess = @move_uploaded_file($aValidFile['tmp_name'], $org_file_path);

            if($bSuccess) {
                $aSavedFiles[] = $sFileName;
            }    
        }
    }
            
    return $aSavedFiles;          
}

/**
 * Convert bytes to MB
 *
 * @param integer bytes Size in bytes to convert
 * @return int|float
 */
function bytes_to_mb($bytes, $precision = 2) {  
    $kilobyte = 1024;
    $megabyte = $kilobyte * 1024;
    
    return round($bytes / $megabyte, $precision);
}

/**
 * Get maximum file upload size allowed on server in MegaBytes(MB)
 * 
 * @link http://www.kavoir.com/2010/02/php-get-the-file-uploading-limit-max-file-size-allowed-to-upload.html
 *
 * @param integer $iUserSepcificMaxSize User specific size to consider while calculation max size.
 * @return int $max_upload_size Maximum file upload size on server
 */
function get_max_upload_file_size( $iUserSepcificMaxSize = 0 ) {
    $aAllSizes   = array();
    $aAllSizes[] = (int)(ini_get('upload_max_filesize'));
    $aAllSizes[] = (int)(ini_get('post_max_size'));
    $aAllSizes[] = (int)(ini_get('memory_limit'));

    if($iUserSepcificMaxSize > 0)
        $aAllSizes[] = $iUserSepcificMaxSize;

    $max_upload_size = min($aAllSizes);

    return $max_upload_size;
}

function delete_file( $sPath, $sFileName ) {
    if( is_file( $sPath.$sFileName ) ) 
        @unlink( $sPath.$sFileName );
}
add_action('admin_init','update_css');
function update_css(){
    if(isset($_POST['updatecss'])){
        unset($_POST['updatecss']);
        update_option( 'customcss', stripslashes($_POST['customcss']) );

        
        $file = WP_CONTENT_DIR.'/plugins/wp-testimonial-widget/css/swp-custom-style.css';
        
        $current = $_POST['customcss'];
        
        file_put_contents($file, $current);
    }
}
function getCategory(){
    global $wpdb;
    $strTblName = $wpdb->prefix."swp_category";
    $arrCat = $wpdb->get_results( 'SELECT id,category_name FROM '.$strTblName, ARRAY_A );
    return $arrCat;
}

function fnSaveTestimonailOrder(){
    global $wpdb;
    $strTbl = $wpdb->prefix."swp_testimonial";

    $arr = explode("testimonail[]=",$_POST['order']);    
    $arrTemp = array();
    foreach ($arr as  $value) {
        if(!empty($value)){
            $arrTemp[] = rtrim($value,"&");
        }
    }
    foreach ($arrTemp as $key => $value) {
        $wpdb->update($strTbl,array("orders"=>$key+1),array("id"=>$value));
    }
    die;
}
add_action( 'wp_ajax_update-testimonail-order', 'fnSaveTestimonailOrder' );
add_action( 'wp_ajax_nopriv_update-testimonail-order', 'fnSaveTestimonailOrder' );