<?php
class Rinter{
    
    
   //get all tags inside cpecific tag , return array of all elements
function element_set($element_name, $xml, $content_only = false) {
    if ($xml == false) {
        return false;
    }
    $found = preg_match_all('#<'.$element_name.'(?:\s+[^>]+)?>' .
            '(.*?)</'.$element_name.'>#s',$xml, $matches, PREG_PATTERN_ORDER);
    if ($found != false) {
        if ($content_only) {
            return $matches[1];  //ignore the enlosing tags
        } else {
            return $matches[0];  //return the full pattern match
        }
    }
    // No match found: return false.
    return false;
} 
    
    
    

//get value of specific tag
function value_in($element_name, $xml, $content_only = true) {
    if ($xml == false) {
        return false;
    }
    $found = preg_match('#<'.$element_name.'(?:\s+[^>]+)?>(.*?)'.
            '</'.$element_name.'>#s', $xml, $matches);
    if ($found != false) {
        if ($content_only) {
            return $matches[1];  //ignore the enclosing tags
        } else {
            return $matches[0];  //return the full pattern match
        }
    }
    // No match found: return false.
    return false;
}
    
    
   function element_attributes($element_name, $xml) {
    if ($xml == false) {
        return false;
    }
    // Grab the string of attributes inside an element tag.
    $found = preg_match('#<'.$element_name.
            '\s+([^>]+(?:"|\'))\s?/?>#',
            $xml, $matches);
    if ($found == 1) {
        $attribute_array = array();
        $attribute_string = $matches[1];
        // Match attribute-name attribute-value pairs.
        $found = preg_match_all(
                '#([^\s=]+)\s*=\s*(\'[^<\']*\'|"[^<"]*")#',
                $attribute_string, $matches, PREG_SET_ORDER);
        if ($found != 0) {
            // Create an associative array that matches attribute
            // names to attribute values.
            foreach ($matches as $attribute) {
                $attribute_array[$attribute[1]] =
                        substr($attribute[2], 1, -1);
            }
            return $attribute_array;
        }
    }
    // Attributes either weren't found, or couldn't be extracted
    // by the regular expression.
    return false;
} 
    
    
}
?>
