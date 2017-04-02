<div id='homebody'>
	<div class="alinhado-centro borda-base espaco-vertical">
		<?php echo heading($produtos[0]->titulo,3);?>
	</div>
	<div class="row">
		<div class="col-md-4">
			<?php echo img(base_url("assets/img/produto-sem-foto.png"));?>
		</div>
		<div class="col-md-5">
			<?php
			foreach($produtos as $produto){
				echo "<p>".$produto->descricao."</p>".
				heading($produto->codigo,6).
				heading(reais($produto->preco),5);
			}
			?>
		</div>
		<div class='col-md-3'>
			<?php 
			echo heading("Comprar ". $produtos[0]->titulo,5);
			echo "Preço unitário: ".reais($produtos[0]->preco).br().
			form_open(base_url('carrinho/adicionar'));
			$campos_hidden= array(
				'id'=>$produtos[0]->codigo,
				'url'=>base_url(uri_string()),
				'foto'=>base_url('assents/img/produto-sem-foto'),
				'nome'=>$produtos[0]->titulo,
				'altura'=>$produtos[0]->altura_caixa_mm,
				'largura'=>$produtos[0]->largura_caixa_mm,
				'comprimento'=>$produtos[0]->comprimento_caixa_mm,
				'peso'=>$produtos[0]->peso_gramas,
				'preco'=>$produtos[0]->preco);
			echo form_hidden($campos_hidden).
			form_input('quantidade',1).
			form_submit('adicionar','Adicionar ao carrinho').
			form_close();
			?>
		</div>
	</div>
</div>