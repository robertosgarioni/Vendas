@extends('layout.app', ["current" => "home"])

@section('body')
<!-- Btn de busca-->
<div class="jumbotron bg-light border">
    <br>
   <h1 class="title">Selecione o Produto</h1>
   <form method="get">
        <div class="input-group">
                <input class="form-control mb-2 mr-sm-2" id="produto" style="max-width:200px;" placeholder="digite o nome ou codigo do produto">
                <input class="form-control mb-2 mr-sm-2" id="qte" style="max-width:170px;" placeholder="digite a quantidade">
                <button id="BuscaProduto" class="btn btn-sm btn-primary"  type="submit"> Buscar </button>
        </div>
    </form>
    <!-- Final do Btn de busca-->
   <br>
   <h3>Produtos Adicionados:</h3>
   		<table class="table table-ordered table-hover" id="Tpedido">
            <thead>
                <tr>
                    <th scope="col">Codigo</th>
                    <th scope="col">Descrição do serviço</th>
                    <th scope="col">Valor Unitario</th>
                    <th scope="col">Quantiade</th>
                    <th scope="col">Valor Total</th>
                    <th scope="col">Data de Criação</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
                
            <tbody>
			</tbody>
                
        </table>
</div>

<!-- Totalizadores-->
<div class="jumbotron bg-light border ">
    <div class="totalizador">
        <h3>Totalizadores do pedido</h3>
        <div class="input-group">
            <h5> &ensp; Valor Total: &ensp; </h5>
            <input class="form-control" id="disabledInput" type="text" style="max-width:120px;"  disabled>
            <h5> &ensp; Desconto: &ensp; </h5>
        </div>
            <br>
            
            <button id="fecharPedido" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal" > Fechar Pedido </button> 
            <button class="btn btn-sm btn-danger"> Cancelar </button>
    </div>
</div>
<!-- Final Totalizadores-->

<!-- Modal para selecionar usuario-->


<div class="modal fade" id="modalPedido" tabindex="-1" role="dialog" aria-labelledby="modalPedido" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pedido de venda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="form-group">
                            <label for="usuario"  class="control-label">Usuario:</label>
                            <div class="input-group">
                                <select style="max-width:200px;" class="form-control" id="usuario" >
                                </select>    
                            </div>
                        </div>
                <h5>Escolha a forma de pagamento:</h5>
                <input id="pagamento" class="form-control mb-2 mr-sm-2" style="max-width:200px;" placeholder="Forma de pagamento">
            </div>
            <div>
            </div>
      <div class="modal-footer">
            <form method="get">
                <button id="dados" class="btn  btn-primary"  type="submit"> Incluir </button>
            </form>
      </div>
    </div>
  </div>
</div>

<!--Final Modal-->

<div class="modal" id="sucesso" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <p>Peido Efetuado com sucesso</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@section('javascript')
<script type="text/javascript">
 
 document.getElementById('Desconto').value=0;
itens = new Array ();
pagamento ="";
cliente="";

 function novoItem(id,desc,preco,qte){
    var produto = new Object();
    produto.id=id;
    produto.desc=desc;
    produto.preco=preco;
    produto.qte=qte;
    produto.valort=preco*qte;
    produto.dta_criacao=dta_criacao;
    itens.push(produto);
 }


function montarLinha(n,id,preco,qte,valort) {
    var linha = '<tr id="'+id+'">' +
            "<td>" + id+ "</td>" +
            "<td>" + n + "</td>" +
            "<td>" + preco + "</td>" +
            "<td>" + qte + "</td>" +
            "<td>" + valort + "</td>" +

            "<td>" +
              '<button class="btn btn-sm btn-danger" type="submit" id="salvarP"> Apagar </button> ' +
            "</td>" +
            "</tr>";
            novoItem(id,n,preco,qte);
            return linha;
    }

    function BuscarProduto(produto,qte) {
        $.getJSON('/api/produtos', function(produtos) { 
            for(i=0;i<produtos.length;i++) {
                if(produtos[i].nome == produto | produtos[i].id==produto ){
                    var n=produtos[i].nome;
                    var id=produtos[i].id;
                    var preco=produtos[i].preco;
                    var valort=preco*qte;
                    linha = montarLinha(n,id,preco,qte,valort);
                    $('#tpedido>tbody').append(linha);
                    oldpreco = document.getElementById('disabledInput').value;
                    
                    if(document.getElementById("disabledInput").value == ""){
                        document.getElementById('disabledInput').value = valort;
                    }
                    else{
                        var n1 = parseInt(valort);
                        var n2 = parseInt(oldpreco);
                        var value = n1+n2;
                        document.getElementById('disabledInput').value = value;
                    }
                    
            
                }
            }
           

        });        
    }  


    // Evento que é executado ao clicar no botão de enviar
    document.getElementById("BuscaProduto").onclick = function(e) { 
        var produto= document.getElementById("produto").value;
        var qte= document.getElementById("qte").value;
        BuscarProduto(produto,qte);
        e.preventDefault();
    }

    function carregarUsuario() {
        $.getJSON('/api/usuario', function(data) {
            for(i=0;i<data.length;i++) {
                opcao = '<option value ="' + data[i].id + '" id="i'+data[i].id+'">' + 
                    data[i].cep + '</option>';
                $('#usuario').append(opcao);
            }
        });
    }


    document.getElementById("dados").onclick = function(e) { 
         cliente= document.getElementById("usuario").value;
         pagamento= document.getElementById("pagamento").value;
        e.preventDefault();
        $('#modalPedido').modal('hide');
    }

    document.getElementById("fecharPedido").onclick = function(e) { 
        console.log(usuario);
        e.preventDefault();
        salvarPedido();
    }


    function salvarPedido() {

        ped ={
            idUsuario:usuario,
            pag:pagamento,
            valort:document.getElementById("disabledInput").value,
            desconto:document.getElementById("Desconto").value
        };

        $.ajax({
            type: "POST",
            url: "/api/pedido/novo",
            context: this,
            data: ped,
            success: function(data) {
                ped = JSON.parse(data);
                salvarItens(ped.id);
                $("#tpedido td").remove(); 
                  produto= document.getElementById("produto").value ="";
                  qte= document.getElementById("qte").value ="";
                document.getElementById('disabledInput').value = "";
                $('#sucesso').modal('show');
                $('#sucesso').modal('hiden');
            },
            error: function(error) {
                console.log(error);
            }
        }); 
       
    }

    function salvarItens(id){
        for(i=0;i<itens.length;i++) {
            it={
                desc: itens[i].desc,
                id_ped: id,
                id_prod: itens[i].id,
                qte: itens[i].qte,
                vlr: itens[i].valort
                dta_criacao: date[i].dta_criacao,
            };
            var v1=itens[i].id;
            var v2=itens[i].qte;

            console.log(it);

            $.ajax({
                type: "POST",
                url: "/api/pedido/itens",
                context: this,
                data: it,
                success: function(data) {
                    baixar(v1,v2);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        } 
       
    }
    
    function baixar(id,qte) {
        $.ajax({
            type: "POST",
            url: "/api/produto/estoque/" + id+"/"+qte,
            context: this,
            success: function() { 
            },
            error: function(error) {
                console.log(error);
            }
        });        
    }



    $(document).ready(function() {
    carregarUsuario();
    $('#modalPedido').modal('show');
})

</script>
@endsection

@endsection