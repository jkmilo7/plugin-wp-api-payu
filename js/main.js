var Payment = function(){
	
	// Formularios
	var $formCreditcard = $("#creditcard-form");
	var $formPSE = $("#pse-form");
	var $formCash = $("#cash-form");
	var $formBanks = $("#banks-form");

	// Obtener la dirección IP
	var userIP;
	$.getJSON("https://api.ipify.org?format=json", function(data){
		userIP = data.ip;
	});

	var makePaymentRequest = function (url, formData, openUrl) {
		// Mostrar el indicador de carga
        showLoading();

        $.ajax({
            url: url,
            type: 'POST',
            data: formData + '&ip=' + userIP,
            dataType: 'json',
            success: function (res) {                

                if (res.status === "ok") {
                    showSuccessNotification("Procesando correctamente: " + res.message);
                    
					if(openUrl)
					{
						// Abre una nueva pestaña con la URL proporcionada
						window.open(res.url, '_blank');
					}					
                } else {
                    showErrorNotification("Error: " + res.message);
                }
            },
            error: function (res, a) {
				
	            showErrorNotification("Error: " + res.message);

            },
            complete: function () {
                // Ocultar el indicador de carga cuando la petición esté completa (ya sea éxito o error)
                hideLoading();
            }
        });
    };
	return {
        creditcard: function () {

			var formElements = $formCreditcard[0].elements;		
			// Verificar la validez de los campos del formulario
			for (var i = 0; i < formElements.length; i++) {
				if (!formElements[i].checkValidity()) {
					// Mostrar el mensaje de error si el campo no es válido
					formElements[i].reportValidity();
					return; // Detener la ejecución si algún campo no es válido
				}
			}
            var formData = $formCreditcard.serialize();
            makePaymentRequest('pay_gateway.php/creditcard-payment', formData, false);
        },
        pse: function () {
			var formElements = $formPSE[0].elements;		
			// Verificar la validez de los campos del formulario
			for (var i = 0; i < formElements.length; i++) {
				if (!formElements[i].checkValidity()) {
					// Mostrar el mensaje de error si el campo no es válido
					formElements[i].reportValidity();
					return; // Detener la ejecución si algún campo no es válido
				}
			}

			var selectedBankValue = document.getElementById("pse_bank").value;

            // Validar que se haya seleccionado una opción diferente de 0
            if (selectedBankValue === "0") {
                showErrorNotification("Por favor, selecciona un banco válido.");
                return;
            }

            var formData = $formPSE.serialize();
            makePaymentRequest('pay_gateway.php/pse-payment', formData, true);
        },
        cash: function () {
			var formElements = $formCash[0].elements;		
			// Verificar la validez de los campos del formulario
			for (var i = 0; i < formElements.length; i++) {
				if (!formElements[i].checkValidity()) {
					// Mostrar el mensaje de error si el campo no es válido
					formElements[i].reportValidity();
					return; // Detener la ejecución si algún campo no es válido
				}
			}
            var formData = $formCash.serialize();
            makePaymentRequest('pay_gateway.php/cash-payment', formData, true);
        },
        banks: function () {
			var formElements = $formBanks[0].elements;		
			// Verificar la validez de los campos del formulario
			for (var i = 0; i < formElements.length; i++) {
				if (!formElements[i].checkValidity()) {
					// Mostrar el mensaje de error si el campo no es válido
					formElements[i].reportValidity();
					return; // Detener la ejecución si algún campo no es válido
				}
			}
            var formData = $formBanks.serialize();
            makePaymentRequest('pay_gateway.php/banks-payment', formData, true);
        }
    };
}();

document.getElementById('payment_method_cash').addEventListener('change', function() {
	var paymentMethod = this.value;
	var cashInstructions = document.getElementById('cash-instructions');
	var efectyInstructions = document.getElementById('efecty-instructions');

	if (paymentMethod === 'EFECTY') {
		cashInstructions.style.display = 'none';
		efectyInstructions.style.display = 'block';
	} else {
		cashInstructions.style.display = 'block';
		efectyInstructions.style.display = 'none';
	}
});

document.addEventListener('DOMContentLoaded', function () {
    var images = document.querySelectorAll('.img-card');
    var cashInstructions = document.getElementById('cash-instructions');
    var efectyInstructions = document.getElementById('efecty-instructions');
    var paymentMethodHiddenInput = document.getElementById('payment_method_cash');

    images.forEach(function (image) {
        image.addEventListener('click', function () {
            var paymentMethod = image.getAttribute('data-value');

            // Establece el valor en el input hidden
            paymentMethodHiddenInput.value = paymentMethod;

            // Ajusta las instrucciones de acuerdo al método de pago seleccionado
            if (paymentMethod === 'EFECTY') {
                cashInstructions.style.display = 'none';
                efectyInstructions.style.display = 'block';
            } else {
                cashInstructions.style.display = 'block';
                efectyInstructions.style.display = 'none';
            }
        });
    });
});

// Mostrar el indicador de carga
function showLoading() {
    $('#loading').show();
}

// Ocultar el indicador de carga
function hideLoading() {
    $('#loading').hide();
}

// Función para mostrar notificación de éxito
function showSuccessNotification(message) {
    toastr.success(message);
}

// Función para mostrar notificación de error
function showErrorNotification(message) {
    toastr.error(message);
}

function convertResponse(res)
{
	var responseText = res.responseText;

	// Busca el índice de la primera llave '{' para determinar el comienzo del JSON
	var jsonStartIndex = responseText.indexOf('{');

	// Extrae la porción de la cadena que contiene solo el JSON válido
	var jsonSubstring = responseText.substring(jsonStartIndex);

	return JSON.parse(jsonSubstring);
}