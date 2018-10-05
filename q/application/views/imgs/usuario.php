<form 
accept-charset="utf-8" method="POST" id="form_img_enid" class="form_img_enid" enctype="multipart/form-data">    <?=input([
    "type"        => "file" ,
    "id"          => 'imagen_img' ,
    "class"       => 'imagen_img' ,
    "name"        => "imagen"
    ])?>          
    <?=input_hidden(["name"=>'q', "value"=>'perfil_usuario'])?>    
    <?=input_hidden([
        "class" =>  'dinamic_img' ,
        "id"    =>  'dinamic_img' ,
        "name"  =>  'dinamic_img' 
    ])?>
    <?=place("separate-enid")?>
    <?=guardar(icon("fa fa-check") , 
    [
        "type"      =>  "submit" ,
        "class"     =>  'btn btn btn-sm guardar_img_enid pull-right' ,
        "id"        =>  'guardar_img' ,
        "style"     =>  'color:white;display: none;'
    ])?>
    <?=place("separate-enid")?>
</form>
<?=place("place_load_img" , ["id"   =>  'place_load_img'])?>
