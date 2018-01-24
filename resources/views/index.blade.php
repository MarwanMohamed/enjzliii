<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Free coming soon template with jQuery countdown">
    <meta name="author" content="http://bootstraptaste.com">
    <title>إنجزلي بيتا</title>
		<link rel="shortcut icon" type="image/ico" href="/front/images/favicon.ico"/>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
  	<link href="assets/css/bootstrap-theme.css" rel="stylesheet">
  	<link href="assets/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
  </head>
  <body>
	<div id="wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<img class="logo-im" src="./assets/img/logo.png">
					<h2 class="subtitle">قريبا اطلاق منصة انجزلي للعمل الحر والمتكامل</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
						<div class="credits">
						</div>
				</div>
			</div>		
		</div>
	</div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.countdown.min.js"></script>
	<script type="text/javascript">
      $('#countdown').countdown('2017/06/10', function(event) {
        $(this).html(event.strftime('%w weeks %d days <br /> %H:%M:%S'));
      });
    </script>
</body>
</html>