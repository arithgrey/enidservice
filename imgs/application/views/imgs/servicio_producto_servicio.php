<form accept-charset="utf-8" 
    method="POST" 
    id="form_img_enid" class="form_img_enid" enctype="multipart/form-data" >      
    <input 
        type="file" 
        id='imagen_img' 
        class='imagen_img' 
        name="imagen"/>    
    <input type='hidden' name='q' value='<?=$q?>'>         
    <input type='hidden' name='<?=$q2?>' value='<?=$q3?>'>   
    <input 
        class='dinamic_img' 
        id='dinamic_img' 
        name='dinamic_img' 
        type='hidden'>

    <div class='separate-enid'>
    </div>
    
    
    <?=n_row_12()?>
        <div style="margin-top: 20px;">
            <center>
                <div class='place_load_img' id='place_load_img'>
                </div>
            </center> 
        </div>         
    <?=end_row()?>

    <?=n_row_12()?>
        <button 
            type="submit" 
            class='btn btn btn-sm guardar_img_enid pull-right' 
            id='guardar_img' 
            style='color:white;display: none;'>
            AGREGAR IMAGEN
            <i class='fa fa-check'>
            </i>
        </button>           
    <?=end_row()?>
</form>
