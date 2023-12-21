<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayU</title>
    <script type="text/javascript"
        src="https://maf.pagosonline.net/ws/fp/tags.js?id=d66f949f19b33e88c202b579cfc549b380200"></script>
    
    <script src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- <link rel="stylesheet" href="./css/normalize.css"> -->
    <!-- <link rel="stylesheet" href="./lib/bootstrap/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- Payment Methods Column -->
                <div class="row">
                    <div id="loading" style="display: none;">
                        <div class="loading-overlay"></div>
                        <div class="loading-content">
                            <img src="./img/loading.gif" alt="Cargando...">
                        </div>
                    </div>                     
                    <div class="col-12">
                        <div class="data-title">
                            <h3>Tus Datos</h3>
                        </div>
                        <div class="data">
                            <h4><?php echo $buyerEmail; ?></h4>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="data-title">
                            <h3>Selecciona tu metodo de pago</h3>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="accordion">
                                    <!-- accordion 1 Ded-Cre cards-->
                                    <div class="card" data-toggle="collapse" data-target="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                Tarjeta de crédito o débito
                                                <img src=".\img\tarvisa.png" alt="Visa" class="img-fluid img-card">
                                                <img src=".\img\tarmaster.png" alt="Mastercard"
                                                    class=".\img-fluid img-card">
                                                <img src=".\img\taramex.png" alt="American Express"
                                                    class=".\img-fluid img-card">
                                                <img src=".\img\tardiners.png" alt="Dinners" class="img-fluid img-card">
                                                <img src=".\img\tarcodensa.png" alt="Codensa" class="img-fluid img-card">
                                            </h5>
                                        </div>

                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                            data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-8 mx-auto">

                                                        <form id="creditcard-form">
                                                        <input type="hidden" id="creditcard_payment_method" name="creditcard_payment_method" value="VISA">
                                                            <div class="form-group">
                                                                <label for="creditcard_payer_name">Nombre en la Tarjeta *:</label>
                                                                <input type="text" id="creditcard_payer_name"
                                                                    name="creditcard_payer_name" class="form-control" placeholder="Nombre Completo" required>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-4">                                                                    
                                                                    <label for="creditcard_type_document"
                                                                        class="inline-label">Documento *</label>
                                                                    <select id="creditcard_type_document" name="creditcard_type_document"
                                                                        class="form-control" required>
                                                                        <option value="CC">C.C.</option>
                                                                        <option value="CE">C.E. (Cédula de Extranjería)</option>
                                                                        <option value="NIT">NIT (Número de Identificación Tributaria)</option>
                                                                        <option value="PP">Pasaporte</option>
                                                                        <option value="OTHER">Otro</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-8">
                                                                    <label for="creditcard_document_number">Número de
                                                                        Documento *:</label>
                                                                    <input type="text" id="creditcard_document_number"
                                                                        name="creditcard_document_number" class="form-control"
                                                                        required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="credit_card_number">Número de Tarjeta *:</label>
                                                                <input type="text" id="credit_card_number"
                                                                    name="credit_card_number" class="form-control"
                                                                    placeholder="1234 5678 9012" required>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-4">
                                                                    <label for="cvv"
                                                                        class="inline-label">Código CVV/CVC *</label>
                                                                    <input type="text" id="cvv"
                                                                        name="cvv" class="form-control"
                                                                        placeholder="000" required>
                                                                </div>
                                                                <div class="form-group col-md-8">
                                                                    <label for="fechaVencimiento">Fecha de
                                                                        Vencimiento *:</label>
                                                                    <div class="form-row">
                                                                        <div class="col">
                                                                            <select id="month_exp"
                                                                                name="month_exp"
                                                                                class="form-control" required>
                                                                                <option value="" disabled selected>Mes
                                                                                </option>
                                                                                <option value="01">01</option>
                                                                                <option value="02">02</option>
                                                                                <option value="02">03</option>
                                                                                <option value="02">04</option>
                                                                                <option value="02">05</option>
                                                                                <option value="02">06</option>
                                                                                <option value="02">07</option>
                                                                                <option value="02">08</option>
                                                                                <option value="02">09</option>
                                                                                <option value="02">10</option>
                                                                                <option value="02">11</option>
                                                                                <option value="02">12</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col">
                                                                            <select id="year_exp"
                                                                                name="year_exp"
                                                                                class="form-control" required>
                                                                                <?php foreach ($years as $year): ?>
                                                                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="fees">Cuotas *:</label>
                                                                <select id="fees" name="fees" class="form-control col-md-3">
                                                                <?php foreach ($fees as $fee): ?>
                                                                    <option value="<?php echo $fee; ?>"><?php echo $fee; ?></option>
                                                                <?php endforeach; ?>                                                                    
                                                                </select>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-9">
                                                                    <label for="creditcard_cell_phone">Teléfono Celular *:</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <img src=".\img\col.png"
                                                                                    alt="Flag" class="flag-icon">
                                                                                +57
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" id="creditcard_cell_phone" name="creditcard_cell_phone"
                                                                            class="form-control" required placeholder="Ej: 3112222222">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="creditcard_politicaDatos" required>
                                                                <label class="form-check-label"
                                                                    for="creditcard_politicaDatos">Acepto  los <a href="https://www.espacolaser.com.co/autorizacion-para-el-tratamiento-de-datos-personales/" class="woocommerce-terms-and-conditions-link woocommerce-terms-and-conditions-link--open" target="_blank">términos y condiciones</a> y autorizo el tratamiento
                                                                    de datos personales</label>
                                                            </div>

                                                            <button type="button" onclick="Payment.creditcard()" class="btn btn-primary">
                                                                Pagar <i class="fas fa-arrow-right"></i>
                                                            </button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- accordion 2 PSE-->
                                    <div class="card" data-toggle="collapse" data-target="#collapseTwo"
                                        aria-expanded="false" aria-controls="collapseTwo">
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                Débito Bancario PSE
                                                <img src=".\img\pse.png" alt="Visa" class="img-fluid img-card">

                                            </h5>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                            data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="row ">
                                                    <div class="col-md-8 mx-auto">
                                                        <p><strong>1.</strong> Todas las compras y pagos por PSE son
                                                            realizados en línea y la confirmación es inmediata</p>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-8 mx-auto">
                                                        <p><strong>2.</strong> Algunos bancos tienen un procedimiento de
                                                            autenticación en su página (por ejemplo, una segunda clave),
                                                            si nunca has realizado pagos por internet con tu cuenta de
                                                            ahorros o corriente, es posible que necesites tramitar una
                                                            autorización ante tu banco. Si tienes dudas, puedes
                                                            consultar los requisitos de cada banco.</p>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-8 mx-auto">
                                                        <p><strong>3.</strong> En tu extracto la compra puede aparecer
                                                            con la identificación PayU PAGOS ONLINE o TECNIPAGOS</p>
                                                    </div>
                                                </div>                                                

                                                <form id="pse-form">                                                    
                                                    <div class="form-group col-md-8 mx-auto">
                                                        <label for="pse_bank" class="inline-label">Banco *</label>
                                                        <select id="pse_bank" name="pse_bank" class="form-control" required>
                                                        <?php foreach ($banksInfo as $bank): ?>
                                                            <option value="<?php echo $bank['pseCode']; ?>"><?php echo $bank['description']; ?></option>
                                                        <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-8 mx-auto">
                                                        <label for="pse_payer_name">Nombre del titular *:</label>
                                                        <input type="text" id="pse_payer_name" name="pse_payer_name"
                                                            class="form-control" placeholder="Nombres y Apellidos" required>
                                                    </div>

                                                    <div class="form-group col-md-8 mx-auto">
                                                        <label for="pse_type_person" class="inline-label">Tipo de
                                                            Persona *</label>
                                                        <select id="pse_type_person" name="pse_type_person" class="form-control"
                                                            required>
                                                            <option value="" disabled selected>Selecciona</option>
                                                            <option value="N">Natural</option>
                                                            <option value="J">Jurídica</option> 
                                                        </select>
                                                    </div>
                                                    <div class="form-row col-md-8 mx-auto">
                                                        <div class="form-group col-md-4 ">
                                                            <label for="pse_type_document"
                                                                class="inline-label">Documento *</label>
                                                            <select id="pse_type_document" name="pse_type_document"
                                                                class="form-control" required>
                                                                <option value="CC">C.C. (Cédula de ciudadanía.)</option>
                                                                <option value="CE">C.E. (Cédula de Extranjería)</option>
                                                                <option value="NIT">NIT (Número de Identificación Tributaria (Empresas))</option>
                                                                <option value="TI">T.I. (Tarjeta de identidad)</option>
                                                                <option value="PP">PP (Pasaporte)</option>
                                                                <option value="IDC">IDC (Identificador único de cliente)</option>
                                                                <option value="CEL">CEL (Número movil)</option>
                                                                <option value="RC">RC (Registro civil de nacimiento)</option>
                                                                <option value="DE">D.E. (Documento de identificación extranjero)</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-8 ">
                                                            <label for="pse_document_number">Número de Documento *:</label>
                                                            <input type="text" id="pse_document_number"
                                                                name="pse_document_number" class="form-control" placeholder="Numero Identificacion" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-row col-md-8 mx-auto">
                                                        <div class="form-group col-md-8">
                                                            <label for="pse_cell_phone">Teléfono Celular *:</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <img src=".\img\col.png"
                                                                            alt="Flag" class="flag-icon">
                                                                        +57
                                                                    </span>
                                                                </div>
                                                                <input type="text" id="pse_cell_phone" name="pse_cell_phone"
                                                                    class="form-control " required placeholder="Ej: 3112222222">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-check col-md-8 mx-auto">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pse_politicaDatos" required>
                                                            <label class="form-check-label"
                                                                    for="pse_politicaDatos">Acepto  los <a href="https://www.espacolaser.com.co/autorizacion-para-el-tratamiento-de-datos-personales/" class="woocommerce-terms-and-conditions-link woocommerce-terms-and-conditions-link--open" target="_blank">términos y condiciones</a> y autorizo el tratamiento
                                                                    de datos personales</label>
                                                    </div>
                                                    <div class="col-md-8 mx-auto">
                                                        <button type="button" onclick="Payment.pse()" class="btn btn-primary">
                                                            Pagar <i class="fas fa-arrow-right"></i>
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- accordion Efectivo -->
                                    <div class="card" data-toggle="collapse" data-target="#collapseThree"
                                        aria-expanded="false" aria-controls="collapseThree">
                                        <div class="card-header" id="headingThree">
                                            <h5 class="mb-0">
                                                Pago en Efectivo
                                                <img src=".\img\pagatodo.png" alt="pagatodo" class="img-fluid img-card" data-value="OTHERS_CASH">
                                                <img src=".\img\apuestascucuta.png" alt="Cucuta"
                                                    class=".\img-fluid img-card" data-value="OTHERS_CASH">
                                                <img src=".\img\gana.png" alt="gana" class="img-fluid img-card" data-value="OTHERS_CASH">
                                                <img src=".\img\ganagana.png" alt="gana gana" class="img-fluid img-card" data-value="OTHERS_CASH">
                                                <img src=".\img\suchance.png" alt="suchance" class="img-fluid img-card" data-value="OTHERS_CASH">
                                                <img src=".\img\acertamos.png" alt="acertamos" class="img-fluid img-card" data-value="OTHERS_CASH">
                                                <img src=".\img\laperla.png" alt="laperla" class="img-fluid img-card" data-value="OTHERS_CASH">
                                                <img src=".\img\apuestasunidas.png" alt="apuestasunidas"
                                                    class=".\img-fluid img-card" data-value="OTHERS_CASH">
                                                <img src=".\img\jer.png" alt="jer" class="img-fluid img-card" data-value="OTHERS_CASH">
                                                <img src=".\img\efecty.png" alt="efecty" class="img-fluid img-card" data-value="EFECTY">
                                            </h5>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                            data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="banner-pay col-md-10 mx-auto">
                                                    <strong class="banner"> Realiza tu pago en Efectivo en cualquier
                                                        punto de pago </strong>
                                                    <img src=".\img\sured.png" alt="efecty"
                                                        class="img-fluid img-card-inner">
                                                </div>
                                                <div id="cash-instructions">
                                                    <div class="custom-bg col-md-10 mx-auto">
                                                        <p>
                                                            <span class="font-weight-bold">1.</span> Haz click en el botón
                                                            "Generar número de pago" para obtener
                                                            el número que te pedirá el cajero de Pagatodo, Apuestas Cucuta
                                                            75, Gana, Gana Gana, Su Chance, Acertemos, La Perla, Apuestas
                                                            Unidas o Jer.
                                                            <span class="float-right"><i
                                                                    class="fas fa-info-circle"></i></span>
                                                        </p>
                                                    </div>
                                                    <div class="custom-bg col-md-10 mx-auto">
                                                        <p>
                                                            <span class="font-weight-bold">2.</span> Realiza el Pago en
                                                            efectivo presentando el número que generaste, en cualquier punto
                                                            Pagatodo, Apuestas Cucuta 75, Gana, Gana Gana, Su Chance,
                                                            Acertemos, La Perla, Apuestas Unidas o Jer de Colombia.
                                                            <span class="float-right"><i
                                                                    class="fas fa-info-circle"></i></span>
                                                        </p>
                                                    </div>
                                                    <div class="custom-bg col-md-10 mx-auto">
                                                        <p>
                                                            <span class="font-weight-bold">3.</span> Una vez recibido tu
                                                            pago en Pagatodo, Apuestas Cucuta 75, Gana, Gana Gana, Su
                                                            Chance, Acertemos, La Perla, Apuestas Unidas o Jer, PayU enviará
                                                            la información del pago a CORPOREOS COLOMBIA S.A.S, que
                                                            procederá a hacer la entrega del producto/servicio que estás
                                                            adquiriendo.
                                                            <span class="float-right"><i
                                                                    class="fas fa-info-circle"></i></span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div id="efecty-instructions" style="display:none;">
                                                    <div class="custom-bg col-md-10 mx-auto">
                                                        <p>
                                                            <span class="font-weight-bold">1.</span> Haz click en el botón 
                                                            "Generar número de pago" para obtener 
                                                            el número que te pedirá el cajero de Efecty.                                                            
                                                            <span class="float-right"><i
                                                                    class="fas fa-info-circle"></i></span>
                                                        </p>
                                                    </div>
                                                    <div class="custom-bg col-md-10 mx-auto">
                                                        <p>
                                                            <span class="font-weight-bold">2.</span> Realiza el Pago en 
                                                            efectivo presentando el número que generaste, en cualquier punto 
                                                            Efecty de Colombia.                                                            
                                                            <span class="float-right"><i
                                                                    class="fas fa-info-circle"></i></span>
                                                        </p>
                                                    </div>
                                                    <div class="custom-bg col-md-10 mx-auto">
                                                        <p>
                                                            <span class="font-weight-bold">3.</span> Una vez recibido tu 
                                                            pago en Efecty, PayU enviará la información del pago 
                                                            a CORPÓREOS COLOMBIA S.A.S, que procederá a hacer la entrega 
                                                            del producto/servicio que estás adquiriendo.                                                            
                                                            <span class="float-right"><i
                                                                    class="fas fa-info-circle"></i></span>
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <form id="cash-form">                                                    
                                                    <input type="hidden" id="payment_method_cash" name="payment_method_cash" value="OTHERS_CASH">
                                                    <div class="form-group col-md-8 mx-auto">
                                                        <label for="cash_payer_name">Nombre del titular *:</label>
                                                        <input type="text" id="cash_payer_name" name="cash_payer_name"
                                                            class="form-control" placeholder="Nombres y Apellidos" required>
                                                    </div>
                                                    <div class="form-row col-md-8 mx-auto">
                                                        <div class="form-group col-md-4 ">
                                                            <label for="cash_type_document"
                                                                class="inline-label">Documento *</label>
                                                            <select id="cash_type_document" name="cash_type_document"
                                                                class="form-control" required>
                                                                <option value="CC">C.C.</option>
                                                                <option value="CE">C.E. (Cédula de Extranjería)</option>
                                                                <option value="NIT">NIT (Número de Identificación Tributaria)</option>
                                                                <option value="PP">Pasaporte</option>
                                                                <option value="OTHER">Otro</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-8 ">
                                                            <label for="cash_document_number">Número de Documento *:</label>
                                                            <input type="text" id="cash_document_number"
                                                                name="cash_document_number" class="form-control" placeholder="Numero Identificacion" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-check col-md-8 mx-auto">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="cash_politicaDatos" required>
                                                            <label class="form-check-label"
                                                                    for="cash_politicaDatos">Acepto  los <a href="https://www.espacolaser.com.co/autorizacion-para-el-tratamiento-de-datos-personales/" class="woocommerce-terms-and-conditions-link woocommerce-terms-and-conditions-link--open" target="_blank">términos y condiciones</a> y autorizo el tratamiento
                                                                    de datos personales</label>
                                                    </div>
                                                    <div class="col-md-8 mx-auto">                                                    
                                                        <button type="button" onclick="Payment.cash()" class="btn btn-primary">
                                                        Generar número de Pago <i class="fas fa-arrow-right"></i>
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- accordion Banks -->
                                    <div class="card" data-toggle="collapse" data-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">
                                        <div class="card-header" id="headingFour">
                                            <h5 class="mb-0">
                                                Pago en Bancos
                                                <img src=".\img\bogota.png" alt="bogota" class="img-fluid img-card-bank">
                                                <img src=".\img\bancolombia.png" alt="bancolombia"
                                                    class=".\img-fluid img-card-bank">
                                                <img src=".\img\davivienda.png" alt="davivienda"
                                                    class=".\img-fluid img-card-bank">

                                            </h5>
                                        </div>
                                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                            data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="custom-bg col-md-10 mx-auto">
                                                    <p>
                                                        <span class="font-weight-bold">1.</span> Haz click en el botón
                                                        "generar recibo de pago" e imprime el recibo que te muestra.
                                                        <span class="float-right"><i
                                                                class="fas fa-info-circle"></i></span>
                                                    </p>
                                                </div>
                                                <div class="custom-bg col-md-10 mx-auto">
                                                    <p>
                                                        <span class="font-weight-bold">2.</span> Puedes realizar el pago
                                                        en efectivo presentando el recibo en cualquier sucursal de Banco
                                                        de Bogotá, Bancolombia o Davivienda de Colombia.
                                                        <span class="float-right"><i
                                                                class="fas fa-info-circle"></i></span>
                                                    </p>
                                                </div>
                                                <div class="custom-bg col-md-10 mx-auto">
                                                    <p>
                                                        <span class="font-weight-bold">3.</span> Una vez recibido tu
                                                        pago en el banco, PayU enviará la información del pago a
                                                        CORPOREOS COLOMBIA S.A.S, que procederá a hacer la entrega del
                                                        producto/servicio que estás adquiriendo.
                                                        <span class="float-right"><i
                                                                class="fas fa-info-circle"></i></span>
                                                    </p>
                                                </div>

                                                <form id="banks-form">                                                    
                                                    <input type="hidden" id="payment_method_banks" name="payment_method_banks" value="BANK_REFERENCED">
                                                    <div class="form-group col-md-8 mx-auto">
                                                        <label for="bank_payer_name">Nombre del titular *:</label>
                                                        <input type="text" id="bank_payer_name" name="bank_payer_name"
                                                            class="form-control" placeholder="Nombres y Apellidos" required>
                                                    </div>
                                                    <div class="form-row col-md-8 mx-auto">
                                                        <div class="form-group col-md-4 ">
                                                            <label for="bank_type_document"
                                                                class="inline-label">Documento *</label>
                                                            <select id="bank_type_document" name="bank_type_document"
                                                                class="form-control" required>
                                                                <option value="CC">C.C.</option>
                                                                <option value="CE">C.E. (Cédula de Extranjería)</option>
                                                                <option value="NIT">NIT (Número de Identificación Tributaria)</option>
                                                                <option value="PP">Pasaporte</option>
                                                                <option value="OTHER">Otro</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-8 ">
                                                            <label for="bank_document_number">Número de Documento *:</label>
                                                            <input type="text" id="bank_document_number"
                                                                name="bank_document_number" class="form-control" placeholder="Numero Identificacion" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-check col-md-8 mx-auto">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="bank_politicaDatos" required>
                                                            <label class="form-check-label"
                                                                    for="bank_politicaDatos">Acepto  los <a href="https://www.espacolaser.com.co/autorizacion-para-el-tratamiento-de-datos-personales/" class="woocommerce-terms-and-conditions-link woocommerce-terms-and-conditions-link--open" target="_blank">términos y condiciones</a> y autorizo el tratamiento
                                                                    de datos personales</label>
                                                    </div>
                                                    <div class="col-md-8 mx-auto">
                                                        <button type="button" onclick="Payment.banks()" class="btn btn-primary">
                                                            Generar número de Pago <i class="fas fa-arrow-right"></i>
                                                        </button>                                                        
                                                    </div>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- SummaryColumn -->
                <div class="summary-column">
                    <div class="summary-title">
                        <h4>Resumen de tu compra</h4>
                    </div>
                    <p>
                        <span class="referencia">Referencia: <?php echo $referenceCode; ?></span>
                    </p>
                    <p>
                        <span class="descripcion">Descripción: <?php echo $description; ?></span>
                    </p>

                    <p>
                        <span class="valor">Total a Pagar: $ <?php echo $formattedAmount; ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>    
    <script src="./lib/jquery/dist/jquery.min.js"></script>
    <script src="./lib/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./js/main.js"></script>

    <script>
        // Detener la propagación del clic en los campos del formulario
        document.getElementById('creditcard-form').addEventListener('click', function (e) {
            e.stopPropagation();
        });

        document.getElementById('pse-form').addEventListener('click', function (e) {
            e.stopPropagation();
        });

        document.getElementById('cash-form').addEventListener('click', function (e) {
            e.stopPropagation();
        });
        
        document.getElementById('banks-form').addEventListener('click', function (e) {
            e.stopPropagation();
        });
       
        function validateCreditCard() {
            var cardNumber = document.getElementById('credit_card_number').value.replace(/\s/g, ''); // Elimina espacios en blanco
            var cvv = document.getElementById('cvv').value;
            var monthExp = document.getElementById('month_exp').value;
            var yearExp = document.getElementById('year_exp').value;

            if (!isValidCreditCardNumber(cardNumber)) {
                alert('Número de tarjeta no válido');
                return;
            }

            if (!isValidCVV(cvv)) {
                alert('CVV no válido');
                return;
            }

            if (!isValidExpirationDate(monthExp, yearExp)) {
                alert('Fecha de vencimiento no válida');
                return;
            }

            // Aquí puedes enviar el formulario o realizar otras acciones si la tarjeta es válida
            alert('Tarjeta válida. Puedes proceder.');
        }

        function isValidCreditCardNumber(cardNumber) {
            // Implementa el algoritmo de Luhn para validar el número de tarjeta
            // Devuelve true si es válido, false si no lo es
            // ...

            // Ejemplo simple de validación de Luhn:
            var sum = 0;
            var isSecondDigit = false;

            for (var i = cardNumber.length - 1; i >= 0; i--) {
                var digit = parseInt(cardNumber.charAt(i), 10);

                if (isSecondDigit) {
                    digit *= 2;
                    if (digit > 9) {
                        digit -= 9;
                    }
                }

                sum += digit;
                isSecondDigit = !isSecondDigit;
            }

            return sum % 10 === 0;
        }

        function isValidCVV(cvv) {
            // Implementa tus propias reglas de validación para el CVV
            // Devuelve true si es válido, false si no lo es
            // Por ejemplo, puedes requerir que el CVV tenga una longitud específica
            return /^[0-9]{3,4}$/.test(cvv);
        }

        function isValidExpirationDate(month, year) {
            // Implementa tus propias reglas de validación para la fecha de vencimiento
            // Devuelve true si es válida, false si no lo es
            // Por ejemplo, puedes verificar que la fecha sea futura
            // ...

            // Ejemplo simple: verifica que el mes sea un número y el año sea un número de 4 dígitos
            return !isNaN(parseInt(month, 10)) && !isNaN(parseInt(year, 10)) && year.length === 4;
        }

    </script>
</body>
</html>