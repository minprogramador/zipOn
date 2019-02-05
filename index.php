

﻿<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>ZipOn.</title>

  <script src="js/bootstrap.min.js" DEFER="DEFER"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<style type="text/css">
#resultOrinal {
	display: none;
}
#loading{
	display: none;
}
</style>

<script type="text/javascript">

function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}
function id( el ){
	return document.getElementById( el );
}


function pesOriginal(tipo){
	$('#resultOrinal').hide();
	$('#resultOrinal tbody').html("");

	if(tipo == 'cpf') {
		$(".appOriginal #dados").attr("placeholder", "Digite o CPF");
		$(".appOriginal #tipo").val("cpf");
		$(".appOriginal #dados").val("");
		$(".appOriginal #bntOrigOk").html("CPF <span class=\"caret\"></span>");
	}else if(tipo == 'cnpj') {
		$(".appOriginal #dados").attr("placeholder", "Digite o CNPJ");
		$(".appOriginal #bntOrigOk").html("CNPJ <span class=\"caret\"></span>");
		$(".appOriginal #dados").val("");
		$(".appOriginal #tipo").val("cnpj");
	}else if(tipo == 'nome') {
		$("#frmOriginal").css("display", 'block');
		$(".appOriginal #dados").attr("placeholder", "Digite o Nome");
		$(".appOriginal #bntOrigOk").html("Nome <span class=\"caret\"></span>");
		$(".appOriginal #dados").val("");		
		$(".appOriginal #tipo").val("nome");

		var nform = `

<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
				<span>Nome:</span>
				<input name="nome" id="nome" placeholder="Nome da Pessoa Fisica ou Pessoa Juridica" min="0" maxlength="" class="form-control" value="" type="text">
		    </div>

		</div>
	</div>

	<div class="row">
		<div class="col-lg-4">
			<div class="form-group">
				<span>Uf:</span>
				<select class="form-control form-group" name="uf" id="uf">
					<option value="">Selecione UF</option>
					<option value="AC">AC</option>
					<option value="AL">AL</option>
					<option value="AM">AM</option>
					<option value="AP">AP</option>
					<option value="BA">BA</option>
					<option value="CE">CE</option>
					<option value="DF">DF</option>
					<option value="ES">ES</option>
					<option value="GO">GO</option>
					<option value="MA">MA</option>
					<option value="MG">MG</option>
					<option value="MS">MS</option>
					<option value="MT">MT</option>
					<option value="PA">PA</option>
					<option value="PB">PB</option>
					<option value="PE">PE</option>
					<option value="PI">PI</option>
					<option value="PR">PR</option>
					<option value="RJ">RJ</option>
					<option value="RN">RN</option>
					<option value="RO">RO</option>
					<option value="RR">RR</option>
					<option value="RS">RS</option>
					<option value="SC">SC</option>
					<option value="SE">SE</option>
					<option value="SP">SP</option>
					<option value="TO">TO</option>
				</select>
		    </div>
		</div>
		<div class="col-lg-5">
			<div class="form-group">
				<span>Cidade:</span>
				<input name="cidade" id="cidade" placeholder="Cidade" min="0" maxlength="" class="form-control" value="" type="text">
		    </div>

		</div>

		<div class="col-lg-3">
			<div class="form-group">
				<span>CEP:</span>	
				<input name="cep" id="cep" placeholder="Cep" min="0" maxlength="" class="form-control" value="" type="text">
		    </div>
		</div>
	</div>


		<div class="col-lg-12">
			<center>
			<div class="form-group">
				<button type="button" class=" btn btn-default" onclick="main();">
					<span>Voltar</span>
				</button>
				<button type="button" class=" btn btn-default" onclick="PesquisarZip();">
					<span>Pesquisar</span>
				</button>

			</div>
			</center>
		</div>

	</div>


		</div>`;


		$("#frmOriginal").html(nform);

	}else if(tipo == 'endereco') {
		$("#frmOriginal").css("display", 'block');
		$(".appOriginal #dados").attr("placeholder", "Digite o Nome");
		$(".appOriginal #bntOrigOk").html("Nome <span class=\"caret\"></span>");
		$(".appOriginal #dados").val("");		
		$(".appOriginal #tipo").val("nome");

		var nform = `

<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-9">
			<div class="form-group">
				<span>Logradouro:</span>
				<input type="hidden" name="end" id="end" value="true">
				<input name="logradouro" id="logradouro" placeholder="Digite o nome da rua/Logradouro" min="0" maxlength="" class="form-control" value="" type="text">
		    </div>
		</div>
		<div class="col-lg-3">
			<div class="form-group">
				<span>Numero:</span>
				<input name="numero" id="numero" placeholder="Numero" min="0" maxlength="" class="form-control" value="" type="text">
		    </div>
		</div>

	</div>

	<div class="row">
		<div class="col-lg-4">
			<div class="form-group">
				<span>Uf:</span>
				<select class="form-control form-group" name="uf" id="uf">
					<option value="">Selecione UF</option>
					<option value="AC">AC</option>
					<option value="AL">AL</option>
					<option value="AM">AM</option>
					<option value="AP">AP</option>
					<option value="BA">BA</option>
					<option value="CE">CE</option>
					<option value="DF">DF</option>
					<option value="ES">ES</option>
					<option value="GO">GO</option>
					<option value="MA">MA</option>
					<option value="MG">MG</option>
					<option value="MS">MS</option>
					<option value="MT">MT</option>
					<option value="PA">PA</option>
					<option value="PB">PB</option>
					<option value="PE">PE</option>
					<option value="PI">PI</option>
					<option value="PR">PR</option>
					<option value="RJ">RJ</option>
					<option value="RN">RN</option>
					<option value="RO">RO</option>
					<option value="RR">RR</option>
					<option value="RS">RS</option>
					<option value="SC">SC</option>
					<option value="SE">SE</option>
					<option value="SP">SP</option>
					<option value="TO">TO</option>
				</select>
		    </div>
		</div>
		<div class="col-lg-5">
			<div class="form-group">
				<span>Cidade:</span>
				<input name="cidade" id="cidade" placeholder="Cidade" min="0" maxlength="" class="form-control" value="" type="text">
		    </div>

		</div>

		<div class="col-lg-3">
			<div class="form-group">
				<span>CEP:</span>	
				<input name="cep" id="cep" placeholder="Cep" min="0" maxlength="" class="form-control" value="" type="text">
		    </div>
		</div>
	</div>


		<div class="col-lg-12">
			<center>
			<div class="form-group">
				<button type="button" class=" btn btn-default" onclick="main();">
					<span>Voltar</span>
				</button>
				<button type="button" class=" btn btn-default" onclick="PesquisarZip();">
					<span>Pesquisar</span>
				</button>

			</div>
			</center>
		</div>

	</div>


		</div>`;


		$("#frmOriginal").html(nform);

	}else if(tipo == 'telefone') {
		$(".appOriginal #dados").attr("placeholder", "Digite o Telefone");
		$(".appOriginal #bntOrigOk").html("Telefone <span class=\"caret\"></span>");
		$(".appOriginal #dados").val("");		
		$(".appOriginal #tipo").val("telefone");
		$("#dados").hide();
		$("#telefoneok").show();
	}


//	alert(tipo);
}

function main() {
	$("#resultadoOriginal").hide();
	
	$("#layOriginal").show();

	$('#resultOrinal').hide();

	var main = `
			<div class="input-group">
 				<div class="input-group-btn">
					<input type="hidden" name="tipo" id="tipo" value="cpf">
					<button type="button" id="bntOrigOk" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						CPF <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="javascript:void(0)" onclick="pesOriginal('cpf');">CPF</a></li>
				    	<li><a href="javascript:void(0)" onclick="pesOriginal('cnpj');">CNPJ</a></li>
						<li><a href="javascript:void(0)" onclick="pesOriginal('nome');">Nome</a></li>
						<li><a href="javascript:void(0)" onclick="pesOriginal('endereco');">Endereco</a></li>
				        <li><a href="javascript:void(0)" onclick="pesOriginal('telefone');">Telefone</a></li>
				 	</ul>
				</div>

				<input type="text" name="dados" id="dados" class="form-control" placeholder="Digite o CPF">
				<input type="text" name="telefoneok" onkeypress="mascara( this, mtel );" maxlength="15" id="telefoneok" value="" class="form-control" placeholder="Digite seu telefone" style="display:none">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="PesquisarZip();">Pesquisar</button>
				</span>
			</div>
	`;
	$("#frmOriginal").html(main);
}

