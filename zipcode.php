<?php

session_start();
header("Content-type: application/json; charset=utf-8");
define('PROXYZIP', '187.32.123.177:3128');#179.97.225.230:3128

//define('PROXYZIP', '170.80.36.12:3128');//'189.76.85.142:60639');#179.97.225.230:3128
define('USUARIO',  'Reg-RJ/ES');
define('SENHA',    '102030@@Aa');

#if($_SERVER['REMOTE_ADDR'] != '189.114.100.97')
#{
#	die('Em manutencao...');
#}

/*
if(!$_GET['token']){
	die('Acesso negado');
}else{
	if($_GET['token'] != 'apizipja2018'){
		die('acesso negado');
	}
}

*/

function getCookies($get)
{
	preg_match_all('/Set-Cookie: (.*);/U',$get,$temp);
	$cookie = $temp[1];
	$cookies = implode('; ',$cookie);
	return $cookies;
}

function curl($link,$cookie,$post=null,$ref=null,$header=false,$xmlhttp=false)
{
	$timeout = 20;
	$ctime   = 20;
	$ch = curl_init();

	
	curl_setopt_array($ch, array(
		CURLOPT_URL            => $link,
		CURLOPT_REFERER        => $ref,
		CURLOPT_HEADER         => $header,
		CURLOPT_COOKIE         => $cookie,
		CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.202 Safari/535.1',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => 0,
		CURLOPT_BINARYTRANSFER => true,
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_VERBOSE        => false,
		CURLOPT_TIMEOUT        => $timeout,
		CURLOPT_CONNECTTIMEOUT => $ctime,
		CURLOPT_ENCODING       => 'GZIP',
	));

	if($xmlhttp != false)
	{
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest"));
	}
	
	curl_setopt($ch, CURLOPT_PROXY, PROXYZIP);

	if(strlen($post) > 2)
	{
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}

	$res = curl_exec($ch);
	curl_close($ch); 
	return ($res);
}

function corta($str, $left, $right) 
{
	$str = substr ( stristr ( $str, $left ), strlen ( $left ) );
	$leftLen = strlen ( stristr ( $str, $right ) );
	$leftLen = $leftLen ? - ($leftLen) : strlen ( $str );
	$str = substr ( $str, 0, $leftLen );
	return $str;
}


function save($string)
{
    $fp = fopen("cczipok.cox", "w+"); 
    $escreve = fwrite($fp, $string);
    fclose($fp);
}

function ler()
{
    $arquivo = fopen('cczipok.cox','r');
    if ($arquivo == false) die('Nao foi possivel abrir o arquivo.');
    $linha = fgets($arquivo);
    return $linha;
    fclose($arquivo);
}

function logar() {
	$usuario = urlencode(USUARIO);
	$senha   = urlencode(SENHA);
	$loga    = curl('https://ziponline.zipcode.com.br/Account/LogOn?ReturnUrl=%2f',null,'Login='.$usuario.'&Senha='.$senha.'&LembrarEmail=false&EntrarAutomaticamente=false&zip_submit_login=Login','https://ziponline.zipcode.com.br/Account/LogOn?ReturnUrl=%2f',true);

	if(stristr($loga, 'cation: /Consultas') || stristr($loga, 'ocation: /Atualizaca'))
	{
		$cookie = getCookies($loga);
		return $cookie;
	}else{
		return false;
	}
}

function test($cookie){
	$loga = curl('https://ziponline.zipcode.com.br/Consultas', $cookie, null, 'https://ziponline.zipcode.com.br/Consultas', true);
	$test = "{$usuario}</li>";
	if(stristr($loga, $test)){
		return true;
	}else{
		return false;
	}
}

function consultDoc($doc, $cookie){
	$url  = 'https://ziponline.zipcode.com.br/Consultas/ConsultaPFPJ';
	$ref  = $url;
	$post = "Documento={$doc}&PessoaFisica=true,false&PessoaJuridica=true,false&Nome=&NomeFantasia=&BuscaSimilares=true,false&Segmento=&DataNascimento=&CEP=&Estado=&cidade=&Logradouro=&Numero=&DDD=&Telefone=";
	$res  = curl($url, $cookie, $post, $ref, true);

	if(stristr($res, 'Dados Principais</h3>')){
		return $res;
	}else{
		return false;
	}
}

