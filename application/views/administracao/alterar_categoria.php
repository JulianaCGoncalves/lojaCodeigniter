<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"> Administrar Categorias</h1>
			</div>
			<div class="col-lg-7">
				<?php
				echo heading("Alterar categoria: ".$categoria[0]->titulo,3);
				echo validation_errors();
				$tit=array('name'=>'txt_titulo','id'=>'txt_titulo','value'=>$categoria[0]->titulo);
				$des=array('name'=>'txt_descricao','id'=>'txt_descricao','value'=>$categoria[0]->descricao);
				echo form_open('administracao/categorias/salvar_alteracoes').br().
				form_hidden('id',md5($categoria[0]->id)).
				form_label('Nome da categoria','txt_titulo').br().
				form_input($tit).br().
				form_label('Descrição','txt_descricao').br().
				form_textarea($des).br().
				form_submit('btn_adiconar','Alterar categoria').
				form_close().
				"</div>".
				"<div class='col-lg-5 imagem'>".
				heading("Imagem",3);
				if(is_file('assets/img/categorias/'.md5($categoria[0]->id).".jpg")){
					echo img('assets/img/categorias/'.md5($categoria[0]->id).".jpg?i=".date('dmYhis'));
				}
				echo form_open_multipart(base_url('administracao/categorias/nova_foto')).
				form_hidden('id',md5($categoria[0]->id)).
				form_upload('userfile').
				form_submit('btn_adiconar','Adicionar nova imagem').
				form_close();
				?>
			</div>
		</div>
	</div>
</div>
