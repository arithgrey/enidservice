<span class='blue_enid_background white ' style="padding: 4px;"> 
	Tus agendados
</span>
<div class="main_section">
   <div>
      <div class="chat_container">
         <div class="col-sm-12 chat_sidebar">
    	 <div class="row">            
            <div class="member_list">
               <ul class="list-unstyled">
<?php  
	$l ="";
	$estilos_extra_header_table  =  "style='font-size:.8em;background: #0030ff;color: white;' "; 
	foreach ($info_agendados as $row) {			
		
		$id_persona =  $row["id_persona"];
		$nombre =  $row["nombre"];
		$a_paterno =  $row["a_paterno"];
		$a_materno =  $row["a_materno"];			
		$tel = $row["tel"];
		$nombre = $nombre . " " . $a_paterno . " " . $a_materno; 						
		$fecha_agenda =  $row["fecha_agenda"];		 
		$hora_agenda =  $row["hora_agenda"];

		$id_usuario_enid_service =  $row["id_usuario_enid_service"];
		$extra_persona =  "<i class='info_persona_agendados fa fa-history ' 
								id='".$id_persona."'>
							</i>";

		$extra_agendar =  "<i 
							href='#tab_agendar_llamada' 
		    				data-toggle='tab' 
							class='btn_agendar_llamada fa fa-phone-square ' 
							id='".$id_persona."'>
							</i>";

		$img = "../imgs/index.php/enid/imagen_usuario/".$id_usuario_enid_service;			
		$id_llamada  = $row["id_llamada"];
		
		?>
    <div  
      onclick="muestra_agenda_persona('<?=$id_persona?>' ,'<?=$id_llamada?>')">
		<li class="left clearfix " >
                     <span class="chat-img pull-left">
                     <img 
	                     src="<?=$img?>" 
	                     class="img-circle "
                       id="<?=$id_persona?>"

	                     onerror="this.src='../img_tema/user/user.png'">
                     </span>
                     <div class="chat-body clearfix " >
                        <div class="header_sec">
                           <strong class="primary-font ">
                           		<?=$nombre?>                           
                           </strong> 
                           <strong class="pull-right ">
	                           	<span style="font-size: .8em;">

	                           		<i class="fa fa-phone"></i>
	                           		<?=$fecha_agenda?> 
	                           		<br>
	                           		<?=$hora_agenda?>
	                           	</span>
                       		</strong>
                        </div>
                        <div class="contact_sec">
                           <strong class="primary-font">
                           	<?=$tel?>
                           </strong>                            
                        </div>
                     </div>
                  </li>
                  </div>                  
		<?php 
		
	}
 	
?>


 				</ul>
            </div>
        	</div>
         </div>         
   </div>
</div>


<style type="text/css">
	 #custom-search-input {
  background: #e8e6e7 none repeat scroll 0 0;
  margin: 0;
  padding: 10px;
}
   #custom-search-input .search-query {
   background: #fff none repeat scroll 0 0 !important;
   border-radius: 4px;
   height: 33px;
   margin-bottom: 0;
   padding-left: 7px;
   padding-right: 7px;
   }
   #custom-search-input button {
   background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
   border: 0 none;
   border-radius: 3px;
   color: #666666;
   left: auto;
   margin-bottom: 0;
   margin-top: 7px;
   padding: 2px 5px;
   position: absolute;
   right: 0;
   z-index: 9999;
   }
   .search-query:focus + button {
   z-index: 3;   
   }
   .all_conversation button {
   background: #f5f3f3 none repeat scroll 0 0;
   border: 1px solid #dddddd;
   height: 38px;
   text-align: left;
   width: 100%;
   }
   .all_conversation i {
   background: #e9e7e8 none repeat scroll 0 0;
   border-radius: 100px;
   color: #636363;
   font-size: 17px;
   height: 30px;
   line-height: 30px;
   text-align: center;
   width: 30px;
   }
   .all_conversation .caret {
   bottom: 0;
   margin: auto;
   position: absolute;
   right: 15px;
   top: 0;
   }
   .all_conversation .dropdown-menu {
   background: #f5f3f3 none repeat scroll 0 0;
   border-radius: 0;
   margin-top: 0;
   padding: 0;
   width: 100%;
   }
   .all_conversation ul li {
   border-bottom: 1px solid #dddddd;
   line-height: normal;
   width: 100%;
   }
   .all_conversation ul li a:hover {
   background: #dddddd none repeat scroll 0 0;
   color:#333;
   }
   .all_conversation ul li a {
  color: #333;
  line-height: 30px;
  padding: 3px 20px;
}
   .member_list .chat-body {
   margin-left: 47px;
   margin-top: 0;
   }
   .top_nav {
   overflow: visible;
   }
   .member_list .contact_sec {
   margin-top: 3px;
   }
   .member_list li {
   padding: 6px;
   }
   .member_list ul {
   border: 1px solid #dddddd;
   }
   .chat-img img {
   height: 34px;
   width: 34px;
   }
   .member_list li {
   border-bottom: 1px solid #dddddd;
   padding: 6px;
   }
   .member_list li:last-child {
   border-bottom:none;
   }
   .member_list {
   height: 380px;
   overflow-x: hidden;
   overflow-y: auto;
   }
   .sub_menu_ {
  background: #e8e6e7 none repeat scroll 0 0;
  left: 100%;
  max-width: 233px;
  position: absolute;
  width: 100%;
}
.sub_menu_ {
  background: #f5f3f3 none repeat scroll 0 0;
  border: 1px solid rgba(0, 0, 0, 0.15);
  display: none;
  left: 100%;
  margin-left: 0;
  max-width: 233px;
  position: absolute;
  top: 0;
  width: 100%;
}
.all_conversation ul li:hover .sub_menu_ {
  display: block;
}
.new_message_head button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
}
.new_message_head {
  background: #f5f3f3 none repeat scroll 0 0;
  float: left;
  font-size: 13px;
  font-weight: 600;
  padding: 18px 10px;
  width: 100%;
}
.message_section {
  border: 1px solid #dddddd;
}
.chat_area {
  float: left;
  height: 300px;
  overflow-x: hidden;
  overflow-y: auto;
  width: 100%;
}
.chat_area li {
  padding: 14px 14px 0;
}
.chat_area li .chat-img1 img {
  height: 40px;
  width: 40px;
}
.chat_area .chat-body1 {
  margin-left: 50px;
}
.chat-body1 p {
  background: #fbf9fa none repeat scroll 0 0;
  padding: 10px;
}
.chat_area .admin_chat .chat-body1 {
  margin-left: 0;
  margin-right: 50px;
}
.chat_area li:last-child {
  padding-bottom: 10px;
}
.message_write {
  background: #f5f3f3 none repeat scroll 0 0;
  float: left;
  padding: 15px;
  width: 100%;
}

.message_write textarea.form-control {
  height: 70px;
  padding: 10px;
}
.chat_bottom {
  float: left;
  margin-top: 13px;
  width: 100%;
}
.upload_btn {
  color: #777777;
}
.sub_menu_ > li a, .sub_menu_ > li {
  float: left;
  width:100%;
}
.member_list li:hover {
  background: #428bca none repeat scroll 0 0;
  color: #fff;
  cursor:pointer;
}
</style>