function consultDocOk($doc, $cookie) {
	$url  = 'https://ziponline.zipcode.com.br/Consultas/ConsultaPFPJ';
	$ref  = $url;
	$post = "Documento={$doc}&PessoaFisica=true,false&PessoaJuridica=true,false&Nome=&NomeFantasia=&BuscaSimilares=true,false&Segmento=&DataNascimento=&CEP=&Estado=&cidade=&Logradouro=&Numero=&DDD=&Telefone=";
	$res  = curl($url, $cookie, $post, $ref, true);

	if(stristr($res, 'Dados Principais</h3>')){
		$loga = $res;
	}else{
		return false;
	}

$corta_dados_basicos = corta($loga,'form_containt gray1-bg">','title="Perfil 3D"');

##
$corta_nome = corta($corta_dados_basicos,'Nome:','</strong>',$corta_nome);
$corta_nome = strip_tags($corta_nome);
$corta_nome = trim($corta_nome);

##
$corta_cpf = corta($corta_dados_basicos,'CPF: </label><strong>','</strong> <br />',$corta_cpf);
##
$corta_sexo = corta($corta_dados_basicos,'exo: </label> <strong>','</strong>',$corta_sexo);
##
$corta_obito = corta($corta_dados_basicos,'bito em','</strong></span>',$corta_obito);
##
$corta_nasc = corta($corta_dados_basicos,'nto: </label><strong>',' (',$corta_nasc);
$corta_nasc = substr($corta_nasc, 0, 9); 

##Idade
if(!stristr($corta_dados_basicos, 'bito em')){
	$corta_idade = corta($corta_dados_basicos,' (',')</strong>',$corta_idade);
	
	}
else{
	$corta_idade = corta($corta_dados_basicos,'<span><strong>','</strong></span>',$corta_idade);
}
##

$corta_signo = corta($corta_dados_basicos,'no: </label><strong> ','</strong>',$corta_signo);
##EMAILS


$corta_email = corta($corta_dados_basicos,'ail: </label> <a href="mailto:','"><strong>',$corta_email);



##IMPORTANTE##
$codigo_base = corta($corta_dados_basicos,'/Consultas/ListaProfissional?idBase=','"><img class="sprite_icons dados-complementares-blue',$codigo_base);

##extras##
$urlpost_extra = "https://ziponline.zipcode.com.br/Consultas/ListaProfissional?idBase=".$codigo_base."&X-Requested-With=XMLHttpRequest";
$loga_extras    = curl($urlpost_extra , $cookie, null, 'https://ziponline.zipcode.com.br/Consultas/ConsultaPF', true);

##########
if(stristr($loga_extras, 'RG</')){
	$corta_rg = corta($loga_extras,'RG</','</tbody>',$corta_rg);
	$corta_rg = corta($corta_rg,'gray1-bg">','</tr>',$corta_rg);
	$corta_rg = trim($corta_rg);
	}
else{
	$corta_rg = "Nao encontrado";
}

##########
if(stristr($loga_extras, 'E-mails<')){
	$corta_email_extra = corta($loga_extras,'E-mails</th>','<table id="',$corta_email_extra);
	$corta_email_extra = corta($corta_email_extra,'<tbody>','</tbody>',$corta_email_extra);
	$corta_emails_extra_explo = explode('<tr>', $corta_email_extra);
	$emails = array();
	foreach($corta_emails_extra_explo as $value)
	{
		$value = strip_tags($value);
		$value = str_replace(array(' ', "\n", "\t", "\r"), '', $value);
		if(strstr($value, '@')){
			$emails[] = $value;
		}
		
		
	
	}
	
	
	}
	
	
else{
	$emails = "Nao encontrado";
	}

##########
if(stristr($loga_extras, 'Escolaridade<')){
	$corta_escolaridade = corta($loga_extras,'Escolaridade</th>','td>',$corta_escolaridade);
	$corta_escolaridade = corta($corta_escolaridade,'gray1-bg">',' </',$corta_escolaridade);
	$corta_escolaridade = strip_tags($corta_escolaridade);
	}
else{
	$corta_escolaridade = "Nao encontrado";
	}
##########
if(stristr($loga_extras, 'Estado Civil<')){
	$corta_estado_civil = corta($loga_extras,'Estado Civil</th','</tbody>',$corta_estado_civil);
	$corta_estado_civil = corta($corta_estado_civil,'gray1-bg"> ','</tr>',$corta_estado_civil);
	$corta_estado_civil = trim($corta_estado_civil);	
	}
else{
	$corta_estado_civil = "Nao encontrado";
}

##########
if(stristr($loga_extras, 'Atividade profissional<')){
	$corta_ati_profissional = corta($loga_extras,'Atividade profissional</th>','td>',$corta_ati_profissional);
	$corta_ati_profissional = corta($corta_ati_profissional,'gray1-bg">','</',$corta_ati_profissional);
	$corta_ati_profissional = strip_tags($corta_ati_profissional);
	}
else{
	$corta_ati_profissional = "Nao encontrado";
}

##########
if(stristr($loga_extras, 'Faixa de renda presumida<')){
	$corta_renda = corta($loga_extras,'Faixa de renda presumida</th>','</td>',$corta_renda);
	$corta_renda = corta($corta_renda,'1-bg">','</td>',$corta_renda);
	}
else{
	$corta_renda = "Nao encontrado";
}


##########
if(stristr($loga_extras, 'PIS<')){
	$corta_pis = corta($loga_extras,'PIS</th>','td>',$corta_pis);
	$corta_pis = corta($corta_pis,'gray1-bg">','</',$corta_pis);
	$corta_pis = strip_tags($corta_pis);
	$corta_pis = trim($corta_pis);
	}
else{
	$corta_pis = "Nao encontrado";
}



##########situacao na receita federal
$urlpost_receita = "https://ziponline.zipcode.com.br/Consultas/ListaReceitaPF?idBase=".$codigo_base."";
$loga_receita    = curl($urlpost_receita , $cookie, null, 'https://ziponline.zipcode.com.br/Consultas/ConsultaPF', true);

$corta_sitcadast = corta($loga_receita,'o Cadastral: <b>','</b></span>',$corta_sitcadast);

$corta_datcadastcpf = corta($loga_receita,'Data da Inscrição: <b>','</b></span>',$corta_datcadastcpf);

$corta_ult_atua_receita = corta($loga_receita,'</b> do dia <b>','</b> (hora',$corta_ult_atua_receita);
$corta_ult_atua_receita = trim($corta_ult_atua_receita);

######

#####telefones###html tel fixo

$corta_tel_fix = corta($loga,'<h6>FIXO</h6>','<div class="zip_resultados_telefones_listas_col2',$corta_tel_fix);

$corta_tel_fix_explo = explode('numero">', $corta_tel_fix);
$fixos = array();
foreach($corta_tel_fix_explo as $value)
{
	$value = strip_tags($value);
	if(strstr($value, '(')){
		
		$fixos[] = trim($value);
	}
}

#####celular####html cell
$corta_tel_cel = corta($loga,'<h6>CELULAR</h6>','<!-- Telefones sugeridos do documento -->',$corta_tel_cel);
$corta_tel_cel_explo = explode('numero">', $corta_tel_cel);
$cell = array();
foreach($corta_tel_cel_explo as $value)
{
	$value = strip_tags($value);
	$value = substr($value, 0, 15);
	if(strstr($value, '(')){
		
		$cell[] = trim($value);
	}
}
#######Participacao empresas#####

$urlpost_empresa = "https://ziponline.zipcode.com.br/Consultas/ListaQSAEmpresas?idBase=".$codigo_base."";
$loga_empresa    = curl($urlpost_empresa , $cookie, null, 'https://ziponline.zipcode.com.br/Consultas/ConsultaPF', true);



$corta_nome1 = corta($loga_empresa,'<div  id="lightBox_qsa_emp','</table>',$corta_nome1);
$corta_nome1 = corta($corta_nome1,'<tbody>','</tbody>',$corta_nome1);

$corta_empresa_nome = explode('</tr>', $corta_nome1);

$empresas = array();
foreach($corta_empresa_nome as $empresa){
	#echo $empresa;
	$empresa_1 = explode('<td>', $empresa);
	$cnpj_empresa = $empresa_1[1];
	$cnpj_empresa = explode('</td>', $cnpj_empresa);
	$data_empresa = strip_tags($cnpj_empresa[1]);
	$data_empresa = str_replace(array(' ', "\n", "\r", "\t"), '', $data_empresa);
	$cnpj_empresa = strip_tags($cnpj_empresa[0]);
	$cnpj_empresa = str_replace(' ', '', $cnpj_empresa);
	
	$nome_empresa = strip_tags($empresa_1[2]);
	$nome_empresa = str_replace(array("\n", "\r", "\t"), '', $nome_empresa);
	$cnpj_tipo = strip_tags($empresa_1[3]);
	if(strlen($cnpj_empresa) > 5){
		$empresas[]= array(
		'cnpj'=> $cnpj_empresa,
		'data'=> $data_empresa,
		'nome'=> $nome_empresa,
		'tipo'=> $cnpj_tipo,
			);
	}
	
	
}
####enderecos####

$corta_enderecos = corta($loga,'ados_enderecos_lista_body">','zip_box_buttom_rodape"></div>',$corta_enderecos);
$corta_enderecos = corta($corta_enderecos,'<tbody>','</tbody>',$corta_enderecos);
$corta_enderecos = explode('</tr>', $corta_enderecos);

$enderecos = array();

foreach($corta_enderecos as $endereco){
	
	$endereco_1 = explode('<td>', $endereco);
	$endereco_rua = $endereco_1[0];
	$endereco_rua = explode('</td>', $endereco_rua);
	$endereco_rua = strip_tags($endereco_rua[2]);
	$endereco_rua = str_replace(array("\n", "\r", "\t"), '', $endereco_rua);
	$endereco_rua = trim($endereco_rua);
	
	$endereco_bairro = $endereco_1[1];
	$endereco_bairro_corta = corta($endereco_bairro,'<br />','</td>',$endereco_bairro);
	
	$endereco_bairro_miolo = corta($endereco_bairro,'<br/></td>','</td>',$endereco_bairro_miolo);
	$endereco_bairro_ponta = corta($endereco_bairro,'</td>','</td>',$endereco_bairro_ponta);
	
	$endereco_bairro_filtro = str_replace(array($endereco_bairro_corta, $endereco_bairro_miolo,$endereco_bairro_ponta, " ", "\n", "\r", "\t"), '', $endereco_bairro);
	
	$endereco_bairro = corta($endereco_bairro_filtro,'<br/></td></td>','</td>',$endereco_bairro);
	$endereco_bairro_final = str_replace($endereco_bairro, '', $endereco_bairro_filtro);
	$endereco_bairro_final = strip_tags($endereco_bairro_final);
	
	
	$endereco_cep = $endereco_1[1];
	$endereco_cep = corta($endereco_cep,'">CEP ','<span>',$endereco_cep);
	$endereco_cep = trim($endereco_cep);

	$endereco_uf = $endereco_1[1];
	$endereco_uf = corta($endereco_uf,'</td>','</td>',$endereco_uf);
	
	$endereco_uf = strip_tags($endereco_uf);
	$endereco_uf = trim($endereco_uf);
	
	$endereco_cidade = $endereco_1[1];
	$endereco_cidade = corta($endereco_cidade,'vertical-center">','</td>',$endereco_cidade);
	$endereco_cidade = strip_tags($endereco_cidade);
	$endereco_cidade = trim($endereco_cidade);
	
	if(strlen($endereco_uf) > 1)
	{
		$enderecos[]= array(
		'rua'=> $endereco_rua,
		'bairro'=> $endereco_bairro_final,
		'cep'=> $endereco_cep,
		'uf'=> $endereco_uf,
		'cidade'=> $endereco_cidade,
		
			);
	}
	
}	






########Pessoas vinculadas
$urlpost_vinculos = "https://ziponline.zipcode.com.br/Consultas/ListaPessoaVinculada?idBase=".$codigo_base."";
$loga_vinculos    = curl($urlpost_vinculos , $cookie, null, 'https://ziponline.zipcode.com.br/Consultas/ConsultaPF', true);

$vinculos = corta($loga_vinculos,'<tbody>','</tbody>',$vinculos);
$vinculos = explode('<tr', $vinculos);


$vinculo1 = array();
foreach($vinculos as $vinculo){

	$vinculos_1 = explode('<td', $vinculo);
	$vinculo_nome = strip_tags($vinculos_1[1]);
	$vinculo_nome = str_replace('class="vertical-center">', '', $vinculo_nome);
	$vinculo_nome = trim($vinculo_nome);

	$vinculo_tipo = strip_tags($vinculos_1[2]);
	$vinculo_tipo = str_replace('class="tx_center">', '', $vinculo_tipo);
	$vinculo_tipo = trim($vinculo_tipo);
	
	if(strlen($vinculo_nome) > 1)
	{
		$vinculo1[]= array(
		'nome'=> $vinculo_nome,
		'tipo'=> $vinculo_tipo,
			);
	}
	
	


}

	$dados = array();
	$dados['dados'] = array(
		'cpf'   => $corta_cpf,
		'situacao' => $corta_sitcadast,
		'data_cad' => $corta_datcadastcpf,
		'data_alt' => $corta_ult_atua_receita,
		'nome'  => $corta_nome,
		'nascimento' => $corta_nasc,
		'idade' => $corta_idade,
		'signo' => $corta_signo,
		'sexo'  => $corta_sexo,
		'email' => $corta_email,
		'escolaridade' => $corta_escolaridade,
		'estado_civil' => $corta_estado_civil,
		'profissao' => $corta_ati_profissional,
		'renda' => $corta_renda,
		'rg'	=> $corta_rg,
		'pis' => $corta_pis,

	);
	$dados['fixo'] = $fixos;
	$dados['cel'] = $cell;
	$dados['enderecos'] = $enderecos;
	$dados['emails']    = $emails;
	$dados['empresas'] = $empresas;
	$dados['vinculos'] = $vinculo1;

	return $dados;
}

