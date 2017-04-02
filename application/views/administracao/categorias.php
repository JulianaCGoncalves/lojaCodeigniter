<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"> Administrar Categorias</h1>
			</div>
			<div class="col-lg-6">
				<h2>Adicionar nova categoria</h2>
				<?php
				echo validation_errors();
				$titulo=array('name'=>'txt_titulo','id'=>'txt_titulo','Placeholder'=>'Título','value'=>set_value('txt_titulo'));
				$descricao=array('name'=>'txt_descricao','id'=>'txt_descricao','Placeholder'=>'Descrição','value'=>set_value('txt_descricao'));
				echo form_open('administracao/categorias/adicionar').br().
				form_label('Nome da categoria','txt_titulo').br().
				form_input($titulo).br().
				form_label('Descrição','txt_descricao').br().
				form_textarea($descricao).br().
				form_submit('btn_adicionar','Adicionar nova categoria').
				form_close();
				?>
			</div>
			<div class="col-lg-6">
				<h2>Alterar categorias existentes</h2>
				<?php
				$this->table->set_heading('Imagem','Excluir','Alterar','Nome da Categoria');
				foreach ($categorias as $categoria) {
					$imagem=img('assets/img/categorias/categoria-sem-foto.png');
					if(is_file('assets/img/categorias/'.md5($categoria->id).".jpg")){
						$imagem=img('assets/img/categorias/'.md5($categoria->id).".jpg");
					}
					$excluir=anchor(base_url('administracao/categorias/excluir/'.md5($categoria->id)),"Excluir");
					$alterar=anchor(base_url('administracao/categorias/alterar/'.md5($categoria->id)),"Alterar");
					$this->table->add_row($imagem,$excluir,$alterar,$categoria->titulo);
				}
				$this->table->set_template(array('table_open'=>"<table class='table table-striped miniaturas'>"));
				echo $this->table->generate();
				?>
			</div>
		</div>
	</div>
</div>
