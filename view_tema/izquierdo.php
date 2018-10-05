<?=anchor_enid( 
	img(
	["src" 	=> '../img_tema/enid_service_logo.jpg' , 'width' => '100%'] ) ,  
	['href' => "../contact/#envio_msj" ]
);?>
<?=input_hidden( ["class"=>"in_session", "value"=>$in_session])?>
<div <?=add_attributes(["style"=>"background: #f2f2f2;padding: 10px;"])?> >
    <?=heading_enid("¿TIENES ALGUNA DUDA?" ,3)?>
    <?=anchor_enid("ENVIA TU MENSAJE", 
        [	
        	"href"	=>	"../contact/#envio_msj" ,
            'style'	=>	'color:black!important;text-decoration:underline;'
        ])?>
</div>