function consultFone($ddd, $numero, $cookie) {

	$url  = 'https://ziponline.zipcode.com.br/Consultas/ConsultaTelefone';
	$ref  = $url;
	$post = "DDD={$ddd}&NumeroTel={$numero}";	

	$res  = curl($url, $cookie, $post, $ref, true);
	if(stristr($res, 'mero de telefone corretamente')){
		return 'nada encontrado';
	}

	if(stristr($res, 'ua consulta retornou os resultados abaixo')){
		$numero 	= corta($res, 'telefone <span class="bold">', '</span>');
		$endere 	= corta($res, '<h3 class="blue">Endere', '</div>');
		$logradouro = corta($endere, 'o:</label> <strong>', '</strong>');
		$bairro 	= corta($endere, 'Bairro:</label> <strong>', '</strong>');
		$cidade 	= corta($endere, 'Cidade:</label> <strong>', '</strong>');
		$uf 	    = corta($endere, 'UF:</label> <strong>', '</strong>');

		$list  = array();
		// if(strlen($uf) >= 2){
		// 	$list['dados'] = array(
		// 		'numero'     => $numero,
		// 		'logradouro' => $logradouro,
		// 		'bairro'  => $bairro,
		// 		'cidade'  => $cidade,
		// 		'uf' 	  => $uf
		// 	);
		// }

		$dados = explode('<tr class="gray1-bg">', $res);

		foreach($dados as $dado) {

			if(stristr($dado, '?idBase=')){
				$idDoc = corta($dado, '?idBase=', '"');
				$doc   = corta($dado, '<td>', '</td>');
				$nome  = corta($dado, $idDoc.'">', '</a>');

				if(strlen($idDoc) > 1) {
					if(strlen($doc) < 5) {
						$doc = 'XXX.XXX.XXX-XX';
					}
				}

				if(stristr($dado, 'PessoaFisica?idBase')) {
					$tipo = 'Fisica';
				}else{
					$tipo = 'Juridica';
				}

				$list[]  = array(
					'id'   => $idDoc,
					'doc'  => $doc,
					'tipo'  => $tipo,
					'nome' => $nome,
					'logradouro' => '-',
					'cidade' => '-',
					'uf' => '-'
				);

			}
		}
		return $list;
	}else{
		return false;
	}
}

