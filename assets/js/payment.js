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
	$('input[id=cardExpiry]').payment('formatCardExpiry');

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
			e.preventDefault();

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