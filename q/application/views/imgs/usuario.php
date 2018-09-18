<form accept-charset="utf-8" 
    method="POST" 
    id="form_img_enid" class="form_img_enid" enctype="multipart/form-data" >      
    <input 
        type="file" 
        id='imagen_img' 
        class='imagen_img' 
        name="imagen"/>    
    <input type='hidden' name='q' value='perfil_usuario'>         
    <input 
        class='dinamic_img' 
        id='dinamic_img' 
        name='dinamic_img' 
        type='hidden'>

    <div class='separate-enid'>
    </div>
    <button 
        type="submit" 
        class='btn btn btn-sm guardar_img_enid pull-right' 
        id='guardar_img' 
        style='color:white;display: none;'>
        <?=icon("fa fa-check")?>
        
    </button>           
    <div class='separate-enid'>
    </div>    
</form>
<center>
    <div class='place_load_img' id='place_load_img'>
    </div>
</center>          