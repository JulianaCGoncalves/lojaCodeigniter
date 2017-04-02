<?php
echo form_open(base_url('carrinho/atualizar'));
$contador=1;
foreach($this->cart->contents() as $item){
	echo form_hidden($contador.'[rowid]'.$item['rowid']).
	"<div class='row linha-carrinho'>".
	"<div class='col-md-1' texto-direita>".anchor(base_url('carrinho/remover/'.$item['rowid']),"Remover")."</div>".
	"<div class='col-md-2'>".img(array('src'=>$item['foto'],'class'=>'miniatura'))."</div>".
	"<div class='col-md-3'>".anchor($item['url'],$item['name'])."</div></a>".
	"<div class='col-md-2'>".form_input(array('name'=>$contador.'[qty]','value'=>$item['qty']))."</div>".
	"<div class='col-md-2 texto-direita'>".reais($item['price'])."</div>".
	"<div class='col-md-2 texto_direita'>".reais($item['subtotal'])."</div>".
	"</div>";
	$contador++;
}
echo br()."<div class='row'>".
"<div class='col-md-8'>".form_submit('btnAtualizar','Atualizar quantidades')."</div>".
"<div class='col-md-2' texto-direita> Total itens: </div>".
"<div class='col-md-2' texto-direita>" .reais($this->cart->total())."</div>".
"</div>".
form_close();
if ($frete){
	echo"<div class='row'>".
	"<div class='col-md-8'></div>".
	"<div class='col-md-2' texto-direita>Frete:</div>".
	"<div class='col-md-2' texto-direita>".reais((double)$frete)."</div>".
		"</div>".
		"<div class='row'>".
		"<div class='col-md-8'>".anchor(base_url('pagar-e-finalizar-compra'),'Pagar e finalizar compra')."</div>".
		"<div class='col-md-2 texto-direita'>Total da compra: </div>".
		"<div class='col-md-2 texto_direita'>".reais($this->cart->total() + $frete)."</div>".
		"</div>";
	}else{
		echo "<div class='row'>".
		"<div class='col-md=12 texto-direita>".
		"Efetue". anchor(base_url('login'),'login').
		"para calcular o frete e finalizar a compra".
		"</div>".
		"</div>";
	}
	?>
