$(function(){
  //Obtener el evento al hacer clic en un botón
  $('#modalButton').click(function (){
    $('#modal').modal('show')
      .find('#modalContent')
      .load($(this).attr('value'));
  });


  $('#_modalButtonApertura').click(function (){
    $('#_modalApertura').modal('show')
      .find('#_aperturaCaja')
      .load($(this).attr('value'));
  });


    $('#_modalButtonCierre').click(function (){
    $('#_modalCierre').modal('show')
      .find('#_cierraCaja')
      .load($(this).attr('value'));
  });
});

//$.pjax.reload({container:'#$dataIn'});