function consultEnd($logradouro, $numero, $cep, $estado, $cidade, $cookie) {
	$url = 'https://ziponline.zipcode.com.br/Consultas/ConsultaEndereco';
	$ref = $url;
	$post = "Logradouro={$logradouro}&Numero={$numero}&CEP={$cep}&Estado={$estado}&cidade={$cidade}";

	$res  = curl($url, $cookie, $post, $ref, true);

	if(stristr($res, 'DadosNaoEncontrados">')) {
		$ver = array('msg'=> 'nada encontrado');
		return $ver;
	}
	elseif(stristr($res, 'window.location = "/Consultas/Lista"')) {
		$url = 'https://ziponline.zipcode.com.br/Consultas/Lista';
		$res = curl($url, $cookie, null, $ref, true);
		if(stristr($res, 'Sua pesquisa retornou')){

			$dados = corta($res, '<div class="white-bg">', 'A TransUnion, ao disponibilizar');
			$dados = explode('<table class="simple_table containt_stretch">', $dados);
			$list  = array();

			foreach($dados as $dado){

				if(stristr($dado, 'href="/Consultas/Consulta')){
					$idDoc  = corta($dado, '?idBase=', '&');
					$nome   = corta($dado, $idDoc . '&amp;Origem=ListaPF">', '</a>');
					$doc    = corta($dado, '<td class="pos1">','</td>');
					$doc    = str_replace('X', '*', $doc);
					$uf     = corta($dado, '<td class="pos2">', '</td>');
					$cidade = corta($dado, '<td class="pos3">', '</td>');

					if(stristr($dado, 'Pessoa Jur')){
						$endere = corta($dado, '<td class="pos3">', '</td>');
						$tipo = 'Juridica';
					}else{
						$endere = corta($dado, '<td>', '</td>');
						$tipo = 'Fisica';
					}
					$list[] = array(
						'id'	=> $idDoc,
						'doc'   => $doc,
						'tipo'  => $tipo,
						'nome'  => $nome,
						'cidade' 	 => $cidade,
						'uf' 	     => $uf,
						'logradouro' => trim(rtrim($endere))
					);
				}
			}
			return $list;
		}else{
			return false;
		}
	}

}

