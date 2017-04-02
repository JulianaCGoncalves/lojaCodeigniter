<div id='homebody'>
	<div class='alinhamento-centro borda-base espaco-vertical'>
		<h3>Seja bem-vindo à nossa loja.</h3>
		<p>Use o formulário abaixo para se cadastrar.</p>
	</div>
        <div class="row">

   		<?php
		echo validation_errors();
		$atributos=array("name"=>"form_cadastro");
		echo form_open(base_url('cadastro/adicionar'),$atributos);
		echo "<div class='col-md-4'>".
		"Dados pessoais".br().
		form_input(array('id'=>'nome','name'=>'nome','Placeholder'=>'Nome','value'=>set_value('nome'))).
		form_input(array('id'=>'sobrenome','name'=>'sobrenome','Placeholder'=>'Sobrenome','value'=>set_value('sobrenome'))).
		form_input(array('id'=>'rg','name'=>'rg','Placeholder'=>'RG','value'=>set_value('rg'))).
		form_input(array('id'=>'cpf','name'=>'cpf','Placeholder'=>'CPF','value'=>set_value('cpf'))).
		form_input(array('id'=>'data_nascimento','name'=>'data_nascimento','Placeholder'=>'Data de Nascimento','value'=>set_value('data_nascimento'))).
		form_input(array('id'=>'sexo','name'=>'sexo','Placeholder'=>'Sexo(M/F)','value'=>set_value('sexo'))).
		"</div>
		<div class='col-md-4'>".
		"Endereço".br().
		form_input(array('id'=>'cep','name'=>'cep','Placeholder'=>'CEP','value'=>set_value('cep'))).
		form_input(array('id'=>'rua','name'=>'rua','Placeholder'=>'Rua','value'=>set_value('rua'))).
		form_input(array('id'=>'bairro','name'=>'bairro','Placeholder'=>'Bairro','value'=>set_value('bairro'))).
		form_input(array('id'=>'cidade','name'=>'cidade','Placeholder'=>'Cidade','value'=>set_value('cidade'))).
		form_input(array('id'=>'estado','name'=>'estado','Placeholder'=>'Estado','value'=>set_value('estado'))).
		form_input(array('id'=>'numero','name'=>'numero','Placeholder'=>'Número','value'=>set_value('numero'))).
		"</div>
		<div class='col-md-4'>".
		"Contato".br().
		form_input(array('id'=>'telefone','name'=>'telefone','Placeholder'=>'Telefone','value'=>set_value('telefone'))).
		form_input(array('id'=>'celular','name'=>'celular','Placeholder'=>'Celular','value'=>set_value('celular'))).
		form_input(array('id'=>'email','name'=>'email','Placeholder'=>'E-mail','value'=>set_value('email'))).
		form_input(array('id'=>'senha','name'=>'senha','Placeholder'=>'Senha','value'=>set_value('senha'))).
		form_submit('btn_cadastrar','Cadastrar');
		echo "</div>";
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