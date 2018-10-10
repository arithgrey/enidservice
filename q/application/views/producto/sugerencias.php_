<?php 
	$table =  width_productos_sugeridos($lista_productos); 
?>
<?php if (count($lista_productos)>0): ?>
	<?=heagin_enid("TAMBIÉN PODRÍA INTERESARTE" , 3 , [] , 1)?>		
<?php endif; ?>
<?=n_row_12()?>
	<div class="productos_sugeridos">
		<div class="row">				
				<div <?=$table["tabla"]?>>
					<?php foreach ($lista_productos as $row):?>							
						<div <?=$table["producto"]?> class='productos_sugerencia' >
							<?=get_td($row)?>		
						</div>
					<?php endforeach; ?>				
				</div>
		</div>
	</div>	
<?end_row()?>

<style type="text/css">
.productos_sugeridos .productos_sugerencia{
	display: inline-table!important;		
}	
  body {
  padding: 1.5em;
  background: #fff;
  background: whitesmoke;
}
.cont {
  width: 100%;
  height: 100%;
}
.cont .product {
  width: 610px;
  height: 250px;
  display: flex;
  margin: 1em 0;
  border-radius: 5px;
  overflow: hidden;
  cursor: pointer;
  box-shadow: 0px 0px 21px 3px rgba(0, 0, 0, 0.15);
  transition: all .1s ease-in-out;
}
.cont .product:hover {
  box-shadow: 0px 0px 21px 3px rgba(0, 0, 0, 0.11);
}
.cont .product .img-cont {
  flex: 2;
}
.cont .product .img-cont img {
  object-fit: cover;
  width: 100%;
  height: 100%;
}
.cont .product .product-info {
  background: #fff;
  flex: 3;
}
.cont .product .product-info .product-content {
  padding: .2em 0 .2em 1em;
}
.cont .product .product-info .product-content h1 {
  
}
.cont .product .product-info .product-content p {
  color: #636363;
  font-size: .9em;
  
  width: 90%;
}
.cont .product .product-info .product-content ul li {
  color: #636363;
  font-size: .9em;
  margin-left: 0;
}
.cont .product .product-info .product-content .buttons {
  padding-top: .4em;
}
.cont .product .product-info .product-content .buttons .button {
  text-decoration: none;
  color: #5e5e5e;
  
  padding: .3em .65em;
  border-radius: 2.3px;
  transition: all .1s ease-in-out;
}
.cont .product .product-info .product-content .buttons .add {
  border: 1px #5e5e5e solid;
}
.cont .product .product-info .product-content .buttons .add:hover {
  border-color: #6997b6;
  color: #6997b6;
}
.cont .product .product-info .product-content .buttons .buy {
  border: 1px #5e5e5e solid;
}
.cont .product .product-info .product-content .buttons .buy:hover {
  border-color: #6997b6;
  color: #6997b6;
}
.cont .product .product-info .product-content .buttons #price {
  margin-left: 4em;
  color: #5e5e5e;
  
  border: 1px solid rgba(137, 137, 137, 0.2);
  background: rgba(137, 137, 137, 0.04);
}
</style>
<div class="cont">  
  <div class="product">
    <div class="img-cont">
      <img src="https://images.unsplash.com/photo-1491553895911-0055eca6402d?dpr=1&auto=compress,format&fit=crop&w=1400&h=&q=80&cs=tinysrgb&crop=">
    </div>
    <div class="product-info">
      <div class="product-content">
        <h1>Nike Airmax</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit ariatur</p>
        <ul>
          <li>Lorem ipsum dolor sit ametconsectetu.</li>
          <li>adipisicing elit dlanditiis quis ip.</li>
          <li>lorem sde glanditiis dars fao.</li>
        </ul>
        <div class="buttons">
          <a class="button buy" href="#">Buy</a>
          <a class="button add" href="#">Add to Cart</a>
          <span class="button" id="price">$59,99</span>
        </div>
      </div>
    </div>
  </div>
  
  <div class="product">
    <div class="img-cont">
      <img src="https://images.unsplash.com/photo-1434493907317-a46b5bbe7834?dpr=1&auto=compress,format&fit=crop&w=1500&h=&q=80&cs=tinysrgb&crop=">
    </div>
    <div class="product-info">
      <div class="product-content">
        <h1>Apple Watch 3</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit ariatur</p>
        <ul>
          <li>Lorem ipsum dolor sit ametconsectetu.</li>
          <li>adipisicing elit dlanditiis quis ip.</li>
          <li>lorem sde glanditiis dars fao.</li>
        </ul>
        <div class="buttons">
          <a class="button buy" href="#">Buy</a>
          <a class="button add" href="#">Add to Cart</a>
          <span class="button" id="price">$120,99</span>
        </div>
      </div>
    </div>
  </div>
  
</div>
