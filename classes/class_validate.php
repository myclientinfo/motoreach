<?php

/**
 * 
 * @package auction
 * 
 * These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
 * and a templating system like Smarty. The database abstraction layer AdoDB is used.
 * @version $Id: class_validate.php,v 1.9 2005/07/28 04:02:33 woostachris Exp $
 * @copyright 2005
 */

/**
 * Copyright (C) 2005 Vickie Comrie, Nicolas Connault, Christopher Vance
 * 
 * Vickie Comrie: <vrcomrie@myway.com>
 * Nicolas Connault: <nicou@sweetpeadesigns.com.au>
 * Christopher Vance: <christopher.vance@gmail.com>
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

/**
 * Validate
 * 
* Tools for validating user input
 * 
 * @package auction
 * @author Nicolas Connault, Christopher Vance 
* @copyright Copyright (c) 2005
 * @version $Id: class_validate.php,v 1.9 2005/07/28 04:02:33 woostachris Exp $
 * @access public 
*/
class Validate {
    /**
     * 
     * @var string _emailpattern Regular Expression matching a correctly formatted email address
     */
    var $_email_pattern;
    /**
     * 
     * @var string _phonepattern Regular Expression matching a correctly formatted phone number
     */
    var $_phone_pattern;
    /**
     * 
     * @var string _zippattern Regular Expression matching a correctly formatted zip number
     */
    var $_zip_pattern;
    /**
     * 
     * @var string _passwordpattern Regular Expression matching a correctly formatted password
     */
    var $_password_pattern;
    /**
     * 
     * @var string _pricepattern Regular Expression matching a correctly formatted price
    */
    var $_price_pattern;
    /**
     * 
     * @var string _max_height Maximum image height
     */
    var $_max_height;
    /**
     * 
     * @var string _max_width Maximum image width
     */
    var $_max_width;
    /**
     * 
     * @var _constant_pattern Constant message name pattern
     */
    var $_constant_pattern;

    /**
     * Validate::Validate()
     * 
     * Constructor Function
     */
    function Validate() {
        $this->_email_pattern = "^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$";
        $this->_phone_pattern = "(^(.*)[0-9]{3})(.*)([0-9]{3})(.*)([0-9]{4}$)";
        $this->_zip_pattern = "[0-9]{4,5}";
        $this->_password_pattern = "^[a-zA-Z0-9]{6,15}$";
        $this->_price_pattern = "^[0-9]{1,10}(\.[0-9]{2})?$";
        $this->_constant_pattern = "^[A-Z]+[A-Z \_ 0-9]+$"; // Starts with upcase letter, then contains only upcase letters, numbers and _
        $this->_max_height = 500;
        $this->_max_width = 300; 
        // For ereg() function. Finds pattern inside the string, but has no way of distinguishing beginning from end
        // $this->emailpattern = "([_a-zA-Z0-9-]+)\+?([_a-zA-Z0-9-]+)@([a-zA-Z0-9-]+(.[a-zA-Z0-9-]+)*)";
    } 

    /**
     * Checks an email address.
     * 
     * @param string $string 
     * @return boolean TRUE if successful, array with error message and error field if error occurs
     */
    function _checkEmail($email) {
        if (!strstr($email, '@')) {
            return array("message" => AUCTION_INVALID_EMAIL, "field" => "email");
        } else {
            return true;
        } 
    } 

    /**
     * Checks a password
     * 
     * @param string $string 
     * @return boolean TRUE if successful, array with error message and error field if error occurs
     */
    function _checkPassword($password) {
		return true;
        if (!eregi($this->_password_pattern, $password)) {
            return array("message" => AUCTION_INVALID_PASSWORD, "field" => "password");
        } else {
            return true;
        } 
    } 

    /**
     * Checks a phone number
     * 
     * @param string $string 
     * @return boolean TRUE if successful, array with error message and error field if error occurs
     */
    function _checkPhone($phone) {
		return true;
        if (!eregi($this->_phone_pattern, $phone)) {
            return array("message" => AUCTION_INVALID_PHONE, "field" => "phone");
        } else {
            return true;
        } 
    } 

