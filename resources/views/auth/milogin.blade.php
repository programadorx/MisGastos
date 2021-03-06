

    <form method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="row {{ $errors->has('email') ? ' has-error' : '' }}">
            
            <label for="email" class="col s12 m12 l12 control-label">E-Mail</label>

            <div class="col s12 m12 l12">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
	
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="row {{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col s12 m12 l12 control-label">Password</label>

            <div class="col s12 m12 l12">
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col s12 m12 l12">
                <div class="col s6 m6 l6">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                   <label for="remember">Recordarme </label >
                </div>
                <div class="col s6 m6 l6">
                    <!-- Modal Trigger -->
                    <a class="waves-effect waves-light modal-trigger grey-text" href="#olvide">Olvide la contraseña</a> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12 m12 l12 center">
                <button type="submit" class="btn waves-effect waves-light orange">Ingresar</button>      
              
            </div>
        </div>
    </form>


  <!-- Modal Structure -->
  <div id="olvide" class="modal">
    	<div class="modal-content">
		
		<h4>Restablecer Contraseña</h4>
   		
   		@if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">E-Mail</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary orange">
                        Enviar Link de restablecimiento de contraseña
                    </button>
                </div>
            </div>
        </form>

		</div> <!--Modal contenido -->

	    <div class="modal-footer">
	      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
	    </div>
	</div>



