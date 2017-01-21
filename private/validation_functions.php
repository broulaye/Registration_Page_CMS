<?php

  // is_blank('abcd')
  function is_blank($value='') {
    return !isset($value) || trim($value) == '';
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    $length = strlen($value);
    if(isset($options['max']) && ($length > $options['max'])) {
      return false;
    } elseif(isset($options['min']) && ($length < $options['min'])) {
      return false;
    } elseif(isset($options['exact']) && ($length != $options['exact'])) {
      return false;
    } else {
      return true;
    }
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
  }

  // sanitize email
  function sanitize_email($value) {
    return filter_var($value, FILTER_SANITIZE_EMAIL);
  }

  //check is first and last name valid
  function is_valid_name($value) {
    return preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $value);
  }

  //check if username
  function is_valid_username($value) {
    return preg_match('/\A[A-Za-z0-9\_]+\Z/', $value);
  }


?>
