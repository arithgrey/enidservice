<form accept-charset="utf-8" 
method="POST" id="form_img_enid" class="form_img_enid" enctype="multipart/form-data" >      
    <?=input([
        "type"      =>"file" ,
        "id"        =>'imagen_img' ,
        "class"     =>'imagen_img' ,
        "name"      =>"imagen"
    ])?>
    <?=input_hidden(["name" =>'q', "value"   => $q])?>
    <?=input_hidden(["name" =>$q2, "value"   => $q3])?>
    <?=input_hidden(["class"=>'dinamic_img', "id"=>'dinamic_img' ,"name"=>'dinamic_img' ])?>
    <?=place("separate-enid")?>
    <?=place("place_load_img" , ["id"   =>  'place_load_img'])?>
    
    <?=guardar("AGREGAR IMAGEN" . icon("fa fa-check") ,
        "class" =>  'btn guardar_img_enid ' ,
        "id"    =>  'guardar_img' 
)?>    
</form>
<?=place("info_form")?>