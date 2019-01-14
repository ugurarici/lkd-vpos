<!DOCTYPE html>
<html>
<head>
	<title>LKD - Bağış / Aidat Ödeme Formu</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<!-- Vendor libraries -->
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<style type="text/css">
		body{padding: 30px 0;}
		.panel-heading{border-top-left-radius: inherit;border-top-right-radius: inherit;}
	</style>
</head>
<body>
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div class="row">
				<div class="col-sm-12">
					<div class="col-sm-4">
						<img src="images/resmilogo.png" class="img-responsive" />
					</div>	
					<div class="col-sm-8">
						<p>
							<span class="subject">Derneğe banka yoluyla da bağış / aidat ödemesi yapabilirsiniz</span><br /><br />
							<span class="subject">Banka :</span> Garanti Bankası<br>
							<span class="subject">Şube :</span> Kızılay (Şube No: 082)<br>
							<span class="subject">Hesap Numarası :</span> 6298573<br>
							<span class="subject">IBAN :</span> TR51 0006 2000 0820 0006 2985 73<br>
						</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<form data-toggle="validator" method="POST" action="process_payment.php" id="payment-form">
						<div class="row">
							<div class="form-group col-sm-6">
								<label for="name">Adınız <small style="color:red;"><em>*</em></small></label>
								<input type="text" class="form-control" id="name" name="name" placeholder="Adınız" data-validate="true" data-error="Adınızı giriniz" required>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group col-sm-6">
								<label for="surname">Soyadınız <small style="color:red;"><em>*</em></small></label>
								<input type="text" class="form-control" id="surname" name="surname" placeholder="Soyadınız" data-validate="true" data-error="Soyadınızı giriniz" required>
								<div class="help-block with-errors"></div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-6">
								<label for="telephone">Telefon Numaranız</label>
								<input type="text" class="form-control" id="telephone" name="phone" placeholder="05---------">
							</div>
							<div class="form-group col-sm-6">
								<label for="Email">E-Posta Adresiniz <small style="color:red;"><em>*</em></small></label>
								<input type="email" class="form-control" id="Email" name="email" placeholder="E-Posta Adresiniz" data-validate="true" data-error="Lütfen geçerli bir E-Posta adresi giriniz." required>
								<div class="help-block with-errors"></div>
							</div>
						</div>
						<div class="form-group">
							<label for="address">Adresiniz</label>
							<textarea type="text" class="form-control" id="address" name="address" placeholder="Adresiniz"></textarea>
						</div>
						<hr>
						<div class="row">
							<div class="form-group col-sm-3">
								<label for="description">Ödeme Türü <small style="color:red;"><em>*</em></small></label>
								<div class="radio">
									<label>
										<input type="radio" name="payment_type" value="aidat" checked required>
										Üyelik Ödentisi (Aidat)
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="payment_type" value="bagis" required>
										Bağış
									</label>
								</div>
							</div>
							<div class="form-group col-sm-9">
								<label for="description">Açıklama</label>
								<textarea type="text" class="form-control" id="decription" name="description" placeholder="Açıklama Giriniz"></textarea>
							</div>
						</div>
						<div id="memberWarning" class="alert alert-info" role="alert">
							Üyelik ödentisi için açıklama kısmına ÜYE NUMARANIZI / İSMİNİZİ girmeyi unutmayınız.
						</div>
						<div class="form-group">
							<label for="Tutar">Tutarı Giriniz <small style="color:red;"><em>*</em></small></label>
							<input type="text" class="form-control" id="telephone" name="amount" placeholder="20,13" data-validate="true" data-error="Lütfen yatırmak istediğiniz miktarı giriniz" required>
							<div class="help-block with-errors"></div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-8">
										<h3 class="panel-title">Kart Bilgileri</h3>
									</div>
									<div class="col-xs-4">
										<img class="img-responsive pull-right" style="max-height: 20px;" src="images/visa-master.png">
									</div>
								</div>
							</div>
							<div class="panel-body">
								<div class="form-group">
									<label for="cardNumber">Kredi Kartı Numaranız <small style="color:red;"><em>*</em></small></label>
									<input type="tel" class="form-control" id="cardNumber" name="cardNo" placeholder="1234 1234 1234 1234" data-validate="true" data-error="Lütfen kredi kartı numaranızı giriniz" required>
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-inline">
									<div class="row">
										<div class="form-group col-sm-6 col-xs-12">
											<label for="cardExpiry">Son Kullanım Tarihi <small style="color:red;"><em>*</em></small></label>
											<input name="cardExpiryDate" type="tel" class="form-control" id="cardExpiry" placeholder="AA / YYYY" data-validate="true" data-error="Kredi kartınızın son kullanım tarihin AY / YIL şeklinde giriniz" required>
											<div class="help-block with-errors"></div>
										</div>
										<div class="form-group col-sm-6 col-xs-12">
											<label for="cardCVC">CVC <small style="color:red;"><em>*</em></small></label>
											<input name="cardCVC" type="tel" class="form-control" id="cardCVC" placeholder="123" data-validate="true" data-error="Kredi kartınızın arkasındaki güvenlik kodunun son 3 hanesini giriniz" required>
											<div class="help-block with-errors"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6 col-xs-12 text-center">
									<img class="" id="captchaImage">&nbsp;
									<a href="#" id="changeCaptcha" class="btn btn-default"><i class="fa fa-refresh" aria-hidden="true"></i> değiştir</a>
								</div>
								<div class="col-sm-6 col-xs-12">
									<label for="txtCaptcha">Bulmaca Yanıtı <small style="color:red;"><em>*</em></small></label>
									<input type="text" class="form-control" id="txtCaptcha" name="captcha" data-validate="true" data-error="Lütfen bulmaca çözümünü girin" required>
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<button type="submit" id="submitButton" class="btn btn-primary btn-block btn-lg">ÖDEME YAP</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<!-- messageModal --><div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog modal-sm"><div class="modal-content panel-success"><div class="modal-header panel-heading"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">İşlem sonucu</h4></div><div class="modal-body">...</div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button></div></div></div></div>

	<script src="assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.payment.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/validator.min.js"></script>
	<script type="text/javascript" src="assets/js/payment.js"></script>
</body>
</html>