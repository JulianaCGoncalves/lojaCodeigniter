<div class='container'>
	<div class="masthead">
		<div id="cadastro-e-login">
			<?php
			if(null != $this->session->userdata('logado')){
				echo "Seja bem-vindo(a): " . $this->session->userdata('cliente')->nome." " .
				$this->session->userdata('cliente')->sobrenome. " ".
				anchor(base_url('alterar-cadastro/'.md5($this->session->userdata('cliente')->id)),'Alterar cadastro')." ".
				anchor(base_url('logout'),'Logout')." ".
				anchor(base_url('carrinho'),'Carrinho['.$this->cart->total_items().']');
			}else{
				echo anchor(base_url('cadastro'),'Cadastro'). " ".
				anchor(base_url('login'),'Login');
			}
			?>
		</div>
		<?php echo heading('Loja online',3,'class="muted"');?>
		<ul class="nav nav-tabs">
			<li class="active"><?php echo anchor(base_url(),"Home")?></li>
			<li class="dropdown"><?php echo anchor(base_url("categorias"),"Produtos<b class='caret'></b>",array("class"=>"dropdown-toggle","data-toggle"=>"dropdown"));?>
				<ul class="dropdown-menu">
					<?php
					foreach($categorias as $categoria){
						echo "<li>".anchor(base_url('categorias/'.$categoria->id."/".limpar($categoria->titulo)),$categoria->titulo)."</li>";
					}
					?>
				</ul>
			</li>
			<li><?php echo anchor(base_url('fale-conosco'),"Fale Conosco")?></li>
			<li><?php $atributos=array("name"=>"form-busca","class"=>"navbar-search pull-right");
				echo form_open(base_url('home/buscar'),$atributos);
				echo form_input(array("type"=>"text","name"=>"txt-busca","placeholder"=>"Buscar","class"=>"search-query"));
				echo form_input(array("type"=>"submit","name"=>"btn_busca","value"=>"Buscar"));
				echo form_close();
				?></li>
			</ul>
		</div>