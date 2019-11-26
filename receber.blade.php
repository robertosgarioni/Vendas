@extends('layout.app', ["current" => "receber" ])

@section('body')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Contas a Receber</h5>
        <br>
        <div class="table-responsive">
        <table class="table table-ordered table-hover " id="tabelaReceber">
            <thead>
                <tr>
                        <th scope="col">Codigo</th>
                        <th scope="col">Data de inclusão</th>
                        <th scope="col">Data de vencimento</th>
                        <th scope="col">valor</th>
                        <th scope="col">Observação</th>
                        <th id="testes"class="teste"  scope="col">Estado do titulo</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Ações</th>
                </tr>
            </thead>
                
            <tbody>
                           
            </tbody>
                
        </table>
        </div>
       
    </div>
    <div class="card-footer">
        <button class="btn btn-sm btn-primary" role="button" onClick="novoReceber()">Novo Receber</button>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="dlgReceber">
    <div class="modal-dialog" role="document"> 
        <div class="modal-content">
            <form class="form-horizontal" id="formReceber">
                <div class="modal-header">
                    <h5 class="modal-title">Inclusão de contas a receber</h5>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="id" class="form-control">
                    <div class="form-group">
                        <label for="quantidadeProduto" class="control-label">Data de inclusão</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="inc" placeholder="Data de inclusão">
                        </div>
                    </div>
                   
                     <div class="form-group">
                        <label for="quantidadeProduto" class="control-label">Data de vencimento</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="venc" placeholder="Data de vencimento">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precoProduto" class="control-label">Valor</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="valor" placeholder="Valor">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="usuario" class="control-label">Usuario</label>
                        <div class="input-group">
                            <select class="form-control" id="usuario" >
                            </select>    
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="quantidadeProduto" class="control-label">Observação</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="observacao" placeholder="Observação do titulo">
                        </div>
                    </div>                    

                   

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
     
     
     
@section('javascript')
<script type="text/javascript">
    
   
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });
    
    function novoReceber() {
        
        $('#dlgReceber').modal('show');
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


    function montarLinha(r,cli) {
        if(r.baixado==1){
            r.baixado='baixado';
            var baixado= '<td class="baixado" id="' + r.id + '">'  + 'Baixado' + "</td>" ;
        }
        else{
            
            var baixado= '<td class="nbaixado" id="' + r.id + '">' +'Em aberto'+ "</td>" ;
        }
        
        var linha = "<tr>" +
            "<td>" + r.id + "</td>" +
            "<td>" + r.data_inc + "</td>" +
            "<td>" + r.data_venc + "</td>" +
            "<td>" + r.valor + "</td>" +
            "<td>" + r.observacao + "</td>" +
                 baixado+
            "<td>" + r.cep + "</td>" +
            "<td>" +
              '<button class="btn btn-sm btn-primary" onclick="editar(' + r.id + ')"> Editar </button> ' +
              '<button class="btn btn-sm btn-danger" onclick="remover(' + r.id + ')"> Apagar </button> ' +
              '<button class="btn btn-sm btn-secondary" onclick="baixar(' + r.id + ')"> Baixar </button> ' +
            "</td>" +
            "</tr>";
        return linha;
    }

    function montarLinha2(r,cli) {
        if(r.baixado==1){
            r.baixado='baixado';
            var baixado= '<td class="baixado" id="' + r.id + '">'  + 'Baixado' + "</td>" ;
        }
        else{
            
            var baixado= '<td class="nbaixado"id="' + r.id + '">'+ 'Em aberto' + "</td>" ;
        }
        
        var linha = "<tr>" +
            "<td>" + r.id + "</td>" +
            "<td>" + r.data_inc + "</td>" +
            "<td>" + r.data_venc + "</td>" +
            "<td>" + r.valor + "</td>" +
            "<td>" + r.observacao + "</td>" +
                 baixado+
            "<td>" + r.usuario_id + "</td>" +
            "<td>" +
              '<button class="btn btn-sm btn-primary" onclick="editar(' + r.id + ')"> Editar </button> ' +
              '<button class="btn btn-sm btn-danger" onclick="remover(' + r.id + ')"> Apagar </button> ' +
              '<button class="btn btn-sm btn-secondary" onclick="baixar(' + r.id + ')"> Baixar </button> ' +
            "</td>" +
            "</tr>";
        return linha;
    }


    
    function editar(id) {
        $.getJSON('/api/receber/'+id, function(data) { 
            console.log(data);
            $('#id').val(data.id);
            $('#inc').val(data.data_inc);
            $('#venc').val(data.data_venc);
            $('#valor').val(data.valor);
            $('#observacao').val(data.observacao);
            $('#baixado').val(data.baixado);
            $('#dlgReceber').modal('show');            
        });        
    }
    
    function remover(id) {
        $.ajax({
            type: "DELETE",
            url: "/api/receber/" + id,
            context: this,
            success: function() {
                console.log('Apagou OK');
                linhas = $("#tabelaReceber>tbody>tr");
                e = linhas.filter( function(i, elemento) { 
                    return elemento.cells[0].textContent == id; 
                });
                if (e)
                    e.remove();
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function baixar(id) {
        $.ajax({
            type: "POST",
            url: "/api/receber/baixar/" + id,
            context: this,
            success: function() {

                $('#'+id+'').html('baixado');  
                $('#'+id+'').css({ backgroundColor: "#90EE90" });   

            },
            error: function(error) {
                console.log(error);
            }
        });        
    }
    
    

   
    
    function carregarReceber() {
        $.getJSON('/api/receber', function(rec,cli) { 
            for(i=0;i<rec.length;i++) {
                linha = montarLinha(rec[i],cli[i]);
                $('#tabelaReceber>tbody').append(linha);
            }
        });       
    }
    
    function criarReceber() {
        rec = { 
            inc: $("#inc").val(), 
            venc: $("#venc").val(), 
            valor: $("#valor").val(), 
            usuario:$("#usuario").val(),
            observacao: $("#observacao").val() 
        };
       
        $.post("/api/receber", rec, function(data) {
            receber = JSON.parse(data);
            console.log(rec.usuario);
            receber.usuario_id=document.getElementById('i'+rec.usuario+'').innerHTML;
            linha = montarLinha2(receber);
            $('#tabelaReceber>tbody').append(linha);            
        });
    }

    
    $("#formReceber").submit( function(event){ 
        event.preventDefault(); 
        if ($("#id").val() != '')
            salvarReceber();
        else
            criarReceber();
            
        $("#dlgReceber").modal('hide');
    });
    
    $(function(){
        carregarUsuario();
        carregarReceber();
    })

    


</script>
@endsection
     
     
     
     
     
     
     
     
     