function consultNome($nome, $cidade, $uf, $cep, $cookie) {
	$url  = 'https://ziponline.zipcode.com.br/Consultas/ConsultaPFPJ';
	$ref  = $url;

	$post = "Documento=&PessoaFisica=true&PessoaFisica=false&PessoaJuridica=true&PessoaJuridica=false&Nome={$nome}&NomeFantasia=&BuscaSimilares=true&BuscaSimilares=false&Segmento=&DataNascimento=&CEP={$cep}&Estado={$uf}&cidade={$cidade}&Logradouro=&Numero=&DDD=&Telefone=";

	$res  = curl($url, $cookie, $post, $ref, true);
 	
	if(stristr($res, 'Dados Principais</h3>')){
		$ver = extraiDoc($res);
		if ($ver == false) {
			return array('msg'=> 'nada encontrado');
		}else{
			return $ver;
		}
	}
	
	if(stristr($res, '/Account/RedirectToLogin?ReturnUrl=')){
		return false;
	}

	if(stristr($res, 'window.location = "/Consultas/Lista"')) {
		$url = 'https://ziponline.zipcode.com.br/Consultas/Lista';
		$res = curl($url, $cookie, null, $ref, true);
		if(stristr($res, 'Sua pesquisa retornou')){

			$dados = corta($res, '<div class="white-bg">', 'A TransUnion, ao disponibilizar');
			$dados = explode('<table class="simple_table containt_stretch">', $dados);
			$list  = array();

			foreach($dados as $dado){

				if(stristr($dado, 'href="/Consultas/Consulta')){
					$idDoc  = corta($dado, '?idBase=', '&');
					$nome   = corta($dado, $idDoc . '&amp;Origem=ListaPF">', '</a>');
					$doc    = corta($dado, '<td class="pos1">','</td>');
					$doc    = str_replace('X', '*', $doc);
					$uf     = corta($dado, '<td class="pos2">', '</td>');
					$cidade = corta($dado, '<td class="pos3">', '</td>');

					if(stristr($dado, 'Pessoa Jur')){
						$endere = corta($dado, '<td class="pos3">', '</td>');
						$tipo = 'Juridica';
					}else{
						$endere = corta($dado, '<td>', '</td>');
						$tipo = 'Fisica';
					}
					$list[] = array(
						'id'	=> $idDoc,
						'doc'   => $doc,
						'tipo'  => $tipo,
						'nome'  => $nome,
						'cidade' 	 => $cidade,
						'uf' 	     => $uf,
						'logradouro' => trim(rtrim($endere))
					);
				}
			}
			return $list;
		}else{
			return false;
		}
	}
}

