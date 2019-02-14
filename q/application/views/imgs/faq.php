<form accept-charset="utf-8" 
method="POST" id="form_img_enid_faq" class="form_img_enid_faq" enctype="multipart/form-data" >      
    
    <?=input(["type"=>"file",
             "id"=>'imagen_img_faq',
             "class"=>'imagen_img_faq',
             "name"=>"imagen"])?>
    <?=input_hidden([ "name"=>'q' , "value"=>'faq'])?>
    <?=input_hidden(
        [   "class"     =>  'dinamic_img_faq',
            "id"        =>  'dinamic_img_faq',
            "name"      =>  'dinamic_img_faq',
            "value"     =>   $id_faq]
    )?>

    <?=place("separate-enid")?>
    <?=guardar(icon("fa fa-check") , 
    [
        "type"        =>  "submit", 
        "class"       =>  'btn btn btn-sm guardar_img_enid pull-right', 
        "id"          =>  'guardar_img_faq' ,
        "style"       =>  'color:white;'
    ])?>
    
    <?=place("separate-enid")?>
    <center>    
        <?=place("lista_imagenes_faq" ,  ["id"=>'lista_imagenes_faq'])?>        
    </center> 
</form>
<?=place("place_load_img_faq")?>    
