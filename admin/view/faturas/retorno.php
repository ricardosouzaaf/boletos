
    	<?php if(@$_GET['reg'] == "1") { ?>
        <div class="status success">
        	<p class="closestatus"><a href="?cms=Faturas" title="Fechar">x</a></p>
        	<p><img SRC="assets/img/icons/icon_success.png" alt="" /><span>Aten��o!</span> Faturas cadastradas com sucesso.</p>
        </div>
     	<?php } ?>
     
	 
         <div class="contentcontainer">
            <div class="headings altheading">
                <h2>Retorno Banc�rio</h2>
            </div>
            <div class="contentbox">
    
 

<strong>� Selecione um arquivo com extens�o .RET com padr�o CNAB240.</strong><br/></span></p><br/>

  <form action="retorno.php" method="post" enctype="multipart/form-data">
	<input name="arquivo" class="btn btn-info" type="file" /><br/><br/>

    <div class="controlsa">
    <button type="submit" class="btn btn-success" id="btnsubmit" >
    <i class="fa fa-thumbs-up icon-white"></i> Processar Arquivo</button>
    <input type="hidden" value="ENVIAR" name="funcao">
    </div>
    </form>
            
        </div> </div> 