function saveLog($id, $log){
	$conteudo = $log;	 
	$fp = fopen("LogsZip/{$id}.html","wb");	
	fwrite($fp,$conteudo);	 
	fclose($fp);	
}

function extraiCnpj($res) {
	if(!stristr($res, 'o Social: </label>')){
		return false;
	}

	$razao_social = corta($res, 'o Social: </label> <strong>', '</strong>');
	$nome_fantas  = corta($res, 'Nome Fantasia: </label> <strong>', '</strong>');
	$cnpj         = corta($res, 'CNPJ: </label> <strong>', '</strong>');
	$data_abert   = corta($res, 'Data de abertura: </label><strong>', '</strong>');

	$tels = corta($res, '<!-- Telefones do documento -->', '<div class="btn-avaliar-telefones');
	$tels = explode('<div class="zip_resultados_telefones_listas_numero">', $tels);
	$telefones = array();

	foreach($tels as $tel){
		$tel = 'INICIO#'. $tel;
		$ver = corta($tel, 'INICIO#', '</div>');
		if(stristr($ver, '(') AND stristr($ver, ')') AND stristr($ver, '-')){
			$fonn = rtrim(rtrim($ver));
			if(stristr($fonn, '-')){
				$fonn = explode(' ', $fonn);
				if(stristr($fonn[0], '(')){
					$ddd  = $fonn[0];
					$ddd  = str_replace(array('(', ')'), '', $ddd);
					$tell = $fonn[1];
					$telefones[] = array('ddd'=> $ddd, 'numero'=> $tell);
				}
			}
		}
	}

	$ends = corta($res, '<div class="zip_resultados_enderecos_lista_body">', 'btn-avaliar-telefones');
	$ends = explode('<tr class="gray1-bg"', $ends);
	$enderecos = array();

	foreach($ends as $end){
		if(stristr($end, '<td class="vertical-center">')){
			$endx = explode('<td', $end);
			$logradouro = strip_tags($endx[3]);
			$logradouro = str_replace(array('class="vertical-center">', '  ', "\n", "\r", "\t"), '', $logradouro);
			$bairro = $endx[4];
			$cep    = corta($bairro, '">CEP ', '<');
			$bairro = str_replace(array('  ', "\n", "\t"), '', corta($bairro, '>', '<br'));
			$uf = $endx[5];
			$uf = str_replace(array(' class="vertical-center tx_center">','</td>','  ', "\n", "\t"), '', $uf);
			if(strlen($uf) > 5){
				$nuf    = explode('<td class="vertical-center', $end);
				$uf     = str_replace(array('tx_center">', '  ', '</td>', '">', "\t", "\n"), '',$nuf[4]);
				$cidade = str_replace(array('">', '  ', "\t", "\n"), '', strip_tags($nuf[5]));
			}else{
				$cidade = $endx[6];
				$cidade = str_replace(array('</tbody>' ,' class="vertical-center">', '</tr>','</td>','  ', "\n", "\t"), '', $cidade);
			}	

			if(stristr($cep, '-')){
				$enderecos[] = array(
					'logradouro' => trim(rtrim($logradouro)),
					'bairro' => trim(rtrim($bairro)),
					'cep' 	 => trim(rtrim($cep)),
					'uf' 	 => trim(rtrim($uf)),
					'cidade' => trim(rtrim($cidade))
				);
			}
		}
	}

	$dados = array();
	$razao_social = corta($res, 'o Social: </label> <strong>', '</strong>');
	$nome_fantas  = corta($res, 'Nome Fantasia: </label> <strong>', '</strong>');
	$cnpj         = corta($res, 'CNPJ: </label> <strong>', '</strong>');
	$porte 		  = strip_tags(corta($res, 'Porte: </label>', '</strong>'));
	$data_abert   = corta($res, 'Data de abertura: </label><strong>', '</strong>');


	$dados['dados'] = array(
		'cnpj'   		=> $cnpj,
		'razao_social'  => $razao_social,
		'nome_fantasia' => $nome_fantas,
		'data_abertura' => $data_abert,
	);
	$dados['telefones'] = $telefones;
	$dados['enderecos'] = $enderecos;

	return $dados;
}

