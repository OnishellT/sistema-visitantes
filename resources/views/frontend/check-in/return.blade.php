@extends('frontend.layouts.frontend')

@section('content')
    <!-- Default Page -->
    <section id="pm-banner-1" class="custom-css-step">
        <div class="container">
            <div class="card" style="margin-top:40px;" >
                <div class="card-header" id="Details" align="center">
                    <h4 style="color: #111570;font-weight: bold">{{__('Detalles del Visitante')}}</h4>
                </div>
                <div class="card-body">
                    <div style="margin: auto;">
                        {!! Form::open(['route' => 'check-in.find.visitor', 'id' => 'myForm']) !!}
                        <div class="save">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                            {!!  Html::decode(Form::label('email', "Documento de Identificacion <span class='text-danger'>*</span>", ['class' => 'control-label'])) !!}
                                            {!! Form::text('national_identification_no', null, ('' == 'required') ? ['class' => 'form-control input','id '=>'national_identification_no','required' => 'required', 'placeholder'=>"Buscar Documento.."] : ['class' => 'form-control input','id '=>'first_name', 'placeholder'=>"Buscar Documento.."]) !!}
                                            {!! $errors->first('national_identification_no', '<p class="text-danger">:message</p>') !!}
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a href="{{ route('/') }}"
                                                   class="btn btn-danger float-left text-white">
                                                    <i class="fa fa-arrow-left" aria-hidden="true"></i> {{__('Cancelar')}}
                                                </a>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-success float-right" id="continue">
                                                    <i class="fa fa-arrow-right" aria-hidden="true"></i> {{__('Continuar')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script type="application/javascript">
        $(document).ready(function(){
            $("#form-submit").click(function(){
                $("#myForm").submit(); // Submit the form
            });
        });
    </script>
@endsection
