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
        <div >
            <center>
                <div class='place_load_img' id='place_load_img'>
                </div>
            </center> 
        </div>         
    <?=end_row()?>

    <?=n_row_12()?>
        <button 
            type="submit" 
            class='btn guardar_img_enid ' 
            id='guardar_img' 
            style='color:white;display: none;width: 100%;background: #00030B !important;
            width: 100% !important;
            background: black !important;
            padding: 5px;
            color: white;
            margin-bottom: 50px;'>
            AGREGAR IMAGEN
            <?=icon("fa fa-check")?>
            
        </button>           
    <?=end_row()?>
</form>
