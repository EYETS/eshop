<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* @author     Ashraf M Kaabi
* @name       Advance Linux Exec
*/
class Exec {
    /**
     * Run Application in background
     *
     * @param     unknown_type $Command
     * @param     unknown_type $Priority
     * @return     PID
     */
    public function background($Command, $Priority = 0){
       if($Priority)
           $PID = shell_exec("nohup nice -n $Priority $Command > /dev/null & echo $!");
       else
           $PID = shell_exec("nohup $Command > /dev/null & echo $!");
       return($PID);
   }
   /**
    * Check if the Application running !
    *
    * @param     unknown_type $PID
    * @return     boolen
    */
   public function is_running($PID){
       exec("ps $PID", $ProcessState);
       return(count($ProcessState) >= 2);
   }
   /**
    * Kill Application PID
    *
    * @param  unknown_type $PID
    * @return boolen
    */
   public function kill($PID){
       if($this->is_running($PID)){
           exec("kill -KILL -s SIGTERM $PID");
           return true;
       }else return false;
   }
};
?>