function openDados($id, $tipo, $cookie){
	if($tipo == 1){
		$url = "https://ziponline.zipcode.com.br/Consultas/ConsultaPJCompleta?idBase={$id}&Origem=ListaPF";
	}else{
		$url = "https://ziponline.zipcode.com.br/Consultas/ConsultaPFCompleta?idBase={$id}&Origem=ListaPF";
	}

	$ref = 'https://ziponline.zipcode.com.br/Consultas/Lista';
	$res = curl($url, $cookie, null, $ref, true);
	$res = extraiDoc($res);
	return $res;
}

function extraiDoc($res){
	if(stristr($res, 'o Social: </label>')){
		return extraiCnpj($res);
	}

	if(!stristr($res, 'Nome: </label><strong>')){
		return false;
	}

	$nome = corta($res, 'Nome: </label><strong>', '</strong>');
	$cpf  = corta($res, 'CPF: </label><strong>', '</strong>');
	$sexo = corta($res, 'Sexo: </label> <strong>', '</strong>');
	$nasc = corta($res, 'Data de nascimento: </label><strong>', '</strong>');
	$nasce= explode(' (', $nasc);
	$idade= str_replace(')', '', $nasce[1]);
	$nasc = $nasce[0];
	$sign = trim(rtrim(corta($res, 'Signo: </label><strong>', '</strong>')));
	
	if(stristr($res, 'E-mail: </label> <a href="mailto:')){ $email = corta($res, 'E-mail: </label> <a href="mailto:', '">'); }else{ $email = ''; }

	$tels = corta($res, '<!-- Telefones do documento -->', '<div class="btn-avaliar-telefones');
	$tels = explode('<div class="zip_resultados_telefones_listas_numero">', $tels);
	$telefones = array();

	foreach($tels as $tel){
		$tel = 'INICIO#'. $tel;
		$ver = corta($tel, 'INICIO#', '</div>');
		if(stristr($ver, '(') AND stristr($ver, ')') AND stristr($ver, '-')){
			$fonn = rtrim(rtrim($ver));
			if(stristr($fonn, '-')){
				$fonn = explode(' ', $fonn);
				if(stristr($fonn[0], '(')){
					$ddd  = $fonn[0];
					$ddd = str_replace(array('(', ')'), '', $ddd);					
					$tell = $fonn[1];
					$telefones[] = array('ddd'=> $ddd, 'numero'=> $tell);
				}
			}
		}
	}

	$ends = corta($res, '<div class="zip_resultados_enderecos_lista_body">', '</table>');
	$ends = explode('<tr class="', $ends);
	$enderecos = array();

	foreach($ends as $end){
		if(stristr($end, '<td class="vertical-center">')){
			$endx = explode('<td', $end);
			$logradouro = strip_tags($endx[3]);
			$logradouro = str_replace(array('class="vertical-center">', '  ', "\n", "\r", "\t"), '', $logradouro);
			$bairro = $endx[4];
			$cep = corta($bairro, '">CEP ', '<');
			$bairro = str_replace(array('  ', "\n", "\t"), '', corta($bairro, '>', '<br'));
			$uf = $endx[5];
			$uf = str_replace(array(' class="vertical-center tx_center">','</td>','  ', "\n", "\t"), '', $uf);
			$cidade = $endx[6];
			$cidade = str_replace(array('</tbody>' ,' class="vertical-center">', '</tr>','</td>','  ', "\n", "\t"), '', $cidade);
			
			if(stristr($cep, '-')){
				$enderecos[] = array(
					'logradouro' => trim(rtrim($logradouro)),
					'bairro' => trim(rtrim($bairro)),
					'cep' 	 => trim(rtrim($cep)),
					'uf' 	 => trim(rtrim($uf)),
					'cidade' => trim(rtrim($cidade))
				);
			}
		}
	}

	$dados = array();
	$dados['dados'] = array(
		'cpf'   => $cpf,
		'nome'  => $nome,
		'nascimento' => $nasc,
		'idade' => $idade,
		'signo' => $sign,
		'sexo'  => $sexo,
		'email' => $email
	);
	$dados['telefones'] = $telefones;
	$dados['enderecos'] = $enderecos;

	return $dados;
}

