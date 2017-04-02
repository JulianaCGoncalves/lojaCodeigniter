<div id='homebody'>
	<div class="alinhado-centro borda-base espaco-vertical">
		<h3> Seja bem-vindo à nossa loja.</h3>
		<p> A melhor loja de comida, especiarias e temperos.
			Compre online e receba em casa.</p>
			<a class="btn btn-medium btn-sucess" href="#"> Cadastre-se</a>
		</div>
		<div class="row">
			<?php 
			$contador=0;
			foreach($categorias as $categoria){
				$contador++;
				echo "<div class='col-md-4 caixacategoria'>";
				echo heading($categoria->titulo,3);
				if(is_file('assets/img/categorias/'.md5($categoria->id).".jpg")){
					echo img('assets/img/categorias/'.md5($categoria->id).".jpg");
				}
				echo "<p>".word_limiter($categoria->descricao,40)."</p>";
				echo anchor(base_url('categorias/'.$categoria->id."/".limpar($categoria->titulo)),"Ver produtos",array('class'=>'btn'));
				echo"</div>";
				if($contador%3 == 0){//para exibir de 3 em 3 categorias
					echo "</div><div class='row'>";
				}
			}
			?>
		</div>
	</div>