    /**
     * Checks a zip code
     * 
     * @param string $string 
     * @return boolean TRUE if successful, array with error message and error field if error occurs
     */
    function _checkZip($zip) {
		return true;
        if (!eregi($this->_zip_pattern, $zip)) {
            return array("message" => AUCTION_INVALID_ZIP, "field" => "zip");
        } else {
            return true;
        } 
    } 

    /**
     * Checks an item description for length.
     * 
     * @param string $string 
     * @return boolean TRUE if successful, array with error message and error field if error occurs
     */
    function _checkDescription($description) {
        // Limit the size of the description field to 50,000 Bytes (that's BIG!!!)
        if (strlen($description) > 50000) {
            return array("message" => AUCTION_INVALID_DESCRIPTION, "field" => "description");
        } else {
            return true;
        } 
    } 

    /**
     * Checks a starting price.
     * 
     * @param  $startingprice 
     * @return boolean TRUE if successful, array with error message and error field if error occurs
     */
    function _checkStartprice($startprice) {
        if ($startprice == "" || is_null($startprice)) {
            return array("message" => 'AUCTION_ALL_FIELDS_REQUIRED', "field" => "startprice");
        } else {
            return true;
        } 
    } 

    /**
     * Checks an increment value for an item.
     * 
     * @param  $increment 
     * @return boolean TRUE if successful, array with error message and error field if error occurs
     */
    function _checkIncrement($increment) {
        if ($increment == "") {
            return array("message" => AUCTION_ALL_FIELDS_REQUIRED, "field" => "increment");
        } elseif ($increment < 1) {
            return array("message" => AUCTION_INVALID_INCREMENT, "field" => "increment");
        } else {
            return true;
        } 
    } 

    /**
     * Checks a constant value.
     * 
     * @param  $constant 
     * @return boolean TRUE if successful, array with error message and error field if error occurs
     */
    function _checkConstant($constant) {
		return true;
        if (!eregi($this->_constant_pattern, $constant)) {
            return array("message" => ADMIN_INVALID_CONSTANT, "field" => "constant");
        } else {
            return true;
        } 
    } 

    /**
     * Checks a reserve price.
     * 
     * @param  $reserve 
     * @param  $startingprice 
     * @return boolean TRUE if successful, array with error message and error field if error occurs
     */

   function _checkReserve($reserve, $startprice) {
	   return true;
        if ($reserve == "") {
            return array("message" => AUCTION_ALL_FIELDS_REQUIRED, "field" => "reserve");
        } elseif (!eregi($this->_price_pattern, $reserve)) {
            return array("message" => AUCTION_INVALID_PRICE, "field" => "reserve");
        } elseif ($reserve <= $startprice) {
            return array("message" => AUCTION_INVALID_RESERVE, "field" => "reserve");
        } else {
            return true;
        } 
    } 

    /**
     * Checks a category ID.
     * 
     * @param  $id 
     * @return boolean TRUE if successful, array with error message and error field if error occurs
     */
    function _checkCategoryID($ID) {
        if ($ID == "") {
            return array("message" => AUCTION_ALL_FIELDS_REQUIRED, "field" => "categoryID");
        } 

        $myDB = &ADONewConnection(DSN);
        $query = "SELECT * FROM auction_categories WHERE ID = $ID";
        $rs = &$myDB->Execute($query);
        if (!$rs || $rs->RecordCount() < 1) {
            // If the record count is less than 1, then no rows representing
            // categories were selected. Return an error in this case.
            $myDB->Close();
            return array("message" => AUCTION_BAD_CATEGORY, "field" => "categoryID");
        } else {
            // RecordSet exists, so it contains the record with the ID passed into this function
            $myDB->Close();
            return true;
        } 
    } 