function count_digits(n) {
    numDigits = 0;
    integers = Math.abs(n);

    while (integers > 0) {
        integers = (integers - integers % 10) / 10;
        numDigits++;
    }
    return numDigits;
}
function abrirOriginal(doc, tipo) {

	$("#layOriginal").hide();
	$("#resultOrinal").hide();

	$("#resultadoOriginal").html("<br><br><br><center>Aguarde...</center>");
	$("#resultadoOriginal").show();	    
	if(tipo === 'Fisica') {
		tipo = 'cpf';		
	}else{
		tipo = 'cnpj'
	}
	var data = {
		tipo: tipo,
		dados: doc
	}

	$.ajax({
	        method : "POST",
	        url : './zipcode.php',
	        data: data,
	        timeout: 8000,
	    })
	    .done(function(res) {
    	
	    	if(res.error && res.msg){
	    		alert(res.msg);
	    		return;
	    	}
			$("#resultadoOriginal").html(result);
			$("#resultadoOriginal").show();	    	

			if(res.dados.cpf){
				$("#resultadoOriginal").hide();
				$("#layOriginal").hide();
				$('#resultOrinal').hide();

				var result = `
				<div class="row">
				<div class="col-lg-1"></div>
				<div class="col-lg-10">

							<center>
								<img style="margin-bottom:10px; margin-top:20px" src=" data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAB5KSURBVHhe7V1diF3XeT0a3ZmmD6V9KJhSqOlDcB9CDQ2V6YNrU4o98sietpA4hUIKpTYEiknQzNiyrLFmXAcKMc1D/ZAHlVJQKBRDoRHkIepTXGxJI9W2FNs4tmmtsdwE44dU4Kfpt/b9ztU+53777/yfO9+ChTT37rvPOfvsb++19s85mUKhUCgUCoVCoVAoFAqFQqFQKBQKhUKhUCgUCoVCoVAoFAqFQtE7Lm2tPHBpY7Jt8Ul8dvFM9kucRKE4XLj8reV7rmyunLu8uXLg5MbKbaR57eTkXv6ZQrHYeO3kF+66vLF8XgwIL5dfvvpU9qucjUKxeLh8cmXr0ubKp3IAhHlpc3Lj6tbK3ZydQrEYMB6DKrdU6VOJANMgUSwEqsspPy9trLyqBl4xatSVUyFSj/QiH0qhGA+alFMh6uiWYjRoS075CKnFh1cohou25ZSXJydf59NQKIaFLuWUm5N9nR9RDAqQU8FZ8A55ZWPyEp+aQtEvXt9cfqo3OeWhGnZFryApcx9VxL1yxWySJNdewfor6bsQ1bArekFHcooCb3Ifjge5JHwfRzXsii7RtpxC3jgGH84AM+Qw3lL6MNWwKzpAF3Jquoz9C3fxIQt4fXPyuPSbGKphHxh+vp39yv9sZ7/5853sdz4+mx375IXsXvy9/7fZr3OS0aBrOeUDpbtY+l001bD3DATFJ7vZH9zazb5GQfE3Ln6yk32d/n0QAcM/HSz6kFM+oJKrYR8Zbm5nv7y/m93/8fPZN8rBEOROtjbEXqULOYUlKC455YMa9hHhk+3srls72V+JlT+WFFiUx5c4y14BM9u2nMIsO2bb+ZDJUMM+Eny0nX2xUq/hIHohzroXmIcitCynsD6LD1cLdQw7tulyNoq2AP/QZHDk3N/OvsyH6AyQU9DncmVqiBXllA903hfEY0VQDXuLgBknI/6EVMGb4K1vZ7/Nh2oVkBpoTaUK1BTryikf8ASUqoaduMfZKJoGjLVUsW1ipOrW2eyP8+FdDPdCQoVGuEB4moN/yZb4cK1gTHLKBwrAF6XjxxBlwNkomgJGnKRKbRNDvb4KjmAJ9UDIg5M3irHKKRfqGvauzvPQgCruw1KFNiRPglEtTuoFhoZ5PsSZV5O9yNjllA8UkOvS+cRRDXtjQIX1GfNUg22MvpBPzqa8yKLIKR/UsA8A5CF+S6rIhjvZVzhZEui3D87lxYSH4WSVsGhyygc17AMAVdpj5UqcE2ackyXB52lg6DlZEhZZTvmghr1nUKV1tvax3kOCS7ZhNIuTRANLKaqb1giilSY5NcQHtKlh7xkkeR6TKnJdQw15JuZL5CRBQEe3LaeohX5l6JVIDXuP8M1/vPvdbIWTJcM3N8JJnDBrp+os3osg5NRrJ1ce5kMOHmrYe4JZsStUYhAGnpMlwYyMCfmBGAbmZCIOs5zyQQ17T8AwrlSRwaprqLxDvY6RMZVTYahh7wEw4mJFJsJQV5FZ+2ezP5PyA8uz6Sqn4qGGvSf49n6kzltgD4iUT057x6HKqXSoYe8BPh8CxkotM+nomZXPh3hVTtWDGnYLWN+EVjdnG1tZcQxfxTYk7/DZt7Nf458UABmGnkb8ncX9M9nvNymnrmytHFzdWi7w8tbkOsmph/jUFhJ+w049Mn2PdJCVwnKc8Rt2s6tvJ1vzrY6FzsdMd52hWBuhXiSnWYw4HRo+hqCIWeoO/vRM9vdNyKmrFBRvPjM5ePvZEk8d/fynp5f+jcrlm7Nl+TUmOocOMt3bUvmUvRZWBpTTjNawQ7/7/IBIavlRueuuksXvYyt7CqnX23339NGfoGKXb1QK8fvrUmAQ3z299NZHz2enpOPvP5/9RdXh6iHDGPaNyfvlcuKvZ8A7DstpRmfYIV0gYaQbHEtUhLotptlVmBqgDt58Ptt477mlH6ICX32apM/cTYrnG/T7clCA7zy79LMPzxz5B+n4c6ReD1KSL3UhIBl27Gvnrw1cPc1oDDtaN5+USuK0N6nVWiJYvXs6IvjBmewcVd7P3j41ObjWRnCQnHrv9JEfQE5Jx3cR14VGgC91IYDBiLlyO7myBWkFKeWbXBy8YcfeiKA5TmUDQQJf45vLcJHl1Dt5Rd6rKauk4GA5tS0dP4ZojFyDDWOEkVCLOMPe6kMSKEiaaCkxWBDTm9hyCkTFxgiTcEOieW2rGBxJcipAyNG6nm1IcMuoMAdr2GNaaA4gLEc/hiFe/Iu/YwILq3T5ULWAioRAMSNWgj/54MyRf4Scuk5y6r8QGMJNSCYF1yw4PHIKwYuZeYzmmd6YR9bK6SRiYIMvcfRwGfY4DtCw880Ub1xOTM65hnB5MaBzo1PONh61g2MjWH/y9NIfXt1a/nEjAVFiPozrklNoIBC0fEpzgBmPCRRXL0uG/mXip5Tmwgfb43hi4ULNsNMNdg+nkjyKHY0KPQURvRQnbQxYO1Vn0VyIkGbUI/2vS06h14idLMWwuZQH8/v7O9lNCoTrVI4zs0p/Y57nICflMZqX+IuGPZKDMeyhR+yktvomSIR8cjY5ajNtpdpdO/XG00vfdY5OVfBWkGBCXrtU+T+nfw8+3s0OKFBmT0j/aCd73A4Q4mjWLy2EYYdeLt2sGav6Bl+PVHVfuQ2ztKHG+p84Ti7gBvseQVTVNwje6VQpCG5wUrO6GQHDn3/68XZ2Nz6/eTZ7iv6+jc/oPAa7Mnj0ht1XAfDwNU6WBJ+ngRbnZMmA+TNyqnqrFCaZS3t5hDPYqfeoOtFHv5f23V/kIEAvUnhQwwd03be2s9mLb+i498zSTjkLqKFh9IYdQ4zCzTKsWgHwOyk/EBWOkyWhCzmF4LOXopvBB4enqnodAI8AzuVJ3I5pQMyeGStAqIfZ568GiVEbdte8AmQAJ6kEKU8Qx+MkUehKTuUrTm3AX0jXANYZcOB8MRr2A+J/EmfrtsoBgvPCLDTkHn9kQGm38wC5uZOt88eDRR3DTvcn+Nq41uCbeOMklSDobMPYAOlETqFHotaNDzkHX4DUkYo3d7PfoAB7f9YDnM1+Vs53+tyt0rsCN5bP2z3cmDBaw+4z1H1JrD7klATfdUCacrJk/PcZ8mgcHFaQbHDeDyKNewPXeHfh1THsKe9YbBRosewbb7PqxB71Hs7xfl/L26eccsHXw1ZdQ4XRL/r9W7MAOZtdy/PEKB8GCeRzn7L8tEUYeBh7mHn+aJCoY9ix0aoXw+4d5q1oRKHPpfxAaZh3CHLKBV8DQjzGyaJheiU2/lRO/0r8ntV7mD3yGN6Ur2HGvbz3Q2BYPdGNoW/KCgW/j3ivI2fTHXw6G/QtoZDA7ywX8wLLrS5V3PuGIKdc8PWGqOipvQj9zv0gbfJtGDmblolwLRZzybG/Yw0PE4c8J5JjdIbd1+KDsfMhZv7DMSwKUmtcmHg0vYZYCE0xTU5JQIV1DTiA8CKxQcLSyv79LpX9OfrXrO+yH0FE5+9/PTQFPiSH+b0VIPZ8yVCB8x6VYfdN7OXEzXMtVsTnlCZpsWK7wVFNTrkgVOwCSYo+gZ4GwcQ/KcD00vOPVJ0uL0HFPpv9ghqWv7MHRaKkyMbyeSxeRJCgJ8HsOv988MAmKvGaItiLYUfrXrqBc0RFoH8rLXdHBeFD1Xy9sIc15ZQLaAB8Zj0nehoOJpSLoad3Lkqjs9l3+HAzxEiRob0eIRbsO29I1xRiL4bdNo9NE5Ur731M99qK56gvp3wws9fNls8/zwLkLAXIC9mf8qFmiJQiM8PeNcxKamylrRikozPs1Pp5H7RWiZSfPbLS/GM9m5VTPvhG/Cry+9RzX6J/nZIhRoo0JTkwmYeKN+2JVz7FvIUr+DDSVnzGFdZNpS9Rj+kl3ezDsCNI5JuZTEgvSDHOmrvV5t7jBzmFVoyz7wRNBgl6VvgTztqAfMQWfbdNPbrpDaOkCBt2k0EJ+D0HGWblL6KBksrMLGmR7g35HE4yAxqkuXTEKtInspd0sZ8ZdrPE2rOIMYo72Vds0wk06D0utimnQkD5+Ea2YgjPVy4f+ny2voo4W9oea9hNJhZMcMkz8nvlIPG15OVl5/SZc4QN+XCyaIzOsAMYkYHhjDLgFo1R3c6+LI3ooMWXLjKek/3yc5b6gvFsGLBIlKRoeFxzS/T9BStACosQfRU4Z9kL+JZ2lDW8v2cvLjsPzYYjoDlpFKJ6SQer9FqNAhXdTP6FHiRH34fmS9DKSRcZQwRX13IqBmaEi2RXcJRrJ1uDfOWfiTDyioMDS9ht7xYpRQqGnf4uLnac4x0NjyCQ0+S8swbM+BQxzZSo7PZ5xGB0ht0FTIrBV+QsywQf6GICN0xkr3IqFXXKBzBbbC0PYgNyQiifAm3JQZU+tK5tpuERAML3BeYmHD2V9H2BJJtMxgmI6SVdXIinxNOFJAcIeg7++aGHMdwe/W9oGfbp+06ENBbzgIrtoZAWCFZmz8CBC5HnIBLnw9mMF5VaCBTYiHqQthHVerNhj9H2toaPMcu5YY+pzFUqbR3DPvpeJEYiyJxc4CwUhBgvlxv2GG2fa/g2AqpLw44hbM5mnECESxcWxY4mA8eASCkyM+xxPffUsDcfUJ0a9v52HjYFXETpoiI52U8t6EVGimGPDSiTMaHpgOrSsPPPxwv0BNKFxZAKTQ07A40FlUmCYQ/LocEZdimvAPnn4wZdSJXhXjXsJfRt2POAihhOTjLs6J2qvlSVsxg3jBcJt1AOqmG30bRhtwMqbv94/MrskGHHRHDMfIyLCHDOavyotapXDfsMsXIo928x2j4PqDpyWCJ6MJePnF8dXInjN+k5phq66r4QNew22jDsKQGVxJJhryOnyhzEMC/WB9lLKVzbcGNQZ3Uv3bhBGnYsX7fLJ/WhDlUwbWzaMew1H/g2Tz6PunJKYi8ThVhLhP3otzwPmDNLv3eytdQnoAB0YaM27GggsEjTbFn2rOzF1lukc+1br4umDfusIlOANCB9ytxrIc+LpiC6Am483fSo14fZzJe7czZBjNWwm1W8eNdH4nJ3bB9IKZ8UNG7YK0vgjmmCucPeA8uyTa8g3OBYYt+DvVzbh7EZdjydpW75mO0Bpd2EsTCyh2QSZJC9BQAtfkTL3J6/6IslX9MqzN4P6YZWIbWuoT0QwFRDj8Owo/UXr7UCTW8S+fo2YFpORd1uAuLkZPZA8BYM+6DZ6V4Qsx89UTLEMMabjMGw07UEn/2VSmlfugvOntZIjDtzDPRZo4Z9qMSOSXPBXcA83KyF4DCkfGMqAV30YA27aTyka2uAkKMh825Gfbyt/WQ/l1v0/+CjS3PDHtPjDI+T/dxLdYaoB8fBgO9m90OGYQgT/+LvKD1OmpsP5cRQDTtG8mKukR90cQweBeWDrbhmoCOu4fE+CNv4DvG679CeBwhti51yJCY8J9UNqIUuJbVBzKNHQyMv5nE4gYpgP3rUhSEadjQC0vXkRPAgIDj5HKJGBKnsfNtzjV+QrrnEfDQn0rCPiO0+GNALz+Mxp8+djajYAEatfEGCuRRO6sTQDDukD8pAuh4QvUbsvvOQwbcfXi2BrjEoQTErzclHKp/KpLrQ59IizPRKNytnbHDkCL0nPWbUZkiGnXoH98uAKHBSh2p9vRF6Ik4mAhVFuuY5WqNa9HfF/Tc9sy85VYbvSYExLb4En5/B8TiZF1RIgzDs1Kq735NeYcIPvY2vlw01IEZqSNddYKJhHxx7lFNl+CpAau+RwzeXguNxMi+GYtjZeIvXUnWiL9CLfImTiUDFiSmXdMM+DNrnPQigl5BuFFh1ISJ+52olUeE4WRBDMOzSNRhGjMq5AEMv5klE8HAyJyA9xGsucZyGfWArtX1PBOQkleAaFsXxOEkQQzDs0jWAsT2hBJ/vw2gXJ3MitlzGatgH1Yu4AiSlIkuQ8gRT8+3bsEvXAGLkj5Mkw0zKCnmCMQECLLRhJwnZ6eJDH3waO3b4sgxjRIX8wCrGnwqtN8PehFQsg2SUb1bevCc9BvBa4nUXOFrD3u3ydRd8E1ghw+iCd2QssoW00adhd3q0wMSeD/R755tuY0f5gEU37IN4kr939W4FI2om1jzLMlIqgI2+DLt3lK9CsAfLJ3KLQI7YclHDXhGhicLUCh2aLa46NNqXYQ8tw0mt0N6A282eSN1xWMWw67BvIrBdVrphhiQlYrfS+qQVSC1u4T3pqejDsIdafFTq2CAJremKGeKVEFsu5oU6WN5eWa72wCEY9lArCeLmuTQ3m3Knrs5ZdeLRBhXaj+YKMYY1CjpUsdGIQKq6Wn/Me/jWuxnW8DQAXWO1gYxxsH/D7u1FctJNZFM/ew+4TzIUaL0nvQ5eO7n0u1c3l//vjWeWD64/Mzl4+9kST00OrhPfpO+vbjVT0KFeZEYqHy7HvHzwDnnnRGyJ3uXuIdQbyBg+ezfs5iEEnknDOoQMqdM65sA6JbTE750+cnEuMDy89vRy7YKO6WWrss6cio1aAxmD5wAMe2i5eiVSfin7riWYFtwajqYK9c13nl36TAoGF29Qr7JnepTJzaoFTcdufMsteqYmGg+g3kDG8DkIww69jBZfupnJRHBEPLTBB+NvduZfIPrBmeycFAghQnZd2Tj6Hc4+GXTsxoIEk41NP1iuzkDG4DkEww64KmUKob3r3vyQ7Hv39NF3pCDwknoSeBh4GT5MMhD0dRsReLfUId0QzMRh1Oz6qDmMGXbcPMxpRJlTi5z+WBM3PzTyQ73d7tunjn4uBkKAVzZX/oMPUwloRIzsS5Sk6DWqPIHSB0grs8J3gU26zd4NexkYwgyNxuB731BnKkJzKjnfe27ph/AXbz0zHb1CDyEFRJkYAXt98+hX+XCVgUBBQxIa4ECP4du3XhXTRYuL6ztkDmxJvA1UCNzonE1raMBIvEDLjJ4KI0s/Op0tX948+pFdgDDjCBopMGxee+boraYLGgMddvk0LaNyHBI55eQgDHtfCE3MQdrYm7kub0welQrxjaeXvT3KDWIdw94HDpuccnIohr0P+OSKa7kKtab/LhWkCZJSYNjcM4Z9HAV9OOWUl8Mw7F0CcyZSYIAYOYL84qQFXP5W9kVqVX5RLsQrkFtCYOREAA29oA+7nPJxcIa9bQRWA3uXY5D0eEEqxKtb7l4EZh1phljQKqfCpPK5wcV1OODzH6HFjpJhN6ReRAqOnNN0wxoZUTkVJpbt5w/hPjTwLX50ySsbLsPuG9XK0wxhZETlVBT3qIzu4yI7XIAJl4IDjB0ypcKbM+wxAdLnyEg3cmrcPRJ2QubvNjm0sBcllhm76FEy7FJg5LTTETs37F3IKQSfeYWC6aHGt3fkUMopCRQIzsWAtxIeImEbdixQlAIDxAiXfSPArgx7R3LqIo7Dh5wBPaVZHr8xeV/4zWAIE975u0CGDN/Dr11zIBJsw+6bC8ESlfJNQWvepmHvSk7FBjoCCGnNOSGgBjBqNn21XIfvHhwLfI8tBbHei5MGAcOOZSe+2fRrW3c2U9lsy7B3Kaf4kJUwC5qNybbpaaayjIKngx5nY/m8yikPfKt4MVkYu/4LwfbO6aU9KTAMKXAwBCzfpGYNe59yqi2gJ6RjNva0RpVTkQhub8VGrMCrB8yejR3z5ifnkvg3RXlVYG3DPjQ51TRQoeVziqfKqQoI7QUBeQn+MQQDnreF1bNmJr70AAosiZcC5Ipws8qsU/HGIqfqApJIOrcoqpyqBvNAu8TNSC5Ke9h5DVYE0w37IsopH1DBU3tIlVMNIPQ6txR+eObI9/LgiJBWBcYa9kWXUz7Evl5B5VTDCCxeTOK7p5fewq5DrPCVbp6TEYb9sMgpF2IMO53/KyqnWoAx7Q3IrQ+fO/K1Gq27aNi7kFN4ru4Y9qy4DDvk1GsnVyq/cEgRAXgS3zotH/GgBBh55GMkkHATY2hLm67klP0CnDGgYNhRNiSnUj2cogZQ0cujVC5ilKu8PGUqBapKoalh70JOwfcMVU75kBt2lVM9Ayt7eb7EPAcXw8K8l+QYZtt9S+OnFVyumGG27DNGIqd80MBYAFBFH9iei/HJKcUCw5jrVv1DPMcqpxQLjjqGvQkugpxSLDDqGfY6VDmlGAnqGfZ0qpxSjA5dGHaVU4rRok3DjrVHlzYmT/KhFIpxAp5AquD1uPxyX3Lq0UdX71tfe/gB8LETq1vra8e3k3ni+Hqex/Hjx3Vuoys8duL4S8SL/XFVXE2KUa1/+uvfOzjz5w/MKFd8PyGnSLZ1+tymx9ZWH6drO0d8nyr2QUu8TTyPY62vr6uPaguopKWC75SoSHwqc9j46h/92E4rBYCLfcip9UceuXf9xOq+fc5d0dXQKGpiyAGC7+y0UiDMkfxLH6NTCA5qzT+1z3fGteOvopxnXFt9ZU5COUjp53p4VxDSd86yVFSEafVY27ZJIzvmK9BtfM6nMge0inml+Ms/eWgPDywzm3ykwNhc2YMs62PtETyBcG3ncd2cpHGsrz98t1ima8df5CSKsUCWHqv7MK+cJAnoHbDfIWffcxnGeFvXRgHdmbRDcFJQ3JgdmwLm/vvv1yXtYwFaObpxMJRWBVrdQwvISUYPCoiZGce18cedgct4Vr7rjz6sKwPGAKo4LxVu3JTnF6mFM0O49vWtrXb+QGeUZ1FqrV7grxRDBIYd6Ya9Uqg4YGLlod+s24aVP54D8p2ls1pPY5yn8of8wB0ZIhEVDF6H8noZLXJsEM+13i36Dh9Mrzw7h+Pii2xmZVQqJwDXi8/QqKEcigFX4nTQ4VxKOSkYJ048dA9ukF2gKOxHH3kkeR80boKdD388B0pnSRyq5CYwao/O3aY8XgrNMZjgtH/Xk3REr5GfA8qbPy7APk+UDz4zvQ+CwhcQflI56RBzFHi0qjyqcgNBw0mSQDeuSoC8X+NmC1zd950/KlchfU+TduWyks7D/p7SX0QwlxuzqkR+2pt4MNeSotAgs2pUmPJN54/nQOlcM9a3IZno3/XQiBlGg9DLQX6U8zN/O3qG2HNsG3TeL9rnIZ2v/T2dN8nJ46/OPqNAoc+eRCPnWsoyDSgslzGNQmHgZZpH9/5r8OAuuth6mcKqPx4fW/ko3XyA0M2vumbJ6HHodCs/BDt/XUDsObaN8vmGAiQnnf/FKvLXzP3M3ffVfe1FLPAY/J1WaErv5F8KqgfI6n7V4LBBeZ238r0t5TnmADHlVqOHNw1JeX6rp0GKwWE6vFksHFPgZJA5SW1UDpCGZpOnE5x2vvMSYswB0kRlLktrNewE9BBUGKXJP5i+Zg1q1QCpOkMvwTb8OB/+eIYRB8ht/rgWyo2IVEaHClQA85N/ZIT560YRW/koXSFA+ONGYEtIaZZ8tAHimCtJBY5TyJdkKX91uIDegSTVbKydibmC1tYdVQuQ1X3+uBFQ3rP5FByHP54h9hzbRmqA4Lr449poK9/RQJr8Q0VsUspIiK18qLh5GvyfP24E9jlAbvHHM8SeY9vQAOkJGAK0dfi0EFb3mhglCiG28lG6TgJEOofYc2wbGiA9oDxCwexssWFs5aN0h74HofMozehrgLSG6fh2YQ5gyo5nSmMrH6XrzYOUW+4uelYJMWVlf4/r4o9ro618Bwlp8s9IrB4mgGJuOoCKG5OuCnDD83wdo1hP2sduch4oBfZ5uhoJ+zyRnj+ujbbyHRykyT9jzoXuugtQYVcKkC7nQcz6LevYfc0km/s0O4fjr/LHBdjnqQGSCOwFoAssTv7VXGxYF1UDBLKHv6oFM3pXyHdeYpbT0LlEvWS0SZhe3zoHojgXYafRAEkAbqp9kYYNVbI6oPOqFiDoBRsI7NLxxbVYACqFfeyuF+xheYd1ns5ezE6Dc+aPa6OtfHsHKlHx5hqiF1nnJL2iVEETAmR6o+oEyfwaI3fPQD1tcVchJlQ76nlxbFsGQmrxV3OwzxHlwx/XRlv59o6Cbs0vMOGZTY3R4XGosCsHCGgqztrqy/AJoU1b6B1c+0HoM/Jh7gqPHgMGvvAb9GLTPRrrTY9sGa9IAWzuVeGY5pqdK6kL6TRAwrAvrFc6JEGlAMEI3PwS/Mo0FT9ikIKXfpeX4nTJ26F9HXZ6DZAI2BfWKxsMENwgU1nRE9jSI5HIE9qeDxGFaU9Sa393FUISn48ZXrZ/h3Lij2ujrXx7ByrRIOhooanAo55qgsrsukGQI1MTu3oB31Ga0jL91T18znwJ0iUkx0KAHKO815GfOaYgZWsQC0RxHebB1SkDAnZZNvnsrLbyVTQEqjDOAFEoDj00QBQKDzRAFAoPNEAUCg80QBQKDzRAFAoPKDDOIzCYnS8WVCgUCoVCoVAoFAqFQqFQKBQKhUKhUCgUCoVCoVAoFAqFQqFQDBZZ9v9guc8RIc3mBQAAAABJRU5ErkJggg==">
							</center>
					<br><br>
						<div class="panel panel-default">
							<div class="panel-heading">Resultado.</div>
						  	<div class="panel-body">
						  		<table class="table" style="font-size: 13px">
						  			<tr>
						  				<td><strong>Nome:</strong></td>
						  				<td colspan="2">${res.dados.nome}</td>
						  				<td><strong>CPF: </strong>${res.dados.cpf}</td>
						  				<td colspan="1"><strong>Data cadastro:${res.dados.data_cad}</td>
						  				<td colspan="1"><strong>Data alteraçao:${res.dados.data_alt}</td>
						  			</tr>
						  			<tr>
						  				<td><strong>Sexo:</strong></td>
						  				<td>${res.dados.sexo}</td>
						  				<td><strong>Nascimento:</strong></td>
						  				<td>${res.dados.nascimento} - ${res.dados.idade} anos</td>
						  				<td><strong>Signo:</strong></td>
						  				<td>${res.dados.signo}</td>					  				
						  			</tr>
						  			<tr>
						  				<td><strong>Escolaridade:</strong></td>
						  				<td>${res.dados.escolaridade}</td>
						  				<td><strong>Estado civil:</strong></td>
						  				<td>${res.dados.estado_civil}</td>
						  				<td><strong>Profissao: </strong>${res.dados.profissao}</td>
						  				<td><strong>Renda: </strong>${res.dados.renda}</td>					  				
						  			</tr>
	 					  		</table>
						  	</div>
				</div>`;
				

				if(res.dados.email) {
				result += `
						<div class="panel panel-default">
							<div class="panel-heading">Emails.</div>
						  	<div class="panel-body">
	 					  		<table class="table" style="font-size: 13px">
	 					  			<tr>
	 					  				<td><strong>Email</strong></td>
	 					  			</tr>
	 					  			<tbody>
		 				  		<tr>
		 				  			<td>${res.dados.email}</td>
		 				  		</tr>`;

	 				result += 	`</tbody>
	 					  		</table>
						  	</div>
					</div>`;
				}

				if(res.telefones.length > 0){
					result += `
					<div class="panel panel-default">
						<div class="panel-heading">Telefones.</div>
							<div class="panel-body">
	 					  		<table class="table" style="font-size: 13px" id="OriginalResTelefonesFixos">
	 					  			<tr>
	 					  				<td><strong>Telefone</strong></td>
	 					  			</tr>
	 					  		<tbody>	 					  		
					`;

					$.each(res.telefones , function(index, val) {
						 result += `
		 				  		<tr>
		 				  			<td>(${val['ddd']}) ${val['numero']}</td>
		 				  		</tr>
		            	`;
		            });
		            result += `
		 						</tbody>
	 						</table>
						</div>
					</div>

		            `;
		       	}

		        if(res.enderecos.length > 0){
		        	result += `
						<div class="panel panel-default">
							<div class="panel-heading">Enderecos.</div>
						  	<div class="panel-body">
	 					  		<table class="table" style="font-size: 13px" id="OriginalResEnderecos">
	 					  			<tr>
	 					  				<td><strong>Logradouro</strong></td>
	 					  				<td><strong>Bairro</strong></td>
	 					  				<td><strong>Cidade</strong></td>
	 					  				<td><strong>Uf</strong></td>
	 					  				<td><strong>Cep</strong></td>
	 					  			</tr>
	 					  			<tbody>
		        	`;
			    	$.each(res.enderecos , function(index3, val3) {
			         	result += `
		 				  		<tr>
		 				  			<td>${val3['logradouro']}</td>
		 				  			<td>${val3['bairro']}</td>
		 					  		<td>${val3['cidade']}</td>
		 					  		<td>${val3['uf']}</td>
		 				 			<td>${val3['cep']}</td>
		 				 		</tr>
			            	`;
			        });
			        result += `
	 					  		</tbody>
	 					  		</table>
						  	</div>
						</div>
			        `;
		       	}

				result += `

						<center>
	 					  		<table>
	 					  			<tr>
	 					  				<td style="padding:5px">
	 					  					<button type="button" class=" btn btn-default" onclick="voltarOriginal();">
												<span>Voltar</span>
											</button>
										</td>
	 					  				<td>
	 					  					<button type="button" class=" btn btn-default" onclick="main();">
												<span>Nova consulta</span>
											</button>
										</td>
	 					  			</tr>
	 					  		</table>
	 					</center>

					</div>
					<div class="col-lg-1"></div>
				</div>
					`;

				$("#resultadoOriginal").html(result);

				$("#resultadoOriginal").show();
				$("#layOriginal").hide();
				$('#resultOrinal').hide();
				$("#loading").hide();

	    }else if(res.dados.cnpj){
			$("#resultadoOriginal").hide();
			$("#layOriginal").hide();
			$('#resultOrinal').hide();

			var result = `
				<div class="row">
				<div class="col-lg-1"></div>
				<div class="col-lg-10">
							<center>
								<img style="margin-bottom:10px; margin-top:20px" src=" data:image/png;base64,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">
							</center>

					<br><br>
					<div class="panel panel-default">
						<div class="panel-heading">Resultado.</div>
					  	<div class="panel-body">
					  		<table class="table" style="font-size: 13px">
					  			<tr>
					  				<td><strong>CNPJ:</strong></td>
					  				<td>${res.dados.cnpj}</td>
					  				<td><strong>Data Abertura:</strong></td>
					  				<td>${res.dados.data_abertura}</td>
					  			</tr>
					  			<tr>
					  				<td><strong>Razao Social:</strong></td>
					  				<td colspan="2">${res.dados.razao_social}</td>
					  				<td colspan="4"><strong style="margin-left:8px;">Nome Fantasia: </strong> ${res.dados.nome_fantasia}</td>
					  			</tr>
 					  		</table>
					  	</div>
			</div>`;
			

			if(res.telefones.length > 0){
				result += `
				<div class="panel panel-default">
					<div class="panel-heading">Telefones fixo.</div>
						<div class="panel-body">
 					  		<table class="table" style="font-size: 13px" id="OriginalResTelefonesFixos">
 					  			<tr>
 					  				<td><strong>Telefone</strong></td>
 					  			</tr>
 					  		<tbody>	 					  		
				`;

				$.each(res.telefones , function(index, val) {
					 result += `
	 				  		<tr>
	 				  			<td>(${val['ddd']}) ${val['numero']}</td>
	 				  		</tr>
	            	`;
	            });
	            result += `
	 						</tbody>
 						</table>
					</div>
				</div>

	            `;
	       	}


	        if(res.enderecos.length > 0){
	        	result += `
					<div class="panel panel-default">
						<div class="panel-heading">Enderecos.</div>
					  	<div class="panel-body">
 					  		<table class="table" style="font-size: 13px" id="OriginalResEnderecos">
 					  			<tr>
 					  				<td><strong>Logradouro</strong></td>
 					  				<td><strong>Bairro</strong></td>
 					  				<td><strong>Cidade</strong></td>
 					  				<td><strong>Uf</strong></td>
 					  				<td><strong>Cep</strong></td>
 					  			</tr>
 					  			<tbody>
	        	`;
		    	$.each(res.enderecos , function(index3, val3) {
		         	result += `
	 				  		<tr>
	 				  			<td>${val3['logradouro']}</td>
	 				  			<td>${val3['bairro']}</td>
	 					  		<td>${val3['cidade']}</td>
	 					  		<td>${val3['uf']}</td>
	 				 			<td>${val3['cep']}</td>
	 				 		</tr>
		            	`;
		        });
		        result += `
 					  		</tbody>
 					  		</table>
					  	</div>
					</div>
		        `;
	       	}

			result += `

					<center>
 					  		<table>
 					  			<tr>
 					  				<td style="padding:5px">
 					  					<button type="button" class=" btn btn-default" onclick="voltarOriginal();">
											<span>Voltar</span>
										</button>
									</td>
 					  				<td>
 					  					<button type="button" class=" btn btn-default" onclick="main();">
											<span>Nova consulta</span>
										</button>
									</td>
 					  			</tr>
 					  		</table>
 					</center>

				</div>
				<div class="col-lg-1"></div>
			</div>
					`;

				$("#resultadoOriginal").html(result);

				$("#resultadoOriginal").show();
				$("#layOriginal").hide();
				$('#resultOrinal').hide();
				$("#loading").hide();

		    }else{
		    	alert('Nada encontrado.');
		    }

	    })
	    .fail(function() {
	    	alert('Ocorreu um erro, tente novamente em breve...');
	    	$("#loading").hide();
            $("#resultOrinal").hide();
	    });

	

}

