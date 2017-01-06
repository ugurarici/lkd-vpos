<!DOCTYPE html>
<html>
<head>
	<title>LKD - Bağış / Aidat Ödeme Formu</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Vendor libraries -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
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

			$('input[type=radio][name=payment_type]').change(function() {
				if (this.value == 'bagis') {
					$("#submitButton").text("BAĞIŞ YAP");
					$("#memberWarning").hide('fast');
				}
				else if (this.value == 'aidat') {
					$("#submitButton").text("ÖDEME YAP");
					$("#memberWarning").show('fast');
				}
			});

			var activateModal = function(result, message){
				$("#messageModal .modal-content")
				.removeClass("panel-success")
				.removeClass("panel-warning")
				.removeClass("panel-danger");

				$("#messageModal .btn")
				.removeClass("btn-default")
				.removeClass("btn-danger");

				$("#messageModal .modal-body").html(message);
				$("#messageModal .btn").text("Kapat");

				if(result==="success"){
					$("#messageModal .modal-title").text("İşlem başarılı");
					$("#messageModal .modal-content").addClass("panel-success");
					$("#messageModal .btn").addClass("btn-default");
				}else if(result==="warning"){
					$("#messageModal .modal-title").text("Uyarı");
					$("#messageModal .modal-content").addClass("panel-warning");
					$("#messageModal .btn").addClass("btn-default");
				}else if(result==="error"){
					$("#messageModal .modal-title").text("HATA");
					$("#messageModal .modal-content").addClass("panel-danger");
					$("#messageModal .btn").addClass("btn-danger");
					$("#messageModal .btn").text("Tekrar Dene");
				}
				
				$('#messageModal').modal({
					backdrop: 'static',
					keyboard: false
				});
			}

			/* form gönderim işlemini buradan yapalım */
			$("#payment-form").validator().on('submit', function (e) {
				if (e.isDefaultPrevented()) {
					activateModal("error", "Lütfen tüm form alanlarını kontrol ederek tekrar deneyin");
				} else {
					/* formun normal işleyişini engelleyelim */
					event.preventDefault();

					/* butonu disable yapıp "işlem yapılıyor" yazalım */
					$("#payment-form button").prop("disabled", true);
					var oldButtonText = $("#payment-form button").last().text();
					$("#payment-form button").html('<i class="fa fa-refresh fa-spin" aria-hidden="true"></i> Lütfen bekleyin');

					/* formun gideceği sayfayı alalım (ileride değişir falan diye iki yerde yazmasın) */
					var $form = $( this ),
					url = $form.attr( 'action' );

					/* form içeriğini gönderelim */
					var posting = $.post( url, $('#payment-form').serialize() );

					/* talep başarıyla döndüğünde sonucu alıp içine bakalım */
					posting.done(function( data ) {
						var response = jQuery.parseJSON(data);
						console.log(data);
						console.log(response);
						activateModal(response.result, response.message);

						if(response.result === "success" || response.result === "warning"){
							$('#payment-form').trigger("reset");
						}
					});

					/* talep işlenemediğinde hata verelim */
					posting.fail(function() {
						activateModal("error", "İşlem gerçekleştirilemedi, lütfen daha sonra tekrar deneyin");
					});

					posting.always(function() {
						$("#txtCaptcha").val("");
						createCaptcha();
						$("#payment-form :input").prop("disabled", false);
						$("#payment-form button").last().text(oldButtonText);
					});
				}
			});
		});
	</script>
</body>
</html>