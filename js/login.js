$(function () {
	$('.changer').on('click', '.regist', function() {
		$('.header').text('User Registration');
		$('.email').attr('name', 'reg_email');
		$('.pass').attr('name', 'reg_pass');
		$('.subm-btn').attr('value', 'Register');
		$(this).attr('class', 'login btn btn-primary mb-2 mt-2');
		$(this).text('Login')
	})
	$(".changer").on('click', '.login', function() {
		$('.header').text('Please Log In');
		$('.email').attr('name', 'email');
		$('.pass').attr('name', 'pass');
		$('.subm-btn').attr('value', 'Log in');
		$(this).attr('class', 'regist btn btn-primary mb-2 mt-2');
		$(this).text('Registration');
		
	});
})