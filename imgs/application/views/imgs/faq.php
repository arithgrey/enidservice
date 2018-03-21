<form accept-charset="utf-8" method="POST" id="form_img_enid_faq" class="form_img_enid_faq" enctype="multipart/form-data" >      
    <input type="file" id='imagen_img_faq' class='imagen_img_faq' name="imagen"/>
    <input type='hidden' name='q' value='faq'>         
    <input class='dinamic_img_faq' id='dinamic_img_faq' name='dinamic_img_faq' 
    type='hidden' value="<?=$id_faq;?>">
    <div class='separate-enid'>
    </div>
    <button type="submit" class='btn btn btn-sm guardar_img_enid pull-right' id='guardar_img_faq' 
            style='color:white;'>
            <i class='fa fa-check'>
            </i>
    </button>           
    <div class='separate-enid'>
    </div>
    <center>    
        <div class='lista_imagenes_faq' id='lista_imagenes_faq'>
        </div>          
    </center> 
    
</form>
<center>
    <div class='place_load_img_faq'>
    </div>
</center>          