    /**
     * Check an entire form data for errors in entry
     * 
     * @param  $fields 
     * @return boolean TRUE if successful, array with error message and error field if error occurs
     */
    function checkForm($fields) {
    	
		// First check that the password and confirmpassword match
        if (isset($fields['password']) and isset($fields['confirmpassword'])) {
            if ($fields['password'] != $fields['confirmpassword']) {
                return array("message" => AUCTION_NONMATCHING_PASSWORDS, "field" => "password");
            } 
        } 

        // Then, if the form is an update form and the password fields are empty, unset them
        if ($fields['formdata'] == "update" AND $fields['password'] == '' AND $fields['confirmpassword'] == '') {
            unset($fields['password']);
            unset($fields['confirmpassword']);
        }
		
		foreach($fields as $k => $v) {
            $result = true; 
            // If there is no method defined for this field, skip the validation
            if (method_exists($this, "_check" . ucfirst($k))) {
                // Each method outputs an error message if the input is invalid
                // The variable $reserve must be checked against $startingprice
                if ($k == "reserve" AND $fields['formdata'] != "update") {
                    $result = $this-> {
                        "_check" . ucfirst($k)} 
                    ($v, $fields['startprice']);
                } elseif ($k != "reserve") {
                    $result = $this-> {
                        "_check" . ucfirst($k)} 
                    ($v);
                } 
            } elseif (($fields['formdata'] == "register" OR $fields['formdata'] == "update") && $v == "") {
                return true;
            } elseif ($fields['formdata'] == "submission" && $v == "" && $k != "reserve") {
                return true;
            } 
            if ($result !== true) {
                return $result;
            } 
        } 
        
		return true;
    } 

    /**
     * Using the given alias and password, retrieves a user from the database. This object's attributes will be updated
     * 
     * @param string $alias 
     * @param string $password 
     * @return array "fields" if user was successfully retrieved, string error message if an error occurred.
     */
    function checkUser($alias, $password, $type = "user") {
        // Check that both fields have a value first
        if ($alias == "" || $password == "") {
            return array("message" => AUCTION_ALL_FIELDS_REQUIRED, "field" => "");
        } 
        $myDB = &ADONewConnection(DSN);
		
		
		if ($type == "user") {
            $querypass = 'SELECT u.*, g.group_name, g.id as group_id, t.type FROM auction_users AS u 
					LEFT JOIN groups AS g ON u.group_id = g.id 
					LEFT JOIN user_types AS t ON t.id = u.user_type_id
					WHERE email = "'.$alias.'" AND password = "' . MD5($password) . '"';
        } elseif ($type == "admin") {
            $querypass = "SELECT * FROM admin_users WHERE alias = '$alias' AND password = '" . MD5($password) . "'";
        } 
        $rspass = &$myDB->Execute($querypass);
        if ($rspass->RecordCount() == 1) {
            $myDB->Close();
            if ($type == "user") {
                return $rspass->fields;
            } elseif ($type == "admin") {
                return true;
            } 
        } else {
            $myDB->Close();
            return array("message" => 'AUCTION_WRONG_PASSWORD', "field" => "password");
        } 
        
    } 

    /**
     * Checks that the file is of the correct size and is not duplicated
     * 
     * @param  $file Image file
     * @return TRUE if OK, error message otherwise
     */
    function checkImageFile($file) {
        if ($file['tmp_name'] == "") {
            return array("message" => AUCTION_ALL_FIELDS_REQUIRED, "field" => "image");
        } elseif (!is_uploaded_file($file['tmp_name'])) {
            switch ($file['error']) {
            case 1:
                return array("message" => AUCTION_FILE_TOO_LARGE, "field" => "image");
            case 2:
                return array("message" => AUCTION_FILE_TOO_LARGE, "field" => "image");
            case 3:
                return array("message" => AUCTION_UPLOAD_PARTIAL, "field" => "image");
            case 4:
                return array("message" => AUCTION_UPLOAD_FAILURE, "field" => "image");
            } 
        } elseif (file_exists('images/' . $file['name']) && md5_file('images/' . $file['name']) != md5_file($file['tmp_name'])) {
            return array("message" => "duplicate" , "field" => "image");
        } elseif ($file['size'] > 50000) {
            return array("message" => AUCTION_FILE_TOO_LARGE, "field" => "image");
        } else {
            return true;
        } 
    } 

