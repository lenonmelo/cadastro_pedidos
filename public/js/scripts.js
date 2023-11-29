$(function () {

    //Scripts para os formulários de clientes

    // Aplica a máscara para o campo de CPF
    $('#cpf').mask('000.000.000-00');
    $('#telefone').mask('(00)000000000');
    $('#data_nasc').mask('00/00/0000');

    //Date piker da data de nascimento
    $("#data_nasc").datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        maxDate: -1,
        minDate: new Date(1900, 1 - 1, 1),
        yearRange: "c-100:c+0",
    });

    //Scripts para os formulários de pedidos

    // Aplica a máscara para o campo valir
    $('#valor').mask('000.000.000,00', { reverse: true });

    //Date piker da data do pedido
    $("#data_pedido").datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        minDate: new Date(1900, 1 - 1, 1),
        yearRange: "c-100:c+0"
    });

});

/*
* Function que mostra a imagem no tamanho grande
*/
function mostrarImagem(id, url) {
    //Inclui o loading no modal
    $("#conteudo").html('<div class="d-flex justify-content-center m-5"><span class="m-2">Carregando...</span><div class="spinner-border m-2" role="status"></div></div>');

    //Abre o modal
    $("#myModal").modal('show');

    //Carrega a imagem e inclui no modal
    $.ajax({
        url: url + "?id=" + id
    }).done(function (html) {
        $("#conteudo").html(html);
    });
}
