$(document).ready(function(){

$('#login .modal-title .col-sm-6').click(function(){
	$('#login .modal-title .on').removeClass('on');
	var a=$(this).attr('name');
	$('#login .type').val(a);
	$(this).addClass('on');
});
$('#register .modal-title .col-sm-6').click(function(){
	$('#register .modal-title .on').removeClass('on');
	var a=$(this).attr('name');
	if(a==='agency')
	$('#submit_registration').attr('form','agency_register');
	else
	$('#submit_registration').attr('form','customer_register');
	
	$('#register .form .register').each(function(){
												 if($(this).hasClass('hidden'))
												 $(this).removeClass('hidden');
												 else
												 $(this).addClass('hidden');
												 });
	$(this).addClass('on');
});

$('#rent_car_btn').click(function() {
	var carId = $(this).data('car-id');
	$('#car_id_modal').val(carId);
});

$('.menu .dropdown span').click(function(){
										 if($(this).hasClass('fa-caret-down'))
										 {
										 	$(this).next().css('display','block');
											$(this).removeClass('fa-caret-down');
											$(this).addClass('fa-caret-up');
										 }
										 else if($(this).hasClass('fa-caret-up'))
										 {
										 	$(this).next().css('display','none');
											$(this).removeClass('fa-caret-up');
											$(this).addClass('fa-caret-down');
										 }
										 });

						   });

function edit_details(ele) {
	$(ele).siblings('button').removeClass('d-none');
	$(ele).parent().siblings('.details').find('.model').removeAttr('readonly');
	$(ele).parent().siblings('.details').find('.model').removeClass('edit_field');
	$(ele).parent().siblings('.details').find('.number').removeAttr('readonly');
	$(ele).parent().siblings('.details').find('.number').removeClass('edit_field');
	$(ele).parent().siblings('.details').find('.seats').removeAttr('readonly');
	$(ele).parent().siblings('.details').find('.seats').removeClass('edit_field');
	$(ele).parent().siblings('.details').find('.rent').removeAttr('readonly');
	$(ele).parent().siblings('.details').find('.rent').removeClass('edit_field');
	$(ele).addClass('d-none');
}