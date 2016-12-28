<!DOCTYPE html>
<html>
<head>
	<title>LKD - Bağış / Aidat Ödeme Formu</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Vendor libraries -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<style type="text/css">
		body{
			padding: 30px 0;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div class="row">
				<div class="col-sm-12">
					<p class="top">Bağlantı Adresiniz, <strong><?php echo $_SERVER['REMOTE_ADDR']?></strong></p>
				</div>
			</div>
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
					<form data-toggle="validator" method="POST" action="process_payment.php">
						<div class="form-group">
							<label for="name">Adınız</label>
							<input type="text" class="form-control" id="name" name="nameText" placeholder="Adınız" data-validate="true" data-error="Adınızı giriniz" required>
							<div class="help-block with-errors"></div>
						</div>
						<div class="form-group">
							<label for="surname">Soyadınız</label>
							<input type="text" class="form-control" id="surname" name="surnameText" placeholder="Soyadınız" data-validate="true" data-error="Soyadınızı giriniz" required>
							<div class="help-block with-errors"></div>
						</div>
						<div class="form-group">
							<label for="address">Adresiniz</label>
							<textarea type="text" class="form-control" id="address" name="addressTextArea" placeholder="Adresiniz"></textarea>
						</div>
						<div class="form-group">
							<label for="telephone">Telefon Numaranız</label>
							<input type="text" class="form-control" id="telephone" name="telephoneText" placeholder="05---------">
						</div>
						<div class="form-group">
							<label for="description">Açıklama</label>
							<textarea type="text" class="form-control" id="decription" name="descriptionTextArea" placeholder="Açıklama Giriniz"></textarea>
						</div>
						<div class="form-group">
							<label for="description">Ödeme Türü</label>
							<div class="radio">
								<label>
									<input type="radio" name="optionsRadios" value="bagis" required>
									Bağış
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="optionsRadios" value="aidat" checked required>
									Üyelik Ödentisi (Aidat)
								</label>
							</div>
						</div>
						<div class="alert alert-info" role="alert">
							Üyelik ödentisi için açıklama kısmına ÜYE NUMARANIZI / İSMİNİZİ girmeyi unutmayınız.
						</div>
						<div class="form-group">
							<label for="Email">E-Posta Adresiniz</label>
							<input type="email" class="form-control" id="Email" name="emailText" placeholder="E-Posta Adresiniz" data-validate="true" data-error="Lütfen geçerli bir E-Posta adresi giriniz." required>
							<div class="help-block with-errors"></div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-8">
										<h3 class="panel-title">Ödeme Bilgileri</h3>
									</div>
									<div class="col-xs-4">
										<img class="img-responsive pull-right" style="max-height: 20px;" src="images/visa-master.png">
									</div>
								</div>
							</div>
							<div class="panel-body">
								<div class="form-group">
									<label for="cardNumber">Kredi Kartı Numaranız</label>
									<input type="tel" class="form-control" id="cardNumber" name="cardNoText" placeholder="1234 1234 1234 1234" data-validate="true" data-error="Lütfen kredi kartı numaranızı giriniz" required>
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-inline">
									<div class="row">
										<div class="form-group col-sm-6 col-xs-12">
											<label for="cardExpiry">Son Kullanım Tarihi</label>
											<input name="cardExpiryDate" type="tel" class="form-control" id="cardExpiry" placeholder="AA / YYYY" data-validate="true" data-error="Kredi kartınızın son kullanım tarihin AY / YIL şeklinde giriniz" required>
											<div class="help-block with-errors"></div>
										</div>
										<div class="form-group col-sm-6 col-xs-12">
											<label for="cardCVC">CVC</label>
											<input name="cardCVC" type="tel" class="form-control" id="cardCVC" placeholder="123" data-validate="true" data-error="Kredi kartınızın arkasındaki güvenlik kodunun son 3 hanesini giriniz" required>
											<div class="help-block with-errors"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="Tutar">Tutarı Giriniz</label>
							<input type="text" class="form-control" id="telephone" name="tutarText" placeholder="20,13" data-validate="true" data-error="Lütfen yatırmak istediğiniz miktarı giriniz" required>
							<div class="help-block with-errors"></div>
						</div>
						<hr>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6 col-xs-12 text-center">
									<img class="" id="captchaImage">&nbsp;
									<a href="#" id="changeCaptcha" class="btn btn-default"><i class="fa fa-refresh" aria-hidden="true"></i> değiştir</a>
								</div>
								<div class="col-sm-6 col-xs-12">
									<label for="txtCaptcha">Bulmaca Yanıtı</label>
									<input type="text" class="form-control" id="txtCaptcha" name="captchaText" data-validate="true" data-error="Lütfen bulmaca çözümünü girin" required>
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-primary btn-block btn-lg">GÖNDER</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.8/validator.min.js"></script>
	<script type="text/javascript">
		//	createCaptcha.php dosyası üzerinden bulmaca oluşturup ekranda gösterecek JS fonksiyonumuzu tanımlıyoruz
		var createCaptcha = function(){
			$("#changeCaptcha i").addClass("fa-spin");
			$("#changeCaptcha").addClass("disabled");
			$.get( "createCaptcha.php", function(data) {
				$("#captchaImage").attr("src", data);
			})
			.fail(function() {
				alert( "Bulmaca yenilenemedi" );
			})
			.always(function(){
				$("#changeCaptcha").removeClass("disabled");
				$("#changeCaptcha i").removeClass("fa-spin");
			});
		}

		//	sayfa yüklendiğinde çalışacak JS kodları
		$(document).ready(function(){
			//	jquery.payment eklentisi sayesinde kart bilgilerini uygun formatta maskeliyoruz
			$('input[id=cardNumber]').payment('formatCardNumber');
			$('input[id=cardCVC]').payment('formatCardCVC');
			$('input[id=cardExpiry').payment('formatCardExpiry');

			//	ilk yükleme için bulmaca oluşturulup gösterilmesini sağlıyoruz
			createCaptcha();

			//	bulmacanın yanındaki değiştirme bağlantısına tıklandığında yeni bir tane oluşturulup gösterilmesini sağlıyoruz
			$("#changeCaptcha").click(function(e){
				e.preventDefault();
				createCaptcha();
			});
		});
	</script>
</body>
</html>