    /**
     * This method will resize an image if it exceeds the predetermined maximum height and/or width
     * 
     * @param  $file A string pointing to the image file
     * @return true if image is in correct dimensions, error message if not
     */
    function checkImageDimensions($file) {
        $image_info = getimagesize($file); 
        // Get image type (1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP)
        $types_array = array(1 => "gif", 2 => "jpg", 3 => "png", 4 => "swf", 5 => "psd", 6 => "bmp");
        $image_type = $types_array[$image_info[2]]; 
        // Get image dimensions
        $width = $image_info[0];
        $height = $image_info[1];

        $shortfile = substr($file, 0, -4);
        $dst_image_file = "$shortfile.$image_type.temp";
        $new_image_file = "$shortfile.$image_type";
        switch ($image_type) {
        case "jpg":
            $image_handle = imagecreatefromjpeg($file);
            break;
        case "gif":
            break;
        case "png":
            $image_handle = imagecreatefrompng($file);
            break;
        case "bmp":
            $image_handle = imagecreatefromwbmp($file);
            break;
        default:
            return array("message" => AUCTION_IMAGE_TYPE_UNSUPPORTED, "field" => "image");
        } 

        if ($width > $this->_max_width) {
            // Create new image
            $proportion = $this->_max_width / $width;
            $newimage = imagecreatetruecolor($this->_max_width, $height * $proportion);
            switch ($image_type) {
            case "jpg":
                imagejpeg($newimage, $dst_image_file);
                $dst_img_handle = imagecreatefromjpeg($dst_image_file);
                break;
            case "gif":
                return array("message" => AUCTION_GIF_RESIZE_FAILURE, "field" => "image");
            case "png":
                imagepng($newimage, $dst_image_file);
                $dst_img_handle = imagecreatefrompng($dst_image_file);
                break;
            case "bmp":
                imagewbmp($newimage, $dst_image_file);
                $dst_img_handle = imagecreatefromwbmp($dst_image_file);
                break;
            default:
                break;
            }
            // Copy resized image onto new file
            imagecopyresampled($dst_img_handle, $image_handle, 0, 0, 0, 0, $this->_max_width, $height * $proportion, $width, $height);
            switch ($image_type) {
            case "jpg":
                imagejpeg($dst_img_handle, $dst_image_file);
                break;
            case "png":
                imagepng($dst_img_handle, $dst_image_file);
                break;
            case "bmp":
                imagewbmp($dst_img_handle, $dst_image_file);
                break;
            default:
                break;
            } 
            // Delete previous image file and rename new image file
            unlink($file);
            rename($dst_image_file, $new_image_file);
            return $new_image_file;
        } elseif ($height > $this->_max_height) {
            // Create new image
            $proportion = $this->_max_height / $height;
            $newimage = imagecreatetruecolor($this->_max_width, $height * $proportion);
            switch ($image_type) {
            case "jpg":
                imagejpeg($newimage, $dst_image_file);
                $dst_img_handle = imagecreatefromjpeg($dst_image_file);
                break;
            case "gif":
                return array("message" => AUCTION_GIF_RESIZE_FAILURE, "field" => "image");
            case "png":
                imagepng($newimage, $dst_image_file);
                $dst_img_handle = imagecreatefrompng($dst_image_file);
                break;
            case "bmp":
                imagewbmp($newimage, $dst_image_file);
                $dst_img_handle = imagecreatefromwbmp($dst_image_file);
                break;
            default:
                break;
            } 
            // Copy resized image onto new file
            imagecopyresampled($dst_img_handle, $image_handle, $width * $proportion, $this->_max_height, $width, $height);
            switch ($image_type) {
            case "jpg":
                imagejpeg($dst_img_handle, $dst_image_file);
                break;
            case "png":
                imagepng($dst_img_handle, $dst_image_file);
                break;
            case "bmp":
                imagewbmp($dst_img_handle, $dst_image_file);
                break;
            default:
                break;
            } 
            // Delete previous image file and rename new image file
            unlink($file);
            rename($dst_image_file, $new_image_file);
            return $new_image_file;
        } else {
            return $file;
       } 
    } 
} 

?>