if(strlen(http_build_query($_GET)) > 1 OR strlen(http_build_query($_POST)) > 1){
	$cookie = ler();
	if(test($cookie) == false){
		$logar = logar();
		if($logar != false){
			$cookie = $logar;
			save($cookie);
		}else{
			save("");
			echo "erro ao relogar";
			die;
		}
	}else{
		//echo 'consultar';
	}
}

if(isset($_REQUEST['telefoneok']) and strlen($_REQUEST['telefoneok']) > 6){
	$num = $_REQUEST['telefoneok'];
	
	$num = explode(' ', $num);
	$ddd = str_replace(array('(', ')'), '', $num[0]);

	$numero = str_replace('-', '', $num[1]);
	$ver = consultFone($ddd, $numero, $cookie);
}elseif(isset($_REQUEST['nome'])){
	$nome   = $_REQUEST['nome'];
	$cidade = $_REQUEST['cidade'];
	$uf  	= $_REQUEST['uf'];
	$cep 	= $_REQUEST['cep'];

	$ver 	= consultNome($nome, $cidade, $uf, $cep, $cookie);

}elseif(isset($_GET['doc'])){
	$doc = $_GET['doc'];
	$ver = consultDoc($doc, $cookie);
	if($ver != false){
		$ver = extraiDoc($ver);
		if ($ver == false) {
			$ver = array('msg'=> 'nada encontrado');
		}
	}
}elseif(isset($_REQUEST['dados'])){
	$doc = $_REQUEST['dados'];
	$tipo = $_REQUEST['tipo'];
	if($tipo == 'cpf' OR $tipo == 'cnpj'){
		if($tipo == 'cpf'){
			$tipo = 2;
		}else{
			$tipo = 1;
		}

		if(strlen($doc) > 9){
			$ver = consultDoc($doc, $cookie);
			if($ver != false){
				$ver = extraiDoc($ver);
				if ($ver == false) {
					$ver = array('msg'=> 'nada encontrado');
				}
			}
		}else{
			$ver = openDados($doc, $tipo,$cookie);
		}
	}
}elseif(isset($_REQUEST['end'])){
	//endereco... cep....
	$logradouro = $_REQUEST['logradouro'];
	$numero     = $_REQUEST['numero'];
	$cep 		= $_REQUEST['cep'];
	$estado     = $_REQUEST['estado'];
	$cidade     = $_REQUEST['cidade'];
	$ver = consultEnd($logradouro, $numero, $cep, $estado, $cidade, $cookie);

}elseif(isset($_REQUEST['open'])){
	$id  = $_REQUEST['open'];
	$tipo = $_REQUEST['tipo'];
	if(strlen($tipo) > 1){
		if($tipo == 'cpf'){
			$tipo = 2;
		}else{
			$tipo = 1;
		}
	}

	$ver = openDados($id, $tipo,$cookie);
}

if(isset($ver)){
	echo json_encode($ver);
	die;
}
