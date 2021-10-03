<?php 
class customfunctions{

    public function slug($string){
        $slug = preg_replace('/[^a-z0-9]+/i', '-', $string);
        return $slug;
    }


    public function check_empty($values){
    	$length = count($values);
		for ($i=0; $i < $length; $i++) {
			if (empty($values[$i])) {
				echo "Please fill required fields";
				exit;
			}
		}
    }




}

$functions = new customfunctions();


 ?>