<div id='homebody'>
	<div class='alinhamento-centro borda-base espaco-vertical'>
		<h3>Alteração de cadastro.</h3>
		<p>Use o formulário abaixo para alterar seu cadastro.</p>
	</div>
	<div class="row">
		<?php
		echo validation_errors();
		echo form_open(base_url('cadastro/salvar_alteracao_cadastro'),array('id'=>'form_cadastro')).
		"<div class='col-md-4'>".
		form_hidden('id',md5($cliente[0]->id)).
		form_input(array('id'=>'nome','name'=>'nome','Placeholder'=>'Nome','value'=>$cliente[0]->nome)).
		form_input(array('id'=>'sobrenome','name'=>'sobrenome','Placeholder'=>'Sobrenome',
			'value'=>$cliente[0]->sobrenome)).
		form_input(array('id'=>'rg','name'=>'rg','Placeholder'=>'RG','value'=>$cliente[0]->rg)).
		form_input(array('id'=>'cpf','name'=>'cpf','Placeholder'=>'CPF','value'=>$cliente[0]->cpf)).
		form_input(array('id'=>'data_nascimento','name'=>'data_nascimento','Placeholder'=>'Data de Nascimento','value'=>dataMySQL_to_dataBr($cliente[0]->data_nascimento))).
		form_input(array('id'=>'sexo','name'=>'sexo','Placeholder'=>'Sexo(M/F)','value'=>$cliente[0]->sexo)).
		"</div><div class='col-md-4'>".
		form_input(array('id'=>'cep','name'=>'cep','Placeholder'=>'CEP','value'=>$cliente[0]->cep)).
		form_input(array('id'=>'rua','name'=>'rua','Placeholder'=>'Rua','value'=>$cliente[0]->rua)).
		form_input(array('id'=>'bairro','name'=>'bairro','Placeholder'=>'Bairro','value'=>$cliente[0]->bairro)).
		form_input(array('id'=>'cidade','name'=>'cidade','Placeholder'=>'Cidade','value'=>$cliente[0]->cidade)).
		form_input(array('id'=>'estado','name'=>'estado','Placeholder'=>'Estado','value'=>$cliente[0]->estado)).
		form_input(array('id'=>'numero','name'=>'numero','Placeholder'=>'Número','value'=>$cliente[0]->numero)).
		"</div><div class='col-md-4'>".
		form_input(array('id'=>'telefone','name'=>'telefone','Placeholder'=>'Telefone','value'=>$cliente[0]->telefone)).
		form_input(array('id'=>'celular','name'=>'celular','Placeholder'=>'Celular','value'=>$cliente[0]->celular)).
		form_input(array('id'=>'email','name'=>'email','Placeholder'=>'E-mail','value'=>$cliente[0]->email)).
		form_input(array('id'=>'senha','name'=>'senha','Placeholder'=>'Senha','value'=>$cliente[0]->senha)).
		form_submit('btn_cadastrar','Alterar Cadastro').
		"</div>".
		form_close();
		?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#cpf').mask('000.000.000-00',{reverse:true});
		$('#cep').mask('00000-000',{reverse:true});
		$('#telefone').mask('(00)0000.0000',{reverse:true});
		$('#celular').mask('(00)00000-0000',{reverse:true});
		$('#data_nascimento').mask('00/00/0000',{reverse:true});
		$('#sexo').mask('A',{reverse:true});
		$('#cep').blur(function(){
			$.getJSON("http://viacep.com.br/ws/"+$('#cep').val()+"/json",function(dados){
				if(!("erro" in dados)){
					$('#rua').val(dados.logradouro);
					$('#bairro').val(dados.bairro);
					$('#cidade').val(dados.localidde);
					$('#estado').val(dados.uf);
					$('#numero').focus();
				}else{
					alert('CEP não encontrado');
				}
			});
		});
	});
</script>