function voltarOriginal() {
	$("#resultadoOriginal").hide();
	$("#layOriginal").show();
	$("#resultOrinal").show();
}

function PesquisarZip() {
//    var token = getCookie('token');
//    headers: {"Authorization": "Bearer " + token}        
	$("#resultOrinal").hide();
	$("#loading").show();

	var dados = $(".appOriginal #dados").val();
	var data = $("#frmPesOriginal").serialize();

	if(data.length < 1) {
		return;
	} else{

	$.ajax({
	    method : "POST",
	    url : './zipcode.php',
	    data: data,
	    timeout: 8000,
	})
	.done(function(res) {
		
		if(res.dados){
				if(res.dados.cpf){
					///cpf?
					$("#resultadoOriginal").hide();
					$("#layOriginal").hide();
					$('#resultOrinal').hide();

					var result = `
						<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">

							<center>
								<img style="margin-bottom:10px; margin-top:20px" src=" data:image/png;base64,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">
							</center>

						<br><br>
						<div class="panel panel-default">
							<div class="panel-heading">Resultado.</div>
						  	<div class="panel-body">
						  		<table class="table" style="font-size: 13px">
						  			<tr>
						  				<td><strong>Nome:</strong></td>
						  				<td colspan="2">${res.dados.nome}</td>
						  				<td><strong>CPF:</strong></td>
						  				<td colspan="1">${res.dados.cpf}</td>
						  				<td colspan="1"></td>
						  			</tr>
						  			<tr>
						  				<td><strong>Sexo:</strong></td>
						  				<td>${res.dados.sexo}</td>

						  				<td><strong>Nascimento:</strong></td>
						  				<td>${res.dados.nascimento} - ${res.dados.idade} anos</td>
						  				<td><strong>Signo:</strong></td>
						  				<td>${res.dados.signo}</td>					  				
						  			</tr>

	 					  		</table>
						  	</div>
				</div>`;
				

				if(res.dados.email) {
				result += `
						<div class="panel panel-default">
							<div class="panel-heading">Emails.</div>
						  	<div class="panel-body">
	 					  		<table class="table" style="font-size: 13px">
	 					  			<tr>
	 					  				<td><strong>Email</strong></td>
	 					  			</tr>
	 					  			<tbody>
		 				  		<tr>
		 				  			<td>${res.dados.email}</td>
		 				  		</tr>`;

	 				result += 	`</tbody>
	 					  		</table>
						  	</div>
					</div>`;
				}

				if(res.telefones.length > 0){
					result += `
					<div class="panel panel-default">
						<div class="panel-heading">Telefones.</div>
							<div class="panel-body">
	 					  		<table class="table" style="font-size: 13px" id="OriginalResTelefonesFixos">
	 					  			<tr>
	 					  				<td><strong>Telefone</strong></td>
	 					  			</tr>
	 					  		<tbody>	 					  		
					`;

					$.each(res.telefones , function(index, val) {
						 result += `
		 				  		<tr>
		 				  			<td>(${val['ddd']}) ${val['numero']}</td>
		 				  		</tr>
		            	`;
		            });
		            result += `
		 						</tbody>
	 						</table>
						</div>
					</div>

		            `;
		       	}

		        if(res.enderecos.length > 0){
		        	result += `
						<div class="panel panel-default">
							<div class="panel-heading">Enderecos.</div>
						  	<div class="panel-body">
	 					  		<table class="table" style="font-size: 13px" id="OriginalResEnderecos">
	 					  			<tr>
	 					  				<td><strong>Logradouro</strong></td>
	 					  				<td><strong>Bairro</strong></td>
	 					  				<td><strong>Cidade</strong></td>
	 					  				<td><strong>Uf</strong></td>
	 					  				<td><strong>Cep</strong></td>
	 					  			</tr>
	 					  			<tbody>
		        	`;
			    	$.each(res.enderecos , function(index3, val3) {
			         	result += `
		 				  		<tr>
		 				  			<td>${val3['logradouro']}</td>
		 				  			<td>${val3['bairro']}</td>
		 					  		<td>${val3['cidade']}</td>
		 					  		<td>${val3['uf']}</td>
		 				 			<td>${val3['cep']}</td>
		 				 		</tr>
			            	`;
			        });
			        result += `
	 					  		</tbody>
	 					  		</table>
						  	</div>
						</div>
			        `;
		       	}

				result += `

						<center>
	 					  		<table>
	 					  			<tr>
	 					  				<td style="padding:5px">
	 					  					<button type="button" class=" btn btn-default" onclick="voltarOriginal();">
												<span>Voltar</span>
											</button>
										</td>
	 					  				<td>
	 					  					<button type="button" class=" btn btn-default" onclick="main();">
												<span>Nova consulta</span>
											</button>
										</td>
	 					  			</tr>
	 					  		</table>
	 					</center>

					</div>
					<div class="col-lg-1"></div>
				</div>
					`;

				$("#resultadoOriginal").html(result);

				$("#resultadoOriginal").show();
				$("#layOriginal").hide();
				$('#resultOrinal').hide();
				$("#loading").hide();

		    }

		    if(res.dados.cnpj){
				$("#resultadoOriginal").hide();
				$("#layOriginal").hide();
				$('#resultOrinal').hide();

				var result = `
					<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
												<center>
								<img style="margin-bottom:10px; margin-top:20px" src=" data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAB5KSURBVHhe7V1diF3XeT0a3ZmmD6V9KJhSqOlDcB9CDQ2V6YNrU4o98sietpA4hUIKpTYEiknQzNiyrLFmXAcKMc1D/ZAHlVJQKBRDoRHkIepTXGxJI9W2FNs4tmmtsdwE44dU4Kfpt/b9ztU+53777/yfO9+ChTT37rvPOfvsb++19s85mUKhUCgUCoVCoVAoFAqFQqFQKBQKhUKhUCgUCoVCoVAoFAqFQtE7Lm2tPHBpY7Jt8Ul8dvFM9kucRKE4XLj8reV7rmyunLu8uXLg5MbKbaR57eTkXv6ZQrHYeO3kF+66vLF8XgwIL5dfvvpU9qucjUKxeLh8cmXr0ubKp3IAhHlpc3Lj6tbK3ZydQrEYMB6DKrdU6VOJANMgUSwEqsspPy9trLyqBl4xatSVUyFSj/QiH0qhGA+alFMh6uiWYjRoS075CKnFh1cohou25ZSXJydf59NQKIaFLuWUm5N9nR9RDAqQU8FZ8A55ZWPyEp+aQtEvXt9cfqo3OeWhGnZFryApcx9VxL1yxWySJNdewfor6bsQ1bArekFHcooCb3Ifjge5JHwfRzXsii7RtpxC3jgGH84AM+Qw3lL6MNWwKzpAF3Jquoz9C3fxIQt4fXPyuPSbGKphHxh+vp39yv9sZ7/5853sdz4+mx375IXsXvy9/7fZr3OS0aBrOeUDpbtY+l001bD3DATFJ7vZH9zazb5GQfE3Ln6yk32d/n0QAcM/HSz6kFM+oJKrYR8Zbm5nv7y/m93/8fPZN8rBEOROtjbEXqULOYUlKC455YMa9hHhk+3srls72V+JlT+WFFiUx5c4y14BM9u2nMIsO2bb+ZDJUMM+Eny0nX2xUq/hIHohzroXmIcitCynsD6LD1cLdQw7tulyNoq2AP/QZHDk3N/OvsyH6AyQU9DncmVqiBXllA903hfEY0VQDXuLgBknI/6EVMGb4K1vZ7/Nh2oVkBpoTaUK1BTryikf8ASUqoaduMfZKJoGjLVUsW1ipOrW2eyP8+FdDPdCQoVGuEB4moN/yZb4cK1gTHLKBwrAF6XjxxBlwNkomgJGnKRKbRNDvb4KjmAJ9UDIg5M3irHKKRfqGvauzvPQgCruw1KFNiRPglEtTuoFhoZ5PsSZV5O9yNjllA8UkOvS+cRRDXtjQIX1GfNUg22MvpBPzqa8yKLIKR/UsA8A5CF+S6rIhjvZVzhZEui3D87lxYSH4WSVsGhyygc17AMAVdpj5UqcE2ackyXB52lg6DlZEhZZTvmghr1nUKV1tvax3kOCS7ZhNIuTRANLKaqb1giilSY5NcQHtKlh7xkkeR6TKnJdQw15JuZL5CRBQEe3LaeohX5l6JVIDXuP8M1/vPvdbIWTJcM3N8JJnDBrp+os3osg5NRrJ1ce5kMOHmrYe4JZsStUYhAGnpMlwYyMCfmBGAbmZCIOs5zyQQ17T8AwrlSRwaprqLxDvY6RMZVTYahh7wEw4mJFJsJQV5FZ+2ezP5PyA8uz6Sqn4qGGvSf49n6kzltgD4iUT057x6HKqXSoYe8BPh8CxkotM+nomZXPh3hVTtWDGnYLWN+EVjdnG1tZcQxfxTYk7/DZt7Nf458UABmGnkb8ncX9M9nvNymnrmytHFzdWi7w8tbkOsmph/jUFhJ+w049Mn2PdJCVwnKc8Rt2s6tvJ1vzrY6FzsdMd52hWBuhXiSnWYw4HRo+hqCIWeoO/vRM9vdNyKmrFBRvPjM5ePvZEk8d/fynp5f+jcrlm7Nl+TUmOocOMt3bUvmUvRZWBpTTjNawQ7/7/IBIavlRueuuksXvYyt7CqnX23339NGfoGKXb1QK8fvrUmAQ3z299NZHz2enpOPvP5/9RdXh6iHDGPaNyfvlcuKvZ8A7DstpRmfYIV0gYaQbHEtUhLotptlVmBqgDt58Ptt477mlH6ICX32apM/cTYrnG/T7clCA7zy79LMPzxz5B+n4c6ReD1KSL3UhIBl27Gvnrw1cPc1oDDtaN5+USuK0N6nVWiJYvXs6IvjBmewcVd7P3j41ObjWRnCQnHrv9JEfQE5Jx3cR14VGgC91IYDBiLlyO7myBWkFKeWbXBy8YcfeiKA5TmUDQQJf45vLcJHl1Dt5Rd6rKauk4GA5tS0dP4ZojFyDDWOEkVCLOMPe6kMSKEiaaCkxWBDTm9hyCkTFxgiTcEOieW2rGBxJcipAyNG6nm1IcMuoMAdr2GNaaA4gLEc/hiFe/Iu/YwILq3T5ULWAioRAMSNWgj/54MyRf4Scuk5y6r8QGMJNSCYF1yw4PHIKwYuZeYzmmd6YR9bK6SRiYIMvcfRwGfY4DtCw880Ub1xOTM65hnB5MaBzo1PONh61g2MjWH/y9NIfXt1a/nEjAVFiPozrklNoIBC0fEpzgBmPCRRXL0uG/mXip5Tmwgfb43hi4ULNsNMNdg+nkjyKHY0KPQURvRQnbQxYO1Vn0VyIkGbUI/2vS06h14idLMWwuZQH8/v7O9lNCoTrVI4zs0p/Y57nICflMZqX+IuGPZKDMeyhR+yktvomSIR8cjY5ajNtpdpdO/XG00vfdY5OVfBWkGBCXrtU+T+nfw8+3s0OKFBmT0j/aCd73A4Q4mjWLy2EYYdeLt2sGav6Bl+PVHVfuQ2ztKHG+p84Ti7gBvseQVTVNwje6VQpCG5wUrO6GQHDn3/68XZ2Nz6/eTZ7iv6+jc/oPAa7Mnj0ht1XAfDwNU6WBJ+ngRbnZMmA+TNyqnqrFCaZS3t5hDPYqfeoOtFHv5f23V/kIEAvUnhQwwd03be2s9mLb+i498zSTjkLqKFh9IYdQ4zCzTKsWgHwOyk/EBWOkyWhCzmF4LOXopvBB4enqnodAI8AzuVJ3I5pQMyeGStAqIfZ568GiVEbdte8AmQAJ6kEKU8Qx+MkUehKTuUrTm3AX0jXANYZcOB8MRr2A+J/EmfrtsoBgvPCLDTkHn9kQGm38wC5uZOt88eDRR3DTvcn+Nq41uCbeOMklSDobMPYAOlETqFHotaNDzkHX4DUkYo3d7PfoAB7f9YDnM1+Vs53+tyt0rsCN5bP2z3cmDBaw+4z1H1JrD7klATfdUCacrJk/PcZ8mgcHFaQbHDeDyKNewPXeHfh1THsKe9YbBRosewbb7PqxB71Hs7xfl/L26eccsHXw1ZdQ4XRL/r9W7MAOZtdy/PEKB8GCeRzn7L8tEUYeBh7mHn+aJCoY9ix0aoXw+4d5q1oRKHPpfxAaZh3CHLKBV8DQjzGyaJheiU2/lRO/0r8ntV7mD3yGN6Ur2HGvbz3Q2BYPdGNoW/KCgW/j3ivI2fTHXw6G/QtoZDA7ywX8wLLrS5V3PuGIKdc8PWGqOipvQj9zv0gbfJtGDmblolwLRZzybG/Yw0PE4c8J5JjdIbd1+KDsfMhZv7DMSwKUmtcmHg0vYZYCE0xTU5JQIV1DTiA8CKxQcLSyv79LpX9OfrXrO+yH0FE5+9/PTQFPiSH+b0VIPZ8yVCB8x6VYfdN7OXEzXMtVsTnlCZpsWK7wVFNTrkgVOwCSYo+gZ4GwcQ/KcD00vOPVJ0uL0HFPpv9ghqWv7MHRaKkyMbyeSxeRJCgJ8HsOv988MAmKvGaItiLYUfrXrqBc0RFoH8rLXdHBeFD1Xy9sIc15ZQLaAB8Zj0nehoOJpSLoad3Lkqjs9l3+HAzxEiRob0eIRbsO29I1xRiL4bdNo9NE5Ur731M99qK56gvp3wws9fNls8/zwLkLAXIC9mf8qFmiJQiM8PeNcxKamylrRikozPs1Pp5H7RWiZSfPbLS/GM9m5VTPvhG/Cry+9RzX6J/nZIhRoo0JTkwmYeKN+2JVz7FvIUr+DDSVnzGFdZNpS9Rj+kl3ezDsCNI5JuZTEgvSDHOmrvV5t7jBzmFVoyz7wRNBgl6VvgTztqAfMQWfbdNPbrpDaOkCBt2k0EJ+D0HGWblL6KBksrMLGmR7g35HE4yAxqkuXTEKtInspd0sZ8ZdrPE2rOIMYo72Vds0wk06D0utimnQkD5+Ea2YgjPVy4f+ny2voo4W9oea9hNJhZMcMkz8nvlIPG15OVl5/SZc4QN+XCyaIzOsAMYkYHhjDLgFo1R3c6+LI3ooMWXLjKek/3yc5b6gvFsGLBIlKRoeFxzS/T9BStACosQfRU4Z9kL+JZ2lDW8v2cvLjsPzYYjoDlpFKJ6SQer9FqNAhXdTP6FHiRH34fmS9DKSRcZQwRX13IqBmaEi2RXcJRrJ1uDfOWfiTDyioMDS9ht7xYpRQqGnf4uLnac4x0NjyCQ0+S8swbM+BQxzZSo7PZ5xGB0ht0FTIrBV+QsywQf6GICN0xkr3IqFXXKBzBbbC0PYgNyQiifAm3JQZU+tK5tpuERAML3BeYmHD2V9H2BJJtMxgmI6SVdXIinxNOFJAcIeg7++aGHMdwe/W9oGfbp+06ENBbzgIrtoZAWCFZmz8CBC5HnIBLnw9mMF5VaCBTYiHqQthHVerNhj9H2toaPMcu5YY+pzFUqbR3DPvpeJEYiyJxc4CwUhBgvlxv2GG2fa/g2AqpLw44hbM5mnECESxcWxY4mA8eASCkyM+xxPffUsDcfUJ0a9v52HjYFXETpoiI52U8t6EVGimGPDSiTMaHpgOrSsPPPxwv0BNKFxZAKTQ07A40FlUmCYQ/LocEZdimvAPnn4wZdSJXhXjXsJfRt2POAihhOTjLs6J2qvlSVsxg3jBcJt1AOqmG30bRhtwMqbv94/MrskGHHRHDMfIyLCHDOavyotapXDfsMsXIo928x2j4PqDpyWCJ6MJePnF8dXInjN+k5phq66r4QNew22jDsKQGVxJJhryOnyhzEMC/WB9lLKVzbcGNQZ3Uv3bhBGnYsX7fLJ/WhDlUwbWzaMew1H/g2Tz6PunJKYi8ThVhLhP3otzwPmDNLv3eytdQnoAB0YaM27GggsEjTbFn2rOzF1lukc+1br4umDfusIlOANCB9ytxrIc+LpiC6Am483fSo14fZzJe7czZBjNWwm1W8eNdH4nJ3bB9IKZ8UNG7YK0vgjmmCucPeA8uyTa8g3OBYYt+DvVzbh7EZdjydpW75mO0Bpd2EsTCyh2QSZJC9BQAtfkTL3J6/6IslX9MqzN4P6YZWIbWuoT0QwFRDj8Owo/UXr7UCTW8S+fo2YFpORd1uAuLkZPZA8BYM+6DZ6V4Qsx89UTLEMMabjMGw07UEn/2VSmlfugvOntZIjDtzDPRZo4Z9qMSOSXPBXcA83KyF4DCkfGMqAV30YA27aTyka2uAkKMh825Gfbyt/WQ/l1v0/+CjS3PDHtPjDI+T/dxLdYaoB8fBgO9m90OGYQgT/+LvKD1OmpsP5cRQDTtG8mKukR90cQweBeWDrbhmoCOu4fE+CNv4DvG679CeBwhti51yJCY8J9UNqIUuJbVBzKNHQyMv5nE4gYpgP3rUhSEadjQC0vXkRPAgIDj5HKJGBKnsfNtzjV+QrrnEfDQn0rCPiO0+GNALz+Mxp8+djajYAEatfEGCuRRO6sTQDDukD8pAuh4QvUbsvvOQwbcfXi2BrjEoQTErzclHKp/KpLrQ59IizPRKNytnbHDkCL0nPWbUZkiGnXoH98uAKHBSh2p9vRF6Ik4mAhVFuuY5WqNa9HfF/Tc9sy85VYbvSYExLb4En5/B8TiZF1RIgzDs1Kq735NeYcIPvY2vlw01IEZqSNddYKJhHxx7lFNl+CpAau+RwzeXguNxMi+GYtjZeIvXUnWiL9CLfImTiUDFiSmXdMM+DNrnPQigl5BuFFh1ISJ+52olUeE4WRBDMOzSNRhGjMq5AEMv5klE8HAyJyA9xGsucZyGfWArtX1PBOQkleAaFsXxOEkQQzDs0jWAsT2hBJ/vw2gXJ3MitlzGatgH1Yu4AiSlIkuQ8gRT8+3bsEvXAGLkj5Mkw0zKCnmCMQECLLRhJwnZ6eJDH3waO3b4sgxjRIX8wCrGnwqtN8PehFQsg2SUb1bevCc9BvBa4nUXOFrD3u3ydRd8E1ghw+iCd2QssoW00adhd3q0wMSeD/R755tuY0f5gEU37IN4kr939W4FI2om1jzLMlIqgI2+DLt3lK9CsAfLJ3KLQI7YclHDXhGhicLUCh2aLa46NNqXYQ8tw0mt0N6A282eSN1xWMWw67BvIrBdVrphhiQlYrfS+qQVSC1u4T3pqejDsIdafFTq2CAJremKGeKVEFsu5oU6WN5eWa72wCEY9lArCeLmuTQ3m3Knrs5ZdeLRBhXaj+YKMYY1CjpUsdGIQKq6Wn/Me/jWuxnW8DQAXWO1gYxxsH/D7u1FctJNZFM/ew+4TzIUaL0nvQ5eO7n0u1c3l//vjWeWD64/Mzl4+9kST00OrhPfpO+vbjVT0KFeZEYqHy7HvHzwDnnnRGyJ3uXuIdQbyBg+ezfs5iEEnknDOoQMqdM65sA6JbTE750+cnEuMDy89vRy7YKO6WWrss6cio1aAxmD5wAMe2i5eiVSfin7riWYFtwajqYK9c13nl36TAoGF29Qr7JnepTJzaoFTcdufMsteqYmGg+g3kDG8DkIww69jBZfupnJRHBEPLTBB+NvduZfIPrBmeycFAghQnZd2Tj6Hc4+GXTsxoIEk41NP1iuzkDG4DkEww64KmUKob3r3vyQ7Hv39NF3pCDwknoSeBh4GT5MMhD0dRsReLfUId0QzMRh1Oz6qDmMGXbcPMxpRJlTi5z+WBM3PzTyQ73d7tunjn4uBkKAVzZX/oMPUwloRIzsS5Sk6DWqPIHSB0grs8J3gU26zd4NexkYwgyNxuB731BnKkJzKjnfe27ph/AXbz0zHb1CDyEFRJkYAXt98+hX+XCVgUBBQxIa4ECP4du3XhXTRYuL6ztkDmxJvA1UCNzonE1raMBIvEDLjJ4KI0s/Op0tX948+pFdgDDjCBopMGxee+boraYLGgMddvk0LaNyHBI55eQgDHtfCE3MQdrYm7kub0welQrxjaeXvT3KDWIdw94HDpuccnIohr0P+OSKa7kKtab/LhWkCZJSYNjcM4Z9HAV9OOWUl8Mw7F0CcyZSYIAYOYL84qQFXP5W9kVqVX5RLsQrkFtCYOREAA29oA+7nPJxcIa9bQRWA3uXY5D0eEEqxKtb7l4EZh1phljQKqfCpPK5wcV1OODzH6HFjpJhN6ReRAqOnNN0wxoZUTkVJpbt5w/hPjTwLX50ySsbLsPuG9XK0wxhZETlVBT3qIzu4yI7XIAJl4IDjB0ypcKbM+wxAdLnyEg3cmrcPRJ2QubvNjm0sBcllhm76FEy7FJg5LTTETs37F3IKQSfeYWC6aHGt3fkUMopCRQIzsWAtxIeImEbdixQlAIDxAiXfSPArgx7R3LqIo7Dh5wBPaVZHr8xeV/4zWAIE975u0CGDN/Dr11zIBJsw+6bC8ESlfJNQWvepmHvSk7FBjoCCGnNOSGgBjBqNn21XIfvHhwLfI8tBbHei5MGAcOOZSe+2fRrW3c2U9lsy7B3Kaf4kJUwC5qNybbpaaayjIKngx5nY/m8yikPfKt4MVkYu/4LwfbO6aU9KTAMKXAwBCzfpGYNe59yqi2gJ6RjNva0RpVTkQhub8VGrMCrB8yejR3z5ifnkvg3RXlVYG3DPjQ51TRQoeVziqfKqQoI7QUBeQn+MQQDnreF1bNmJr70AAosiZcC5Ipws8qsU/HGIqfqApJIOrcoqpyqBvNAu8TNSC5Ke9h5DVYE0w37IsopH1DBU3tIlVMNIPQ6txR+eObI9/LgiJBWBcYa9kWXUz7Evl5B5VTDCCxeTOK7p5fewq5DrPCVbp6TEYb9sMgpF2IMO53/KyqnWoAx7Q3IrQ+fO/K1Gq27aNi7kFN4ru4Y9qy4DDvk1GsnVyq/cEgRAXgS3zotH/GgBBh55GMkkHATY2hLm67klP0CnDGgYNhRNiSnUj2cogZQ0cujVC5ilKu8PGUqBapKoalh70JOwfcMVU75kBt2lVM9Ayt7eb7EPAcXw8K8l+QYZtt9S+OnFVyumGG27DNGIqd80MBYAFBFH9iei/HJKcUCw5jrVv1DPMcqpxQLjjqGvQkugpxSLDDqGfY6VDmlGAnqGfZ0qpxSjA5dGHaVU4rRok3DjrVHlzYmT/KhFIpxAp5AquD1uPxyX3Lq0UdX71tfe/gB8LETq1vra8e3k3ni+Hqex/Hjx3Vuoys8duL4S8SL/XFVXE2KUa1/+uvfOzjz5w/MKFd8PyGnSLZ1+tymx9ZWH6drO0d8nyr2QUu8TTyPY62vr6uPaguopKWC75SoSHwqc9j46h/92E4rBYCLfcip9UceuXf9xOq+fc5d0dXQKGpiyAGC7+y0UiDMkfxLH6NTCA5qzT+1z3fGteOvopxnXFt9ZU5COUjp53p4VxDSd86yVFSEafVY27ZJIzvmK9BtfM6nMge0inml+Ms/eWgPDywzm3ykwNhc2YMs62PtETyBcG3ncd2cpHGsrz98t1ima8df5CSKsUCWHqv7MK+cJAnoHbDfIWffcxnGeFvXRgHdmbRDcFJQ3JgdmwLm/vvv1yXtYwFaObpxMJRWBVrdQwvISUYPCoiZGce18cedgct4Vr7rjz6sKwPGAKo4LxVu3JTnF6mFM0O49vWtrXb+QGeUZ1FqrV7grxRDBIYd6Ya9Uqg4YGLlod+s24aVP54D8p2ls1pPY5yn8of8wB0ZIhEVDF6H8noZLXJsEM+13i36Dh9Mrzw7h+Pii2xmZVQqJwDXi8/QqKEcigFX4nTQ4VxKOSkYJ048dA9ukF2gKOxHH3kkeR80boKdD388B0pnSRyq5CYwao/O3aY8XgrNMZjgtH/Xk3REr5GfA8qbPy7APk+UDz4zvQ+CwhcQflI56RBzFHi0qjyqcgNBw0mSQDeuSoC8X+NmC1zd950/KlchfU+TduWyks7D/p7SX0QwlxuzqkR+2pt4MNeSotAgs2pUmPJN54/nQOlcM9a3IZno3/XQiBlGg9DLQX6U8zN/O3qG2HNsG3TeL9rnIZ2v/T2dN8nJ46/OPqNAoc+eRCPnWsoyDSgslzGNQmHgZZpH9/5r8OAuuth6mcKqPx4fW/ko3XyA0M2vumbJ6HHodCs/BDt/XUDsObaN8vmGAiQnnf/FKvLXzP3M3ffVfe1FLPAY/J1WaErv5F8KqgfI6n7V4LBBeZ238r0t5TnmADHlVqOHNw1JeX6rp0GKwWE6vFksHFPgZJA5SW1UDpCGZpOnE5x2vvMSYswB0kRlLktrNewE9BBUGKXJP5i+Zg1q1QCpOkMvwTb8OB/+eIYRB8ht/rgWyo2IVEaHClQA85N/ZIT560YRW/koXSFA+ONGYEtIaZZ8tAHimCtJBY5TyJdkKX91uIDegSTVbKydibmC1tYdVQuQ1X3+uBFQ3rP5FByHP54h9hzbRmqA4Lr449poK9/RQJr8Q0VsUspIiK18qLh5GvyfP24E9jlAbvHHM8SeY9vQAOkJGAK0dfi0EFb3mhglCiG28lG6TgJEOofYc2wbGiA9oDxCwexssWFs5aN0h74HofMozehrgLSG6fh2YQ5gyo5nSmMrH6XrzYOUW+4uelYJMWVlf4/r4o9ro618Bwlp8s9IrB4mgGJuOoCKG5OuCnDD83wdo1hP2sduch4oBfZ5uhoJ+zyRnj+ujbbyHRykyT9jzoXuugtQYVcKkC7nQcz6LevYfc0km/s0O4fjr/LHBdjnqQGSCOwFoAssTv7VXGxYF1UDBLKHv6oFM3pXyHdeYpbT0LlEvWS0SZhe3zoHojgXYafRAEkAbqp9kYYNVbI6oPOqFiDoBRsI7NLxxbVYACqFfeyuF+xheYd1ns5ezE6Dc+aPa6OtfHsHKlHx5hqiF1nnJL2iVEETAmR6o+oEyfwaI3fPQD1tcVchJlQ76nlxbFsGQmrxV3OwzxHlwx/XRlv59o6Cbs0vMOGZTY3R4XGosCsHCGgqztrqy/AJoU1b6B1c+0HoM/Jh7gqPHgMGvvAb9GLTPRrrTY9sGa9IAWzuVeGY5pqdK6kL6TRAwrAvrFc6JEGlAMEI3PwS/Mo0FT9ikIKXfpeX4nTJ26F9HXZ6DZAI2BfWKxsMENwgU1nRE9jSI5HIE9qeDxGFaU9Sa393FUISn48ZXrZ/h3Lij2ujrXx7ByrRIOhooanAo55qgsrsukGQI1MTu3oB31Ga0jL91T18znwJ0iUkx0KAHKO815GfOaYgZWsQC0RxHebB1SkDAnZZNvnsrLbyVTQEqjDOAFEoDj00QBQKDzRAFAoPNEAUCg80QBQKDzRAFAoPKDDOIzCYnS8WVCgUCoVCoVAoFAqFQqFQKBQKhUKhUCgUCoVCoVAoFAqFQqFQDBZZ9v9guc8RIc3mBQAAAABJRU5ErkJggg==">
							</center>

						<br><br>
						<div class="panel panel-default">
							<div class="panel-heading">Resultado.</div>
						  	<div class="panel-body">
						  		<table class="table" style="font-size: 13px">
						  			<tr>
						  				<td><strong>CNPJ:</strong></td>
						  				<td>${res.dados.cnpj}</td>
						  				<td><strong>Data Abertura:</strong></td>
						  				<td>${res.dados.data_abertura}</td>
						  			</tr>
						  			<tr>
						  				<td><strong>Nome:</strong></td>
						  				<td colspan="2">${res.dados.razao_social}</td>
						  				<td colspan="4"><strong style="margin-left:8px;">Nome Fantasia: </strong> ${res.dados.nome_fantasia}</td>
						  			</tr>
	 					  		</table>
						  	</div>
				</div>`;

				if(res.telefones.length > 0){
					result += `
					<div class="panel panel-default">
						<div class="panel-heading">Telefones fixo.</div>
							<div class="panel-body">
	 					  		<table class="table" style="font-size: 13px" id="OriginalResTelefonesFixos">
	 					  			<tr>
	 					  				<td><strong>Telefone</strong></td>
	 					  			</tr>
	 					  		<tbody>	 					  		
					`;

					$.each(res.telefones , function(index, val) {
						 result += `
		 				  		<tr>
		 				  			<td>(${val['ddd']}) ${val['numero']}</td>
		 				  		</tr>
		            	`;
		            });
		            result += `
		 						</tbody>
	 						</table>
						</div>
					</div>

		            `;
		       	}

		        if(res.enderecos.length > 0){
		        	result += `
						<div class="panel panel-default">
							<div class="panel-heading">Enderecos.</div>
						  	<div class="panel-body">
	 					  		<table class="table" style="font-size: 13px" id="OriginalResEnderecos">
	 					  			<tr>
	 					  				<td><strong>Logradouro</strong></td>
	 					  				<td><strong>Bairro</strong></td>
	 					  				<td><strong>Cidade</strong></td>
	 					  				<td><strong>Uf</strong></td>
	 					  				<td><strong>Cep</strong></td>
	 					  			</tr>
	 					  			<tbody>
		        	`;
			    	$.each(res.enderecos , function(index3, val3) {
			         	result += `
		 				  		<tr>
		 				  			<td>${val3['logradouro']}</td>
		 				  			<td>${val3['bairro']}</td>
		 					  		<td>${val3['cidade']}</td>
		 					  		<td>${val3['uf']}</td>
		 				 			<td>${val3['cep']}</td>
		 				 		</tr>
			            	`;
			        });
			        result += `
	 					  		</tbody>
	 					  		</table>
						  	</div>
						</div>
			        `;
		       	}

				result += `

						<center>
	 					  		<table>
	 					  			<tr>
	 					  				<td style="padding:5px">
	 					  					<button type="button" class=" btn btn-default" onclick="voltarOriginal();">
												<span>Voltar</span>
											</button>
										</td>
	 					  				<td>
	 					  					<button type="button" class=" btn btn-default" onclick="main();">
												<span>Nova consulta</span>
											</button>
										</td>
	 					  			</tr>
	 					  		</table>
	 					</center>

					</div>
					<div class="col-lg-1"></div>
				</div>
					`;

				$("#resultadoOriginal").html(result);

				$("#resultadoOriginal").show();
				$("#layOriginal").hide();
				$('#resultOrinal').hide();
				$("#loading").hide();

		   	 }
			}
			
			else{

			$("#resultadoOriginal").hide();
			$("#layOriginal").show();
			$('#resultOrinal').hide();
			$("#loading").hide();

		    	if(res.length > 0) {

		            $('#resultOrinal tbody').html("");

		            $.each(res , function(index, val) {

						var row = `<tr>
							            <th><a href="javascript:void(0)" onclick="abrirOriginal('${val['id']}', '${val['tipo']}');">${val['doc']}</a></th>
							            <td>${val['nome']}</td>
							            <td>${val['logradouro']}</td>
							            <td>${val['cidade']}</td>
							            <td>${val['uf']}</td>
							       </tr>`;

		                $('#resultOrinal tbody').append($(row));
		            });
		            $("#resultOrinal").show();
		    	}			
		    	return;

			}

		  	$("#loading").hide();


	    })
	    .fail(function() {
	    	alert('Ocorreu um erro, tente novamente em breve...');
	    	$("#loading").hide();
            $("#resultOrinal").hide();
	    });

	}
}


