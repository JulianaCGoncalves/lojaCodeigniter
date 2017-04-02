<div id="homebody">
	<div class="alinhado-centro borda-base espaco-vertical">
		<h3> Você buscou por:<?php echo $termo;?></h3>
		<p>Os seguintes resultados foram encontrados.</p>
	</div>
	<div class="row">
		<?php
		$contador=0;
		foreach ($destaques as $destaque) {
			$contador++;
			echo "div class='col-md-4 caixacategoria'>";
			echo heading($destaque->titulo,3);
			echo "<p>".word_limiter($destque->descricao,20)."</p>";
			echo anchor(base_url("produto/".$destaque->id."/".limpar($destaque->titulo)),"Ver produto",array('class'=>'btn'));
			echo"</div>";
			if(contador%3==0){
				echo "</div><div class='row'>";
			}
		}
		?>
	</div>
</div>