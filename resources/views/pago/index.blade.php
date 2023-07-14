<!DOCTYPE html>

<html lang="en">
   

    <head>
        <meta charset="utf-8" />
        <title>Lector medidor</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('css/card/card.css') }}">
        <script type="text/javascript" src="https://h.online-metrix.net/fp/tags.js?org_id={{$df_org_id}}&session_id={{$merchant_id}}{{$session_id}}"></script>
        <!-- END THEME LAYOUT STYLES -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
         </head>
         
        @stack('links')
        <style>
           
        </style>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper justify-items-stretch">
                <div class="grid m-6 justify-self-center p-6 max bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex  space-x-2 justify-self-center">
                        <form method="post" action="{{url('api/pago/confirmar')}}" id="formulario" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="profile_id" value="{{$profile_id}}">
                            <input type="hidden" name="access_key" value="{{$access_key_secure_acceptance}}">
                            <input type="hidden" name="transaction_uuid" value="{{$transaction_uuid}}">
                            <input type="hidden" name="signed_date_time" value="{{$signed_data_time}}">

                            <input type="hidden" name="signed_field_names" value="profile_id,access_key,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,auth_trans_ref_no,amount,currency,merchant_descriptor,override_custom_cancel_page,override_custom_receipt_page,payment_method">
                            
                            <input type="hidden" name="unsigned_field_names" value="device_fingerprint_id,signature,bill_to_forename,bill_to_surname,bill_to_email,bill_to_phone,bill_to_address_line1,bill_to_address_line2,bill_to_address_city,bill_to_address_state,card_type,card_number,card_expiry_date,card_cvn,bill_to_address_country,bill_to_address_postal_code,customer_ip_address,line_item_count,item_0_code,item_0_sku,item_0_name,item_0_quantity,item_0_unit_price,merchant_defined_data1,merchant_defined_data2,merchant_defined_data4,merchant_defined_data6,merchant_defined_data9,merchant_defined_data11,merchant_defined_data87,merchant_defined_data90,merchant_defined_data7,merchant_defined_data12,merchant_defined_data15,merchant_defined_data19,merchant_defined_data23,merchant_defined_data24">


                            <input type="hidden" name="override_custom_cancel_page" value="{{url('api/pago/callback'.'/'.$token)}}">
                            <input type="hidden" name="override_custom_receipt_page" value="{{url('api/pago/callback'.'/'.$token)}}">

                            <input type="hidden" name="customer_ip_address" value="{{$customer_ip_address}}">
                            <input type="hidden" name="device_fingerprint_id" value="{{$session_id}}">


                            <input type="hidden" name="line_item_count" value="1"/>

                            <input type="hidden" name="item_0_sku" value="sku1"/>
                            <input type="hidden" name="item_0_code" value="code1">
                            <input type="hidden" name="item_0_name" value="name1">
                            <input type="hidden" name="item_0_quantity" value="1">
                            <input type="hidden" name="item_0_unit_price" value="{{ $price }}">
                            <input type="hidden" name="plan" value="{{ $plan }}">
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                       

                            <input type="hidden" name="merchant_defined_data1" value="SI">
                            <input type="hidden" name="merchant_defined_data2" value="01-01-22">
                            <input type="hidden" name="merchant_defined_data4" value="01-01-22">

                            <input type="hidden" name="merchant_defined_data6" value="SI">
                            <input type="hidden" name="merchant_defined_data9" value="Pagina Web">
                            <input type="hidden" name="merchant_defined_data11" value="7736734SC">
                            <input type="hidden" name="merchant_defined_data87" value="1111222233334444">
                            <input type="hidden" name="merchant_defined_data90" value="Servicio">


                            <input type="hidden" name="merchant_defined_data7" value="LectorMedidor">
                            <input type="hidden" name="merchant_defined_data12" value="68836930">
                            <input type="hidden" name="merchant_defined_data15" value="1000">
                            <input type="hidden" name="merchant_defined_data19" value="{{$orden_id}}">
                            <input type="hidden" name="merchant_defined_data23" value="{{ $plan == null ? 0 : $plan->id }}">
                            <input type="hidden" name="merchant_defined_data24" value="{{ $user_id }}">
                            <input type="hidden" name="merchant_defined_data25" value="{{ $plan->id }}">
                            <input type="hidden" name="merchant_defined_data26" value="{{ $user_id }}">

                            <input type="hidden" name="transaction_type" value="sale">
                            <input type="hidden" name="reference_number" value="{{$identificador}}">
                            <input type="hidden" name="auth_trans_ref_no" value="{{$identificador}}">
                            <input type="hidden" name="amount" value="300">
                            <input type="hidden" name="currency" value="USD">
                            <input type="hidden" name="locale" value="es">
                            <input type="hidden" name="merchant_descriptor" value="LectorMedidor">
                            
                            <input type="hidden" name="bill_to_address_line1" maxlength="60"  value="5to anillo">
                            <input type="hidden" name="bill_to_address_line2" maxlength="60" value="Santos dumont">
                            <input type="hidden" name="bill_to_address_city" value="Santa Cruz de la sierra">
                            <input type="hidden" name="payment_method" value="card">
                            <input type="hidden" name="card_type" value="">
                            
                            <input type="hidden" name="bill_to_address_country" value="BO">
                            <input type="hidden" name="bill_to_address_postal_code" value="94043">


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="card-wrapper"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Número de tarjeta <strong class="required" aria-required="true">*</strong></label>
                                    <br>
                                    <input type="tel" id="card_number" name="card_number" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="Número de tarjeta" value="" required="">
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Nombres <strong class="required" aria-required="true">*</strong></label>
                                    <input type="text" id="bill_to_forename" name="bill_to_forename" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="Nombres" value="" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Apellidos <strong class="required" aria-required="true">*</strong></label>
                                    <input type="text" id="bill_to_surname" name="bill_to_surname" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="Apellidos" value="" required="">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Correo electrónico <strong class="required" aria-required="true">*</strong></label>
                                    <input type="email" id="bill_to_email" name="bill_to_email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="Correo electrónico" value="" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Número de celular <strong class="required" aria-required="true">*</strong></label>
                                    <input type="number" id="bill_to_phone" name="bill_to_phone" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="Número de celular" value="" required=""> 
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="single-append-text" class="control-label">Seleccione la ciudad <strong class="required" aria-required="true">*</strong></label>
                                    <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="bill_to_address_state" name="bill_to_address_state" required>
                                        <option value="">Seleccione una ciudad</option>
                                        <option value="BOS">Santa Cruz</option>
                                        <option value="BOH">Chuquisaca</option>
                                        <option value="BOC">Cochabamba</option>
                                        <option value="BOB">Beni</option>
                                        <option value="BOL">La Paz</option>
                                        <option value="BOO">Oruro</option>
                                        <option value="BON">Pando</option>
                                        <option value="BOP">Potosi</option>
                                        <option value="BOT">Tarija</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Expiración <strong class="required" aria-required="true">*</strong></label>
                                    <input type="tel" id="card_expiry_date" name="card_expiry_date" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="MM/YYYY" value="" required=""> 
                                </div>
                                <div class="form-group col-md-6">
                                    <label>CVN <strong class="required" aria-required="true">*</strong></label>
                                    <input type="number" id="card_cvn" name="card_cvn" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="CVN" value="" required=""> 
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Precio <strong class="required" aria-required="true">*</strong></label>
                                    <input type="number" id="bill_to_email" name="bill_to_email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="Correo electrónico"  disabled value="{{ $price }}" required="">
                                </div>
                               
                            </div>
                            <br>
                            <br>

                         
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Comprar</button>


                        </form>
                    </div>
                </div>
                <!-- BEGIN CONTENT BODY -->
                <div class="container">
                    <h4 style="margin-bottom: 1em;"> Los campos con <strong style="color: red;">*</strong> son obligatorios</h4>
                    <div class="row portlet-body">

                            @if(Session::has('message'))
                            <h3> <strong style="color: red;">{{ Session::get('message') }}</strong> </h3>
                            @endif

                        
                    </div>
                </div>
            </div>
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> 2022 © UAGRM
       <!--          <a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Purchase Metronic!</a> -->
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
        <script src="{{ asset('js/card/card.js') }}"></script>
         <noscript>
         <iframe style="width: 100px; height: 100px; border: 0; position:absolute; top: -5000px;" src="https://h.online-metrix.net/fp/tags?org_id={{$df_org_id}}&session_id={{$merchant_id}}{{$session_id}}"></iframe>
         </noscript>
        <script>
        $(document).ready(function () {
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
              }
            });
            new Card({
                form: 'form#formulario',
                container: '.card-wrapper',
                formSelectors: {
                    nameInput: 'input[name="bill_to_forename"], input[name="bill_to_surname"]',
                    numberInput: 'input[name="card_number"]',
                    expiryInput:  'input[name="card_expiry_date"]',
                    cvcInput:  'input[name="card_cvn"]'
                }
            });

            /*$('#bill_to_address_state').select2({
                    placeholder: "Seleccione la ciudad",
                    allowClear: true,
                    width: 'auto'
            });*/

        });

        </script>
        @stack('scripts')
        
        <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
    </body>

</html>