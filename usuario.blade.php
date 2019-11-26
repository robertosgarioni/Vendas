@extends('layout.app', ["current" => "usuario" ])

@section('body')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Clientes</h5>
        <div class="table-responsive">
        <table class="table table-ordered table-hover" id="tabelaClientes">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Telefone1</th>
                    <th scope="col">Cep</th>
                    <th scope="col">Endereço</th>
                    <th scope="col">Numero</th>
                    <th scope="col">Data de Criação</th>
                    <th scope="col">Ações</th>
                    
                </tr>
            </thead>
                
                        <tbody>
                           
                        </tbody>
                
        </table>
        </div>
       
    </div>
    <div class="card-footer">
        <button class="btn btn-sm btn-primary" role="button" onClick="novoUsuario()">Novo Usuario</button>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="dlgUsuario">
    <div class="modal-dialog" role="document"> 
        <div class="modal-content">
            <form class="form-horizontal" id="formUsuario">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro Usuario</h5>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="id" class="form-control">


                    <div class="form-group">
                        <label for="quantidadeProduto" class="control-label">E-mail</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="email" placeholder="E-mail">
                        </div>
                    </div>                    

                    <div class="form-group">
                        <label for="quantidadeProduto" class="control-label">Telefone1</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="telefone1" placeholder="Telefone1">
                        </div>
                    </div>     




                    <div class="form-group">
                        <label for="quantidadeProduto" class="control-label">Cep</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="cep" placeholder="Cep">
                        </div>
                    </div>  


                    <div class="form-group">
                        <label for="quantidadeProduto" class="control-label">Endereço</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="endereço" placeholder="Endereço">
                        </div>
                    </div>  


                    <div class="form-group">
                        <label for="quantidadeProduto" class="control-label">Rua</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="numero" placeholder="numero">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="quantidadeProduto" class="control-label">Data de Criação</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="date" placeholder="date">
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
    
    function novoCliente() {
        $('#id').val('');
        $('#email').val('');
        $('#telefone1').val('')
        $('#cep').val('');
        $('#endereço').val('');
        $('#numero').val('');
        $('#datacriacao').val('');
        $('#dlgUsuario').modal('show');
    }
    
    function carregarCategorias() {
        $.getJSON('/api/categorias', function(data) { 
            for(i=0;i<data.length;i++) {
                opcao = '<option value ="' + data[i].id + '">' + 
                    data[i].nome + '</option>';
                $('#categoriaProduto').append(opcao);
            }
        });
    }
    
    function montarLinha(c) {
        
           if (typeof c.rua == "undefined"){
            c.rua='';
           }

           if (typeof c.email == "undefined"){
            c.email='';
           }
           if (typeof c.telefone2 == "undefined"){
            c.telefone2='';
           }
           if (typeof c.cep == "undefined"){
            c.cep='';
           }
           
           if (typeof c.endereço == "undefined"){
            c.endereço='';
           }
           
           if (typeof c.numero == "undefined"){
            c.endereço='';
           }

        if (typeof c.datacriacao == "undefined"){
            c.datacriacao='';
        }

        var linha = "<tr>" +

            '<td scope="row">' + c.id + "</td>"+
            '<td scope="row">' + c.cpf + "</td>" +
            '<td scope="row">' + c.email + "</td>" +
            '<td scope="row">' + c.telefone1 + "</td>" +
            '<td scope="row">' + c.cep + "</td>" +
            '<td scope="row">' + c.endereco + "</td>" +
            '<td scope="row">' + c.numero + "</td>" +
            '<td scope="row">' + c.datacricao + "</td>" +
            '<td scope="row">' +
              '<button class="btn btn-sm btn-primary" onclick="editar(' + c.id + ')"> Editar </button> ' +
              '<button class="btn btn-sm btn-danger" onclick="remover(' + c.id + ')"> Apagar </button> ' +
            "</td>" +
            "</tr>";
        return linha;
    }
    
    function editar(id) {
        $.getJSON('/api/usuario/'+id, function(data) {
            console.log(data);
            $('#id').val(data.id);

            $('#email').val(data.email);
            $('#telefone1').val(data.telefone1);
            $('#cep').val(data.cep);
            $('#endereço').val(data.endereco);
            $('#numero').val(data.numero);
            $('#datacriacao').val(data.datacriacao);
            $('#dlgUsuario').modal('show');
        });        
    }
    
    function remover(id) {
        $.ajax({
            type: "DELETE",
            url: "/api/usuario/" + id,
            context: this,
            success: function() {
                console.log('Apagou OK');
                linhas = $("#tabelaUsuario>tbody>tr");
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
    
    function carregarUsuario() {
        $.getJSON('/api/usuario', function(usuario) {
            for(i=0;i<usuario.length;i++) {
                linha = montarLinha(usuario[i]);
                $('#tabelausuario>tbody').append(linha);

                       
            }
        });        
    }
    
    function criarUsuario() {
        cli = { 
                id: $("#id").val(),

                email:$('#email').val(),
                telefone1:$('#telefone1').val(),
                cep: $('#cep').val(),
                endereço: $('#endereço').val(),
                numero: $('#numero').val(),
            datacriacao: $('#datacriacao').val(),
        };
        $.post("/api/clientes", cli, function(data) {
            usuario = JSON.parse(data);
            linha = montarLinha(usuario);
            $('#tabelaUsuario>tbody').append(linha);
        });
    }
    
    function salvarProduto() {
        cli = { 
                id : $("#id").val(), 

                email:$('#email').val(),
                telefone1:$('#telefone1').val(),
                telefone2: $('#telefone2').val(),
                cep: $('#cep').val(),
                endereço: $('#endereço').val(),
                numero: $('#numero').val(),
                datacriacao: $('#datacriacao').val(),
        };
        $.ajax({
            type: "PUT",
            url: "/api/clientes/" + cli.id,
            context: this,
            data: cli,
            success: function(data) {
                cli = JSON.parse(data);
                linhas = $("#tabelaUsuario>tbody>tr");
                e = linhas.filter( function(i, e) { 
                    return ( e.cells[0].textContent == cli.id );
                });
                if (e) {
                    e[0].cells[0].textContent = cli.id;
                    e[0].cells[1].textContent = cli.email;
                    e[0].cells[2].textContent = cli.telefone1;
                    e[0].cells[3].textContent = cli.cep;
                    e[0].cells[4].textContent = cli.endereco;
                    e[0].cells[5].textContent = cli.numero;
                    e[0].cells[6].textContent = cli.datacriacao;
                }
            },
            error: function(error) {
                console.log(error);
            }
        });        
    }
    
    $("#formCliente").submit( function(event){ 
        event.preventDefault(); 
        if ($("#id").val() != '')
            salvarProduto();
        else
            criarUsuario();
            
        $("#dlgUsuario").modal('hide');
    });
    
    $(function(){
        carregarCategorias();
        carregarUsuario();
    })
    
</script>
@endsection
     
     
     
     
     
     
     
     