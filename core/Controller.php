<?php 

abstract class Controller {

    public function render($view, $viewBag=[]){
        $file = "Views/".static::class."/$view";
        $file = str_replace('Controller','',$file);

        if(file_exists($file)){
            extract($viewBag);
            ob_start(); 
            require_once($file);

            $content = ob_get_contents();
            ob_end_clean(); 
            echo $content;

        } else{
            echo '<h1>View not found</h1>';
        }
    }
}
?>