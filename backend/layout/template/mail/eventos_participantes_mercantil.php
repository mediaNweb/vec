<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title; ?></title>
<style type="text/css">
<!--
.tituloderecha {
	font-family: Arial, Helvetica, sans-serif;
	color: #004E9B;
	font-weight: bold;
	font-size: 17px
	
}
 .Impulsa {
	font-size: 20px;
	color: #004E9B;
	font-weight: bold;
	font-style: italic;
	
	font-family: Arial, Helvetica, sans-serif;
}
.contenidoLink {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #004E9B;
	font-weight: bold;
	text-decoration: none;
}
a:link.contenidoLink,a:visited.contenidoLink,a:active.contenidoLink {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color:#004E9B;
	text-decoration:none;
	font-weight: bold;
}
a:hover.contenidoLink {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color:#004E9B;
	text-decoration:none;
	font-weight: bold;
}

body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}

a:link {  color: #333333; text-decoration: none}
a:visited {  color: #333333; text-decoration: none}
a:hover {  color: #004E9B; text-decoration: none}
a:active {  color: #333333;text-decoration: none}

.texBlanco { font-family: Arial, Helvetica, sans-serif; color: #FFFFFF; text-decoration: none; font-size: 11px;}
a:link.texBlanco {	color: #FFFFFF;	text-decoration: none;}
a:visited.texBlanco { color: #FFFFFF; text-decoration: none;}
a:hover.texBlanco {	color: #E5E9F8;	text-decoration: none;}
a:active.texBlanco { color: #FFFFFF;	text-decoration: none;}

.textpeq {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #666666;
	text-decoration: none;
	text-align: justify;
}
.linkMenu {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #333333;
	text-decoration: none;
	width: 100%;
	height: auto;
	padding-top: 3px;
	padding-right: 3px;
	padding-bottom: 3px;
	padding-left: 5px;
}

A:hover.linkMenu {	background-color: #F0EDF7;	color: #333333;
}



.celdaMenu {
	width: 150px;
	background-color: #FFFFFF;
	border-top-width: 1px;
	border-right-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-left-style: solid;
	border-top-color: #CCCCCC;
	border-right-color: #CCCCCC;
	border-left-color: #CCCCCC;
}

.celdaAzul {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #FFFFFF;
	text-decoration: none;
	background-color: #004E9B;
	border-top-width: 1px;
	border-right-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-left-style: solid;
	border-top-color: #999999;
	border-right-color: #999999;
	border-left-color: #999999;
	line-height: 20px;
	padding-left: 6px;
}

.celdaAzulClaro1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	text-decoration: none;
	background-color: #F4F8FD;
	border-top-width: 1px;
	border-right-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-left-style: solid;
	border-top-color: #999999;
	border-right-color: #999999;
	border-left-color: #999999;
	padding-left: 6px;
	padding-top: 5px;
	padding-right: 6px;
	padding-bottom: 5px;
}

.celdaBlanco {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	text-decoration: none;
	background-color: #FFFFFF;
	border-top-width: 1px;
	border-right-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-left-style: solid;
	border-top-color: #999999;
	border-right-color: #999999;
	border-left-color: #999999;
	padding-left: 6px;
	padding-top: 5px;
	padding-right: 6px;
	padding-bottom: 5px;
}

.tituloAzul {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #004E9B;
	text-decoration: none;
}

.texGris1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #999999;
	text-decoration: none;
	text-align: justify;
}

.texGris2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	text-decoration: none;
	text-align: justify;
}

.texGris3 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #333333;
	text-decoration: none;
	text-align: justify;
}
.texGris3_L {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #333333;
	text-decoration: none;
}
li {
	list-style-image: url(../../../../imgindex/flecha_bullet.gif);
	margin-bottom: 2px;
	padding-bottom: 7px;
	line-height: 13px;
	font-size: 11px;
}

.tituloAzulBold {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #004E9B;
	text-decoration: none;
	font-weight: bold;
}

.tituloAzulBold02 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #004E9B;
	text-decoration: none;
	font-weight: bold;
	border-bottom-width: 0px;
	border-bottom-style: solid;
	border-bottom-color: #666666;
	display: block;
	padding-bottom: 10px;
}
.tituloGrisBold {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #333333;
	text-decoration: none;
	font-weight: bold;
}

.tituloAzulBold3 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #004E9B;
	text-decoration: none;
	font-weight: bold;
}
.FraseCierre {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 15px;
	color: #004E9B;
	font-weight: bold;
	font-style: italic;
}
.tabla-tit {
	font-size: 12px;
	color: #FFFFFF;
	background-color: #003399;
	font-weight: bold;
}
.texto-tabla {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
	color: #333333;
}
.tab-gris-claro {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #CCCCCC;
}
.textoAzul {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #003399;
}
.textoGrande {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 36px;
	color: #004E9B;
	font-weight: bold;
	font-style: italic;
}
.textoMediano {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
	color: #004E9B;
	font-weight: bold;
	font-style: normal;
}
.textoPeque {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #004E9B;
	font-weight: bold;
}
.textoLink {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	font-weight: bold;
}
a.textoLink:hover { 
	font-family: Arial, Helvetica, sans-serif;
	color: #999999;
	width:11px; 
	text-decoration:underline;
	font-weight: bold;
}
#email-pie-pagina{
	width: 480px;
	height: 50px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #003399;
	text-align: right;
	padding: 10px;
	margin-top: 15px;
	font-weight: bold;
}
#email-pie-pagina ul li{
	list-style-image: url(../../../../layout/imagenes/doble_menor_que.gif);	
}
#email-pie-pagina ul li a{
	color: #003399;
	text-decoration: none;
}
.tituloAzulCorto {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #004E9B;
	text-decoration: none;
	font-weight: bold;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #004E9B;
	width: 320px;
	padding-bottom: 5px;
	text-align: left;
}
.letras_mail_new_again {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #004E9B;
	text-decoration: none;
	font-weight: bold;
	margin-left:5px;
}
.textoMedio {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #004E9B;
	font-weight: bold;
}
.textoPeque2{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 22px;
	color: #FE6601;
	font-weight: bold;
	font-style: normal;
}
.textoPeque3{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #FE6601;
	font-weight: bold;
	font-style: normal;
}
.textoMediano1 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 24px;
	color: #004E9B;
	font-weight: bold;
	font-style: italic;
}
.textoMedio1 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #004E9B;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<table width="560" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="560" height="274" align="left" valign="top"><img src="<?php echo HTTP_SERVER; ?>imagenes/layuot/mercantil/header_mercantil.jpg" alt="" width="620" height="296" />
      <div class="textoPeque" style=" width:620px; margin-top:5px; text-align:right;">
          Caracas, 
		<?php 
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp"); 
            echo ucwords(strftime("%A %d de %B de %Y")); 
        ?>
      </div></td>
  </tr>
  <tr>
    <td align="center" valign="bottom"><table width="560" border="0" cellspacing="0" cellpadding="10">
        <tr>
          <td align="center"><div style="width:620px; text-align: left;">
              <p class="tituloAzulBold02"><span class="textoMedio">Estimado <span class="textoMedio">(a)</span> Sr.(a): <?php echo $text_name; ?></span>
            </div>
            <div style="text-align:left; width:620px; height:auto; float:left; margin-bottom: 0px;"> 
              <p class="texGris3_L">A ti que eres cliente Mercantil, tenemos el gusto de informarte que ya estás inscrito en la <br />Caracas Rock 2012. Gracias por aceptar esta invitación cortesía de Mercantil que, una vez más, impulsa tu mundo con energía para que vivas 10K de música, diversión y emoción en compañía de tu familia y amigos.</p>
              <div style="float:left; width:490px"><span class="texGris3_L">
                <p align="left" class="tituloAzulBold3"><strong>A continuación, tus datos de participación:</strong></p>
                <p align="left" class="texGris3_L">
                    <b><?php echo $text_number; ?></b> <?php echo $number; ?><br />
                    <b><?php echo $text_customer_id; ?></b> <?php echo $customer_id; ?><br />
                    <b><?php echo $text_name; ?></b> <?php echo $name; ?><br />
                    <b><?php echo $text_email; ?></b> <?php echo $email; ?><br />
                    <?php if ($group) { ?>
                        <b><?php echo $text_group; ?></b> <?php echo $group; ?><br />
                    <?php } ?>
                    <?php if ($category) { ?>
                        <b><?php echo $text_category; ?></b> <?php echo $category; ?><br />
                    <?php } ?>
                </p>
                <p align="left" class="tituloAzulBold3"><strong>Detalles de Solicitud</strong></p>
                <p align="left" class="texGris3_L">
                    <b><?php echo $text_order_id; ?></b> <?php echo $order_id; ?><br />
                    <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?><br />
                    <?php if ($payment_method) { ?>
                        <b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
                    <?php } ?>
                    <b><?php echo $text_event; ?></b> <?php echo $event; ?><br />
                    <b><?php echo $text_event_date; ?></b> <?php echo $event_date; ?><br />
                </p>
                <p align="left" class="tituloAzulBold3"><strong>Detalles de la Entrega de Materiales</strong></p>
                <p align="left" class="texGris3_L">Entrega de materiales:<br />
					<?php echo html_entity_decode($materials);?><br />
                </p>
              </div>
              <div style="float:left; width:130px"><span class="texGris3_L"><img src="<?php echo HTTP_SERVER; ?>imagenes/layuot/mercantil/mano_mercantil.jpg" alt="" width="130" height="142" align="top" /></div>
              <div style="float:left; width:620px">
                <div align="center"><span class="texGris3_L">Para mayor información escribir a</span><strong class="tituloAzulBold3"> <span class="tituloAzulBold3">comentarios@hipereventos.com</span></strong></div>
              </div>
            </div>
            <div style="float:right">
            <br />
            <div style=" text-align: center; width:620px; height:auto;">
              <p class="Impulsa">Mercantil, impulsa tu mundo<br />
              </p>
            </div>
            <div style="width:620px; height:auto; float:left; text-align:justify">
              <p align="left" class="textpeq">© Copyright 2009 Mercantil C.A., Banco Universal RIF: J-00002961-0. Todos los derechos reservados. Mercantil nunca le solicitará por ningún medio como Internet, "Mis Mensajes", correo electrónico, llamada telefónica o fax, la actualización de sus claves, ni más de dos coordenadas de su e-Seguridad. En caso de que esto suceda, no facilite la información y repórtelo de inmediato al Centro de Atención Mercantil al número y/o correo suministrado en la sección "Para mayor información".</p>
            </div>
            <p>
            
            <p>&nbsp;</p></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table>
</body>
</html>



<!--
<div id="container"><a href="<?php // echo $store_url; ?>" title="<?php // echo $store_name; ?>"><img src="<?php // echo $logo; ?>" alt="<?php // echo $store_name; ?>" id="logo" /></a> <br />
	<br />
</div>
-->