</script>
</head>
<body onload="main();">
	<div class="container-fluid">
		<div class="appOriginal">
			<div id="resultadoOriginal">

		</div>
		<div id="layOriginal">
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					<div class="col-lg-12">
						<div>
							<center>
								<img style="margin-bottom:30px; margin-top:40px" src=" data:image/png;base64,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">
							</center>
						</div>
						<form action="javascript:void(0)" name="frmPesOriginal" id="frmPesOriginal"> 
						<div class="row" id="frmOriginal">

				    	</div>
				    	</form>
					</div>
				</div>
			  	<div class="col-lg-2"></div>
			</div>
		</div>
			<br><br>

			<div class="row" id="loading">
				<center>
					<span>Aguarde....</span>
				</center>
			</div>
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">

					<div class="panel panel-default" id="resultOrinal">
					  <div class="panel-heading">#Resultado</div>
						<table class="table" style="font-size: 12px;">
					        <thead>
					          <tr>
					            <th>Documento</th>
					            <th>Nome</th>
					            <th>Endereço</th>
					            <th>Cidade</th>
					            <th>Uf</th>
					          </tr>
					        </thead>
					        <tbody>
					        </tbody>
					      </table>

					</div>

			  	</div>
			  	<div class="col-lg-2"></div>

			</div>














		</div>
	</div>
</body>
</html>